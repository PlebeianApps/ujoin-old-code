<?PHP
/*
Plugin Name: Policy Ninja administrator
Plugin URI: http://wordpress.org/#
Description: Admin policy ninja content.
Author: Tangamampilia
Version: 1.0
Author URI: http://www.tangamampilia.net/
*/
error_reporting(E_ALL);
//ini_set("display_errors", true);
//ini_set("display_errors", true);
	
if (!class_exists("pn_tables")) include("class.pn_tables.php");	

	
//add_action( 'admin_menu', 'pn_bills_check_installed' );
add_action('admin_menu', 'pn_policyreports_plugin_menu');	

function pn_policyreports_check_installed() {	
	global $wpdb;
	include_once("plugins/check_installed.php");
								
}

function pn_policyreports_plugin_menu() {

/*
	add_menu_page('Bills', 'Policy Reports', 'manage_options', 'pn-bills' );
    add_submenu_page('pn-bills', "Bills", "Bills", 'manage_options', 'pn-bills', 'pn_bills_plugin_options');
    add_submenu_page('pn-bills', "Committee", "Committee", 'manage_options', 'pn-committee', 'pn_committee_plugin_options');
    add_submenu_page('pn-bills', "Cycles", "Cycles", 'manage_options', 'pn-cycles', 'pn_cycles_plugin_options');
    add_submenu_page('pn-bills', "Legislators", "Legislators", 'manage_options', 'pn-legislators', 'pn_legislators_plugin_options');
    add_submenu_page('pn-bills', "Categories", "Categories", 'manage_options', 'pn-categories', 'pn_categories_plugin_options');
    add_submenu_page('pn-bills', "Users", "Users", 'manage_options', 'pn-users', 'pn_users_plugin_options');
*/

	add_menu_page('Committee', 'Policy Reports', 'manage_options', 'pn-sim', 'pn_committee_plugin_options');
//  add_submenu_page('pn-bills', "Bills", "Bills", 'manage_options', 'pn-bills', 'pn_bills_plugin_options');
    add_submenu_page('pn-sim', "Committee", "Committee", 'manage_options', 'pn-committee', 'pn_committee_plugin_options');
    add_submenu_page('pn-sim', "Cycles", "Cycles", 'manage_options', 'pn-cycles', 'pn_cycles_plugin_options');
    add_submenu_page('pn-sim', "Legislators", "Legislators", 'manage_options', 'pn-legislators', 'pn_legislators_plugin_options');
    add_submenu_page('pn-sim', "Categories", "Categories", 'manage_options', 'pn-categories', 'pn_categories_plugin_options');
    add_submenu_page('pn-sim', "Users", "Users", 'manage_options', 'pn-users', 'pn_users_plugin_options');	
}

function pn_bills_plugin_options(){
	ini_set("display_errors", true);
	include("plugins/pn-bills.php");
	init_pn_plugin();
}

function pn_committee_plugin_options(){
	include("plugins/pn-committee.php");
	init_pn_plugin();
}

function pn_cycles_plugin_options(){
	include("plugins/pn-cycles.php");
	init_pn_plugin();
}

function pn_legislators_plugin_options(){
	ini_set("display_errors", true);
	include("plugins/pn-legislators.php");
	init_pn_plugin();
}

function pn_categories_plugin_options(){
	include("plugins/pn-categories.php");
	init_pn_plugin();
}

function pn_users_plugin_options(){
	ini_set("display_errors", true);
	include("plugins/pn-users.php");
	init_pn_plugin();
}


?>