<?php
/**
 * Conf
 */
namespace FeaturedItemBlocks\Meta;

function setup() {
	add_action( 'init', __NAMESPACE__ . '\\register_featured_meta' );
}

function omit_non_yes_values( $check, int $object_id, string $meta_key, $meta_value ) {
	if ( $meta_key === '_featured' && $meta_value !== 'yes' ) {
		return null;
	}
	return $check;
}

function register_featured_meta() {
	register_post_meta( 'post', '_featured', [
    'type'         => 'string', // TODO: Change to Boolean.
		'description'  => 'Whether or not the post should be included in Featured Items lists.',
		'single'       => true,
		'show_in_rest' => true,
	] );

	add_filter( 'add_post_metadata', __NAMESPACE__ . '\\omit_non_yes_values' );
}

