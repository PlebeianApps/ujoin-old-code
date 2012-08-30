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
		width: 40% !important;
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
		position: absolute;
		top: 0;
		left: 0;
	}
	#edit-window {
		z-index: 3;
		width: 600px;
		margin-left: -300px;
		position: absolute;
		left: 50%;
		background-color: #FFF;
		padding: 20px 20px 20px 20px;
	}
</style>


<form action="admin.php?page=pn-cycles" method="post" enctype="multipart/form-data" id="form-delete">
		<input type="hidden" name="delete" value="" />
		<input type="hidden" name="type" value="" />
</form>


<div id="opacity-edit" style="display:none;"></div>
<div id="edit-window" style="display:none;">
	<form action="admin.php?page=pn-cycles" method="post" enctype="multipart/form-data" id="form-edit">
		<input type="hidden" name="edit" value="true" />
		<input type="hidden" name="type" value="" />
		<div class="content-window"></div>
		<br/>
		<div><a href="#submit_edit" class="button submit-edit-h2">Save</a> <a href="#submit_cancel" class="button submit-cancel-h2">Cancel</a></div>
	</form>
</div>


<h2>Cycles</h2>
<div id="plug-actions"><a href="#add_new" class="button add-new-h2">Add new cycle</a></div>
[STRMESSAGE]


<div id="add-list"> 
<form action="admin.php?page=pn-cycles" method="post" enctype="multipart/form-data" id="form-submit">
<input type="hidden" name="add" value="true" />
<div class="content-window">
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr class="thead">
			<th scope="col" class="manage-column" style="">Field</th>
			<th scope="col" class="manage-column" style="">Value</th>
		</tr>
	</thead>
	<tbody class="">
		<tr>
			<td scope="col" class="manage-column" style="">Title:</td>
			<td scope="col" class="manage-column" style=""><input type="text" name="title"/></td>
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
<table class="widefat fixed" cellspacing="0" id="table-content">
<thead>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-cycles&p=[PAGE]&o=title,[ORDER]">Title</a></th>
	<th scope="col" class="manage-column edit-buttons" style="">-</th>
</tr>
</thead>
<tfoot>
<tr class="thead">
	<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox" /></th>
	<th scope="col" class="manage-column" style=""><a href="admin.php?page=pn-cycles&p=[PAGE]&o=title,[ORDER]">Title</a></th>
	<th scope="col" class="manage-column" style=""> </th>
</tr>
</tfoot>
<tbody class="">
[STRRESULT]
</tbody>
</table>
<div><a href="#delete" class="button delete-cycle-h2">Delete a cycle</a></div>
</div>


<script type="text/javascript">
	jQuery("table tbody a.edit").click(function () {
		jQuery("#form-edit .content-window").html(jQuery("#form-submit .content-window").html())
		var d = jQuery.parseJSON(jQuery(this).parent().find("input[type=hidden]").val());
		jQuery("#form-edit input[name=title]").val(d.title);
		jQuery("#form-edit input[name=edit]").val(d.id);	
		jQuery("#opacity-edit").fadeTo("slow", 0.6);
		jQuery("#edit-window").show("slow");		
	})
	jQuery("table tbody a.delete").click(function () {	
		var id = jQuery(this).parent().parent().find("input[type=checkbox]").val();
		var d = jQuery.parseJSON(jQuery(this).parent().find("input[type=hidden]").val());
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
	jQuery("a.delete-cycle-h2").click(function () {
		var t = new Array();
		jQuery("#table-content input[type=checkbox]:checked").each(function(){
			t.push(jQuery(this).val())
		});		
		jQuery("#form-delete input[name=delete]").val(t.join(","))
		jQuery("#form-delete").submit();
	})
</script>