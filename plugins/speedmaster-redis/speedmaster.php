<?php
/*
Plugin Name: Speedmaster Redis
Description: Redis cache full html pages.
Author: Speedmaster.io
Author URI: https://speedmaster.io
Version: 0.1.0
Text Domain: speedmaster
*/

if ( ! defined( 'ABSPATH' ) ) {
  die( 'Invalid request.' );
}

/**
 * Output Buffering
 *
 * Buffers the entire WP output, capturing the final HTML for manipulation.
 * The `speedmaster__html_buffer`-filter can be used to manipulate all html content at any time:
 *
*/
ob_start();
function speedmaster_end_buffer() {
  global $smcache;
  global $wp_query;

  $buffer = '';

  // Get all output buffer and store it in a variable.
  $buffer = ob_get_clean();

  // Calculate how long time it takes to generate a page.
  $time_before = microtime(true);

  // Apply any filters to the final output
  $filtered_buffer = apply_filters('speedmaster__html_buffer', $buffer);

  // Calculate how long time it to to render page.
  $time_after = microtime(true);
  
  if ( true === is_cachable_page() ) {
    // Save buffer to file if cache is enabled.
    $saved_time = round($time_after - SPEEDMASTER_BUFFER_TIMESTAMP_START,3);    
    $smcache->store($filtered_buffer . "\n" . '<!-- Speedmaster just saved you '.$saved_time.' second(s). -->');
  }
  
  echo $filtered_buffer;
}

function is_cachable_page() {
  if (function_exists('is_user_logged_in') and is_user_logged_in()) return false;
  if (false == (is_page() || is_front_page() || is_single() || is_archive())) return false;

  if (count($_COOKIE)) {
    foreach ($_COOKIE as $key => $val) {
      if (preg_match("/wordpress_logged_in/i", $key)) {
       return false;
      }
    }
  }

  return true;
}

add_action('shutdown', 'speedmaster_end_buffer', 0);