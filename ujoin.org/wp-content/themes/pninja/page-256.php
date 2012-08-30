<?php
/*
Template Name: Bills Edit / Create
*/
?>
<?PHP
	if ( !is_user_logged_in() ){
		wp_redirect( get_option( 'siteurl' ));
		exit();
	}
?>
<?PHP

	global $wpdb;
	global $pn_tables;
	
	
	//print_r($_POST);
	
	if (isset($_POST['add'])) {
		$r = json_decode( stripslashes($_POST['introducer']) );	
		$sql = "INSERT INTO $pn_tables->bills VALUES (NULL, '".$_POST['bill_id']."', '".$_POST['measure_title']."', '".$_POST['report_title']."', 
											   '".$_POST['description']."', '".$_POST['companion']."', '".$_POST['package']."',
											   '".$_POST['current_referral']."', '".join(",", $r)."', '".$_POST['committee']."',  
											   '".$_POST['testimony']."', 1)";
		$wpdb->query($sql); 


/*		$wpdb->insert('wp_pn_bills_search_results',
			array('bill_id'=>$_POST['bill_id'],
			'title'=>$_POST['measure_title'],
			'subjects'=>$_POST['report_title'],
			);
*/				
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
		
		if(isset($_POST['return']) && trim($_POST['return']) != ''){
			header("Location: ".$_REQUEST['return']);
			exit();
		}
	}	
				
	if (isset($_GET['p'])) $p = $_GET['p'];
	else $p = 1;	
		
		
	$result = $wpdb->get_results( "SELECT * FROM wp_pn_bills_search_results;" );
	$result_c = $wpdb->get_results( "SELECT CEIL(COUNT(id)/10) AS counter FROM wp_pn_bills_search_results;" );
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
			<td class="manage-column tdBill" style="">'.$data->bill_id.'</td>
			<td class="manage-column tdMeasure" style="">'.$data->measure_title.'</td>
			<td class="manage-column tdDesc" style="">'.$data->description.'</td>
			<td class="manage-column tdIntro" style="">'.join("<br/>", $sponsors_label).'</td>
			<td class="manage-column edit-buttons" style="">
				<a href="#edit" class="button edit" id="edit-bill-'.$data->id.'">Edit</a> 
				<input type="hidden" value='."'".json_encode($data)."'".' />
			</td>
		</tr>';		
	}
	
	$pagination = array();
	for($x=0; $x<$total;$x++) {
		if($x + 1 != $p) $pagination[] = "<a href='?page_id=256&p=".($x+1)."'>".($x+1)."</a>";
		else $pagination[] = "<span>".($x + 1)."</span>";
	}
	
	$message = "";
	
	if (isset($_POST['add']) || isset($_POST['edit'])) {
		$message = "<div class='update-nag'>Saved</div>";
	}
	
	$arr_comm = array();
	$result_comm = $wpdb->get_results( "SELECT * FROM $pn_tables->committee WHERE status = '1';" );
	foreach ($result_comm as $data_comm) {
		$arr_comm[] = "<option value='".$data_comm->id."'>".$data_comm->name."</option>";
	}
?>
<?php get_header(); ?>
<script type="text/javascript">_removeUniform = true</script>
<script type="text/javascript" src="<?=home_url('/');?>wp-includes/js/jquery/jquery.js?ver=1.4.2"></script>
<script src="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/js/jquery.json-2.2.min.js" type="text/javascript"></script>
<script src="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/js/jquery.ui.core.min.js" type="text/javascript"></script>
<script src="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/js/jquery.effects.core.min.js" type="text/javascript"></script>
<script src="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/js/jquery.ui.position.min.js" type="text/javascript"></script>
<script src="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/js/jquery.ui.widget.min.js" type="text/javascript"></script>
<script src="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/js/jquery.ui.autocomplete.min.js" type="text/javascript"></script>
<script src="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/js/jquery.ui.autocomplete.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/css/base/jquery.ui.all.css" type="text/css" media="all" />
<link rel="stylesheet" href="<?=home_url('/');?>/wp-content/plugins/pn-policyreports/css/ui-lightness/jquery-ui-1.8.7.custom.css" type="text/css" media="all" />
<style type="text/css">
						.tdBill{ width: 80px;}
						.tdMeasure{ width: 220px;}
						.tdDesc{ width: 120px;}
						.tdIntro{ width: 120px;}
						td.edit-buttons, th.edit-buttons{ width: 40px; text-align: left;}
	h2 {
		font: italic normal normal 24px/29px Georgia, 'Times New Roman', 'Bitstream Charter', Times, serif;
		padding: 14px 15px 3px 0px;
		margin:0;
		text-shadow: white 0px 1px 0px;
	}
	thead {
		width: 100% !important;
	}
	/*#add-list, #content-list  {
		width: 95% !important;
		margin:20px 0px 40px 10px !important;
	}*/
	
	#add-list div.content-window, #content-list div.content-window {
		margin: 15px 15px 15px 0px;
	}
	#pagination {
		margin-bottom:10px;
		color: #555;
		text-align: right;
	}
	#pagination span {
		color: #000;
		font-weight: bold;
	}
	#pagination a {
		color: #555;
		text-decoration:none; 
	}
	#pagination a:hover {
		text-decoration:underline; 
	}
	#plug-actions {
		margin:10px 0px 10px 10px !important;
	}
	td.check-column {
		text-align: center;
	}
	td.check-column input {
		margin-top: 3px;
	}
	/*td.edit-buttons, th.edit-buttons {
		text-align:center;
		width:120px;	
	}*/
	#opacity-edit {
		z-index: 2;
		width: 100%;
		height: 100%;
		background-color: #000;
		position: fixed;
		top: 0;
		left: 0;
	}
	#edit-window {
		z-index: 3;
		width: 600px;
		margin-left: -300px;
		position: fixed;
		left: 50%;
	}
	#edit-window form {
		background-color: #fff;
		padding: 20px;
		width: 560px;
		font-size: 12px;
	}
	#sCommittee {
		width: 300px;
	}
	#sLegislators {
		width: 180px;
	}
	#sCommitteeUpdate {
		width: 130px;
	}
	ul.ui-autocomplete {
		width: 200px;
		font-size: 12px;
	}
	.introducer-text {
		width: 110px;
	}
	select.legislators, select.legislators option {
		width: 100px;
	}
	input.committee_comm {
		width: 200px;
	}
	#add-list table.widefat.fixed {
		border: 2px solid #0097CA;	
		font-size: 14px;
		margin-left: 30px;
		padding: 10px;
		width: 600px;
	}
	#add-list table.widefat.fixed .manage-column input {
		border: 1px solid #CCC;
	}
	#add-list table.widefat.fixed .title {
		font-weight: bold;
	}
	#edit-window table.widefat.fixed .title {
		font-weight: bold;
	}
	#edit-window table.widefat.fixed {
		width: 100%;
	}
	#committee-list {
		max-height: 300px;
		overflow-y: auto;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('#content-list table').dataTable({"sPaginationType": "full_numbers","iDisplayLength": 10,"aaSorting": [ ]});
});
</script>
	<div id="content-page">              

		<div id="contentLeft">
            <span class="contentLeftTitle"><span>AHA!</span></span>
				<?php if ( !dynamic_sidebar('Transparency') ) : // begin primary sidebar widgets ?>
                <?php endif; // end primary sidebar widgets  ?>
            <span class="bordertop"><img class="lista" src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></span>
            
        </div>
		<div id="contentRight">
        
    		<div id="contentRightTop">
    			<div id="main">
					<div id="opacity-edit" style="display:none;"></div>
					<div id="edit-window" style="display:none;">
						
						<div class="tabHeader">Edit bill</div>
					
						<form action="?page_id=256" method="post" enctype="multipart/form-data" id="form-edit" class="tabContent">
							<input type="hidden" name="edit" value="true" />
							<input type="hidden" name="votes" value="{}" />
							<input type="hidden" name="introducer" />
							<div class="content-window"></div>
							<br/>
							<div><select id="sCommittee"><?= join("", $arr_comm); ?></select> <input type="button"  class="button add-new-h2" value="Add" id="btAdd"/></div>
							<br/>		
							<div id="committee-list"></div>
							<br/>
							<div><a href="#submit_edit" class="button submit-edit-h2">Save</a> <a href="#submit_cancel" class="button submit-cancel-h2">Cancel</a></div>
						</form>
					</div>

					<div id="plug-actions">
						<!--a href="#add_new" class="superboton"></a-->
						<div class="button" id="uniform-f-submit"><span>Add new bill<input id="f-submit" class="superboton" type="button" value="Add new bill" style="opacity: 0; "></span></div>
					</div>
					<?= $message; ?>
					<div id="add-list"> 
						<form action="?page_id=256" method="post" enctype="multipart/form-data" id="form-submit">
						<input type="hidden" name="add" value="true" />
						<input type="hidden" name="introducer"value="[]" />
						<div class="content-window">
							<table class="widefat fixed" cellspacing="0">
									<thead>
										<tr class="thead">
											<th scope="col" class="manage-column" style=""></th>
											<th scope="col" class="manage-column" style=""></th>
											<th scope="col" class="manage-column" style=""></th>
											<th scope="col" class="manage-column" style=""></th>
										</tr>
									</thead>
									<tbody class="">
										<tr>
											<td scope="col" class="manage-column title" style="">Bill ID:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="bill_id"/></td>
											<td scope="col" class="manage-column title" style="">Measure Title:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="measure_title"/></td>
										</tr>
										<tr>
											<td scope="col" class="manage-column title" style="">Report Title:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="report_title"/></td>
											<td scope="col" class="manage-column title" style="">Description:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="description"/></td>
										</tr>
										<tr>
											<td scope="col" class="manage-column title" style="">Companion:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="companion"/></td>
											<td scope="col" class="manage-column title" style="">Package:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="package"/></td>
										</tr>
										<tr>
											<td scope="col" class="manage-column title" style="">Current Referral:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="current_referral"/></td>
											<td scope="col" class="manage-column title" style="">Introducer:</td>
											<td scope="col" class="manage-column" style="">
												<div id="introducer-selected"></div>
												<div><input type="text" name="introducer_text" class="introducer-text"/><input type="button" value="+" class="add-more"/></div>
											</td>
										</tr>
										<tr>
											<td scope="col" class="manage-column title" style="">Testimony link:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="testimony"/></td>
											<td scope="col" class="manage-column title" style="">Committee Reports:</td>
											<td scope="col" class="manage-column" style=""><input type="text" name="committee"/></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="button submit-new-h2" id="uniform-f-submit"><span>Create<input id="f-submit" class="superboton" type="button" value="Create" style="opacity: 0; "></span></div>
							<!--div><a href="#submit_new" class="button submit-new-h2"></a></div-->
						</form>
					</div>
					<script type="text/javascript">jQuery("#add-list").hide(0)</script>
					<div id="content-list">
						<div class="tabHeader">Bills</div>
						<div class="tabContent">
							<table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="table-content">
								<thead>
									<tr class="forumsHeader thead">
										<th class="manage-column tdBill" style="">Bill ID</th>
										<th class="manage-column tdMeasure" style="">Measure Title</th>
										<th class="manage-column tdDesc" style="">Description</th>
										<th class="manage-column tdIntro" style="">Introducer</th>
										<th class="manage-column edit-buttons" style="background:none;">-</th>
									</tr>
								</thead>
								<tbody id="bills" class=""><?= join("", $row); ?></tbody>
							</table>
						</div>
					</div>
					<!--<div class="tabContent">
						<div id="pagination"><?= join("", $pagination); ?></div>
					</div>-->

					<div style="display:none"  id="table-committee">
						<table class="widefat fixed" cellspacing="0">
							<thead>
								<tr class="thead">
									<th scope="col" class="manage-column" style="width:85px;"></th>
									<th scope="col" class="manage-column" style=""></th>
									<th scope="col" class="manage-column" style="width:85px;"></th>
									<th scope="col" class="manage-column" style="text-align:right;"><input type="button" value="Remove" class="button"/></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td scope="col" class="manage-column" style="">Committee:</td>
									<td scope="col" class="manage-column" style=""><input type="text" class="committee_comm" readonly="readonly"/> <input value="" type="hidden" /></td>
									<td scope="col" class="manage-column" style="">Date:</td>
									<td scope="col" class="manage-column" style=""><input type="text" class="date_comm"/></td>
								</tr>
								<tr>
									<td scope="col" class="manage-column" style="">Status:</td>
									<td scope="col" class="manage-column" style=""><select class="process_comm"><option value="0">---------</option><option value="1">Passed</option><option value="2">Killed</option><option value="3">Deferred</option></select></td>
									<td scope="col" class="manage-column" style="">Youtube:</td>
									<td scope="col" class="manage-column" style=""><input type="text" class="youtube_comm"/></td>
								</tr>
								<tr>
									<td scope="col" class="manage-column" style="">Votes:</td>
									<td scope="col" class="manage-column" style=""><select class="legislators"></select> : <select class="votes"></select></td>
									<td scope="col" class="manage-column" style="">Google Map:</td>
									<td scope="col" class="manage-column" style=""><input type="text" class="address_comm"/></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
                    
        	<div id="contentRightBottom"></div>
		</div> 
	</div>
<script type="text/javascript">
	
	var selected_item,return_url;
	jQuery("table tbody a.edit").click(function () {
	
		jQuery("#form-edit input[name=bill_id]").attr("readonly", "readonly");
	
		jQuery("#form-edit .content-window").html(jQuery("#form-submit .content-window").html())
		var d = jQuery.parseJSON(jQuery(this).parent().find("input[type=hidden]").val());
		jQuery("#form-edit input[name=edit]").val(d.id);
		jQuery("#form-edit input[name=bill_id]").val(d.bill_id);
		jQuery("#form-edit input[name=measure_title]").val(d.measure_title);
		jQuery("#form-edit input[name=report_title]").val(d.report_title);
		jQuery("#form-edit input[name=description]").val(d.description);
		jQuery("#form-edit input[name=companion]").val(d.companion);
		jQuery("#form-edit input[name=current_referral]").val(d.current_referral);
		jQuery("#form-edit input[name=committee]").val(d.committe_reports);
		jQuery("#form-edit input[name=package]").val(d.package);		
		jQuery("#form-edit input[name=testimony]").val(d.testimony);
		jQuery("#form-edit select[name=process]").find("option[value="+d.status+"]").attr("selected", "selected")
		jQuery("#opacity-edit").fadeTo("slow", 0.6);
		jQuery("#edit-window").show("slow");		
		
		
		jQuery("#form-edit input[name=votes]").val(jQuery.toJSON(d.committee));
		jQuery("#form-edit input[name=introducer_text]").autocomplete({source:"/?ajax&searchLegs", select:function(e, ui){
			selected_item = ui.item
		}});
		
		var a = new Array();
		var h = "<input type='button' value='-' class='remove-more' />";
		for (var i=0; i<d.sponsor_id.length; i++) {
			var c = "<div><input type='text' value='"+d.sponsor_id[i].lname+"' readonly='readonly' class='introducer-text' />"+h
			c += "<input type='hidden' value='"+d.sponsor_id[i].crp_id+"' /></div>" 
			a.push(d.sponsor_id[i].crp_id)
			jQuery("#introducer-selected").append(c)
		}
		jQuery("#form-edit .remove-more").click(removeLegs)
		jQuery("#form-edit input[name=introducer]").val(jQuery.toJSON(a))
		jQuery("#form-edit .add-more").click(addLegs)
		
		jQuery("#committee-list").html( "" )
		
		for (var prop in d.committee) {
			
			if (prop == "assoc") continue;
		
			jQuery("#sCommittee").find("option[value="+prop+"]").attr("selected", "selected")
			jQuery("#committee-list").prepend( jQuery("#table-committee").html() )
			var g = jQuery("#committee-list").find("table").get(0);
		
			var s = jQuery("#sCommittee").find("option:selected").text()
			jQuery(g).find("input.committee_comm").val(s)
			jQuery(g).find("input[type=hidden]").val(prop)
		
			var url = "/?ajax&legsVotedBill=" + d.id + "|" + prop
			
			jQuery(g).find(".date_comm").val(d.committee[prop].date);
			jQuery(g).find(".process_comm").val(d.committee[prop].vote);
			jQuery(g).find(".youtube_comm").val(d.committee[prop].youtube);
			jQuery(g).find(".address_comm").val(d.committee[prop].address);
			
			jQuery.ajax({url:url, context:g, success:ajaxCommLoad, type:"get"})
		
			jQuery(g).find("input[value=Remove]").click(removeComm)			
		}
		
		
		
	})
	
	jQuery("#form-submit input[name=introducer_text]").autocomplete({source:"/?ajax&searchLegs", select:function(e, ui){
			selected_item = ui.item
	}});
	
	
	function addLegs () {
		var j = jQuery(this).parent().find("input[name=introducer_text]").val()
		if (j == "" || selected_item == null) return;
		var p = jQuery(this).parent().parent().parent().parent().parent().parent().parent()
		var a  = jQuery.parseJSON(p.find("input[name=introducer]").val())	
		a.push(selected_item.crp_id);
		p.find("input[name=introducer]").val(jQuery.toJSON(a))
		jQuery(this).parent().find("input[name=introducer_text]").val("")		
		var h = "<input type='button' value='-' class='remove-more' />";	
		var c = "<div><input type='text' value='"+j+"' readonly='readonly' class='introducer-text' />"+h
		c += "<input type='hidden' value='"+selected_item.crp_id+"' /></div>" 
		jQuery("#introducer-selected").append(c)
		p.find(".remove-more").click(removeLegs)
		
		selected_item = null;
	}
	
	jQuery("#form-submit .add-more").click(addLegs)
	
	function removeLegs () {
		var p = jQuery(this).parent().parent().parent().parent().parent().parent().parent().parent()

		var a  = jQuery.parseJSON( p.find("input[name=introducer]").val() )	
		var h = jQuery(this).parent().find("input[type=hidden]").val();	
		for (var i=0; i<a.length; i++) {
			if (h == a[i]) {
				a.splice(i, 1);
				break;
			}			
		}			
		p.find("input[name=introducer]").val(jQuery.toJSON(a))
		jQuery(this).parent().remove();
	}
	
	
	jQuery("#btAdd").click(function () {	

		var v = jQuery("#sCommittee").find("option:selected").val();	
		var o = jQuery.parseJSON(jQuery("#form-edit input[name=votes]").val())
		
		if (!o[v]) {
			o[v] = new Object();
			o[v].legsvotes = new Object();
		} else {
			alert("Committee already added!")
			return;
		}
		
		jQuery("#committee-list").prepend( jQuery("#table-committee").html() )
		var g = jQuery("#committee-list").find("table").get(0);		
		jQuery("#form-edit input[name=votes]").val(jQuery.toJSON(o))			
	
		var s = jQuery("#sCommittee").find("option:selected").text()
		jQuery(g).find("input.committee_comm").val(s)
		jQuery(g).find("input[type=hidden]").val(v)
		jQuery(g).find("input[value=Remove]").click(removeComm)
		
		var url = "/?ajax&legsVotedBill=" + jQuery("#form-edit input[name=edit]").val() + "|" + jQuery("#sCommittee").find("option:selected").val()
		jQuery.ajax({url:url, context:g, success:ajaxCommLoad, type:"get"})
	})
	
	
	function removeComm() {
		var v  = jQuery(this).parent().parent().parent().parent().find("input[type=hidden]").val()
		var o = jQuery.parseJSON(jQuery("#form-edit input[name=votes]").val())
		delete o[v];
		jQuery("#form-edit input[name=votes]").val(jQuery.toJSON(o))
		jQuery(this).parent().parent().parent().parent().remove();
	}
	
	
	function ajaxCommLoad (msg) {
		var t = jQuery.parseJSON(msg); 
		var d = t.legs;
				
		var v = jQuery(this).find("input[type=hidden]").val()
		var o = jQuery.parseJSON(jQuery("#form-edit input[name=votes]").val())
		
			
		for (var i=0; i<d.length; i++) {
			if (d[i].vote == 0) jQuery(this).find(".legislators").append("<option value='" + jQuery.toJSON(d[i]) + "'>" + d[i].name + "</option>")
			else jQuery(this).find(".legislators").append("<option value='" + jQuery.toJSON(d[i]) + "'>- [Voted] " + d[i].name + "</option>")
			
			o[v]['legsvotes'][d[i].crp_id] = d[i].vote
		}

		jQuery("#form-edit input[name=votes]").val(jQuery.toJSON(o))	
		jQuery(this).find(".legislators").change(chgLegislator)
		jQuery(this).find(".legislators").trigger("change");
	}
	
	
	function chgLegislator() {
		var v = jQuery(this).parent().parent().parent().parent().find("input[type=hidden]").val()
		var o = jQuery.parseJSON(jQuery("#form-edit input[name=votes]").val())
		var f = jQuery.parseJSON(jQuery(this).val());
				
		var r = o[v]['legsvotes'][f.crp_id];
		jQuery(this).parent().find(".votes").html("");
				
		var d = new Array("No vote", "Aye", "No", "With reservations", "Excused", "Absent");			
		for (var i=0; i<d.length; i++) {
			if (i != r) jQuery(this).parent().find(".votes").append("<option value='"+i+"'>"+d[i]+"</option>")
			else  jQuery(this).parent().find(".votes").append("<option value='"+i+"' selected='selected'>"+d[i]+"</option>")
		}
		jQuery(this).parent().find(".votes").change(chgVotes);
	}

	
	function chgVotes () {
		var v = jQuery(this).parent().parent().parent().parent().find("input[type=hidden]").val()

		var o = jQuery.parseJSON(jQuery("#form-edit input[name=votes]").val())
		var f = jQuery.parseJSON(jQuery(this).parent().find(".legislators").val());
		o[v]['legsvotes'][f.crp_id] = jQuery(this).val();
		jQuery("#form-edit input[name=votes]").val(jQuery.toJSON(o))
	}
	
	
	jQuery("a.submit-cancel-h2").click(function () {
		jQuery("#opacity-edit").fadeTo("slow", 0, function(){
			jQuery("#opacity-edit").hide(0);
			if(jQuery.trim(return_url) != ''){
				window.location = unescape(return_url);
			}
		});
		jQuery("#edit-window").hide("slow");
	})
	
	
	jQuery("#plug-actions div.button").click(function () {
		jQuery("#add-list").slideToggle();
	})
	
	
	jQuery("div.submit-new-h2").click(function () {
		jQuery("#form-submit").submit();
	})
	
	
	jQuery("a.submit-edit-h2").click(function () {
		
		var o = jQuery.parseJSON(jQuery("#form-edit input[name=votes]").val())
		for (var prop in o) {
			o[prop].date =  jQuery("#committee-list input[value='"+prop+"']").parent().parent().parent().find(".date_comm").val();
			o[prop].vote =  jQuery("#committee-list input[value='"+prop+"']").parent().parent().parent().find(".process_comm").val();
			o[prop].youtube =  jQuery("#committee-list input[value='"+prop+"']").parent().parent().parent().find(".youtube_comm").val();
			o[prop].address =  jQuery("#committee-list input[value='"+prop+"']").parent().parent().parent().find(".address_comm").val();
		}
		if(jQuery.trim(return_url) != ''){
				jQuery("#form-edit").append('<input type="hidden" name="return" value="'+unescape(return_url)+'"/>');
		}
		jQuery("#form-edit input[name=votes]").val(jQuery.toJSON(o))
		jQuery("#form-edit").submit();
	})
</script>
<?PHP if(isset($_REQUEST['bill_id']) && !is_nan((int) $_REQUEST['bill_id'])):?>
<script type="text/javascript">
		var bid = '<?=$_REQUEST['bill_id'];?>';
		return_url = '<?=$_REQUEST['return'];?>'
		jQuery('#edit-bill-'+bid).trigger('click');
</script>
<?PHP endif;?>
</body>
</html>