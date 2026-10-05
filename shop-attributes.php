<?php
/**
 * Plugin Name:       ShopAttributes
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
 * Text Domain:       shop-attributes
 *
 * WC requires at least: 8.0
 * WC tested up to:      10.7
 *
 * @package Pkart\ShopAttributes
 */

namespace Pkart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SHOP_ATTRIBUTES_FILE', __FILE__ );
define( 'SHOP_ATTRIBUTES_PATH', plugin_dir_path( __FILE__ ) );

require_once SHOP_ATTRIBUTES_PATH . 'includes/class-shop-attributes.php';

add_action(
	'init',
	array( Shop_Attributes::class, 'register_block' )
);

add_action(
	'before_woocommerce_init',
	array( Shop_Attributes::class, 'declare_wc_compatibility' )
);
