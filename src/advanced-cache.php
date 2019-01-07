<?php
// Created by Speedmaster
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

define( 'SPEEDMASTER__AC_FILE_CHECK', 1 );

if (file_exists('/var/www/html/wp-content/plugins/speedmaster-redis/boot.php')) {
  require_once( '/var/www/html/wp-content/plugins/speedmaster-redis/boot.php');
}