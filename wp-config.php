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
define('DB_NAME', 'db_shopping_tls');

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
define('AUTH_KEY',         '?>a!L@>EV.Xz#-89Ri[J1YPNYH]_;C.JJAN^3WfKnD {zO+I^nQK/o?B,Ld;r~Xe');
define('SECURE_AUTH_KEY',  'H39E[kZS3g`G/P6![%>k0hKy))5qpf=K7,uR{uKbAH{%.MDJ77XlXk7rm80I+ }~');
define('LOGGED_IN_KEY',    'DNarknBv?BVYoY38&h<Tr-5 `*;IaBZ-/~@*UI@g5<Xs)MuJQtICqHAWL}A^{p),');
define('NONCE_KEY',        '7~)JE0# >=b$#)JAG5G3{YI;$[s3|L1Y;w7]#XwK+wC^/pC@+Q)|^(*~V.,Fs!*i');
define('AUTH_SALT',        ';Mcv, f6eQMD6Y]wE=z%TGKfm?[:^ug[:z|}0C:{@%m*Q2+nJTxwjIt[,z+0-Od7');
define('SECURE_AUTH_SALT', 'q4DU,qQ<K.F9=*le]e%5X8b%}:2,(Q3U?}_0XL*/_ID^.1/9u*O5&pYN4lzGJ{W}');
define('LOGGED_IN_SALT',   'NwrzCjG<F 6(#lIN5cZN V4T}@xY2EPhlO{0PHm!~fJ?N>/InNezx.:G7h zm}zs');
define('NONCE_SALT',       'hmy{ O$k^M<SDc2Ur,{cS(~!cjB.%&IYM!_b%NnA]={[{>}_u1fh:I~gwapCV9u(');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'tlsspo_';

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
