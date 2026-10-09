<?php
/**
 * Plugin Name:       PKart Product Attributes Display
 * Plugin URI:        https://pluginskart.com
 * Description:       Displays WooCommerce product attributes inside product blocks.
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Requires Plugins:  woocommerce
 * Author:            PKart
 * Author URI:        https://pluginskart.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pkart-product-attributes-display
 *
 * WC requires at least: 8.0
 * WC tested up to:      10.7
 *
 * @package Pkart\ProductAttributesDisplay
 */

namespace Pkart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define(
	'PKART_PRODUCT_ATTRIBUTES_DISPLAY_FILE',
	__FILE__
);

define(
	'PKART_PRODUCT_ATTRIBUTES_DISPLAY_PATH',
	plugin_dir_path( __FILE__ )
);

require_once PKART_PRODUCT_ATTRIBUTES_DISPLAY_PATH
	. 'includes/class-product-attributes-display.php';

add_action(
	'init',
	array( Product_Attributes_Display::class, 'register_block' )
);

add_action(
	'before_woocommerce_init',
	array( Product_Attributes_Display::class, 'declare_wc_compatibility' )
);