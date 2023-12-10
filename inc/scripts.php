<?php
/**
 * Register scripts in development and production.
 */
namespace FeaturedItemBlocks\Scripts;

use Asset_Loader;

function setup() {
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_editor_assets' );
}

/**
 * Enqueue editor assets based on the generated `asset-manifest.json` file.
 */
function enqueue_block_editor_assets() {
	$plugin_path  = trailingslashit( plugin_dir_path( dirname( __FILE__ ) ) );
	$dev_manifest = $plugin_path . 'build/production-asset-manifest.json';

	Asset_Loader\enqueue_asset( $dev_manifest, 'editor.js', [
		'handle' => 'featured-item-blocks-editor',
		'dependencies' => [
			'wp-blocks',
			'wp-components',
			'wp-compose',
			'wp-data',
			'wp-edit-post',
			'wp-element',
			'wp-i18n',
			'wp-plugins',
		],
	] );
}
