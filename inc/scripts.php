<?php
/**
 * Register scripts in development and production.
 */

namespace FeaturedItemBlocks\Scripts;

/**
 * Conect namespace functions to hooks.
 */
function setup() {
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_editor_assets' );
}

/**
 * Enqueue editor assets based on the generated `asset-manifest.json` file.
 */
function enqueue_block_editor_assets() {
	$editor_asset_file = include dirname( __DIR__ ) . '/build/editor.asset.php';

	if ( empty( $editor_asset_file ) ) {
		trigger_error( 'Featured item blocks editor bundle not present. Has the build been run?', E_USER_NOTICE );
		return;
	}

	wp_enqueue_script(
		'featured-item-blocks-editor',
		plugin_dir_url( __DIR__ ) . '/build/editor.js',
		$editor_asset_file['dependencies'],
		$editor_asset_file['version'],
		[
			'strategy' => 'defer',
		]
	);
}
