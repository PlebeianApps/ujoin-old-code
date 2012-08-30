<?PHP
/*
Plugin Name: Committtee administrator
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
	
		//print("1");
	
	if (isset($_GET['parse'])) {

		$key = $pn_tables->apikey;
		
		
		$json = json_decode( file_get_contents("http://services.sunlightlabs.com/api/committees.getList.json?apikey=".$key."&chamber=House") );
		$d = $json->response->committees;
		for ($x=0; $x<count($d); $x++) {			
			$sql = "INSERT INTO $pn_tables->committee VALUES (NULL, '".$d[$x]->committee->id."', '".$d[$x]->committee->name."', '1')";
			$wpdb->query($sql);
			$comm = json_decode( file_get_contents("http://services.sunlightlabs.com/api/committees.get.json?apikey=".$key."&id=".$d[$x]->committee->id) );	
			$m = $comm->response->committee->members;
			for ($y=0; $y<count($d); $y++) {
				$wpdb->query("INSERT INTO $pn_tables->legs2committee VALUES ('".$d[$x]->committee->id."', '".$m[$y]->legislator->crp_id."')");
			}
		}
		
		$json = json_decode( file_get_contents("http://services.sunlightlabs.com/api/committees.getList.json?apikey=".$key."&chamber=Senate") );
		$d = $json->response->committees;
		for ($x=0; $x<count($d); $x++) {			
			$sql = "INSERT INTO $pn_tables->committee VALUES (NULL, '".$d[$x]->committee->id."', '".$d[$x]->committee->name."', '1')";
			$wpdb->query($sql);
			$comm = json_decode( file_get_contents("http://services.sunlightlabs.com/api/committees.get.json?apikey=".$key."&id=".$d[$x]->committee->id) );	
			$m = $comm->response->committee->members;
			for ($y=0; $y<count($d); $y++) {
				$wpdb->query("INSERT INTO $pn_tables->legs2committee VALUES ('".$d[$x]->committee->id."', '".$m[$y]->legislator->crp_id."')");
			}
		}
		
		
		
		$json = json_decode( file_get_contents("http://services.sunlightlabs.com/api/committees.getList.json?apikey=".$key."&chamber=Joint") );
		$d = $json->response->committees;
		for ($x=0; $x<count($d); $x++) {			
			$sql = "INSERT INTO $pn_tables->committee VALUES (NULL, '".$d[$x]->committee->id."', '".$d[$x]->committee->name."', '1')";
			$wpdb->query($sql);
			$comm = json_decode( file_get_contents("http://services.sunlightlabs.com/api/committees.get.json?apikey=".$key."&id=".$d[$x]->committee->id) );	
			$m = $comm->response->committee->members;
			for ($y=0; $y<count($d); $y++) {
				$wpdb->query("INSERT INTO $pn_tables->legs2committee VALUES ('".$d[$x]->committee->id."', '".$m[$y]->legislator->crp_id."')");
			}
		}
		
		
		?><script type="text/javascript">window.location = "admin.php?page=pn-committee";</script><?PHP
				
		exit ();		
	}
	
	if (isset($_POST['add'])) {
		$sql = "INSERT INTO $pn_tables->committee VALUES (NULL, '".$_POST['comm_id']."', '".$_POST['name']."', '".$_POST['email']."', 1)";
		$wpdb->query($sql);
	}
	
	if (isset($_POST['edit'])) {
		$sql = "UPDATE $pn_tables->committee SET comm_id = '".$_POST['comm_id']."', 
					name = '".$_POST['name']."', email = '".$_POST['email']."' WHERE id = '".$_POST['edit']."'";		
		$wpdb->query($sql);
	}
	
	if (isset($_POST['delete'])) {		
		$sql = "UPDATE $pn_tables->committee SET status = '0' WHERE id IN (".$_POST['delete'].")";
		$wpdb->query($sql);				
	}
		
	if (isset($_GET['p'])) $p = $_GET['p'];
	else $p = 1;	
		
	if (isset($_GET['o'])) $o = explode(",", $_GET['o']);
	else $o = array("comm_id", "0");
	
	if (isset($_GET['s'])) $s = $_GET['s'];
	else $s = "";		
		
	$tpl = file_get_contents(ABSPATH . 'wp-content/plugins/pn-policyreports/plugins/pn-committee.tpl');
	$result = $wpdb->get_results( "SELECT * FROM $pn_tables->committee WHERE status = '1' 
									AND (comm_id LIKE '%".$s."%' OR name LIKE '%".$s."%' OR email LIKE '%".$s."%')
									ORDER BY ".$o[0]." ".($o[1] == 1 ? "ASC" : "DESC")." LIMIT ".(($p - 1)*30).",30;" );
	$result_c = $wpdb->get_results( "SELECT CEIL(COUNT(id)/30) AS counter FROM $pn_tables->committee  WHERE  status = '1'
									AND (comm_id LIKE '%".$s."%' OR name LIKE '%".$s."%' OR email LIKE '%".$s."%');" );
	foreach ($result_c as $data_c) $total = $data_c->counter; 
	
	$row = array();
	
	foreach ($result as $data) {			
		$row [] = '
		<tr class="thead">
			<td scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" value="'.$data->id.'"/></td>
			<td scope="col" class="manage-column" style="">'.$data->comm_id.'</td>
			<td scope="col" class="manage-column" style="">'.$data->name.'</td>
			<td scope="col" class="manage-column" style="">'.$data->email.'</td>
			<td scope="col" class="manage-column edit-buttons" style="">
				<a href="#edit" class="button edit">Edit</a> 
				<a href="#delete" class="button delete">Delete</a> <input type="hidden" value='."'".json_encode($data)."'".' />
			</td>
		</tr>';		
	}
	
	$pagination = array();
	for($x=0; $x<$total;$x++) {
		if($x + 1 != $p) $pagination[] = "<a href='admin.php?page=pn-committee&p=".($x+1)."&o=".join(",", $o)."&s=".$s."'>".($x+1)."</a>";
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

?>