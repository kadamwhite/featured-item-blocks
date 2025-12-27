import { __ } from '@wordpress/i18n';
import { registerBlockType } from '@wordpress/blocks';
import { ServerSideRender } from '@wordpress/server-side-render';

import './style.scss';

import metadata from './block.json';

registerBlockType( metadata.name, {
	...metadata,

	edit( { attributes } ) {
		return (
			<div className="featured-items-list">
				<ServerSideRender
					block={ metadata.name }
					attributes={ {
						...attributes,
						editMode: true,
					} }
				/>
			</div>
		);
	},

	save() {
		// Dynamic Block: render in PHP.
		return null;
	},
} );
