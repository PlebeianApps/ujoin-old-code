<?PHP
/*
Plugin Name: Legislators administrator
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
	
	if (isset($_GET['parse'])) {
		//&state=HI
		$json = json_decode( file_get_contents("http://services.sunlightlabs.com/api/legislators.getList.json?apikey=207b25d043ee40a78148b02d5aff125c") );
		$d = $json->response->legislators;
		
		for ($x=0; $x<count($d); $x++) {
			$sql = "INSERT INTO $pn_tables->legislators VALUES (NULL, '".$d[$x]->legislator->govtrack_id."', '".$d[$x]->legislator->crp_id."', 
											   '".$d[$x]->legislator->firstname."', 
											   '".$d[$x]->legislator->middlename."', '".$d[$x]->legislator->lastname."', 
											   '".$d[$x]->legislator->district."', '".$d[$x]->legislator->title."', 0, 
											   '".$d[$x]->legislator->congress_office."', '".$d[$x]->legislator->phone."', 
											   '".$d[$x]->legislator->fax."', '".$d[$x]->legislator->email."', '', 
											   '1')";
			$wpdb->query($sql);
		}
		?><script type="text/javascript">window.location = "admin.php?page=pn-legislators";</script><?PHP
		exit ();		
	}
	
	print_r($_POST);
	
	if (isset($_POST['add'])) {
		$sql = "INSERT INTO $pn_tables->legislators VALUES (NULL, '".$_POST['govtrack_id']."', '".$_POST['crp_id']."', '".$_POST['firstname']."', 
											   '".$_POST['middlename']."',  '".$_POST['lastname']."', '".$_POST['district']."', 
											   '".$_POST['title']."','".$_POST['cycle']."', '".$_POST['address']."', 
											    '".$_POST['phone']."',  '".$_POST['fax']."', '".$_POST['email']."', '".$_POST['party']."',
											    1)";
		$wpdb->query($sql);
		
		$id = $wpdb->insert_id;
		if(isset($_FILES['image'])){
			if($_FILES['image']['error'] > 0) return;
			include ABSPATH.'wp-content/plugins/pn-policyreports/plugins/wideimage/WideImage.php';
			move_uploaded_file($_FILES['image']['tmp_name'], (ABSPATH."wp-content/legislators/$id.jpg"));
			$file = ABSPATH."wp-content/legislators/$id.jpg";
			WideImage::load($file)->resize(100, 100)->saveToFile($file);
		}
	}
	
	
	
	if (isset($_POST['edit'])) {
	
		$rlegs = $wpdb->get_results( "SELECT crp_id FROM pn_legislators WHERE id = '".$_POST['edit']."';" );
		foreach ($rlegs as $datalegs) $old_crp = $datalegs->crp_id;
	
		$sql = "UPDATE $pn_tables->legislators SET govtrack_id = '".$_POST['govtrack_id']."', firstname = '".$_POST['firstname']."', 
								 	middlename = '".$_POST['middlename']."', lastname = '".$_POST['lastname']."', 
								 	district = '".$_POST['district']."', title = '".$_POST['title']."', crp_id  = '".$_POST['crp_id']."', 
								 	cycle = '".$_POST['cycle']."', address = '".$_POST['address']."', phone  = '".$_POST['phone']."',
								 	fax = '".$_POST['fax']."', email = '".$_POST['email']."', party = '".$_POST['party']."'
									WHERE id = '".$_POST['edit']."'";
		$wpdb->query($sql);
		
		$wpdb->query("DELETE FROM $pn_tables->legs2committee WHERE crp_id='".$old_crp."';");
				
		$c = json_decode(stripslashes($_POST['committee']));
		for ($x=0; $x<count($c); $x++) {
			if ($c[$x]->rank == "0") continue;
			$sql = "INSERT INTO $pn_tables->legs2committee VALUES('".$c[$x]->comm_id."', '".$_POST['crp_id']."', '".$c[$x]->rank."')";
			$wpdb->query($sql);
		}
		
		$id = $_POST['edit'];
		if(isset($_FILES['image'])){
			if($_FILES['image']['error'] > 0) return;
			include ABSPATH.'wp-content/plugins/pn-policyreports/plugins/wideimage/WideImage.php';
			move_uploaded_file($_FILES['image']['tmp_name'], (ABSPATH."wp-content/legislators/$id.jpg"));
			$file = ABSPATH."wp-content/legislators/$id.jpg";
			WideImage::load($file)->resize(100, 100)->saveToFile($file);
		}
	}
	
	if (isset($_POST['delete'])) {		
		$sql = "UPDATE $pn_tables->legislators SET status = '0' WHERE id IN (".$_POST['delete'].")";
		$wpdb->query($sql);				
	}
		
	if (isset($_GET['p'])) $p = $_GET['p'];
	else $p = 1;	
		
	$tpl = file_get_contents(ABSPATH . 'wp-content/plugins/pn-policyreports/plugins/pn-legislators.tpl');
	$result = $wpdb->get_results( "SELECT * FROM $pn_tables->legislators WHERE  status = '1' LIMIT ".(($p - 1)*30).",30;" );
	$result_c = $wpdb->get_results( "SELECT CEIL(COUNT(id)/30) AS counter FROM $pn_tables->legislators  WHERE  status = '1';" );
	foreach ($result_c as $data_c) $total = $data_c->counter; 
	
	$row = array();
	
	foreach ($result as $data) {			
		
		$comm = array();
		$result_comm = $wpdb->get_results( "SELECT comm_id, rank FROM $pn_tables->legs2committee WHERE crp_id = '".$data->crp_id."';" );
		foreach ($result_comm as $data_comm) $comm[] = $data_comm;
		
		$row [] = '
		<tr class="thead">
			<td scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" value="'.$data->id.'"/></td>
			<td scope="col" class="manage-column" style="">'.$data->govtrack_id.'</td>
			<td scope="col" class="manage-column" style="">'.$data->crp_id.'</td>
			<td scope="col" class="manage-column" style="">'.$data->firstname." ".$data->middlename." ".$data->lastname.'</td>
			<td scope="col" class="manage-column" style="">'.$data->district.'</td>
			<td scope="col" class="manage-column" style="">'.$data->title.'</td>
			<td scope="col" class="manage-column edit-buttons" style="">
				<a href="#edit" class="button edit">Edit</a> 
				<a href="#delete" class="button delete">Delete</a> 
				<input type="hidden" value='."'".json_encode($data)."'".' name="data"/>
				<input type="hidden" value='."'".json_encode($comm)."'".' name="committe"/>
			</td>
		</tr>';		
	}
	
	$pagination = array();
	for($x=0; $x<$total;$x++) {
		if($x + 1 != $p) $pagination[] = "<a href='admin.php?page=pn-legislators&p=".($x+1)."'>".($x+1)."</a>";
		else $pagination[] = "<span>".($x + 1)."</span>";
	}
	
	
	$select = array();
	$result_cy = $wpdb->get_results( "SELECT * FROM $pn_tables->cycle;" );
	foreach ($result_cy as $data_cy) {			
		$select [] = '<option value="'.$data_cy->id.'">'.$data_cy->title.'</option>';		
	}
	
	
	$message = "";
	$tpl = str_replace("[STRRESULT]", join("", $row), $tpl);
	$tpl = str_replace("[STRPAGES]", join(" - ", $pagination), $tpl);
	$tpl = str_replace("[STRCYCLES]", join("", $select), $tpl);	
	
	if (isset($_POST['add']) || isset($_POST['edit'])) {
		$message = "<div class='update-nag'>Saved</div>";
	}
	
	$tpl = str_replace("[STRMESSAGE]", $message, $tpl);	
	
	$listcomm = array();
	$result_listcomm = $wpdb->get_results( "SELECT comm_id, name FROM $pn_tables->committee;" );
	foreach ($result_listcomm as $data_listcomm) $listcomm[] = "<option value='".$data_listcomm->comm_id."'>".$data_listcomm->name."</option>";
	
	$tpl = str_replace("[STRCOMM]", join("", $listcomm), $tpl);
	
	print($tpl);	
}
//ini_set("display_errors", false);
?>