<?php
/*
Template Name: New Bill
*/
?>
<?PHP global $pn_tables; ?>
<?PHP
	if ( !is_user_logged_in() ){
		wp_redirect( get_option( 'siteurl' ));
		exit();
	}
	//echo is_group_admin() ? 'ok' : 'nop';
?>
<?PHP
	$status = true;
	$error = array();
	if(isset($_REQUEST['invite_id'], $_REQUEST['action'])){
		$status = false;
		$id = $_REQUEST['invite_id'];
		$action = $_REQUEST['action'];
		$uid = get_user_id();
		if($action == 'delete-invitation'){
			$sql = "DELETE FROM $pn_tables->invitations WHERE id = $id AND pid = $uid LIMIT 1;";
			$wpdb->query($sql);
			$status = true;
		}else if($action == 'resend-invitation'){
			$sql = "SELECT email, `key` FROM $pn_tables->invitations WHERE id = $id AND pid = $uid LIMIT 1;";
			$data = $wpdb->get_row($sql, ARRAY_A);
			$url = home_url().'/?page_id=234&key='.$data['key'];
			$uid = get_user_id();
			$sql = "SELECT organization FROM $pn_tables->user_profile WHERE wuid = $uid LIMIT 1;";
			$group = $wpdb->get_var($sql);
			$msg = "$group has invited you to join the Hawaii Policy Portal (link to join) \n $url"; 
			wp_mail($data['email'], 'Policy Ninja Invitation', $msg);
			$status = true;
			$error[] = $sql;
		}
		echo json_encode(array('status' => $status, 'message' => $error));
		exit();
	}
	if(isset($_REQUEST['invite']) && trim($_REQUEST['invite']) != ''){
		$wpdb->show_errors();
		if(is_email($_REQUEST['invite']) && is_group_admin()){
			$key = md5(mktime().$_REQUEST['invite']);
			$email = $_REQUEST['invite'];
			$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $pn_tables->invitations WHERE email = '$email';"));
			if($count < 1){
				$uid = get_user_id();
				$sql = "INSERT INTO $pn_tables->invitations VALUES(NULL, $uid, '$email', NOW(), '$key', 0);";
				$wpdb->query($sql);
				$iid = $wpdb->insert_id;
				$url = home_url().'/?page_id=234&key='.$key;
				$msg = "Join policy Ninja $url";
				wp_mail($email, 'Policy Ninja Invitation', $msg);
				$error[] = "The invitation has been sent to: $email";
			}else{
				$error[] = 'An invitation has been sent to this email address previously';
				$status = false;
			}
		}else{
			$error[] = 'The email address is not valid';
			/*$error[] = $_REQUEST['invite'];
			$error[] = is_group_admin();
			$status = false;
			$id = get_user_id();
			$user_last = get_user_meta( $id, 'user_is_group', true);
			$error[] = $user_last;
			$error[] = get_user_id();*/
		}
		
		$data = json_encode(array('status' => $status, 'message' => $error, 'id' => $iid));
		echo $data;
		$wpdb->hide_errors();
		exit();
	}
	
?>
<?php get_header() ?>
<script type="text/javascript">
var invitationTable;
$(document).ready(function(){
	$(":date").dateinput({change:function(){
		_isoDate = this.getValue('yyyy-mm-dd');
	}});
	invitationTable = $('#invateTable').dataTable();
	$('#f-submit').click(function($event){
		$event.stopPropagation();
		saveProfile();
		return false;
	})
	$('#f-pic').change(function() {
        $(this).upload(getURL("updateAvatarProfile", []), function($data) {
            $('#user-image').attr('src', '/?ajax&resizeImage='+$data.url);
        }, 'json');
    });
    $('#p-submit').click(function(){
    	var pw = $('#p-pw').val();
    	var pw2 = $('#p-pw2').val();
    	if($.trim(pw) == ''){
    		alert('Password can\'t be empty');
    		return;
    	}
    	if(pw.length < 3){
    		alert('Password is to short');
    		return;
    	}
    	if(pw != pw2){
    		alert('Passwords doesn\'t match');
    		return;
    	}
    	var laoding = '<div id="loading-div"><p>Loading...</p></div>';
    	$('#p-form').append(laoding);
    	$('#p-form ul').hide();
    	var url = getURL("changePassword", [pw]);
		$.getJSON(url, function($data) {
			alert("Your password has been successfully changed");
			$('#p-pw').val('');
			$('#p-pw2').val('');
			$('#loading-div').remove();
	    	$('#p-form ul').show();
		});
    	
    });
    $('#i-submit').click(function(){
    	var email = $('#i-email').val();
    	var url = '/your-profile';
    	var laoding = '<div id="loading-div"><p>Loading...</p></div>';
    	$('#invite-form p.status').remove();
    	$('#invite-form').append(laoding);
    	$('#invite-form ul').hide();
		$.getJSON(url, {invite:email}, function($data) {
			$('#i-email').val('');
			$('#loading-div').remove();
			$('#invite-form ul').show();
			var str = '';
			for(var i in $data.message){
				str += '<p class="status">'+$data.message[i]+'</<p>';
			}
			$('#invite-form').append(str);
			if($data.status){
				var date = new Date();
				var a = invitationTable.fnAddData( 
					[
						email, 
						date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate()+' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds(), 
						'Invitation send', 
						'<a href="#resend-invitation/'+$data.id+'" class="resend-invitation">Resend Invitation</a><a href="#delete-invitation/'+$data.id+'" class="delete-invitation">Delete Invitation</a>'
					] 
				);
				var nTr = invitationTable.fnSettings().aoData[ a[0] ].nTr;
				$('td', nTr).addClass('tdTitle');
				setInvitationsEvenets();
			}
		});
		return false;
    });
    setInvitationsEvenets();
});

function setInvitationsEvenets(){
	$('a.delete-invitation').click(function(){
		var id = $(this).attr('href').split('/')[1];
		var tr = $(this).parent().parent();
		var email = $('td:first', tr).text();
		var res = confirm('Do you really want to delete '+email+' invitation?')
		if(!res) return false;
		var aPos = invitationTable.fnGetPosition( tr[0] );
		invitationTable.fnDeleteRow( aPos );
		
		var url = '<?=home_url('/');?>?page_id=166';
		$.getJSON(url, {invite_id:id, action:'delete-invitation'}, function($data) {
			//alert($data.message);
		});
		return false;
	});
	$('a.resend-invitation').click(function(){
		var id = $(this).attr('href').split('/')[1];
		var tr = $(this).parent().parent();
		if(tr.hasClass('sending')) return false;
		tr.addClass('sending');
		var url = '<?=home_url('/');?>?page_id=166';
		$.getJSON(url, {invite_id:id, action:'resend-invitation'}, function($data) {
			alert('Invitation sent');
			tr.removeClass('sending');
		});
		return false;
	});
	$('a.delete-user').click(function(){
		var id = $(this).attr('href').split('/')[1];
		var tr = $(this).parent().parent();
		var email = $('td:first', tr).text();
		var res = confirm('Do you really want to delete '+email+' from the group?')
		if(!res) return false;
		var aPos = invitationTable.fnGetPosition( tr[0] );
		invitationTable.fnDeleteRow( aPos );
		
		var url = getURL("deleteUser", [email]);
		$.getJSON(url, function($data) {
			//alert($data.message);
		});
		return false;
	});
}
function saveProfile(){
	var data = [get_val('#f-email'), encodeURIComponent(get_val('#f-url')), get_val('#f-company'), get_val('#f-phone'), get_val('#f-address'), get_val('#f-city'), get_val('#f-state'), get_val('#f-zip'), get_val('#f-about')];
    var laoding = '<div id="loading-div"><p>Loading...</p></div>';
    $('#loading-container').append(laoding);
    $('#f-profile ul').hide();
	var url = getURL("updateUserProfile", data);
	$.getJSON(url, function($data) {
		$('#loading-div').remove();
    	$('#f-profile ul').show();
	});
	return false;
}
</script>
<style>
#contentRight #main #inviteUl, #contentRight #main #passwordUl{
    clear: both;
    margin: 0 10px 0 0;
    padding: 0;
}
#contentRight #main #inviteUl li, #contentRight #main #passwordUl li {
    background: url("images/separator.png") repeat-x scroll center bottom transparent;
    line-height: 40px;
    min-height: 46px;
    overflow: hidden;
    padding: 0 0 4px 40px;
}
</style>
	<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Take Action!</span></span>
				<?php if ( !dynamic_sidebar('Home') ) : // begin primary sidebar widgets ?>
                <?php endif; // end primary sidebar widgets  ?>
            <span class="bordertop"><img class="lista" src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></span>    
            
        </div>
        
        <div id="contentRight">
        
        	<div id="contentRightTop">
        	           
                <div id="main">
                <?PHP
						$uid = get_user_group();
                    	$sql = "SELECT $pn_tables->user_profile.*, wp_users.* FROM wp_users LEFT JOIN $pn_tables->user_profile ON  $pn_tables->user_profile.wuid = wp_users.ID WHERE wp_users.ID = $uid;";
                    	//echo $sql;
                    	$profile = $wpdb->get_results($sql, ARRAY_A);
                ?>  
                            
                      <h1>My Action Pages</h1> 
<?PHP
						//%d %c %Y %h %i %p
						/*
						$sql = "SELECT t.id, 
									   t.bill,
									   b.title AS `name`
								FROM $pn_tables->form_testimony t
								INNER JOIN wp_pn_bills_search_results b ON t.bill = b.id
								WHERE t.wuid = $uid AND (t.status = 1 OR t.status = 2);";
						*/
						$sql = "SELECT id, bill FROM wp_pn_form_testimony WHERE wuid = $uid AND status != 0;";
						$letters = $wpdb->get_results($sql, ARRAY_A);

?>
					<div id="billTabs">
                    
                        <div class="tabHeader">My Testimony Action Pages</div>
                        <div class="tabContent">
                            <a href="<?php bloginfo('url');?>/?p=108" class="firstRow">
                                <span class="rowTitle">You have created <?=count($letters)?> Bills</span>
                            </a>
                        <?PHP foreach($letters as $key):?>
                        <?PHP
                        	$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent_table = 'pn_form_testimony' AND parent = ".$key['id'];
                        	$testimony = $wpdb->get_results($sql, ARRAY_A);

                        	$billId = $key['bill'];

                        	if($key['bill'] != 0)
                        		$key['name'] = $wpdb->get_var("SELECT title FROM wp_pn_bills_search_results WHERE id = $billId;");
                        	else
                        		$key['name'] = "New testimony";
                        ?>
                            <a href="<?php bloginfo('url');?>/?p=201&letter=<?=$key['id'];?>" class="tabContentRow">
                            	<span class="billName"><?=strlen($key['name']) > 60 ? substr($key['name'], 0, 60).'...' : $key['name'];?></span>
                                <span class="billTestimony"><?=$testimony[0]['total'];?> testimony submitted</span>
                                <span class="billMore">Click to edit...</span>
                            </a>
						<?PHP endforeach;?>                                                      
                        </div> 
<?PHP
						//%d %c %Y %h %i %p
						$sql = "SELECT id, 
									   title
								FROM $pn_tables->form_letter
								WHERE wuid = $uid AND type = 'letter' AND status != 0;";
						$letters = $wpdb->get_results($sql, ARRAY_A);
?>                        
                        <div class="tabHeader">My letters to the Editor</div>
                        <div class="tabContent">
                            <a href="#" class="firstRow">
                                <span class="rowTitle">You have created <?=count($letters)?> Bills</span>
                            </a>
                            <?PHP foreach($letters as $key):?>
	                        <?PHP
	                        	$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent_table = 'pn_form_letter' AND parent = ".$key['id'];
	                        	$testimony = $wpdb->get_results($sql, ARRAY_A);
	                        ?>
                            <a href="<?php bloginfo('url');?>/?p=208&letter=<?=$key['id'];?>" class="tabContentRow">
                            	<span class="billName"><?=$key['title'];?></span>
                                <span class="billTestimony"><?=$testimony[0]['total'];?> testimony submitted</span>
                                <span class="billMore">Click to edit...</span>
                            </a>
                            <?PHP endforeach;?>   
                        </div> 
<?PHP
						//%d %c %Y %h %i %p
						$sql = "SELECT id, 
									   title
								FROM $pn_tables->form_letter
								WHERE wuid = $uid AND type = 'advocacy' AND status != 0;";
						$letters = $wpdb->get_results($sql, ARRAY_A);
?>                     
                        <div class="tabHeader">My Advocacy Emails</div>
                        <div class="tabContent">
                            <a href="#" class="firstRow">
                                <span class="rowTitle">You have created <?=count($letters)?> Bills</span>
                            </a>
                            <?PHP foreach($letters as $key):?>
	                        <?PHP
	                        	$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent_table = 'pn_form_letter' AND parent = ".$key['id'];
	                        	$testimony = $wpdb->get_results($sql, ARRAY_A);
	                        ?>
                            <a href="<?php bloginfo('url');?>/?p=211&letter=<?=$key['id'];?>" class="tabContentRow">
                            	<span class="billName"><?=$key['title'];?></span>
                                <span class="billTestimony"><?=$testimony[0]['total'];?> testimony submitted</span>
                                <span class="billMore">Click to edit...</span>
                            </a>
                            <?PHP endforeach;?>   
                         </div>  
<?PHP
						//%d %c %Y %h %i %p
						$sql = "SELECT id, 
									   title
								FROM $pn_tables->form_petition
								WHERE wuid = $uid AND status != 0;";
						$letters = $wpdb->get_results($sql, ARRAY_A);
?>                     
                         
                      <div class="tabHeader">My Petitions</div>
                        <div class="tabContent">
                            <a href="#" class="firstRow">
                                <span class="rowTitle">You have created <?=count($letters)?> Bills</span>
                            </a>
                            <?PHP foreach($letters as $key):?>
	                        <?PHP
	                        	$sql = "SELECT COUNT(id)AS total FROM $pn_tables->form_user WHERE parent_table = 'pn_form_petition' AND parent = ".$key['id'];
	                        	$testimony = $wpdb->get_results($sql, ARRAY_A);
	                        ?>
                            <a href="<?php bloginfo('url');?>/?p=209&letter=<?=$key['id']?>" class="tabContentRow">
                            	<span class="billName"><?=$key['title'];?></span>
                                <span class="billTestimony"><?=$testimony[0]['total'];?> testimony submitted</span>
                                <span class="billMore">Click to edit...</span>
                            </a>
                            <?PHP endforeach;?>    
                         </div>                                                                         
                    
                    </div>     
                    
                    <div style="display:block; height:50px; clear:both;"></div>
                    
                                    	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              
                    <h1><?php the_title(); ?></h1>
                    <img id="user-image" src="http://www.policyninja.org/?ajax&resizeImage=<?=$profile[0]['avatar'] ?>" class="floatright" />
                    <?php the_content(); ?>   
                        
					<?php endwhile; else: ?>
					
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>                                                      
                    <?PHP if(is_group_admin()):?>
                    <form id="f-profile">  
                    <div id="loading-container"></div>     
                    <ul id="newBill" style="padding-top:4px;">
                    	<li><label class="labelLeft">Upload your logo</label><input type="file" name="picture" id="f-pic" class="floatright text" /></li>
                        <li><label class="labelLeft">Organization Name</label><input id="f-company" value="<?=$profile[0]['organization'];?>" type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">e-Mail</label><input id="f-email" value="<?=$profile[0]['user_email'];?>" type="email" size="40" class="text"></li>
                        <li><label class="labelLeft">URL</label><input id="f-url" value="<?php echo $profile[0]['user_url'];?>" type="url" size="40" class="text"></li>
                        <li><label class="labelLeft">Phone</label><input id="f-phone" value="<?=$profile[0]['phone'];?>" type="phone" size="40" class="text"></li>
                        <li><label class="labelLeft">Address</label><input id="f-address" value="<?=$profile[0]['address'];?>" type="text" size="40" class="text"></li> 
                        <li><label class="labelLeft">City</label><input id="f-city" value="<?=$profile[0]['city'];?>" type="text" size="40" class="text"></li>                         
                        <li><label class="labelLeft">State</label><input id="f-state" value="<?=$profile[0]['state'];?>" type="text" size="40" class="text"></li>   
                        <li><label class="labelLeft">Zip</label><input id="f-zip" value="<?=$profile[0]['zip'];?>" type="number" size="40" class="text"></li>   
                        <li><label class="labelLeft">About you</label><textarea id="f-about" rows="5" cols="40" class="uniform"><?=$profile[0]['about'];?></textarea></li>
                      </ul>      
                      
                      <input id="f-submit" class="superboton" type="button" value="Save" /> 
                      </form> 
               <?PHP endif;?>
                      
                      <div style="display:block; height:50px; clear:both;"></div>
                      
                      <h1>Change your password</h1>
                    <form id="p-form">
                    	<ul id="passwordUl">
                    		<li><label class="labelLeft">New Password</label><input type="password" id="p-pw" /></li>
                    		<li><label class="labelLeft">Confirm Password</label><input type="password" id="p-pw2" /></li>
                    	</ul>
                    	<input style="clear:both;" id="p-submit" class="superboton" type="button" value="Save" />
                    </form>
                      
               <?PHP if(is_group_admin()):?>
                    <h1>Invite people to your group</h1> 
                      <form id="invite-form">
                      <p>Just type the email of the person you want to invite.</p>
                      <ul id="inviteUl" style="padding-top:4px; background:url('images/separator.png') repeat-x scroll center top transparent;">
                      	<li><label class="labelLeft">Email</label><input type="email" id="i-email" /></li>
                      </ul>
                      <input style="clear:both;" id="i-submit" class="superboton" type="button" value="Invite" /> 
                      </form>
                      <div>
                      	<div class="tabHeader">Invitations</div>
                        <div class="tabContent">
                            <table cellpadding="0" cellspacing="0" border="0" class="display tablageneral" id="invateTable">
                                <thead>
                                    <tr class="forumsHeader">
                                        <th class="tdTitle">Email</th>
                                        <th class="tdBy">Date</th>
                                        <th class="tdBy">Status</th>
                                        <th class="tdCategory">Options</th>
                                    </tr>
                                  </thead>
                                <tbody>
                            <?PHP
                            	$uid = get_user_id();    
	                    		$sql = "SELECT id, email, `date`, `status` FROM `$pn_tables->invitations` WHERE pid = $uid;";
	                    		$query = $wpdb->get_results($sql, ARRAY_A);
	                    	?>
                                <?PHP foreach($query as $data):?>
                                    <tr id="invitation-tr-<?=$data['id'];?>">
                                        <td  class="tdTitle"><?=$data['email']?></td>
                                        <td  class="tdBy"><?=$data['date']?></td>
                                        <td  class="tdBy"><?=$data['status'] == 0 ? 'Invitation sent' : 'Registered';?></td>
                                        <td  class="tdCategory">
                                        <?PHP if($data['status'] == 0):?>
                                        	<a href="#resend-invitation/<?=$data['id'];?>" class="resend-invitation">Resend Invitation</a>
                                        	<a href="#delete-invitation/<?=$data['id'];?>" class="delete-invitation">Delete Invitation</a>
                                        <?PHP else: ?>
                                        	<a href="#delete-user/<?=$data['id'];?>" class="delete-user">Delete User</a>
                                        <?PHP endif;?>
                                       </td>
                                     </tr>
                                <?PHP endforeach;?>                                                                                                                                                                                                                                                  
                                </tbody>
                            </table>                         
						</div> 
                      </div>                        
                     <?PHP endif;?>           
        
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>

</body>
</html>