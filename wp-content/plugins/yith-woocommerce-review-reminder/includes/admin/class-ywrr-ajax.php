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
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'YWRR_Ajax' ) ) {

	/**
	 * Implements AJAX for YWRR plugin
	 *
	 * @class   YWRR_Ajax
	 * @package Yithemes
	 * @since   1.1.5
	 * @author  Your Inspiration Themes
	 *
	 */
	class YWRR_Ajax {

		/**
		 * Constructor
		 *
		 * @since   1.1.5
		 * @return  mixed
		 * @author  Alberto Ruggiero
		 */
		public function __construct() {

			add_action( 'wp_ajax_ywrr_send_test_mail', array( $this, 'send_test_mail' ) );
			add_action( 'wp_ajax_ywrr_unsubscribe', array( $this, 'ywrr_unsubscribe' ) );
			add_action( 'wp_ajax_nopriv_ywrr_unsubscribe', array( $this, 'ywrr_unsubscribe' ) );

		}

		/**
		 * Send a test mail from option panel
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function send_test_mail() {
			ob_start();

			$total_products = wp_count_posts( 'product' );

			if ( ! $total_products->publish ) {

				wp_send_json( array( 'error' => __( 'In order to send the test email, at least one product has to be published', 'yith-woocommerce-review-reminder' ) ) );

			} else {

				$args = array(
					'posts_per_page' => 2,
					'orderby'        => 'rand',
					'post_type'      => 'product'
				);

				$random_products = get_posts( $args );

				$test_items = array();

				foreach ( $random_products as $item ) {

					$test_items[ $item->ID ]['id']   = $item->ID;
					$test_items[ $item->ID ]['name'] = $item->post_title;

				}

				$days       = get_option( 'ywrr_mail_schedule_day' );
				$test_email = $_POST['email'];
				$template   = $_POST['template'];

				try {

					$mail_args = array(
						'order_id'   => 0,
						'item_list'  => $test_items,
						'days_ago'   => $days,
						'test_email' => $test_email,
						'template'   => $template,
					);

					$mail_result = apply_filters( 'send_ywrr_mail', $mail_args );

					if ( ! $mail_result ) {

						wp_send_json( array( 'error' => __( 'There was an error while sending the email', 'yith-woocommerce-review-reminder' ) ) );

					} else {

						wp_send_json( true );

					}

				} catch ( Exception $e ) {

					wp_send_json( array( 'error' => $e->getMessage() ) );

				}

			}

		}

		/**
		 * Handles the unsubscribe form
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_unsubscribe() {

			$response = array(
				'status' => 'failure'
			);

			$customer_id    = ! empty( $_POST['user_id'] ) ? $_POST['user_id'] : 0;
			$customer_email = ! empty( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';

			if ( empty( $customer_email ) || ! is_email( $customer_email ) ) {
				wc_add_notice( __( 'Please provide a valid email address.', 'yith-woocommerce-review-reminder' ), 'error' );
			} elseif ( $customer_email !== urldecode( base64_decode( $_POST['email_hash'] ) ) ) {
				wc_add_notice( __( 'Please retype the email address as provided.', 'yith-woocommerce-review-reminder' ), 'error' );
			} else {
				if ( true == YWRR_Blocklist()->check_blocklist( $customer_id, $customer_email ) ) {

					try {
						YWRR_Blocklist()->add_to_blocklist( $customer_id, $customer_email );
						wc_add_notice( __( 'Unsubscribe was successful.', 'yith-woocommerce-review-reminder' ) );
						$response['status'] = 'success';

					} catch ( Exception $e ) {

						wc_add_notice( __( 'An error has occurred', 'yith-woocommerce-review-reminder' ), 'error' );

					}

				} else {
					wc_add_notice( __( 'You have already unsubscribed', 'yith-woocommerce-review-reminder' ), 'error' );
				}
			}

			ob_start();
			wc_print_notices();
			$response['messages'] = ob_get_clean();

			echo '<!--WC_START-->' . json_encode( $response ) . '<!--WC_END-->';

			exit;

		}

	}

	new YWRR_Ajax();

}

