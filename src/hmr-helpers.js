const { blocks, plugins } = wp;
const { dispatch, select } = wp.data;

/**
 * When a selected block is being disposed during a hot module reload, persist
 * its clientId so it may be reselected after the new module version loads.
 *
 * If the block being unloaded is currently selected, clear that selection to
 * avoid a Gutenberg error that occurs when unregistering a selected block.
 *
 * @param {String} name The name of the block being disposed.
 */
const getSelectedBlockClientId = name => {
	const selectedBlock = select( 'core/editor' ).getSelectedBlock();

	if ( ! selectedBlock || selectedBlock.name !== name ) {
		// Do nothing if no block is selected, or if the selected block is not being reloaded.
		return;
	}

	// The block being reloaded is currently selected: deselect it now.
	dispatch( 'core/editor' ).clearSelectedBlock();

	// Return the block's client ID.
	return selectedBlock.clientId;
};

/**
 * Block disposal helper, which persists the ID of the block being disposed if
 * that block is currently selected.
 *
 * @param {String} name The name of the block being disposed.
 * @param {Object} hot The module.hot instance from the module being disposed.
 */
export const unregisterBlockType = ( name, hot ) => {
	if ( ! hot ) {
		return;
	}

	hot.dispose( data => {
		const clientId = getSelectedBlockClientId( name );

		if ( clientId ) {
			// Persist the client ID so that it may be reselected in registerBlock.
			data.clientId = clientId;
		}

		blocks.unregisterBlockType( name );
	} );
}

export const unregisterPlugin = ( name, hot ) => {
	if ( ! hot ) {
		return;
	}

	hot.dispose( () =>  {
		plugins.unregisterPlugin( name );
	} );
}

/**
 * Block registration helper which wraps registerBlockType and contextually
 * attemptes to reselect the re-registered block.
 *
 * @param {String} name The name of the block being registered.
 * @param {Object} options The options object for the block being registered.
 * @param {Object} hot The module.hot instance, if the calling module is being reloaded.
 */
export const registerBlockType = ( name, options, hot ) => {
	blocks.registerBlockType( name, options );

	if ( hot && hot.data && hot.data.clientId ) {
		dispatch( 'core/editor' ).selectBlock( hot.data.clientId );
	}
};

export const registerPlugin = ( name, options ) => {
	plugins.registerPlugin( name, options );
};
