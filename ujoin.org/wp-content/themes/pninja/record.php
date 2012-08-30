<!--<div style="float:right; width:380px;pading-left:10px">
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/record.js"></script>
	<?PHP
		global $record_msg;
		if(isset($record_msg) && trim($record_msg) != ''):
	?>
	<p style="line-height:normal;padding-top:10px;"><a id="actionButton" href="javascript:action();">Click Here</a> <span class="hideMsg"><?=$record_msg;?></span></p>
	<?PHP else:?>
	<a id="actionButton" href="javascript:action();">Record</a>
	<?PHP endif;?>
	<div id="recorder" style="overflow:hidden;">
		<object id="nimbb" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="240" codebase= "http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
			<param name="movie" value="http://player.nimbb.com/nimbb.swf?mode=record&simplepage=1&showmenu=0&key=59f61d716f&lang=en" />
			<param name="allowScriptAccess" value="always" />
			<embed name="nimbb" src="http://player.nimbb.com/nimbb.swf?mode=record&simplepage=1&showmenu=0&key=59f61d716f&lang=en" width="320" height="240" allowScriptAccess="always" pluginspage="http://www.adobe.com/go/getflashplayer"></embed>
		</object>
	</div>
</div>-->
<div style="float:right; width:380px;pading-left:10px">
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/record.js"></script>
	<?PHP
		global $record_msg;
		if(isset($record_msg) && trim($record_msg) != ''):
	?>
	<p style="line-height:normal;padding-top:10px;"><a id="actionButton" href="javascript:showPlayer();">Click Here</a> <span class="hideMsg"><?=$record_msg;?></span></p>
	<?PHP else:?>
	<p style="line-height:normal;padding-top:10px;"><a id="actionButton" href="javascript:showPlayer();">Record</a></p>
	<?PHP endif;?>
	<div id="recorder" style="display:none;">
<object id="nimbb-recorder" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="320" height="240" codebase= "http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
<param name="movie" value="http://player.nimbb.com/nimbb.swf?mode=record&simplepage=1&key=59f61d716f&lang=en" />
<param name="allowScriptAccess" value="always" />
<embed name="nimbb-recorder" src="http://player.nimbb.com/nimbb.swf?mode=record&simplepage=1&key=59f61d716f&lang=en" width="320" height="240" allowScriptAccess="always" pluginspage="http://www.adobe.com/go/getflashplayer">
</embed>
</object>
	</div>
</div>