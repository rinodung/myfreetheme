<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache
define('WP_HOME','http://myfreetheme.com/');
define('WP_SITEURL','http://myfreetheme.com/');
define('FS_METHOD','direct');
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'theme');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'password!12@');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '!:{1]Q{p|z]a7xR(=-ZE,bhUp73T?1|#`[-Eo:QUM>m:TOSbv=Aq&50D5Nd-jAxX');
define('SECURE_AUTH_KEY',  'gLul|8z9i.:l.mBJ2Pr^6y-K<<Ij[VYi;)^};eqPr6jL/-V0H[WjnJ`InG urXTL');
define('LOGGED_IN_KEY',    'cN#rtrKFw>-Rv~i34`y3xF9BWdKnw!V<2+r<3S#<p+Ae^V=`yZ~ps8uK,cix#%H+');
define('NONCE_KEY',        'q<x91&B-25O8hrHd1w5FWfQBh62i|_~BPm%~9-fUN0$l;7J,&-ZlqUH!^;~a[5Z]');
define('AUTH_SALT',        '[)GH-k^-wRFE z5 P*+iTmk$Zlez$( *jX`qHaI1BVL0KD}- }N0H/t5y0VBW1o-');
define('SECURE_AUTH_SALT', '-oJ]q@.v&XQ-tDK%R)9G26!;CWGy*U?!yN/J`#_NVdH+:NYXxTw9.Vv^4 8+253`');
define('LOGGED_IN_SALT',   'MtD)x6PzU1d^A<MvH_5f)vqsa-.H9te3x%$N-c-H&4t-O@Pci3S`kb7NkQyba|pM');
define('NONCE_SALT',       'Ag%{QOKkFEI{`N>g$9wT|C)I`AANyH)8TG+GKF<n|O(!vc$+opD(r8Ka_+PZQ:yb');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'rr3j_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
