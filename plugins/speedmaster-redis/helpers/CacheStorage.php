<?php
namespace Speedmaster;

class CacheStorage {
  private $engine = null;
  private $cache_key_prefix = 'speedmaster/cache/';

  public function __construct() {
    $this->connect();
  }

  public function connect($args = array()) {
    $args = array(
      'to' => 'redis',
      'connections' => array(
        array( 'host' => 'redis', 'port' => '6379', 'alias' => 'master', 'master' => true, 'write_only' => true ),
        array( 'host' => 'redis', 'port' => '6379', 'alias' => 'slave'  )
      )
    );

    $this->engine = new \Credis_Cluster($args['connections']);
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