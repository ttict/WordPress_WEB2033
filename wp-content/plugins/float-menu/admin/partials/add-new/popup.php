<?php
/**
 * Popup Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( !defined( 'ABSPATH' ) ) {
  exit;
}
include_once('settings/popup.php');

?>

<div class="container">
  <div class="element">
    <?php _e( 'Popup Title', $this->text_domain ); ?><?php echo self::tooltip( $popuptitle_help ); ?><br/>
    <?php echo self::option( $popuptitle ); ?>
  </div>
</div>

<div class="container">
  <div class="element">
    <?php _e( 'Popup Content', $this->text_domain ); ?><?php echo self::tooltip( $popupcontent_help ); ?><br/>
    <?php echo self::option( $popupcontent ); ?>
  </div>
</div>