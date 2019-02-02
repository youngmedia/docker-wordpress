<?php
namespace Speedmaster;

add_action( 'admin_menu', function () {
  add_options_page( 
    'Speedmaster', 
    'Speedmaster', 
    'manage_options', 
    'speedmaster', 
    'Speedmaster\speedmaster_settings_page_view' ); 
});

function speedmaster_settings_page_view() {
  if ( !current_user_can( 'manage_options' ) )  {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }

  global $smcache;

  if (isset($_GET['do']) && $_GET['do'] == 'flushdb') {
    $smcache->flushdb();
    Admin::notice('Cache was successfully flushed');
  }

  $keys = $smcache->keys();
  $cached_pages = [];
  foreach($keys as $key) {
    $cached_pages[] = $smcache->get($key);
  }

  usort($cached_pages, function($a,$b){
    return strlen($a->request_uri)-strlen($b->request_uri);
  });

  include('admin-page.php');
}