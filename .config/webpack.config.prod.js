/**
 * This file defines the configuration that is used for the production build.
 */
const { resolve } = require( 'path' );
const { externals, presets } = require( '@humanmade/webpack-helpers' );

const pluginPath = ( ...pathParts ) => resolve( __dirname, '..', ...pathParts );

/**
 * Theme production build configuration.
 */
module.exports = presets.production( {
	externals,
	entry: {
		editor: pluginPath( 'src/index.js' ),
	},
	output: {
		path: pluginPath( 'build' ),
	},
} );
