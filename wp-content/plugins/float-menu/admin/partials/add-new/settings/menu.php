<?php
/**
 * Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */


$count_i = (!empty( $param[ 'menu_1' ][ 'item_icon' ] )) ? count( $param[ 'menu_1' ][ 'item_icon' ] ) : '0';
if ( $count_i > 0 ) {
  for ( $i = 0; $i < $count_i; $i++ ) {

    // Order of the menu
//    $item_order_[ $i ] = array (
//    	'name' => 'param[item_order][]',
//    	'id'   => 'item_order',
//    	'type' => 'hidden',
//    	'val'  => isset( $param['item_order'][ $i ] ) ? $param['item_order'][ $i ] : '',
//    );

    // Icon
    $item_icon_[ $i ] = array(
      'name'   => 'param[menu_1][item_icon][]',
      'class'  => 'icons',
      'type'   => 'select',
      'val'    => isset( $param[ 'menu_1' ][ 'item_icon' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_icon' ][ $i ] : 'fas fa-hand-point-up',
      'option' => $icons_new,
    );

    // Select custom icon
    $item_custom_[ $i ] = array(
      'name'  => 'param[menu_1][item_custom][]',
      'type'  => 'checkbox',
      'class' => 'custom-icon',
      'val'   => isset( $param[ 'menu_1' ][ 'item_custom' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_custom' ][ $i ] : 0,
      'func'  => 'customicon(this);',
      'disabled' => 'disabled',
    );

    // Custom icon URL
    $item_custom_link_[ $i ] = array(
      'name'   => 'param[menu_1][item_custom_link][]',
      'type'   => 'text',
      'class'  => 'custom-icon-url',
      'val'    => isset( $param[ 'menu_1' ][ 'item_custom_link' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_custom_link' ][ $i ] : '',
      'option' => array(
        'placeholder' => __( 'Enter Icon URL', $this->text_domain ),
      ),
    );

    // Label for item
    $item_tooltip_[ $i ] = array(
      'name'  => 'param[menu_1][item_tooltip][]',
      'class' => 'item-tooltip',
      'type'  => 'text',
      'val'   => isset( $param[ 'menu_1' ][ 'item_tooltip' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_tooltip' ][ $i ] : '',
    );

    // Sub item
    $item_sub_[ $i ] = array(
      'name'  => 'param[menu_1][item_sub][]',
      'type'  => 'checkbox',
      'val'   => isset( $param[ 'menu_1' ][ 'item_sub' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_sub' ][ $i ] : '',
      'disabled' => 'disabled',
    );

//    $smooth = isset( $param[ 'menu_1' ][ 'scroll' ][ $i ] ) ? $param[ 'menu_1' ][ 'scroll' ][ $i ] : '';

    // Type of the item
    $item_type_[ $i ] = array(
      'name'   => 'param[menu_1][item_type][]',
      'type'   => 'select',
      'class'  => 'item-type',
      'val'    => isset( $param[ 'menu_1' ][ 'item_type' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_type' ][ $i ] : 'link',
      'option' => array(
        'link'         => __( 'Link', $this->text_domain ),
      ),
      'func'   => 'itemtype(this);',
    );


    // Link URL
    $item_link_[ $i ] = array(
      'name' => 'param[menu_1][item_link][]',
      'type' => 'text',
      'val'  => isset( $param[ 'menu_1' ][ 'item_link' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_link' ][ $i ] : '',
    );


    // Open link in a new window
    $new_tab_[ $i ] = array(
      'name'  => 'param[menu_1][new_tab][]',
      'class' => '',
      'type'  => 'checkbox',
      'val'   => isset( $param[ 'menu_1' ][ 'new_tab' ][ $i ] ) ? $param[ 'menu_1' ][ 'new_tab' ][ $i ] : 0,
      'func'  => '',
      'sep'   => '',
    );

    // Smooth scroll
//    $scroll_[ $i ] = array(
//      'name'  => 'param[menu_1][scroll][]',
//      'class' => '',
//      'type'  => 'checkbox',
//      'val'   => isset( $param[ 'menu_1' ][ 'scroll' ][ $i ] ) ? $param[ 'menu_1' ][ 'scroll' ][ $i ] : 0,
//      'func'  => '',
//      'sep'   => '',
//    );

    // Social Networks
    $item_share_[ $i ] = array(
      'name'   => 'param[menu_1][item_share][]',
      'type'   => 'select',
      'val'    => isset( $param[ 'menu_1' ][ 'item_share' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_share' ][ $i ] : '',
      'option' => array(
        'Facebook'      => __( 'Facebook', $this->text_domain ),
        'VK'            => __( 'VK', $this->text_domain ),
        'Twitter'       => __( 'Twitter', $this->text_domain ),
        'Linkedin'      => __( 'Linkedin', $this->text_domain ),
        'Odnoklassniki' => __( 'Odnoklassniki', $this->text_domain ),
        'Google'        => __( 'Google', $this->text_domain ),
        'Pinterest'     => __( 'Pinterest', $this->text_domain ),
        'xing'          => __( 'XING', $this->text_domain ),
        'myspace'       => __( 'Myspace', $this->text_domain ),
        'weibo'         => __( 'Weibo', $this->text_domain ),
        'buffer'        => __( 'Buffer', $this->text_domain ),
        'stumbleupon'   => __( 'StumbleUpon', $this->text_domain ),
        'reddit'        => __( 'Reddit', $this->text_domain ),
        'tumblr'        => __( 'Tumblr', $this->text_domain ),
        'blogger'       => __( 'Blogger', $this->text_domain ),
        'livejournal'   => __( 'LiveJournal', $this->text_domain ),
        'pocket'        => __( 'Pocket', $this->text_domain ),
        'telegram'      => __( 'Telegram', $this->text_domain ),
        'skype'         => __( 'Skype', $this->text_domain ),
        'email'         => __( 'Email', $this->text_domain ),
      ),
      'func'   => '',
    );

    // Modal
    $item_modal_[ $i ] = array(
      'name' => 'param[menu_1][item_modal][]',
      'type' => 'text',
      'val'  => isset( $param[ 'menu_1' ][ 'item_modal' ][ $i ] ) ? $param[ 'menu_1' ][ 'item_modal' ][ $i ] : '',
    );

    // Font color
    $color_[ $i ] = array(
      'name' => 'param[menu_1][color][]',
      'type' => 'color',
      'val'  => isset( $param[ 'menu_1' ][ 'color' ][ $i ] ) ? $param[ 'menu_1' ][ 'color' ][ $i ] : '#ffffff',
    );

    // Icon Сolor
//    $iconcolor_[ $i ] = array(
//      'name' => 'param[menu_1][iconcolor][]',
//      'type' => 'color',
//      'val'  => isset( $param[ 'menu_1' ][ 'iconcolor' ][ $i ] ) ? $param[ 'menu_1' ][ 'iconcolor' ][ $i ] : '#ffffff',
//    );

    // Background
    $bcolor_[ $i ] = array(
      'name' => 'param[menu_1][bcolor][]',
      'type' => 'color',
      'val'  => isset( $param[ 'menu_1' ][ 'bcolor' ][ $i ] ) ? $param[ 'menu_1' ][ 'bcolor' ][ $i ] : '#128be0',
    );

    // Background Hover
//    $hbcolor_[ $i ] = array(
//      'name' => 'param[menu_1][hbcolor][]',
//      'type' => 'color',
//      'val'  => isset( $param[ 'menu_1' ][ 'hbcolor' ][ $i ] ) ? $param[ 'menu_1' ][ 'hbcolor' ][ $i ] : '#128be0',
//    );
//
    $button_id_[ $i ] = array(
      'name' => 'param[menu_1][button_id][]',
      'type' => 'text',
      'val'  => isset( $param[ 'menu_1' ][ 'button_id' ][ $i ] ) ? $param[ 'menu_1' ][ 'button_id' ][ $i ] : '',
    );

    $button_class_[ $i ] = array(
      'name' => 'param[menu_1][button_class][]',
      'type' => 'text',
      'val'  => isset( $param[ 'menu_1' ][ 'button_class' ][ $i ] ) ? $param[ 'menu_1' ][ 'button_class' ][ $i ] : '',
    );

    // Hold open item when menu load
    $hold_open_[ $i ] = array(
      'name'  => 'param[menu_1][hold_open][]',
      'class' => '',
      'type'  => 'checkbox',
      'val'   => isset( $param[ 'menu_1' ][ 'hold_open' ][ $i ] ) ? $param[ 'menu_1' ][ 'hold_open' ][ $i ] : 0,
      'func'  => '',
      'sep'   => '',
      'disabled' => 'disabled',
    );

  }

}


$item_icon_help = array (
  'title' => __('Set the icon for menu item. If you want use the custom item:', $this->text_domain),
  'ul' => array (
    __('1. Check the box on "custom"', $this->text_domain),
    __('2. Upload the icon in Media Library', $this->text_domain),
    __('3. Copy the URL to icon', $this->text_domain),
    __('4. Paste the icon URL to field', $this->text_domain),
  ),
);

$item_tooltip_help = array(
  'text' => __( 'Set the text for menu item.', $this->text_domain ),
);

$item_type_help = array(
  'text' => __( 'Select the type of menu item. Explanation of some types:', $this->text_domain ),
  'ul' => array (
    __('<strong>Smooth Scroll</strong> - Smooth scrolling of the page to the specified anchors on the page. Enter Link like #anchor', $this->text_domain),
  ),
);

$hold_open_help = array(
  'text' => __('When the page loads, the menu item will open.', $this->text_domain),
);

$button_id_help = array(
  'text' => __('Set the attribute ID for the menu item or left empty.', $this->text_domain),
);

$button_class_help = array(
  'text' => __('Set the attribute CLASS for the menu item or left empty.', $this->text_domain),
);

$item_sub_help = array(
  'text' => __('Set item as sub item for first item of the menu.', $this->text_domain),
);