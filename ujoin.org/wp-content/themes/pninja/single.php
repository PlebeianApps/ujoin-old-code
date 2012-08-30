<?php get_header() ?>

	<div id="content-page">              

		<?php get_sidebar() ?>    
        
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