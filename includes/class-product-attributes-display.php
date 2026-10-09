<?php
/**
 * Product Attributes Display class.
 *
 * @package Pkart\ProductAttributesDisplay
 */

namespace Pkart;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product Attributes Display.
 */
class Product_Attributes_Display {

	/**
	 * Render the product attribute display block.
	 *
	 * @param array     $attributes Block attributes.
	 * @param string    $content    Block default content.
	 * @param \WP_Block $block      Block instance.
	 * @return string
	 */
	public static function render_block( $attributes, $content, $block ) {
		if (
			! isset( $block->context['postId'] )
			|| empty( $attributes['attributeSlug'] )
		) {
			return '';
		}

		if ( ! function_exists( 'wc_get_product' ) ) {
			return '';
		}

		$product_id = (int) $block->context['postId'];
		$product    = wc_get_product( $product_id );

		if ( ! $product ) {
			return '';
		}

		$slug   = (string) $attributes['attributeSlug'];
		$prefix = isset( $attributes['prefix'] )
			? (string) $attributes['prefix']
			: '';
		$suffix = isset( $attributes['suffix'] )
			? (string) $attributes['suffix']
			: '';

		$value      = '';
		$attributes = $product->get_attributes();

		foreach ( $attributes as $key => $attribute ) {
			if ( $attribute->is_taxonomy() ) {
				$matches = ( $key === $slug );
			} else {
				$bare_slug = preg_replace( '/^pa_/', '', $slug );
				$matches   = (
					sanitize_title( $attribute->get_name() )
					=== $bare_slug
				);
			}

			if ( ! $matches ) {
				continue;
			}

			$options = $attribute->get_options();

			if ( $attribute->is_taxonomy() ) {
				$terms = array_map(
					static function ( $term_id ) {
						$term = get_term( $term_id );

						return (
							$term && ! is_wp_error( $term )
						)
							? $term->name
							: '';
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

		$output = '<p ' . $wrapper_attributes . '>';

		if ( '' !== $prefix ) {
			$output .= '<span class="wp-block-pkart-product-attributes-display__prefix">'
				. esc_html( $prefix )
				. '</span>';
		}

		$output .= '<span class="wp-block-pkart-product-attributes-display__value">'
			. esc_html( $value )
			. '</span>';

		if ( '' !== $suffix ) {
			$output .= '<span class="wp-block-pkart-product-attributes-display__suffix">'
				. esc_html( $suffix )
				. '</span>';
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

		foreach ( $taxonomies as $taxonomy ) {
			$name = $taxonomy->attribute_label;

			$variation = array(
				'name'        => 'pa_' . $taxonomy->attribute_name,
				'title'       => $name,
				'description' => sprintf(
					/* translators: %s: attribute label */
					__(
						'Display the assigned value of the attribute: %s',
						'pkart-product-attributes-display'
					),
					$name
				),
				'attributes'  => array(
					'attributeSlug' => 'pa_' . $taxonomy->attribute_name,
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
	 * Declare compatibility with WooCommerce features.
	 *
	 * @return void
	 */
	public static function declare_wc_compatibility() {
		if (
			class_exists(
				\Automattic\WooCommerce\Utilities\FeaturesUtil::class
			)
		) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
				'custom_order_tables',
				PKART_PRODUCT_ATTRIBUTES_DISPLAY_FILE,
				true
			);

			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility(
				'cart_checkout_blocks',
				PKART_PRODUCT_ATTRIBUTES_DISPLAY_FILE,
				true
			);
		}
	}

	/**
	 * Register the block.
	 *
	 * @return void
	 */
	public static function register_block() {
		register_block_type_from_metadata(
			PKART_PRODUCT_ATTRIBUTES_DISPLAY_PATH . 'build',
			array(
				'render_callback'    => array(
					__CLASS__,
					'render_block',
				),
				'variation_callback' => array(
					__CLASS__,
					'build_variations',
				),
			)
		);
	}
}