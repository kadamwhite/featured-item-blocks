<?php
/**
 * Block auto-loader.
 */
namespace FeaturedItemBlocks\Blocks;

/**
 * Extract the block name from a directory path
 *
 * @param string $directory_path Path to a block's php file.
 * @return string The name of the block, in Pascal case.
 */
function get_block_handle_from_path( $block_file_path ) {
	return str_replace(
		[ __DIR__ . '/blocks/', '.php' ],
		[ '', '' ],
		$block_file_path
	);
}

/**
 * Get the expected PHP namespace from the block name.
 *
 * @param string $block_name Block handle name, harpoon-case.
 * @return string Expected PHP namespace, in PascalCase.
 */
function get_namespace_from_block_handle( $block_handle ) {
	return sprintf(
		'FeaturedItemBlocks\\Blocks\\%s',
		str_replace( '-', '', ucwords( $block_handle ) )
	);
}

/**
 * Dynamically register blocks if a registration file exists.
 */
function autoregister_blocks() {
	// Each block registered must have an entrypoint in /blocks/{blockname}/namespace.php.
	foreach ( glob( __DIR__ . '/blocks/*.php' ) as $file ) {
		require_once( $file );
		$block_handle = get_block_handle_from_path( $file );
		$setup = get_namespace_from_block_handle( $block_handle ) . '\\setup';

		if ( function_exists( $setup ) ) {
			call_user_func( $setup );
		}
	}
}
