<?php
/**
 * GENERAL ARRAY OPTIONS
 */

$general = array(

	'general'  => array(

		'general-options' => array(
			'title' => __( 'General Options', 'yith-woocommerce-waiting-list' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'yith-wcwtl-general-options'
		),

		'enable-waiting-list' => array(
			'id'        => 'yith-wcwtl-enable',
			'name'      => __( 'Enable Waiting List', 'yith-woocommerce-waiting-list' ),
			'type'      => 'checkbox',
			'default'   => 'yes'
		),

		'waiting-list-message'  => array(
			'id'        => 'yith-wcwtl-form-message',
			'name'      => __( 'Notification message', 'yith-woocommerce-waiting-list' ),
			'desc'      => __( 'A text message to show before the waiting list form in the single product page.', 'yith-woocommerce-waiting-list' ),
			'type'      => 'text',
			'default'   => __( 'Notify me when the item is back in stock.', 'yith-woocommerce-waiting-list' ),
		),

		'waiting-list-button-add'  => array(
			'id'        => 'yith-wcwtl-button-add-label',
			'name'      => __( 'Add button label', 'yith-woocommerce-waiting-list' ),
			'desc'      => __( 'The label of the button to be added to the waiting list', 'yith-woocommerce-waiting-list' ),
			'type'      => 'text',
			'default'   => __( 'Add to waiting list', 'yith-woocommerce-waiting-list' ),
		),

		'waiting-list-button-leave'  => array(
			'id'        => 'yith-wcwtl-button-leave-label',
			'name'      => __( 'Remove button label', 'yith-woocommerce-waiting-list' ),
			'desc'      => __( 'The label of the button to be removed from the waiting list', 'yith-woocommerce-waiting-list' ),
			'type'      => 'text',
			'default'   => __( 'Leave waiting list', 'yith-woocommerce-waiting-list' ),
		),

		'waiting-list-success-msg'  => array(
			'id'        => 'yith-wcwtl-button-success-msg',
			'name'      => __( 'Successful registration message', 'yith-woocommerce-waiting-list' ),
			'desc'      => __( 'The text for the successful registration in the waiting list.', 'yith-woocommerce-waiting-list' ),
			'type'      => 'text',
			'default'   => __( 'You have been added to the waiting list for this product', 'yith-woocommerce-waiting-list' ),
		),

		'general-options-end' => array(
			'type'      => 'sectionend',
			'id'        => 'yith-wcwtl-general-options'
		),
	)
);

return apply_filters( 'yith_wcwt_panel_general_options', $general );