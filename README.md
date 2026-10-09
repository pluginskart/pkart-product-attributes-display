# PKart Product Attributes Display

Display WooCommerce product attributes such as color, size, and material inside product blocks and Product Collection templates.

![WordPress](https://img.shields.io/badge/WordPress-6.5%2B-blue)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777bb4)
![WooCommerce](https://img.shields.io/badge/WooCommerce-required-96588a)
![License](https://img.shields.io/badge/license-GPL--2.0--or--later-green)

## Features

- Automatically creates block variations for global WooCommerce attributes.
- Supports global and custom product attributes.
- Displays multiple attribute values separated by commas.
- Supports optional prefix and suffix text.
- Renders nothing when the selected product has no value.
- No settings page, database tables, or front-end JavaScript.

## Requirements

| Requirement | Version |
|---|---|
| WordPress | 6.5+ |
| WooCommerce | 8.0+ |
| PHP | 7.4+ |

## Usage

1. Activate WooCommerce and PKart Product Attributes Display.
2. Open a template containing a Product Collection block or a single product template.
3. Insert the attribute block variation you want to display.
4. Configure Attribute slug, Prefix, and Suffix in the settings sidebar.

Global attributes use the `pa_` prefix, such as `pa_color`.

For custom product attributes, enter the attribute name in lowercase with spaces replaced by hyphens, such as `fabric-type`.

## Example output

```html
<p class="wp-block-pkart-shop-attributes pa_color">
    <span class="wp-block-pkart-product-attributes-display__prefix">Color: </span>
    <span class="wp-block-pkart-product-attributes-display__value">Red, Blue</span>
</p>
```

The existing `pkart/shop-attributes` block name is retained to preserve compatibility with previously saved blocks.

## Development

```bash
npm install
npm run start
npm run build
npm run lint:js
npm run lint:css
npm run plugin-zip
```

## Project structure

```text
pkart-product-attributes-display.php
includes/
src/
build/
readme.txt
README.md
package.json
```

## License

GPL-2.0-or-later.