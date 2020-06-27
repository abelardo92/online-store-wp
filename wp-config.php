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
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

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
define('AUTH_KEY',         'VKNypEstTZWmAiGgEmKrX/1RwYzUXJ2giJRyJdhhLv4RT1saIKmz3NkhsvrMYRC7vsJgpZBcb1Pf90tr9Yv2Bw==');
define('SECURE_AUTH_KEY',  'Dsu3RPObqMbZdz3W2iBrEi8JzIl5lFKzVOy+YLY7ju80+tePdvlL/5WEa25JCXgzConsN+Bf6k9wAK5A/pxAdg==');
define('LOGGED_IN_KEY',    'iUYRhr8/jXL6GnihOBn7A3oVFwxRK4+ZwK9SrnUF0H/fDslXTAar1ZsxE8Z3o7Tao9aRKcwuLjB6twlL2s3d2g==');
define('NONCE_KEY',        'hSgKnwokDj/h41mccI13OMntlk9KRAl/VjzlrdnrQoLN9X/3OmKbmLpNcMD1oQUNXie4LcSQEWk4UU/wXfWkwg==');
define('AUTH_SALT',        'AJqVTfmmPiex5NJPm5NBzon5SOmXeumeSPV8ffBNuPopBAe/j0qXqKZ4xaKuWAc7xy67lhDe01vDrPUCrWbWFg==');
define('SECURE_AUTH_SALT', 'CSSkrYapClDaqeCf96XdY1vrb6uQxaQOEjCmDUMDoa9WS2vS16OSC69iBkaPcyl4s80B0llgDdjAzxKQ+J19qA==');
define('LOGGED_IN_SALT',   'P52ulPsOxP2KH6tHiwtmpZJFoPnWTO4MeSBfwPKHjwPhy6OZktdtb0QNB+NbkrDTviohu2SQyJuK1lLexhTabQ==');
define('NONCE_SALT',       '3SAMg9CAoJbCx0Gkb87HKXazM0abZp2Znu8LkCeIcvkRtZ84r76oNPIYWZzPWIRae0ZBn13MLLUguOUWjSCIGQ==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
