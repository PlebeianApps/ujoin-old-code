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
                    
					<?php endwhile; endif; ?>
					<div id="billTabs">
					<?PHP
						$sql = "SELECT * FROM $pn_tables->cycles;";
						$cycles = $wpdb->get_results($sql, ARRAY_A);
						foreach($cycles as $cycle):
							$cycle_id = $cycle['id'];
					?>
					<script type="text/javascript">
					$(document).ready(function(){
						oTable = $('#tabla<?=$cycle_id;?>').dataTable({"sPaginationType": "full_numbers","iDisplayLength": 10,"aaSorting": [ ]});
					});
					</script>
					<div class="tabHeader">Cycle <?=$cycle['title'];?></div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tabla<?=$cycle_id;?>">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">First Name</th>
                                        <th class="tdTitle">Last Name</th>
                                    </tr>
                                  </thead>
                                <tbody>
                                <?PHP
	                    		$sql = "SELECT id, govtrack_id, firstname, middlename, lastname FROM `$pn_tables->legislators` WHERE cycle = $cycle_id";
	                    		$query = $wpdb->get_results($sql, ARRAY_A);
	                    	?>
                                <?PHP foreach($query as $data):?>
                                    <tr>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data['firstname']?></a></td>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data['lastname']?></a></td>
                                     </tr>
                                <?PHP endforeach;?>                                                                                                                                                                                                                                                  
                                </tbody>
                            </table>                         
						</div> 
					<?PHP endforeach; ?>
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