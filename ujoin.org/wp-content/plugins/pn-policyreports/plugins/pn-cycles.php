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


function init_pn_plugin () {	
	global $wpdb;
	global $pn_tables;
	
	
	if (isset($_POST['add'])) {
		$sql = "INSERT INTO $pn_tables->cycle VALUES (NULL, '".$_POST['title']."')";		
		$wpdb->query($sql);
	}
	
	if (isset($_POST['edit'])) {
		$sql = "UPDATE $pn_tables->cycle SET title = '".$_POST['title']."' WHERE id = '".$_POST['edit']."'";
	
		
		$wpdb->query($sql);
	}
	
	if (isset($_POST['delete'])) {		
		$sql = "DELETE FROM $pn_tables->cycle WHERE id IN (".$_POST['delete'].")";
		$wpdb->query($sql);				
	}
			
		
	$tpl = file_get_contents(ABSPATH . 'wp-content/plugins/pn-policyreports/plugins/pn-cycles.tpl');
	if (isset($_GET['o'])) $o = explode(",", $_GET['o']);
	else $o = array("title", "0");	
	
	$result = $wpdb->get_results( "SELECT * FROM $pn_tables->cycle ORDER BY ".$o[0]." ".($o[1] == 1 ? "ASC" : "DESC")."" );
		
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
		
	
	$message = "";
	$tpl = str_replace("[STRRESULT]", join("", $row), $tpl);
	
	if (isset($_POST['add']) || isset($_POST['edit'])) {
		$message = "<div class='update-nag'>Saved</div>";
	}
	
	$tpl = str_replace("[STRMESSAGE]", $message, $tpl);	
	$tpl = str_replace("[ORDER]", $o[1] == "1" ? "0" : "1", $tpl);	
	
	print($tpl);	
}

?>