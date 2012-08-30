<?php
/*
Template Name: Bills Extras
*/
?>
<?PHP global $pn_tables; ?>
<?php get_header() ?>

	<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>AHA!</span></span>
				<?php if ( !dynamic_sidebar('Transparency') ) : // begin primary sidebar widgets ?>
                <?php endif; // end primary sidebar widgets  ?>
            <span class="bordertop"><img class="lista" src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></span>
            
        </div>
        
        <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>       
                    
					<?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>                                                      
                    
                    <div id="billTabs">
                    
                        <div class="tabHeader">Agriculture and Food</div>
                        <div class="tabContent">
                            <a href="<?php bloginfo('url');?>/?p=108" class="firstRow">
                                <img class="rowImage" src="images/minilogo.png" />
                                <span class="rowDescription">
                                <span class="rowTitle">Hawaii SEED</span>
                                Protecting Hawaii and its people from the risks posed by genetically engineered organisms.
                                </span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a>                                                        
                        </div> 
                        
                        <div class="tabHeader">Budget and Spending</div>
                        <div class="tabContent">
                            <a href="<?php bloginfo('url');?>/?p=108" class="firstRow">
                                <img class="rowImage" src="images/minilogo.png" />
                                <span class="rowDescription">
                                <span class="rowTitle">Hawaii SEED</span>
                                Protecting Hawaii and its people from the risks posed by genetically engineered organisms.
                                </span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a
                        ></div> 
                        
                        <div class="tabHeader">Something Else</div>
                        <div class="tabContent">
                            <a href="<?php bloginfo('url');?>/?p=108" class="firstRow">
                                <img class="rowImage" src="images/minilogo.png" />
                                <span class="rowDescription">
                                <span class="rowTitle">Hawaii SEED</span>
                                Protecting Hawaii and its people from the risks posed by genetically engineered organisms.
                                </span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=108" class="tabContentRow">
                            	<span class="billName">Bill 25 CD1 Raising Waikiki Parking Meter Fees</span>
                                <span class="billTestimony">96 testimony submitted</span>
                                <span class="billMore">Click to read more...</span>
                            </a
                        ></div>                                                 
                    
                    </div>                    
                                
        
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>

</body>
</html>