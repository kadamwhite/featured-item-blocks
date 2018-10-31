<?php
/**
 * Register scripts in development and production.
 */
namespace FeaturedItemBlocks\Scripts;

require_once( __DIR__ . '/asset-loader.php' );

use FeaturedItemBlocks\Asset_Loader;

/**
 * Enqueue editor assets based on the generated `asset-manifest.json` file.
 */
function enqueue_block_editor_assets() {
	$plugin_path  = trailingslashit( plugin_dir_path( dirname( __FILE__ ) ) );
	$plugin_url   = trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) );
	$dev_manifest = $plugin_path . 'build/asset-manifest.json';

	$loaded_dev_assets = Asset_Loader\enqueue_assets( $dev_manifest, [
		'handle' => 'featured-item-blocks-editor',
	] );

	if ( ! $loaded_dev_assets ) {
		// Production mode. Manually enqueue script bundles.
		if ( file_exists( $plugin_path . 'build/editor.css' ) ) {
			wp_enqueue_script(
				'featured-item-blocks-editor',
				$plugin_url . 'build/editor.js',
				[],
				filemtime( $plugin_path . '/build/editor.js' ),
				true
			);
		}
		// TODO: Error if file is not found.

		if ( file_exists( $plugin_path . 'build/editor.css' ) ) {
			wp_enqueue_style(
				'featured-item-blocks-editor',
				$plugin_url . 'build/editor.css',
				null,
				filemtime( $plugin_path . 'build/editor.css' )
			);
		}
	}
}
