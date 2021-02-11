<?php

define('FS_METHOD', 'direct');
define('FORCE_SSL_ADMIN', true);

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
define( 'DB_NAME', 'dbs1411069' );

/** MySQL database username */
define( 'DB_USER', 'dbu645495' );

/** MySQL database password */
define( 'DB_PASSWORD', 'khBGuXjSEWHNmRJUEKDF' );

/** MySQL hostname */
define( 'DB_HOST', 'db5001706691.hosting-data.io' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '~mDR&Rl  Z?v0_.cRPBLEJ:IZ0cQp2fD&y/{J)]JS|MFVe#1ea7~D5^N?ORAzL<!' );
define( 'SECURE_AUTH_KEY',   'VSf:jK6^s-bSk7!WHL$q}hd8AvC1NL,DJZNGh-2J=nruMa^E&_t[s({4<z_={9G*' );
define( 'LOGGED_IN_KEY',     'dqdBSkqfs4:cH:kwYZxgDSQzkrS-hk$rE:v$@/-Cq8G&injk8+OA:ezXWou._?mh' );
define( 'NONCE_KEY',         'Op&ZjQJ0L)n.CFPeDdbU(G,VrSAgt9Cl?d)h>lFDgqW 5:M0gp%uX)=4li[BT5{h' );
define( 'AUTH_SALT',         'qN1H8XWwKYS,9~lKD2@ O{7jjx}mJH^}+l}pj}VfnK_40jl}$]tE!l+sW|A6zHNe' );
define( 'SECURE_AUTH_SALT',  '+yiRBpEiR9ZczQnXAoh ?sZ#YnJbzu W^*M<e} q:?aS- KzD|>3!{GQ2C T=Uw^' );
define( 'LOGGED_IN_SALT',    '>.]TuN =T3sI:q<WWyI:>2Ub}N(1*L{*43,B1uD>$?&k6+p6]vlCmMR.)F1z0gl0' );
define( 'NONCE_SALT',        ':CYWKg?dZ1_XSp_@:KY^.LY8cc$xn:c6+55>e+bZ:5#Y=|o3<r}xqtWa-B^DiVq(' );
define( 'WP_CACHE_KEY_SALT', 'I;EOVy&7^%mG4U>d5tl)FJA$-P:I;co[UiMC~C$vpTFd#./l@~m&+bF%X}lo#ZWf' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'umNfmYwz';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
