<?php
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


return array(

	'settings' => array(


		'section_general_settings'     => array(
			'name' => __( 'Request a Quote - General settings', 'yith-woocommerce-request-a-quote' ),
			'type' => 'title',
			'id'   => 'ywraq_section_general'
		),

        'page_id' => array(
            'name'     => __( 'Request Quote Page', 'yith-woocommerce-request-a-quote' ),
            'desc'     => __( 'Page contents: [yith_ywraq_request_quote]', 'yith-woocommerce-request-a-quote' ),
            'id'       => 'ywraq_page_id',
            'type'     => 'single_select_page',
            'class'    => 'wc-enhanced-select',
            'css'      => 'min-width:300px',
            'desc_tip' => false,
        ),

        'show_btn_link' => array(
            'name'    => __( 'Button type', 'yith-woocommerce-request-a-quote' ),
            'desc'    => '',
            'id'      => 'ywraq_show_btn_link',
            'type'    => 'select',
            'class'    => 'wc-enhanced-select',
            'options' => array(
                'link'   => __( 'Link', 'yith-woocommerce-request-a-quote' ),
                'button' => __( 'Button', 'yith-woocommerce-request-a-quote' ),
            ),
            'default' => 'button',
        ),

        'show_btn_link_text' => array(
            'name'    => __( 'Button/Link text', 'yith-woocommerce-request-a-quote' ),
            'desc'    => '',
            'id'      => 'ywraq_show_btn_link_text',
            'type'    => 'text',
            'default' => __('Add to quote', 'yith-woocommerce-request-a-quote'),
        ),

        'hide_add_to_cart' => array(
            'name'    => __( 'Hide "Add to cart" button', 'yith-woocommerce-request-a-quote' ),
            'desc'    => '',
            'id'      => 'ywraq_hide_add_to_cart',
            'type'      => 'yith-field',
            'yith-type' => 'onoff',
            'default' => 'no'
        ),

        'section_general_settings_end' => array(
			'type' => 'sectionend',
			'id'   => 'ywraq_section_general_end'
		),

        'section_form_settings'     => array(
	        'name' => __( 'Form - Settings', 'yith-woocommerce-request-a-quote' ),
	        'type' => 'title',
	        'id'   => 'ywraq_section_form_settings'
        ),
        'add_privacy_checkbox' => array(
	        'name'    => __( 'Add Privacy Policy', 'yith-woocommerce-request-a-quote' ),
	        'desc'    => '',
	        'id'      => 'ywraq_add_privacy_checkbox',
	        'type'      => 'yith-field',
	        'yith-type' => 'onoff',
	        'default' => 'no'
        ),
        'privacy_label' => array(
	        'name'    => __( 'Request a quote Privacy Policy Label', 'yith-woocommerce-request-a-quote' ),
	        'desc'    =>__('You can use the shortcode [terms] and [privacy_policy] (from WooCommerce 3.4.0)'),
	        'id'      => 'ywraq_privacy_label',
	        'type'      => 'yith-field',
	        'yith-type' => 'text',
	        'default' => __('I have read and agree to the website terms and conditions.', 'yith-woocommerce-request-a-quote'),
	        'deps'             => array(
		        'id'    => 'ywraq_add_privacy_checkbox',
		        'value' => 'yes',
		        'type'  => 'hide'
	        ),
        ),
        'privacy_description' => array(
	        'name'    => __( 'Request a quote Privacy Policy', 'yith-woocommerce-request-a-quote' ),
	        'desc'    =>__('You can use the shortcode [terms] and [privacy_policy] (from WooCommerce 3.4.0)'),
	        'id'      => 'ywraq_privacy_description',
	        'type'      => 'yith-field',
	        'yith-type' => 'textarea',
	        'default' => __('Your personal data will be used to process your request, support your experience throughout this website, and for other purposes described in our  [privacy_policy].', 'yith-woocommerce-request-a-quote'),
	        'deps'             => array(
		        'id'    => 'ywraq_add_privacy_checkbox',
		        'value' => 'yes',
		        'type'  => 'hide'
	        ),
        ),

        'section_form_settings_end' => array(
	        'type' => 'sectionend',
	        'id'   => 'ywraq_form_settings_end'
        ),
	)
);