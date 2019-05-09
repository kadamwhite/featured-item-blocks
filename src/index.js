/**
 * Dynamically locate, load & register all Editor Blocks & Plugins.
 *
 * Entry point for the "editor.js" bundle.
 */
import {
	autoloadBlocks,
	autoloadPlugins,
} from 'block-editor-hmr';

// Load all block index files.
autoloadBlocks( {
	/**
	 * Return a project-specific require.context.
	 */
	getContext: () => require.context( './blocks', true, /index\.js$/ ),
}, ( context, loadModules ) => {
	if ( module.hot ) {
		module.hot.accept( context.id, loadModules );
	}
} );

// Load all plugin files.
autoloadPlugins( {
	/**
	 * Return a project-specific require.context.
	 */
	getContext: () => require.context( './plugins', true, /index\.js$/ ),
}, ( context, loadModules ) => {
	if ( module.hot ) {
		module.hot.accept( context.id, loadModules );
	}
} );
