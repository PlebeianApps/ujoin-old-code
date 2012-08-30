<?php
/*
This file is part of SANDBOX.

SANDBOX is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or (at your option) any later version.

SANDBOX is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with SANDBOX. If not, see http://www.gnu.org/licenses/.
*/

error_reporting (E_ALL ^ E_NOTICE);

add_theme_support('menus');
add_theme_support('post-thumbnails');

register_sidebar(array(
  'name' => 'About',
  'description' => 'Widgets for all single pages.',
  'before_title' => '<h2>',
  'after_title' => '</h2>'
));

register_sidebar(array(
  'name' => 'Education',
  'description' => 'Widgets for the education page.',
  'before_title' => '<h2>',
  'after_title' => '</h2>'
));

register_sidebar(array(
  'name' => 'Transparency',
  'description' => 'Widgets for transparency page.',
  'before_title' => '<h2>',
  'after_title' => '</h2>'
));

register_sidebar(array(
  'name' => 'Action',
  'description' => 'Widgets for action pages.',
  'before_title' => '<h2>',
  'after_title' => '</h2>'
));

register_sidebar(array(
  'name' => 'Home',
  'description' => 'Home far-right section.',
  'before_title' => '<h2>',
  'after_title' => '</h2>'
));

function register_my_menus() {
register_nav_menus(
array(
'header-menu' => __( 'Header Menu' )
)
);
}

function user_is_admin(){
	global $user_ID;
	if( $user_ID ) return current_user_can('level_10');
	return false;
}


// Produces a list of pages in the header without whitespace
function sandbox_globalnav() {
	if ( $menu = str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages('title_li=&sort_column=menu_order&echo=0') ) )
		$menu = '<ul>' . $menu . '</ul>';
	$menu = '<div id="menu">' . $menu . "</div>\n";
	echo apply_filters( 'globalnav_menu', $menu ); // Filter to override default globalnav: globalnav_menu
}

// Generates semantic classes for BODY element
function sandbox_body_class( $print = true ) {
	global $wp_query, $current_user;

	// It's surely a WordPress blog, right?
	$c = array('wordpress');

	// Applies the time- and date-based classes (below) to BODY element
	sandbox_date_classes( time(), $c );

	// Generic semantic classes for what type of content is displayed
	is_front_page()  ? $c[] = 'home'       : null; // For the front page, if set
	is_home()        ? $c[] = 'blog'       : null; // For the blog posts page, if set
	is_archive()     ? $c[] = 'archive'    : null;
	is_date()        ? $c[] = 'date'       : null;
	is_search()      ? $c[] = 'search'     : null;
	is_paged()       ? $c[] = 'paged'      : null;
	is_attachment()  ? $c[] = 'attachment' : null;
	is_404()         ? $c[] = 'four04'     : null; // CSS does not allow a digit as first character

	// Special classes for BODY element when a single post
	if ( is_single() ) {
		$postID = $wp_query->post->ID;
		the_post();

		// Adds 'single' class and class with the post ID
		$c[] = 'single postid-' . $postID;

		// Adds classes for the month, day, and hour when the post was published
		if ( isset( $wp_query->post->post_date ) )
			sandbox_date_classes( mysql2date( 'U', $wp_query->post->post_date ), $c, 's-' );

		// Adds category classes for each category on single posts
		if ( $cats = get_the_category() )
			foreach ( $cats as $cat )
				$c[] = 's-category-' . $cat->slug;

		// Adds tag classes for each tags on single posts
		if ( $tags = get_the_tags() )
			foreach ( $tags as $tag )
				$c[] = 's-tag-' . $tag->slug;

		// Adds MIME-specific classes for attachments
		if ( is_attachment() ) {
			$mime_type = get_post_mime_type();
			$mime_prefix = array( 'application/', 'image/', 'text/', 'audio/', 'video/', 'music/' );
				$c[] = 'attachmentid-' . $postID . ' attachment-' . str_replace( $mime_prefix, "", "$mime_type" );
		}

		// Adds author class for the post author
		$c[] = 's-author-' . sanitize_title_with_dashes(strtolower(get_the_author_login()));
		rewind_posts();
	}

	// Author name classes for BODY on author archives
	elseif ( is_author() ) {
		$author = $wp_query->get_queried_object();
		$c[] = 'author';
		$c[] = 'author-' . $author->user_nicename;
	}

	// Category name classes for BODY on category archvies
	elseif ( is_category() ) {
		$cat = $wp_query->get_queried_object();
		$c[] = 'category';
		$c[] = 'category-' . $cat->slug;
	}

	// Tag name classes for BODY on tag archives
	elseif ( is_tag() ) {
		$tags = $wp_query->get_queried_object();
		$c[] = 'tag';
		$c[] = 'tag-' . $tags->slug;
	}

	// Page author for BODY on 'pages'
	elseif ( is_page() ) {
		$pageID = $wp_query->post->ID;
		$page_children = wp_list_pages("child_of=$pageID&echo=0");
		the_post();
		$c[] = 'page pageid-' . $pageID;
		$c[] = 'page-author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));
		// Checks to see if the page has children and/or is a child page; props to Adam
		if ( $page_children )
			$c[] = 'page-parent';
		if ( $wp_query->post->post_parent )
			$c[] = 'page-child parent-pageid-' . $wp_query->post->post_parent;
		if ( is_page_template() ) // Hat tip to Ian, themeshaper.com
			$c[] = 'page-template page-template-' . str_replace( '.php', '-php', get_post_meta( $pageID, '_wp_page_template', true ) );
		rewind_posts();
	}

	// Search classes for results or no results
	elseif ( is_search() ) {
		the_post();
		if ( have_posts() ) {
			$c[] = 'search-results';
		} else {
			$c[] = 'search-no-results';
		}
		rewind_posts();
	}

	// For when a visitor is logged in while browsing
	if ( $current_user->ID )
		$c[] = 'loggedin';

	// Paged classes; for 'page X' classes of index, single, etc.
	if ( ( ( $page = $wp_query->get('paged') ) || ( $page = $wp_query->get('page') ) ) && $page > 1 ) {
		// Thanks to Prentiss Riddle, twitter.com/pzriddle, for the security fix below.
		$page = intval($page); // Ensures that an integer (not some dangerous script) is passed for the variable
		$c[] = 'paged-' . $page;
		if ( is_single() ) {
			$c[] = 'single-paged-' . $page;
		} elseif ( is_page() ) {
			$c[] = 'page-paged-' . $page;
		} elseif ( is_category() ) {
			$c[] = 'category-paged-' . $page;
		} elseif ( is_tag() ) {
			$c[] = 'tag-paged-' . $page;
		} elseif ( is_date() ) {
			$c[] = 'date-paged-' . $page;
		} elseif ( is_author() ) {
			$c[] = 'author-paged-' . $page;
		} elseif ( is_search() ) {
			$c[] = 'search-paged-' . $page;
		}
	}

	// Separates classes with a single space, collates classes for BODY
	$c = join( ' ', apply_filters( 'body_class',  $c ) ); // Available filter: body_class

	// And tada!
	return $print ? print($c) : $c;
}

// Generates semantic classes for each post DIV element
function sandbox_post_class( $print = true ) {
	global $post, $sandbox_post_alt;

	// hentry for hAtom compliace, gets 'alt' for every other post DIV, describes the post type and p[n]
	$c = array( 'hentry', "p$sandbox_post_alt", $post->post_type, $post->post_status );

	// Author for the post queried
	$c[] = 'author-' . sanitize_title_with_dashes(strtolower(get_the_author('login')));

	// Category for the post queried
	foreach ( (array) get_the_category() as $cat )
		$c[] = 'category-' . $cat->slug;

	// Tags for the post queried; if not tagged, use .untagged
	if ( get_the_tags() == null ) {
		$c[] = 'untagged';
	} else {
		foreach ( (array) get_the_tags() as $tag )
			$c[] = 'tag-' . $tag->slug;
	}

	// For password-protected posts
	if ( $post->post_password )
		$c[] = 'protected';

	// Applies the time- and date-based classes (below) to post DIV
	sandbox_date_classes( mysql2date( 'U', $post->post_date ), $c );

	// If it's the other to the every, then add 'alt' class
	if ( ++$sandbox_post_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for post DIV
	$c = join( ' ', apply_filters( 'post_class', $c ) ); // Available filter: post_class

	// And tada!
	return $print ? print($c) : $c;
}

// Define the num val for 'alt' classes (in post DIV and comment LI)
$sandbox_post_alt = 1;

// Generates semantic classes for each comment LI element
function sandbox_comment_class( $print = true ) {
	global $comment, $post, $sandbox_comment_alt;

	// Collects the comment type (comment, trackback),
	$c = array( $comment->comment_type );

	// Counts trackbacks (t[n]) or comments (c[n])
	if ( $comment->comment_type == 'comment' ) {
		$c[] = "c$sandbox_comment_alt";
	} else {
		$c[] = "t$sandbox_comment_alt";
	}

	// If the comment author has an id (registered), then print the log in name
	if ( $comment->user_id > 0 ) {
		$user = get_userdata($comment->user_id);
		// For all registered users, 'byuser'; to specificy the registered user, 'commentauthor+[log in name]'
		$c[] = 'byuser comment-author-' . sanitize_title_with_dashes(strtolower( $user->user_login ));
		// For comment authors who are the author of the post
		if ( $comment->user_id === $post->post_author )
			$c[] = 'bypostauthor';
	}

	// If it's the other to the every, then add 'alt' class; collects time- and date-based classes
	sandbox_date_classes( mysql2date( 'U', $comment->comment_date ), $c, 'c-' );
	if ( ++$sandbox_comment_alt % 2 )
		$c[] = 'alt';

	// Separates classes with a single space, collates classes for comment LI
	$c = join( ' ', apply_filters( 'comment_class', $c ) ); // Available filter: comment_class

	// Tada again!
	return $print ? print($c) : $c;
}

// Generates time- and date-based classes for BODY, post DIVs, and comment LIs; relative to GMT (UTC)
function sandbox_date_classes( $t, &$c, $p = '' ) {
	$t = $t + ( get_option('gmt_offset') * 3600 );
	$c[] = $p . 'y' . gmdate( 'Y', $t ); // Year
	$c[] = $p . 'm' . gmdate( 'm', $t ); // Month
	$c[] = $p . 'd' . gmdate( 'd', $t ); // Day
	$c[] = $p . 'h' . gmdate( 'H', $t ); // Hour
}

// For category lists on category archives: Returns other categories except the current one (redundant)
function sandbox_cats_meow($glue) {
	$current_cat = single_cat_title( '', false );
	$separator = "\n";
	$cats = explode( $separator, get_the_category_list($separator) );
	foreach ( $cats as $i => $str ) {
		if ( strstr( $str, ">$current_cat<" ) ) {
			unset($cats[$i]);
			break;
		}
	}
	if ( empty($cats) )
		return false;

	return trim(join( $glue, $cats ));
}

// For tag lists on tag archives: Returns other tags except the current one (redundant)
function sandbox_tag_ur_it($glue) {
	$current_tag = single_tag_title( '', '',  false );
	$separator = "\n";
	$tags = explode( $separator, get_the_tag_list( "", "$separator", "" ) );
	foreach ( $tags as $i => $str ) {
		if ( strstr( $str, ">$current_tag<" ) ) {
			unset($tags[$i]);
			break;
		}
	}
	if ( empty($tags) )
		return false;

	return trim(join( $glue, $tags ));
}

// Produces an avatar image with the hCard-compliant photo class
function sandbox_commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
		$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
		$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar_size = apply_filters( 'avatar_size', '32' ); // Available filter: avatar_size
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, $avatar_size ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}

// Function to filter the default gallery shortcode
function sandbox_gallery($attr) {
	global $post;
	if ( isset($attr['orderby']) ) {
		$attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
		if ( !$attr['orderby'] )
			unset($attr['orderby']);
	}

	extract(shortcode_atts( array(
		'orderby'    => 'menu_order ASC, ID ASC',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
	), $attr ));

	$id           =  intval($id);
	$orderby      =  addslashes($orderby);
	$attachments  =  get_children("post_parent=$id&post_type=attachment&post_mime_type=image&orderby={$orderby}");

	if ( empty($attachments) )
		return null;

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $id => $attachment )
			$output .= wp_get_attachment_link( $id, $size, true ) . "\n";
		return $output;
	}

	$listtag     =  tag_escape($listtag);
	$itemtag     =  tag_escape($itemtag);
	$captiontag  =  tag_escape($captiontag);
	$columns     =  intval($columns);
	$itemwidth   =  $columns > 0 ? floor(100/$columns) : 100;

	$output = apply_filters( 'gallery_style', "\n" . '<div class="gallery">', 9 ); // Available filter: gallery_style

	foreach ( $attachments as $id => $attachment ) {
		$img_lnk = get_attachment_link($id);
		$img_src = wp_get_attachment_image_src( $id, $size );
		$img_src = $img_src[0];
		$img_alt = $attachment->post_excerpt;
		if ( $img_alt == null )
			$img_alt = $attachment->post_title;
		$img_rel = apply_filters( 'gallery_img_rel', 'attachment' ); // Available filter: gallery_img_rel
		$img_class = apply_filters( 'gallery_img_class', 'gallery-image' ); // Available filter: gallery_img_class

		$output  .=  "\n\t" . '<' . $itemtag . ' class="gallery-item gallery-columns-' . $columns .'">';
		$output  .=  "\n\t\t" . '<' . $icontag . ' class="gallery-icon"><a href="' . $img_lnk . '" title="' . $img_alt . '" rel="' . $img_rel . '"><img src="' . $img_src . '" alt="' . $img_alt . '" class="' . $img_class . ' attachment-' . $size . '" /></a></' . $icontag . '>';

		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "\n\t\t" . '<' . $captiontag . ' class="gallery-caption">' . $attachment->post_excerpt . '</' . $captiontag . '>';
		}

		$output .= "\n\t" . '</' . $itemtag . '>';
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= "\n</div>\n" . '<div class="gallery">';
	}
	$output .= "\n</div>\n";

	return $output;
}

// Widget: Search; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_search($args) {
	extract($args);
	$options = get_option('widget_sandbox_search');
	$title = empty($options['title']) ? __( 'Search', 'sandbox' ) : attribute_escape($options['title']);
	$button = empty($options['button']) ? __( 'Find', 'sandbox' ) : attribute_escape($options['button']);
?>
			<?php echo $before_widget ?>
				<?php echo $before_title ?><label for="s"><?php echo $title ?></label><?php echo $after_title ?>
				<form id="searchform" class="blog-search" method="get" action="<?php bloginfo('home') ?>">
					<div>
						<input id="s" name="s" type="text" class="text" value="<?php the_search_query() ?>" size="10" tabindex="1" />
						<input type="submit" class="button" value="<?php echo $button ?>" tabindex="2" />
					</div>
				</form>
			<?php echo $after_widget ?>
<?php
}

// Widget: Search; element controls for customizing text within Widget plugin
function widget_sandbox_search_control() {
	$options = $newoptions = get_option('widget_sandbox_search');
	if ( $_POST['search-submit'] ) {
		$newoptions['title'] = strip_tags(stripslashes( $_POST['search-title']));
		$newoptions['button'] = strip_tags(stripslashes( $_POST['search-button']));
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_sandbox_search', $options );
	}
	$title = attribute_escape($options['title']);
	$button = attribute_escape($options['button']);
?>
	<p><label for="search-title"><?php _e( 'Title:', 'sandbox' ) ?> <input class="widefat" id="search-title" name="search-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<p><label for="search-button"><?php _e( 'Button Text:', 'sandbox' ) ?> <input class="widefat" id="search-button" name="search-button" type="text" value="<?php echo $button; ?>" /></label></p>
	<input type="hidden" id="search-submit" name="search-submit" value="1" />
<?php
}

// Widget: Meta; to match the Sandbox style and replace Widget plugin default
function widget_sandbox_meta($args) {
	extract($args);
	$options = get_option('widget_meta');
	$title = empty($options['title']) ? __( 'Meta', 'sandbox' ) : attribute_escape($options['title']);
?>
			<?php echo $before_widget; ?>
				<?php echo $before_title . $title . $after_title; ?>
				<ul>
					<?php wp_register() ?>

					<li><?php wp_loginout() ?></li>
					<?php wp_meta() ?>

				</ul>
			<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; to match the Sandbox style
function widget_sandbox_rsslinks($args) {
	extract($args);
	$options = get_option('widget_sandbox_rsslinks');
	$title = empty($options['title']) ? __( 'RSS Links', 'sandbox' ) : attribute_escape($options['title']);
?>
		<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<ul>
				<li><a href="<?php bloginfo('rss2_url') ?>" title="<?php echo wp_specialchars( get_bloginfo('name'), 1 ) ?> <?php _e( 'Posts RSS feed', 'sandbox' ); ?>" rel="alternate" type="application/rss+xml"><?php _e( 'All posts', 'sandbox' ) ?></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url') ?>" title="<?php echo wp_specialchars(bloginfo('name'), 1) ?> <?php _e( 'Comments RSS feed', 'sandbox' ); ?>" rel="alternate" type="application/rss+xml"><?php _e( 'All comments', 'sandbox' ) ?></a></li>
			</ul>
		<?php echo $after_widget; ?>
<?php
}

// Widget: RSS links; element controls for customizing text within Widget plugin
function widget_sandbox_rsslinks_control() {
	$options = $newoptions = get_option('widget_sandbox_rsslinks');
	if ( $_POST['rsslinks-submit'] ) {
		$newoptions['title'] = strip_tags( stripslashes( $_POST['rsslinks-title'] ) );
	}
	if ( $options != $newoptions ) {
		$options = $newoptions;
		update_option( 'widget_sandbox_rsslinks', $options );
	}
	$title = attribute_escape($options['title']);
?>
	<p><label for="rsslinks-title"><?php _e( 'Title:', 'sandbox' ) ?> <input class="widefat" id="rsslinks-title" name="rsslinks-title" type="text" value="<?php echo $title; ?>" /></label></p>
	<input type="hidden" id="rsslinks-submit" name="rsslinks-submit" value="1" />
<?php
}

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
function sandbox_widgets_init() {
	if ( !function_exists('register_sidebars') )
		return;

	// Formats the Sandbox widgets, adding readability-improving whitespace
	$p = array(
		'before_widget'  =>   "\n\t\t\t" . '<li id="%1$s" class="widget %2$s">',
		'after_widget'   =>   "\n\t\t\t</li>\n",
		'before_title'   =>   "\n\t\t\t\t". '<h3 class="widgettitle">',
		'after_title'    =>   "</h3>\n"
	);

	// Table for how many? Two? This way, please.
	register_sidebars( 0, $p );

	// Finished intializing Widgets plugin, now let's load the Sandbox default widgets; first, Sandbox search widget
	$widget_ops = array(
		'classname'    =>  'widget_search',
		'description'  =>  __( "A search form for your blog (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'search', __( 'Search', 'sandbox' ), 'widget_sandbox_search', $widget_ops );
	unregister_widget_control('search'); // We're being Sandbox-specific; remove WP default
	wp_register_widget_control( 'search', __( 'Search', 'sandbox' ), 'widget_sandbox_search_control' );

	// Sandbox Meta widget
	$widget_ops = array(
		'classname'    =>  'widget_meta',
		'description'  =>  __( "Log in/out and administration links (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'meta', __( 'Meta', 'sandbox' ), 'widget_sandbox_meta', $widget_ops );
	unregister_widget_control('meta'); // We're being Sandbox-specific; remove WP default
	wp_register_widget_control( 'meta', __( 'Meta', 'sandbox' ), 'wp_widget_meta_control' );

	//Sandbox RSS Links widget
	$widget_ops = array(
		'classname'    =>  'widget_rss_links',
		'description'  =>  __( "RSS links for both posts and comments (Sandbox)", "sandbox" )
	);
	wp_register_sidebar_widget( 'rss_links', __( 'RSS Links', 'sandbox' ), 'widget_sandbox_rsslinks', $widget_ops );
	wp_register_widget_control( 'rss_links', __( 'RSS Links', 'sandbox' ), 'widget_sandbox_rsslinks_control' );
}

// Translate, if applicable
load_theme_textdomain('sandbox');

// Runs our code at the end to check that everything needed has loaded
add_action( 'init', 'sandbox_widgets_init' );

// Registers our function to filter default gallery shortcode
add_filter( 'post_gallery', 'sandbox_gallery', $attr );

// Adds filters for the description/meta content in archives.php
add_filter( 'archive_meta', 'wptexturize' );
add_filter( 'archive_meta', 'convert_smilies' );
add_filter( 'archive_meta', 'convert_chars' );
add_filter( 'archive_meta', 'wpautop' );

// Remember: the Sandbox is for play.





/* Functions for policy ninja, don't touch!! */

function add_query_vars($aVars) {
    $aVars[] = "letter";
    $aVars[] = "template";
    $aVars[] = "template_id";
    return $aVars;
}
add_filter('query_vars', 'add_query_vars');

function validate_letter(){
	global $form_table, $form_var, $form_query, $wp_query, $wpdb;
	if(!isset($wp_query->query_vars[$form_var]) || is_nan($wp_query->query_vars[$form_var])){
		wp_redirect( get_option( 'siteurl' ).'?1'); exit();
	}
	
	$letter = $wp_query->query_vars[$form_var];
	$sql = "SELECT * FROM $form_table WHERE id = $letter AND status != 0;";
	$form_query = $wpdb->get_results($sql, ARRAY_A);
	
	if(count($form_query) != 1){
		wp_redirect( get_option( 'siteurl' ).'?2'); exit();
	}
}

function is_group_admin($id=''){
	$id = get_user_id($id);
	if($id < 1) return false;
	$value = get_user_meta( $id, 'user_is_group', true);
	return $value == '1';
}

function get_user_group($id=''){
	$id = get_user_id($id);
	if($id < 1) return false;
	return get_user_meta( $id, 'user_parent', true);
}

function get_user_id($id=''){
	global $current_user;
	$id = (int)$id;
	if(is_nan($id) || $id < 1){
		wp_get_current_user();
		$id = $current_user->ID;
	}
	return $id;
}
function testimony_exists($bill_id){
	return action_page_exists('form_testimony', $bill_id);
}

function advocacy_exists($bill_id){
	return action_page_exists('form_letter', $bill_id, 'advocacy');
}

function letter_exists($bill_id){
	return action_page_exists('form_letter', $bill_id, 'letter');
}

function petition_exists($bill_id){
	return action_page_exists('form_petition', $bill_id);
}

function action_page_exists($tbl, $bill_id, $type=''){
	global $wpdb, $pn_tables;
	$uid = get_user_group();
	if($tbl == 'form_letter' && trim($type) != ''){
		$type = "AND `type` = '$type'";
	}
	$tbl = $pn_tables->$tbl;
	$sql = "SELECT COUNT(id) FROM $tbl WHERE bill = $bill_id AND wuid = $uid AND status = 1 $type;";
	//echo "<pre>$sql</pre>";
	$total = $wpdb->get_var($sql);
	return $total > 0;
}

function is_valid_template(){
	if(isset($_REQUEST['template'], $_REQUEST['template_id']) && !is_nan($_REQUEST['template_id'])){
		$types = array('testimony', 'advocacy', 'letter', 'petition');
		return in_array($_REQUEST['template'], $types);
	}
	return false;
}

function get_form_table($type){
	global $pn_tables;
	$types = array('testimony' =>  $pn_tables->form_testimony, 'advocacy' =>  $pn_tables->form_letter, 'letter' =>  $pn_tables->form_letter, 'petition' =>  $pn_tables->form_petition);
	return $types[$type];
	
}


function get_testimony_mail($id, $key=''){
	global $wpdb, $pn_tables;

	$sql = "SELECT * FROM $pn_tables->form_testimony WHERE id = $id AND status != 0;";
	$form_query = $wpdb->get_row($sql, ARRAY_A);
	
	include_once("ajax/library/class.gridservice.php");
	$g = new GridService();
	
	$sql = "SELECT name FROM $pn_tables->committee WHERE comm_id = '".$form_query['committee']."' LIMIT 1;";
    $committee = $wpdb->get_var($sql);
	$sql = "SELECT title FROM wp_pn_bills_search_results WHERE id = ".$form_query['bill']." LIMIT 1;";
	$billName = $wpdb->get_var($sql);	
	$sql = "SELECT measure_title FROM $pn_tables->form_user WHERE id = ".$form_query['bill']." LIMIT 1;";
	$billName = $wpdb->get_var($sql);
	
	$committee_mem = $g->getCommitteeMembers($form_query['committee']);
		
	$msg = 'Representative '.$committee_mem['Chair'].', Chair<br/>
			Representative '.$committee_mem['Vicechair'].', Vice Chair<br/>
			'.$committee.'<br/>
			<br/>
			From: Kory Payne<br/>
			Executive Director<br/>
			Voter Owned Hawaii<br/>
			1142 Waialae Ave, Suite #8<br/>
			Honolulu, HI 96816<br/>
			<br/>
			Date: '.$form_query['date'].'<br/>
			<br/>
			Subject: Support for '.$billName.'';
	
	/*
	$sql = "SELECT * FROM $pn_tables->form_testimony WHERE id = $id AND status != 0;";
	$form_query = $wpdb->get_row($sql, ARRAY_A);
	$sql = "SELECT measure_title FROM $pn_tables->bills WHERE id = ".$form_query['bill']." LIMIT 1;";
	$billName = $wpdb->get_var($sql);
	$sql = "SELECT name FROM $pn_tables->committee WHERE comm_id = '".$form_query['committee']."' LIMIT 1;";
    $committee = $wpdb->get_var($sql);
	$msg = 'Position Statement: '.($form_query['statment'] == '0' ? 'Strong support for' : 'Strong opposition to')."<br/>";
	$sql = "SELECT title FROM $pn_tables->form_category WHERE id = ".$form_query['category'];
	$category = $wpdb->get_var($sql);
	$url = home_url('/')."?page_id=201&letter=$id&key=$key";
	$msg = $url."<br/>";
	$msg = "Name of Bill: $billName<br/>";
	$msg .= 'Date: '.$form_query['date']."<br/>";
	$msg .= 'URL: '.$form_query['url']."<br/>";
	$msg .= 'RSS update URL: '.$form_query['rss']."<br/>";
	$msg .= "Committee: $committee<br/>";
	$msg .= 'Category: '.$category."<br/>";
	$msg .= 'Description of the Bill: '.$form_query['description']."<br/>";
	$msg .= 'Sample Talking Points: '.$form_query['talking_points']."<br/>";
	$msg .= 'Sample Testimony: '.$form_query['testimony']."<br/>";
	$msg .= 'Sample Video: '.$form_query['youtube']."<br/>";
	*/
	
	
	return $msg;
	
}
function get_letter_mail($id, $key=''){
	global $wpdb, $pn_tables;
	$sql = "SELECT * FROM $pn_tables->form_letter WHERE id = $id AND status != 0;";
	$form_query = $wpdb->get_row($sql, ARRAY_A);
	$sql = "SELECT title FROM wp_pn_bills_search_results WHERE id = ".$form_query['bill']." LIMIT 1;";
	$billName = $wpdb->get_var($sql);
	$sql = "SELECT name FROM $pn_tables->committee WHERE comm_id = '".$form_query['committee']."' LIMIT 1;";
    $committee = $wpdb->get_var($sql);
	$type = $form_query['type'] == 'letter' ? '208' : '211';
	$url = home_url('/')."?page_id=$type&letter=$id&key=$key";
	$msg = $url."<br/>";
	$msg = "Name of Bill: $billName<br/>";
	$msg .= 'To: '.$form_query['to']."<br/>";
	$msg .= 'BCC: '.$form_query['bbc']."<br/>";
	$msg .= "Committee: $committee<br/>";
	$msg .= 'Title: '.$form_query['title']."<br/>";
	$msg .= 'Overview: '.$form_query['overview']."<br/>";
	$msg .= 'Talking Points: '.$form_query['message']."<br/>";
	$msg .= 'Sample Message: '.$form_query['talking_points']."<br/>";
	$msg .= 'Sample Video: '.$form_query['youtube']."<br/>";
	return $msg;
	
}
function get_petition_mail($id, $key=''){
	global $wpdb, $pn_tables;
	$sql = "SELECT * FROM $pn_tables->form_petition WHERE id = $id AND status != 0;";
	$form_query = $wpdb->get_row($sql, ARRAY_A);
	$sql = "SELECT measure_title FROM pn_bills WHERE id = ".$form_query['bill']." LIMIT 1;";
	$billName = $wpdb->get_var($sql);
	$sql = "SELECT name FROM $pn_tables->committee WHERE comm_id = '".$form_query['committee']."' LIMIT 1;";
    $committee = $wpdb->get_var($sql);
    $category = $wpdb->get_var($sql);
	$msg = 'Position Statement: '.(@$form_query['statment'] == '0' ? 'Strong support for' : 'Strong opposition to')."<br/>";
	$url = home_url('/')."?page_id=209&letter=$id&key=$key";
	$msg = $url."<br/>";
	$msg = "Name of Bill: $billName<br/>";
	$msg .= "Committee: $committee<br/>";
	$msg .= 'Category: '.$category."<br/>";
	$msg .= 'Description '.$form_query['description']."<br/>";
	$msg .= 'Sample Video: '.$form_query['youtube']."<br/>";
	return $msg;

	
}

function get_current_url() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function get_url_string_value($url, $var) {
	$tmp = explode('?', $url);
	$vars = explode('&', $tmp[1]);
	foreach($vars as $data){
		$tmp = explode('=', $data);
		if($tmp[0] == $var) return $tmp[1];
	}
	return '';
}

function set_uer_group($user_id) {
	update_user_meta( $user_id, 'user_parent', $user_id);
	update_user_meta( $user_id, 'user_is_group', '1');
}
add_filter('user_register','set_uer_group',99);







//////////////////////////////////////////////////
// real sim shady ////////////////////////////////
//////////////////////////////////// ah yeah /////
// @simloovoo @luminopolis ///////////////////////
//////////////////////////////////////////////////

/* Disable the Admin Bar. */
add_filter( 'show_admin_bar', '__return_false' );

function generate_open_states_manager() {
	global $wpdb;
//	$api_url = "http://openstates.org/api/v1/bills/?state=HI&searchwindow=session&apikey=aa6d2f4176d047a2baa5d8d4a6f1061d";
	$api_url = "custom filtering of OpenStates data";

	if($_POST['billSearch']=='1'){
/*
	//	$bills_json = file_get_contents($api_url); // pull directly from api
		$bills_json = file_get_contents(get_template_directory().'/bills2012-02-15.json', FILE_USE_INCLUDE_PATH); // pull from manually processed file uploaded to server
		$bills = json_decode($bills_json);
		foreach ($bills as $bill) {
			$wpdb->insert('wp_pn_bills_search_results', array(
				'bill_id'  => $bill->bill_id,
				'state'    => $bill->state,
				'session'  => $bill->session,
				'chamber'  => $bill->chamber,
				'title'    => $bill->title,
				'subjects' => implode(',', $bill->subjects),
				'json'     => json_encode($bill),
				'api_url'  => $api_url));
		}
*/	}

	echo '

	<div id="open_states_api_manager">
		<form action="'.get_site_url().'/wp-admin/tools.php?page=open_states_api_manager" method="post">
			<p>come on you slags</p>
			<input type="hidden" name="billSearch" value="1" />
			<input type="submit" value="Get Data" />
		</form>
	</div>';
}
function register_open_states_page(){
	$myPage = add_submenu_page('tools.php', 'Open States API Manager', 'Open States API Manager', 'upload_files', 'open_states_api_manager', 'generate_open_states_manager');
}

/*
  Commenting out following line hides page from menu
*/
//add_action('admin_menu', 'register_open_states_page');



function optInRegisterForm(){
	$optInCheckbox = '<label for="optIn" style="margin: 50px; padding: 1em 0 2em;">I have read and agreed to the <a href="'.
					  get_bloginfo('url').'/about/terms-conditions">Terms &amp; Conditions</a>'.
					  'and the <a href="'.get_bloginfo('url').'/about/privacy-policy">Privacy Policy</a>.'.
					  '<input type="checkbox" required="true" name="optIn" value="1" id="optIn" />';
	echo $optInCheckbox;
}
add_action('register_form', optInRegisterForm);


function fetchBillInfo($billDbId) {
	global $wpdb;
	$wpdb->show_errors();

	//fetch basics from search
	if($billDbId && $billDbId != '')
		$billData = $wpdb->get_row("SELECT * FROM wp_pn_bills_search_results WHERE id = $billDbId LIMIT 1;", ARRAY_A);
	else
		return false;

    $lookupDbId = $billData['bill_lookup_id']; // attached bill info from API Lookup
    $scrapeDbId = $billData['bill_scrape_id']; // ''

    $lookupDbExists = !($lookupDbId==0);
    $scrapeDbExists = !($scrapeDbId==0);

    $billName = $billData["title"];
    $reportTitle = $billData["subjects"];
    $billId = $billData["bill_id"];

    
    /* Check for existence of each table. Pull information from OpenStates API & Capitol.Hawaii.gov if needed. Format and store in database. */
   	if(!$lookupDbExists && $billData["state"] != '' && $billData['session']!= '' && $billData['bill_id'] !='') {

		//we need to hit up the OpenStates API: Bill Lookup http://openstates.org/api/bills/#bill-lookup
		//construct the url
		$api_url = "http://openstates.org/api/v1/bills/".$billData["state"]."/".rawurlencode($billData['session'])."/".rawurlencode($billData['bill_id'])."/?apikey=aa6d2f4176d047a2baa5d8d4a6f1061d";

	    $billLookupJson = file_get_contents($api_url);

		/** Bill Lookup object http://openstates.org/api/bills/#bill-lookup
		{sources : [{url, retrieved}],
		 scraped_subjects : [""],
		 +description : "",
		 +referral : "",
		 sponsors: [{leg_id, name, type}],
		 versions: [{name, url}],
		 votes: [{chamber, date, motion,
		 		 no_count, no_votes: [{leg_id, name}]},
		 		 other_count, other_votes: [{leg_id, name}],
		 		 passed: bool,
		 		 sources: [{url, retrieved}],
		 		 type, vote_id,
		 		 yes_count, yes_votes: [{leg_id, name}]],
		documents: [{}],
		subjects: [""],
		type: [""],
		bill_id, chamber, country, created_at, level, session, state, title, updated_at
		} // yay pseudocode documentation
		**/
	    $billLookup = json_decode($billLookupJson);



	    //pull data from object
	    $description = $billLookup->{"+description"};
	    $referral = $billLookup->{"+referral"};
	    $actions = json_encode($billLookup->actions);

	    if(isset($billLookup->scraped_subjects))
		    $scraped_subjects = implode(', ', $billLookup->scraped_subjects);

	    $sources = json_encode($billLookup->sources);

		function returnSponsorName($sponsor) {return $sponsor->name;} 
        $introducers = array_map(returnSponsorName, $billLookup->sponsors);
        $sponsors = implode(', ', $introducers);

	    $versions = json_encode($billLookup->versions);
	    $votes = json_encode($billLookup->votes);
	    $documents = json_encode($billLookup->documents);
	    $source = $billLookup->sources[0]->url;


	    //insert into database http://codex.wordpress.org/Class_Reference/wpdb#INSERT_rows
	    $wpdb->insert('wp_pn_bills_lookup',
	    	array(
		    	'bills_search_id' => $billDbId,
		    	'json'            => $billLookupJson,
		    	'description'     => $description,
		    	'actions'         => $actions,
		    	'scraped_subjects'=> $scraped_subjects,
		    	'sources'         => $sources,
		    	'sponsors'        => $sponsors,
		    	'versions'        => $versions,
		    	'votes'           => $votes,
		    	'api_url'         => $api_url,
		    	'documents'       => $documents,
		    	'current_referral'=> $referral
		    ), array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
	    $lookupDbId = $wpdb->insert_id;

		//maintain references amongst tables
		$wpdb->update('wp_pn_bills_search_results', array('bill_lookup_id'=>$lookupDbId), array('id'=>$billDbId), array('%d'), array('%d'));

    } 

   	$lookupData = $wpdb->get_row("SELECT * FROM wp_pn_bills_lookup WHERE id= $lookupDbId LIMIT 1;", ARRAY_A);
    if(!$scrapeDbExists) {
    	//we need to scrape capitol.hawaii.gov

    	if(!isset($source)){
			//stored as raw JSON string in db
			$lookupDataParsedJson = json_decode($lookupData['json']);
			$source = $lookupDataParsedJson->sources[0]->url;
		}

		if($source && $source!='') {
            $rawSource = file_get_contents($source);
            if($rawSource) {
            	//scrape
                $dom = new DomDocument();
                @$dom->loadHTML($rawSource); //suppress errors from faulty pages
                $companion = $dom->getElementById('ListView1_ctrl0_companionLabel')->nodeValue;
                $package = $dom->getElementById("ListView1_ctrl0_package_acroLabel")->nodeValue;
                $referral = $dom->getElementById('ListView1_ctrl0_current_referralLabel')->nodeValue;
                $hearingComm = $dom->getElementById('GridView1_ctl02_Label17')->nodeValue;
                $hearingDate = $dom->getElementById('GridView1_ctl02_Label27')->nodeValue;
    
                $hearingLinkElem = $dom->getElementById('GridView1_ctl02_hearingNoticeLink');
                $hearingNoticeLink;
                if($hearingLinkElem) {
                    $hearingNoticeLink = $hearingLinkElem->getAttribute('href');
                } 
            }
        }

        $wpdb->insert('wp_pn_bills_scrape',
        	array(
	        	'companion'=>$companion,
	        	'package'=>$package,
	        	'referral'=>$referral,
	        	'hearing_committee'=>$hearingComm,
	        	'hearing_date'=>$hearingDate,
	        	'hearing_link'=>$hearingNoticeLink,
	        	'bills_search_id'=>$billDbId,
	        	'bills_lookup_id'=>$lookupDbId,
	        	'source_url'=>$source
	        ), array(
		    	'%s','%s','%s','%s','%s','%s','%d','%d','%s'
		    )
        );
        $scrapeDbId = $wpdb->insert_id;

		//maintain references amongst tables
		$wpdb->update('wp_pn_bills_search_results', array('bill_scrape_id'=>$scrapeDbId), array('id'=>$billDbId), array('%d'), array('%d'));
		$wpdb->update('wp_pn_bills_lookup', array('bill_scrape_id'=>$scrapeDbId), array('id'=>$lookupDbId), array('%d'), array('%d'));

	}	

   	$scrapeData = $wpdb->get_row("SELECT * FROM wp_pn_bills_scrape WHERE id= $scrapeDbId LIMIT 1;", ARRAY_A);
	/* construct returnable object */
	$billData = array_merge($billData, $lookupData, $scrapeData);

	return $billData;
}
?>