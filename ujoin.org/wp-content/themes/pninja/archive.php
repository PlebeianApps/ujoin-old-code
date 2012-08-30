<?php get_header() ?>

<div id="sliderbgTwo">

	<div id="sliderTwo">

		<!-- <h1>BRINGING CLARITY TO DIGITAL</h1> -->
        
        
        
		<?php
        rewind_posts();
        query_posts('posts_per_page=3');
        if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        ?>   
        <a title="Leer la nota: <?php the_title(); ?>" href="?p=<?php the_ID(); ?>" class="sliderBlock">	
            <img class="thumbnail" src="<?php echo get_post_meta($post->ID,'blog_featured', true); ?>" title="<?php the_title(); ?>" alt="Leer la nota: <?php the_title(); ?>" />        
        	<span class="featuredTitle"><?php the_title(); ?></span>
        </a>
		<?php endwhile; else: ?>
        <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
        <?php endif; ?>         
     
    </div>

</div>

<div id="contentsbg">
    
    <div id="contents">
    
    	
    	
    	<div id="contentLeft">

        	<?php
			rewind_posts();
            query_posts('posts_per_page=10&offset=3');
            if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            ?>   
        	
            <div class="postexcerpt">
            
                <a href="?p=<?php the_ID(); ?>"><h2><?php the_title(); ?></h2></a>
                <?php the_post_thumbnail(); ?>
                <?php the_excerpt(); ?>
                <a class="readmore" href="?p=<?php the_ID(); ?>">Read more...</a>
                <div class="bloqueExtras">
                    <a class="responses" href="?p=<?php the_ID(); ?>"><?php comments_number('No Responses','One Response','% Responses'); ?></a>
                    <div class="share"><?php if( function_exists('ADDTOANY_SHARE_SAVE_KIT') ) { ADDTOANY_SHARE_SAVE_KIT(); } ?></div>
                </div>
            
            </div>
            
			<?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>      
            
            <?php wp_pagenavi(); ?>
        
        </div>
        
        <?php get_sidebar() ?>    

    
    </div>
    
  </div>
    <!-- termina contents -->
    
</div>    


<?php get_footer() ?>