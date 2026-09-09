<?php
/**
 * Render callback for the product attribute display block.
 *
 * Displays WooCommerce product dimensions:
 *
 * Thickness × High Width × Length
 *
 * @var array     $attributes Block attributes.
 * @var string    $content    Inner block content.
 * @var \WP_Block $block      Block instance.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Render product dimensions.
 *
 * @param array     $attributes Block attributes.
 * @param string    $content    Inner block content.
 * @param \WP_Block $block      Block instance.
 *
 * @return string Rendered HTML.
 */
function pkart_product_dimensions_render( $attributes, $content, $block ) {
	$pkart_post_id = isset( $block->context['postId'] )
		? (int) $block->context['postId']
		: get_the_ID();

	if ( ! $pkart_post_id || ! function_exists( 'wc_get_product' ) ) {
		return '';
	}

	$pkart_product = wc_get_product( $pkart_post_id );

	if ( ! $pkart_product ) {
		return '';
	}

	$pkart_all_attributes = $pkart_product->get_attributes();

	$pkart_thickness  = '';
	$pkart_high_width = '';
	$pkart_length     = '';

	foreach ( $pkart_all_attributes as $pkart_attr ) {
		$pkart_name    = strtolower( $pkart_attr->get_name() );
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

		if ( str_contains( $pkart_name, 'thickness' ) ) {
			$pkart_thickness = $pkart_value;
		} elseif (
			str_contains( $pkart_name, 'high width' ) ||
			str_contains( $pkart_name, 'high-width' )
		) {
			$pkart_high_width = $pkart_value;
		} elseif ( str_contains( $pkart_name, 'length' ) ) {
			$pkart_length = $pkart_value;
		}
	}

	$pkart_parts = array();

	if ( '' !== $pkart_thickness ) {
		$pkart_parts[] = esc_html( $pkart_thickness ) . '" T';
	}

	if ( '' !== $pkart_high_width ) {
		$pkart_parts[] = esc_html( $pkart_high_width ) . '" W';
	}

	if ( '' !== $pkart_length ) {
		$pkart_parts[] = esc_html( $pkart_length ) . '" L';
	}

	if ( empty( $pkart_parts ) ) {
		return '';
	}

	$pkart_dimensions = implode( ' &times; ', $pkart_parts );

	return sprintf(
		'<p %1$s>%2$s</p>',
		get_block_wrapper_attributes(),
		$pkart_dimensions
	);
}

echo wp_kses_post(
	pkart_product_dimensions_render(
		$attributes,
		$content,
		$block
	)
);
