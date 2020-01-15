<?php 
	/**
		* Deactivator function
		*
		* @package     Wow_Plugin
		* @subpackage  
		* @copyright   Copyright (c) 2018, Dmytro Lobov
		* @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
		* @since       1.0
	*/
	
	if ( ! defined( 'ABSPATH' ) ) exit;

if ( is_dir( $basedir ) ) {

  $is_empty = count( glob( $basedir . '*' ) ) ? true : false;
  if ( $is_empty === true ) {
    $handle = opendir( $basedir );

    while ( false !== ($file = readdir( $handle )) ) {

      if ( $file != "." && $file != ".." ) {
        wp_delete_file( $basedir . $file );
      }

    }
    closedir( $dir_handle );
  }
  rmdir( $basedir );
}