<?php
// Load Speedmaster helpers
require_once('helpers/Admin.php');
require_once('helpers/CacheStorage.php');
require_once('helpers/CurrentRequest.php');

global $smcache;

$smcache = new CacheStorage();
$smcache->connect();

if (true == CurrentRequest::hasCache()) {

  $request_type = CurrentRequest::requestType();

  if ('html' == $request_type) {
    echo CurrentRequest::getCachedHTML();
  } else if ('css' == $request_type) {
    echo CurrentRequest::getCachedCSS();
  } else if ('js' == $request_type) {
    echo CurrentRequest::getCachedJS();
  }
 
  die();
}