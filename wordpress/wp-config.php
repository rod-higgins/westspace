<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', 'wordpress' );

/** Database hostname */
define( 'DB_HOST', 'database' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '6cwuAO;OK!zUw;Td8BZhZ%I:qF+ebxDvkEiTLcDhbsAD2DYKP&8S[]!Yom/oa81-' );
define( 'SECURE_AUTH_KEY',   '_(@og)zpU&g&#O#8|TLe2bK$~gGAR8{1Bx,tu&nyo1ivF@2H0lTXj2uX/4k=ndr8' );
define( 'LOGGED_IN_KEY',     ':,Psw!}P=Cs3rK@SlR@Y!=iKp02h!07Bo]NId(C`oHPKu3-hvQM>F1~^L}LXxmEG' );
define( 'NONCE_KEY',         'mVQxS;(`CK&kygP$rZ)E#o|Ds(v(8|!GPa/bk :`;*m-X<)e!XZ2jMNkJ#}s) 8=' );
define( 'AUTH_SALT',         'M+c]G:a}KtR&V`-*[`1x13P]GlQ-<yL[E#]`}&nB )!V1={31S^P.7~d9`GR.K4 ' );
define( 'SECURE_AUTH_SALT',  ',P@;z5(6`6 &pPy+_rxB|4cDn);LB<#c}H|]1+{`NV(2An[d~FFG^L}6& 8ii82Y' );
define( 'LOGGED_IN_SALT',    '!vMkpY5Rx$W!fN8:!-gU:W+nZ_cOAmRJMD(-+Ns}=gb/Dg!eBvF~ h8o*L;wKa/`' );
define( 'NONCE_SALT',        'MwusWdw3zgww^/esyQdQWFRc>]oZyl#=UZeXl}lxZs=t@@e`o7,Np[>de|NIjOoX' );
define( 'WP_CACHE_KEY_SALT', 'LeuP0f>`bG_f-|wu,~w 68<*E!n#o[<#v>Apv^=f Hu3_|lKYhbMgy.W7n*w,M~#' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
