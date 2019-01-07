<?php
class CacheStorage {
  private $engine = null;
  private $current_page_id = null;
  private $storage_key = null;
  private $cache_prefix = 'smcache_';

  public function __construct($engine = 'redis', $args = array()) {
    $this->storage_key = $this->currentPageIdentifier();

    if ($engine == 'redis') {
      $this->prepareRedis($args);
    } 
  }

  private function prepareRedis($args = array()) {
    if (isset($args['REDIS_HOST'])) {
      $REDIS_HOST = $args['REDIS_HOST'];
    } else {
      $REDIS_HOST = '127.0.0.1';
    }      

    if (isset($args['REDIS_PORT'])) {
      $REDIS_PORT = $args['REDIS_PORT'];
    } else {
      $REDIS_PORT = 6379;
    }      

    $this->engine = new Credis_Cluster(array(
      array('host' => $REDIS_HOST, 'port' => $REDIS_PORT, 'alias'=>'master', 'master'=>true, 'write_only'=>true),
      // array('host' => '127.0.0.1', 'port' => 6380, 'alias'=>'slave')
    ));
  }

  private function currentPageIdentifier() {
    $string = $_SERVER['REQUEST_URI'];

    $string = str_replace('/', '_', $string);
    $string = str_replace('?', '_', $string);
    $string = str_replace('=', '_', $string);
    $string = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $string);
    $string = mb_ereg_replace("([\.]{2,})", '', $string);
    $string = trim($string, '_');
    
    return $this->cache_prefix . $string;
  }

  public function html() {
    try {
      return base64_decode($this->engine->get($this->storage_key));
    } catch (Exception $e) { $this->logAnddie($e); }

    return null;
  }

  public function store($html = "") {
    try {
      $this->engine->set($this->storage_key, base64_encode($html));
      return true;
      
    } catch (Exception $e) { $this->logAnddie($e); }

    return false;
  }

  public function getAllCacheKeys() {
    return $this->engine->get('KEYS *');
  }

  private function logAndDie($error) {
    return;
    die($error->getMessage());
  }
}