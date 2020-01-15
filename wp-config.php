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
define('DB_NAME', 'id10204469_web2033');

/** MySQL database username */
define('DB_USER', 'id10204469_admin');

/** MySQL database password */
define('DB_PASSWORD', '12345678');

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
define('AUTH_KEY',         'jkK!h]6{eQyya,s*rvc8$R]4q9gg9~[;e`vdreJyAXneZ&sG}TCL(h]iN50m3GsM');
define('SECURE_AUTH_KEY',  'E,(:Y!-/[#o3Z@uF1_%[bu&;2NusVjt}kp:2-o5GSeMd#UZ;V#tpjMO$sZL}S*Oz');
define('LOGGED_IN_KEY',    '+^sWDT@d=F]YgE1z1G&br&gB{5qZ+i$Z}Dak<&t:kR@~>T,1cl6o^,js!ro5o[vg');
define('NONCE_KEY',        '~l>6jA}z}jD91 oj94mRWt~^P#zbGHl@g<0Q~]Rl)#17%@/7bK#Ol8zm<[EOPGzm');
define('AUTH_SALT',        '+Xs|2:;q~_A;-$M@4N@Mu(JN~egD!#q:>^d9yWJO1s69i/!Oy77HqmuJuKH3-o6z');
define('SECURE_AUTH_SALT', 'FBZxv?<$dHi:9/G{Ar*Y-keHHF:fG4ZSTwE3;G*;]MGW%<;]{r-qoM$tP],E}?Ri');
define('LOGGED_IN_SALT',   'HWZEx82m,VOO^bvhJJ7hZsj&% NbZ~6uDBIG/pja^LVPD+z*][|n2oovrhsF1`ey');
define('NONCE_SALT',       'e~&2qh7j9[gPNVmo63N*M.$ObRMdkNeZk$iien8--xRz-I OdPzX7# 152Qh]hO7');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
