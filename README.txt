=== Product Availability Checker ===
Contributors: jordiplana
Donate link: https://jordiplana.com/donate.html
Tags: amazon, azon, affiliates, api, links, product, stock, availability, checker, scanner, validator
Requires at least: 3.0.1
Requires PHP: 5.5
Tested up to: 5.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Check your site for Amazon Affiliate's links to products that are out of stock. Stop sending your visitors to products that are no longer available!

== Description ==

Keep your website up-to-date with affiliate links pointing to products that can be purchased. Don't leave behind old Amazon links pointing to out of stock or unavailable products.

This simple plugin will scan your website for links pointing to Amazon marketplace, extract the [ASIN](https://www.amazon.com/gp/seller/asin-upc-isbn-info.html) and check it against the [Product Advertising API](https://webservices.amazon.com/paapi5/documentation/) to see if it is still in stock, and can be purchased.

_It's time to get rid of junk links and increase revenue._

Cover photo by [Brooke Lark](https://unsplash.com/@brookelark?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText)

== Installation ==

1. Upload `pac.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to Product Availability > Settings and configure your Amazon Product Avertising API v5 credentials
1. Click on Scan and Check and wait for the scanner to print out the results of products that are no longer available to buy

== Frequently Asked Questions ==

= How do I get credentials for the Amazon Product Advertising API? =

1. Register as an Amazon affiliate https://affiliate-program.amazon.com
1. Create Amazon Product Advertising API credentials https://affiliate-program.amazon.com/gp/flex/advertising/api/sign-in.html

= Does the plugin work with cloaked links? =

On the current version the plugin only works with links containing the amazon domains and the product ASIN . If you don't know how to find a product ASIN please check the following link: https://www.oreilly.com/library/view/amazon-hacks/0596005423/ch01s03.html

= The scanner is showing products out of stock but when I follow the link to Amazon I see they are available. What's going on? =

Lots of vendors redirect old out-of-stock products to a newer, or alternative, version. In order to check if the plugin reported a false positive you should compare the ASIN you're linking to, and the ASIN displayed on Amazon under the Product Details section.

= How can I request a feature to be included in future versions of the plugin? =

Feedback is always welcome, please start a thread in the Wordpress.org plugin support forum.

== Screenshots ==

1. Amazon Product Advertising API Settings
2. Scan result example

== Changelog ==

= 1.1.0 =

- Add compatibility with Amazon Shortlinks (amzn.to / amazn.com).
- Add Start/Stop scanning button.
- Scanner styling and UX.
- Last scan timestamp.
- Add settings shortcut on plugins page.

= 1.0.0 =

- Initial release :)

== Upgrade Notice ==

= 1.0.0 =

- N/A
