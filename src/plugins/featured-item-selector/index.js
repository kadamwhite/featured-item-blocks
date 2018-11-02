import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import {
	PluginSidebar,
	PluginPostStatusInfo,
	PluginSidebarMoreMenuItem,
} from '@wordpress/edit-post';

import FeaturedItemCheckbox from './featured-item-checkbox';

export const name = 'featured-item-selector';

export const options = {
	icon: 'star-empty',

	render() {
		return (
			<Fragment>
				<PluginPostStatusInfo>
					<FeaturedItemCheckbox />
				</PluginPostStatusInfo>
				<PluginSidebarMoreMenuItem target="featured-item-selector">
					{ __( 'Featured Item' ) }
				</PluginSidebarMoreMenuItem>
				<PluginSidebar
					name="featured-item-selector"
					title="Feature This Post"
				>
					<div className="components-panel__body is-opened">
						<p>Include this post in the featured posts lists?</p>
						<p>Foo!</p>
					</div>
				</PluginSidebar>
			</Fragment>
		);
	},
};
