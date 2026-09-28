<?php
/**
 * Plugin Name:       ShopAttributes
 * Description:       Displays WooCommerce product attributes inside product blocks.
 * Version:           1.0.0
 * Author:            PKart
 * Author URI:        https://pluginskart.com
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       shop-attributes
 *
 * @package Pkart\ShopAttributes
 */

namespace Pkart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shop Attributes.
 */
class Shop_Attributes {

	/**
	 * Render the product attribute display block.
	 *
	 * @param array    $attributes Block attributes.
	 * @param string   $content    Block default content.
	 * @param \WP_Block $block     Block instance.
	 * @return string
	 */
	public static function render_block( $attributes, $content, $block ) {
		if ( ! isset( $block->context['postId'] ) || empty( $attributes['attributeSlug'] ) ) {
			return '';
		}

		if ( ! function_exists( 'wc_get_product' ) ) {
			return '';
		}

		$pkart_post_id = (int) $block->context['postId'];
		$pkart_product = wc_get_product( $pkart_post_id );

		if ( ! $pkart_product ) {
			return '';
		}

		$pkart_slug   = $attributes['attributeSlug'];
		$pkart_prefix = $attributes['prefix'] ?? '';
		$pkart_suffix = $attributes['suffix'] ?? '';

		$pkart_value     = '';
		$pkart_all_attrs = $pkart_product->get_attributes();

		foreach ( $pkart_all_attrs as $pkart_key => $pkart_attr ) {
			if ( $pkart_attr->is_taxonomy() ) {
				$pkart_matches = ( $pkart_key === $pkart_slug );
			} else {
				$pkart_bare    = preg_replace( '/^pa_/', '', $pkart_slug );
				$pkart_matches = ( sanitize_title( $pkart_attr->get_name() ) === $pkart_bare );
			}

			if ( ! $pkart_matches ) {
				continue;
			}

			$pkart_options = $pkart_attr->get_options();

			if ( $pkart_attr->is_taxonomy() ) {
				$pkart_terms = array_map(
					static function ( $pkart_id ) {
						$pkart_term = get_term( $pkart_id );

						return ( $pkart_term && ! is_wp_error( $pkart_term ) )
							? $pkart_term->name
							: '';
					},
					$pkart_options
				);

				$pkart_value = implode( ', ', array_filter( $pkart_terms ) );
			} else {
				$pkart_value = implode( ', ', $pkart_options );
			}

			break;
		}

		if ( '' === $pkart_value ) {
			return '';
		}

		$pkart_wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => sanitize_html_class( $pkart_slug ),
			)
		);

		$pkart_output = "<p $pkart_wrapper_attributes>";

		if ( $pkart_prefix ) {
			$pkart_output .= '<span class="wp-block-pkart-shop-attributes__prefix">' . esc_html( $pkart_prefix ) . '</span>';
		}

		$pkart_output .= '<span class="wp-block-pkart-shop-attributes__value">' . esc_html( $pkart_value ) . '</span>';

		if ( $pkart_suffix ) {
			$pkart_output .= '<span class="wp-block-pkart-shop-attributes__suffix">' . esc_html( $pkart_suffix ) . '</span>';
		}

		$pkart_output .= '</p>';

		return $pkart_output;
	}

	/**
	 * Build block variations from WooCommerce attributes.
	 *
	 * @return array
	 */
	public static function build_variations() {
		if ( ! function_exists( 'wc_get_attribute_taxonomies' ) ) {
			return array();
		}

		$pkart_taxonomies = wc_get_attribute_taxonomies();

		if ( empty( $pkart_taxonomies ) ) {
			return array();
		}

		$pkart_variations = array();
		$pkart_is_first   = true;

		foreach ( $pkart_taxonomies as $pkart_tax ) {
			$pkart_name = $pkart_tax->attribute_label;

			$pkart_variation = array(
				'name'        => 'pa_' . $pkart_tax->attribute_name,
				'title'       => $pkart_name,
				'description' => sprintf(
					/* translators: %s: attribute label */
					__( 'Display assigned attribute from the attribute: %s', 'shop-attributes' ),
					$pkart_name
				),
				'attributes'  => array(
					'attributeSlug' => 'pa_' . $pkart_tax->attribute_name,
					'attributeName' => $pkart_name,
				),
				'isActive'    => array( 'attributeSlug' ),
				'scope'       => array( 'inserter', 'transform' ),
			);

			if ( $pkart_is_first ) {
				$pkart_variation['isDefault'] = true;
				$pkart_is_first               = false;
			}

			$pkart_variations[] = $pkart_variation;
		}

		return $pkart_variations;
	}

	/**
	 * Register the block.
	 *
	 * @return void
	 */
	public static function register_block() {
		register_block_type_from_metadata(
			__DIR__ . '/build',
			array(
				'render_callback'    => array( __CLASS__, 'render_block' ),
				'variation_callback' => array( __CLASS__, 'build_variations' ),
			)
		);
	}
}

add_action(
	'init',
	array( 'Pkart\Shop_Attributes', 'register_block' )
);