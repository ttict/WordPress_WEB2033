<?php
/**
 * Main Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( !defined( 'ABSPATH' ) ) {
  exit;
}
include_once('settings/main.php');

?>
<fieldset class="itembox">
  <legend>
    <?php _e( 'Main', $this->text_domain ); ?>
  </legend>

  <div class="container">
    <div class="element">
      <?php _e( 'Position', $this->text_domain ); ?><?php echo self::tooltip( $menu_help ); ?><br/>
      <?php echo self::option( $menu ); ?>

    </div>
    <div class="element">
      <?php _e( 'Top offset (px)', $this->text_domain ); ?>
      <?php echo self::tooltip( $top_offset_help ); ?>
      <?php echo self::pro(); ?>
      <br/>
      <?php echo self::option( $top_offset ); ?>

    </div>
    <div class="element">
      <?php _e( 'Side offset (px)', $this->text_domain ); ?>
      <?php echo self::tooltip( $side_offset_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $side_offset ); ?>
    </div>
  </div>

  <div class="container">
    <div class="element">
      <?php _e( 'Align', $this->text_domain ); ?><?php echo self::tooltip( $align_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $align ); ?>
    </div>
    <div class="element">
      <?php _e( 'Shape', $this->text_domain ); ?><?php echo self::tooltip( $shape_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $shape ); ?>
    </div>
    <div class="element">
      <?php _e( 'Side Space', $this->text_domain ); ?><?php echo self::tooltip( $sideSpace_help ); ?><br/>
      <?php echo self::option( $sideSpace ); ?>
    </div>
  </div>

  <div class="container">
    <div class="element">
      <?php _e( 'Button Space', $this->text_domain ); ?><?php echo self::tooltip( $buttonSpace_help ); ?><br/>
      <?php echo self::option( $buttonSpace ); ?>
    </div>
    <div class="element">
      <?php _e( 'Label On', $this->text_domain ); ?><?php echo self::tooltip( $labelsOn_help ); ?><br/>
      <?php echo self::option( $labelsOn ); ?>
    </div>
    <div class="element">
      <?php _e( 'Label Space', $this->text_domain ); ?><?php echo self::tooltip( $labelSpace_help ); ?><br/>
      <?php echo self::option( $labelSpace ); ?>
    </div>
  </div>

  <div class="container">
    <div class="element">
      <?php _e( 'Label Connected', $this->text_domain ); ?><?php echo self::tooltip( $labelConnected_help ); ?><br/>
      <?php echo self::option( $labelConnected ); ?>
    </div>
    <div class="element">
      <?php _e( 'Label Effect', $this->text_domain ); ?><?php echo self::tooltip( $labelEffect_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $labelEffect ); ?>
    </div>
    <div class="element">
      <?php _e( 'Label Speed (ms)', $this->text_domain ); ?><?php echo self::tooltip( $labelSpeed_help ); ?><br/>
      <?php echo self::option( $labelSpeed ); ?>
    </div>
  </div>

  <div class="container">
    <div class="element">
      <?php _e( 'Icon size (px)', $this->text_domain ); ?><?php echo self::tooltip( $iconSize_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $iconSize ); ?>
    </div>
    <div class="element">
      <?php _e( 'Icon size for mobile (px)', $this->text_domain ); ?><?php echo self::tooltip( $mobiliconSize_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $mobiliconSize ); ?>
    </div>
    <div class="element">
      <?php _e( 'Mobile Screen (px)', $this->text_domain ); ?><?php echo self::tooltip( $mobilieScreen_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $mobilieScreen ); ?>
    </div>
  </div>

  <div class="container">
    <div class="element">
      <?php _e( 'Label size (px)', $this->text_domain ); ?><?php echo self::tooltip( $labelSize_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $labelSize ); ?>
    </div>
    <div class="element">
      <?php _e( 'Label size for mobile (px)', $this->text_domain ); ?><?php echo self::tooltip( $mobillabelSize_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $mobillabelSize ); ?>
    </div>
    <div class="element">
      <?php _e( 'Show After Position', $this->text_domain ); ?><?php echo self::tooltip( $showAfterPosition_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $showAfterPosition ); ?>
    </div>
  </div>


</fieldset>


<fieldset class="itembox">
  <legend>
    <?php _e( 'Sub Menu ', $this->text_domain ); ?>
  </legend>

  <div class="container">
    <div class="element">
      <?php _e( 'Sub Position', $this->text_domain ); ?><?php echo self::tooltip( $subPosition_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $subPosition ); ?>
    </div>
    <div class="element">
      <?php _e( 'Sub Space', $this->text_domain ); ?><?php echo self::tooltip( $subSpace_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $subSpace ); ?>
    </div>
    <div class="element">
      <?php _e( 'Sub Effect', $this->text_domain ); ?><?php echo self::tooltip( $subEffect_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $subEffect ); ?>
    </div>
  </div>

  <div class="container">
    <div class="element">
      <?php _e( 'Sub Speed (ms)', $this->text_domain ); ?><?php echo self::tooltip( $subSpeed_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $subSpeed ); ?>
    </div>
    <div class="element">
      <?php _e( 'Sub Open', $this->text_domain ); ?><?php echo self::tooltip( $subOpen_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $subOpen ); ?>
    </div>
    <div class="element">
    </div>
  </div>

</fieldset>

<fieldset class="itembox">
  <legend>
    <?php _e( 'Popup', $this->text_domain ); ?>
  </legend>

  <div class="container">
    <div class="element">
      <?php _e( 'Horizontal position', $this->text_domain ); ?>
      <?php echo self::tooltip( $windowhorizontalPosition_help ); ?><?php echo self::pro(); ?><br/>
      <?php echo self::option( $windowhorizontalPosition ); ?>
    </div>
    <div class="element">
      <?php _e( 'Vertical position', $this->text_domain ); ?>
      <?php echo self::tooltip( $windowverticalPosition_help ); ?><?php echo self::pro(); ?><br/>
      <?php echo self::option( $windowverticalPosition ); ?>
    </div>
    <div class="element">
      <?php _e( 'Corners', $this->text_domain ); ?><?php echo self::tooltip( $windowCorners_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $windowCorners ); ?>
    </div>
  </div>

  <div class="container">
    <div class="element">
      <?php _e( 'Color', $this->text_domain ); ?><?php echo self::tooltip( $windowColor_help ); ?>
      <?php echo self::pro(); ?><br/>
      <?php echo self::option( $windowColor ); ?>
    </div>
    <div class="element">
    </div>
    <div class="element">
    </div>
  </div>

</fieldset>


