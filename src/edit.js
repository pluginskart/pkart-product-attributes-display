import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { attributeSlug, attributeName, prefix, suffix } = attributes;
	const blockProps = useBlockProps();

	const label =
		attributeName ||
		attributeSlug ||
		__( 'Select a product attribute', 'pkart-product-attributes-display' );

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __(
						'Attribute settings',
						'pkart-product-attributes-display'
					) }
				>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Attribute slug',
							'pkart-product-attributes-display'
						) }
						help={ __(
							'Global attributes use the "pa_" prefix, for example pa_color. Custom attributes use their name, for example material.',
							'pkart-product-attributes-display'
						) }
						value={ attributeSlug }
						onChange={ ( value ) =>
							setAttributes( {
								attributeSlug: value.trim(),
							} )
						}
					/>

					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Prefix',
							'pkart-product-attributes-display'
						) }
						value={ prefix }
						onChange={ ( value ) =>
							setAttributes( { prefix: value } )
						}
					/>

					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label={ __(
							'Suffix',
							'pkart-product-attributes-display'
						) }
						value={ suffix }
						onChange={ ( value ) =>
							setAttributes( { suffix: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<p { ...blockProps }>
				{ prefix && (
					<span className="wp-block-pkart-product-attributes-display__prefix">
						{ prefix }
					</span>
				) }

				<span className="wp-block-pkart-product-attributes-display__value shop-attributes__placeholder">
					{ label }
				</span>

				{ suffix && (
					<span className="wp-block-pkart-product-attributes-display__suffix">
						{ suffix }
					</span>
				) }
			</p>
		</>
	);
}