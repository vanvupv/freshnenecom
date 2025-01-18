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
define( 'DB_NAME', '202501freshnesecom' );

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
define( 'AUTH_KEY',         'uLLfiy;kYPxYnUV@ABnD/Y:9kSZ9z#,]F3<;`>N?1{I;I97x9[vD}`|,u9i,x)l3' );
define( 'SECURE_AUTH_KEY',  '=l+PUS@V}P;xsxl52e>5N19 }yxam+!?u]sD:v?}IoMx$n^d.[KZ4F*-.[.,y>gf' );
define( 'LOGGED_IN_KEY',    '87=W$C|zeI1`7P!/eoG{J^?AAl 3yN.v=NP[U :gqVENu;ZrA0(B!=T6`(>G43/@' );
define( 'NONCE_KEY',        'Zx2B/$wV4/C>Yg=j]8XyVp0sZ4ZYV(~Bc vhPz5s4qg}cdCT:,QB0icfKd9W(Q5s' );
define( 'AUTH_SALT',        'Q]2d)%`#>-}hpS/ME^t&EXg Icu$4&:@@?XS)81}Y7gBz)vVO7<o[rgx$10KB+P=' );
define( 'SECURE_AUTH_SALT', '?x);;eHve(guTp8`3iw{89/ $_z|Z$1bs3F_7Y}nr1,XC7WI?tbM8zprDTG:4>{o' );
define( 'LOGGED_IN_SALT',   'wxCI~T;DOn$DhnW8D9ki}xew&=9c;0)N&&OBGLw%5`ZJ_pf-qUe;Hl&hg%vzAu3-' );
define( 'NONCE_SALT',       'lxj9_)mLe-to5?>H#MluaJ8De(FXf2Ad=tQ3:zp>+Z;H~)NxvU7sa;,hf3*#eJd`' );

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
