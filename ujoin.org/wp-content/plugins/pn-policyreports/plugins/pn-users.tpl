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
	#action-window a {
		font-size: 12px;
	}
	#action-window {
		height: 250px;
		overflow-y: scroll;
		border: 1px solid #CCC;
		padding: 10px 10px 10px 10px;
	}
</style>
<form action="admin.php?page=pn-users" method="post" enctype="multipart/form-data" id="form-delete">
		<input type="hidden" name="delete" value="" />
</form>
<div id="opacity-edit" style="display:none;"></div>
<div id="edit-window" style="display:none;">
	<form action="admin.php?page=pn-users" method="post" enctype="multipart/form-data" id="form-edit">
		<input type="hidden" name="edit" value="true" />
		<input type="hidden" name="committee" value="" />
		<div class="content-window"></div>
		<br/>
		<h2>Action pages</h2>
		<div id="action-window"></div>
		<br/>
		<div><a href="#submit_edit" class="button submit-edit-h2">Save</a> <a href="#submit_cancel" class="button submit-cancel-h2">Cancel</a></div>
	</form>
</div>

<h2>Users</h2>
<div id="plug-actions"><a href="#add_new" class="button add-new-h2">Add new user</a></div>
[STRMESSAGE]
<div id="add-list"> 
<form action="admin.php?page=pn-users" method="post" enctype="multipart/form-data" id="form-submit">
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
			<td scope="col" class="manage-column" style="">Username:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="username"/></td>
			<td scope="col" class="manage-column" style="">Email:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="email"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">First Name:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="firstname"/></td>
			<td scope="col" class="manage-column" style="">Last Name:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="lastname"/></td>
		</tr>
		<tr>
			<td scope="col" class="manage-column" style="">Password:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="password" /></td>
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
		<input type="hidden" name="page" value="pn-users"/>
		<input type="text" name="s" value="[SEARCH]"/> <input type="submit" value="Search" />
	</form>
</div>
<table class="widefat fixed" cellspacing="0" id="table-content">
<thead>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-users&p=[PAGE]&o=user_login,[ORDER]&s=[SEARCH]">Username</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-users&p=[PAGE]&o=user_email,[ORDER]&s=[SEARCH]">Email</a></th>
	<th scope="col" class="manage-column" style="">First Name</a></th>
	<th scope="col" class="manage-column" style="">Last Name</a></th>
	<th scope="col" class="manage-column" style="">Type</a></th>
	<th scope="col" class="manage-column edit-buttons" style="">-</th>
</tr>
</thead>

<tfoot>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-users&p=[PAGE]&o=user_login,[ORDER]&s=[SEARCH]">Username</a></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-users&p=[PAGE]&o=user_email,[ORDER]&s=[SEARCH]">Email</a></th>
	<th scope="col" class="manage-column" style="">First Name</th>
	<th scope="col" class="manage-column" style="">Last Name</th>
	<th scope="col" class="manage-column" style="">Type</th>
	<th scope="col" class="manage-column" style=""> </th>
</tr>
</tfoot>
<tbody id="bills" class="">
[STRRESULT]
</tbody>
</table>
<div id="pagination">[STRPAGES]</div>
<div><a href="#delete" class="button delete-h2">Delete username</a></div>
</div>
<select id="sCommittees" style="display:none;">[STRCOMM]</select>
<script type="text/javascript">

	jQuery("table tbody a.edit").click(function () {
	
		jQuery("#form-edit .content-window").html(jQuery("#form-submit .content-window").html())
		var d = jQuery.parseJSON(jQuery(this).parent().find("input[name=data]").val());
		var a = jQuery.parseJSON(jQuery(this).parent().find("input[name=actions]").val());
		
		jQuery("#action-window").html("")
		var ti = "";
		for (var i=0; i<a.length; i++) {
			if (ti != a[i].type) {
				ti = a[i].type
				jQuery("#action-window").append("<h4>"+a[i].type+"</h4>");
			}
			jQuery("#action-window").append("<a href='"+a[i].url+"' target='_blank'>"+a[i].title+"</a><br/><br/>");
		}
		
		
		jQuery("#form-edit input[name=edit]").val(d.id);
		jQuery("#form-edit input[name=username]").val(d.username);
		jQuery("#form-edit input[name=email]").val(d.email);
		jQuery("#form-edit input[name=firstname]").val(d.firstname);
		jQuery("#form-edit input[name=lastname]").val(d.lastname);
						
		jQuery("#opacity-edit").fadeTo("slow", 0.6);
		jQuery("#edit-window").show("slow");				
		jQuery("#sLegsComm").trigger("change")		
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