<?php
add_filter('speedmaster__addons', function($addons) {

  $addons[] = array(
    'id' => 'minify-html',
    'title' => __('Minify HTML', 'speedmaster'),
    'description' => __('Minifies HTML and decreases the file size of the rendered HTML code.', 'speedmaster'),
    'file_path' => dirname(__FILE__) . '/html.php',
    'vars' => array('SPEEDMASTER__MINIFY_HTML')
  );
  
  return $addons;
});