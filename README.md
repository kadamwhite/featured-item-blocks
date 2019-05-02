# Featured Item Blocks

This project represents WordPress 5.0 / ["Gutenberg"](http://wordpress.org/gutenberg) blocks to display a list of recent featured posts. A "featured post" is defined as a post which has been flagged with the value "yes" for the meta key `_featured`, based on prior art from the [Featured Item Metabox](https://wordpress.org/plugins/featured-item-metabox/) plugin. The data retrieval logic has been tuned for that usage.

This plugin provides its own interface for controlling featured meta, so the Featured Item Metabox plugin is no longer needed.

## Featured Items List

The "Featured Items List" block provided by this plugin renders a list of four columns, each listing a recently-used category and up to three most-recent "featured" posts in that category.

### Roadmap

The `yes` / `no` values for the `_featured` meta key should be replaced with either a boolean `true` value, or else the key should not be set. This will remove the need for the `meta_value` query.

This block could be expanded to provide more control to the editor, such as specifying the number of categories or number of posts per category to render, whether to show the featured image, _etcetera_. However, there is currently no concrete plan or timeline for making those changes.

## Theme Integration

This block exposes two filter hooks which can be used to control the format & size of the image which displays for the most recent post in each category.

**`featured_item_blocks_thumbnail_size`**

This filter can be used to control what size of thumbnail your site tries to render for each column. If your site uses exclusively square images, for example, and you have a `square_thumbnail` image size registered, you may hook into this filter to use your square image size instead of the default 3:2 aspect ratio:

```php
function mytheme_square_featured_items_images() {
  return 'square_thumbnail';
}
add_filter( 'featured_item_blocks_thumbnail_size', 'mytheme_square_featured_items_images' );
```

**`featured_item_blocks_image_sizes`**

This block renders out responsive image markup using WordPress' built-in image handlers. However, the default `sizes` value of these images may cause an overly large image to render in each column, regardless of the value you specify in the `featured_item_blocks_thumbnail_size` filter. That's where this second filter comes in: using this, you may instruct WordPress to output a responsive image `sizes` attribute which exactly matches your theme's breakpoints.

For example, assuming that you plan to use this block on your site homepage and your site is configured to break the block columns onto two lines below 700px, this filter will instruct WordPress that the largest these images could be is 50vw (50% of the viewport width) below 700px, and 25vw (25% of the viewport width) otherwise:

```php
function mytheme_featured_item_blocks_image_sizes() {
  return '(max-width: 700px) 50vw, 25vw';
}
add_filter( 'featured_item_blocks_image_sizes', 'mytheme_featured_item_blocks_image_sizes' );
```

If your site puts a max-width (say, 1200px) on the content column and doesn't support wide alignment, you could also specify the maximum possible image size:

```php
function mytheme_featured_item_blocks_image_sizes() {
  return '(max-width: 700px) 50vw, (max-width: 1200px) 25vw, 300px';
}
add_filter( 'featured_item_blocks_image_sizes', 'mytheme_featured_item_blocks_image_sizes' );
```

## Build Tooling

If you are a developer interested in how to configure Webpack for use with Gutenberg, this project represents what I consider best practice as of Oct 31, 2018, during WordPress 5.0 Beta 2. Hot reloading is present when running `npm start`, blocks are automatically included in the build based on file path, and so on. I release this project in part to spur discussion about what we could do to iterate on or improve our tooling to get maximum benefit from both Gutenberg and Webpack.

### Key Commands

- `npm start`: Run the Webpack development server. WordPress will automatically detect and load the script from the dev server based on the presence of the `asset-manifest.json` the dev server outputs into the build directory.
- `npm run build`: Build the application into the `build/` directory.
- `npm run lint`: Run PHPCS and ESLint to check for style issues.
- `npm run release #.#.#`: Merge master into the release branch, then build and tag release v#.#.#. (Use the version number specified in package.json and the plugin's PHP file.)

## License

This plugin is free software; you can redistribute it and/or modify it under the terms of either:

- the [GNU General Public License](LICENSE.md#gnu-general-public-license) as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version, or
- the [Artistic License 2.0](LICENSE.md#artistic-license-20)
