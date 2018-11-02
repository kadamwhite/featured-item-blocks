/* eslint-disable no-console */
/**
 * WordPress dependencies
 */
import { CheckboxControl } from '@wordpress/components';
import { compose } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { withSelect, withDispatch } from '@wordpress/data';

const FeaturedItemCheckbox = ( { meta, postType, updateMeta } ) => {
	if ( postType !== 'post' ) {
		return null;
	}
	console.log( meta );
	return (
		<CheckboxControl
			label={ __( 'Feature this post' ) }
			checked={ meta._featured }
			onChange={ () => {
				console.log( 'Toggled' );
			} }
		/>
	);
};

// Fetch the post meta.
const applyWithSelect = withSelect( select => {
	const meta = select( 'core/editor' ).getEditedPostAttribute( 'meta' );
	const postType = select( 'core/editor' ).getCurrentPostType();
	console.log( meta );

	return {
		meta,
		postType,
	};
} );

// Provide method to update post meta.
const applyWithDispatch = withDispatch( ( dispatch, { meta } ) => {
	const { editPost } = dispatch( 'core/editor' );

	return {
		updateMeta( newMeta ) {
			editPost( {
				meta: {
					...meta,
					...newMeta,
				},
			} ); // Important: Old and new meta need to be merged in a non-mutating way!
		},
	};
} );

// Combine the higher-order components.
export default compose( [ applyWithSelect, applyWithDispatch ] )( FeaturedItemCheckbox );
