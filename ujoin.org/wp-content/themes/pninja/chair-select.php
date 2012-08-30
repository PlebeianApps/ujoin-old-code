<?PHP
	global $chair_select_id, $selected_value, $pn_tables;
	$leadder = $wpdb->get_results("SELECT id, name FROM $pn_tables->form_leader", ARRAY_A);
?>
<select <?=isset($chair_select_id) ? "id=\"$chair_select_id\"" : '';?>>
<?PHP foreach($leadder as $key):?>
<option <?=$selected_value == $key['id'] ? 'selected="selected"' : ''?> value="<?=$key['id'];?>"><?=$key['name'];?></option>
<?PHP endforeach;?>
</select>
<?PHP $selected_value = null; ?>