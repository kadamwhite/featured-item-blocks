import { __ } from '@wordpress/i18n';
import { ServerSideRender } from '@wordpress/components';

import './style.scss';

export const name = 'featured-item-blocks/featured-items-list';

export const options = {
	title: __( 'Featured Items List' ),

	description: __( 'Display a list of featured items.' ),

	icon: 'star-empty',

	category: 'widgets',

	// These may be editable down the road, but hard-coded is ok for now.
	attributes: {
		count: {
			type: 'number',
			default: 4,
		},
		editMode: {
			// editMode will never actually get set to true, but it is used
			// to flag that the PHP rendering of this block should skip any
			// post queries not needed in edit mode. (Only registered
			// attributes may be passed to the ServerSideRender component.)
			type: 'boolean',
			default: false,
		},
		postsPerCategory: {
			type: 'number',
			default: 3,
		},
	},

	edit( { attributes } ) {
		return (
			<div className="featured-items-list">
				<ServerSideRender
					block={ name }
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
};
