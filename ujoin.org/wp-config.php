<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ujoin_org');

/** MySQL database username */
define('DB_USER', 'ujoinorg');

/** MySQL database password */
define('DB_PASSWORD', 'kgfJ7RgY');

/** MySQL hostname */
define('DB_HOST', 'mysql.niiwi.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '+N|iwwq03jKf(urypj``o&mDmkcv_iPrV}5rs8!9uEQhj, qNMj>u3(N{-S[>Inv');
define('SECURE_AUTH_KEY',  'q2hx<E/0cQSE!aul{QfiGsLZKWMp-FB4XHF#LJDPy?1:vJ+dGt/#.Indmd-+COf1');
define('LOGGED_IN_KEY',    'DjX_=:o<tYfx>VNa:=xnz|I.9B|<i+5DFP=%-Ut&Q-FdI57O-I4e7ZeAfzI||/Q,');
define('NONCE_KEY',        'i8f3{ufD}M0[d[yzH<yQvpoH({`m,r/yo^#{uT97A,3m9rBwER;-z@LGH3JRQ=)l');
define('AUTH_SALT',        '`.b)XkOYK-}L+y)7?h+a@3-P|w#AKf=^w#<Y-bM1B-La~o/!fqa-$t*$]KUz:rZ7');
define('SECURE_AUTH_SALT', '+o{Q|b.}W9vAr/Ac&Tl!ezT7c+5j:hDX~Y-P6+FF>aHq^&+)L 1Ax&U=)(z*MlPP');
define('LOGGED_IN_SALT',   'e|NP|(t+0!39<,V4WLTY6P-Z+ya5dP^MZz+u;>_i=k:DMoS$!kNDz9_tI>z|cPT2');
define('NONCE_SALT',       ':RBm2Iy|.u7AjP .-G#6Y9:QRVr~uJl--h,Mm=a+eS_#VSa+ZN]TS{qE_|0Jau-;');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);


//hypercache
define('WP_CACHE', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
