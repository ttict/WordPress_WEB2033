<?php
/**
 * Main Settings param
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
*/

include_once( 'icons.php' );
$icons_new = array();
foreach ( $icons as $key => $value ) {
  $icons_new[ $value ] = $value;
}

// Main Settings

// Position of the menu
$menu = array(
  'id'     => 'position',
  'name'   => 'param[menu]',
  'type'   => 'select',
  'val'    => isset( $param[ 'menu' ] ) ? $param[ 'menu' ] : 'left',
  'option' => array(
    'left' => __( 'Left', $this->text_domain ),
    'right' => __( 'Right', $this->text_domain ),
  ),
);

// Menu position help
$menu_help = array (
  'text' => __('Specify menu position on screen.', $this->text_domain),
);

// Top Offset from start position
$top_offset = array(
  'name'   => 'param[top_offset]',
  'type'   => 'number',
  'val'    => isset( $param[ 'top_offset' ] ) ? $param[ 'top_offset' ] : '0',
  'option' => array(
    'min'         => '0',
    'max'         => '60',
    'step'        => '1',
    'placeholder' => '10',
    'disabled' => 'disabled',
  ),
);

$top_offset_help = array (
  'text' => __('Top Offset from base position on screen in (px).', $this->text_domain),
);

// Offset from start position
$side_offset = array(
  'name'   => 'param[side_offset]',
  'type'   => 'number',
  'val'    => isset( $param[ 'side_offset' ] ) ? $param[ 'side_offset' ] : '0',
  'option' => array(
    'min'         => '0',
    'max'         => '60',
    'step'        => '1',
    'placeholder' => '10',
    'disabled' => 'disabled',
  ),
);

$side_offset_help = array (
  'text' => __('Side Offset from base position on screen in (px).', $this->text_domain),
);

// Menu Vertical alignment
$align = array(
	'name'   => 'param[align]',
	'id'     => 'align',
	'class'  => '',
	'type'   => 'select',
	'val'    => isset( $param['align'] ) ? $param['align'] : 'center',
	'option' => array(
	  'top' => __( 'Top', $this->text_domain ),
		'center' => __( 'Center', $this->text_domain ),
		'bottom' => __( 'Bottom', $this->text_domain ),
	),
  'disabled' => 'disabled',
);

// Menu Vertical alignment help
$align_help = array (
  'text' => __('Specify the vertical positioning of the menu.', $this->text_domain),
);



// Shape for menu item
$shape = array(
  'name'   => 'param[shape]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['shape'] ) ? $param['shape'] : 'square',
  'option' => array(
    'square' => __( 'Square', $this->text_domain ),
    'round' => __( 'Round', $this->text_domain ),
    'rounded' => __( 'Rounded', $this->text_domain ),
    'rounded-out' => __( 'Rounded-out', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

// Shape help
$shape_help = array (
  'text' => __('The shape of the buttons. It also determines the shape of the labels.', $this->text_domain),
);

// Side Space
$sideSpace = array(
  'name'   => 'param[sideSpace]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['sideSpace'] ) ? $param['sideSpace'] : 'true',
  'option' => array(
    'true' => __( 'Yes', $this->text_domain ),
    'false' => __( 'No', $this->text_domain ),
  ),
);

// Side Space help
$sideSpace_help = array (
  'text' => __('If there should be space on the side of the bar.', $this->text_domain),
);

// Button Space
$buttonSpace = array(
  'name'   => 'param[buttonSpace]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['buttonSpace'] ) ? $param['buttonSpace'] : 'true',
  'option' => array(
    'true' => __( 'Yes', $this->text_domain ),
    'false' => __( 'No', $this->text_domain ),
  ),
);

// Button Space help
$buttonSpace_help = array (
  'text' => __('If there should be space between the buttons.', $this->text_domain),
);

// Label On
$labelsOn = array(
  'name'   => 'param[labelsOn]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['labelsOn'] ) ? $param['labelsOn'] : 'true',
  'option' => array(
    'true' => __( 'Yes', $this->text_domain ),
    'false' => __( 'No', $this->text_domain ),
  ),
);

// Label On help
$labelsOn_help = array (
  'text' => __('If the labels should be enabled.', $this->text_domain),
);

// Label Space
$labelSpace = array(
  'name'   => 'param[labelSpace]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['labelSpace'] ) ? $param['labelSpace'] : 'true',
  'option' => array(
    'true' => __( 'Yes', $this->text_domain ),
    'false' => __( 'No', $this->text_domain ),
  ),
);

// Label Space help
$labelSpace_help = array (
  'text' => __('If there should be space between the label and the button.', $this->text_domain),
);

// Label Connected
$labelConnected = array(
  'name'   => 'param[labelConnected]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['labelConnected'] ) ? $param['labelConnected'] : 'true',
  'option' => array(
    'true' => __( 'Yes', $this->text_domain ),
    'false' => __( 'No', $this->text_domain ),
  ),
);

// Label Connected help
$labelConnected_help = array (
  'text' => __('If the button and label should be visually connected or not. If they are connected, when the label appears, it looks like it expands from the button.', $this->text_domain),
);

// Label Animate
$labelEffect = array(
  'name'   => 'param[labelEffect]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['labelEffect'] ) ? $param['labelEffect'] : 'fade',
  'option' => array(
    'none'           => __( 'None', $this->text_domain ),
    'fade'           => __( 'Fade', $this->text_domain ),
    'slide'          => __( 'Slide', $this->text_domain ),
    'slide-out'      => __( 'Slide-out', $this->text_domain ),
    'slide-out-fade' => __( 'Slide-out-fade', $this->text_domain ),
    'slide-in'       => __( 'Slide-in', $this->text_domain ),
    'slide-out-out'  => __( 'Slide-out-out', $this->text_domain ),
    'slide-in-in'    => __( 'Slide-in-in', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

// Label Connected help
$labelEffect_help = array (
  'text' => __('The appearance effect of the button label', $this->text_domain),
);

// Label Speed
$labelSpeed = array(
  'name'   => 'param[labelSpeed]',
  'type'   => 'number',
  'val'    => isset( $param[ 'labelSpeed' ] ) ? $param[ 'labelSpeed' ] : '400',
  'option' => array(
    'min'         => '0',
    'step'        => '1',
    'placeholder' => '400',
  ),
);

$labelSpeed_help = array (
  'text' => __('Set the time is in milliseconds.', $this->text_domain),
);

// Sub Menu Settings

// Sub Position
$subPosition = array(
  'name'   => 'param[subPosition]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['subPosition'] ) ? $param['subPosition'] : 'under',
  'option' => array(
    'under'    => __( 'Under', $this->text_domain ),
    'side'     => __( 'Side', $this->text_domain ),
    'circular' => __( 'Сircular', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

// Sub Position help
$subPosition_help = array (
  'text' => __('The position of the subbar.', $this->text_domain),
);

// Sub Space
$subSpace = array(
  'name'   => 'param[subSpace]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['subSpace'] ) ? $param['subSpace'] : 'true',
  'option' => array(
    'true' => __( 'Yes', $this->text_domain ),
    'false' => __( 'No', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

// Sub Space help
$subSpace_help = array (
  'text' => __('If there should be space between the subbar and the button.', $this->text_domain),
);

// Sub Open
$subOpen = array(
  'name'   => 'param[subOpen]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['subOpen'] ) ? $param['subOpen'] : 'mouseover',
  'option' => array(
    'mouseover' => __( 'Mouseover', $this->text_domain ),
    'click'     => __( 'Click', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

// Sub Space help
$subOpen_help = array (
  'text' => __('If the subbar should be opened on mouseover or on click.', $this->text_domain),
);


// Sub Effect
$subEffect = array(
  'name'   => 'param[subEffect]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['subEffect'] ) ? $param['subEffect'] : 'none',
  'option' => array(
    'none'         => __( 'None', $this->text_domain ),
    'fade'         => __( 'Fade', $this->text_domain ),
    'slide'        => __( 'Slide', $this->text_domain ),
    'linear-fade'  => __( 'Linear-fade', $this->text_domain ),
    'linear-slide' => __( 'Linear-slide', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

// Sub Space help
$subEffect_help = array (
  'text' => __('The appearance effect of the subbar.', $this->text_domain),
);

// Sub Speed (ms)
$subSpeed = array(
  'name'   => 'param[subSpeed]',
  'type'   => 'number',
  'val'    => isset( $param[ 'subSpeed' ] ) ? $param[ 'subSpeed' ] : '400',
  'option' => array(
    'min'         => '0',
    'step'        => '1',
    'placeholder' => '400',
    'disabled' => 'disabled',
  ),
);

$subSpeed_help = array (
  'text' => __('Set the time is in milliseconds.', $this->text_domain),
);

// Popup Settings

// Horizontal position
$windowhorizontalPosition = array(
  'name'   => 'param[windowhorizontalPosition]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['windowhorizontalPosition'] ) ? $param['windowhorizontalPosition'] : 'center',
  'option' => array(
    'center'         => __( 'Center', $this->text_domain ),
    'left'         => __( 'Left', $this->text_domain ),
    'right'        => __( 'Right', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

$windowhorizontalPosition_help = array (
  'text' => __('Set the horizontal position of the window.', $this->text_domain),
);

// Vertical position
$windowverticalPosition = array(
  'name'   => 'param[windowverticalPosition]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['windowverticalPosition'] ) ? $param['windowverticalPosition'] : 'center',
  'option' => array(
    'center' => __( 'Center', $this->text_domain ),
    'top'    => __( 'Top', $this->text_domain ),
    'bottom' => __( 'Bottom', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

$windowverticalPosition_help = array (
  'text' => __('Set the vertical position of the window.', $this->text_domain),
);

// Corners
$windowCorners = array(
  'name'   => 'param[windowCorners]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['windowCorners'] ) ? $param['windowCorners'] : 'match',
  'option' => array(
    'match' => __( 'Match', $this->text_domain ),
    'square'    => __( 'Square', $this->text_domain ),
    'round' => __( 'Round', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

$windowCorners_help = array (
  'text' => __('The type of the window corners.', $this->text_domain),
);

// Color
$windowColor = array(
  'name'   => 'param[windowColor]',
  'class'  => '',
  'type'   => 'select',
  'val'    => isset( $param['windowColor'] ) ? $param['windowColor'] : 'default',
  'option' => array(
    'default' => __( 'Default', $this->text_domain ),
    'black'   => __( 'Black', $this->text_domain ),
    'red'     => __( 'Red', $this->text_domain ),
    'yellow'  => __( 'Yellow', $this->text_domain ),
    'blue'    => __( 'Blue', $this->text_domain ),
  ),
  'disabled' => 'disabled',
);

$windowColor_help = array (
  'text' => __('The color of the header of the window.', $this->text_domain),
);

// Icon & Label Size

// Icon size (px)
$iconSize = array(
  'name'   => 'param[iconSize]',
  'type'   => 'number',
  'val'    => isset( $param[ 'iconSize' ] ) ? $param[ 'iconSize' ] : '24',
  'option' => array(
    'min'         => '0',
    'step'        => '1',
    'placeholder' => '16',
    'disabled' => 'disabled',
  ),
);

$iconSize_help = array (
  'text' => __('Set the size for menu icons.', $this->text_domain),
);

// Icon size for mobile
$mobiliconSize = array(
  'name'   => 'param[mobiliconSize]',
  'type'   => 'number',
  'val'    => isset( $param[ 'mobiliconSize' ] ) ? $param[ 'mobiliconSize' ] : '24',
  'option' => array(
    'min'         => '0',
    'step'        => '1',
    'placeholder' => '16',
    'disabled' => 'disabled',
  ),
);

$mobiliconSize_help = array (
  'text' => __('Set the Icons size on mobile devices.', $this->text_domain),
);

// Mobile Screen (px)
$mobilieScreen = array(
  'name'   => 'param[mobilieScreen]',
  'type'   => 'number',
  'val'    => isset( $param[ 'mobilieScreen' ] ) ? $param[ 'mobilieScreen' ] : '480',
  'option' => array(
    'min'         => '0',
    'step'        => '1',
    'placeholder' => '480',
    'disabled' => 'disabled',
  ),
);

$mobilieScreen_help = array (
  'text' => __('Set the size screen for mobile devices when use Icon size for mobile.', $this->text_domain),
);

// Label size (px)
$labelSize = array(
  'name'   => 'param[labelSize]',
  'type'   => 'number',
  'val'    => isset( $param[ 'labelSize' ] ) ? $param[ 'labelSize' ] : '15',
  'option' => array(
    'min'         => '0',
    'step'        => '1',
    'placeholder' => '24',
    'disabled' => 'disabled',
  ),
);

$labelSize_help = array (
  'text' => __('Set the size for menu labels.', $this->text_domain),
);

// Label size for mobile (px)
$mobillabelSize = array(
  'name'   => 'param[mobillabelSize]',
  'type'   => 'number',
  'val'    => isset( $param[ 'mobillabelSize' ] ) ? $param[ 'mobillabelSize' ] : '15',
  'option' => array(
    'min'         => '0',
    'step'        => '1',
    'placeholder' => '24',
    'disabled' => 'disabled',
  ),
);

$mobillabelSize_help = array (
  'text' => __('Set the Labels size on mobile devices.', $this->text_domain),
);


// Show After Position
$showAfterPosition = array(
  'name'   => 'param[showAfterPosition]',
  'type'   => 'number',
  'val'    => isset( $param[ 'showAfterPosition' ] ) ? $param[ 'showAfterPosition' ] : '0',
  'option' => array(
    'min'         => '0',
    'step'        => '1',
    'placeholder' => '0',
    'disabled' => 'disabled',
  ),
);

// Show After Position helper
$showAfterPosition_help = array (
  'text' => __('If the sidebar should be shown only after the page was scrolled beyond a certain point.', $this->text_domain),
);