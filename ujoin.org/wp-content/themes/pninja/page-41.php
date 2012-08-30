<?php
/*
Template Name: Action
*/
?>

<?php get_header() ?>

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