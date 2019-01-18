<?php
function speedmaster_delete_cache_ajax() {
  global $smcache;
  do_action('speedmaster__before_flush_cache');
  $smcache->flushdb();
  do_action('speedmaster__after_flush_cache');
  echo "ok";
  wp_die();
}

function speedmaster_delete_cache_action_js() { ?>
  <script type="text/javascript" >
   jQuery("li#wp-admin-bar-speedmaster-delete-cache .ab-item").on( "click", function() {
      var data = { 'action': 'speedmaster_delete_cache'};
      jQuery.post("<?php echo admin_url( 'admin-ajax.php' ); ?>", data, function(response) {
        alert(response);
        return;
         if (response == "ok") {
          alert('All cache files were deleted!');
         } else {
          alert('Could not erase cache. Unknown error. Please check your web servers error log for clues.');
         }
      });
    });
  </script> <?php
}
add_action('init', function() {
  add_action( 'wp_ajax_speedmaster_delete_cache', 'speedmaster_delete_cache_ajax' );
  add_action( 'admin_footer', 'speedmaster_delete_cache_action_js' );
  add_action( 'wp_footer', 'speedmaster_delete_cache_action_js', PHP_INT_MAX );
});
function speedmaster_admin_toolbar($admin_bar){
    $admin_bar->add_menu( array(
      'id'    => 'speedmaster',
      'title' => '<span class="ab-icon dashicons dashicons-smiley"></span> Speedmaster',
      'href'  => admin_url('admin.php?page=speedmaster')
    ));
    $admin_bar->add_menu( array(
      'id'    => 'speedmaster-delete-cache',
      'parent' => 'speedmaster',
      'title' => 'Purge Redis Cache',
      'href'  => '#'
    ));
}
add_action('admin_bar_menu', 'speedmaster_admin_toolbar', 90);