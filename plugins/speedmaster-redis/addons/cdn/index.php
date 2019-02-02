<?php
add_filter('speedmaster__addons', function($addons) {

  $addons[] = array(
    'id' => 'cdn-replace',
    'title' => __('CDN uploads', 'speedmaster'),
    'description' => __('Replaces all /wp-content/ links with a CDN url', 'speedmaster'),
    'file_path' => dirname(__FILE__) . '/replace-urls.php',
    'vars' => array('SPEEDMASTER__CDN', 'SPEEDMASTER__CDN_ENDPOINT')
  );

  return $addons;
});