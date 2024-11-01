=== Youtube Activator ===
Tags: youtube, podcast, podcasting, audio, video, mp3, m4a, ogg, ogv, xspf
Contributors: WordpressAlpar
Requires at least: 2.2
Tested up to: 3.2.1

A plugin to change the status of Youtube Videos linked with Wordpress Posts / Podcasts


== Description ==

Based on the problematic, that no current tool on the market was able to cope with the simple task of chaning a videos status.

So what the plugin does, is to set a video to public, once its related wordpress post gets published.

Functionalities like this exist for Facebook, Twitter etc.

If you own a Podcast Blog and you do publish your Podcasts on Youtube, maybe this is an interesting Plugin if you would like 
to automate you publishing routine.

You just need to enter your credentials and API-Key at the top of the yt-activator.php and specify the ApplicationID as you set it at the Google Code Dashboard.

When setting a video public a mail is sent automatically to the admin.

This plugin was originally developed for http://www.omreport.de


== Changelog ==

= v1.1 = 
* new: Multiple Videos can be seperated by :

= v1.0 =
* new: Initial release


== Installation ==

If you have ever installed a plugin, then this will be pretty easy.

1. Extract the files. Copy the "podpress" directory into `/wp-content/plugins/`
1. Activate the plugin through the "Plugins" menu in WordPress
1. Configure the Feed/iTunes Settings and add eventually one of the podPress widgets to one of the sidebars (OR If you are using a WP version that is older than WP 2.5 and you want to add a link to itunes on your website then set the FeedID in the podPress options page, and then add this code in your template `<?php podPress_iTunesLink(); ?>`)

Details about all the optional_files are in optional_files/details.txt

= Requirements =

The plugin has been developed for Wordpress 3.2 but should run under all Wordpress versions after 2.2, cause it uses no special capabilities.

CustomFields should already be available in your Wordpress Version

= Included Software =


* ZendGdata Library


== Configuration ==

Just enter you Youtube credentials and the Google Code API Key in the variables of the yt-activator.php in the plugin directory.


== Notes ===

To faciliate best compatibility this plugin works by using the frequently tested and updated Zend_Gdata library.

If you have any problem with this plugin it would be wise to update this library, which resides in the same directory as the yt-activator.php
file.

The code for the plugin itself is very small and not really prone to errors, so any complications might likely occur due to changes on the Youtube API


