/* eslint-disable import/no-unresolved,prettier/prettier */
/**
 * WordPress dependencies
 */
import { CheckboxControl } from '@wordpress/components';
import { compose } from '@wordpress/compose';
import { __ } from '@wordpress/i18n';
import { withSelect, withDispatch } from '@wordpress/data';

const supportedPostTypes = [ 'post' ];

export const FeaturedItemCheckbox = ( { meta, postType, toggleMeta } ) => {
	if ( ! supportedPostTypes.includes( postType ) ) {
		return null;
	}
	return (
		<CheckboxControl
			label={ __( 'Feature this post' ) }
			checked={ meta._featured === 'yes' }
			onChange={ toggleMeta }
		/>
	);
};

// Fetch the post meta.
const applyWithSelect = withSelect( select => {
	const editor = select( 'core/editor' );

	return {
		meta: editor.getEditedPostAttribute( 'meta' ),
		postType: editor.getCurrentPostType(),
	};
} );

// Provide method to update post meta.
const applyWithDispatch = withDispatch( ( dispatch, { meta } ) => {
	const { editPost } = dispatch( 'core/editor' );

	const toggleMeta = () => editPost( {
		meta: {
			_featured: meta._featured === 'yes' ? null : 'yes',
		},
	} );

	return {
		toggleMeta,
	};
} );

// Combine the higher-order components.
export default compose( [ applyWithSelect, applyWithDispatch ] )( FeaturedItemCheckbox );
