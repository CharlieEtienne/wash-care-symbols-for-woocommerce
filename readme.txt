=== Wash Care Symbols for WooCommerce ===
Contributors: charlieetienne
Tags: woocommerce, wash, care, symbols, clothes
Stable tag: 4.2.0
Requires at least: 5.2
Tested up to: 6.4
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate Link: https://paypal.me/webnancy

Display wash/care symbols in WooCommerce products.

== Description ==

Display wash/care symbols in WooCommerce products.

== Usage & Documentation ==

You can choose wash/care symbols to display on product category level or in each individual product

For now, these choices are available:

* Washing:
    * Machine wash, gentle / delicate
    * Machine wash, permanent press / wrinkle resistant
    * Machine wash, regular / normal
    * Do not wash
    * Hand wash only
    * Machine wash, gentle / delicate, 30 degrees C (85 degrees F)
    * Machine wash, permanent press / wrinkle resistant, 30 degrees C (85 degrees F)
    * Machine wash, regular / normal, 30 degrees C (85 degrees F)
    * Machine wash, gentle / delicate, 40 degrees C (105 degrees F)
    * Machine wash, permanent press, 40 degrees C (105 degrees F)
    * Machine wash, regular / normal, 40 degrees C (105 degrees F)
    * Machine wash, gentle / delicate, 50 degrees C (120 degrees F)
    * Machine wash, permanent press, 50 degrees C (120 degrees F)
    * Machine wash, regular / normal, 50 degrees C (120 degrees F)
    * Machine wash, gentle / delicate, 60 degrees C (140 degrees F)
    * Machine wash, permanent press, 60 degrees C (140 degrees F)
    * Machine wash, regular / normal, 60 degrees C (140 degrees F)
    * Machine wash, gentle / delicate, 70 degrees C (160 degrees F)
    * Machine wash, permanent press, 70 degrees C (160 degrees F)
    * Machine wash, regular / normal, 70 degrees C (160 degrees F)
    * Machine wash, gentle / delicate, 95 degrees C (200 degrees F)
    * Machine wash, permanent press, 95 degrees C (200 degrees F)
    * Machine wash, regular / normal, 95 degrees C (200 degrees F)
    * Hand wash, 30 degrees C (85 degrees F)
    * Hand wash, 40 degrees C (105 degrees F)
    * Hand wash, 50 degrees C (120 degrees F)

* Drying:
    * Tumble dry, normal
    * Tumble dry, normal, low heat
    * Tumble dry, normal, medium heat
    * Tumble dry, normal, high heat
    * Tumble dry, normal, no heat
    * Tumble dry, permanent press
    * Tumble dry, permanent press, low heat
    * Tumble dry, permanent press, medium heat
    * Tumble dry, permanent press, high heat
    * Tumble dry, gentle
    * Tumble dry, gentle, low heat
    * Tumble dry, gentle, medium heat
    * Tumble dry, gentle, high heat
    * Tumble dry, permanent press, no heat
    * Line dry
    * Drip dry
    * Dry flat
    * Dry in shade
    * Do not dry
    * Line dry in shade
    * Drip dry in shade
    * Dry flat in shade
    
* Ironing:
    * Ironing required
    * Iron, low temperature
    * Iron, medium temperature
    * Iron, high temperature
    * Do not iron
    * Iron, no steam
    * Iron, no steam, low temperature
    * Iron, no steam, medium temperature
    * Iron, no steam, high temperature
    
* Dry cleaning:
    * Dry clean
    * Dry clean, any solvent
    * Dry clean, petroleum based solvent only
    * Dry clean, any solvent other than trichloroethylene
    * Do not dry clean
    * Dry clean, short cycle
    * Dry clean, low moisture
    * Dry clean, low heat
    * Dry clean, no steam
    * Dry clean, any solvent, short cycle
    * Dry clean, any solvent, low moisture
    * Dry clean, any solvent, low heat
    * Dry clean, any solvent, no steam
    
* Bleaching:
    * Use any bleach
    * Use only non-chlorine bleach
    * Do not bleach

* Chemical cleaning
    * Dry clean, hydrocarbon solvent only (HCS)
    * Gentle cleaning with hydrocarbon sovents (HCS)
    * Very gentle cleaning with hydrocarbon sovents (HCS)
    * Dry clean, tetrachloroethylene only (PCE)
    * Gentle cleaning with tetrachloroethylene (PCE)
    * Very gentle cleaning with tetrachloroethylene (PCE)

* Wet cleaning
    * Wet clean
    * Gentle wet cleaning
    * Very gentle wet cleaning
    * Professionnal wet cleaning is not allowed

== Settings ==

Go to Settings > Wash Care Symbols for WooCommerce.

* **Position:** Inside "Additional Information"(default) / below short description (added in 2.4) / In custom tab (added in 3.1).
* **Layout:** Horizontal/Vertical/Minimal (added in 2.2).
* **Icons size** (added in 2.7).

== Shortcode ==

If for some reason, you don't want to use WooCommerce Product data tabs, you can display wash/care instructions wherever you want with the `[wcsfwc]` shortcode.

In a product page, just do:

~~~php
[wcsfwc]
~~~

It will use current product and the layout you defined in Settings.

If you want to override layout, add a "layout" argument (available values are "minimal", "vertical", "horizontal"):

`
[wcsfwc layout="minimal"]
`

If you want to display the wash/care instructions outside a product page, or for another product, use "product" argument:

`
[wcsfwc product="123"]
`

In a .php file, use the `do_shortcode` function:

`
echo do_shortcode( '[wcsfwc]' );
`

== Hooks ==

* `wcsfw_display` (action): allows you to use your own display hook
* `wcsfw-data` (filter): allows you to modify symbols data and texts
* `wcsfw_below_short_desc_priority` (filter): allows you to change hook priority if symbols doesn't appear in the right place when using *below short description* setting
* `wcsfw_custom_tab_priority` (filter): allows you to change tabs order when using *custom tab* layout

== How to Customize ==

**Remove hooks**

In order to remove hooks used by this plugin, you'll need to get plugin instance and pass it in an array inside the callback argument.
For example:

~~~php
$wcsfwc = WCSFWC\WashCareSymbolsForWooCommerce::get_instance();
remove_action( 'woocommerce_single_product_summary', [ $wcsfwc, 'below_short_desc_display' ], apply_filters( 'wcsfw_below_short_desc_priority', 21 ) );
remove_action( 'woocommerce_product_additional_information', [ $wcsfwc, 'additional_info_display' ] );
~~~

**Display wherever you want**

Here is what you'll need to use a custom hook to display instructions wherever you want on your product page:

~~~php
add_action('whatever_hook_you_want', function(){
    $wcsfwc = WCSFWC\WashCareSymbolsForWooCommerce::get_instance();
    $wcsfwc->additional_info_display();
});
~~~

= Resources =

* **WordPress Plugin:** [https://wordpress.org/plugins/wash-care-symbols-for-woocommerce](https://wordpress.org/plugins/wash-care-symbols-for-woocommerce)
* **GitHub Repository:** [https://github.com/CharlieEtienne/wash-care-symbols-for-woocommerce](https://github.com/CharlieEtienne/wash-care-symbols-for-woocommerce)
* **Support:** [https://github.com/CharlieEtienne/wash-care-symbols-for-woocommerce/issues](https://github.com/CharlieEtienne/wash-care-symbols-for-woocommerce/issues)

== Installation ==

1. Install this plugin either via the WordPress.org plugin directory, or by uploading the files to your server.
2. Activate the plugin.
3. That's it. You're ready to go! Please, refer to the Usage & Documentation section for examples and how-to information.

== Frequently Asked Questions ==

= Is this plugin completely free? =
Yes.

= Can I use this plugin for commercial purposes? =
Sure, go ahead! It is completely open source.
If you like my work, you can donate here: [https://paypal.me/webnancy](https://paypal.me/webnancy)

= Is it compatible with Elementor Page Builder? =
Yes.

= How can I say thank you? =
If you like my work, you can donate here: [https://paypal.me/webnancy](https://paypal.me/webnancy)

== Screenshots ==

1. Product page
2. Product edit in administration

== Changelog ==

= 4.2.0 =
* Make plugin compatible with WooCommerce HPOS

= 4.1.0 =
* [FIX] Fix tooltip overlap in some cases
* [FIX] Fix tooltip being hidden in elementor in some cases
* [FIX] Make method static (https://wordpress.org/support/topic/wordpress-backend-throws-error-on-wash-care-plugin-category-level-enabling/)

= 4.0.0 =
* Major update, with rewrite of most of plugin's code. 
* **We can now display wash/care symbols with the `[wcsfwc]` shortcode!** See the Shortcode section of the docs for more details.

= 3.1.0 =
* **We can now display wash/care symbols in a custom tab!** Just go in settings and set position to "In custom tab"
* A new hook has been added: `wcsfw_custom_tab_priority`. It allows you to change tabs order.

= 3.0.0 =
* **We can now choose wash/care symbols on category level!** This setting can be overrided in each individual product.

= 2.7.0 =
* Adds a setting option to choose icons size

= 2.6.0 =
* **We now have symbols in admin too!** Gets rid of selectWoo on WCSFW fields and loads a modified copy of select2.js in order to add symbols in dropdowns and selected options, which is not possible with selectWoo since v1.07 (see https://github.com/woocommerce/selectWoo/issues/39)
* Move to Singleton pattern to let other developpers unhook actions or filters. If you want to unhook something, use it like this, for example: `remove_filter( 'hook_name', [ WashCareSymbolsForWooCommerce::get_instance(), 'method_name' ] );`

= 2.5.0 =
* Improve LocoTranslate compatibility: fix wrong domain path in .pot filename
* Update .pot file with new strings
* Improve themes compatibility: fix too large symbols on some themes
* Trying to improve WPML compatibility: in progress...

= 2.4.0 =
* Adds a setting option to display symbols below short description

= 2.3.0 =
* Adds 10 new symbols for professional cleaning:
  - Dry clean, hydrocarbon solvent only (HCS)
  - Gentle cleaning with hydrocarbon sovents (HCS)
  - Very gentle cleaning with hydrocarbon sovents (HCS)
  - Dry clean, tetrachloroethylene only (PCE)
  - Gentle cleaning with tetrachloroethylene (PCE)
  - Very gentle cleaning with tetrachloroethylene (PCE)
  - Wet clean
  - Gentle wet cleaning
  - Very gentle wet cleaning
  - Professionnal wet cleaning is not allowed

= 2.2.2 =
* Fix translation

= 2.2.1 =
* You can now choose between Horizontal/Vertical/Minimal layouts

= 2.2.0 =
* Added "vertical" mode