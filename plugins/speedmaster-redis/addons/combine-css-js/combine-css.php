<?php
namespace Speedmaster;

add_action('wp_enqueue_scripts', function() {
  if (!CurrentRequest::isCachable()) return;

  global $wp_styles;
  global $smcache;

  $combined_body = "";

  foreach( $wp_styles->queue as $handle ) {
    $url = $wp_styles->registered[$handle]->src;

    // Check if url is relative but not //
    if ($url[0] == "/" && $url[1] != "/") {
      $url = site_url() . $url;
    }

    // Don't combine external css files.
    if (strpos($url, site_url()) === false)
      continue;

    // Replace site_url with localhost for faster downloading.
    $url = str_replace(site_url(), 'http://127.0.0.1', $url);

    $response = wp_remote_get($url);

    if ( !is_wp_error( $response ) ) {
      $body = $response['body'];
      $combined_body .= $body . "\n";
      wp_dequeue_style($handle);
    }
    
  }

  $combined_body = apply_filters('speedmaster__combined-css', $combined_body);

  $combined_hash = substr(md5($combined_body), 0, 6);
  $css_url = "/assets/css/{$combined_hash}.css";

  $identifier = CurrentRequest::identifier($css_url);

  $data = array(
    'identifier' => $identifier,
    'request_uri' => $css_url,
    'timestamp' => time(true),
    'response_code' => 200,
    'css' => base64_encode($combined_body)
  );

  $smcache->set($identifier, $data);

  wp_enqueue_style('speedmaster-css', $css_url);

}, PHP_INT_MAX );