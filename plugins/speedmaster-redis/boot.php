<?php
// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
  die( 'Invalid request.' );
}

// Initiate a timer that can be used to calculate page rendering time.
define( 'SPEEDMASTER_BUFFER_TIMESTAMP_START', microtime(true)); 

// Load vendor libraries
require_once('lib/credis/Client.php');
require_once('lib/credis/Cluster.php');

// Load project classes.
require_once('src/classes/CacheStorage.php');

// Create a global cache storage object for gets/sets.
global $smcache;
$smcache = new CacheStorage('redis', array('REDIS_HOST' => 'redis'));

if ($html = $smcache->html()) {
  echo $html;
  die();
}