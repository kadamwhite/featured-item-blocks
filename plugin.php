<?php
/**
 * Featured Item Blocks
 *
 * @author    K.Adam White <adam@kadamwhite.com>
 * @license   GPL-2.0+
 * @copyright 2018 K.Adam White
 *
 * @wordpress-plugin
 * Plugin Name: Featured Item Blocks
 * Description: Blocks for displaying featured posts and a block editor control to selecting a post as featured.
 * Version:     0.4.0
 * Author:      K.Adam White <adam@kadamwhite.com>
 * Author URI:  http://kadamwhite.com
 * License:     GPL-2.0+ or Artistic License 2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Register meta.
require_once( __DIR__ . '/inc/meta.php' );
FeaturedItemBlocks\Meta\setup();

// Set up Data namespace methods.
require_once( __DIR__ . '/inc/data.php' );
FeaturedItemBlocks\Data\setup();

// Conditionally include bundled asset-loader, then enqueue editor UI scripts & styles.
if ( ! function_exists( 'Asset_Loader\\autoenqueue' ) ) {
	require_once( __DIR__ . '/vendor/humanmade/asset-loader/asset-loader.php' );
}
require_once( __DIR__ . '/inc/scripts.php' );
FeaturedItemBlocks\Scripts\setup();

// Auto-load PHP Editor Blocks.
require_once( __DIR__ . '/inc/blocks.php' );
FeaturedItemBlocks\Blocks\autoregister_blocks();
