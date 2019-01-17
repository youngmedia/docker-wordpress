<?php
namespace Speedmaster;

define( 'SM__TIMESTAMP_BOOT', microtime(true));

// Load vendor libraries
require_once('lib/credis/Client.php');
require_once('lib/credis/Cluster.php');

// Load Speedmaster helpers
require_once('helpers/Admin.php');
require_once('helpers/CacheStorage.php');
require_once('helpers/CurrentPage.php');

global $smcache;

$smcache = new CacheStorage();
$smcache->connect();

if (true == CurrentPage::hasCache()) {
  echo CurrentPage::getCachedHTML();
  die();
}