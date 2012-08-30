<?php
/*
Plugin Name: Backend User Restrictor
Plugin URI: http://www.lloydengland.com/
Description: Blanket backend restriction for users who are not administators. Users are still able to access their profiles or whichever paths are specified. Also supports https connections.
Version: 1.1
Author: Lloyd England
Author URI: http://www.lloydengland.com/
Contributors: Dustin Vietzke

Copyright 2010  Lloyd England  (email : lloyd@lloydengland.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
 
add_action('admin_init', 'bur_plugin_enforceRestriction');

function bur_plugin_enforceRestriction() {
	global $current_user;
	if (current_user_can('manage_options')) { }
	else{
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80"):
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		else: 
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		endif;
	
		// allowed path(s)
		if ($pageURL == site_url()."/wp-admin/profile.php" && false){
		}else{
			header("Location:".get_bloginfo('url')."/your-profile");
		}
	}
}

?>
