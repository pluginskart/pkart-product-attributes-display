=== PKart Product Attributes Display ===
Contributors: pkart
Tags: woocommerce, product attributes, attributes, blocks, product block
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Display WooCommerce product attributes such as color, size, and material inside product blocks and the Product Collection block.

== Description ==

PKart Product Attributes Display adds a block that displays a single WooCommerce product attribute for the current product. Place it inside a Product Collection block, a product template, or a single product template to display the attribute values assigned to each product.

Global attributes created under Products → Attributes are automatically available as block variations. Custom product-level attributes are supported through the block settings.

= Features =

* Automatically creates a block variation for each global WooCommerce attribute.
* Supports global taxonomy attributes and custom product attributes.
* Displays multiple values as a comma-separated list.
* Supports optional prefix and suffix text, such as "Color: " or " cm".
* Renders nothing when the selected product has no value for the attribute.
* Lightweight implementation with no settings page, database tables, or front-end JavaScript.

= Requirements =

* WordPress 6.5 or later
* WooCommerce 8.0 or later
* PHP 7.4 or later

= Installation =

1. Upload the pkart-product-attributes-display folder to /wp-content/plugins/, or upload the plugin ZIP through Plugins → Add New Plugin → Upload Plugin.
2. Activate WooCommerce and PKart Product Attributes Display.
3. Open a template containing a Product Collection block or a single product template in the Site Editor.
4. Insert the desired attribute block variation inside the product template.
5. Configure the Attribute slug, Prefix, and Suffix in the block settings if needed.

= Frequently Asked Questions =

= Does this plugin require WooCommerce? =

Yes. WooCommerce must be installed and active.

= Where can I use the block? =

Use it wherever a product is available as block context, including Product Collection templates and single product templates. Outside a product context, the block renders nothing.

= Why don't I see my attribute in the inserter? =

Global attributes are created under Products → Attributes. Create the attribute there to make it available as a block variation. For custom product attributes, insert a ShopAttributes block and configure its Attribute slug.

= What should I enter as the attribute slug? =

For global attributes, use the taxonomy name with the pa_ prefix, such as pa_color. For custom attributes, use the attribute name in lowercase with spaces replaced by hyphens, such as fabric-type.

= Why is the block empty on some products? =

The block outputs content only when the current product has a value for the selected attribute.

= Can I style the output? =

Yes. The output uses the wp-block-pkart-shop-attributes block wrapper class for compatibility, along with the selected attribute slug. Prefix, value, and suffix use dedicated child classes.

= Is the plugin compatible with WooCommerce HPOS? =

The plugin declares compatibility with High-Performance Order Storage and Cart and Checkout blocks. It does not read or write orders.

== Changelog ==

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
Initial release.