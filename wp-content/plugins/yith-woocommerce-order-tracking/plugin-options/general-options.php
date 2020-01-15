<?php
global $YWOT_Instance;
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


if ( defined( 'YITH_YWOT_PREMIUM' ) ) {
	$carrier_option = array(
		'name'    => __( 'Default carrier name', 'yith-woocommerce-order-tracking' ),
		'id'      => 'ywot_carrier_default_name',
		'type'    => 'select',
		'desc'    => __( '  To display the list of carriers, you have to select them first from the specific "Carriers" tab that you can find in the top part of the screen.', 'yith-woocommerce-order-tracking' ),
		'options' => Carriers::getInstance()->get_carriers_enabled( true )
	);
} else {
	$carrier_option = array(
		'name' => __( 'Default carrier name', 'yith-woocommerce-order-tracking' ),
		'type' => 'text',
		'id'   => 'ywot_carrier_default_name'
	);
}

$general_options = array(

	'general' => array(

		'section_general_settings'     => array(
			'name' => __( 'General settings', 'yith-woocommerce-order-tracking' ),
			'type' => 'title',
			'id'   => 'ywot_section_general'
		),
		'carrier_default_name'         => $carrier_option,
		'order_tracking_text'          => array(
			'name'    => __( 'Text in the Orders page', 'yith-woocommerce-order-tracking' ),
			'type'    => 'text',
			'id'      => 'ywot_order_tracking_text',
			'default' => __( 'Your order has been picked up by [carrier_name] on [pickup_date]. Your track code is [track_code].', 'yith-woocommerce-order-tracking' ),
			'desc'    => __( 'This is the text showed in Order details page. You can customize the text using the following 3 placeholders, representing real shipping information.', 'yith-woocommerce-order-tracking' ) . '[carrier_name], [pickup_date], [track_code]',
			'css'     => 'width:60%'
		),
		'order_tracking_text_position' => array(
			'name'    => __( 'Position of the text in the Orders page', 'yith-woocommerce-order-tracking' ),
			'type'    => 'select',
			'id'      => 'ywot_order_tracking_text_position',
			'desc'    => __( 'Choose if tracking text have to be shown on top (before order product list) or on bottom (after product list).', 'yith-woocommerce-order-tracking' ),
			'options' => array(
				'1' => __( 'Show on top', 'yith-woocommerce-order-tracking' ),
				'2' => __( 'Show on bottom', 'yith-woocommerce-order-tracking' ),
			),
			'default' => '1'
		),
	)
);

$general_options = apply_filters( 'yith_ywot_general_options', $general_options );

$general_options['general']['section_general_settings_end'] = array(
	'type' => 'sectionend',
	'id'   => 'ywot_section_general_end'
);

return $general_options;

