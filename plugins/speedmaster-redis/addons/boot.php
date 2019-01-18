<?php
namespace Speedmaster;

require_once('minify/index.php');
require_once('combine-css-js/index.php');
require_once('footer-scripts/index.php');
require_once('cdn/index.php');
require_once('disable-emoji-and-embed/index.php');

define('SPEEDMASTER__MINIFY_HTML', true);
define('SPEEDMASTER__COMBINE_CSS', true);
define('SPEEDMASTER__COMBINE_JS', true);

add_action('init', function() {
  global $smaddons;
  $smaddons = apply_filters('speedmaster__addons', array());

  foreach ($smaddons as $index => $addon) {
    foreach($addon['vars'] as $constant) {
      if (!defined($constant) && getenv($constant)) {
        $value = getenv($constant);
        define($constant, $value);
      }        
    }

    $constant = $addon['vars'][0];
    if (defined($constant) && constant($constant) == 'true') {
      require_once($addon['file_path']);
      $smaddons[$index]['activated'] = true;
    } else {
      $smaddons[$index]['activated'] = false;
    }
  }
});