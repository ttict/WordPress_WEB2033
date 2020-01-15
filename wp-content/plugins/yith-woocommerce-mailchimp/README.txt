=== YITH WooCommerce Mailchimp ===

Contributors: yithemes
Tags: mailchimp, woocommerce, checkout, themes, yit, e-commerce, shop, newsletter, subscribe, subscription, marketing, signup, order, email, mailchimp for wordpress, mailchimp for wp, mailchimp signup, mailchimp subscribe, newsletter, newsletter subscribe, newsletter checkbox, double optin
Requires at least: 4.0
Tested up to: 5.2
Stable tag: 2.1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Integrate MailChimp into your e-commerce shop to manage users' subscription directly from your store.
WooCommerce 3.6.x compatible.


== Description ==

Get perfect integration of MailChimp into your e-commerce. An opportunity to let you benefit from all advantages that an email marketing service provider offers, so that you can manage contacts from your shop in an easy and almost automatic way and create specific campaigns for your target customers. The more targeted and specific campaigns are conceived, the higher is conversion rate of your email campaign. With YITH WooCommerce MailChimp you can manage users’ subscriptions directly from your e-commerce.

= Features: =

* Customers' subscription to a specific list in MailChimp:
* Subscription can be either automatic or require customer's consent in checkout page.
* Subscription can be either made when order is placed or when order is completed.

== Installation ==

1. Unzip the downloaded zip file.
2. Upload the plugin folder into the `wp-content/plugins/` directory of your WordPress site.
3. Activate `YITH WooCommerce Mailchimp` from Plugins page

YITH WooCommerce Mailchimp will add a new submenu called "Mailchimp" under "YIT Plugins" menu. Here you are able to configure all the plugin settings.

== Frequently Asked Questions ==

= Where can I find my API key =

You just have to register on mailchimp.com and visit the following [page](http://admin.mailchimp.com/account/api/ "Account page")

= Is it possible to subscribe users automatically? =

Sure, you just have to select the list in which you want to register the users, and deactivate the visualization of the "newsletter subscription" checkbox.

= Is it possible to subscribe users at the "order complete" stage? =

Sure, you just have to select the voice "Order completed" in the "Register after" option.

= I can't see my list in the dedicated list table =

Try to press the "Update lists" button near the select

== Screenshots ==

1. The YITH WooCommerce Mailchimp settings page (integration)
2. The YITH WooCommerce Mailchimp settings page (checkout)
3. Checkout page with "Newsletter subscription" checkbox

== Changelog ==

= 2.1.2 - Released: Jun, 13 - 2019 =

* Update: internal plugin framework

= 2.1.1 - Released: Apr, 23 - 2019 =

* Update: internal plugin framework

= 2.1.0 - Released: Apr, 10 - 2019 =

* New: WooCommerce 3.6 support
* Tweak: improved Mailchimp class inclusion
* Update: internal plugin framework
* Update: Italian language
* Update: Spanish language
* Update: Dutch language

= 2.0.0 - Released: Feb, 07 - 2019 =

* New: WooCommerce 3.5.4 support
* New: support to MailChimp API 3.0
* Update: internal plugin framework
* Tweak: reviewed method that performs API calls

= 1.1.5 - Released: Oct, 24 - 2018 =

* New: WooCommerce 3.5 support
* Tweak: updated plugin framework

= 1.1.4 - Released: Oct, 16 - 2018 =

* New: WooCommerce 3.5-rc support
* New: WordPress 4.9.8 support
* Tweak: updated plugin framework
* Update: Italian language
* Fix: possible Fatal Error during checkout

= 1.1.3 - Released: May, 28 - 2018 =

* New: WooCommerce 3.4 compatibility
* New: WordPress 4.9.6 compatibility
* New: updated plugin framework
* New: GDPR compliance
* Update: Italian language

= 1.1.2 - Released: Feb, 01 - 2018 =

* New: WooCommerce 3.3.0 support
* New: update internal plugin-fw
* New: added Dutch translation

= 1.1.1 - Released: Oct, 25 - 2017 =

* New: WooCommerce 3.2.1 support
* New: WordPress 4.8.2 support
* New: update internal plugin-fw
* Tweak: avoided double form handler execution, adding return false at the end of handler
* Dev: created subscribe wrapper for subscription process and refactored code
* Dev: moved cachable requests init to init hook, to let third party code filter them

= 1.1.0 - Released: May, 05 - 2017 =

* Add: WooCommerce 3.0.x compatibility
* Add: WordPress 4.7.4 compatibility

= 1.0.9 - Released: Nov, 28 - 2016 =

* Add: spanish translation
* Add: italian translation
* Tweak: changed text domain to yith-woocommerce-mailchimp
* Tweak: updated plugin-fw version

= 1.0.8 - Released: Jun, 13 - 2016 =

* Added: WooCommerce 2.6-RC1 support
* Tweak: improved performance with last plugin-fw version

= 1.0.7 - Released: Apr, 26 - 2016 =

* Fixed: warnings related to partial plugin.fw on wp.org repo

= 1.0.6 - Released: Apr, 12 - 2016 =

* Added: WooCommerce 2.5.5 compatibility
* Added: WordPress 4.5 compatibility
* Tweak: Updated internal plugin-fw
* Fixed: lists/list call now retrieves all lists, and not only first page
* Fixed: checkout checkbox position option, causing unexpected results

= 1.0.5 - Released: Dec, 14 - 2015 =

* Added: check over MailChimp class existence, to avoid Fatal Error with other plugins including that class
* Added: MailChimp error translation via .po archives
* Tweak: improved plugin import procedure
* Tweak: Updated internal plugin-fw

= 1.0.4 - Released: Oct, 23 - 2015 =

* Tweak: Performance improved with new plugin core 2.0

= 1.0.3 - Released: Aug, 12 - 2015 =

* Added: Compatibility with WC 2.4.2
* Tweak: Updated internal plugin-fw

= 1.0.2 - Released: May, 04 - 2015 =

* Added: WP 4.2.1 support
* Fixed: "Plugin Documentation" appearing on all plugins
* Fixed: various minor bug

= 1.0.1 - Released: Apr, 20 - 2015 =

* Added: delete key-related options/transient when key changed
* Tweak: string revision
* Fixed: various minor bug

= 1.0.0 - Released: Mar, 26 - 2015 =

* Initial release

== Suggestions ==

If you have suggestions about how to improve YITH WooCommerce Mailchimp, you can [write us](mailto:plugins@yithemes.com "Your Inspiration Themes") so we can bundle them into YITH WooCommerce Mailchimp.

== Translators ==

= Available Languages =
* English (Default)
* Italian
* Spanish

Need to translate this plugin into your own language? You can contribute to its translation from [this page](https://translate.wordpress.org/projects/wp-plugins/yith-woocommerce-mailchimp "Translating WordPress").
Your help is precious! Thanks

== Documentation ==

Full documentation is available [here](http://yithemes.com/docs-plugins/yith-woocommerce-mailchimp).

== Upgrade notice ==

= 2.1.1 - Released: Apr, 23 - 2019 =

* Update: internal plugin framework