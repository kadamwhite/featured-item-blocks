import { __ } from '@wordpress/i18n';
import { ServerSideRender } from '@wordpress/components';
import { withSelect } from '@wordpress/data';

export const name = 'featured-item-blocks/post-meta';

const BlockPreview = ( { id } ) => (
	<ServerSideRender block={ name } attributes={ { id } } />
);

const ConnectedBlockPreview = withSelect( select => ( {
	id: select( 'core/editor' ).getCurrentPostId(),
} ) )( BlockPreview );

export const options = {
	title: __( 'Post Meta List' ),

	description: __( 'Display a table of post meta.' ),

	icon: 'editor-table',

	category: 'widgets',

	attributes: {
		id: {
			type: 'number',
		},
	},

	edit() {
		return (
			<ConnectedBlockPreview />
		);
	},

	save() {
		// Dynamic Block: render in PHP.
		return null;
	},
};
