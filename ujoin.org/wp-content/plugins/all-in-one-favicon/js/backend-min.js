jQuery(document).ready(function(a){a("td").each(function(d,e){var c;var b;$nestedElement=a(e).children("input.aioFaviconUpload");$nestedElement.click(function(){$textInput=a(this).siblings(".aioFaviconUrl");textInputId=$textInput.attr("id");tb_show("","media-upload.php?type=image&TB_iframe=true");return false})});window.send_to_editor=function(b){imgurl=jQuery("img",b).attr("src");$test=jQuery("#aio-favicon_settings-backendGIF").val();$textvalBefore=jQuery("input#"+textInputId).val();jQuery("input#"+textInputId).val(imgurl);$textvalAfter=jQuery("input#"+textInputId).val();$a="asdf";tb_remove()}});