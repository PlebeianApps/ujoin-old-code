<?php
/*
Template Name: Bills Extras
*/
?>
<?PHP
	global $pn_tables;
	if(!isset($_REQUEST['bill']) && !is_nan($_REQUEST['bill'])){
		wp_redirect(home_url('/').'?page_id=54');
		exit();
	}
	$bill = $_REQUEST['bill'];

    /*
	$sql = "SELECT measure_title FROM $pn_tables->bills WHERE id = $bill LIMIT 1;";
	$billName = $wpdb->get_var($sql);
    $sql = "SELECT report_title FROM $pn_tables->bills WHERE id = $bill LIMIT 1;";
    $reportTitle = $wpdb->get_var($sql);
    $sql = "SELECT description FROM $pn_tables->bills WHERE id = $bill LIMIT 1;";
    $desc = $wpdb->get_var($sql);
    */

//    $billData = $wpdb->get_row("SELECT bill_id,state,session,title,subjects FROM wp_pn_bills_search_results WHERE id = $bill LIMIT 1;", ARRAY_A);

    $billData = fetchBillInfo($bill);    
    $billName = $billData["title"];
    $reportTitle = $billData["subjects"];
    $billId = $billData["bill_id"];
/*
    $api_url = "http://openstates.org/api/v1/bills/".$billData["state"]."/".rawurlencode($billData['session'])."/".rawurlencode($billData['bill_id'])."/?apikey=aa6d2f4176d047a2baa5d8d4a6f1061d";

    $billLookupJson = file_get_contents($api_url);
    $billLookup = json_decode($billLookupJson); */
    $source = $billData['source_url'];
    $reportTitle = $billData['scraped_subjects'];

    $committees = $wpdb->get_col("SELECT comm_id FROM wp_pn_committee;");
    function regexWordWrap($s) {return '\b'.$s.'\b';}
    $committeesRegexArray = array_map(regexWordWrap, $committees);
    $committeeRegex = '#'.implode('|',$committeesRegexArray).'#';

/*    if($source && $source!='') {
        $rawSource = file_get_contents($source);
        if($rawSource) {
            $dom = new DomDocument();
            @$dom->loadHTML($rawSource);
            $companion = $dom->getElementById('ListView1_ctrl0_companionLabel')->nodeValue;
            $package = $dom->getElementById("ListView1_ctrl0_package_acroLabel")->nodeValue;
            $referral = $dom->getElementById('ListView1_ctrl0_current_referralLabel')->nodeValue;
            $hearingComm = $dom->getElementById('GridView1_ctl02_Label17')->nodeValue;
            $hearingDate = $dom->getElementById('GridView1_ctl02_Label27')->nodeValue;

            $hearingLinkElem = $hearingNoticeLink = $dom->getElementById('GridView1_ctl02_hearingNoticeLink');
            $hearingNoticeLink;
            if($hearingLinkElem) {
                $hearingNoticeLink = $hearingLinkElem->getAttribute('href');
            } 
        }
    } */

    $companion = $billData['companion'];
    $package = $billData['package'];
    $referral = $billData['current_referral'];
    $hearingComm = $billData['hearing_committee'];
    $hearingDate = $billData['hearing_date'];
    $hearingNoticeLink = $billData['hearing_link'];

    $description = $billData['description'];

    $votes = json_decode($billData['votes']);
    $actions = json_decode($billData['actions']);
    
?>
<?php get_header() ?>

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
                    <h1><?php echo $billName;?></h1>                                                      
                    <h2><?php echo $reportTitle;?></h2>
                    <dl>
                        <dt>Bill ID</dt>
                        <dd><?php echo $billId;?></dd>
                        <dt>Measure Title</dt>
                        <dd><?php echo $billName;?></dd>
                        <dt>Report Title</dt>
                        <dd><?php echo $reportTitle;?></dd>
                        <dt>Description</dt>
                        <dd><?php echo $description;?></dd>
                        <dt>Companion</dt>
                        <dd><?php echo $companion;?></dd>
                        <dt>Package</dt>
                        <dd><?php echo $package;?></dt>
                        <dt>Current Referral</dt>
                        <dd><?php echo $referral;?></dt>
                        <dt>Introducer(s)</dt>
                        <dd><?php
                        echo $billData['sponsors'];?></dd>
                        <?php if($hearingComm):?>
                        <dt>Next Hearing</dt>
                        <dd>Committee: <?php echo $hearingComm;?> | Date: <?php echo $hearingDate;?> | <a href="<?php if($hearingNoticeLink) echo $hearingNoticeLink;?>">Agenda</a></dd>
                        <?php endif;?>
                        <dt>Votes of Elected Officials</dt>
                        <dd><?php
                        foreach($votes as $vote): ?>
                        <table>
                        <thead>
                        <tr><th colspan="3"><?php echo $vote->motion;?>
                        <tr><th>Name</th><th>Committee</th><th>Vote</th></tr></thead>
                        <tbody>
                            <?php foreach($vote->yes_votes as $yes_vote) : ?>
                            <tr><td><?php echo $yes_vote->name;?></td><td><?php 

                            if(preg_match($committeeRegex, $vote->motion, $committee))
                                echo $committee[0];

                            ?></td><td>Aye</td></tr>
                            <?php endforeach; ?>
                            <?php foreach($vote->no_votes as $no_vote) : ?>
                            <tr><td><?php echo $no_vote->name;?></td><td><?php 

                            if(preg_match($committeeRegex, $vote->motion, $committee))
                                echo $committee[0];

                            ?></td><td>Nay</td></tr>
                            <?php endforeach; ?>
                            <?php foreach($vote->other_votes as $other_vote) : ?>
                            <tr><td><?php echo $other_vote->name;?></td><td><?php 

                            if(preg_match($committeeRegex, $vote->motion, $committee))
                                echo $committee[0];

                            ?></td><td>Other</td></tr>
                            <?php endforeach; ?>
                        </tbody>
                        </table>
                        <?php endforeach;?></dd>
                        <dt>Status</dt>
                        <dd><?php 
                        echo end($actions)->action;
                        ?></dd>
                        <a href="<?php echo $source;?>">Source</a>
                    </dl>

	<div id="billTabs">
                        
                        <div class="tabHeader">Bills</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="tablaUno">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">Advocacy Group</th>
                                        <th class="tdTitle">Page Type</th>
                                        <th class="tdBy">Testimony</th>
                                        <th class="tdMore" style="background:none;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?PHP   
		                    		$sql = "SELECT id, wuid
										FROM $pn_tables->form_testimony
										WHERE bill = $bill AND status = 1;";
		                    		$query = $wpdb->get_results($sql, ARRAY_A);
		                    		foreach($query as $data):
		                    			$id = $data['id'];
		                    			$uid = $data['wuid'];
		                    			$sql = "SELECT organization FROM $pn_tables->user_profile WHERE wuid = $uid;";
		                    			$group = $wpdb->get_var($sql);
		                    			$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent_table = 'pn_form_testimony' AND parent = $id";
		                    			$testimony = $wpdb->get_var($sql);
	                    		?>
                                    <tr>
                                        <td  class="tdTitle"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$id;?>"><?=$group;?></a></td>
                                        <td  class="tdTitle"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$id;?>">Testimony</a></td>
                                        <td  class="tdBy"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$id;?>"><?=$testimony;?></a></td>
                                        <td  class="tdMore"><a href="<?php bloginfo('url');?>/?p=201&letter=<?=$id;?>">View More...</a></td>
                                    </tr> 
                                <?PHP endforeach;?> 
                                <?PHP   
		                    		$sql = "SELECT id, wuid, type
										FROM $pn_tables->form_letter
										WHERE bill = $bill AND status = 1;";
		                    		$query = $wpdb->get_results($sql, ARRAY_A);
		                    		foreach($query as $data):
		                    			$id = $data['id'];
		                    			$uid = $data['wuid'];
		                    			$sql = "SELECT organization FROM $pn_tables->user_profile WHERE wuid = $uid;";
		                    			$group = $wpdb->get_var($sql);
		                    			$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent_table = 'pn_form_letter' AND parent = $id";
		                    			$testimony = $wpdb->get_var($sql);
		                    			$page = $data['type'] == 'letter' ? 208 : 211;
	                    		?>
                                    <tr>
                                        <td  class="tdTitle"><a href="<?php bloginfo('url');?>/?p=<?=$page;?>&letter=<?=$id;?>"><?=$group;?></a></td>
                                        <td  class="tdTitle"><a href="<?php bloginfo('url');?>/?p=<?=$page;?>&letter=<?=$id;?>"><?=ucwords($data['type']);?></a></td>
                                        <td  class="tdBy"><a href="<?php bloginfo('url');?>/?p=<?=$page;?>&letter=<?=$id;?>"><?=$testimony;?></a></td>
                                        <td  class="tdMore"><a href="<?php bloginfo('url');?>/?p=<?=$page;?>&letter=<?=$id;?>">View More...</a></td>
                                    </tr> 
                                <?PHP endforeach;?> 
                                <?PHP   
		                    		$sql = "SELECT id, wuid
										FROM $pn_tables->form_petition
										WHERE bill = $bill AND status = 1;";
		                    		$query = $wpdb->get_results($sql, ARRAY_A);
		                    		foreach($query as $data):
		                    			$id = $data['id'];
		                    			$uid = $data['wuid'];
		                    			$sql = "SELECT organization FROM $pn_tables->user_profile WHERE wuid = $uid;";
		                    			$group = $wpdb->get_var($sql);
		                    			$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent_table = 'pn_form_petition' AND parent = $id";
		                    			$testimony = $wpdb->get_var($sql);
	                    		?>
                                    <tr>
                                        <td  class="tdTitle"><a href="<?php bloginfo('url');?>/?p=209&letter=<?=$id;?>"><?=$group;?></a></td>
                                        <td  class="tdTitle"><a href="<?php bloginfo('url');?>/?p=209&letter=<?=$id;?>">Petition</a></td>
                                        <td  class="tdBy"><a href="<?php bloginfo('url');?>/?p=209&letter=<?=$id;?>"><?=$testimony;?></a></td>
                                        <td  class="tdMore"><a href="<?php bloginfo('url');?>/?p=209&letter=<?=$id;?>">View More...</a></td>
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