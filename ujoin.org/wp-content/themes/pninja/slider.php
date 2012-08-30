	<div id="accordionHome"> 

			<?php
            query_posts(array( 'home-content' => 'accordion', 'showposts' => 1 ));
            if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            ?>

                <img id="btn1" class="accordionbutton" src="<?php bloginfo('stylesheet_directory') ?>/images/Flash-btn1.png" /> 
            	<div class="homeAccordionPane" style="display:block;"> 

                     <div class="slideLeft"> <?php the_post_thumbnail(); ?> </div>
                     <div class="slideRight">
                          <h1><?php the_title(); ?></h1>
                          <?php the_content(); ?>
                     </div>
                 
                 </div>
            
            <?php
            endwhile; else:
            endif;
            wp_reset_query(); 
            ?>                   

			<?php
            query_posts(array( 'home-content' => 'accordion',  'showposts' => 1, 'offset' => 1 ));
            if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            ?>
            <img id="btn2" class="accordionbutton" src="<?php bloginfo('stylesheet_directory') ?>/images/Flash-btn2.png" /> 
            <div class="homeAccordionPane"> 

                 <div class="slideLeft"> <?php the_post_thumbnail(); ?> </div>
                 <div class="slideRight">
                      <h1><?php the_title(); ?></h1>
                      <?php the_content(); ?>
                 </div>
            
            </div>
            <?php
            endwhile; else:
            endif;
            wp_reset_query(); 
            ?>   
            
			<?php
            query_posts(array( 'home-content' => 'accordion', 'showposts' => 1, 'offset' => 2 ));
            if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            ?>   
                <img id="btn3" class="accordionbutton" src="<?php bloginfo('stylesheet_directory') ?>/images/Flash-btn3.png" /> 
                <div class="homeAccordionPane"> 
    
                     <div class="slideLeft"> <?php the_post_thumbnail(); ?> </div>
                     <div class="slideRight">
                          <h1><?php the_title(); ?></h1>
                          <?php the_content(); ?>
                     </div>
                
                </div>
             
            <?php
            endwhile; else:
            endif;
            wp_reset_query(); 
            ?>               

           
			<?php
            query_posts(array( 'home-content' => 'accordion', 'showposts' => 1, 'offset' => 3 ));
            if ( have_posts() ) : while ( have_posts() ) : the_post(); 
            ?>  
            
                <img id="btn4" class="accordionbutton" src="<?php bloginfo('stylesheet_directory') ?>/images/Flash-btn4.png" /> 
                <div class="homeAccordionPane"> 
    
                     <div class="slideLeft"> <?php the_post_thumbnail(); ?> </div>
                     <div class="slideRight">
                          <h1><?php the_title(); ?></h1>
                          <?php the_content(); ?>
                     </div>
                
                </div>

            <?php
            endwhile; else:
            endif;
            wp_reset_query(); 
            ?>           

    </div>