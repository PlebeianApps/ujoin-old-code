<?php
/*
Template Name: Registration Invite
*/
?>
<?php
global $pn_tables;
if ( is_user_logged_in() ){
	wp_redirect( get_option( 'siteurl' ));
	exit();
}else if(!isset($_REQUEST['key']) || trim($_REQUEST['key']) == ''){
	wp_redirect( get_option( 'siteurl' ).'?no_key');
	exit();
}
$key = $_REQUEST['key'];
$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $pn_tables->invitations WHERE `key` = '$key' AND `status` = 0;"));

if($count != 1){
	wp_redirect( get_option( 'siteurl' ).'?invalid_key');
	exit();
}
$sql = "SELECT * FROM $pn_tables->invitations WHERE `key` = '$key'";
$invitation_query = $wpdb->get_results($sql, ARRAY_A);
$invitation_query = $invitation_query[0];

$uid = $invitation_query['pid'];
$sql = "SELECT * FROM $pn_tables->user_profile WHERE wuid = $uid;";
$user_query = $wpdb->get_results($sql, ARRAY_A);
$user_query = $user_query[0];

if(isset($_REQUEST['register']) && $_REQUEST['register']){
	$error = array();
	if(trim($_POST['user']) == ''){
		$error[] = 'Username cant be empty';
	}
	if(!is_email($_POST['email'])){
		$error[] = 'Email address is not valid';
	}
	if(trim($_POST['password']) == ''){
		$error[] = 'Password can\'t be empty';
	}
	if(empty($error)){
		require_once(ABSPATH . WPINC . '/registration.php' );
		require_once(ABSPATH . WPINC . '/pluggable.php' );
		$uid = username_exists($_POST['user']);
		if ($uid){
			$error[] = 'Username already exists';
		}else{
			$uid = email_exists($_POST['email']);
			if($uid){
				$error[] = 'Email already exists';
			}else{
				$uid = wp_create_user($_POST['user'], $_POST['password'], $_POST['email']);
				$pid = $invitation_query['pid'];
				update_user_meta($uid, 'user_is_group', '0');
				update_user_meta($uid, 'user_parent', $pid);
				update_user_meta($uid, 'first_name', $_POST['fname']);
				update_user_meta($uid, 'last_name', $_POST['lname']);
				$sql = "UPDATE $pn_tables->invitations SET `status` = 1, `email` = '".$_POST['email']."' WHERE `key` = '$key' LIMIT 1;";
				$wpdb->query($sql);
			}
		}
	}
	echo json_encode(array('success' => empty($error) ? true : false, 'errors' => $error));
	exit();
}
?>

<?php get_header() ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#f-submit').click(function(){
		$('#f-registration').submit();
	});
	$('#f-registration').submit(function(){
		var errors = [];
		
		if($.trim($('#f-user').val()) == ''){
			errors.push('The Username cant\'t be empty');
		}
		if($.trim($('#f-fname').val()) == ''){
			errors.push('The First Name cant\'t be empty');
		}
		if($.trim($('#f-lname').val()) == ''){
			errors.push('The Last Name cant\'t be empty');
		}
		if($.trim($('#f-email').val()) == ''){
			errors.push('The Email cant\'t be empty');
		}
		if($.trim($('#f-pw').val()) == ''){
			errors.push('The password cant\'t be empty');
		}
		if($('#f-pw').val() != $('#f-pw2').val()){
			errors.push('The password dosen\'t match');
		}
		
		if(errors.length > 0){
			displayErrors(errors);
			return false;
		}
		displayErrors([]);
		
		$('ul', this).hide();
		$('#f-submit').hide();
		$('<div id="loading-div">Loading...</div>').appendTo(this);
		
		var vars = {
			key: '<?=$key;?>',
			user: $('#f-user').val(),
			fname: $('#f-fname').val(),
			lname: $('#f-lname').val(),
			email: $('#f-email').val(),
			password: $('#f-pw').val()
			
		}
		
		var url = '<?=home_url('/');?>?page_id=234&register=true';
		$.post(url, vars, function($data) {
			$('#loading-div').remove();
	  		if($data.success){
	  			var str = '<p>Your registration is complete, please <a href="#" id="login-reg">login here</a></p>';
	  			$(str).appendTo('#f-registration');
	  			displayErrors([]);
	  			$('#login-reg').click(function(){
	  				$('#signin-link').click();
	  				$('#loginline input[name="log"]').val(vars.user);
	  				return false;
	  			});
	  		}else{
	  			$('#f-registration ul').show();
				$('#f-submit').show();
				displayErrors($data.errors);
	  		}
		}, 'json');
		$.trim()
		
		return false;
	});
});

function displayErrors($errors){
	$('#form-errors').remove();
	var str = '<div id="form-errors">';
	for(var i in $errors){
		str += '<p>'+$errors[i]+'</p>';
	}
	str += '</div>';
	$(str).appendTo('#f-registration');
}
</script>
<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Overview</span></span>
				<?php if ( !dynamic_sidebar('About') ) : // begin primary sidebar widgets ?>
                <?php endif; // end primary sidebar widgets  ?>
            <span class="bordertop"><img class="lista" src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottom.png" /></span>
        </div>
        
   <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>Join <?=$user_query['organization'];?></h1>      
                    <p><?=$user_query['about'];?></p>                                                
                    
                    <form id="f-registration">     
                  	<ul id="newBill" style="padding:4px 0 0;">
                        <li><label class="labelLeft">Username:</label><input id="f-user" type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">First Name:</label><input id="f-fname" type="text" size="40" class="text"></li>
		            	<li><label class="labelLeft">Last Name:</label><input id="f-lname" type="text" size="40" class="text"></li>
		            	<li><label class="labelLeft">EMail:</label><input id="f-email" type="text" size="40" class="text" value="<?=$invitation_query['email'];?>"></li>
		            	<li><label class="labelLeft">Password</label><input id="f-pw" type="password" size="40" class="text"></li>
		            	<li><label class="labelLeft">Confirm Password</label><input id="f-pw2" type="password" size="40" class="text"></li>                     
		            </ul>
					<input class="superboton" type="button" id="f-submit" value="Register" />
					</form>
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>	


</body>
</html>