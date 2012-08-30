<?PHP global $pn_tables; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?></title>
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
    <meta property="og:image" content="http://www.policyninja.org/cms/wp-content/themes/pninja/images/logo.png" />
<?php /*
<meta property="og:title" content="Hawaii Policy Portal" />
<meta property="og:type" content="Political Advocacy and Transparency" />
<meta property="og:image" content="http://www.policyninja.org/cms/wp-content/themes/pninja/images/logo.png" />
<meta property="og:description" content="Take Action Now! <?php wp_title( '-', true, 'right' ); echo wp_specialchars( get_bloginfo('name'), 1 ) ?>" />
<meta property="og:site_name" content="Policy Ninja" />
*/ ?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" />
	<?php wp_head() // For plugins ?>
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php printf( __( '%s latest posts', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'sandbox' ), wp_specialchars( get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
    
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/css/uniform.default.css" type="text/css" media="screen">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/custom-theme/jquery-ui-1.8.5.custom.css" type="text/css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/css/date.css" type="text/css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/css/autocomplete.css" type="text/css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/shadowbox/shadowbox.css" type="text/css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/jwysiwyg/css/jquery.wysiwyg.css" type="text/css" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory') ?>/css/superfish.css" />
    
    <script type="text/javascript">var _wpUrl = '<?php bloginfo("url"); ?>';</script>

    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery-1.4.2.min.js" type="text/javascript"></script>
    <script src="http://cdn.jquerytools.org/1.2.5/all/jquery.tools.min.js"></script>
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery-ui-1.8.5.custom.min.js" type="text/javascript"></script>
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/superfish.js"></script> 
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.uniform.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.youtubin.js" type="text/javascript" charset="utf-8"></script>
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.dataTables.js"  type="text/javascript" language="javascript"></script>
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.dataTables.currencySort.js" type="text/javascript"></script>
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.upload-1.0.2.min.js"  type="text/javascript"></script>  
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.cookie.js" type="text/javascript"></script> 
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/jquery.json-2.2.min.js" type="text/javascript"></script>
    <script src="<?php bloginfo('stylesheet_directory') ?>/jwysiwyg/jquery.wysiwyg.js" type="text/javascript"></script>
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/extras.js" type="text/javascript"></script> 
    <script src="<?php bloginfo('stylesheet_directory') ?>/js/base.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory') ?>/js/shadowbox/shadowbox.css">
	<script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/shadowbox/shadowbox.js"></script>
	<script type="text/javascript">
	Shadowbox.init();
	</script>


    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/swfobject/swfobject.js"></script>

    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory') ?>/js/uploadify/jquery.uploadify.min.js"></script>
    
    <script src="<?php bloginfo('stylesheet_directory') ?>/shadowbox/shadowbox.js" type="text/javascript"></script>  
    <script type="text/javascript">Shadowbox.init();</script>  
    
    <?php if (is_home()) { ?>
    <script type="text/javascript">
            var flashvars = {};
            flashvars.xml = "<?php bloginfo('stylesheet_directory') ?>/config.xml";
            flashvars.font = "<?php bloginfo('stylesheet_directory') ?>/font.swf";
            var attributes = {};
            attributes.wmode = "transparent";
            attributes.id = "slider";
            swfobject.embedSWF("<?php bloginfo('stylesheet_directory') ?>/cu3er.swf", "cu3er-container", "960", "360", "9", "<?php bloginfo('stylesheet_directory') ?>/expressInstall.swf", flashvars, attributes);
    </script>
    <?php } else { }?>
    
    
</head>

<body class="<?php if (is_home()) { echo'home'; } else if (is_page('54')) { echo'takeaction'; } else { echo'single'; } ?>">

<!--<div style="display:none;" id="members" title="Members Area">
	<p>You need to login to access the members area.</p>
	<form name="al_loginForm" onsubmit="return false;" id="al_loginForm" action="#" method="post">
	<div class="loginline"><label><span><?php _e('User') ?>:</span><input class="label" onkeypress="return al_loginOnEnter(event);" type="text" name="log" value="" size="20" tabindex="7" /></label></div>
    <div class="loginline"><label><span><?php _e('Password') ?>:</span><input class="label" onkeypress="return al_loginOnEnter(event);" type="password" name="pwd" value="" size="20" tabindex="8" /></label></div>
    <div class="loginline"><label><input style="width:20px; float:left;" type="checkbox" name="rememberme" value="forever" tabindex="9" /> <span style="font-size:11px;"><?php _e("Remember me"); ?></span></label>
						<a style="font-size:11px; float:right; margin-right:10px;" href="<?php echo wp_lostpassword_url( get_bloginfo('url') ); ?>">Lost password?</a>
    </div>
    <input type="button" name="submit" value="<?php _e('Login'); ?> &raquo;" tabindex="10" onclick="al_login();"/><br/>
    <span id="al_loginMessage"></span>
    </form> 
</div>-->
    
<?php global $post; 
if (is_home()) { ?>    
<div class="container">

	<div id="header">
		<a href="#" id="logo"></a>
		<div id="navigation">
        
      		<div id="loggingbg">
                <span id="logging">
                	<?php if ( is_user_logged_in() ) { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/?p=166">My Profile</a>
                    <a id="signup-link" class="nomargin" href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>">Logout</a> 
                    <?php } else { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/login/?action=register">Register</a> 
                    <a class="nomargin" href="<?php bloginfo('url');?>/login/?action=login">Sign in</a>
                    <?php } ?>
                </span>
            </div>
            
            <?php wp_nav_menu(array('menu'=>'Main menu', 'container'=>false, 'menu_class'=>'sf-menu', 'menu_id'=>'mainmenu'));?>

		</div>
    </div>

</div>
<?php } else if (is_page('108') || is_page('201') || is_page('205') || is_page('208') || is_page('209') || is_page('211') || is_page('222') || is_page('227') || is_page('223')) { ?>
<div id="takeactionbg">
<div class="container">

    <div id="header">
    <?PHP
		  	
		  		$id_letter = $wp_query->query_vars['letter'];
		  		
		  		if (is_page('201') || is_page('222') || is_page('227') || is_page('223')) $table_query = "$pn_tables->form_testimony";
		 		else if (is_page('209')) $table_query = "$pn_tables->form_petition";
		 		else if (is_page('208') || is_page('211')) $table_query = "$pn_tables->form_letter";
		 		else $table_query = "";
		 		
		 		
		 		if ($table_query != "") {
		 			global $pn_tables;	
		 			$sql = "SELECT up.avatar 
							FROM $pn_tables->user_profile AS up INNER JOIN $table_query AS ft ON up.wuid = ft.wuid
							WHERE ft.id = '$id_letter';";
					//echo $sql;
		  			$avatar = $wpdb->get_var($sql);				
		  		} else {
		  			global $pn_tables;
		  			wp_get_current_user();
					global $current_user;
					$uid = $current_user->ID;
               	 	$sql = "SELECT avatar FROM $pn_tables->user_profile WHERE wuid = $uid;";
                	$result = $wpdb->get_results($sql, ARRAY_A);
                	$avatar = $result[0]['avatar'];
		  		}
		  		/*
		  		wp_get_current_user();
				global $current_user;
				$uid = $current_user->ID;
                $sql = "SELECT avatar FROM pn_user_profile WHERE wuid = $uid;";
                $result = $wpdb->get_results($sql, ARRAY_A);
                $avatar = $result[0]['avatar'];
                */
                
		  	?>
		  	<?PHP if(trim($avatar) != '') : ?>
		<table width="390" border="0" height="120" class="logocenter">
		  <tr>
		    <td><img src="http://www.policyninja.org/?ajax&resizeImage=<?=$avatar?>" /></td>
	      </tr>
	    </table>
	    <?PHP else: ?>
                <table width="390" border="0" height="120" class="logocenter">
          <tr>
            <td><img src="http://www.policyninja.org/?ajax&resizeImage=/wp-content/themes/pninja/images/logo.png" /></td>
          </tr>
        </table>
<!--	    <a href="#" id="logo"></a> -->
	    <?PHP endif; ?>
		<div id="navigation">
        
      		<div id="loggingbg">
                <span id="logging">
                	<?php if ( is_user_logged_in() ) { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/?p=166">My Profile</a>
                    <a id="signup-link" class="nomargin" href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>">Logout</a> 
                    <?php } else { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/login/?action=register">Register</a> 
                    <a class="nomargin" href="<?php bloginfo('url');?>/login/?action=login">Sign in</a>
                    <?php } ?>
                </span>
            </div>
            
                        <?php wp_nav_menu(array('menu'=>'Main menu', 'container'=>false, 'menu_class'=>'sf-menu', 'menu_id'=>'mainmenu'));?>

		</div>

    </div>
<?php } else if (is_page('41') || is_page('43') || is_page('45') || is_page('52') || is_page('172') || is_page('176') || is_page('178') || is_page('166') || is_page('47') || is_page('186')) { ?>


<div id="actionbg">
<div class="container">

    <div id="header">
    	<a id="logo" href="<?php bloginfo('url');?>/"></a>
        <div id="navigation">
        
            <div id="loggingbg">
                <span id="logging">
                	<?php if ( is_user_logged_in() ) { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/?p=166">My Profile</a>
                    <a id="signup-link" class="nomargin" href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>">Logout</a> 
                    <?php } else { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/login/?action=register">Register</a> 
                    <a class="nomargin" href="<?php bloginfo('url');?>/login/?action=login">Sign in</a>
                    <?php } ?>
                </span>
            </div>
            
            <?php wp_nav_menu(array('menu'=>'Main menu', 'container'=>false, 'menu_class'=>'sf-menu', 'menu_id'=>'mainmenu'));?>

		</div>

    </div>

<?php } else if (is_page('20') || is_page('26') || is_page('28') || is_page('22')) { ?>

<div id="educationbg">
<div class="container">

    <div id="header">
    	<a id="logo" href="<?php bloginfo('url');?>/"></a>
        <div id="navigation">
        
            <div id="loggingbg">
                <span id="logging">
                	<?php if ( is_user_logged_in() ) { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/?p=166">My Profile</a>
                    <a id="signup-link" class="nomargin" href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>">Logout</a> 
                    <?php } else { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/login/?action=register">Register</a> 
                    <a class="nomargin" href="<?php bloginfo('url');?>/login/?action=login">Sign in</a>
                    <?php } ?>
                </span>
            </div>
            
            <?php wp_nav_menu(array('menu'=>'Main menu', 'container'=>false, 'menu_class'=>'sf-menu', 'menu_id'=>'mainmenu'));?>

		</div>

    </div>

<?php } else if (is_page('30') || is_page('36') || is_page('38') || is_page('32') || is_page('58') || is_page('54')) { ?>

<div id="transparencybg">
<div class="container">

    <div id="header">
    	<a id="logo" href="<?php bloginfo('url');?>/"></a>
        <div id="navigation">
        
            <div id="loggingbg">
                <span id="logging">
                	<?php if ( is_user_logged_in() ) { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/?p=166">My Profile</a>
                    <a id="signup-link" class="nomargin" href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>">Logout</a> 
                    <?php } else { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/login/?action=register">Register</a> 
                    <a class="nomargin" href="<?php bloginfo('url');?>/login/?action=login">Sign in</a>
                    <?php } ?>
                </span>
            </div>
            
            <?php wp_nav_menu(array('menu'=>'Main menu', 'container'=>false, 'menu_class'=>'sf-menu', 'menu_id'=>'mainmenu'));?>

		</div>

    </div>

<?php } else if (is_page('2')) { ?>

<div id="overviewbg">
<div class="container">

    <div id="header">
    	<a id="logo" href="<?php bloginfo('url');?>/"></a>
        <div id="navigation">
        
            <div id="loggingbg">
                <span id="logging">
                	<?php if ( is_user_logged_in() ) { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/?p=166">My Profile</a>
                    <a id="signup-link" class="nomargin" href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>">Logout</a> 
                    <?php } else { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/login/?action=register">Register</a> 
                    <a class="nomargin" href="<?php bloginfo('url');?>/login/?action=login">Sign in</a>
                    <?php } ?>
                </span>
            </div>
            
            <?php wp_nav_menu(array('menu'=>'Main menu', 'container'=>false, 'menu_class'=>'sf-menu', 'menu_id'=>'mainmenu'));?>

		</div>

    </div>

<?php } else { ?>

<div id="overviewbg">
<div class="container">

    <div id="header">
    	<a id="logo" href="<?php bloginfo('url');?>/"></a>
        <div id="navigation">
        
            <div id="loggingbg">
                <span id="logging">
                	<?php if ( is_user_logged_in() ) { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/?p=166">My Profile</a>
                    <a id="signup-link" class="nomargin" href="<?php echo wp_logout_url( get_bloginfo('url') ); ?>">Logout</a> 
                    <?php } else { ?>
                    <a id="signup-link" href="<?php bloginfo('url');?>/login/?action=register">Register</a> 
                    <a class="nomargin" href="<?php bloginfo('url');?>/login/?action=login">Sign in</a>
                    <?php } ?>
                </span>
            </div>
            
            <?php wp_nav_menu(array('menu'=>'Main menu', 'container'=>false, 'menu_class'=>'sf-menu', 'menu_id'=>'mainmenu'));?>

		</div>

    </div>

<?php } ?>
