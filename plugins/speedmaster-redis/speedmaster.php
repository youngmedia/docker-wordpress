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

  $buffer = '';

  // Get all output buffer and store it in a variable.
  $buffer = ob_get_clean();

  // Calculate how long time it takes to generate a page.
  $time_before = microtime(true);

  // Apply any filters to the final output
  $filtered_buffer = apply_filters('speedmaster__html_buffer', $buffer);

  // Calculate how long time it to to render page.
  $time_after = microtime(true);
  
  $smcache->store($filtered_buffer);
  echo $filtered_buffer;
}

add_action('shutdown', 'speedmaster_end_buffer', 0);