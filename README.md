# PKart Product Attributes Display

![Version](https://img.shields.io/badge/version-1.0.0-blue)
![WordPress](https://img.shields.io/badge/WordPress-6.5%2B-21759b)
![WooCommerce](https://img.shields.io/badge/WooCommerce-8.0%2B-96588a)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777bb4)
![License](https://img.shields.io/badge/license-GPL--2.0--or--later-green)

Show WooCommerce product attributes like color, width, size, or material anywhere in your block-based product templates.

By default, WooCommerce only lists attributes in the "Additional information" tab. This plugin adds a lightweight block so you can place individual attributes, such as **Color: Walnut, Natural Oak, Black** or **Width: 60, 90, 120 cm**, directly under the product title or price, inside product grids, or anywhere else in the Site Editor.

![Product attributes on the single product page](.wordpress-org/screenshot-1.png)

## Features

- **One block per attribute.** A block variation is created automatically for every global WooCommerce attribute.
- **Global and custom attributes.** Works with taxonomy-based global attributes and product-level custom attributes.
- **Prefix and suffix.** Add labels and units, such as `Width: ` and ` cm`.
- **Multiple values.** Displays multiple values as a comma-separated list.
- **Works where products live.** Single Product template, Product Collection block, and any block that provides product context.
- **Hides itself when empty.** Outputs nothing when the product has no value for the attribute.
- **Easy to style.** Prefix, value, and suffix have their own CSS classes.
- **Lightweight.** No settings page, no custom database tables, no front-end JavaScript.
- **HPOS compatible.** Declares compatibility with High-Performance Order Storage and the Cart and Checkout blocks.

## Requirements

| Requirement | Version |
| ----------- | ------- |
| WordPress   | 6.5+    |
| WooCommerce | 8.0+    |
| PHP         | 7.4+    |

A block theme (or a theme that supports block templates) is required to place the block in product templates.

## Installation

**From WordPress.org**

1. Go to **Plugins → Add New Plugin** and search for "PKart Product Attributes Display".
2. Click **Install Now**, then **Activate**.

**From source**

```bash
cd wp-content/plugins
git clone https://github.com/pluginskart/pkart-product-attributes-display.git
```

The compiled block is committed in `build/`, so no build step is needed.

Then activate the plugin from **Plugins → Installed Plugins**.

## Usage

1. Create attributes under **Products → Attributes** (or add custom attributes on a product) and assign values to your products.
2. Open **Appearance → Editor** and edit the Single Product template, or any template containing a Product Collection block.
3. Search the block inserter for your attribute name (for example, "Width") and insert it.
4. Set the **Prefix** and **Suffix** in the block settings sidebar if needed.

![Attribute blocks in the Site Editor](.wordpress-org/screenshot-2.png)

### Attribute slugs

| Attribute type | Slug format | Example |
| -------------- | ----------- | ------- |
| Global (Products → Attributes) | `pa_` + attribute name | `pa_color`, `pa_width` |
| Custom (product-level) | Name in lowercase, spaces replaced by hyphens | `fabric-type`, `thickness` |

Blocks inserted for global attributes fill in the slug automatically. To display a custom attribute, insert any attribute block and change its **Attribute slug**.

![Attributes in the WooCommerce product editor](.wordpress-org/screenshot-3.png)

## Styling

Example output for a block with the prefix `Width: ` and the suffix ` cm`:

```html
<p class="wp-block-pkart-shop-attributes pa_width">
	<span class="wp-block-pkart-product-attributes-display__prefix">Width: </span>
	<span class="wp-block-pkart-product-attributes-display__value">60, 90, 120</span>
	<span class="wp-block-pkart-product-attributes-display__suffix"> cm</span>
</p>
```

| Class | Element |
| ----- | ------- |
| `.wp-block-pkart-shop-attributes` | Block wrapper |
| `.pa_width`, `.thickness`, … | Selected attribute slug |
| `.wp-block-pkart-product-attributes-display__prefix` | Prefix text |
| `.wp-block-pkart-product-attributes-display__value` | Attribute values |
| `.wp-block-pkart-product-attributes-display__suffix` | Suffix text |

## Development

| Path | Contents |
| ---- | -------- |
| `src/` | Block editor source (built with `@wordpress/scripts`) |
| `build/` | Compiled block assets loaded by the plugin |
| `includes/class-product-attributes-display.php` | Server-side rendering and block variations |

## Changelog

### 1.0.0

- Initial release.

## License

[GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html)
