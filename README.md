# ShopAttributes

Show any WooCommerce product attribute, such as color, size or material, inside product blocks and the Product Collection block.

![WordPress](https://img.shields.io/badge/WordPress-6.5%2B-blue) ![PHP](https://img.shields.io/badge/PHP-7.4%2B-777bb4) ![WooCommerce](https://img.shields.io/badge/WooCommerce-required-96588a) ![License](https://img.shields.io/badge/license-GPL--2.0--or--later-green)

## Features

- One block variation for each global WooCommerce attribute, detected automatically.
- Supports global (taxonomy) and custom product attributes.
- Multiple values are shown as a comma-separated list.
- Optional prefix and suffix text.
- Renders nothing when the product does not have the attribute.
- No settings page, no database tables and no front-end JavaScript.

## Requirements

| Requirement | Version |
| ----------- | ------- |
| WordPress   | 6.5+    |
| WooCommerce | 8.0+ (tested up to 10.7) |
| PHP         | 7.4+    |

## Usage

1. Activate WooCommerce and ShopAttributes.
2. In the Site Editor, open a template that contains a Product Collection block or a single product template.
3. Inside the product template, insert the block for an attribute, for example **Color**.
4. Optionally, set **Prefix** and **Suffix** in the block settings sidebar.

For a custom (product-level) attribute, insert any ShopAttributes variation and set **Attribute slug** to the attribute's name, for example `material`. Global attributes use the `pa_` prefix, for example `pa_color`.

### Markup

```html
<p class="pa_color wp-block-pkart-shop-attributes">
	<span class="wp-block-pkart-shop-attributes__prefix">Color: </span>
	<span class="wp-block-pkart-shop-attributes__value">Red, Blue</span>
</p>
```

## Development

```bash
npm install
npm run start       # watch mode
npm run build       # production build into /build
npm run lint:js
npm run lint:css
npm run plugin-zip  # creates shop-attributes.zip for upload
```

### Project structure

```
shop-attributes.php               Plugin bootstrap (headers, constants, hooks)
includes/class-shop-attributes.php  Block registration, server-side render, variations
src/                              Block source (block.json, editor JS, SCSS)
build/                            Compiled assets (generated, committed for release)
readme.txt                        WordPress.org plugin directory readme
```

## Releasing to WordPress.org

1. Update the version in `shop-attributes.php`, `src/block.json`, `package.json`, and `Stable tag` in `readme.txt`.
2. Add a `== Changelog ==` entry (and an `== Upgrade Notice ==` if needed) in `readme.txt`.
3. Run `npm run build`.
4. Copy the plugin files to the SVN `trunk/` (exclude everything listed in `.distignore`), then `svn cp trunk tags/X.Y.Z` and commit.

Banners, icons and screenshots belong in the SVN `assets/` folder, not in the plugin.

## License

GPL-2.0-or-later. See <https://www.gnu.org/licenses/gpl-2.0.html>.
