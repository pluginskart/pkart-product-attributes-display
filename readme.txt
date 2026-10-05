=== ShopAttributes ===
Contributors: pkart
Tags: woocommerce, product attributes, attributes, blocks, product block
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Show any WooCommerce product attribute, such as color, size or material, inside product blocks and the Product Collection block.

== Description ==

ShopAttributes adds a block that displays a single WooCommerce product attribute for the current product. Place it inside a Product Collection block, a product template or a single product template, and it shows the attribute values assigned to each product.

Every global attribute you create under **Products → Attributes** appears in the block inserter as its own block variation, so you can add "Color", "Size" or "Material" in one click. Custom (product-level) attributes are supported too: enter the attribute name in the block settings.

= Features =

* One block variation for each global WooCommerce attribute, detected automatically.
* Supports global (taxonomy) and custom product attributes.
* Multiple values are shown as a comma-separated list.
* Optional prefix and suffix text, for example "Color: " or " cm".
* Renders nothing when the product does not have the attribute, so there are no empty labels.
* Lightweight: no settings page, no database tables and no front-end JavaScript.

= Requirements =

* WordPress 6.5 or later
* WooCommerce (active)
* PHP 7.4 or later

= Source code =

The plugin's JavaScript is compiled with `@wordpress/scripts`. The uncompiled source is included in the `src` folder of the plugin. To build it yourself, run `npm install` and then `npm run build`.

== Installation ==

1. In your WordPress admin, go to **Plugins → Add New**, search for "ShopAttributes", and click **Install Now**. Alternatively, upload the `shop-attributes` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin from the **Plugins** screen. WooCommerce must be installed and active.
3. Open a template or page that contains a Product Collection block (or a single product template) in the Site Editor.
4. Inside the product template, add the block for the attribute you want to show, for example "Color".
5. Optionally, set a prefix or suffix in the block settings sidebar.

== Frequently Asked Questions ==

= Does this plugin require WooCommerce? =

Yes. WooCommerce must be installed and active.

= Where can I use the block? =

Use it anywhere a product is available as context: inside the Product Collection block's product template and in single product templates. Outside a product context the block renders nothing.

= Why don't I see my attribute in the inserter? =

Block variations are created for global attributes only (**Products → Attributes**). For a custom attribute that is defined on an individual product, insert any ShopAttributes variation and change the **Attribute slug** in the block settings to the attribute's name, for example `material`.

= What should I enter as the attribute slug? =

For global attributes, use the taxonomy name with the `pa_` prefix, for example `pa_color`. For custom attributes, use the attribute name in lowercase with spaces replaced by hyphens, for example `fabric-type`.

= Why is the block empty on some products? =

The block only outputs content when the current product has a value for the selected attribute.

= Can I style the output? =

Yes. The block outputs a paragraph with the class `wp-block-pkart-shop-attributes` plus the attribute slug, and the prefix, value and suffix are wrapped in `wp-block-pkart-shop-attributes__prefix`, `__value` and `__suffix` spans.

= Is the plugin compatible with WooCommerce HPOS? =

Yes. The plugin does not read or write orders, and it declares compatibility with High-Performance Order Storage and the Cart and Checkout blocks.

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
Initial release.
