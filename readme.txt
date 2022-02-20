=== Wash Care Symbols for WooCommerce ===
Contributors: charlieetienne
Tags: woocommerce, wash, care, symbols, clothes
Stable tag: 2.5.0
Requires at least: 5.2
Tested up to: 5.9
Requires PHP: 7.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Donate Link: https://paypal.me/webnancy

Display wash/care symbols in WooCommerce products.

== Description ==

Display wash/care symbols in WooCommerce products.

== Usage & Documentation ==

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

* **Position:** Inside "Additional Information"(default) / below short description (added in 2.4).
* **Layout:** Horizontal/Vertical/Minimal (added in 2.2).

== Hooks ==

* `wcsfw_display` (action): allows you to use your own display hook
* `wcsfw-data` (filter): allows you modify symbols data and texts
* `wcsfw_below_short_desc_priority` (filter): allows you to change hook priority if symbols doesn't appear in the right place when using *below short description* setting

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

== Screenshots ==

1. Product page
2. Product edit in administration

== Changelog ==

= 2.5.0 =
* Improve LocoTranslate compatibility: fix wrong domain path in .pot filename
* Update .pot file with new strings
* Improve themes compatibility: fix too large symbols on some themes
* Trying to improve WPML compatibility: in progress...

= 2.4.0 =
* Adds an setting option to display symbols below short description

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