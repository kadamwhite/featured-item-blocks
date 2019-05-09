import { PluginPostStatusInfo } from '@wordpress/edit-post';

import FeaturedItemCheckbox from './featured-item-checkbox';

export const name = 'featured-item-selector';

export const settings = {
	icon: 'star-empty',

	render() {
		return (
			<PluginPostStatusInfo>
				<FeaturedItemCheckbox />
			</PluginPostStatusInfo>
		);
	},
};
