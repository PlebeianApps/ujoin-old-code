<?PHP
/*
Plugin Name: Bills administrator
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
		
		$json = json_decode( file_get_contents("http://drumbone.services.sunlightlabs.com/v1/api/bills.json?apikey=$pn_tables->apikey") );
		$d = $json->bills;
		
		for ($x=0; $x<count($d); $x++) {
			$sql = "INSERT INTO $pn_tables->bills VALUES (NULL, '".$d[$x]->bill_id."', '".$d[$x]->official_title."', '".$d[$x]->official_title."', 
											   '', '', '', '', '', '', '', '', 1)";
			$wpdb->query($sql);
		}
		?><script type="text/javascript">window.location = "admin.php?page=pn-bills";</script><?PHP
		exit ();		
	}
	
	if (isset($_POST['add'])) {
		$r = json_decode( stripslashes($_POST['introducer']) );	
		$sql = "INSERT INTO $pn_tables->bills VALUES (NULL, '".$_POST['bill_id']."', '".$_POST['measure_title']."', '".$_POST['report_title']."', 
											   '".$_POST['description']."', '".$_POST['companion']."', '".$_POST['package']."',
											   '".$_POST['current_referral']."', '".join(",", $r)."', '".$_POST['committee']."',  
											   '".$_POST['testimony']."', 1)";
		$wpdb->query($sql);
				
	}
	
	if (isset($_POST['edit'])) {
	
		$r = json_decode( stripslashes($_POST['introducer']) );	
		$sql = "UPDATE $pn_tables->bills SET measure_title = '".$_POST['measure_title']."', bill_id='".$_POST['bill_id']."', 
								 	report_title = '".$_POST['report_title']."', description = '".$_POST['description']."', 
								 	companion = '".$_POST['companion']."', package = '".$_POST['package']."',
									current_referral = '".$_POST['current_referral']."', sponsor_id = '".join(",", $r)."', 
									committe_reports = '".$_POST['committee']."', testimony = '".$_POST['testimony']."' 
									WHERE id = '".$_POST['edit']."'";
									

		$wpdb->query($sql);		
		$bupd = json_decode(stripslashes($_POST['votes']));		
		$wpdb->query("DELETE FROM $pn_tables->legs2bills WHERE bill_id = '".$_POST['edit']."';");
		$wpdb->query("DELETE FROM $pn_tables->bills_updates WHERE bill_id = '".$_POST['edit']."';");
		

		foreach($bupd as $key1=>$value1) {
			
			if ($key1 == "assoc") continue;
			$wpdb->query("INSERT INTO $pn_tables->bills_updates 
						VALUES (NULL, 1, '".$_POST['edit']."', '".$key1."', '".$value1->address."', 
						'".$value1->youtube."', '".$value1->date."', '".$value1->vote."', NOW());");
			
			
			foreach($value1->legsvotes as $key2=>$value2) {
				if ($key2 == "assoc") continue;
				$wpdb->query("INSERT INTO $pn_tables->legs2bills 
								VALUES('".$_POST['edit']."', '".$key2."', '".$key1."', '".$value2."')");			
			}			
			
		}
		

				
	}
	
	if (isset($_POST['delete'])) {		
		$sql = "UPDATE $pn_tables->bills SET status = '0' WHERE id IN (".$_POST['delete'].")";
		$wpdb->query($sql);				
	}
		
	if (isset($_GET['p'])) $p = $_GET['p'];
	else $p = 1;
	
	if (isset($_GET['o'])) $o = explode(",", $_GET['o']);
	else $o = array("bill_id", "0");
	
	if (isset($_GET['s'])) $s = $_GET['s'];
	else $s = "";	
		
	$tpl = file_get_contents(ABSPATH . 'wp-content/plugins/pn-policyreports/plugins/pn-bills.tpl');
	$result = $wpdb->get_results( "SELECT * FROM $pn_tables->bills WHERE  status = '1' 
									AND (bill_id LIKE '%".$s."%' OR measure_title LIKE '%".$s."%' OR report_title LIKE '%".$s."%' OR 
										description LIKE '%".$s."%') 
									ORDER BY ".$o[0]." ".($o[1] == 1 ? "ASC" : "DESC")." LIMIT ".(($p - 1)*10).",10;" );
	
									
	$result_c = $wpdb->get_results( "SELECT CEIL(COUNT(id)/10) AS counter FROM $pn_tables->bills  WHERE  status = '1'
									AND (bill_id LIKE '%".$s."%' OR measure_title LIKE '%".$s."%' OR report_title LIKE '%".$s."%' OR 
										description LIKE '%".$s."%');" );
	foreach ($result_c as $data_c) $total = $data_c->counter; 
	
	
	$row = array();


	foreach ($result as $data) {	
		
		$c = explode(",", $data->sponsor_id);
		for ($x=0; $x<count($c); $x++) $c[$x] = "'".$c[$x]."'";
		
		$sponsors = array();
		$sponsors_label = array();
		$result_i = $wpdb->get_results("SELECT id AS crp_id, CONCAT(firstname, ' ', lastname) AS lname FROM $pn_tables->legislators WHERE id IN (".join(",", $c).");");
		
		
		foreach ($result_i as $data_i) {
			$sponsors[] = $data_i;
			$sponsors_label[] = $data_i->lname;
		}
		
		$data->sponsor_id = $sponsors;
		
		$arr_comm = array("assoc"=>"");
		$result_r = $wpdb->get_results("SELECT * FROM $pn_tables->bills_updates WHERE bill_id = '".$data->id."' ORDER BY committee;", ARRAY_A);
		foreach ($result_r as $data_r) {
			$data_r['legsvotes'] = array("assoc"=>"");
			$arr_comm[$data_r['committee']] = $data_r;
		}
			
		$data->committee = $arr_comm; 		
			
		$row [] = '
		<tr class="thead">
			<td scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" value="'.$data->id.'"/></td>
			<td scope="col" class="manage-column" style="">'.$data->bill_id.'</td>
			<td scope="col" class="manage-column" style="">'.substr($data->measure_title, 0, 30).'...</td>
			<td scope="col" class="manage-column" style="">'.substr($data->report_title, 0, 30).'...</td>
			<td scope="col" class="manage-column" style="">'.$data->description.'</td>
			<td scope="col" class="manage-column" style="">'.join("<br/>", $sponsors_label).'</td>
			<td scope="col" class="manage-column edit-buttons" style="">
				<a href="#edit" class="button edit">Edit</a> 
				<a href="#delete" class="button delete">Delete</a> 
				<input type="hidden" value='."'".json_encode($data)."'".' />
			</td>
		</tr>';		
	}
	
	$pagination = array();
	for($x=0; $x<$total;$x++) {
		if($x + 1 != $p) $pagination[] = "<a href='admin.php?page=pn-bills&p=".($x+1)."&o=".join(",", $o)."&s=".$s."'>".($x+1)."</a>";
		else $pagination[] = "<span>".($x + 1)."</span>";
	}
	
	$message = "";
	$tpl = str_replace("[STRRESULT]", join("", $row), $tpl);
	$tpl = str_replace("[STRPAGES]", join(" - ", $pagination), $tpl);	
	
	if (isset($_POST['add']) || isset($_POST['edit'])) {
		$message = "<div class='update-nag'>Saved</div>";
	}
	
	$arr_comm = array();
	$result_comm = $wpdb->get_results( "SELECT * FROM $pn_tables->committee WHERE status = '1';" );
	foreach ($result_comm as $data_comm) {
		$arr_comm[] = "<option value='".$data_comm->id."'>".$data_comm->name."</option>";
	}
	$tpl = str_replace("[STRCOMMITTEE]", join("", $arr_comm), $tpl);
	$tpl = str_replace("[STRCOMMITTEE]", join("", $arr_comm), $tpl);	
	$tpl = str_replace("[STRMESSAGE]", $message, $tpl);
	$tpl = str_replace("[PAGE]", $p, $tpl);
	$tpl = str_replace("[SEARCH]", $s, $tpl);
	$tpl = str_replace("[ORDER]", $o[1] == "1" ? "0" : "1", $tpl);	
	
	print($tpl);	
}




?>