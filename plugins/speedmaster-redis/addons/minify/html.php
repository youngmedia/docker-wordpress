<?php
// use MatthiasMullie\Minify;

// require_once dirname(__FILE__) . '/lib/minify/src/Minify.php';
// require_once dirname(__FILE__) . '/lib/minify/src/CSS.php';
// require_once dirname(__FILE__) . '/lib/minify/src/JS.php';
// require_once dirname(__FILE__) . '/lib/minify/src/Exception.php';
// require_once dirname(__FILE__) . '/lib/minify/src/Exceptions/BasicException.php';
// require_once dirname(__FILE__) . '/lib/minify/src/Exceptions/FileImportException.php';
// require_once dirname(__FILE__) . '/lib/minify/src/Exceptions/IOException.php';

add_action('speedmaster__buffer', function($html) {
  require_once dirname(__FILE__) . '/lib/minify-html.php';
  return minify_html($html);
});

