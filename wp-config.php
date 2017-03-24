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
define('DB_NAME', 'petshop2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'Ed/%/+QvJa@v+5KpjcuW4Po<e8P`!CO+?7VT:J)x(H&8LY4I-Y%(h?&?@&$I`WNA');
define('SECURE_AUTH_KEY',  'jH7Exbn]omf XTy)S/?l(EtJ1#/w]aY+YY#dx9CVL&Meinw63(S`IIJE.p_!@T G');
define('LOGGED_IN_KEY',    'uXCI.=CzZpLRAzQxh[V<QBS(s~IgWaD<s[Ab^wmr}n=w~wDl$qEaH]U*DJ5$@wnO');
define('NONCE_KEY',        '1;4t7q`zN%8(s%Vo}rw$+|$QfP%X@; #gB{h:S!.ki^=mw>RX,X#8W3wapqMq &3');
define('AUTH_SALT',        'Odb: &n[fjYS YeLpbJfeA_]`9=N,hcU$m PO^7XW%Z_5O<3o;p9Rb4m$pN($lt|');
define('SECURE_AUTH_SALT', 'o#Q=xeLw).i?!C.e;_9m4<3|+CLn~[i9HU!a.pRU!-kX_>RkV70G?JhYZ3[n&wn&');
define('LOGGED_IN_SALT',   'kS=`L;>/F/{9M?hch+T:s)9T+e8H~9D<7iiR~x9WWl:b58O!M:!p`T(!Hj `OV?N');
define('NONCE_SALT',       'jz4W9leE_%NofUS;@3/G.gq[AapSy^W;hjIhqiRq9<lF!VXLT_j6B&5tWOTgQbYN');

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
