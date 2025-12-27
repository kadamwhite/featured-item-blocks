<?php
/**
 * Server-rendered three-column Featured Posts block.
 */

$category_count = (int) $attributes['count'] ?: 4;
$posts_per_category = (int) $attributes['postsPerCategory'] ?: 3;
// Special flag for signaling the use of <ServerSideRender> in the editor view.
$edit_mode = (bool) $attributes['editMode'] ?: false;
$align = (string) $attributes['align'];

$featured_content = FeaturedItemBlocks\Data\get_cached_featured_categories( $category_count, $posts_per_category );
$featured_categories = $featured_content['categories'];

if ( ! count( $featured_categories ) ) {
	return '';
}

add_filter( 'wp_get_attachment_image_attributes', '\\FeaturedItemBlocks\\Blocks\\FeaturedItemsList\\filter_image_attributes', 10 );


printf(
	'<div class="wp-block-columns has-%s-columns %s">',
	count( $featured_categories ),
	empty( $align ) ? '' : "align$align"
);

foreach ( $featured_categories as $category_id ) {
	$featured_post_ids = $featured_content['posts_by_category'][ $category_id ];
	$category = get_category( $category_id );
	if ( $edit_mode ) {
		FeaturedItemBlocks\Blocks\FeaturedItemsList\render_edit_mode_category( $category, $featured_post_ids );
	} else {
		FeaturedItemBlocks\Blocks\FeaturedItemsList\render_category( $category, $featured_post_ids );
	}
}

echo '</div>';

remove_filter( 'wp_get_attachment_image_attributes', '\\FeaturedItemBlocks\\Blocks\\FeaturedItemsList\\filter_image_attributes' );
