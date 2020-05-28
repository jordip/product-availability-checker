=== Amazon Affiliate Product Availability Tracker ===
Contributors: productavailable
Donate link: https://www.productavailable.com
Tags: amazon, affiliates, product, stock, availability, tracker, scanner, validator
Requires at least: 3.0.1
Requires PHP: 5.5
Tested up to: 5.4.1
Stable tag: 1.4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Scans your Amazon Affiliate site for links to products that are out of stock, or no longer available.

== Description ==

### The #1 Amazon Affiliate Product Availability Tracker plugin

Keep your Amazon affiliate website healthy and maximize revenue. Don't leave behind old Amazon links pointing to out of stock or unavailable products.

This simple plugin will scan your website for affiliate links pointing to Amazon, extract the [ASIN](https://www.amazon.com/gp/seller/asin-upc-isbn-info.html) and check it against the [Amazon API](https://webservices.amazon.com/paapi5/documentation/) to determine if it is still in stock, and can be purchased.

#### Increase affiliate revenue

You may be sending traffic to products that can’t be purchased, missing sale opportunities. Fix your links and get back those sales commissions.

#### Keep content relevant

Finding out-of-stock products, and replacing them with newer versions, or alternatives, will keep your site’s content valid and relevant.

#### Product availability reports

Our plugin generates simple reports that will help you identify which posts need attention, and whose products link may no longer be in stock.

_It's time to get rid of junk links and increase revenue._

Cover photo by [Brooke Lark](https://unsplash.com/@brookelark?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText)

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/` directory
1. Activate the plugin through the `Plugins` menu in WordPress
1. Navigate to `Amazon Products > Settings` and configure your Amazon Product Avertising API v5 credentials
1. Navigate to `Amazon Products > Scan` to scan every post and page for Amazon products that are no longer available to buy

== Frequently Asked Questions ==

= How do I get credentials for the Amazon Product Advertising API? =

1. Register as an Amazon affiliate [https://affiliate-program.amazon.com](https://affiliate-program.amazon.com)
1. Create Amazon Product Advertising API credentials [https://affiliate-program.amazon.com/gp/flex/advertising/api/sign-in.html](https://affiliate-program.amazon.com/gp/flex/advertising/api/sign-in.html)

Official documentation: [https://webservices.amazon.com/paapi5/documentation/register-for-pa-api.html](https://webservices.amazon.com/paapi5/documentation/register-for-pa-api.html)

= Does the plugin work with cloaked links? =

On the current version the plugin only works with links containing the amazon domains and the product ASIN . If you don't know how to find a product ASIN please check the following link: [https://www.oreilly.com/library/view/amazon-hacks/0596005423/ch01s03.html](https://www.oreilly.com/library/view/amazon-hacks/0596005423/ch01s03.html)

= The scanner is showing products out of stock but when I follow the link to Amazon I see they are available. What's going on? =

Lots of vendors redirect old out-of-stock products to a newer, or alternative, version. In order to check if the plugin reported a false positive you should compare the ASIN you're linking to, and the ASIN displayed on Amazon under the Product Details section.

= I'm using a shortcodes to embed my Amazon affiliate product links, will the scanner pick it up? =

Yes, the plugin will scan the shortcodes output.

= Does the plugin work with Woocommerce? How about custom post types? And fields?

Currently the plugin does only scan posts and pages for body content. All the custom post types and other fields won't get scanned.

= If we have products from from multiple Amazon country sites (like .com and .in),  will this check availability for them?

The plugin uses your Amazon Product Advertising API to check for product availability. The requests sent to that API are determined by your affiliate's credentials, and thus results are specific to the country. 

= How can I request a feature to be included in future versions of the plugin? =

Feedback is always welcome, please start a thread in the Wordpress.org [plugin support forum](https://wordpress.org/support/plugin/product-availability-checker/).

== Screenshots ==

1. Scan result example
2. Report example
3. Amazon Product Advertising API Settings


== Changelog ==

= 1.4.3 =

- Bug fixes on the reports page.
- Compatibility with GeniusLink, Amazon Link Engine, EasyAzon, AzonPress, AAWP, Amazon Link and AmazonSimpleAdmin.

= 1.4.2 =

- Bug fixes for shortlink compatibility.

= 1.4.0 =

- Bug fixes.
- Improved scanner accuracy.
- Shortcuts in plugins page.

= 1.3.1 =

- Bug fix with vendor folder.

= 1.3.0 =

- New [official website](https://wwww.productavailable.com)
- Scan reports.
- Bug fixes.
- FAQs update.

= 1.2.0 =

- Add recheck functionality per post.
- Code standards formatting.
- UX improvements.

= 1.1.0 =

- Add compatibility with Amazon Shortlinks (amzn.to / amzn.com).
- Add Start/Stop scanning button.
- Scanner styling and UX.
- Last scan timestamp.
- Add settings shortcut on plugins page.

= 1.0.0 =

- Initial release :)

== Upgrade Notice ==

= 1.0.0 =

- N/A
