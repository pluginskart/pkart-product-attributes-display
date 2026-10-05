import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { attributeSlug, attributeName, prefix, suffix } = attributes;
	const blockProps = useBlockProps();

	const label =
		attributeName ||
		attributeSlug ||
		__( 'Select a product attribute', 'shop-attributes' );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Attribute settings', 'shop-attributes' ) }>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Attribute slug', 'shop-attributes' ) }
						help={ __(
							'Global attributes use the "pa_" prefix, for example pa_color. Custom attributes use their name, for example material.',
							'shop-attributes'
						) }
						value={ attributeSlug }
						onChange={ ( value ) =>
							setAttributes( { attributeSlug: value.trim() } )
						}
					/>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Prefix', 'shop-attributes' ) }
						value={ prefix }
						onChange={ ( value ) => setAttributes( { prefix: value } ) }
					/>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __( 'Suffix', 'shop-attributes' ) }
						value={ suffix }
						onChange={ ( value ) => setAttributes( { suffix: value } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<p { ...blockProps }>
				{ prefix && (
					<span className="wp-block-pkart-shop-attributes__prefix">
						{ prefix }
					</span>
				) }
				<span className="wp-block-pkart-shop-attributes__value shop-attributes__placeholder">
					{ label }
				</span>
				{ suffix && (
					<span className="wp-block-pkart-shop-attributes__suffix">
						{ suffix }
					</span>
				) }
			</p>
		</>
	);
}
