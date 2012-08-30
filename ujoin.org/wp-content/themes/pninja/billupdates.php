<?PHP
	global $form_query, $pn_tables, $wpdb;
	$bid = $form_query['bill']; ?>
<script>console.log({bid: <?php echo $bid;?>});</script>


<?php    function regexWordWrap($s) {return '\b'.$s.'\b';}


//	$sql = "select * from $pn_tables->bills_updates where bill_id = $bid ORDER BY `creation` DESC";
//	$bill_updates = $wpdb->get_row($sql, ARRAY_A);


	if($bid !=0)
		$billInfo = fetchBillInfo($bid);

	$committees = explode(',', $billInfo['referral']);

	$votes = json_decode($billInfo['votes']);

	//if(count($committees) > 0):
	if(count($votes) > 0 && $bid != 0):
?>
<script>console.log(<?php echo json_encode($billInfo) .','. json_encode($votes).','.$bid;?>);</script>
<span class="contentLeftTitle" style="margin-left:50px;"><span style="font-size:35px;">Committee Stops & Votes</span></span>
<div class="termometer">
	<div class="termoLeft">
<?PHP
//	$position = isset($form_query, $form_query['statment']) ? $form_query['statment'] : '0';
//	$x = 0;
/*	foreach($bill_updates as $update):
		$date = strtotime($update['date']);
		$month = date('M',$date);
		$day = date('d',$date);
		$class = '';
		if($update['vote'] == 2 && ($position == '0' || $position == '1')){
			$class = ' red';
		}
		if($update['vote'] == 1 && ($position == '2' || $position == '3')){
			$class = ' red';
		}
		if($update['vote'] == 3 || $update['vote'] == 0){
			$class = ' gray';
		}
		
		if($update['date'] == '0000-00-00'){
			$day = $x = $x+1;
			$month = '';
		}
		$title = '';
		switch($update['vote']){
			case 0 :
				$title = 'N/A';
			break;
			case 1 :
				$title = 'Passed';
			break;
			case 2 :
				$title = 'Killed';
			break;
			case 3 :
				$title = 'Deferred';
			break;
		}
		
		//$title .= '('.$update['vote'].')'; */

		foreach ($votes as $vote) :
			if($vote->passed && $vote->passed !== true) {
				$class = ' red';
			}

			$date = strtotime($vote->date);
			$month = date('M',$date);
			$day = date('d',$date);


			   $committees = $wpdb->get_col("SELECT comm_id FROM wp_pn_committee;");
    $committeesRegexArray = array_map(regexWordWrap, $committees);
    $committeeRegex = '#'.implode('|',$committeesRegexArray).'#';


    if(preg_match($committeeRegex, $vote->motion, $current_referral))
    	$current_referral = $current_referral[0];

/*	$current_referral = $wpdb->get_var("SELECT current_referral FROM wp_pn_bills_lookup WHERE bills_search_id = '".$bid."';");
	$current_referral = substr($current_referral, 0, 3); */
	if($current_referral != '') {
		$committeeData = $wpdb->get_row("SELECT * from $pn_tables->committee WHERE comm_id = '".$current_referral."';", ARRAY_A);
		$committee = $committeeData['name'];
		$cid = $committeeData['id'];
	}

	$excerpt = $committee;
	if(strlen($excerpt) > 30) $excerpt = substr($excerpt, 0, 30).'...'; 

	if(strlen($excerpt) > 0) :
?>
	     <div class="tleftRow<?php echo $class;?>" title="<?php //echo $title;?>">
	     	<span class="tlrDay"><?=$day?></span><?=strtolower($month);?>
	     </div>
<?PHP endif; endforeach;?>
	</div>
	<div class="termoRight">
<?PHP
/*	foreach($bill_updates as $update):
		$cid = $update['committee'];
		$sql = "SELECT name FROM $pn_tables->committee WHERE comm_id = '$cid';";
		$committee = $wpdb->get_var($sql);
		$excerpt = $committee;
		if(strlen($excerpt) > 30) $excerpt = substr($excerpt, 0, 30).'...';
*/
	foreach ($votes as $vote):
    $committees = $wpdb->get_col("SELECT comm_id FROM wp_pn_committee;");
    $committeesRegexArray = array_map(regexWordWrap, $committees);
    $committeeRegex = '#'.implode('|',$committeesRegexArray).'#';


    if(preg_match($committeeRegex, $vote->motion, $current_referral))
    	$current_referral = $current_referral[0];

/*	$current_referral = $wpdb->get_var("SELECT current_referral FROM wp_pn_bills_lookup WHERE bills_search_id = '".$bid."';");
	$current_referral = substr($current_referral, 0, 3); */
	if($current_referral != '') {
		$committeeData = $wpdb->get_row("SELECT * from $pn_tables->committee WHERE comm_id = '".$current_referral."';", ARRAY_A);
		$committee = $committeeData['name'];
		$cid = $committeeData['id'];
	}

	$excerpt = $committee;
	if(strlen($excerpt) > 30) $excerpt = substr($excerpt, 0, 30).'...'; 

	if(strlen($excerpt) > 0) :
?>                
	    <div class="trightRow">
	        <div class="colCommittee" title="<?=$committee;?>"><a class="committee-update" href="#<?=$bid?>-<?=$cid?>"><?=$excerpt;?></a></div>
	        <div class="colExtras">
	        <?PHP if(trim($update['address']) != ''): ?>
	        	<a href="<?=$update['address']?>" rel="shadowbox">
	        	<img src="<?php bloginfo('stylesheet_directory') ?>/images/map.png" alt="Address" />
	        	</a>
	        <?PHP endif;?>
	        </div>
	        <div class="colExtras">
	        <?PHP
	        	if(trim($update['youtube']) != ''):
	        		$vid = get_url_string_value($update['youtube'], 'v');
	        ?>
	        	<a href="http://www.youtube.com/v/<?=$vid;?>&rel=1&autoplay=1" rel="shadowbox;width=530;height=375;player=swf">
	        	<img src="<?php bloginfo('stylesheet_directory') ?>/images/youtube.png" alt="Video"  />
	        	</a>
	        <?PHP endif;?>
	        </div>
	    </div>
<?PHP endif; endforeach;?>
	</div>  
</div>                     
<div class="trightBottom"></div>
<script type="text/javascript">
$(document).ready(function(){
	$('a.committee-update').click(function(){
		var tmp = $(this).attr('href').substr(1);
		var data = tmp.split('-');
		var url = getURL("legsVotedBill", data);
		var votes = new Array("No vote", "Aye", "No", "With reservations", "Excused", "Absent");
		//alert('clicked');
		$.getJSON(url, function($data) {
			console.log($data);
			var str = '<ul class="legsVotedBill" width="100%">';
			str += '<li class="header-list"><div class="name-voted">NAME</div> <div class="district-voted">DISTRICT</div> ';
//			str += '<div class="title-voted">TITLE</div>';
			str +='<div class="party-voted">PARTY</div>';
//			str +='<div class="vote-voted">VOTE</div>';
			str +='</li>';
			var len = $data.legs.length;
			for(var x = 0; x<len; x++){
				str += '<li><div class="picture-voted"><a href="'+$data.legs[x].crp_id+'" class="legsInfo"><img src="'+$data.legs[x].picture+'" alt="" width="30"/></a></div>';
				str += '<div class="name-voted"><a href="'+$data.legs[x].crp_id+'" class="legsInfo">&nbsp;'+$data.legs[x].name+'</a></div>';
				str += '<div class="district-voted">&nbsp;'+$data.legs[x].district+'</div>';
//				str += '<div class="title-voted">&nbsp;'+$data.legs[x].title+'</div>';
				str += '<div class="party-voted">&nbsp;'+$data.legs[x].party+'</div>';
//				str += '<div class="vote-voted">&nbsp;'+votes[$data.legs[x].vote]+'</div>';
				str += '<div class="viewmore-voted"><a href="'+$data.legs[x].crp_id+'" class="legsInfo">View More</a></div>';
				str += '<div class="extra"></div></li>';
			}
			str += '</ul>';
			Shadowbox.open({
		        content:    str,
		        player:     "html",
		        title:      "Committee Stops & Votes",
		        height:     380,
		        width:      630,
		        overlayColor: '#F00',
		        options: {onFinish: function(){$('a.legsInfo').click(legsInfo)}}
		    });
		    
		    
		    
		});
		return false;
	});
	
	function legsInfo (e){
			var info_div = $(this).parent().parent().find("div.extra");
			if (info_div.html() != "" || info_div.text() == "Loading...") {
				info_div.toggle("slow");
				return false;
			}
			info_div.html("<p>Loading...</p>").show();
			//alert("asdasd")
				//Shadowbox.close();
			var url = getURL("legsInfo", new Array($(this).attr('href')));
			//alert(url)
			$.ajax({url:url, context:this, dataType:"json", success:function($data) {
				//$(this).parent().parent().parent().find("div.extra").hide("slow");
				//$(this).parent().parent().find("div.extra").toggle("slow");
				console.log("legInfo", $data)
				var str = '<div><strong>Phone:</strong> '+$data.phone+'</div><div class="odd"><strong>Fax:</strong> '+$data.fax+'</div><div><strong>Email:</strong> '+$data.email+'</div><div class="odd"><strong>Address:</strong> '+$data.address+'</div>';
				str += '<div class="committee-voted"><h6>Committee:</h6> '+$data.committee.join(", ")+'</div>'
				str += "<table class=\"contributors\"><thead><tr><th>Donor</th><th>Sector</th><th>Industry</th><th>Amount</th><th>Date</th></tr></thead><tbody>";
				for(var i = 0; i<$data.donors.length; i++){
					var $ddonors = $data.donors[i]['@attributes']
					str += "<tr>";
					str += "<td>"+$ddonors.contributor_name+"</td><td>"+$ddonors.sector_name+"</td>";
					str += "<td>"+$ddonors.industry_name+"</td><td>"+$ddonors.amount+"</td><td>"+$ddonors.date+"</td>";
					str += "</tr>";
				}

//				console.log($data.donors);
				info_div.html(str);

				$(e.target).closest('li').find('table.contributors').dataTable({"sPaginationType": "two_button","iDisplayLength": 10,"aaSorting": [[3, 'desc']]});
			}})	
		    return false;
		}
	
});
</script>
<?PHP endif;?>