/* eslint-disable no-console */
const { __ } = wp.i18n;
const { CheckboxControl } = wp.components;
const { Fragment } = wp.element;
const { PluginSidebar, PluginPostStatusInfo, PluginSidebarMoreMenuItem } = wp.editPost;

export const name = 'featured-item-selector';

export const options = {
	icon: 'star-empty',

	render() {
		return (
			<Fragment>
				<PluginPostStatusInfo>
					<CheckboxControl
						label={ __( 'Feature this post' ) }
						checked={ true }
						onChange={ () => {
							console.log( 'Toggled' );
						} }
					/>
				</PluginPostStatusInfo>
				<PluginSidebarMoreMenuItem target="featured-item-selector">
					Featured Item
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
