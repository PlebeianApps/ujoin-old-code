<?php
/*
Template Name: Inside Testimony
*/
?>
<?PHP
	global $pn_tables;
	$form_table = $pn_tables->form_testimony;
	$form_var = 'letter';
	$form_query = array();
	
	validate_letter();
	
	$letter = $wp_query->query_vars[$form_var];
	
	$form_query = $form_query[0];
	
	$sql = "SELECT bill_id FROM wp_pn_bills_search_results WHERE id = ".$form_query['bill']." LIMIT 1;";
	
	$billName = $wpdb->get_var($sql);
	
	function get_form_value($data, $key){
		return ' value="'.$data[$key].'" ';
	}
	
	$guest = false;
	if(isset($_REQUEST['key']) && trim($_REQUEST['key']) != ''){
		$key = $_REQUEST['key'];
		$sql = "SELECT COUNT(*) FROM $pn_tables->guest_users WHERE `key` = '$key' AND page_id = $letter AND type = 'testimony';";
		$guest = $wpdb->get_var($sql) > 0 ? true : false;
	}else if(is_user_logged_in()){
		//if($form_query['wuid'] !=  get_user_group() && !user_is_admin()) $guest = false;
	}
	
?>
<?php get_header() ?>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.jfeed.pack.js"></script>
<script type="text/javascript">
	jQuery.getFeed({
        	url: '<?php bloginfo('stylesheet_directory') ?>/proxy.php?url=<?= $form_query['rss']; ?>',
        	success: function(feed) {    
    	        jQuery('#rss-feed').append('<h2>'+ '<a href="' + feed.link + '">' + feed.title + '</a>' + '</h2>');
            	var html = '';
            	for(var i = 0; i < feed.items.length && i < 5; i++) {
                	var item = feed.items[i];
           	     	html += '<h3>' + '<a href="' + item.link + '">' + item.title + '</a>' + '</h3>';
           	     	html += '<div class="updated">' + item.updated + '</div>';
                	html += '<div>' + item.description + '</div>';
            	}
            	jQuery('#rss-feed').append(html);
        	}    
    	});
</script>
<?php if ( ($form_query['wuid'] ==  get_user_group() || user_is_admin() || $guest) && !isset($_REQUEST['public'])) { ?>
<script type="text/javascript">
var _action = 'edit';
var _email = '<?=$current_user->user_email;?>';
var _letter = <?=$letter?>;
</script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/testimony.js"></script>

<script type="text/javascript">
	_billId = <?=$form_query['bill']?>;
	_updateBillUrl = '<?=home_url('/')?>?page_id=256';
	<?PHP if($guest):?>
	$(document).ready(function(){
		$('#newBill input').attr('disabled', 'disabled');
		$('#newBill select').each(function(){
			var target = $(this);
			var val = $('option:selected', target).text();
			var id = target.attr('id');
			var input = '<input type="text" disabled="disabled" value="'+val+'" id="'+id+'" class="text" size="40"/>';
			var parent = target.parent().parent();
			target.parent().remove();
			parent.append(input);
		});
		$('#newBill textarea').attr('disabled', 'disabled').css('height', 'auto');
		try{
			$('#newBill textarea').wysiwyg('destroy');
		}catch($error){}
		$('#newBill textarea').each(function(){
			$(this).replaceWith('<div style="color: #777777;">'+$(this).val()+'</div>');
		});
		$('#f-submit').hide();
		
		
	});
	<?PHP endif;?>
</script>


<div id="content-page">              

		<div id="contentLeft">
        	<?PHP
        		$support = 'Support for';
        		if($form_query['statment'] == '1'){
        			$support = 'Strong support for';
        		}else if($form_query['statment'] == '2'){
        			$support = 'Opposition for';
        		}else if($form_query['statment'] == '3'){
        			$support = 'Strong opposition for';
        		}
        	?>
            <span class="contentLeftTitle"><span>
            	<?=$support?>: <?=$billName;?></span>
            </span>
            <ul>
            <?PHP if(!$guest):?>
            	<li style="display:none;"><a href="#" id="addUpdate">Add Update</a></li>
            	<li><a href="#" id="editPage">Edit Testimony</a></li>
            	<li><a href="#" id="deleteLetter">Delete Testimony</a></li>
              <?PHP if(!testimony_exists($form_query['bill'])):?>
              	<li><a href="<?=home_url('/');?>?page_id=191&template=testimony&template_id=<?=$letter?>">Duplicate this to: Testimony Action Page</a></li> 
              <?PHP endif; ?>
              <?PHP if(!advocacy_exists($form_query['bill'])):?>
              	<li><a href="<?=home_url('/');?>?page_id=176&template=testimony&template_id=<?=$letter?>">Duplicate this to: Advocacy Action Page</a> </li>
              <?PHP endif; ?>
              <?PHP if(!letter_exists($form_query['bill'])):?>
              	<li><a href="<?=home_url('/');?>?page_id=172&template=testimony&template_id=<?=$letter?>">Duplicate this to: Letter Action Page</a> </li>
              <?PHP endif; ?>
              <?PHP if(!petition_exists($form_query['bill'])):?>
              	<li><a href="<?=home_url('/');?>?page_id=178&template=testimony&template_id=<?=$letter?>">Duplicate this to: Petition Action Page</a></li>    <?PHP endif; ?>
              	<?PHP else:?>
              	<li><a href="#">
                	<h6>Support Video</h6>
                </a></li>  
            	<li style="border:0;"><a class="youtubesmall" style="border:0; padding-top:0;" href="<?=$form_query['youtube'];?>">Video</a></li> 
              	<?PHP endif;?>
            </ul>
            <?php get_template_part( 'billupdates'); ?> 
            <div id="rss-feed"></div>
             <div style="clear:both;" class="socialnetwork">
 <span class='st_facebook_large' st_title='Policy Ninja' st_image='http://www.policyninja.org/wp-content/themes/pninja/images/logo.png' st_description='Take Action Now! <?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?>' st_url='<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>' displayText='Share it'></span>
             <span class='st_twitter_large' st_title='Policy Ninja' st_url='<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>' displayText='Share it'></span>
             <span class='st_blogger_large' st_title='Policy Ninja' st_url='<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>' displayText='Share it'></span>
             </div>
        </div>
        
   <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>Edit Testimony</h1>    
                    <p>Edit your action page here. If you are unsure about a certain data field, mouse over the "?" images.</p>
                    <p style="font-size:10px;">Public URL: <a href="<?php echo get_current_url().'&public'?>"><?php echo get_current_url().'&public'?></a></p>                                    
                    <form id="f-letter">    
                  	<ul id="newBill" style="padding:4px 0 0;">
                        <li>
                          <label class="labelLeft">Position Statement:</label>
                          <select id="f-position">
                            <option value="0" <?=$form_query['statment'] == '0' ? 'selected="selected"' : '';?>>Support for</option>
                            <option value="1" <?=$form_query['statment'] == '1' ? 'selected="selected"' : '';?>>Strong support for</option>
                            <option value="2" <?=$form_query['statment'] == '2' ? 'selected="selected"' : '';?>>Opposition to</option>
                            <option value="3" <?=$form_query['statment'] == '3' ? 'selected="selected"' : '';?>>Strong opposition to</option>		
                          </select>
                        </li>                      

                        <li><label class="labelLeft">Name of Bill</label><input value="<?=$billName;?>" id="f-name" type="text" size="40" class="text"/></li>
                        <li><label class="labelLeft">To</label><input <?=get_form_value($form_query, 'to');?> id="f-to" type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">BCC</label><input <?=get_form_value($form_query, 'bbc');?> id="f-bcc" type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">Date</label><input <?=get_form_value($form_query, 'date');?> id="f-date" type="date" size="40" class="text"></li>
                        <li><label class="labelLeft">URL</label><input <?=get_form_value($form_query, 'url');?> id="f-url" type="url" size="40" class="text"></li>
                        <li><label class="labelLeft">RSS update URL</label><input <?=get_form_value($form_query, 'rss');?> id="f-rss" type="url" size="40" class="text"></li>
                        <li><label class="labelLeft">Committee</label>
                       		<select id="f-committee">
                       		<?PHP
                       			$sql = "SELECT id AS comm_id, name FROM $pn_tables->committee;";
                       			$query = $wpdb->get_results($sql, ARRAY_A);
                       			foreach($query as $data):
                       				$selected = $form_query['committee'] == $data['comm_id'] ? 'selected="selected"' : '';
                       		?>
                       			<option <?=$selected?> value="<?=$data['comm_id'];?>"><?=$data['name'];?></option>
                       		<?PHP endforeach;?>
                       		</select>
                       	</li>
                        <li style="display:none;">
                          <label class="labelLeft">Chair:</label>
                          <input id="f-chair" type="text" size="40" class="text" disabled="disabled">
                        </li>  
                        <li style="display:none;">
                          <label class="labelLeft">Vice Chair:</label>
                          <input id="f-vchair" type="text" size="40" class="text" disabled="disabled">
                        </li>                                                  
                        <li>
                          <label class="labelLeft">Category</label>
                         	<?php $cat_select_id = 'f-category'; $selected_value = $form_query['category']; get_template_part( 'category-select' ); ?>
                        </li>    
                        <li><label class="labelLeft">Description of the Bill</label><textarea id="f-description" rows="5" cols="40" class="ss"><?=$form_query['description']?></textarea></li>
                        <li><label class="labelLeft">Sample Talking Points</label><textarea id="f-talking" rows="5" cols="40" class="uniform"><?=$form_query['talking_points']?></textarea></li>
                        <li><label class="labelLeft">Sample Testimony</label><textarea id="f-testimony" rows="5" cols="40" class="uniform"><?=$form_query['testimony']?></textarea></li>
                        <?PHP if(!$guest):?>
                        <li><label class="labelLeft">Sample Video</label><input id="f-video"  <?=get_form_value($form_query, 'youtube');?> type="url" size="40" class="text"></li>
                         <li>
                        	<label class="labelLeft">Or record your video</label>
                        	<?php get_template_part( 'record' ); ?> 
                        </li>
                        <li><label class="labelLeft">Public Action Page</label>
                       		<select id="f-public">
                       			<option <?=$form_query['status'] == '1' ? 'selected="selected"' : ''?> value="1">Yes</option>
                       			<option <?=$form_query['status'] != '1' ? 'selected="selected"' : ''?> value="2">No</option>
                       		</select>
                       	</li>
                       	<li><label class="labelLeft">Users can post video?</label>
                       		<select id="f-nimbb">
                       			<option <?=$form_query['nimbb'] == '1' ? 'selected="selected"' : ''?> value="1">Yes</option>
                       			<option <?=$form_query['nimbb'] != '1' ? 'selected="selected"' : ''?> value="0">No</option>
                       		</select>
                       	</li>
                       	<?PHP endif;?>

                      </ul>
                      <?PHP if(!$guest):?>     
                      <input class="superboton" type="button" id="f-submit" />
                      <?PHP endif; ?>
                      </form>
                      <?PHP if(!$guest):?>
                      <div id="testimonyTabs">
<?PHP
						$sql = "SELECT id, CONCAT_WS(' ', first_name, last_name)AS name, email, published FROM $pn_tables->form_user WHERE parent_table = 'pn_form_testimony' AND parent = ".$letter;
						$letters = $wpdb->get_results($sql, ARRAY_A);
?>
                        <div class="tabHeader">Submitted Testimony</div>
                        <div class="tabContent">
                            <a href="#" class="firstRow">
                                <span class="rowDescription">
                                <span class="rowTitle">
                                	<span><?=count($letters)?></span> people have submitted testimony for this bill so far.</span>
                                </span>
                            </a>
                        <?PHP foreach($letters as $key):?>
							<a href="<?php bloginfo('url');?>/?p=205&letter=<?=$key['id'];?>" class="tabContentRow">
								<span class="billName"><?=$key['name'];?></span>
                                <span class="billMail"><?=$key['email'];?></span>
                                <span class="billTestimony"><?=$key['published'];?></span>
                                <span class="billMore">Click to read more...</span>
							</a>
						<?PHP endforeach;?>                                                                       
                        </div> 
                  
                    </div>
                    <?PHP if(get_user_id() == get_user_group()):?>
                    <script type="text/javascript">
                    	$(document).ready(function(){
                    		$('#export-testimony').click(function(){
                    			var url = getURL("exportPage", [_letter,'pn_form_testimony']);
                    			window.location.href = url;
                    			return false;
                    		});
                    	});
                    </script>
                    <input class="superboton" type="button" id="export-testimony" value="Export to CSV" />
                    <?PHP endif;?>             
                      <form id="f-update" style="display:none;">
                      	<ul  style="padding:4px 0 0;">
                      		<li><label class="labelLeft">Committee</label>
                      			<select id="u-committee">
                      			<option value="0">N/A</option>
	                       		<?PHP
	                       			$sql = "SELECT comm_id, name FROM $pn_tables->committee;";
	                       			$query = $wpdb->get_results($sql, ARRAY_A);
	                       			foreach($query as $data):
	                       				$selected = $form_query['committee'] == $data['comm_id'] ? 'selected="selected"' : '';
	                       		?>
	                       			<option <?=$selected?> value="<?=$data['comm_id'];?>"><?=$data['name'];?></option>
	                       		<?PHP endforeach;?>
	                       		</select>
                      		</li>
                      		<li><label class="labelLeft">Date</label><input id="u-date" type="date" size="40" class="text"></li>
                      		<li><label class="labelLeft">Vote</label>
                      			<select id="u-vote">
                      				<option value="0">N/A</option>
                      				<option value="1">Passed</option>
                      				<option value="2">Killed</option>
                      				<option value="3">Deferred</option>
                      			</select>
                      		</li>
                      		<li><label class="labelLeft">Address</label><input id="u-address" type="text" size="40" class="text"></li>
                      		<li><label class="labelLeft">Youtube link</label><input id="u-youtube" type="text" size="40" class="text"></li>
                      	</ul>
                      	<input class="superboton" type="button" id="u-submit" />
                      </form>
                      <div id="updateTabs" style="display:none;">
                      <a style="clear:both;margin-left:40px;" href="<?=home_url('/')?>/?page_id=256">Edit Bill</a>
                      <script type="text/javascript">
                      	var _billUpdtate = {};
                      	var _billUpdtateID = null;
                      	$(document).ready(function(){
                      		$('#updateTabs a').click(function(){
                      			var id = $(this).parent().parent().attr('id');
                      			_billUpdtateID = id.split('bill_update_')[1];
                      			var data = _billUpdtate[id];
                      			if(!data) return false;	
                      			var val = $('#u-committee option[value='+data.committte+']').attr('selected', 'selected').text();
                      			$('#u-committee').parent().find('span').text(val);
                      			$('#u-date').val(data.date);
                      			var val = $('#u-vote option[value='+data.vote+']').attr('selected', 'selected').text();
                      			$('#u-vote').parent().find('span').text(val);
                      			$('#u-address').val(data.address);
                      			$('#u-youtube').val(data.youtube);
                      			if(data.date != '00/00/0000'){
                      				var tmp = data.date.split('/');
                      				var date = new Date(parseInt(tmp[2]), parseInt(tmp[0]-1), parseInt(tmp[1]));
                      				$("#u-date").data("dateinput").setValue(date);
                      			}else{
                      				_isoDate2 = '0000-00-00';
                      				$("#u-date").val('');
                      			}
                      			return false;
                      		});
                      	});
                      </script>
                        <div>
                      	<div class="tabHeader">Current Updates</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="invateTable">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">Committee</th>
                                        <th class="tdBy">Vote</th>
                                        <th class="tdCategory">Address</th>
                                        <th class="tdCategory">Video</th>
                                        <th class="tdCategory">Date</th>
                                    </tr>
                                  </thead>
                                <tbody>
                            <?PHP
                            	$sql = "SELECT b.id, 
											b.address, 
											b.youtube, 
											DATE_FORMAT(b.date, '%d %b') AS `date`,
											DATE_FORMAT(b.date, '%m/%d/%Y')  as full_date,
											b.vote, 
											b.committee,
											c.name
										FROM wp_pn_bills_updates b LEFT JOIN wp_pn_committee c ON b.committee = c.comm_id
										WHERE b.bill_id = ".$form_query['bill'];
								$query = $wpdb->get_results($sql, ARRAY_A);
	                    	?>
                            <?PHP foreach($query as $data):?>
                            <script type="text/javascript">
								var tmp = {};
								tmp.committte = '<?=$data['committee']?>';
								tmp.date = '<?=$data['full_date']?>';
								tmp.vote = '<?=$data['vote']?>';
								tmp.address = '<?=$data['address']?>';
								tmp.youtube = '<?=$data['youtube']?>';
								_billUpdtate["bill_update_"+<?=$data['id'];?>] = tmp;
	                    	</script>
                                    <tr id="bill_update_<?=$data['id'];?>">
                                        <td class="tdTitle"><a href="#" class="editBillUpdate" title="edit"><?=$data['name']?></a></td>
                                        <td class="tdBy"><a href="#" class="editBillUpdate" title="edit"><?=$data['vote'];?></a></td>
                                        <td class="tdCategory"><a href="#" class="editBillUpdate" title="edit"><?=trim($data['address']) != '' ? 'Yes' : 'No';?></a></td>
                                        <td class="tdCategory"><a href="#" class="editBillUpdate" title="edit"><?=trim($data['youtube']) != '' ? 'Yes' : 'No';?></a></td>
                                        <td class="tdCategory"><a href="#" class="editBillUpdate" title="edit"><?=$data['date'];?></a></td>
                                     </tr>
                                <?PHP endforeach;?>                                                                                                                                                                                                                                                  
                                </tbody>
                            </table>                         
						</div> 
                      </div>    
                      <?PHP endif;?>
					
<!--
<?PHP
					$sql = "SELECT * FROM $pn_tables->form_update WHERE parent = $letter ORDER BY date DESC LIMIT 0,1;";
					$bill_query = $wpdb->get_results($sql, ARRAY_A);
					$date = date("m/d/Y h:i A", $bill_query[0]['date']);
					if(count($bill_query) < 1){
						$date = '';
						$bill_query[0]['title'] = 'No updates';
					}
?>
-->
                                                     
                                        
        
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>	
     
      
      <?php } else { ?>
<script type="text/javascript">
var _action = 'add';
var _letter = <?=$letter?>;
</script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/testimony.js"></script>
<div id="content-page">            

		<div id="contentLeft">
        	
            <?PHP
        		$support = 'Support for';
        		if($form_query['statment'] == '1'){
        			$support = 'Strong support for';
        		}else if($form_query['statment'] == '2'){
        			$support = 'Opposition for';
        		}else if($form_query['statment'] == '3'){
        			$support = 'Strong opposition for';
        		}
        	?>
            <span class="contentLeftTitle"><span>
            	<?=$support?>: <?=$billName;?></span>
            </span>
            <ul>
                <?php get_template_part( 'video', 'view'); ?> 
            	<li><a href="#">
                	<h6>Description of Bill</h6>
                	<p><?=$form_query['description'];?></p>
                </a></li>
            	<li><a href="#">
                	<h6>Hearing</h6>
                	<p><?=date("l, F d, Y", strtotime($form_query['date']));?></p>
                </a></li>        
            	<li><a href="#">
                	<h6>Sample Talking Points</h6>
                	<p><?=$form_query['talking_points'];?></p>
                </a></li>                                                                                                                       
            </ul>         
            <ul>
            	<li><a href="<?= ($form_query['url'] == "n/a" ? "#" : $form_query['url']);?>" target="_blank">
                	<h6>URL</h6>
                	<p><?=$form_query['url'];?></p>
                </a></li>                                                                                                                      
            </ul>   
            <?php get_template_part( 'billupdates'); ?> 
             <div id="rss-feed"></div>
              <div style="clear:both;" class="socialnetwork">
<span class='st_facebook_large' st_title='Policy Ninja' st_image='http://www.policyninja.org/wp-content/themes/pninja/images/logo.png' st_description='Take Action Now! <?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?>' st_url='<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>' displayText='Share it'></span>
             	<span class='st_twitter_large' st_title='Policy Ninja' st_url='<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>' displayText='Share it'></span>
             	<span class='st_blogger_large' st_title='Policy Ninja' st_url='<?= "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"] ?>' displayText='Share it'></span>
             </div>
        </div>
        
        <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                                    
                    <h1 style="margin:0;">Your Testimony</h1>                                               
                    
                           
                    <form id="g-form">
                      <ul id="newBill" style="background:none; margin-top:-28px 10px 0 0;">
                        <li><label class="labelLeft">First Name</label><input id="g-name" type="text" size="40"/></li>                      
                        <li><label class="labelLeft">Last Name</label><input id="g-lname" type="text" size="40"/></li>
                        <li><label class="labelLeft">Email Address</label><input id="g-mail" type="email" size="40"/></li>
                        
                        <li><label class="labelLeft">Title</label><input id="g-title" type="text" size="40"/></li>
                        <li><label class="labelLeft">Organization</label><input id="g-organization" type="text" size="40"/></li>
                        
                        <li><label class="labelLeft">Address</label><input id="g-address" type="text" size="40"/></li>                        						<li><label class="labelLeft">City</label><input id="g-city" type="text" size="40"/></li>
                        <li><label class="labelLeft">State</label><input id="g-state" type="text" size="40"/></li>
                        <li><label class="labelLeft">Postal Code</label><input id="g-zip" type="text" size="40"/></li>
                        <li><label class="labelLeft">Phone</label><input id="g-phone" type="phone" size="40"/></li>
                        <li><label class="labelLeft">File</label><input id="g-file" name="file" type="file" size="40"/></li>
                        <li><label class="labelLeft">Testimony</label><textarea id="g-testimony" cols="40" rows="5"><?=$form_query['testimony'];?></textarea></li>
                       <?PHP if($form_query['nimbb'] == '1'): ?>
                        <li><label class="labelLeft">Video Testimony</label><input id="g-youtube" type="url" size="40" class="text"/></li>
                        <li>
                        	<label class="labelLeft">Or record your video</label>
                        	<?PHP $record_msg = 'to record a 30-second video with your web camera.  If you choose to record a video, a link to your video will be included in your emai';?>
                        	<?php get_template_part( 'record' ); ?> 
                        </li>
                        <?PHP endif;?>
                      </ul>
                      	<input class="superboton" type="button" id="g-submit" />
                    </form>    
                    <?PHP if($form_query['status'] == '1'): ?>
                    <h1>Progress</h1>
<?PHP
//					$sql = "SELECT * FROM $pn_tables->form_update WHERE parent = $letter AND parent_table = 'pn_form_testimony' ORDER BY date DESC LIMIT 0,1;";
          $sql = "SELECT * FROM $pn_tables->form_update WHERE parent = $letter ORDER BY date DESC LIMIT 0,1;";

					$bill_query = $wpdb->get_results($sql, ARRAY_A);
					$date = date("m/d/Y h:i A", $bill_query[0]['date']);
					if(count($bill_query) < 1){
						$date = '';
						$bill_query[0]['title'] = 'No updates';
					}
?>    
                    <div class="billUpdates">
                    	<div class="billUpdateTitle"><?=$bill_query[0]['title'];?><span><?=$date;?></span></div>
                        <p><?=$bill_query[0]['description'];?></p>
                    </div>
                    <h1>User Testimony</h1>
                    <?PHP
                    	$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent_table = 'pn_form_testimony' AND parent = ".$letter;
						$result = $wpdb->get_results($sql, ARRAY_A);
                    ?>   
                    <p><span class="rowTitle"><span><?=$result[0]['total'];?></span> people have submitted testimony so far.</span></p>
                    <?PHP endif; ?>
        
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>        
        

<?php } ?>

<div id="footer">                               
	<div id="footer_central">
		<div id="footer_ninja"></div>
        <a href="http://www.policyninja.org"><div id="footer_left"></div></a>
		<div id="footer_right"><a href="http://www.policyninja.org">Home</a>|<a href="http://www.policyninja.org/about/">About</a>|<a href="http://www.policyninja.org/education_and_training">Education</a>|<a href="http://www.policyninja.org/transparency">Transparency</a>|<a href="http://www.policyninja.org/action_page">Action</a>
        </div>
	</div>
</div>


</body>
</html>