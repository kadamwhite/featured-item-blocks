/**
 * Dynamically locate, load & register all Editor Blocks & Plugins.
 *
 * Entry point for the "editor.js" bundle.
 */
import {
	registerBlockType,
	registerPlugin,
	unregisterBlockType,
	unregisterPlugin,
} from './hmr-helpers';

/**
 * Debugging utility method to help trace which WP package exports a desired dependency.
 *
 * @param {String} exportName The export you are looking for, e.g. `compose` or `BlockIcon`.
 */
window.whatModuleExports = exportName => {
	Object.keys( window.wp ).forEach( packageName => {
		if ( Object.keys( window.wp[ packageName ] ).includes( exportName ) ) {
			// eslint-disable-next-line
			console.log( `Export named ${ exportName } found in wp.${ packageName }!` );
		}
	} );
};

/**
 * Given the results of a require.context() call, require all those files.
 *
 * @param {Object}   requireContext The results of running require.context().
 * @param {Function} register       The function to use to register this module.
 * @param {Function} unregister     The function to use to unregister this module.
 */
const autoRegister = ( requireContext, registerFn, unregisterFn ) => {
	requireContext.keys().forEach( modulePath => {
		const { name, options } = requireContext( modulePath );

		if ( module.hot ) {
			module.hot.accept();

			// When accepting hot updates we must unregister blocks before re-registering them.
			unregisterFn( name, module.hot );
		}

		registerFn( name, options, module.hot );
	} );
};

// Load all block index files.
autoRegister(
	require.context( `${ __dirname }/blocks`, true, /index\.js$/ ),
	registerBlockType,
	unregisterBlockType
);

// Load all plugin files.
autoRegister(
	require.context( `${ __dirname }/plugins`, true, /index\.js$/ ),
	registerPlugin,
	unregisterPlugin
);
