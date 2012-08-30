<?php
/*
Template Name: New petition
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
	
		$sql = "SELECT title FROM  wp_pn_bills_search_results WHERE id = ".$form_query['bill']." LIMIT 1;";
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
</script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.ui.autocomplete.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/petition.js"></script>
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
                
                	<h1>New Petition</h1>      
                    <p>Edit your action page here. If you are unsure about a certain data field, mouse over the "?" images.</p>                                                 
               <form id="f-letter">         
                  <ul id="newBill" style="padding:4px 0 0;">
                        <li><label class="labelLeft">Name of Bill <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="If this action page is associated with a bill,  begin typing in the official name of the bill and choose it from the autopopulate menu.  If your bill is not in the autopopulate list, then click below to 'add a new' bill." /></label><input value="<?=$billName;?>" id="f-name" type="text" size="40" class="text"><a style="clear:both;margin-right:5px;float:right;font-size:80%;" href="<?=home_url('/')?>/?page_id=256">No bill found? Add a new one</a></li>
                        <li><label class="labelLeft">Committee <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="Choose which committee your bill is scheduled for.  All actions will automatically be sent to all members of the committee.  If you would like to add an email recipient to these actions, add the email in either the 'to' or 'bcc' field." /></label>
                       		<select id="f-committee">
                       		<option value="0">N/A</option>
                       		<?PHP
                       			$sql = "SELECT id AS comm_id, name FROM  $pn_tables->committee;";
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
                        <li><label class="labelLeft">Action Page Title <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="This is the title of your action page.  This text will appear in a blue box at the top of your action page.  Use as few words as possible and  try to catch everyone's attention. For example, you could put 'Take Action Now!' or something more specific." /></label><input <?=get_form_value($form_query, 'title');?> id="f-title" type="text" size="40" class="text"></li>
                        <li>
                          <label class="labelLeft">Category <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="This is an optional field to categorize your bill if you make your bill publicly viewable" /></label>
                         	<?php $cat_select_id = 'f-category'; $selected_value = $form_query['category']; get_template_part( 'category-select' ); ?>
                        </li>
                        <li><label class="labelLeft">Description <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="This will appear below the title on your action page.  Use this area to describe your action or your bill in more detail.  Convince people who come to your action page that they need to take action!" /></label><textarea id="f-description" rows="5" cols="40" class="uniform"><?=$form_query['talking_points']?></textarea></li>                        
                        <li><label class="labelLeft">Supplemental Video <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="If you have a YouTube or Vimeo video that will help explain your issue, or inspire people to take action, simply paste (or type) the URL here (for example, http://www.youtube.com/watch?v=EURZuzHyWb0).  If you have a web camera, you can also record yourself talking, and explain your issue. To record your own, click the "record" link and click "save" when you are done.  The URL will automatically be pasted for you." /></label><input id="f-video"  <?=get_form_value($form_query, 'youtube');?> type="url" size="40" class="text"></label><input <?=get_form_value($form_query, 'youtube');?> id="f-video" type="url" size="40" class="text"></li>
                         <li>
                        	<label class="labelLeft">Or record your video</label>
                        	<?php get_template_part( 'record' ); ?> 
                        </li>
                        <li><label class="labelLeft">Public Action Page? <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="If you would like your page to be listed on Hawaii Policy Portal for the general public to view, choose 'yes'.  If you do not want it listed publicly, choose 'no'." /></label>
                       		<select id="f-public">
                       			<option <?=$form_query['status'] == '1' ? 'selected="selected"' : ''?> value="1">Yes</option>
                       			<option <?=$form_query['status'] != '1' ? 'selected="selected"' : ''?> value="2">No</option>
                       		</select>
                       	</li>
                       	<li><label class="labelLeft">Users can post video? <img src="<?php bloginfo('stylesheet_directory') ?>/images/whatisthis.png" title="Choosing 'yes' will allow people to record videos (with their personal web cameras) to add to their emails (from your action page).  If this option is available on your action page, when someone is filling out their information to send their action, they will also be able to record a video to add to their email to influence the decision-maker.  The video is shown in the email as a link (or URL).  The link will open up a web page with the person's video." /></label>
                       		<select id="f-nimbb">
                       			<option <?=$form_query['nimbb'] == '1' ? 'selected="selected"' : ''?> value="1">Yes</option>
                       			<option <?=$form_query['nimbb'] != '1' ? 'selected="selected"' : ''?> value="0">No</option>
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
                
                	<h1>New Petition</h1>
                    <p>You need to be logged in to create a New Petition</p>
                       
        
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