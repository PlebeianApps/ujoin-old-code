<?PHP 
global $form_query;
if(trim($form_query['youtube']) != ''):
?>
<li><a href="#">
	<h6>Support Video</h6>
</a></li>
<?PHP
if(strpos($form_query['youtube'], 'nimbb.com') > 0):
	$url = $form_query['youtube'];
	$tmp = explode('/', $form_query['youtube']);
	$guid = array_pop($tmp);
?>
<li style="border:0;text-align:center;">
<a href="#" onclick="return false;">
	<object id="nimbb" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="240" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
<param name="movie" value="http://player.nimbb.com/nimbb.swf?lang=en&guid=<?=$guid?>" /><param name="allowScriptAccess" value="always" />
<embed name="nimbb" src="http://player.nimbb.com/nimbb.swf?lang=en&guid=<?=$guid?>" width="320" height="240" allowScriptAccess="always" pluginspage="http://www.adobe.com/go/getflashplayer"></embed>
</object></a>
</li>
<?PHP else:?>
<li style="border:0;"><a class="youtubesmall" style="border:0; padding-top:0;" href="<?=$form_query['youtube'];?>">My great YouTube video</a></li>
<?PHP endif;?> 
<?PHP endif;?>