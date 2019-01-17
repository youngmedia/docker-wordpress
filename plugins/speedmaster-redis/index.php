<?php
/*
Plugin Name: Speedmaster 
Description: HTML in-memory caching with Redis.
Author: Speedmaster.io
Author URI: https://speedmaster.io
Version: 0.2.0
Text Domain: speedmaster
*/

namespace Speedmaster;

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Invalid request.' );
}

if (!defined('SM__TIMESTAMP_BOOT')) {
  add_action( 'admin_notices', function() {
    $class = 'notice notice-error';
    $message = __( 'error__advanced-cache_not_loaded', 'speedmaster' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), "<strong>Speedmaster:</strong> " . $message ); 
  });
} else {

  ob_start();

  // Include all addon initializers.
  require_once('addons/minify/index.php');

  add_filter('speedmaster__addons', function($addons) {
    $o = array();

    foreach($addons as $addon) {
      $addon['activated'] = true;
      $o[] = $addon;
    }

    return $o;
  }, 999999);

  add_action('shutdown', function() {
    global $wp_query;
    global $smcache;

    // Capture all buffered output and store it in a variable.
    $buffer = ob_get_clean();

    // Apply any filters to the final HTML output
    $filtered_buffer = $buffer;

    if(!is_admin()) {

      $addons = apply_filters('speedmaster__addons', array());
      foreach ($addons as $addon) {
        if ($addon['activated'] == true) require_once($addon['file_path']);
      }

      $filtered_buffer = apply_filters('speedmaster__buffer', $buffer);
    }

    // Save current page to cache.
    if (true === CurrentPage::isCachable()) {
      $data = CurrentPage::to_a($filtered_buffer);
      $smcache->set(CurrentPage::identifier(), $data);
    }

    echo $filtered_buffer;
  }, 0);

  require_once('src/dashboard/admin-menu.php');
}
