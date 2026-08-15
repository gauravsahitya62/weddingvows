<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wvbn' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '!A9pp{v*c>[l3Ud ,$~RKwC+/G/ZW1$T^V/y9G(uv_m,|OPk>,*$ca@Xd=?I.U=A' );
define( 'SECURE_AUTH_KEY',  'o?8!C8pI)zo+{JS2gxa#I|op(RV[,qb{v^1Bwn53^S0)kiyPSA$z&E<C?&PpC.GA' );
define( 'LOGGED_IN_KEY',    'EDC&/jNTN8am&9;YN0/G=@}Nk.~x7brB-v)RW:=jfCArehp=0$k.^YsUqr|k(z!e' );
define( 'NONCE_KEY',        'EG;X6tP_[~ 1@&CJllmypu.lZe_1:v^0RcV8{_X6<!yGYvyBq?joGm$Uy*[:vKK:' );
define( 'AUTH_SALT',        '__=MC^3@}C15e}lH;UZ/&72C+KY/RG0|hK>,xHPVy[Z_8Ch91*[8[Lie1h&T*9kB' );
define( 'SECURE_AUTH_SALT', '(1#-JQiMwt h3uo3{(V^?h+qbijU38-c.x>jc= =A,cEz)KiEdotM8d?7 d-}ae[' );
define( 'LOGGED_IN_SALT',   'H8tO!t[96Xj5ZXrphGo{Hh^.FQ]G1h3@C6EB^JMj#7z8/2frLv/AxL^zVc5ohz=,' );
define( 'NONCE_SALT',       ',=iGdtIT29c XCQqh1A@hao$n3[sb>=E,VyA>h+(n~Y2zhFgK=^~aR3bP/!-)QH7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
