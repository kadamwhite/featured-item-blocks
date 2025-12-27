<?php
/**
 * Register the meta key used by this plugin.
 */

namespace FeaturedItemBlocks\Meta;

const FEATURED_ITEM_META_KEY = '_featured';

/**
 * Connect namespace functions to hooks.
 */
function setup() {
	add_action( 'init', __NAMESPACE__ . '\\register_featured_meta' );
}

/**
 * Prevent meta updates if user cannot edit_post.
 *
 * @param bool   $allowed  Whether the update is allowed.
 * @param string $meta_key Key of meta being updated.
 * @param int    $post_id  ID of post to check permissions for.
 * @param int    $user_id  User ID to check permissions for.
 *
 * @return bool Whether to permit the update.
 */
function auth_callback( $allowed, $meta_key, $post_id, $user_id ) {
	return user_can( $user_id, 'edit_post', $post_id );
}

/**
 * Register featured meta.
 */
function register_featured_meta() {
	register_post_meta( 'post', FEATURED_ITEM_META_KEY, [
		'type'          => 'string', // TODO: Change to Boolean.
		'description'   => 'Whether or not the post should be included in Featured Items lists.',
		'auth_callback' => __NAMESPACE__ . '\\auth_callback',
		'single'        => true,
		'show_in_rest'  => true,
	] );
}
