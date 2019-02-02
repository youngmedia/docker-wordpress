<?php
namespace Speedmaster;

function siteurl_to_local($url) {
  return str_replace(site_url(), 'http://127.0.0.1', $url);
}

add_action('wp_enqueue_scripts', function() {
  if (!CurrentRequest::isCachable()) return;

  global $wp_scripts;
  global $smcache;

  $combined_body = "";

  $response = wp_remote_get(siteurl_to_local(includes_url( '/js/jquery/jquery.js' )));
  if ( !is_wp_error( $response ) ) {
    $body = $response['body'];
    $combined_body .= $body;
  }

  $response = wp_remote_get(siteurl_to_local(includes_url( '/js/jquery/jquery-migrate.min.js' )));
  if ( !is_wp_error( $response ) ) {
    $body = $response['body'];
    $combined_body .= $body;
  }

  foreach( $wp_scripts->queue as $handle ) {

    if (strpos($handle, 'jquery')) {
      continue;
    }

    $url = $wp_scripts->registered[$handle]->src;

    // Check if url is relative but not //
    if ($url[0] == "/" && $url[1] != "/") {
      $url = site_url() . $url;
    }

    // Don't combine external js files.
    if (strpos($url, site_url()) === false)
      continue;

    // Replace site_url with localhost for faster downloading.
    $url = siteurl_to_local($url);

    $response = wp_remote_get($url);

    if ( !is_wp_error( $response ) ) {
      $body = $response['body'];
  
      $combined_body .= $body . "\n\n";      

      wp_dequeue_script($handle);
    }
    
  }

  $combined_body = apply_filters('speedmaster__combined-js', $combined_body);

  $combined_hash = substr(md5($combined_body), 0, 6);
  $js_url = "/assets/js/{$combined_hash}.js";

  $identifier = CurrentRequest::identifier($js_url);

  $data = array(
    'identifier' => $identifier,
    'request_uri' => $js_url,
    'timestamp' => time(true),
    'js' => base64_encode($combined_body)
  );

  $smcache->set($identifier, $data);

  wp_enqueue_script('speedmaster-js', $js_url);

}, PHP_INT_MAX );