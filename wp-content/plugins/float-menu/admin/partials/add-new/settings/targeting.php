<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Tergeting settings
 *
 * @package     Lead_Generation
 * @subpackage  Settings
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Enable Don’t show on screens more than
$include_more_screen = array(
	'id'   => 'include_more_screen',
	'name' => 'param[include_more_screen]',
	'type' => 'checkbox',
	'val'  => isset( $param['include_more_screen'] ) ? $param['include_more_screen'] : 0,
	'func' => 'screen_more(this);',
);

// Show on screens helper
$show_screen_help = array(
	'text' => __( 'Specify the window breakpoint in px when the button will be shown.', $this->text_domain ),
);

// Max screen value
$screen_more = array(
	'id'     => 'screenmore',
	'name'   => 'param[screen_more]',
	'type'   => 'number',
	'val'    => isset( $param['screen_more'] ) ? $param['screen_more'] : 1024,
	'option' => array(
		'min'         => '0',
		'max'         => '3000',
		'step'        => '1',
		'placeholder' => '1024',
	),
);

// Enable Don’t show on screens less than
$include_mobile = array(
	'id'   => 'include_mobile',
	'name' => 'param[include_mobile]',
	'type' => 'checkbox',
	'val'  => isset( $param['include_mobile'] ) ? $param['include_mobile'] : 0,
	'func' => 'screen_less(this);',
);

// Enable Don’t show on screens less than helper
$include_mobile_help = array(
	'text' => __( 'Specify the window breakpoint ( mix width) in px.', $this->text_domain ),
);

// Min screen value
$screen = array(
	'id'     => 'screen',
	'name'   => 'param[screen]',
	'type'   => 'number',
	'val'    => isset( $param['screen'] ) ? $param['screen'] : 480,
	'option' => array(
		'min'         => '0',
		'max'         => '3000',
		'step'        => '1',
		'placeholder' => '480',
	),
);

// Show for users
$item_user = array(
	'id'     => 'item_user',
	'name'   => 'param[item_user]',
	'type'   => 'radio',
	'class'  => 'item_user',
	'val'    => isset( $param['item_user'] ) ? $param['item_user'] : '1',
	'option' => array(
		'1'          => __( 'All Users', $this->text_domain ),
		'2'   => __( 'Authorized Users', $this->text_domain ),
		'3' => __( 'Unauthorized Users', $this->text_domain ),
	),
	'sep'    => '<br/>',
	'func'   => 'usersroles(this);',
  'disabled' => 'disabled',
);




// Enable Depending on the language
$depending_language = array(
	'id'   => 'depending_language',
	'name' => 'param[depending_language]',
	'type' => 'checkbox',
	'val'  => isset( $param['depending_language'] ) ? $param['depending_language'] : 0,
	'func' => 'languages(this);',
  'disabled' => 'disabled',
);


// Disable FontAwesome on front-end of the site
$disable_fontawesome = array(
  'id'   => 'disable_fontawesome',
  'name' => 'param[disable_fontawesome]',
  'type' => 'checkbox',
  'val'  => isset( $param['disable_fontawesome'] ) ? $param['disable_fontawesome'] : 0,
);

$disable_fontawesome_help = array (
  'title' => __('Disable Font Awesome 5 style on front-end of the site.', $this->text_domain),
  'ul' => array (
    __('If you already have a Font Awesome 5 installed on the site, you can disable the include the Font Awesome 5 style.', $this->text_domain),
  ),
);

// Mobile rules Enable
$mobile_rules = array(
	'name'  => 'param[mobile_rules]',
	'id'    => 'mobile_rules',
	'class' => '',
	'type'  => 'checkbox',
	'val'   => isset( $param['mobile_rules'] ) ? $param['mobile_rules'] : 0,
	'func' => 'mobileRules(this);',
	'sep'   => '',
);

$mobile_rules_help = array (
	'title' => __('Enable mobile rules for menu. Defines menu behavior on mobile devices:', $this->text_domain),
	'ul' => array (
		__('First click opens the label', $this->text_domain),
		__('Second click calls the link AND closes the label', $this->text_domain),
	),
);

// Screen for mobile rules
$mobile_screen = array(
	'name'   => 'param[mobile_screen]',
	'id'     => 'mobile_screen',
	'type'   => 'number',
	'val'    => isset( $param['mobile_screen'] ) ? $param['mobile_screen'] : '768',
	'option' => array(
		'step'        => '1',
		'placeholder' => '768',
	),
);

$mobile_screen_help = array(
	'text' => __( 'Set the screen width for mobile devices when mobile rules are applied.', $this->text_domain ),
);
