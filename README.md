# Featured Item Blocks

This project represents WordPress 5.0 / ["Gutenberg"](http://wordpress.org/gutenberg) blocks to display a list of recent featured posts. A "featured post" is defined as a post which has been flagged with the value "yes" for the meta key `_featured`, based on prior art from the [Featured Item Metabox](https://wordpress.org/plugins/featured-item-metabox/) plugin. The data retrieval logic has been tuned for that usage.

This plugin provides its own interface for controlling featured meta, so the Featured Item Metabox plugin is no longer needed.

## Featured Items List

The "Featured Items List" block provided by this plugin renders a list of four columns, each listing a recently-used category and up to three most-recent "featured" posts in that category.

### Roadmap

The `yes` / `no` values for the `_featured` meta key should be replaced with either a boolean `true` value, or else the key should not be set. This will remove the need for the `meta_value` query.

This block could be expanded to provide more control to the editor, such as specifying the number of categories or number of posts per category to render, whether to show the featured image, _etcetera_. However, there is currently no concrete plan or timeline for making those changes.

## Build Tooling

If you are a developer interested in how to configure Webpack for use with Gutenberg, this project represents what I consider best practice as of Oct 31, 2018, during WordPress 5.0 Beta 2. Hot reloading is present when running `npm start`, blocks are automatically included in the build based on file path, and so on. I release this project in part to spur discussion about what we could do to iterate on or improve our tooling to get maximum benefit from both Gutenberg and Webpack.
