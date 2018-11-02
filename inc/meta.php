<?php
/**
 * Conf
 */
namespace FeaturedItemBlocks\Meta;

function setup() {
	add_action( 'init', __NAMESPACE__ . '\\register_featured_meta' );
}

function auth_callback( $allowed, $meta_key, $post_id, $user_id ) {
	return user_can( $user_id, 'edit_post', $post_id );
}

function register_featured_meta() {
	register_post_meta( 'post', '_featured', [
		'type'          => 'string', // TODO: Change to Boolean.
		'description'   => 'Whether or not the post should be included in Featured Items lists.',
		'auth_callback' => __NAMESPACE__ . '\\auth_callback',
		'single'        => true,
		'show_in_rest'  => true,
	] );
}

