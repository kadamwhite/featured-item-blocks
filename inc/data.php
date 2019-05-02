<?php
/**
 * Expose methods to retrieve a list of recently-published featured items.
 */
// phpcs:disable WordPress.VIP.SlowDBQuery
// phpcs:disable WordPress.DB.SlowDBQuery
namespace FeaturedItemBlocks\Data;

use FeaturedItemBlocks\Meta;
use WP_Query;

/**
 * Get an array of recent categories containing featured posts.
 *
 * A post is considered featured if it has a meta_key of `_featured` with the
 * value "yes". The number of categories and number of featured posts per
 * category are configurable.
 *
 * As this function generates many queries, it should only be used via the
 * get_cached_featured_categories() function: this function saves the data to
 * a transient to reduce unnecessary database interaction.
 *
 * @param int $category_count     Number of recent featured categories to show.
 * @param int $posts_per_category Maximim number of posts to include per category.
 *
 * @return array[string]array Array with key "categories" holding a list of category
 * IDs containing recent featured posts, and key "posts_by_category" containing a
 * dictionary of the recent featured post IDs for each returned category.
 */
function get_featured_categories( int $category_count = 4, int $posts_per_category = 3 ) {
	// Ordered numeric array of IDs for categories with recent featured posts.
	$featured_category_ids = [];

	// $featured_posts_by_category is an associative array of ordered arrays of
	// post IDs by category, keyed by category ID: in the below example, posts
	// 120 & 134 from category 24 & post 145 from category 34 will be included.
	//     {
	//         '24': [ 120, 134 ],
	//         '34': [ 145 ]
	//     }
	$featured_posts_by_category = [];

	// Numeric array of IDs of posts to be featured (order does not matter)
	$featured_post_ids = [];

	while ( count( $featured_category_ids ) < $category_count ) {
		$featured_post_query = new WP_Query( [
			'post_type'        => 'post',
			'meta_key'         => Meta\FEATURED_ITEM_META_KEY,
			'meta_value'       => 'yes',
			// Most recent first.
			'orderby'        => 'date',
			'order'          => 'DESC',
			// Do not repeat posts or categories.
			'post__not_in'     => $featured_post_ids,
			'category__not_in' => $featured_category_ids,
			'posts_per_page'   => 1,
			// Return a list of IDs.
			'fields'           => 'ids',
		] );

		$post_id = $featured_post_query->posts[0];
		$categories = wp_get_post_categories( $post_id, [
			// Most-used categories first.
			'orderby' => 'count',
			'order'   => 'DESC',
			// Return a list of IDs.
			'fields'  => 'ids',
		] );
		$category_id = $categories[0];

		// Store the post ID for future __not_in usage
		array_push( $featured_post_ids, $post_id );

		// Store the category ID for future __not_in usage
		array_push( $featured_category_ids, $category_id );

		// Add to our featured categories dictionary: category__not_in ensures we
		// won't be stomping on any category record which already has data.
		$featured_posts_by_category[ $category_id ] = [ $post_id ];

		wp_reset_postdata();
	}

	foreach ( $featured_category_ids as $category_id ) {
		$additional_posts_query = new WP_Query( [
			'post_type'      => 'post',
			'meta_key'       => '_featured',
			'meta_value'     => 'yes',
			// Most recent first.
			'orderby'        => 'date',
			'order'          => 'DESC',
			// Get as many more in this category as are available, up to the
			// specified maximum number per category: one post has already been
			// retrieved for every category.
			'posts_per_page' => $posts_per_category - 1,
			'category__in'   => [ $category_id ],
			// Don't repeat posts.
			'post__not_in'   => $featured_post_ids,
			// Return a list of IDs.
			'fields'         => 'ids',
		] );

		foreach ( $additional_posts_query->posts as $post_id ) {
			// Store the post ID for future __not_in usage
			array_push( $featured_post_ids, $post_id );
			// Add the post ID to the dictionary of posts by category
			array_push( $featured_posts_by_category[ $category_id ], $post_id );
		}

		wp_reset_postdata();
	}

	// Expose the ordered categories lisit and dictionary of post IDs by category.
	return [
		'categories' => $featured_category_ids,
		'posts_by_category' => $featured_posts_by_category,
	];
}

/**
 * Get the transient key used to store data for a given category and post count pair.
 *
 * @param int $category_count     Number of recent featured categories to show.
 * @param int $posts_per_category Maximim number of posts to include per category.
 *
 * @return string A string transient key.
 */
function transient_key( int $category_count, int $posts_per_category ) {
	return "featured-item-blocks/featured-items-$category_count-$posts_per_category";
}

/**
* Get up to 2 posts for each of the four most recent categories, for display
* on the homepage. Retrieve the data from a transient if possible to reduce
* repeat DB interactions; this generates a lot of queries under the hood!
*
* @returns array[string]array Array with keys "posts" and "categories" holding
* arrays of objects keyed by the IDs for those posts and categories, and key
* "posts_by_category" containing a dictionary of posts to show for each category
*/
function get_cached_featured_categories( int $category_count = 4, int $posts_per_category = 3 ) {
	$transient_key = transient_key( $category_count, $posts_per_category );
	$existing_data = get_transient( $transient_key );

	// Return existing data immediately.
	if ( false !== $existing_data ) {
		return $existing_data;
	}

	// The meta-transient key 'featured-item-blocks/transient-keys' contains a list
	// of all dynamically-generated keys in use by the site. This allows multiple
	// blocks with different combinations of category and post-per-category counts
	// to all have their data properly stored, without losing the ability to wipe
	// those transient values when needed.
	$featured_cat_transient_keys = get_transient( 'featured-item-blocks/transient-keys' ) ?: [];

	// Query and store the requested featured content in a new transient key, and
	// save the new key to the transient-keys transient.
	array_push( $featured_cat_transient_keys, $transient_key );
	// Execute the queries.
	$featured_cats = get_featured_categories( $category_count, $posts_per_category );

	set_transient( $transient_key, $featured_cats );
	set_transient( 'featured-item-blocks/transient-keys', $featured_cat_transient_keys );

	return $featured_cats;
}

/**
 * Delete our featured category transients.
 *
 * Called whenever a post is published or updated.
 *
 * @param int $post_id The ID of the post being updated.
 */
function clear_featured_categories_transients( int $post_id ) {
	if ( 'post' !== get_post_type( $post_id ) ) {
		return;
	}
	// Clear out all known featured content transient keys.
	$featured_cat_transient_keys = get_transient( 'featured-item-blocks/transient-keys' ) ?: [];
	if ( count( $featured_cat_transient_keys ) ) {
		foreach ( $featured_cat_transient_keys as $transient_key ) {
			delete_transient( $transient_key );
		}
	}
	// Clear the list of transient keys itself.
	delete_transient( 'featured-item-blocks/transient-keys' );
}
