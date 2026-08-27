<?php
/**
 * Plugin Name: WooCommerce Product Attribute Display
 * Description: Displays WooCommerce product attributes inside product blocks.
 * Version: 1.0.0
 * Author: PluginsKart
 * Author URI: https://pluginskart.com
 * Text Domain: woocommerce-product-attribute-display
 *
 * @package PluginsKart\WooCommerceProductAttributeDisplay
 */

namespace PluginsKart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product Attribute Display.
 */
class Product_Attribute_Display {

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

		$post_id = (int) $block->context['postId'];
		$product = wc_get_product( $post_id );

		if ( ! $product ) {
			return '';
		}

		$slug   = $attributes['attributeSlug'];
		$prefix = $attributes['prefix'] ?? '';
		$suffix = $attributes['suffix'] ?? '';

		$value     = '';
		$all_attrs = $product->get_attributes();

		foreach ( $all_attrs as $key => $attr ) {
			if ( $attr->is_taxonomy() ) {
				$matches = ( $key === $slug );
			} else {
				$bare    = preg_replace( '/^pa_/', '', $slug );
				$matches = ( sanitize_title( $attr->get_name() ) === $bare );
			}

			if ( ! $matches ) {
				continue;
			}

			$options = $attr->get_options();

			if ( $attr->is_taxonomy() ) {
				$terms = array_map(
					function ( $id ) {
						$term = get_term( $id );

						return ( $term && ! is_wp_error( $term ) ) ? $term->name : '';
					},
					$options
				);

				$value = implode( ', ', array_filter( $terms ) );
			} else {
				$value = implode( ', ', $options );
			}

			break;
		}

		if ( '' === $value ) {
			return '';
		}

		$wrapper_attributes = get_block_wrapper_attributes(
			array(
				'class' => sanitize_html_class( $slug ),
			)
		);

		$output = "<p $wrapper_attributes>";

		if ( $prefix ) {
			$output .= '<span class="wp-block-pluginskart-product-attribute-display__prefix">' . esc_html( $prefix ) . '</span>';
		}

		$output .= '<span class="wp-block-pluginskart-product-attribute-display__value">' . esc_html( $value ) . '</span>';

		if ( $suffix ) {
			$output .= '<span class="wp-block-pluginskart-product-attribute-display__suffix">' . esc_html( $suffix ) . '</span>';
		}

		$output .= '</p>';

		return $output;
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

		$taxonomies = wc_get_attribute_taxonomies();

		if ( empty( $taxonomies ) ) {
			return array();
		}

		$variations = array();
		$is_first   = true;

		foreach ( $taxonomies as $tax ) {
			$name      = $tax->attribute_label;
			$variation = array(
				'name'        => 'pa_' . $tax->attribute_name,
				'title'       => $name,
				'description' => sprintf(
					/* translators: %s: attribute label */
					__( 'Display assigned attribute from the attribute: %s', 'woocommerce-product-attribute-display' ),
					$name
				),
				'attributes'  => array(
					'attributeSlug' => 'pa_' . $tax->attribute_name,
					'attributeName' => $name,
				),
				'isActive'    => array( 'attributeSlug' ),
				'scope'       => array( 'inserter', 'transform' ),
			);

			if ( $is_first ) {
				$variation['isDefault'] = true;
				$is_first               = false;
			}

			$variations[] = $variation;
		}

		return $variations;
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
	array( 'PluginsKart\Product_Attribute_Display', 'register_block' )
);
