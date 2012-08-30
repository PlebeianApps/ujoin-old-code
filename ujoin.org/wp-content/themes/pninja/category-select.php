<?PHP
	global $cat_select_id, $selected_value, $pn_tables;
	$leadder = $wpdb->get_results("SELECT id, title FROM $pn_tables->form_category", ARRAY_A);
?>
<select <?=isset($cat_select_id) ? "id=\"$cat_select_id\"" : '';?>>
<?PHP foreach($leadder as $key):?>
<option <?=$selected_value == $key['id'] ? 'selected="selected"' : ''?> value="<?=$key['id'];?>"><?=$key['title'];?></option>
<?PHP endforeach;?>
</select>
<?PHP $selected_value = null; ?>