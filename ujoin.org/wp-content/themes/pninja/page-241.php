<?PHP
	//error_reporting(E_ALL);
	//ini_set("display_errors", true);

	global $pn_tables;
	if(!isset($_REQUEST['legislator']) || trim($_REQUEST['legislator']) == ''){
		wp_redirect( get_option( 'siteurl' ));
		exit();
	}
	
	$legislator = $_REQUEST['legislator'];
	
	$sql = "SELECT * FROM $pn_tables->legislators WHERE id = $legislator LIMIT 1;";
	$data = $wpdb->get_row($sql, ARRAY_A);
	
	/*
	$url = 'http://transparencydata.com/api/1.0/entities/id_lookup.json?apikey=207b25d043ee40a78148b02d5aff125c&namespace=urn:crp:recipient&id='.$data['crp_id'];
	$id_data = json_decode(file_get_contents($url), true);
	$id = $id_data[0]['id'];
	*/
	include_once("xml2json/xml2json.php");
	
	$url = "http://api.followthemoney.org/candidates.contributions.php?key=f0a49c69624a3903fc391da9cf376220&imsp_candidate_id=".$data['crp_id'];
	$contributions = xml2json::transformXmlStringToJson(file_get_contents($url));
	$contributions = json_decode($contributions);
	

	
	$crp_id = $data['crp_id'];
?>
<?php get_header(); ?>
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
              		
              		<?PHP  
              			$url = home_url('/wp-content/legislators/').$data['id'].'.jpg';
              			$avatar = home_url('/wp-content/legislators/').'default.jpg';
              			if(file_exists('./wp-content/legislators/'.$data['id'].'.jpg')) $avatar = $url;
              		?>
                    <h1><?=$data['firstname'].' '.$data['lastname']?></h1>
                    <p><img src="<?=$avatar;?>" alt="<?=$data['firstname'].' '.$data['lastname']?>" title="<?=$data['firstname'].' '.$data['lastname']?>" width="100"/></p>
                    <?php the_content(); ?>       
                    
					<?php endwhile; endif; ?>
					<h1>Contact Info</h1>
					
					<?PHP
					
							if(trim($data['phone']) == '') $data['phone'] = 'N/A';
							if(trim($data['fax']) == '') $data['fax'] = 'N/A';
							if(trim($data['email']) == '') $data['email'] = 'N/A';
					?>

					
					<ul id="newBill" style="padding: 4px 0pt 0pt;background:none;">
						<li><span class="labelLeft">Party: </span><span class="text"><?=$data['party']?></span></li>
						<li><span class="labelLeft">Title: </span><span class="text"><?=$data['title']?></span></li>
						<li><span class="labelLeft">Committee: </span>
							<span class="text">
								<?PHP 
									$ranks = array("Chair", "Vicechair", "Member");
									$sql = "SELECT c.name, l2c.rank 
											FROM wp_pn_committee AS c INNER JOIN wp_pn_legs2committee AS l2c ON c.id = l2c.comm_id 
											WHERE l2c.crp_id = $legislator;";
											
									$data_comm = $wpdb->get_results($sql, ARRAY_A);
									foreach($data_comm as $comm):
										echo $comm['name']." - ".$ranks[$comm['rank']]."<br/>";
									endforeach;
								?>
							</span>
						</li>
						<li><span class="labelLeft">Phone: </span><span class="text"><?=$data['phone']?></span></li>
						<li><span class="labelLeft">Fax: </span><span class="text"><?=$data['fax']?></span></li>
						<li><span class="labelLeft">Email: </span><span class="text"><?=$data['email']?></span></li>
						<li><span class="labelLeft">Address: </span><span class="text"><?=$data['address']?></span></li>
						<!--li class="avatar"><span class="labelLeft">Picture: </span><span class="text"><img src="<?=$avatar;?>" alt="<?=$data['firstname'].' '.$data['lastname']?>" title="<?=$data['firstname'].' '.$data['lastname']?>"/></span></li-->
					</ul>
					<div id="billTabs">
						<div class="tabHeader">Donations</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tablaUno">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">Name</th>
                                        <th class="tdTitle">Amount</th>
                                    </tr>
                                  </thead>
                                <tbody>
                                <?PHP
	                    			setlocale(LC_MONETARY, 'en_US');
	                    			
	                    			$contr = $contributions->{"candidates.contributions.php"}->contribution;
	                    			
	                    			for($x=0; $x<count($contr); $x++):
	                    		?>
                                    <tr>
                                        <td  class="tdTitle"><?=$contr[$x]->{"@attributes"}->contributor_name?></td>
                                        <td  class="tdBy"><?=money_format('$%!i', $contr[$x]->{"@attributes"}->amount);?></td>
                                     </tr>
                                <?PHP endfor;?>                                                                                                                                                                                                                                                  
                                </tbody>
                            </table>                         
						</div>

	                    <div class="tabHeader">Votes</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tablaDos">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">Bill</th>
                                        <th class="tdTitle">Votes</th>
                                    </tr>
                                  </thead>
                                <tbody>
                                <?PHP
	                    		$sql = "SELECT b.title, lb.vote FROM wp_pn_bills_search_results AS b INNER JOIN $pn_tables->legs2bills AS lb ON b.id = lb.bill_id WHERE lb.crp_id = '$crp_id';";
	                    		//echo $sql;
	                    		$query = $wpdb->get_results($sql, ARRAY_A);
	                    	?>
                                <?PHP foreach($query as $data):	
                                	
                                	?>
                                    <tr>
                                        <td  class="tdTitle"><?=$data['measure_title']?></td>
                                        <td  class="tdBy"><?=$data['vote']?></td>
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