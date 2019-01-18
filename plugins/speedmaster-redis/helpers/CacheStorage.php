<?php
namespace Speedmaster;

class CacheStorage {
  private $engine = null;
  private $cache_key_prefix = 'speedmaster/cache/';

  public function __construct() {
    $this->connect();
  }

  public function connect($args = array()) {

    if (!defined('SPEEDMASTER__REDIS_MASTER_HOST') && getenv('SPEEDMASTER__REDIS_MASTER_HOST'))
      define('SPEEDMASTER__REDIS_MASTER_HOST', getenv('SPEEDMASTER__REDIS_MASTER_HOST'));

    if (!defined('SPEEDMASTER__REDIS_MASTER_PORT') && getenv('SPEEDMASTER__REDIS_MASTER_PORT'))
      define('SPEEDMASTER__REDIS_MASTER_PORT', getenv('SPEEDMASTER__REDIS_MASTER_PORT'));

    if (!defined('SPEEDMASTER__REDIS_SLAVE_HOST') && getenv('SPEEDMASTER__REDIS_SLAVE_HOST'))
      define('SPEEDMASTER__REDIS_SLAVE_HOST', getenv('SPEEDMASTER__REDIS_SLAVE_HOST'));

    if (!defined('SPEEDMASTER__REDIS_SLAVE_PORT') && getenv('SPEEDMASTER__REDIS_SLAVE_PORT'))
      define('SPEEDMASTER__REDIS_SLAVE_PORT', getenv('SPEEDMASTER__REDIS_SLAVE_PORT'));

    if (!defined('SPEEDMASTER__REDIS_MASTER_PORT'))
      define('SPEEDMASTER__REDIS_MASTER_PORT', 6379);

    if (!defined('SPEEDMASTER__REDIS_MASTER_HOST'))
      define('SPEEDMASTER__REDIS_MASTER_HOST', '127.0.0.1');

    if (!defined('SPEEDMASTER__REDIS_MASTER_PORT'))
      define('SPEEDMASTER__REDIS_MASTER_PORT', 6379);

    if (!defined('SPEEDMASTER__REDIS_SLAVE_HOST') && defined('SPEEDMASTER__REDIS_MASTER_HOST'))
      define('SPEEDMASTER__REDIS_SLAVE_HOST', SPEEDMASTER__REDIS_MASTER_HOST);
    
    if (!defined('SPEEDMASTER__REDIS_SLAVE_PORT') && defined('SPEEDMASTER__REDIS_MASTER_PORT'))
      define('SPEEDMASTER__REDIS_SLAVE_PORT', SPEEDMASTER__REDIS_MASTER_PORT);

    $args = array(
      'to' => 'redis',
      'connections' => array(
        array( 
          'host' => SPEEDMASTER__REDIS_MASTER_HOST, 
          'port' => SPEEDMASTER__REDIS_MASTER_PORT, 
          'alias' => 'master', 
          'master' => true, 
          'write_only' => true 
        ),
        array( 
          'host' => SPEEDMASTER__REDIS_SLAVE_HOST, 
          'port' => SPEEDMASTER__REDIS_SLAVE_PORT, 
          'alias' => 'slave'
        )
      )
    );

    $this->engine = new \Credis_Cluster($args['connections']);

    try {
      $this->keys();
      if (!defined('SPEEDMASTER__REDIS_CONNECTION')) define('SPEEDMASTER__REDIS_CONNECTION', true);
    } catch (\Exception $e) {
      if (!defined('SPEEDMASTER__REDIS_CONNECTION')) define('SPEEDMASTER__REDIS_CONNECTION', false);
    }

    
  }

  public function set($key, $data = array()) {
    $key = $this->cache_key_prefix.$key;
    return $this->engine->set($key, json_encode($data));
  }

  public function get($key) {
    $key = str_replace($this->cache_key_prefix, '', $key);
    $key = $this->cache_key_prefix.$key;
    return json_decode($this->engine->get($key));
  }

  public function keys() {
    $pattern = $this->cache_key_prefix.'*';
    return $this->engine->keys($pattern);
  }

  public function flushdb() {
    return $this->engine->flushdb();
  }

}