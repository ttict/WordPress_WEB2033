<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'YWRR_Multilingual_Email' ) ) {

	/**
	 * Implements WPML for YWRR Emails
	 *
	 * @class   YWRR_Request_Mail
	 * @package Yithemes
	 * @since   1.0.0
	 * @author  Your Inspiration Themes
	 * @extends WCML_Emails
	 *
	 */
	class YWRR_Multilingual_Email extends WCML_Emails {

		private $order_id = false;


		/**
		 * Constructor
		 *
		 * Initialize multilanguage for YWRR emails
		 *
		 * @since   1.0.0
		 * @author  Alberto Ruggiero
		 */
		function __construct() {

			// Call parent constructor
			global $woocommerce_wpml, $sitepress, $woocommerce, $wpdb;

			if( version_compare(WCML_VERSION, '4.2.10', '<') ){
				parent::__construct($woocommerce_wpml, $sitepress, $woocommerce);
			}else{
				parent::__construct($woocommerce_wpml, $sitepress, $woocommerce, $wpdb);
			}
			add_filter( 'send_ywrr_mail_notification', array( $this, 'refresh_email_lang' ), 10, 1 );
			add_filter( 'wcml_send_email_order_id', array( $this, 'ywrr_send_email_order_id' ), 10, 1 );

		}

		function ywrr_send_email_order_id( $order_id ) {

			if ( $this->order_id ) {
				$order_id = $this->order_id;
			} elseif ( isset( $_REQUEST['order_id'] ) ) {
				$order_id = $_REQUEST['order_id'];
			}

			return $order_id;

		}

		/**
		 * Refresh email language
		 *
		 * @since   1.0.0
		 *
		 * @param   $args
		 *
		 * @return  array
		 * @author  Alberto Ruggiero
		 */
		function refresh_email_lang( $args ) {

			if ( isset( $args['order_id'] ) ) {
				$order_id = $args['order_id'];
			} else {
				return $args;
			}

			if ( $order_id ) {

				$this->order_id = $order_id;

				$order = wc_get_order( $order_id );
				$lang  = yit_get_prop( $order, 'wpml_language', true );

				if ( ! empty( $lang ) ) {

					global $sitepress;

					$sitepress->switch_lang( $lang, true );

				}

			}

			return $args;

		}

	}

	// returns instance of the mail on file include
	return new YWRR_Multilingual_Email();
}

