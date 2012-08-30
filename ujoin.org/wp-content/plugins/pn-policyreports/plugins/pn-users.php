<?PHP
/*
Plugin Name: User administrator
Plugin URI: http://wordpress.org/#
Description: Manage sponsor categories.
Author: Tangamampilia
Version: 1.0
Author URI: http://www.tangamampilia.net/
*/
error_reporting(E_ALL);
//ini_set("display_errors", true);
function init_pn_plugin () {	
	global $wpdb;
	global $pn_tables;
	
		
	if (isset($_POST['add'])) {
		$id = wp_create_user( $_POST['username'],$_POST['password'], $_POST['email'] );
		update_user_meta($id, 'first_name', $_POST['firstname']);
		update_user_meta($id, 'last_name', $_POST['lastname']);
	}
	
	
	
	if (isset($_POST['edit'])) {
		
		update_user_meta($_POST['edit'], 'first_name', $_POST['firstname']);
		update_user_meta($_POST['edit'], 'last_name', $_POST['lastname']);
		
		if (trim($_POST['password']) != "" && strlen($_POST['password']) > 2) {
			wp_update_user( array ('ID' => $_POST['edit'], 'user_pass' => $_POST['password']) );
		}
	}
	
	if (isset($_POST['delete'])) {	
		$del = explode(",", $_POST['delete']);
		for($x=0; $x<count($del); $x++) {
			if ($del[$x] == "1") continue;
			
			wp_delete_user($del[$x]);
		}
		
			
		//$sql = "DELETE FROM ".$wpdb->prefix."users WHERE ID IN (".$_POST['delete'].")";
		//$wpdb->query($sql);				
	}
		
	if (isset($_GET['p'])) $p = $_GET['p'];
	else $p = 1;	
	
	if (isset($_GET['o'])) $o = explode(",", $_GET['o']);
	else $o = array("user_login", "0");
	
	if (isset($_GET['s'])) $s = $_GET['s'];
	else $s = "";	
		
	$tpl = file_get_contents(ABSPATH . 'wp-content/plugins/pn-policyreports/plugins/pn-users.tpl');
	$result = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."users 
									WHERE (user_login LIKE '%".$s."%' OR user_email LIKE '%".$s."%')
									ORDER BY ".$o[0]." ".($o[1] == 1 ? "ASC" : "DESC")." LIMIT ".(($p - 1)*30).",30;" );
	
		
	$result_c = $wpdb->get_results( "SELECT CEIL(COUNT(id)/30) AS counter FROM ".$wpdb->prefix."users
									WHERE (user_login LIKE '%".$s."%' OR user_email LIKE '%".$s."%');" );
	foreach ($result_c as $data_c) $total = $data_c->counter; 
	
	$row = array();
		
	foreach ($result as $data) {			
		
		$userdata = array("username"=>$data->user_login, "email"=>$data->user_email, 
							"firstname"=>get_user_meta($data->ID, "first_name", true), "lastname"=>get_user_meta($data->ID, "last_name", true));
		
		$groupid = get_user_meta($data->ID, 'user_parent', true);

		
		
		$actions = array();
		
		
		$sql = "SELECT t.id, t.bill, b.title AS `name` 
					FROM $pn_tables->form_testimony t INNER JOIN wp_pn_bills_search_results b ON t.bill = b.id
        			WHERE t.wuid = $groupid AND t.status = 1;";     			
      	$testimony = $wpdb->get_results($sql, ARRAY_A);
      	foreach ($testimony as $data_t) $actions[] = array("title" => $data_t['name'], "type" => "Testimony", "url" => "/?p=201&letter=".$data_t['id']);
      	
      	
      	$sql = "SELECT t.id, t.title AS `name` FROM $pn_tables->form_petition t WHERE t.wuid = $groupid AND t.status = 1;";     			
      	$petition = $wpdb->get_results($sql, ARRAY_A);
      	foreach ($petition as $data_t) $actions[] = array("title" => $data_t['name'], "type" => "Petition", "url" => "/?p=209&letter=".$data_t['id']);
      	
      	
      	$sql = "SELECT t.id, t.title AS `name` FROM $pn_tables->form_letter t WHERE t.wuid = $groupid AND t.status = 1 AND type = 'letter';";     			
      	$letter = $wpdb->get_results($sql, ARRAY_A);
      	foreach ($letter as $data_t) $actions[] = array("title" => $data_t['name'], "type" => "Letter", "url" => "/?p=208&letter=".$data_t['id']);
      	
      	
      	$sql = "SELECT t.id, t.title AS `name` FROM $pn_tables->form_letter t WHERE t.wuid = $groupid AND t.status = 1 AND type = 'advocacy';";     			
      	$letter = $wpdb->get_results($sql, ARRAY_A);
      	foreach ($letter as $data_t) $actions[] = array("title" => $data_t['name'], "type" => "Advocacy", "url" => "/?p=211&letter=".$data_t['id']);
      	

 		$row [] = '
		<tr class="thead">
			<td scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" value="'.$data->ID.'"/></td>
			<td scope="col" class="manage-column" style="">'.$data->user_login.'</td>
			<td scope="col" class="manage-column" style="">'.$data->user_email.'</td>
			<td scope="col" class="manage-column" style="">'.get_user_meta($data->ID, "first_name", true).'</td>
			<td scope="col" class="manage-column" style="">'.get_user_meta($data->ID, "last_name", true).'</td>
			<td scope="col" class="manage-column" style="">'
				. ( get_user_meta($data->ID, "user_is_group", true) == "1" ? "Group admin" : "Group member").
			'</td>
			<td scope="col" class="manage-column edit-buttons" style="">
				<a href="#edit" class="button edit">Edit</a> 
				<a href="#delete" class="button delete">Delete</a> 
				<input type="hidden" value='."'".json_encode($userdata)."'".' name="data"/>
				<input type="hidden" value='."'".json_encode($actions)."'".' name="actions"/>
			</td>
		</tr>';		
	}
	
	
	$pagination = array();
		for($x=0; $x<$total;$x++) {
		if($x + 1 != $p) $pagination[] = "<a href='admin.php?page=pn-users&p=".($x+1)."&o=".join(",", $o)."&s=".$s."'>".($x+1)."</a>";
		else $pagination[] = "<span>".($x + 1)."</span>";
	}
	
	
	$message = "";
	$tpl = str_replace("[STRRESULT]", join("", $row), $tpl);
	$tpl = str_replace("[STRPAGES]", join(" - ", $pagination), $tpl);
	
	if (isset($_POST['add']) || isset($_POST['edit'])) {
		$message = "<div class='update-nag'>Saved</div>";
	}
	
	$tpl = str_replace("[STRMESSAGE]", $message, $tpl);	
	$tpl = str_replace("[PAGE]", $p, $tpl);
	$tpl = str_replace("[ORDER]", $o[1] == "1" ? "0" : "1", $tpl);	
	$tpl = str_replace("[SEARCH]", $s, $tpl);
	

	
	print($tpl);	
}
//ini_set("display_errors", false);
?>