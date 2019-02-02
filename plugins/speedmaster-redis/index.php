<?php
/*
Plugin Name: Speedmaster 
Description: HTML in-memory caching with Redis.
Author: Speedmaster.io
Author URI: https://speedmaster.io
Version: 1.3.3.7
Text Domain: speedmaster
*/

namespace Speedmaster;

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Invalid request.' );
}

require_once('src/dashboard/admin-menu.php');
require_once('src/dashboard/toolbar.php');

if (!defined('SM__TIMESTAMP_BOOT')) {
  add_action( 'admin_notices', function() {
    $class = 'notice notice-error';
    $message = __( 'error__advanced-cache_not_loaded', 'speedmaster' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), "<strong>Speedmaster:</strong> " . $message ); 
  });
} else {

  add_action('after_setup_theme', function() { ob_start(); });

  // Include all addon initializers.
  require_once('addons/boot.php');

  add_action('shutdown', function() {
    global $wp_query;
    global $smcache;

    // Capture all buffered output and store it in a variable.
    $buffer = ob_get_clean();

    // Apply any filters to the final HTML output
    $filtered_buffer = $buffer;

    if(!is_admin()) {
      $filtered_buffer = apply_filters('speedmaster__buffer', $buffer);
    }

    // Save current page to cache.
    if (true === CurrentRequest::isCachable()) {
      $data = CurrentRequest::to_a($filtered_buffer);
      if ($data['response_code'] == 200) {
        $smcache->set(CurrentRequest::identifier(), $data);        
      }
    }

    echo $filtered_buffer;
  }, 0);

}
