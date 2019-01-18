<?php
add_filter('speedmaster__addons', function($addons) {

  $addons[] = array(
    'id' => 'combine-css',
    'title' => __('Combine CSS', 'speedmaster'),
    'description' => __('Combine css/stylesheets to a single file.', 'speedmaster'),
    'file_path' => dirname(__FILE__) . '/combine-css.php',
    'vars' => array('SPEEDMASTER__COMBINE_CSS')
  );

  $addons[] = array(
    'id' => 'combine-js',
    'title' => __('Combine JS', 'speedmaster'),
    'description' => __('Combine javacripts to a single file.', 'speedmaster'),
    'file_path' => dirname(__FILE__) . '/combine-js.php',
    'vars' => array('SPEEDMASTER__COMBINE_JS')
  );

  return $addons;
});