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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'project_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'B*kgfR@{*j5375G=:0?&jkd`v]gG.%&u[%|N<S,7U`?PG=hiqk0`evMf<V&`{,w_' );
define( 'SECURE_AUTH_KEY',  'I-G>3{VZFKcz.x|8_TfY]3BT6%Ts](sBJ-o-8&UAp!xv5+AyZBk:cqh3:{gW;,%D' );
define( 'LOGGED_IN_KEY',    '0gTC0HdgSmH#d3CqS@_Bl^/LAt+8C)sCQ)Zp6FDX5Ie[t`[ dZn`6]6P#%)4c~t)' );
define( 'NONCE_KEY',        '*o+!yJLB%R;Q7qiF0wbNa[!ZN5QoJzA1p$?Fj(vQ0gV(<~C&jMtIYj1HB)Qf~dwh' );
define( 'AUTH_SALT',        'Fy3.BIo;sIHwNE`A,]djgQKQba?rB{6`mWw*@Kt%0yD^$U?Ui:~U2vb_*vJc8k-!' );
define( 'SECURE_AUTH_SALT', 'SU^B1/#]cMaqlo[;wioB=:Sgx3l$}o^S{<:oswEcO?m~Zf^et/a{K*YK-,iZ{$|z' );
define( 'LOGGED_IN_SALT',   'e!>7M_FlS30g(|Ec 7r|4->)cshndvL-5YPk?5E16K;R?Q5_&jtxL1Re;fq~sEOX' );
define( 'NONCE_SALT',       'ivXn&=tb~<Kc/?M+~9?l53)GUx_F;kLJQTL146(9{$$%8%zHtdP]=BmY^{o6eDiq' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
