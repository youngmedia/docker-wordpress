<?php
namespace Speedmaster;

class CurrentRequest {

  // Generate an unique identifer for this page request.
  static public function identifier($string = null) {
    if (!$string) $string = $_SERVER['REQUEST_URI'];

    $string = str_replace('/', '_', $string);
    $string = str_replace('?', '_', $string);
    $string = str_replace('=', '_', $string);
    $string = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $string);
    $string = mb_ereg_replace("([\.]{2,})", '', $string);
    $string = trim($string);

    return $string;
  }

  // Check if this page are allowed to get cached.
  static public function isCachable() {
    if (SPEEDMASTER__REDIS_CONNECTION === false) return false;
    if (function_exists('is_user_logged_in') and is_user_logged_in()) return false;
    if ('POST' == $_SERVER['REQUEST_METHOD']) return false;
    if (preg_match("/wp-admin/i", $_SERVER['REQUEST_URI'])) return false;
    if (preg_match("/\.txt/i", $_SERVER['REQUEST_URI'])) return false;
    if (preg_match("/\.xml/i", $_SERVER['REQUEST_URI'])) return false;

    if (count($_COOKIE)) {
      foreach ($_COOKIE as $key => $val) {
        if (preg_match("/wordpress_logged_in/i", $key)) return false;
      }
    }

    return true;
  }

  // Check if current page has cache stored
  static public function hasCache() {
    global $smcache;
    if (false == self::isCachable()) return false;
    return $smcache->get(self::identifier());
  }

  static public function getCachedData() {
    global $smcache;
    return $smcache->get(self::identifier());
  }

  static public function getCachedHTML() {
    $data = self::getCachedData();
    return base64_decode($data->html);
  }

  static public function getCachedCSS() {
    header("Content-type: text/css; charset: UTF-8");
    $data = self::getCachedData();
    return base64_decode($data->css);
  }

  static public function getCachedJS() {
    header('Content-Type: application/javascript');
    $data = self::getCachedData();
    return base64_decode($data->js);
  }

  static public function requestType() {
    $uri = $_SERVER['REQUEST_URI'];

    if ('.css' == substr($uri, -4, 4))
      return 'css';

    if ('.js' == substr($uri, -3, 3))
      return 'js';

    return 'html';
  }

  // Serialize page data into a storable string
  static public function to_a($html = null) {
    return array(
      'identifier' => self::identifier(),
      'request_uri' => $_SERVER['REQUEST_URI'],
      'timestamp' => time(true),
      'response_code' => http_response_code(),
      'html' => ($html ? base64_encode($html) : null)
    );
  }

}