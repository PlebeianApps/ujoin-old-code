<?php
/*
Template Name: Bills Extras
*/
?>

<?php get_header() ?>
<?PHP global $pn_tables; ?>
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
                        
                        <div class="tabHeader">Bills</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tablaUno">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle" style="width:350px">Name of the Bill</th>
                                        <th class="tdBy" style="width:200px">Action Page</th>
                                        <th class="tdMore" style="background:none;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?PHP  
		                    		$sql = "SELECT id,title FROM wp_pn_bills_search_results;";
                                    $query = $wpdb->get_results($sql, ARRAY_A);
		                    		foreach($query as $data):
		                    			$id = $data['id'];
		                    			$sql = "SELECT COUNT(*)
										FROM $pn_tables->form_petition, $pn_tables->form_testimony, $pn_tables->form_letter
										WHERE $pn_tables->form_petition.bill = $id OR $pn_tables->form_testimony.bill = $id OR $pn_tables->form_letter.id = $id;";
										$result = $wpdb->get_var($sql);
										$have = $result > 0 ? "Yes" : "No";
	                    		?>
                                    <tr>
                                        <td  class="tdTitle" style="width:350px"><a href="<?php bloginfo('url');?>/?p=246&bill=<?=$id?>"><?php echo $data['title'];?></a></td>
                                        <td  class="tdBy" style="width:200px"><a href="<?php bloginfo('url');?>/?p=246&bill=<?=$id;?>"><?php echo $have;?></a></td>
                                        <td  class="tdMore"><a href="<?php bloginfo('url');?>/?p=246&bill=<?=$id;?>">Read More...</a></td>
                                    </tr> 
                                <?PHP endforeach;?>                                                                                                                                                                                                                                                 
                                </tbody>
                            </table>                         
						</div> 
                         
                        <input class="superboton" type="button" id="show-webpage" value="Bills search" />
                        <script type="text/javascript">
	$('#show-webpage').click(function(){
			Shadowbox.open({
		        content:    "http://capitol.hawaii.gov/session2011/",
		        player:     "iframe",
		        title:      "",
		        height:     650,
		        width:      820,
		        overlayColor: '#F00'
		    });
		});
	
</script>
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