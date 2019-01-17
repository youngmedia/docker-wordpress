<?php
add_filter('speedmaster__addons', function($addons) {

  $addons[] = array(
    'id' => 'minify-html',
    'title' => __('Minify HTML', 'speedmaster'),
    'description' => __('Minifies HTML and decreases the file size of the rendered HTML code.', 'speedmaster'),
    'file_path' => dirname(__FILE__) . '/html.php'
  );

  $addons[] = array(
    'id' => 'footer-scripts',
    'title' => __('Footer scripts', 'speedmaster'),
    'description' => __('Move all inline <script>-tags and linked javascripts to footer.', 'speedmaster'),
    'file_path' => dirname(__FILE__) . '/footer-scripts.php'
  );

  return $addons;
});