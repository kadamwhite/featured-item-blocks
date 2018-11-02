<?php
/**
 * Server-rendered three-column Featured Posts block.
 */
namespace FeaturedItemBlocks\Blocks\PostMeta;

function setup() {
	add_action( 'init', __NAMESPACE__ . '\\register_block' );
}

/**
 * Render the post meta list block.
 *
 * @return string The rendered block markup, as an HTML string.
 */
function render_post_meta( array $attributes ) {
	// Allow $attributes to override get_the_ID() if called via <ServerSideRender />
	$post_id = $attributes['id'] ?: get_the_ID();
	$post_meta = get_post_meta( $post_id );
	ob_start();
	echo '<pre>';
	// phpcs:disable WordPress.PHP.DevelopmentFunctions
	foreach ( $post_meta as $key => $value ) {
		echo "$key => ";
		print_r( $value );
		echo "\n";
	}
	echo '</pre>';
	$block_output = ob_get_contents();
	ob_end_clean();
	return $block_output;
}

/**
 * Register the post meta dynamic block.
 */
function register_block() {
	register_block_type( 'featured-item-blocks/post-meta', [
		'attributes' => [
			'id' => [
				'type' => 'number',
			],
		],
		'render_callback' => __NAMESPACE__ . '\\render_post_meta',
	] );
}
