<?PHP
/*
Template Name: Elected Officials
*/
?>
<?PHP global $pn_tables; ?>
<?php get_header() ?>
<script type="text/javascript">
$(document).ready(function(){
});
</script>
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
	                    <div class="tabHeader">REPUBLICANS</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tablaUno">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">First Name</th>
                                        <th class="tdTitle">Last Name</th>
                                        <th class="tdTitle">Party</th>
                                        <th class="tdTitle">Votes</th>
                                    </tr>                                </thead>
                                <tbody>
                                <?PHP
	                    		$sql = "SELECT id, govtrack_id, firstname, middlename, lastname, party, crp_id FROM `$pn_tables->legislators` WHERE party = 'REPUBLICAN'";
	                    		$query = $wpdb->get_results($sql, ARRAY_A);
	                    	?>
                                <?PHP foreach($query as $data):
                                		
                                	$query_v = $wpdb->get_results("SELECT COUNT(*) as c FROM $pn_tables->legs2bills WHERE crp_id = '".$data['crp_id']."';", ARRAY_A);		
                                	foreach($query_v as $data_v);
                                	
                                	?>
                                    <tr>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data['firstname']?></a></td>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data['lastname']?></a></td>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data['party']?></a></td>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data_v['c']?></a></td>
                                     </tr>
                                <?PHP endforeach;?>                                                                                                                                                                                                                                                  
                                </tbody>
                            </table>                         
						</div> 
						<div class="tabHeader">DEMOCRATS</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tablaDos">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">First Name</th>
                                        <th class="tdTitle">Last Name</th>
                                        <th class="tdTitle">Party</th>
                                        <th class="tdTitle">Votes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?PHP
	                    		$sql = "SELECT id, govtrack_id, firstname, middlename, lastname FROM `$pn_tables->legislators` WHERE party = 'DEMOCRAT'";
	                    		$query = $wpdb->get_results($sql, ARRAY_A);
	                    	?>
                                <?PHP foreach($query as $data):
                                
                                	$query_v = $wpdb->get_results("SELECT COUNT(*) as c FROM $pn_tables->legs2bills WHERE crp_id = '".$data['crp_id']."';", ARRAY_A);		
                                	foreach($query_v as $data_v);
                                	?>
                                    <tr>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data['firstname']?></a></td>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data['lastname']?></a></td>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data['party']?></a></td>
                                        <td  class="tdTitle"><a href="<?=get_option('siteurl')?>?page_id=241&legislator=<?=$data['id'];?>"><?=$data_v['c']?></a></td>
                                     </tr>
                                <?PHP endforeach;?>                                                                                                                                                                                                                                                  
                                </tbody>
                            </table>                         
						</div>     
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