=== Secure Your Admin ===
Contributors: k2klettern
Tags: wp-admin, admin, login, secure, hash, wp-login, logged, hide
Requires at least: 4.0
Tested up to: 4.6.1
Stable tag: 0.1.0
License: GPLv2 or later

Generate an extra variable to secure your wp-admin access thru a simple variable name & hash passed in the URL

== Description ==

Generate an extra variable to protect and bypass access to wp-admin or wp-login with a simple extra variable that you may set in the admin page.

Major features in secure_uradmin include:

* You can enable really easy with a on / off button
* You can set the name of your Variable
* You can set the name of your hash
* Your hash will be saved using wp_hash_password 16 round encryption

P.D.: After you enable and set the varname & hash you will need to add them to your wp-admin login url; wp-admin?yourvarname=yourhash

== Installation ==

Upload the secure-uradmin plugin to your blog, Activate it, then enter your varname and hashname in settings, enable it, and you got it.

1, 2, 3: You're done!


== Changelog ==

= 0.1.0 =
*Release Date - 20th September, 2016*

* First Release