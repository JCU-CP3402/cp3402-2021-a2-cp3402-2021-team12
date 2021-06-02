=== Maintenance ===
Contributors: WebFactory
Tags: maintenance, maintenance mode, maintenance page, coming soon, coming soon page, under construction, under construction page
Requires at least: 4.0
Tested up to: 5.7
Stable tag: 4.02
Requires PHP: 5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Great looking maintenance, coming soon & under construction pages. Put your site under maintenance in minutes.

== Description ==

Maintenance plugin allows the WordPress site administrator to close the website for maintenance, enable "503 Service temporarily unavailable”, set a temporary page with authorization, which can be edited via the plugin settings. Easy customize the good look on all devices. Add your logo, background image, select the desired color, add text.

Need **200+ pre-made themes** to build coming soon & landing pages faster? Have a look at our <a href="https://comingsoonwp.com/">Coming Soon & Maintenance Mode</a> plugin.

Let <a href="https://wordpress.org/plugins/security-ninja/">Security Ninja</a> take care of your site's security from day one! Run over 50 security tests with one click. Get a detailed report and automatically fix security issues.


<h3>Features</h3>
<ul>
<li>retina ready HTML/CSS layout</li>
<li>Full-screen background (<a target="_blank" href="https://github.com/srobbin/jquery-backstretch">Backstretch</a>)</li>
<li>Blur background effect</li>
<li>Upload your own logo</li>
<li>Configurable colors: fonts, icons, background</li>
<li>Customize title, headline, text</li>
<li>User login on frontend</li>
<li>Admin bar status</li>
<li>503 error on/off</li>
<li>Google analytics support</li>
<li>Exclude selected pages from Maintenance mode</li>
<li>Support for all popular caching plugins</li>
<li><i>mtnc_load_maintenance_page_for_this_user</i> filter for modifying show sees the maintenance page</li>
</ul>

<h3>Support</h3>
If you have any problems, questions or recommendations about WP Maintenance please open a ticket in the <a href="https://wordpress.org/support/plugin/maintenance/">official support forum</a>. We answer all questions within hours!
Want to say "thank you"? Please leave a <a href="http://wordpress.org/support/view/plugin-reviews/maintenance?filter=5">review</a>.

== Installation ==

Follow the usual routine;

1. Open WordPress admin, go to Plugins, click Add New
2. Enter "maintenance" in search and hit Enter
3. Locate the Maintenance plugin by searching for our mascot, click "Install Now"
4. Activate & open plugin's settings page located in the main WP admin menu

Or if needed, upload manually;

1. Download the plugin.
2. Unzip it and upload to _/wp-content/plugins/_
3. Open WordPress admin - Plugins and click "Activate" next to the plugin
4. Activate & open plugin's settings page located in the main WP admin menu


== Screenshots ==
1. Maintenance page with default design
2. Log in form is built into the maintenance page
3. Maintenance plugin options page


== Frequently Asked Questions ==

= I have activated plugin and don’t see any changes, looks like plugin is not working. =

Try to check in different browser. If you a logged as WordPress user you see the website in normal mode.

= Will my site remain visible to search engines while maintenance mode is on? =

The site will not be visible to search engines only if "503 Service Temporarily Unavailable" option is enabled.

= Where can I find out the username and password to get to the site? =

You can use your "normal" WP administrator access or create a new user in WordPress dashboard - Users.

= If I incorrectly write a login and password I will see the error on the page wp-login? =

No, it will be display error on current maintenance page, without redirect to wp-login page.

= I haven’t found an answer to my question, what should I do? =

Please post the question on the <a href="http://wordpress.org/support/plugin/maintenance">support forum</a>.


== Changelog ==

= v4.02 =
- 2021/03/06
- JS fixes on frontend
- Contact Form 7 conflict fix

= v4.01 =
- 2021/02/20
- added support for Cache Enabler plugin
- fixed a bug when background image isn't defined
- fixed issue on sites with large numbers of posts/pages/CPTs

= v4.0 =
- 2021/01/30
- added flyout menu
- added mtnc_load_maintenance_page_for_this_user filter

= v3.99 =
- 2021/01/13
- minor fixes
- removed promo for WP 301 Redirects

= v3.97 =
- 2020/10/02
- minor fixes
- added promo for WP 301 Redirects

= v3.96 =
- 2020/08/19
- "headers already sent" bug fixed

= v3.95 =
- 2020/08/14
- bug fixes for WP v5.5

= v3.90 =
- 2020/05/30
- bug fixes
- removed integration with Amelia Booking
- added support for WP Rocket Cache plugin
- fixed blur issue

= v3.85 =
- 2019/11/28
- bug fixes
- added integration with Amelia Booking
- added support for Hummingbird Cache plugin

= v3.80 =
- 2019/09/25
- numerous bug fixes
- added preview button
- 400,000 installations; 3,790,000 downloads

= 3.7.1 =
- Bug fix: Restored admin bar notification
- Bug fix: Preview mode
- Update: Translations

= 3.7.0 =
- Improvement: Code optimization

= 3.6.4 =
- Improvement: Code optimization
- Update: Removed 'Show admin bar' option
- Update: Removed statistic
- Update: Removed subscription
- Update: Translations

= 3.6.3 =
- Bug fix: Deactivated statistics

= 3.6.2 =
- New: Added option to switch sound on video
- New: Added child theme support
- New: Added statistics
- Update: Updated translations
- Bug fix: background color for login form

= 3.6.1 =
- Improvement: setting max width logo size
- Bug fix: Change template_include hook priority
- Bug fix: Fix container height
- Bug fix: logo size cropping
- Bug fix: fonts subsets fix

= 3.6 =
- Update: Optimized js libs
- Update: Replaced some features by new css and html5 capabilities
- Update: Refreshed google fonts
- New: Change preloader icon in admin panel
- New: Uploading image for portrait device orientation
- New: Add authorization error text to login panel
- New: Select login panel bg color
- New: Add some css effects

= 3.5.1 =
- Bugfix: Js cache with server options
- Bugfix: bg default color
- Optimization: Fonts load
- Optimization: PageSpeed 90/96

= 3.5 =
* Optimization: Plugin speed optimization
* Bugfix: Clear js cache

= 3.4.2 =
* Optimization: Plugin speed optimization (Google PageSpeed 95)
* Tested up to: Wordpress 4.8

= 3.4.1 =
* Bug fix: Return original template if mode is off

= 3.4 =
* Improvements: WP Hide & Security plugin compatible
* Bug fix: Update localization files
* Bug fix: Subset fonts
* Bug fix: Permission access by user role
* Bug fix: Remove deprecated function getimagesize

= 3.3 =
* New: Add og meta content
* New: Default site title
* Update: WordPress 4.7.1
* Bug fix: Add function not filter to add paragraph

= 3.2 =
* New: Hungarian translation
* New: Persian translation
* New: Swedish translation
* Updated: German translation
* Updated: Russian translation
* Updated: Google Analytics script
* Improvements: Get icons from CDN's
* Improvements: Description tinymce textarea
* Bug fix: Exclude pages - display only !empty post types
* Bug fix: function wpcf7_ajax_loader()

= 3.1.1 =
* Improvements: Google fonts - Add font: Martel Sans
* Updated: Chinese(zh_CN) translation
* Bug fix: Relative reference for google fonts
* Bug fix: Meta title output
* Bug fix: Meta description output

= 3.1 =
* New: Meta description
* Improvements: Descriptions for fields
* Improvements: Added check for ssl
* Improvements: link from footer removed
* Bug fix: Plugin Inspector call this UNSAFE
* Bug fix: changed call to the function mt_clear_cache
* Bug fix: Grammatical mistakes
* Bug fix: Standart background image loading, after update to WordPress 4.6
* Bug fix: Subsets problem with js
* Bug fix: Bugfix googlefonts.json missed problem
* Update: Translation files

= 3.0 =
* New: Additional Save changes button
* Update: Translation files
* Update: Core for maintenance PRO
* Bug fix: Lost password link

= 2.7.1 =
* Update: Language files
* Bug fix: Default values and checkbox changes in preferences
* Bug fix: Lost password link if WooCommerce exist

= 2.7 =
* New: Google fonts subsets
* New: WP Super Cache support
* New: WP Total Cache support
* New: Retina logo
* New: Logo width and height fields
* New: uninstal.php
* Update: WordPress 4.4.2 support
* Improvements: Responsive version
* Improvements: Time format
* Bug fix: Maintenance not working on French Language


= 2.6 =
* Update: WordPress 4.4 support
* Update: translation files
* New: Meta fields for sharing
* Bug fix: callback function to uninstall hook
* Bug fix: save content and settings if plugin disabled
* Bug fix: if footer text is empty not showing text

= 2.5 =
* New: French translation
* Update: WordPress 4.3 support
* Bug fix: Footer and social media icons for mobiles
* Bug fix: Exclude pages now by post id
* Bug fix: Check exclude pages with empty reading options

= 2.4 =
* New option: Footer text
* Improvements: Exclude / Include pages
* Improvements: CSS optimization
* Translation updates

= 2.3 =
* New: Enable maintenance mode for specific pages
* Bug fix: Lost password
* Bug fix: password format with symbols
* Improvements: CSS optimization

= 2.2.1 =
* New: default background image
* Improvements: blur off by default
* Bug fix: Label styles

= 2.2 =
* New options: Custom css
* New options: Font family
* New login form
* Improvements: Responsive version
* Bug fix: PHP 5.2 support

= 2.1.2 =
* New translation Deutch (de_DE)
* New translation Finnish (fi_FI)
* Bug fix: Google analytics field.

= 2.1.1 =
* Content alignment fix
* Added scroll for extra height
* Translation updates

= 2.1 =
* New option Login on/off
* New option Google Analytics field
* Responsive bug fix

= 2.0.1 =
* New translation Brazilian Portuguese
* Bug fix in title
* Bug fix blur background image scroll


= 2.0 =
* New features
* New PRO version
* New design
* New dashboard
* Core plugin changes
* Backstretch fullscreen background
* Blur background effect
* 503 error switcher

= 1.2.3 =
* Wordpress 3.6 support
* Bug fix
* Warning Messages, open_basedir conflict - resolved.

= 1.2.2 =
* Re-directed user to the root of the doman (not to subdirectory).
* Bugfix, Notice in dasboard with debug mode.

= 1.2.1 =
* Admin bar bug fix
* Css fix

= 1.2 =
* Translation ready
* Add Russian language
* Add option for display admin bar
* Css fixes for WP 3.5

= 1.1.1 =
*Css fixes

= 1.1 =
* Any logo images will be in center of page
* Lastpass fields corrected width
* Bug fixes

= 1.0 =
* initial release

== Upgrade Notice ==
