<?php
if ( file_exists( dirname( __FILE__ ) . '/wp-config-local.php' ) ) {
  include( dirname( __FILE__ ) . '/wp-config-local.php' );
}

/** The name of the database for WordPress. */
if ( ! defined( 'DB_NAME' ) ) {
  define( 'DB_NAME', 'bloomp6_dev' );
}

/** MySQL database user name. */
if ( ! defined( 'DB_USER' ) ) {
  define( 'DB_USER', 'bloomp6_devuser' );
}

/** MySQL database password. */
if ( ! defined( 'DB_PASSWORD' ) ) {
  define( 'DB_PASSWORD', '2}{hdDl$0?fp' );
}

/** MySQL host name. */
if ( ! defined( 'DB_HOST' ) ) {
  define( 'DB_HOST', 'localhost' );
}

/** WordPress localized language. Defaults to 'en_EN'. */
if ( ! defined( 'WPLANG' ) ) {
  define( 'WPLANG', '' );
}

/** WordPress debugging mode. */
if ( ! defined( 'WP_DEBUG' ) ) {
  define( 'WP_DEBUG', false );
}

/** WordPress memory limit. Default: 40M. Multi site: 64M. Default max.: 256M. */
define( 'WP_MEMORY_LIMIT', '256M' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. */
define( 'DB_COLLATE', '' );

/** Authentication unique keys and salts. */
define( 'AUTH_KEY', '' );
define( 'SECURE_AUTH_KEY', '' );
define( 'LOGGED_IN_KEY', '' );
define( 'NONCE_KEY', '' );
define( 'AUTH_SALT', '' );
define( 'SECURE_AUTH_SALT', '' );
define( 'LOGGED_IN_SALT', '' );
define( 'NONCE_SALT', '' );

/** WordPress database table prefix. */
$table_prefix = 'wp_';

if ( ! defined( 'WP_DEFAULT_THEME' ) ) {
  define( 'WP_DEFAULT_THEME', 'twentytwelve' );
}

/** Disallow anything that creates, deletes, or updates core, plugin, or theme files. Files in uploads are excepted. */
if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
  define( 'DISALLOW_FILE_MODS', true );
}

/** Defines functionality related WordPress constants. */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
  define( 'WP_POST_REVISIONS', false );
}

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}



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
define('AUTH_KEY',         '`x$0%J+2Rszr&|pvwEcQm(CCjLJ XqZh>Z{}HY}U`R=*PAg|a7k:B{^xkJJ K-l?');
define('SECURE_AUTH_KEY',  '&3^*.:=vWFKkqrLi$j6;8r[)C^T&6Z./(M&|7nm?+gl}0;A)*f-r!%b|,mhwlf(+');
define('LOGGED_IN_KEY',    '*N%>$tf$gT*:]B%xQ:|L.+gfty2 1u8 yzv;Akyl-;4(QJ|dHYu0^8@-Pbo}S%e8');
define('NONCE_KEY',        'fyhAXmN-{^HXEbU#5>.uWqL1T:)H;]BK!v&&ICcQ2f04hi%`o2/Nx-/m2:qs+r/Q');
define('AUTH_SALT',        'tnPUrEeut6,rF>=ixjv~M96n*$+[Z1deoFz+Mr]xK}lTgJ[=h4J:*xqJja]H8_>a');
define('SECURE_AUTH_SALT', 's{;uismjY`PI|J#?N9{;@:DkQWpv8>_z7-G{j0Nn+A-IOs_p+d<$>-nXJpe#CC[o');
define('LOGGED_IN_SALT',   ')Sr;B9V(@a*,]}Fp;.C%/ |:Y0Hi|nvnSyuyB?X1#0h[bO5HZ!2+gSsPAsfdp@qY');
define('NONCE_SALT',       'as:f-;fMmDm,,=gvhf00%:Aqz:26l1p;+lu5A.~WxYF~^$+r/L+{Ge?+6p#XIhG}');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define('WP_HOME','http://dev.bloompost.com');
define('WP_SITEURL','http://dev.bloompost.com');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
