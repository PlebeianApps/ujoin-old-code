<?php
/*
Template Name: Education
*/
?>

<?php get_header() ?>

	<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>OOMMMM...</span></span>
            <ul>
            	<li><a href="<?php bloginfo('url');?>/action-tour">Action Tour</a></li>
                <li><a href="<?php bloginfo('url');?>/hands-on-training">Hands on Training</a></li>
                <li><a href="<?php bloginfo('url');?>/transparency-tour">Transparency Tour</a></li>
                <li><a href="#" class="linkless"><img src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></a></li>
            </ul>
            
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
                                
        
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>

</body>
</html>