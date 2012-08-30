<?php
/*
Template Name: New Bill
*/
?>
<?PHP global $pn_tables; ?>
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
                    
					<div id="billTabs">
                        <?PHP
                        	$sql = "SELECT * FROM $pn_tables->form_testimony WHERE status = 1 ORDER BY id DESC;";
                        	$data = $wpdb->get_results($sql, ARRAY_A);
                        ?>
                        <div class="tabHeader">Public Testimony Action Pages</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tablaUno">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">Title</th>
                                        <th class="tdBy">Advocacy Group</th>
                                        <th class="tdCategory">Category</th>
                                        <th class="tdDate">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                               	<?PHP
                               		foreach($data as $key):
                               			$sql = "SELECT title FROM wp_pn_bills_search_results WHERE id = ".$key['bill']." LIMIT 1;";
										$billName = $wpdb->get_var($sql);
                               	?>
                                    <tr>
                                        <td  class="tdTitle"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$key['id']?>"><?=$billName;?></a></td>
                                        <?PHP
						  	          		$uid = $key['wuid'];
						  	          		$sql = "SELECT organization FROM $pn_tables->user_profile WHERE wuid = $uid;";
		                    				$group = $wpdb->get_var($sql);
						  	          		
						            	?>
                                        <td  class="tdBy"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$key['id']?>"><?=$group;?></a></td>
                                        <?PHP
						  	          		$cat = $key['category'];
						  	          		$sql = "SELECT title FROM $pn_tables->form_category WHERE id = $cat;";
						  	          		$result = $wpdb->get_results($sql, ARRAY_A);
						  	          		
						            	?>
                                        <td  class="tdCategory"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$key['id']?>"><?=$result[0]['title'];?></a></td>
                                        <td  class="tdDate"><?=$key['date'] != '0000-00-00' ? date('m/d/Y', strtotime($key['date'])) : 'N/A'?></td>
                                    </tr>
                                <?PHP endforeach; ?>                                                                                                                                                                                                                          
                                </tbody>
                            </table>                         
						</div> 
                        
                        <?php if (is_user_logged_in()) { ?> 
                        
                        <div class="tabHeader">My Group Testimony Action Pages</div>
<?PHP					
						wp_get_current_user();
						global $current_user;
						$uid = $current_user->ID;
						//%d %c %Y %h %i %p
						$sql = "SELECT *
								FROM $pn_tables->form_testimony
								WHERE wuid = $uid AND status = 1;";
						$letters = $wpdb->get_results($sql, ARRAY_A);
?>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tablaDos">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">Title</th>
                                        <th class="tdBy">Advocacy Group</th>
                                        <th class="tdCategory">Category</th>
                                        <th class="tdDate">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                            </a>
                        <?PHP foreach($letters as $key):?>
                        <?PHP
                        	$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent = ".$key['id'];
                        	$testimony = $wpdb->get_results($sql, ARRAY_A);
                        	$sql = "SELECT title FROM wp_pn_bills_search_results WHERE id = ".$key['bill']." LIMIT 1;";
							$billName = $wpdb->get_var($sql);
                        ?>         
                                    <tr>
                                        <td  class="tdTitle"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$key['id'];?>"><?=$billName;?></a></td>
                                        <?PHP
						  	          		$uid = $key['wuid'];
						  	          		$sql = "SELECT organization FROM $pn_tables->user_profile WHERE wuid = $uid;";
		                    				$group = $wpdb->get_var($sql);
						  	          		
						            	?>
                                        <td  class="tdBy"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$key['id'];?>"><?=$group;?></a></td>
                                        <?PHP
						  	          		$cat = $key['category'];
						  	          		$sql = "SELECT title FROM $pn_tables->form_category WHERE id = $cat;";
						  	          		$result = $wpdb->get_results($sql, ARRAY_A);
						  	          		
						            	?>
                                        <td  class="tdCategory"><a href="<?php bloginfo('url');?>/?p=20&letter=<?=$key['id'];?>1"><?=$result[0]['title'];?></a></td>
                                        <td  class="tdDate"><?=date('m/d/Y', $key['date']);?></td>
                                    </tr>
						<?PHP endforeach;?>                                                                                                                                                                                                                                     
                                </tbody>
                            </table>      
                            
                                               
						
                        </div>  
                        <?php } else {} ?>    
                        
                        
                        
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