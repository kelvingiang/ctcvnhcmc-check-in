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
define('DB_NAME', 'ctcvnhcmc_check_in');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '}Wi:7.^%{z}HFu?Ao #B*Q1q*Yg{gw=lfl.]FbM5m6t)C.|TKe=;uP`lZ2$}cF*U');
define('SECURE_AUTH_KEY',  'k<HLBn}6o-yK<?42=wFcgXiVXp|KwbbE.g$8{2:a[<KHn4nQ4vlX>a5_w>P4BzB$');
define('LOGGED_IN_KEY',    '.Sz0%SV[2kftE%6z`a^EMQ$?)3sTqH@jSb_21jX^%e3&wD<T=4+:SH>5zX%]B}%6');
define('NONCE_KEY',        'a$)>F}:]U>%d<4:6pzXb?xVjBNN3#7^t6GY%06tBW3g+-K_J;gJt]@nM!an%bC9d');
define('AUTH_SALT',        'u!)K^zmN:Iio7Uioeg)e!JJ-AaI~[A.,RUZF)kU7|v..}zGOaIxdB-EL#7y5}_jv');
define('SECURE_AUTH_SALT', 'jy(ulG]60[u]H_Km*_=XKRxsl[mtj<h.Jk{5?+ev(]BbB_1#SdA#fM|A+lLjdI4y');
define('LOGGED_IN_SALT',   'Q0I95Ef!IU,W.BRH{gE|f/k#0i!~[ZD.dn*N1nHs76Xh|n}=P$sq*~xO{8$CQUzo');
define('NONCE_SALT',       't93fz0O{ztz8couV:IC|hD+u@%_Q.]!x&KkFM8{Bq{rK,hQ/rv0yw7.Q5=K0h!<U');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hcmc_';

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
define('WP_DEBUG',  FALSE);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
