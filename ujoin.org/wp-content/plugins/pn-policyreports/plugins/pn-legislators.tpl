<script src="http://www.policyninja.org/wp-content/plugins/pn-policyreports/js/jquery.json-2.2.min.js" type="text/javascript"></script>
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
	#add-list div, #content-list div {
		margin: 15px 15px 0px 0px;
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
	#sLegsComm {
		width: 400px;
	}
</style>
<form action="admin.php?page=pn-legislators" method="post" enctype="multipart/form-data" id="form-delete">
		<input type="hidden" name="delete" value="" />
</form>
<div id="opacity-edit" style="display:none;"></div>
<div id="edit-window" style="display:none;">
	<form action="admin.php?page=pn-legislators" method="post" enctype="multipart/form-data" id="form-edit">
		<input type="hidden" name="edit" value="true" />
		<input type="hidden" name="committee" value="" />
		<div class="content-window"></div>
		<br/>
		<div>
			<select id="sLegsComm"></select> : 
			<select id="sLegsType">
				<option value="0">None</option><option value="1">Chair</option><option value="2">Vicechair</option><option value="3">Member</option>
			</select> 
		</div>
		<br/>
		<div><a href="#submit_edit" class="button submit-edit-h2">Save</a> <a href="#submit_cancel" class="button submit-cancel-h2">Cancel</a></div>
	</form>
</div>

<h2>Parse the webservice <a href="admin.php?page=pn-legislators&parse=true" class="button parse-new-h2">Execute</a></h2>
<div id="plug-actions"><a href="#add_new" class="button add-new-h2">Add new legislator</a></div>
[STRMESSAGE]
<div id="add-list"> 
<form action="admin.php?page=pn-legislators" method="post" enctype="multipart/form-data" id="form-submit">
<input type="hidden" name="add" value="true" />
<div class="content-window">
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr class="thead">
			<th scope="col" id="cb" class="manage-column" style="">Field</th>
			<th scope="col" id="bill-id" class="manage-column" style="">Value</th>
			<th scope="col" id="measure-title" class="manage-column" style="">Field</th>
			<th scope="col" id="report-title" class="manage-column" style="">Value</th>
		</tr>
	</thead>
	<tbody class="">
		<tr>
			<td scope="col" class="manage-column" style="">Govtrack ID:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="govtrack_id"/></td>
			<td scope="col" class="manage-column" style="">First Name:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="firstname"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Title:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="title"/></td>
			<td scope="col" class="manage-column" style="">Middle Name:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="middlename"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">District:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="district"/></td>
			<td scope="col" class="manage-column" style="">Last Name:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="lastname"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">CRP ID:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="crp_id"/></td>
			<td scope="col" class="manage-column" style="">Cycle</td>
			<td scope="col" class="manage-column" style=""><select name="cycle">[STRCYCLES]</select></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Address:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="address"/></td>
			<td scope="col" class="manage-column" style="">Phone:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="phone"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Fax:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="fax"/></td>
			<td scope="col" class="manage-column" style="">Email:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="email"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Party:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="party"/></td>
			<td scope="col" class="manage-column" style=""></td>
			<td scope="col" class="manage-column" style=""></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Image:</td>
			<td scope="col" class="manage-column" style=""><input type="file" name="image"/></td>
			<td scope="col" class="manage-column" style=""></td>
			<td scope="col" class="manage-column" style=""></td>
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
		<input type="hidden" name="page" value="pn-legislators"/>
		<input type="text" name="s" value="[SEARCH]"/> <input type="submit" value="Search" />
	</form>
</div>
<table class="widefat fixed" cellspacing="0" id="table-content">
<thead>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=govtrack_id,[ORDER]&s=[SEARCH]">Govtrack ID</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=crp_id,[ORDER]&s=[SEARCH]">CRP ID</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=firstname,[ORDER]&s=[SEARCH]">Name</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=district,[ORDER]&s=[SEARCH]">District</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=title,[ORDER]&s=[SEARCH]">Title</a></th>
	<th scope="col" class="manage-column edit-buttons" style="">-</th>
</tr>
</thead>

<tfoot>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=govtrack_id,[ORDER]&s=[SEARCH]">Govtrack ID</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=crp_id,[ORDER]&s=[SEARCH]">CRP ID</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=firstname,[ORDER]&s=[SEARCH]">Name</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=district,[ORDER]&s=[SEARCH]">District</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-legislators&p=[PAGE]&o=title,[ORDER]&s=[SEARCH]">Title</a></th>
	<th scope="col" class="manage-column" style=""> </th>
</tr>
</tfoot>
<tbody id="bills" class="">
[STRRESULT]
</tbody>
</table>
<div id="pagination">[STRPAGES]</div>
<div><a href="#delete" class="button delete-h2">Delete legislator</a></div>
</div>
<select id="sCommittees" style="display:none;">[STRCOMM]</select>
<script type="text/javascript">

	jQuery("table tbody a.edit").click(function () {
	
		jQuery("#form-edit .content-window").html(jQuery("#form-submit .content-window").html())
		var d = jQuery.parseJSON(jQuery(this).parent().find("input[name=data]").val());
		var c = jQuery(this).parent().find("input[name=committe]").val();
		jQuery("#form-edit input[name=committee]").val(c);
		
		jQuery("#form-edit input[name=edit]").val(d.id);
		jQuery("#form-edit input[name=govtrack_id]").val(d.govtrack_id);
		jQuery("#form-edit input[name=title]").val(d.title);
		jQuery("#form-edit input[name=firstname]").val(d.firstname);
		jQuery("#form-edit input[name=middlename]").val(d.middlename);
		jQuery("#form-edit input[name=lastname]").val(d.lastname);
		jQuery("#form-edit input[name=district]").val(d.district);
		jQuery("#form-edit input[name=crp_id]").val(d.crp_id);
		
		jQuery("#form-edit input[name=address]").val(d.address);
		jQuery("#form-edit input[name=phone]").val(d.phone);
		jQuery("#form-edit input[name=fax]").val(d.fax);
		jQuery("#form-edit input[name=email]").val(d.email);
		jQuery("#form-edit input[name=party]").val(d.party);

		jQuery("#sLegsComm").html(jQuery("#sCommittees").html());
		
		var h = jQuery.parseJSON(c);
		for (var i=0; i<h.length; i++) {
			var t = jQuery("#sLegsComm").find("option[value="+h[i].comm_id+"]").text()
			jQuery("#sLegsComm").find("option[value="+h[i].comm_id+"]").text("---- [JOINED] " + t);			
		}
		jQuery("#form-edit").find("select option[value="+d.cycle+"]").attr("selected", "selected");				
		jQuery("#opacity-edit").fadeTo("slow", 0.6);
		jQuery("#edit-window").show("slow");				
		jQuery("#sLegsComm").trigger("change")		
	})	
	
	
	
	jQuery("#sLegsComm").change(function(){
		
		var c  = jQuery.parseJSON(jQuery("#form-edit input[name=committee]").val());
		for (var i=0; i<c.length;i++) {
			if (c[i].comm_id == jQuery(this).val()) {
				jQuery("#sLegsType").find("option[value="+c[i].rank+"]").attr("selected", "selected")
				return;
			}
		}
		jQuery("#sLegsType").find("option[value=0]").attr("selected", "selected")
	})
	
	
	
	jQuery("#sLegsType").change(function(){
		
		var c  = jQuery.parseJSON(jQuery("#form-edit input[name=committee]").val());
		var s = jQuery("#sLegsComm").val();
		
		for (var i=0; i<c.length;i++) {
			if (c[i].comm_id == s) {
				c[i].rank = jQuery(this).val();
				
				var t = jQuery("#sCommittees").find("option[value="+c[i].comm_id+"]").text()				
				if (c[i].rank == 0) jQuery("#sLegsComm").find("option[value="+c[i].comm_id+"]").text(t)
				else jQuery("#sLegsComm").find("option[value="+c[i].comm_id+"]").text("---- [JOINED] " + t)
				
				jQuery("#form-edit input[name=committee]").val(jQuery.toJSON(c));
				return;
			}
		}
		c.push({comm_id:s, rank:jQuery(this).val()})
		var l = c.length-1;
		var t = jQuery("#sCommittees").find("option[value="+c[l].comm_id+"]").text()				
		if (c[l].rank == 0) jQuery("#sLegsComm").find("option[value="+c[l].comm_id+"]").text(t)
		else jQuery("#sLegsComm").find("option[value="+c[l].comm_id+"]").text("---- [JOINED] " + t)
		
		jQuery("#form-edit input[name=committee]").val(jQuery.toJSON(c));
	})
	
	
	
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