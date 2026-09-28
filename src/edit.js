import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
	const blockProps = useBlockProps( {
		className: 'shop-attributes',
	} );

	return (
		<p { ...blockProps } aria-label="ShopAttributes">
			<span className="shop-attributes__placeholder">
				ShopAttributes
			</span>
		</p>
	);
}