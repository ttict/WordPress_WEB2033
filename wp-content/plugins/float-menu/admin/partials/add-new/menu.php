<?php
/**
 * Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( !defined( 'ABSPATH' ) ) {
  exit;
}

include_once('settings/menu.php');
?>

<div class="adding-menu-1">
  <?php if ( $count_i > 0 ) {
    for ( $i = 0; $i < $count_i; $i++ ) { ?>
      <fieldset class="itembox">
        <legend>
          <?php _e( 'Item ', $this->text_domain ); ?><?php echo $i + 1; ?>
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
              <?php echo self::option( $item_custom_[ $i ] ); ?>
              <?php echo self::tooltip( $item_icon_help ); ?>
              <?php echo self::pro(); ?>
              <br/>
              <?php echo self::option( $item_icon_[ $i ] ); ?>
              <?php echo self::option( $item_custom_link_[ $i ] ); ?>

            </div>
            <div class="element">
              <?php _e( 'Label Text', $this->text_domain ); ?> <?php echo self::tooltip( $item_tooltip_help ); ?>
              <br/>
              <?php echo self::option( $item_tooltip_[ $i ] ); ?>
            </div>
            <div class="element">
              <span class="sub_menu">
              <?php echo self::option( $item_sub_[ $i ] ); ?>
              <?php _e( 'Sub Menu', $this->text_domain ); ?>
              <?php echo self::tooltip( $item_sub_help ); ?>
              <?php echo self::pro(); ?>
              </span>
            </div>
          </div>
          <div class="container">
            <div class="element">
              <?php _e( 'Item type', $this->text_domain ); ?> <?php echo self::tooltip( $item_type_help ); ?>
              <?php echo self::pro(); ?><br/>
              <?php echo self::option( $item_type_[ $i ] ); ?>
            </div>
            <div class="element type-param">
              <div class="type-link">
                <span class="type-link-text">Link</span>
                <br/>
                <?php echo self::option( $item_link_[ $i ] ); ?>
              </div>
            </div>
            <div class="element type-link-blank">
              <?php echo self::option( $new_tab_[ $i ] ); ?>
              <?php _e( 'Open in new window', $this->text_domain ); ?>
            </div>
          </div>

          <div class="container">
            <div class="element">
              <?php _e( 'Font Сolor', $this->text_domain ); ?><br/>
              <?php echo self::option( $color_[ $i ] ); ?>
            </div>
            <div class="element">
              <?php _e( 'Background', $this->text_domain ); ?><br/>
              <?php echo self::option( $bcolor_[ $i ] ); ?>
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
              <?php echo self::tooltip( $button_id_help ); ?>
              <br/>
              <?php echo self::option( $button_id_[ $i ] ); ?>
            </div>
            <div class="element button_class">
              <?php _e( 'Class for element', $this->text_domain ); ?>
              <?php echo self::tooltip( $button_class_help ); ?>
              <br/>
              <?php echo self::option( $button_class_[ $i ] ); ?>
            </div>
            <div class="element">
            </div>

          </div>
        </div>
      </fieldset>
      <?php
    }
  }
  ?>
</div>

<div class="submit-bottom">
  <input type="button" value="<?php _e( 'Add item', $this->text_domain ); ?>" class="add-item" onclick="itemadd(1)">
</div>
