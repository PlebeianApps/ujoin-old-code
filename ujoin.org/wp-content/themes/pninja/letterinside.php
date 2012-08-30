<?php
/*
Template Name: Letters Inside
*/
?>

<?php get_header() ?>

	<?php if ( is_user_logged_in() ) { ?>

<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Take Action!</span></span>
            <ul>
            	<li><a href="<?php bloginfo('url');?>/?p=52">Create a new bill</a></li>
                <li><a href="<?php bloginfo('url');?>/?p=172">Create a letter to the editor</a></li>
                <li><a href="<?php bloginfo('url');?>/?p=176">Create an Advocacy Email</a></li>
                <li><a href="<?php bloginfo('url');?>/?p=178">Add a petition</a></li>
                <li><a href="#" class="linkless"><img src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></a></li>
            </ul>
            
        </div>
        
   <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>New Letter to the Editor</h1>      
                    <p>Some text talking about the edit page...</p>                                                
                        
                  <ul id="newBill" style="padding:4px 0 0;">
                 
                        <li><label class="labelLeft">To</label><input type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">BCC</label><input type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">Title</label><input type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">Overview</label><input type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">Talking Points</label><textarea rows="5" cols="40" class="uniform"></textarea></li>
                        <li><label class="labelLeft">Sample Message</label><textarea rows="5" cols="40" class="uniform"></textarea></li>
                        <li><label class="labelLeft">Video</label></li>
                      </ul>      
                      <input class="superboton" type="submit" />                      
                   
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
        	
            <span class="contentLeftTitle"><span>Strong opposition to Bill 25 CD1 Raising Waikiki Parking Meter Fees</span></span>
            <ul>
            	<li><a href="#">
                	<h6>To:</h6>
                	<p>Kevin Vaccarello</p>
                </a></li>
            	<li><a href="#">
                	<h6>BBC:</h6>
                	<p>rene@shockvisual.net</p>
                </a></li>
            	<li><a href="#">
                	<h6>Overview</h6>
                	<p>Honolulu City Council (Oahu County Council) is considering raising parking meter fees in Waikiki 600% -- up to $1.50 / hour.</p>
                </a></li>   
            	<li><a href="#">
                	<h6>Sample Message</h6>
                	<p>Honolulu City Council (Oahu County Council) is considering raising parking meter fees in Waikiki 600% -- up to $1.50 / hour.</p>
                </a></li> 
            	<li><a href="#">
                	<h6>Video</h6>
                	<img src="<?php bloginfo('stylesheet_directory') ?>/images/youtube.jpg" />
                </a></li>                                                                                                                        
                <li><a href="#" class="linkless"><img src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></a></li>
            </ul>
            
        </div>
        
        <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>Sample Talking Points</h1>
                    <p>Honolulu City Council (Oahu County Council) is considering raising parking meter fees in Waikiki 600% -- up to $1.50 / hour.</p>
                
                	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              
              		<?php the_content(); ?>   
                    <h1 style="margin:0;"><?php the_title(); ?></h1>
                        
					<?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>                                                      
                    
                           
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
                      </ul>
                      	<input class="superboton" type="submit" />
                    </form>    
                    
                    <h1>Bill Progress</h1>    
                    <div class="billUpdates">
                    	<div class="billUpdateTitle">oppose HB1226 protect local democracy!<span>02/12/2009 03:02 PM</span></div>
                        <p>I am not "anti-science", but do believe we have much to learn about genetic engineering. I also believe because of diversity throughout our State, that Counties should maintain their regulatory authority in regards genetic engineering and the associated health, environmental, agricultural and economic issues. There is a widely recognized need and opportunity in improving our food security and we need legislation that encourages rather than discourages local food systems. </p>
                    </div>
                    
					<div id="testimonyTabs">
                    
                        <div class="tabHeader">Submitted Testimony</div>
                        <div class="tabContent">
                            <a href="#" class="firstRow">
                                <span class="rowDescription">
                                <span class="rowTitle">96 people have submitted testimony for this bill so far.</span>
                                </span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>       
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a> 
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>                                                                              
                        </div> 
                  
                    </div> 
                                
        
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