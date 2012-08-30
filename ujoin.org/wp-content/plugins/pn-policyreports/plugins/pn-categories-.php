<?PHP
/*
Plugin Name: Cycles administrator
Plugin URI: http://wordpress.org/#
Description: Manage sponsor categories.
Author: Tangamampilia
Version: 1.0
Author URI: http://www.tangamampilia.net/
*/
error_reporting(E_ALL);
//ini_set("display_errors", true);

if (!class_exists("pn_tables")) include("class.pn_tables.php");
	
add_action( 'admin_menu', 'pn_cycles_check_installed' );
add_action('admin_menu', 'pn_cycles_plugin_menu');	

function pn_cycles_check_installed() {	

	global $wpdb;			
	
	
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_cycles` (
					`id` int(11) NOT NULL auto_increment,
					`title` varchar(50) default NULL,
  					PRIMARY KEY  (`id`)
										) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 
					
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_form_category` (
					`id` int(8) NOT NULL auto_increment,
					`title` varchar(100) NOT NULL,
					PRIMARY KEY  (`id`)
										) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 	
										

}

function pn_cycles_plugin_menu() {
  add_options_page('Cycles & Categories', 'Cycles & Categories', 'administrator', 'pn-cycles', 'pn_cycles_plugin_options');
}

function pn_cycles_plugin_options () {	
	global $wpdb;
	global $pn_tables;
	
	
	if (isset($_POST['add'])) {
		$sql = "INSERT INTO ".$_POST['type']." VALUES (NULL, '".$_POST['title']."')";
		
			echo $sql;
		print_r($_POST);
		
		$wpdb->query($sql);
	}
	
	if (isset($_POST['edit'])) {
		$sql = "UPDATE ".$_POST['type']." SET title = '".$_POST['title']."' WHERE id = '".$_POST['edit']."'";
	
		
		$wpdb->query($sql);
	}
	
	if (isset($_POST['delete'])) {		
		$sql = "DELETE FROM ".$_POST['type']." WHERE id IN (".$_POST['delete'].")";
		$wpdb->query($sql);				
	}
			
		
	$tpl = file_get_contents(ABSPATH . 'wp-content/plugins/pn-cycles/pn-cycles.tpl');
	
	$result = $wpdb->get_results( "SELECT *, 'pn_cycles' FROM $pn_tables->cycle" );
	$row = array();
	foreach ($result as $data) {			
		$row [] = '
		<tr class="thead">
			<td scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" value="'.$data->id.'"/></td>
			<td scope="col" class="manage-column" style="">'.$data->title.'</td>
			<td scope="col" class="manage-column edit-buttons" style="">
				<a href="#edit" class="button edit">Edit</a> 
				<a href="#delete" class="button delete">Delete</a> 
				<input type="hidden" value='."'".json_encode($data)."'".' />
			</td>
		</tr>';		
	}
	
	
	$result_cats = $wpdb->get_results( "SELECT *, 'pn_form_category' FROM $pn_tables->form_category" );
	$cats = array();
	foreach ($result_cats as $data) {			
		$cats [] = '
		<tr class="thead">
			<td scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" value="'.$data->id.'"/></td>
			<td scope="col" class="manage-column" style="">'.$data->title.'</td>
			<td scope="col" class="manage-column edit-buttons" style="">
				<a href="#edit" class="button edit">Edit</a> 
				<a href="#delete" class="button delete">Delete</a> 
				<input type="hidden" value='."'".json_encode($data)."'".' />
			</td>
		</tr>';		
	}
	
	
	$message = "";
	$tpl = str_replace("[STRRESULT]", join("", $row), $tpl);
	$tpl = str_replace("[STRRESULT1]", join("", $cats), $tpl);
	
	if (isset($_POST['add']) || isset($_POST['edit'])) {
		$message = "<div class='update-nag'>Saved</div>";
	}
	
	$tpl = str_replace("[STRMESSAGE]", $message, $tpl);	
	
	print($tpl);	
}

?>