import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	const blockProps = useBlockProps( {
		className: 'product-attribute-display',
	} );

	return (
		<p { ...blockProps } aria-label="Product attribute">
			<span className="product-attribute-display__placeholder">
				Product Attribute
			</span>
		</p>
	);
}
