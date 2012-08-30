=== Backend User Restrictor ===
Contributors: lloydengland
Donate link: http://www.lloydengland.com/
Tags: restrict, backend, redirect, permissions, administration
Requires at least: 2.7
Tested up to: 3.0
Stable tag: 1.1

Provides a blanket restriction which prevents users who are not admistrators from accessing any part of the WordPress backend except for their profiles.

== Description ==

This plugin provides a blanket restriction which prevents users who are not admistrators from accessing any part of the WordPress backend except for their profiles or any other specified page.

Contributors: Dustin Vietzke

== Installation ==

1. Upload `backend-user-restrictor.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Who does this prevent from accessing the backend? =

Every user who is not an administator

= Can the restricted users still access their profile? =

With version 1.1 Yes. If you don't want users to be able too, you should use version 1.0. 

== Changelog ==

= 1.1 =
* Updated to allow specified pages to be seen
* Accounts for https connections
* Tested upto Wordpress 3.0 Beta

= 1.0 =
* First version

== Upgrade Notice ==

= 1.1 =
You should upgrade to 1.1 if you want users to access specific backend pages - such as their profile pages, or if you site runs on a https connection.