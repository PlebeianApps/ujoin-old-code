<script src="http://www.policyninja.org/wp-content/plugins/pn-policyreports/js/jquery.json-2.2.min.js" type="text/javascript"></script>
<script src="http://www.policyninja.org/wp-content/plugins/pn-policyreports/js/jquery.ui.core.min.js" type="text/javascript"></script>
<script src="http://www.policyninja.org/wp-content/plugins/pn-policyreports/js/jquery.effects.core.min.js" type="text/javascript"></script>
<script src="http://www.policyninja.org/wp-content/plugins/pn-policyreports/js/jquery.ui.position.min.js" type="text/javascript"></script>
<script src="http://www.policyninja.org/wp-content/plugins/pn-policyreports/js/jquery.ui.widget.min.js" type="text/javascript"></script>
<script src="http://www.policyninja.org/wp-content/plugins/pn-policyreports/js/jquery.ui.autocomplete.min.js" type="text/javascript"></script>
<script src="http://www.policyninja.org/wp-content/plugins/pn-policyreports/js/jquery.ui.autocomplete.min.js" type="text/javascript"></script>
<link rel='stylesheet' href='http://www.policyninja.org/wp-content/plugins/pn-policyreports/css/base/jquery.ui.all.css' type='text/css' media='all' />
<link rel='stylesheet' href='http://www.policyninja.org/wp-content/plugins/pn-policyreports/css/ui-lightness/jquery-ui-1.8.7.custom.css' type='text/css' media='all' />

<style type="text/css">
	h2 {
		font: italic normal normal 24px/29px Georgia, 'Times New Roman', 'Bitstream Charter', Times, serif;
		padding: 14px 15px 3px 0px;
		margin:0;
		text-shadow: white 0px 1px 0px;
	}
	thead {
		width: 100% !important;
	}
	#add-list, #content-list  {
		width: 95% !important;
		margin:20px 0px 40px 10px !important;
	}
	
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
 	#content-list tbody a {
		margin-top:8px !important;
	}
	td.edit-buttons, th.edit-buttons {
		text-align:center;
		width:120px;	
	}
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
		background-color: #FFF;
		padding: 20px 20px 20px 20px;
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
</style>
<form action="admin.php?page=pn-bills" method="post" enctype="multipart/form-data" id="form-delete">
		<input type="hidden" name="delete" value="" />
</form>
<div id="opacity-edit" style="display:none;"></div>
<div id="edit-window" style="display:none;">
	<form action="admin.php?page=pn-bills" method="post" enctype="multipart/form-data" id="form-edit">
		<input type="hidden" name="edit" value="true" />
		<input type="hidden" name="votes" value="{}" />
		<input type="hidden" name="introducer" />
		<div class="content-window"></div>
		<br/>
		<div><select id="sCommittee">[STRCOMMITTEE]</select> <input type="button"  class="button add-new-h2" value="Add" id="btAdd"/></div>
		<br/>		
		<div id="committee-list"></div>
		<br/>
		<div><a href="#submit_edit" class="button submit-edit-h2">Save</a> <a href="#submit_cancel" class="button submit-cancel-h2">Cancel</a></div>
	</form>
</div>

<h2>Parse the webservice <a href="admin.php?page=pn-bills&parse=true" class="button parse-new-h2">Execute</a></h2>
<div id="plug-actions"><a href="#add_new" class="button add-new-h2">Add new bill</a></div>
[STRMESSAGE]
<div id="add-list"> 
<form action="admin.php?page=pn-bills" method="post" enctype="multipart/form-data" id="form-submit">
<input type="hidden" name="add" value="true" />
<input type="hidden" name="introducer"value="[]" />
<div class="content-window">
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr class="thead">
			<th scope="col" class="manage-column" style="">Field</th>
			<th scope="col" class="manage-column" style="">Value</th>
			<th scope="col" class="manage-column" style="">Field</th>
			<th scope="col" class="manage-column" style="">Value</th>
		</tr>
	</thead>
	<tbody class="">
		<tr>
			<td scope="col" class="manage-column" style="">Bill ID:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="bill_id"/></td>
			<td scope="col" class="manage-column" style="">Measure Title:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="measure_title"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Report Title:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="report_title"/></td>
			<td scope="col" class="manage-column" style="">Description:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="description"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Companion:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="companion"/></td>
			<td scope="col" class="manage-column" style="">Package:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="package"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Current Referral:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="current_referral"/></td>
			<td scope="col" class="manage-column" style="">Introducer:</td>
			<td scope="col" class="manage-column" style="">
				<div id="introducer-selected"></div>
				<div><input type="text" name="introducer_text" class="introducer-text"/><input type="button" value="+" class="add-more"/></div>
			</td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Testimony link:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="testimony"/></td>
			<td scope="col" class="manage-column" style="">Committee Reports:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="committee"/></td>
		</tr>
	</tbody>
</table>
</div>
<div><a href="#submit_new" class="button submit-new-h2">Create</a></div>
</form>
</div>
<script type="text/javascript">
	jQuery("#add-list").hide(0)
</script>
<div id="content-list">
<div style="text-align:right;margin-bottom:5px;">
	<form action="admin.php" method="get">
		<input type="hidden" name="page" value="pn-bills"/>
		<input type="text" name="s" value="[SEARCH]"/> <input type="submit" value="Search" />
	</form>
</div>
<table class="widefat fixed" cellspacing="0" id="table-content">
<thead>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-bills&p=[PAGE]&o=bill_id,[ORDER]&s=[SEARCH]">Bill ID</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-bills&p=[PAGE]&o=measure_title,[ORDER]&s=[SEARCH]">Measure Title</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-bills&p=[PAGE]&o=report_title,[ORDER]&s=[SEARCH]">Report Title</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-bills&p=[PAGE]&o=description,[ORDER]&s=[SEARCH]">Description</a></th>
	<th scope="col" class="manage-column" style="">Introducer</a></th>
	<th scope="col" class="manage-column edit-buttons" style="">-</th>
</tr>
</thead>

<tfoot>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-bills&p=[PAGE]&o=bill_id,[ORDER]&s=[SEARCH]">Bill ID</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-bills&p=[PAGE]&o=measure_title,[ORDER]&s=[SEARCH]">Measure Title</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-bills&p=[PAGE]&o=report_title,[ORDER]&s=[SEARCH]">Report Title</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-bills&p=[PAGE]&o=description,[ORDER]&s=[SEARCH]">Description</a></th>
	<th scope="col" class="manage-column" style="">Introducer</a></th>
	<th scope="col" class="manage-column edit-buttons" style="">-</th>
</tr>
</tfoot>
<tbody id="bills" class="">
[STRRESULT]
</tbody>
</table>
<div id="pagination">[STRPAGES]</div>
<div><a href="#delete" class="button delete-h2">Delete bills</a></div>
</div>

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

<script type="text/javascript">
	
	var selected_item;

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
			
			//alert(url)
			
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
	
	/*
	jQuery("#sVotes").change(function(){
		var r = jQuery.parseJSON(jQuery("#form-edit input[name=votes]").val())
		r[jQuery("#sLegislators").val()].vote = jQuery(this).val();		
		jQuery("#form-edit input[name=votes]").val(jQuery.toJSON(r))
		if (jQuery(this).val() == 0) jQuery("#sLegislators").find("option:selected").text(r[jQuery("#sLegislators").val()].name)
		else jQuery("#sLegislators").find("option:selected").text("- [Voted] " + r[jQuery("#sLegislators").val()].name)
		
	}) 
	*/
	
	jQuery("table tbody a.delete").click(function () {	
		var id = jQuery(this).parent().parent().find("input[type=checkbox]").val();
		jQuery("#form-delete input[name=delete]").val(id)
		jQuery("#form-delete").submit();
	})
	
	
	jQuery("a.submit-cancel-h2").click(function () {
		jQuery("#opacity-edit").fadeTo("slow", 0, function(){
			jQuery("#opacity-edit").hide(0)
		});
		jQuery("#edit-window").hide("slow");
	})
	
	
	jQuery("a.add-new-h2").click(function () {
		jQuery("#add-list").slideToggle();
	})
	
	
	jQuery("a.submit-new-h2").click(function () {
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
		jQuery("#form-edit input[name=votes]").val(jQuery.toJSON(o))
		jQuery("#form-edit").submit();
	})
	
	
	jQuery("a.delete-h2").click(function () {
		var t = new Array();
		jQuery("#table-content input[type=checkbox]:checked").each(function(){
			t.push(jQuery(this).val())
		});		
		jQuery("#form-delete input[name=delete]").val(t.join(","))
		jQuery("#form-delete").submit();
	})
</script>