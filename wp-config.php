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
define( 'DB_NAME', 'athome01_test' );

/** Database username */
define( 'DB_USER', 'athome01_test' );

/** Database password */
define( 'DB_PASSWORD', 'u4Xck3@^2D' );

/** Database hostname */
define( 'DB_HOST', 'athome01.mysql.tools' );

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
define( 'AUTH_KEY',         '5AMu|nI;K?hEMn+E=%gv[Qtzvk::L,9;g,:9z}.y~fAuW-,f7%yq=x+T&heKsS;@' );
define( 'SECURE_AUTH_KEY',  '=?[~=rS(v`N0B95gqMhnOfO-:/YX`0(b?(M?/$$9eecE4y3Vu@EgQAvmWD;ik2zI' );
define( 'LOGGED_IN_KEY',    '+D{IblZzyD|;h)px4o5/TJs_XMRh{IrK9 %T:qV[08lpjXgYvy?)Z&gN]wGr`0$=' );
define( 'NONCE_KEY',        'nTuL,*9w[;Y.t]VeMV|!DPRcI=0Syj]OsS(O>6+@:^pp({?bPjkn<jePod3 AN!O' );
define( 'AUTH_SALT',        'Se`G>{6`&@!q`XXHQwis=&{HSMlTUu=hZcNJa0/)oICzi<AwBouC+64.#<oD<}}{' );
define( 'SECURE_AUTH_SALT', 'SC4dK|U/rK*]Qy0 na:f0E]R;(0ql?+#Q6m5FHfjTn;MyPFz^uG^qr!plj=Xq773' );
define( 'LOGGED_IN_SALT',   'epb{BE/u*g|h$u,I)z#.=;5Q)<swt9Uh!Cz7M`Ai#VF:~VCs6 sB4{#xN~R^rD,w' );
define( 'NONCE_SALT',       '+E)EC*E27ygQ@gy|iF-QHjlazX`ost{-a7r6WdD}B,X5;^vMS1D>7Vrr}[hU^yl$' );

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
define( 'WP_DEBUG', true );
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// for better security, this file could be placed one level up
define( 'API_CREDENTIALS', serialize( array(
    'admin' => 'testpassword',
    'another_admin' => 'another_secure_password',
) ) );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

define('WP_REST_API_ENABLED', true);

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
