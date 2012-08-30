<?PHP

	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_bills` (
					`id` int(11) NOT NULL auto_increment,
					`bill_id` varchar(20) default NULL,
					`measure_title` varchar(255) default NULL,
					`report_title` varchar(255) default NULL,
					`description` tinytext,
					`companion` varchar(11) default NULL,
					`package` varchar(11) default NULL,
					`current_referral` varchar(11) default NULL,
					`sponsor_id` varchar(20) default NULL,
					`committe_reports` varchar(11) default NULL,
					`testimony` varchar(11) default NULL,
					`process` tinyint(4) default NULL,
					`status` tinyint(4) default '1',
  					PRIMARY KEY  (`id`),
  					UNIQUE KEY `bill_id` (`bill_id`)
										) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 	
		
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_form_letter` (
					`id` int(8) NOT NULL auto_increment,
					`wuid` int(8) NOT NULL,
					`bill` int(11) default NULL,
					`committee` varchar(6) default NULL,
					`to` varchar(255) NOT NULL,
					`bbc` varchar(255) NOT NULL,
					`title` varchar(100) NOT NULL,
					`overview` varchar(100) NOT NULL,
					`talking_points` text NOT NULL,
					`message` text NOT NULL,
					`youtube` varchar(100) NOT NULL,
					`nimbb` tinyint(11) default NULL,
					`type` varchar(10) NOT NULL,
					`email` mediumtext,
					`publish` datetime NOT NULL,
					`status` tinyint(1) NOT NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 		
					
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_form_petition` (
					`id` int(8) NOT NULL auto_increment,
					`wuid` int(8) NOT NULL,
					`bill` int(11) default NULL,
					`committee` varchar(6) default NULL,
					`title` varchar(100) NOT NULL,
					`category` int(4) NOT NULL,
					`description` text NOT NULL,
					`youtube` varchar(50) NOT NULL,
					`nimbb` tinyint(11) default NULL,
					`email` mediumtext,
					`publish` datetime NOT NULL,
					`status` tinyint(1) NOT NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 	
																		
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_form_testimony` (
					`id` int(8) NOT NULL auto_increment,
					`wuid` int(8) NOT NULL,
					`statment` tinyint(1) NOT NULL,
					`bill` int(11) NOT NULL default '0',
					`date` date NOT NULL,
					`url` varchar(100) NOT NULL,
					`rss` varchar(100) NOT NULL,
					`committee` varchar(6) NOT NULL default '0',
					`category` int(4) NOT NULL,
					`description` text NOT NULL,
					`talking_points` text NOT NULL,
					`testimony` text NOT NULL,
					`youtube` varchar(50) NOT NULL,
					`nimbb` tinyint(11) default NULL,
					`email` mediumtext,
					`publish` datetime NOT NULL,
					`status` tinyint(1) NOT NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 																			
		
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_form_update` (
					`id` int(11) NOT NULL auto_increment,
					`wuid` int(11) NOT NULL,
					`title` varchar(100) NOT NULL,
					`description` text NOT NULL,
					`date` datetime NOT NULL,
					`type` varchar(10) NOT NULL,
					`parent` int(11) NOT NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;"); 																			
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_form_user` (
					`id` int(11) NOT NULL auto_increment,
					`first_name` varchar(100) NOT NULL,
					`last_name` varchar(100) NOT NULL,
					`email` varchar(100) NOT NULL,
					`address` varchar(255) NOT NULL,
					`city` varchar(50) NOT NULL,
					`state` varchar(50) NOT NULL,
					`postal_code` varchar(15) NOT NULL,
					`phone` varchar(20) NOT NULL,
					`testimony` text NOT NULL,
					`youtube` varchar(50) NOT NULL,
					`published` datetime NOT NULL,
					`parent` int(11) NOT NULL,
					`parent_table` varchar(20) NOT NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;"); 																			
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_guest_users` (
					`id` int(11) NOT NULL auto_increment,
					`wuid` int(11) default NULL,
					`page_id` int(11) default NULL,
					`type` varchar(20) default NULL,
					`email` varchar(50) default NULL,
					`key` varchar(50) default NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;"); 																		
					
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_invitations` (
					`id` int(11) NOT NULL auto_increment,
					`pid` int(11) NOT NULL,
					`email` varchar(255) NOT NULL,
					`date` datetime NOT NULL,
					`key` varchar(40) NOT NULL,
					`status` tinyint(1) NOT NULL,
					PRIMARY KEY  (`id`,`email`)
					) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;"); 
	
	
					
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_user_profile` (
					`wuid` int(11) NOT NULL,
					`organization` varchar(255) NOT NULL,
					`address` varchar(255) NOT NULL,
					`phone` varchar(50) NOT NULL,
					`city` varchar(50) NOT NULL,
					`state` varchar(50) NOT NULL,
					`zip` varchar(50) NOT NULL,
					`about` varchar(255) NOT NULL,
					`avatar` varchar(100) NOT NULL,
					PRIMARY KEY  (`wuid`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_committee` (
  					`id` int(11) NOT NULL auto_increment,
					`comm_id` varchar(20) default NULL,
					`name` varchar(255) default NULL,
					`status` tinyint(11) default NULL,
					 PRIMARY KEY  (`id`),
					 UNIQUE KEY `comm_id` (`comm_id`)
										) ENGINE=MyISAM DEFAULT CHARSET=utf8"); 

		$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_legislators` (
					`id` int(11) NOT NULL auto_increment,
					`govtrack_id` varchar(20) default NULL,
					`crp_id` varchar(20) default NULL,
					`firstname` varchar(20) default NULL,
					`middlename` varchar(20) default NULL,
					`lastname` varchar(20) default NULL,
					`district` varchar(20) default NULL,
					`title` varchar(5) default NULL,
					`cycle` int(11) default NULL,
					`address` varchar(255) default NULL,
					`phone` varchar(50) default NULL,
					`fax` varchar(20) default NULL,
					`email` varchar(50) default NULL,
					`party` varchar(20) default '',
					`status` tinyint(4) default '1',
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=541 DEFAULT CHARSET=utf8;	"); 						
										
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_legs2bills` (
					`bill_id` varchar(11) default NULL,
					`crp_id` varchar(11) default NULL,
					`comm_id` varchar(11) default NULL,
					`vote` int(11) default NULL
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 	
					
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_legs2committee` (
					`comm_id` varchar(11) default NULL,
					`crp_id` varchar(11) default NULL,
					`rank` int(11) default '3'
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 
					
		$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_cycles` (
					`id` int(11) NOT NULL auto_increment,
					`title` varchar(50) default NULL,
  					PRIMARY KEY  (`id`)
										) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 
					
					
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."pn_form_category` (
					`id` int(8) NOT NULL auto_increment,
					`title` varchar(100) NOT NULL,
					PRIMARY KEY  (`id`)
										) ENGINE=MyISAM DEFAULT CHARSET=utf8;"); 					

?>