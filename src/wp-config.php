<?php
define( 'WP_CACHE', true);

/* MySQL settings */
define( 'DB_NAME', getenv('WORDPRESS_DB_NAME'));
define( 'DB_USER', getenv('WORDPRESS_DB_USER'));
define( 'DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD'));
define( 'DB_HOST', getenv('WORDPRESS_DB_HOST'));
define( 'DB_CHARSET',  'utf8' );

$table_prefix  = getenv('WORDPRESS_DB_PREFIX') ? getenv('WORDPRESS_DB_PREFIX') : 'wp_';

// Turns WordPress debugging on
define('WP_DEBUG', getenv('WORDPRESS_DEBUG'));

// Prevent SSL proxy redirect loop.
if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false)
  $_SERVER['HTTPS']='on';

// Disable the Plugin and Theme Editor
if ( ! defined('DISALLOW_FILE_EDIT') )
  define( 'DISALLOW_FILE_EDIT', true );

// Disable Plugin and Theme Update and Installation
if ( ! defined('DISALLOW_FILE_MODS') )
  define( 'DISALLOW_FILE_MODS', true );

// Disable all automatic updates:
if ( ! defined('AUTOMATIC_UPDATER_DISABLED') )
 define( 'AUTOMATIC_UPDATER_DISABLED', true );

// Enable core updates for minor releases (default):
if ( ! defined('WP_AUTO_UPDATE_CORE') )
 define( 'WP_AUTO_UPDATE_CORE', false);

// Cleanup Image Edits
if ( ! defined('IMAGE_EDIT_OVERWRITE') ) 
  define( 'IMAGE_EDIT_OVERWRITE', true );

/* Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');

/* Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
