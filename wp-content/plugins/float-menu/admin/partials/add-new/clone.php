<?php
/**
 * Elements for clone
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( 'settings/clone.php' );
?>

<fieldset class="itembox" id="adding-menu-1">
  <legend>
    <?php _e( 'Item ', $this->text_domain ); ?> <span class="item"></span>
  </legend>
  <div class="control">
    <span class="dashicons dashicons-move"></span>
    <span class="dashicons dashicons-minus toogle"></span>
    <span class="dashicons dashicons-plus toogle"></span>
    <span class="dashicons dashicons-no-alt item-del"></span>
  </div>
  <div class="menu_block">
    <div class="container">
      <div class="element">
        <?php _e( 'Icon', $this->text_domain ); ?>:
        <?php _e( 'custom', $this->text_domain ); ?>
        <?php echo self::option( $menu_1_item_custom ); ?>
        <?php echo self::tooltip( $menu_1_item_icon_help ); ?>
        <?php echo self::pro(); ?>
        <br/>
        <?php echo self::option( $menu_1_item_icon ); ?>
      </div>
      <div class="element">
        <?php _e( 'Label Text', $this->text_domain ); ?>
        <?php echo self::tooltip( $menu_1_item_tooltip_help ); ?>
        <br/>
        <?php echo self::option( $menu_1_item_tooltip ); ?>
      </div>
      <div class="element">
        <?php echo self::option( $menu_1_item_sub ); ?>
        <?php _e( 'Sub Menu', $this->text_domain ); ?>
        <?php echo self::tooltip( $menu_1_item_sub_help ); ?>
        <?php echo self::pro(); ?>
      </div>
    </div>
    <div class="container">
      <div class="element">
        <?php _e( 'Item type', $this->text_domain ); ?>
        <?php echo self::tooltip( $menu_1_item_type_help ); ?>
        <?php echo self::pro(); ?>
        <br/>
        <?php echo self::option( $menu_1_item_type ); ?>
      </div>
      <div class="element type-param">
        <div class="type-link">
          <span class="type-link-text">Link</span>
          <br/>
          <?php echo self::option( $menu_1_item_link ); ?>
        </div>

      </div>
      <div class="element type-link-blank">
        <?php echo self::option( $menu_1_new_tab ); ?>
        <?php _e( 'Open in new window', $this->text_domain ); ?>
      </div>
    </div>

    <div class="container">
      <div class="element">
        <?php _e( 'Font Сolor', $this->text_domain ); ?><br/>
        <?php echo self::option( $menu_1_color ); ?>
      </div>
      <div class="element">
        <?php _e( 'Background', $this->text_domain ); ?><br/>
        <?php echo self::option( $menu_1_bcolor ); ?>
      </div>
      <div class="element">
				<input type="checkbox" disabled>
				<?php _e( 'Hold open', $this->text_domain ); ?>
				<?php echo self::pro(); ?>
			</div>
    </div>

    <div class="container">
      <div class="element button_id">
      <?php _e( 'ID for element', $this->text_domain ); ?>
        <?php echo self::tooltip( $menu_1_button_id_help ); ?>
        <br/>
      <?php echo self::option( $menu_1_button_id ); ?>

      </div>
      <div class="element button_class">
        <?php _e( 'Class for element', $this->text_domain ); ?>
        <?php echo self::tooltip( $menu_1_button_class ); ?>
        <br/>
        <?php echo self::option( $menu_1_button_class ); ?>

      </div>
      <div class="element">

      </div>

    </div>
  </div>
</fieldset>
