<?php
// Created by Speedmaster
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

define( 'SPEEDMASTER_ACTIVATED', true );

if (file_exists('/var/www/html/wp-content/plugins/speedmaster/boot.php')) {
  require_once( '/var/www/html/wp-content/plugins/speedmaster/boot.php');
}