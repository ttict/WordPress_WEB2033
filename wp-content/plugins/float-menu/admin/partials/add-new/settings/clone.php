<?php
/**
 * Clone Elements Settings
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Elements for clone Menu 1
$menu_1_item_icon = array(
	'name'  => 'param[menu_1][item_icon][]',
	'class' => 'icons',
	'type'  => 'select',
	'val'   => 'fas fa-hand-point-up',
	'option' => $icons_new,
);
$menu_1_item_custom = array(
	'name'  => 'param[menu_1][item_custom][]',
	'type'  => 'checkbox',
	'class' => 'custom-icon',
	'val'   => 0,
	'func'  => 'customicon(this); checkboxchecked(this);',
  'disabled' => 'disabled',
);

$menu_1_item_tooltip = array(
	'name'  => 'param[menu_1][item_tooltip][]',
	'class' => 'item-tooltip',
	'type'  => 'text',
	'val'   => '',
);

$menu_1_item_sub = array(
  'name'  => 'param[menu_1][item_sub][]',
  'type'  => 'checkbox',
  'val'   => '',
  'disabled' => 'disabled',
);

$menu_1_item_sub_help = array(
  'text' => __('Set item as sub item for first item of the menu.', $this->text_domain),
);

$menu_1_item_type = array(
  'name'   => 'param[menu_1][item_type][]',
  'type'   => 'select',
  'val'    => 'link',
  'class'  => 'item-type',
  'option' => array(
    'link'         => __( 'Link', $this->text_domain ),
  ),
  'func'   => 'itemtype(this);',

);

$menu_1_item_link = array(
  'name' => 'param[menu_1][item_link][]',
  'type' => 'text',
  'val'  => '',
);

$menu_1_new_tab = array(
  'name'  => 'param[menu_1][new_tab][]',
  'class' => '',
  'type'  => 'checkbox',
  'val'   => '',
);

// Font color
$menu_1_color = array(
  'name' => 'param[menu_1][color][]',
  'type' => 'color',
  'val'  => '#ffffff',
);

// Icon Сolor
//$menu_1_iconcolor = array(
//  'name' => 'param[menu_1][iconcolor][]',
//  'type' => 'color',
//  'val'  => '#ffffff',
//);

// Background
$menu_1_bcolor = array(
  'name' => 'param[menu_1][bcolor][]',
  'type' => 'color',
  'val'  => '#128be0',
);

// Background Hover
//$menu_1_hbcolor = array(
//  'name' => 'param[menu_1][hbcolor][]',
//  'type' => 'color',
//  'val'  => '#128be0',
//);

$menu_1_button_id = array (
	'name' => 'param[menu_1][button_id][]',
	'type' => 'text',
	'val'  => '',
);

$menu_1_button_id_help = array (
	'text' => __( 'Set ID for element.', $this->text_domain ),
);

$menu_1_button_class = array (
	'name' => 'param[menu_1][button_class][]',
	'type' => 'text',
	'val'  => '',
);

$menu_1_button_class_help = array (
	'title' => __( 'Set Class for element.', $this->text_domain ),
	'ul' => array(
		__( 'You may enter several classes separated by a space.', $this->text_domain ),
	)
);

$menu_1_hold_open = array(
  'name'  => 'param[menu_1][hold_open][]',
  'class' => '',
  'type'  => 'checkbox',
  'val'   => '',
  'disabled' => 'disabled',
);

$menu_1_item_icon_help = array (
  'title' => __('Set the icon for menu item. If you want use the custom item:', $this->text_domain),
  'ul' => array (
    __('1. Check the box on "custom"', $this->text_domain),
    __('2. Upload the icon in Media Library', $this->text_domain),
    __('3. Copy the URL to icon', $this->text_domain),
    __('4. Paste the icon URL to field', $this->text_domain),
  ),
);

$menu_1_item_tooltip_help = array(
  'text' => __( 'Set the text for menu item.', $this->text_domain ),
);

$menu_1_item_type_help = array(
  'text' => __( 'Select the type of menu item. Explanation of some types:', $this->text_domain ),
  'ul' => array (
    __('<strong>Smooth Scroll</strong> - Smooth scrolling of the page to the specified anchors on the page. Enter Link like #anchor', $this->text_domain),

  ),
);

$menu_1_hold_open_help = array(
  'text' => __('When the page loads, the menu item will open.', $this->text_domain),
);