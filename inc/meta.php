<?php
/**
 * Register the meta key used by this plugin.
 */
namespace FeaturedItemBlocks\Meta;

const FEATURED_ITEM_META_KEY = '_featured';

function setup() {
	add_action( 'init', __NAMESPACE__ . '\\register_featured_meta' );
}

function auth_callback( $allowed, $meta_key, $post_id, $user_id ) {
	return user_can( $user_id, 'edit_post', $post_id );
}

function register_featured_meta() {
	register_post_meta( 'post', FEATURED_ITEM_META_KEY, [
		'type'          => 'string', // TODO: Change to Boolean.
		'description'   => 'Whether or not the post should be included in Featured Items lists.',
		'auth_callback' => __NAMESPACE__ . '\\auth_callback',
		'single'        => true,
		'show_in_rest'  => true,
	] );
}

