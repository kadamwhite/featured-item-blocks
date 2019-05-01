<?php
/**
 * Server-rendered three-column Featured Posts block.
 */
// phpcs:disable WordPress.VIP.SlowDBQuery
// phpcs:disable WordPress.DB.SlowDBQuery
// phpcs:disable HM.Files.NamespaceDirectoryName.NameMismatch
namespace FeaturedItemBlocks\Blocks\FeaturedItemsList;

use FeaturedItemBlocks\Data;
use WP_Query;

const BLOCK_NAME = 'featured-item-blocks/featured-items-list';

function setup() {
	add_action( 'init', __NAMESPACE__ . '\\register_block' );
	add_action( 'save_post', __NAMESPACE__ . '\\clear_featured_categories_transients' );
	add_filter( 'render_block', __NAMESPACE__ . '\\disable_wpautop', 10, 2 );
}

/**
 * Template function to render a "posted on" date, used within render_category().
 */
function posted_on() {
	printf(
		// Translators: Indicates the date on which the linked post was published.
		__( '<span class="screen-reader-text">Posted on </span><time class="entry-date" datetime="%1$s">%2$s</time>', 'featured-item-list' ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( 'M j, Y' ) )
	);
}

/**
 * Register the Featured Items List dynamic block.
 */
function register_block() {
	register_block_type( BLOCK_NAME, [
		'attributes' => [
			'align' => [
				'type' => 'string',
				'default' => 'full',
			],
			'count' => [
				'type' => 'number',
				'default' => 4,
			],
			'editMode' => [
				'type' => 'boolean',
				'default' => false,
			],
			'postsPerCategory' => [
				'type' => 'number',
				'default' => 3,
			],
		],
		'render_callback' => __NAMESPACE__ . '\\render_featured_items_list',
	] );
}

/**
 * Render the Featured Items List block.
 *
 * @param array $attributes The block attributes.
 * @return string The rendered block markup, as an HTML string.
 */
function render_featured_items_list( array $attributes = [] ) {
	$category_count = (int) $attributes['count'] ?: 4;
	$posts_per_category = (int) $attributes['postsPerCategory'] ?: 3;
	// Special flag for signaling the use of <ServerSideRender> in the editor view.
	$edit_mode = (bool) $attributes['editMode'] ?: false;
	$align = (string) $attributes['align'];

	$featured_content = Data\get_cached_featured_categories( $category_count, $posts_per_category );
	$featured_categories = $featured_content['categories'];

	if ( ! count( $featured_categories ) ) {
		return '';
	}

	ob_start();

	echo sprintf(
		'<div class="wp-block-columns has-%s-columns %s">',
		count( $featured_categories ),
		empty( $align ) ? '' : "align$align"
	);

	foreach ( $featured_categories as $category_id ) {
		$featured_post_ids = $featured_content['posts_by_category'][ $category_id ];
		$category = get_category( $category_id );
		if ( $edit_mode ) {
			render_edit_mode_category( $category, $featured_post_ids );
		} else {
			render_category( $category, $featured_post_ids );
		}
	}

	echo '</div>';

	$block_output = ob_get_contents();
	ob_end_clean();

	return $block_output;
}

/**
 * Render the Gutenberg-side version of a  featured category listing.
 *
 * The editor does not need to see the full preview while editing, as the number
 * of columns can lead this block to display poorly within the narrow editor
 * content area. This function renders a slimmed-down version of the category
 * listing to provide editorial direction / confirmation that data exists,
 * without distracting or compromising the layout of the block preview.
 *
 * @param stdClass $category The category object being rendered.
 * @param array    $post_ids An array of post IDs to render for this category.
 */
function render_edit_mode_category( $category, $post_ids ) {
	$post_count = count( $post_ids );
	?>
	<div class="featured-items-list__category-list wp-block-column">
		<h2 class="featured-category-title"><?php echo $category->name; ?></h2>
		<span>
			<?php
			printf(
				// Translators: Indicate the number of posts which will display for this category on the frontend.
				esc_html( _n( '(%d post)', '(%d posts)', $post_count, 'featured-item-blocks' ) ),
				$post_count
			);
			?>
		</span>
	</div>
	<?php
}

/**
 * Render an individual featured category listing.
 *
 * Displays a category header followed by three post links. The first post's
 * featured image will be included.
 *
 * @param stdClass $category The category object being rendered.
 * @param array    $post_ids An array of post IDs to render for this category.
 */
function render_category( $category, $post_ids ) {
	$posts_query = new WP_Query( [
		'post__in' => $post_ids,
		'orderby'  => 'post__in',
	] );
	?>
	<div class="featured-items-list__category-list wp-block-column">
		<h2 class="featured-category-title"><?php echo $category->name; ?></h2>
		<?php
		while ( $posts_query->have_posts() ) :
			$posts_query->the_post();
			?>
			<div class="featured-items-list__item">
				<strong class="entry-title">
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php the_title(); ?>
					</a>
				</strong>
				<!-- Show featured image only for first post in each category. -->
				<?php if ( $posts_query->current_post === 0 ) : ?>
				<div class="featured-image">
					<?php the_post_thumbnail( [ 320, 212 ] ); ?>
				</div>
				<?php the_excerpt(); ?>
				<?php endif; ?>
				<small class="entry-meta">
					<?php posted_on(); ?>
				</small>
			</div>
		<?php endwhile; ?>
	</div>
	<?php
	wp_reset_postdata();
}

/**
 * Turn off wpautop filter when rendering this block.
 *
 * @link https://wordpress.stackexchange.com/q/321662/26317
 *
 * @param string $block_content The HTML generated for the block.
 * @param array  $block         The block.
 */
function disable_wpautop( string $block_content, array $block ) {
	if ( BLOCK_NAME === $block['blockName'] ) {
		remove_filter( 'the_content', 'wpautop' );
	}

	return $block_content;
}
