<?php
/**
 * Targeting
 *
 * @package     Wow_Pluign
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include_once( 'settings/targeting.php' );

?>

<div id="targeting" class="postbox wow-sidebar">
  <h2><?php _e( 'Targeting', $this->text_domain ); ?></h2>
  <div class="inside">
    <div class="container">
      <div class="element">
        <h4><?php _e( 'Show on devices', $this->text_domain ); ?></h4>
				<?php echo self::option( $include_more_screen ); ?> <label
          for="include_more_screen"><?php _e( "Don't show on screens more", $this->text_domain ); ?></label><?php echo self::tooltip( $show_screen_help ); ?>
        <p/>
				<?php echo self::option( $screen_more ); ?>
				<?php echo self::option( $include_mobile ); ?> <label
          for="include_mobile"><?php _e( "Don't show on screens less", $this->text_domain ); ?></label><?php echo self::tooltip( $include_mobile_help ); ?>
        <p/>
				<?php echo self::option( $screen ); ?><p/>
      </div>
    </div>
    <div class="container">
      <div class="element">
        <h4><?php _e( 'Show for users', $this->text_domain ); ?> <?php echo self::pro(); ?></h4>
				<?php echo self::option( $item_user ); ?><p/>

      </div>
    </div>
    <div class="container">
      <div class="element">
        <h4><?php _e( 'Depending on the language', $this->text_domain ); ?> <?php echo self::pro(); ?></h4>
				<?php echo self::option( $depending_language ); ?> <label
          for="depending_language"><?php _e( "Enable", $this->text_domain ); ?></label>
        <p/>
      </div>
    </div>
    <div class="container">
      <div class="element">
        <h4><?php _e( 'Font Awesome 5 style', $this->text_domain ); ?></h4>
        <?php echo self::option( $disable_fontawesome ); ?> <label
          for="disable_fontawesome"><?php _e( "Disable", $this->text_domain ); ?></label>
        <?php echo self::tooltip( $disable_fontawesome_help ); ?>
      </div>
    </div>
		<div class="container">
			<div class="element">
				<p/>
				<h4><?php _e( 'Mobile Rules', $this->text_domain ); ?></h4>
		  <?php echo self::option( $mobile_rules ); ?>
				<label for="mobile_rules"> <?php _e( 'Enable', $this->text_domain ); ?></label>
				<?php echo self::tooltip( $mobile_rules_help ); ?>
					<p/>
				<span id="mobile_screen_block">
					<?php _e( 'Mobile screen ', $this->text_domain ); ?> (px) <?php echo self::tooltip( $mobile_screen_help ); ?>
					<?php echo self::option( $mobile_screen ); ?>
				</span>
			</div>
		</div>
  </div>
</div>