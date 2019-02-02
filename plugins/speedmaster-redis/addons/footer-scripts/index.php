<?php
add_filter('speedmaster__addons', function($addons) {

  $addons[] = array(
    'id' => 'footer-scripts',
    'title' => __('Footer scripts', 'speedmaster'),
    'description' => __('Move all inline <script>-tags and linked javascripts to footer.', 'speedmaster'),
    'file_path' => dirname(__FILE__) . '/footer-scripts.php',
    'vars' => array('SPEEDMASTER__FOOTER_SCRIPTS')
  );

  return $addons;
});