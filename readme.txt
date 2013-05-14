=== WP Reroute Email ===
Contributors: msh134
Tags: mail, email
Requires at least: 2.2.3
Tested up to: 3.5.1
Stable tag: 1.0.0
License: GPLv2 or later

This plugin reroutes all outgoing emails from a WordPress site (sent using the wp_mail() function) to a predefined configurable email address.

== Description ==

This plugin intercepts all outgoing emails from a WordPress site, sent using the wp_mail() function, and reroutes them to a predefined configurable email address. This is useful in case where you do not want email sent from a WordPress site to reach the users. For an example, to resolve an issue you downloaded production database to your development site and you want no email is sent to production users when testing. You may enable this plugin in development server and reroute emails to your given email address.

Any issue? Contact me (http://sajjadhossain.com/contact-me/).


== Installation ==

1. Upload `wp-reroute-email` folder to the plugins directory (`/wp-content/plugins/`).
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to Settings > WP Reroute Email settings page and modify the settings.