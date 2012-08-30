<?php
/*
Template Name: Testimony view
*/
?>
<?PHP
	global $pn_tables;
	$testimony = $wp_query->query_vars['letter'];
	
	$sql = "SELECT * FROM $pn_tables->form_user WHERE id = $testimony AND parent_table = 'pn_form_testimony';";
	$testimony_query = $wpdb->get_results($sql, ARRAY_A);
	if(count($testimony_query) != 1){
		wp_redirect( get_option( 'siteurl' )); exit();
	}
	
	$form_table = $pn_tables->form_testimony;
	$form_var = 'letter';
	$form_query = array();
	
	$wp_query->query_vars[$form_var] = $testimony_query[0]['parent'];
	
	validate_letter();
	
	$letter = $wp_query->query_vars[$form_var];
	
	$form_query = $form_query[0];
	if(!is_user_logged_in()){
		wp_redirect( get_option( 'siteurl' ).'?page_id=201&testimony='.$letter);
		exit();
	}
?>

<?php get_header() ?>

	<?php if ( is_user_logged_in() ) { ?>

<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Contact Information</span></span>
            <ul>
            	<li><a href="#">
                	<h6>Full Name:</h6>
                	<p><?=$testimony_query[0]['first_name'];?> <?=$testimony_query[0]['last_name'];?></p>
                </a></li>
            	<li><a href="#">
                	<h6>Email:</h6>
                	<p><?=$testimony_query[0]['email'];?></p>
                </a></li>
            	<li><a href="#">
                	<h6>Address</h6>
                	<p><?=$testimony_query[0]['address'];?></p>
                </a></li>
            	<li><a href="#">
                	<h6>City</h6>
                	<p><?=$testimony_query[0]['city'];?></p>
                </a></li>  
            	<li><a href="#">
                	<h6>State</h6>
                	<p><?=$testimony_query[0]['state'];?></p>
                </a></li>    
            	<li><a href="#">
                	<h6>Zip Code</h6>
                	<p><?=$testimony_query[0]['postal_code'];?></p>
                </a></li>    
            	<li><a href="#">
                	<h6>Phone</h6>
                	<p><?=$testimony_query[0]['phone'];?></p>
                </a></li>
                <li><a href="#">
                	<h6>Testimony</h6>
                	<p><?=$testimony_query[0]['testimony'];?></p>
                </a></li>                                                                                                                                          
                <li><a href="#" class="linkless"><img src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottombig.png" /></a></li>
            </ul>
            
        </div>
        
   <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>Bill Information</h1>      
                    <p>Some text talking about the edit page...</p>                                                
                        
                  	<ul id="newBill" style="padding:4px 0 0;">
                        <li>
                            <span class="labelLeft">Position Statement:</span>
							<div class="labelRight"><?= $form_query['statment'] == '1' ? 'Strong opposition to' : 'Strong support to';?></div>
                        </li>
                        <li>
                            <span class="labelLeft">Name of Bill:</span>
							<div class="labelRight"><?=$form_query['bill'];?></div>
                        </li>                                                  
                        <li>
                        <?PHP
  	          		$cat = $form_query['category'];
  	          		$sql = "SELECT title FROm $pn_tables->form_category WHERE id = $cat;";
  	          		$result = $wpdb->get_results($sql, ARRAY_A);
  	          		
            	?>
                            <span class="labelLeft">Category:</span>
							<div class="labelRight"><?=$result[0]['title'];?></div>
                        </li>   
                        <li>
                            <span class="labelLeft">Description of the Bill:</span>
							<div class="labelRight"><?=$form_query['description'];?></div>
                        </li>   
                        <li>
                            <span class="labelLeft">Hearing</span>
							<div class="labelRight"><?=date("l, F d, Y h:i A", $form_query['date']);?></div>
                        </li>   
                        <li>
                            <span class="labelLeft">Sample Talking Points</span>
							<div class="labelRight"><?=$form_query['talking_points'];?></div>
                        </li>   
                                                                                                                                                					
                        <li><span class="labelLeft">Video Testimony</span>
                        <div class="video"><a class="youtube" href="<?=$form_query['youtube'];?>">My great YouTube video</a></div>
                        </li>
                      </ul>      
                      <!--<input class="superboton" type="submit" />-->
                      

                    <h1>Bill Progress</h1>    
<?PHP
					$sql = "SELECT * FROM $pn_tables->form_update WHERE parent = $letter ORDER BY date DESC LIMIT 0,1;";
					$bill_query = $wpdb->get_results($sql, ARRAY_A);
					$date = date("m/d/Y h:i A", $bill_query[0]['date']);
					if(count($bill_query) < 1){
						$date = '';
						$bill_query[0]['title'] = 'No updates';
					}
?>
                    <div class="billUpdates">
                    	<div class="billUpdateTitle"><?=$bill_query[0]['title']?><span><?=$date?></span></div>
                        <p><?=$bill_query[0]['description'];?></p>
                    </div>
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>	
     
      
      <?php } else { ?>
<?PHP
	wp_redirect( get_option( 'siteurl' ).'page_id=201&testimony='.$letter); exit();
?>
<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Strong opposition to Bill 25 CD1 Raising Waikiki Parking Meter Fees</span></span>
            <ul>
            	<li><a href="#">
                	<h6>Position Statement:</h6>
                	<p>Strong opposition to</p>
                </a></li>
            	<li><a href="#">
                	<h6>Category:</h6>
                	<p>Budget and Spending</p>
                </a></li>
            	<li><a href="#">
                	<h6>Description of Bill</h6>
                	<p>Honolulu City Council (Oahu County Council) is considering raising parking meter fees in Waikiki 600% -- up to $1.50 / hour. </p>
                </a></li>
            	<li><a href="#">
                	<h6>Hearing</h6>
                	<p>Wednesday, June 10, 2009 09:00 AM</p>
                </a></li>                                                                                        
                <li><a href="#" class="linkless"><img src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></a></li>
            </ul>
            
        </div>
        
        <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>Sample Talking Points</h1>
                
                	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              
              		<?php the_content(); ?>   
                    
					<?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>       
                    
                    <h1 style="margin:0;">Your Testimony</h1>                                               
                    
                           
                    <form>
                      <ul id="newBill" style="background:none; margin-top:-28px 10px 0 0;">
                        <li><label class="labelLeft">First Name</label><input type="text" size="40"/></li>                      
                        <li><label class="labelLeft">Last Name</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Email Address</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Address</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">City</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">State</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Postal Code</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Phone</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Testimony</label><textarea cols="40" rows="5"></textarea></li>
                        <li><span class="labelLeft">Video Testimony</span>
                        <div class="video"><a class="youtube" href="http://www.youtube.com/watch?v=TILzJ-_4urk">My great YouTube video</a></div>
                        </li>
                      </ul>
                      	<input class="superboton" type="submit" />
                    </form>    
                    
                    <h1>Progress</h1>    
                    <div class="billUpdates">
                    	<div class="billUpdateTitle">oppose HB1226 protect local democracy!<span>02/12/2009 03:02 PM</span></div>
                        <p>I am not "anti-science", but do believe we have much to learn about genetic engineering. I also believe because of diversity throughout our State, that Counties should maintain their regulatory authority in regards genetic engineering and the associated health, environmental, agricultural and economic issues. There is a widely recognized need and opportunity in improving our food security and we need legislation that encourages rather than discourages local food systems. </p>
                    </div>
                    
                    <h1>User Testimony</h1>   
                    <p><span class="rowTitle">96 people have submitted testimony so far.</span></p>
                    
        
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