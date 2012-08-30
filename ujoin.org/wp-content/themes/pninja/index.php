<?PHP
if (isset($_GET['ajax'])) {
	include("ajax/service.php");	
	die();
}
?>
<?php get_header() ?>

<div id="home-flash">

    <div class="flashsize" id="cu3er-container">
        <a href="http://www.adobe.com/go/getflashplayer">
            <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
        </a>
    </div>
    
</div> 

<div class="container">

	<div id="content-home">
    
		<?php
        query_posts('cat=4&showposts=1&order=ASC');
        if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        ?>
        
		<div class="block first-child">
        	<img class="imgtitle" src="<?php bloginfo('stylesheet_directory') ?>/images/bloque1.gif" alt="What is Policy Ninja?" />
        	<?php the_content(); ?>
        </div>
        
		<?php
        endwhile; else:
        endif;
        wp_reset_query(); 
        ?>     

		<?php
        query_posts('cat=4&showposts=1&offset=1&order=ASC');
        if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        ?>
        
		<div class="block">
        	<img class="imgtitle" src="<?php bloginfo('stylesheet_directory') ?>/images/bloque2.gif" alt="Im Interested, Tell me more!" />
        	<?php the_content(); ?>
        </div>
        
		<?php
        endwhile; else:
        endif;
        wp_reset_query(); 
        ?> 
        
		<?php
        query_posts('cat=4&showposts=1&offset=2&order=ASC');
        if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        ?>
        
		<div class="block">
        	<img class="imgtitle" src="<?php bloginfo('stylesheet_directory') ?>/images/bloque3.gif" alt="I want in, lets get started" />
        	<?php the_content(); ?>
            <a href="<?php bloginfo('url');?>/wp-login.php?action=register" id="btn-newaccount"></a>
        </div>
        
		<?php
        endwhile; else:
        endif;
        wp_reset_query(); 
        ?>                           

    </div>

</div>   

</body>
</html>