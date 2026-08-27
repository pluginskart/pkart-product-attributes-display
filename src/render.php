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

$post_id = isset( $block->context['postId'] )
	? (int) $block->context['postId']
	: get_the_ID();

if ( ! $post_id || ! function_exists( 'wc_get_product' ) ) {
	return;
}

$product = wc_get_product( $post_id );

if ( ! $product ) {
	return;
}

$all_attributes = $product->get_attributes();

$thickness  = '';
$high_width = '';
$length     = '';

foreach ( $all_attributes as $attr ) {
	$name = strtolower( $attr->get_name() );

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

	if ( str_contains( $name, 'thickness' ) ) {
		$thickness = $value;
	} elseif (
		str_contains( $name, 'high width' ) ||
		str_contains( $name, 'high-width' )
	) {
		$high_width = $value;
	} elseif ( str_contains( $name, 'length' ) ) {
		$length = $value;
	}
}

$parts = array();

if ( '' !== $thickness ) {
	$parts[] = esc_html( $thickness ) . '" T';
}

if ( '' !== $high_width ) {
	$parts[] = esc_html( $high_width ) . '" W';
}

if ( '' !== $length ) {
	$parts[] = esc_html( $length ) . '" L';
}

if ( empty( $parts ) ) {
	return;
}

$dimensions = implode( ' &times; ', $parts );
?>

<p <?php echo get_block_wrapper_attributes(); ?>>
	<?php echo $dimensions; ?>
</p>
