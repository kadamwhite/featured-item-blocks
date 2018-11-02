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
 * Version:     0.1.0
 * Author:      K.Adam White <adam@kadamwhite.com>
 * Author URI:  http://kadamwhite.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */
require_once( __DIR__ . '/inc/asset-loader.php' );

require_once( __DIR__ . '/inc/meta.php' );
FeaturedItemBlocks\Meta\setup();

require_once( __DIR__ . '/inc/scripts.php' );
FeaturedItemBlocks\Scripts\setup();

require_once( __DIR__ . '/inc/blocks/featured-items-list.php' );
FeaturedItemBlocks\Blocks\FeaturedItemsList\setup();
