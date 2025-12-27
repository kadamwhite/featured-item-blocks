import { registerPlugin } from '@wordpress/plugins';
import { PluginPostStatusInfo } from '@wordpress/editor';

import FeaturedItemCheckbox from './featured-item-checkbox';

registerPlugin( 'featured-item-selector', {
	icon: 'star-empty',

	render() {
		return (
			<PluginPostStatusInfo>
				<FeaturedItemCheckbox />
			</PluginPostStatusInfo>
		);
	},
} );
