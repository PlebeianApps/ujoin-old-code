<?php
/*
Template Name: New Testimony
*/
?>
<?PHP
	global  $pn_tables;
	if(is_valid_template()){
		$form_table = get_form_table($_REQUEST['template']);
		$form_var = 'template_id';
		$form_query = array();
	
		validate_letter();
		
		$form_query = $form_query[0];
	
		$sql = "SELECT title FROM wp_pn_bills_search_results WHERE id = ".$form_query['bill']." LIMIT 1;";
		$billName = $wpdb->get_var($sql);
	}
	
	function get_form_value($data, $key){
		return ' value="'.$data[$key].'" ';
	}
?>
<?php get_header() ?>

	<?php if ( is_user_logged_in() ) { ?>
<script type="text/javascript">
var _action = 'add';
var _email = '<?=$current_user->user_email;?>';
</script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/testimony.js"></script>
<?PHP if(isset($billName)):?>
<script type="text/javascript">
	_billId = <?=$form_query['bill']?>;
</script>
<?PHP endif;?>
<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Take Action!</span></span>
				<?php if ( !dynamic_sidebar('Home') ) : // begin primary sidebar widgets ?>
                <?php endif; // end primary sidebar widgets  ?>
            <span class="bordertop"><img class="lista" src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></span>    
            
        </div>
        
   <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>New Testimony Action Page</h1>      
                    <p>Edit your action page here. If you are unsure about a certain data field, mouse over the "?" images.</p>                                                  
                        
              <form id="f-letter">    
                  	<ul id="newBill" style="padding:4px 0 0;">
                        <li>
                          <label class="labelLeft">Position Statement:</label>
                          <select id="f-position">
                            <option value="0" <?=$form_query['statment'] == '0' ? 'selected="selected"' : '';?>>Strong support for</option>
                            <option value="1" <?=$form_query['statment'] == '1' ? 'selected="selected"' : '';?>>Strong opposition to</option>
                          </select>
                        </li>                      

                        <li><label class="labelLeft">Name of Bill <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="If this action page is associated with a bill,  begin typing in the official name of the bill and choose it from the autopopulate menu.  If your bill is not in the autopopulate list, then click below to 'add a new' bill." /></label><input style="border-bottom:1px solid #f0f0f0;" value="<?=$billName;?>" id="f-name" type="text" size="40" class="text"><a style="clear:both;margin-right:5px;float:right;font-size:80%;" href="<?=home_url('/')?>/?page_id=256">No bill found? Add a new one</a></li>
                        <li><label class="labelLeft">To <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="This works the same way as regular email.  Add the email addresses of the recipients of your action page here.  If you are sending the action email to multiple emails, separate them with a comma.  You may also add the emails in the 'BCC' field." /></label><input <?=get_form_value($form_query, 'to');?> id="f-to" type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">BCC <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="This works the same way as regular email.  Add the email addresses of the recipients of your action page here.  If you are sending the action emails to multiple emails, separate them with a comma." /></label><input <?=get_form_value($form_query, 'bbc');?> id="f-bcc" type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">Hearing Date</label><input <?=get_form_value($form_query, 'date');?> id="f-date" type="date" size="40" class="text"></li>
                        <li><label class="labelLeft">URL <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="If you want, you can add the URL to your bill's status page on the state website at http://capitol.hawaii.gov" /></label><input <?=get_form_value($form_query, 'url');?> id="f-url" type="url" size="40" class="text"></li>
                        <li><label class="labelLeft">RSS update URL <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="If you want, you can add the RSS URL to your action page.  The RSS URL will automatically provide updates on the status of your bill from the state's website http://capitol.hawaii.gov.  The status updates will appear on the left side of your action page." /></label><input <?=get_form_value($form_query, 'rss');?> id="f-rss" type="url" size="40" class="text"></li>
                        
                        <li><label class="labelLeft">Committee <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="Choose which committee your bill is scheduled for.  All actions will automatically be sent to all members of the committee.  If you would like to add an email recipient to these actions, add the email in either the 'to' or 'bcc' field." /></label>
                       		<select id="f-committee">
                       		<option value="0">N/A</option>
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
                          <label class="labelLeft">Category <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="This is an optional field to categorize your bill if you make your bill publicly viewable" /></label>
                         	<?php $cat_select_id = 'f-category'; $selected_value = $form_query['category']; get_template_part( 'category-select' ); ?>
                        </li>    
                        <li><label class="labelLeft">Description of the Bill <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="This will appear below the title on your action page.  Use this area to describe your action or your bill in more detail.  Convince people who come to your action page that they need to take action!" /></label><textarea id="f-description" rows="5" cols="40" class="uniform"><?=$form_query['description']?></textarea></li>
                        <li><label class="labelLeft">Sample Talking Points <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="Some people will visit your action page and will want to write their own message.  Use this area to provide those people with some sample talking points about your issue to help them draft their own message." /></label><textarea id="f-talking" rows="5" cols="40" class="uniform"><?=$form_query['talking_points']?></textarea></li>
                        <li><label class="labelLeft">Sample Email, Letter, or Testimony <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="This is the actual message that is going to get sent if people visit your action page and click 'submit' to send the action without editing the message.  On your finished action page, users will also be able to edit this area to craft their own message." /></label><textarea id="f-testimony" rows="5" cols="40" class="uniform"><?=$form_query['testimony']?></textarea></li>
                        <li><label class="labelLeft">Supplemental Video <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="If you have a YouTube or Vimeo video that will help explain your issue, or inspire people to take action, simply paste (or type) the URL here (for example, http://www.youtube.com/watch?v=EURZuzHyWb0).  If you have a web camera, you can also record yourself talking, and explain your issue. To record your own, click the "record" link and click "save" when you are done.  The URL will automatically be pasted for you." /></label><input id="f-video"  <?=get_form_value($form_query, 'youtube');?> type="url" size="40" class="text"></li>
                         <li>
                        	<label class="labelLeft">Or record your video</label>
                        	<?php get_template_part( 'record' ); ?> 
                        </li>
                        <li><label class="labelLeft">Public Action Page? <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="If you would like your page to be listed on Hawaii Policy Portal for the general public to view, choose 'yes'.  If you do not want it listed publicly, choose 'no'." /></label>
                       		<select id="f-public">
                       			<option value="1">Yes</option>
                       			<option value="2">No</option>
                       		</select>
                       	</li>
                       	<li><label class="labelLeft">Users can post video? <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="Choosing 'yes' will allow people to record videos (with their personal web cameras) to add to their emails (from your action page).  If this option is available on your action page, when someone is filling out their information to send their action, they will also be able to record a video to add to their email to influence the decision-maker.  The video is shown in the email as a link (or URL).  The link will open up a web page with the person's video." /></label>
                       		<select id="f-nimbb">
                       			<option value="1">Yes</option>
                       			<option value="0">No</option>
                       		</select>
                       	</li>
                      </ul>      
                      <input class="superboton" type="button" id="f-submit" />  
                      </form>                                          
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>	
     
      
      <?php } else { ?>

<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Haaayah!</span></span>
				<?php if ( !dynamic_sidebar('Action') ) : // begin primary sidebar widgets ?>
                <?php endif; // end primary sidebar widgets  ?>
            <span class="bordertop"><img class="lista" src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></span>            
            
        </div>
        
        <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>New Testimony Action Page</h1>
                    <p>Please register to be able to create Testimony Action Page</p>
                                
        
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>        
        

<?php } ?>




</body>
</html>