<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'anddab94');

/** MySQL database username */
define('DB_USER', 'adminAnd');

/** MySQL database password */
define('DB_PASSWORD', 'Andrzej1%1');

/** MySQL hostname */
define('DB_HOST', 'mysql.cba.pl');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'DPh9Gy  +gO0.MS(<Bqd(#/OV>X|`?!()b!POkbZjYl]rDMKihH1jR.#M8~uS*#{');
define('SECURE_AUTH_KEY',  'Q~&MXnBtYw;=qF:C6FcriQVp.7kAYcLcq/x*sEImDQ3L86D/oxJ&h+90<G1OLTiR');
define('LOGGED_IN_KEY',    'HfzWH&fnz0SNi+1q!Y5Xuu#NP,9RtXQA/%W.nha*u4WK$S9(d#}[6Tf]1yt~n[V@');
define('NONCE_KEY',        '_X?h>s%O+BhY,x;NCC8P[oc]a[@YXE8;CBW5C57XM<yN4Q?}AMGBMU]La[WhV7K+');
define('AUTH_SALT',        'QB76asl PQ*3Lrv{wNogYZWRcC&7OZ*O:qBt;yrLT{kgUHyR{QModqv13~R!7h&d');
define('SECURE_AUTH_SALT', 'E>bOqiA[i!S|:foL.rFYQ`1BLa9ppbrs*i{zG>`REX``4RN0+$YbblGc$*P%mZo@');
define('LOGGED_IN_SALT',   'Lq)RhOkdJhXWmc]rWKIpr7#%841s_l$kgG7fIVh}qr{Lh4y;k,Qhe?/HBxR*T2lt');
define('NONCE_SALT',       '+`h4P5Hi71J.G2;26@WyG__LawRCHD8jnI1y5AX#-Oc;=++<iPT1Y^G% 0c{.+%p');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpakl_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
