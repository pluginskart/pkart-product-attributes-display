const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );

const originalEntry = defaultConfig.entry;

module.exports = {
	...defaultConfig,
	entry: async () => {
		const entries = typeof originalEntry === 'function'
			? await originalEntry()
			: originalEntry;
		return {
			...entries,
			'style-index': path.resolve( process.cwd(), 'src/style-index.scss' ),
		};
	},
};
