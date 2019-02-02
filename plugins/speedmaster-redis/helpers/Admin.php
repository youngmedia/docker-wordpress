<?php
namespace Speedmaster;

class Admin {
  static public function notice($message = '') {
    add_action( 'admin_notices', function() {
      $class = 'notice notice-success';

      printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), "<strong>Speedmaster:</strong> " . $message ); 
    });
  }
}