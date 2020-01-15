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

if ( ! class_exists( 'YWRR_Schedule' ) ) {

	/**
	 * Implements scheduling functions for YWRR plugin
	 *
	 * @class   YWRR_Schedule
	 * @package Yithemes
	 * @since   1.0.0
	 * @author  Your Inspiration Themes
	 *
	 */
	class YWRR_Schedule {

		/**
		 * Single instance of the class
		 *
		 * @var \YWRR_Schedule
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YWRR_Schedule
		 * @since 1.0.0
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self();

			}

			return self::$instance;

		}

		/**
		 * Constructor
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function __construct() {

			if ( get_option( 'ywrr_enable_plugin' ) == 'yes' ) {

				add_action( 'woocommerce_order_status_completed', array( $this, 'schedule_mail' ) );
				add_action( 'ywrr_daily_send_mail_job', array( $this, 'daily_schedule' ) );
				add_action( 'ywrr_hourly_send_mail_job', array( $this, 'hourly_schedule' ) );

				add_action( 'trashed_post', array( $this, 'on_order_deletion' ) );
				add_action( 'after_delete_post', array( $this, 'on_order_deletion' ) );

			}

		}

		/**
		 * Create a schedule record
		 *
		 * @since   1.0.0
		 *
		 * @param   $order_id int the order id
		 * @param   $forced_list
		 *
		 * @return  boolean
		 * @author  Alberto Ruggiero
		 */
		public function schedule_mail( $order_id, $forced_list = '' ) {

			$was_quote = false;

			if ( function_exists( 'YITH_YWRAQ_Order_Request' ) ) {
				$was_quote = YITH_YWRAQ_Order_Request()->is_quote( $order_id );
			}

			$order          = wc_get_order( $order_id );
			$customer_id    = yit_get_prop( $order, '_customer_user' );
			$customer_email = yit_get_prop( $order, '_billing_email' );

			if ( YWRR_Blocklist()->check_blocklist( $customer_id, $customer_email ) != true ) {
				return __( 'This mail cannot be scheduled', 'yith-woocommerce-review-reminder' );

			}
			if ( ( ! wp_get_post_parent_id( $order_id ) || ( wp_get_post_parent_id( $order_id ) && $was_quote ) ) && $this->check_exists_schedule( $order_id ) == 0 ) {

				$forced_list = maybe_serialize( $forced_list );

				if ( $forced_list == '' ) {

					$order       = wc_get_order( $order_id );
					$list        = array();
					$is_funds    = yit_get_prop( $order, '_order_has_deposit' ) == 'yes';
					$is_deposits = yit_get_prop( $order, '_created_via' ) == 'yith_wcdp_balance_order';

					if ( ! $is_funds && ! $is_deposits ) {

						if ( defined( 'YWRR_PREMIUM' ) ) {

							$list = YWRR_Emails_Premium()->get_review_list( $order_id );

						} else {

							$list = YWRR_Emails()->get_review_list( $order_id );

						}

					}

					if ( empty( $list ) ) {
						return __( 'There are no reviewable items in this order', 'yith-woocommerce-review-reminder' );
					}

				}

				if ( YITH_WRR()->check_reviewable_items( $order_id ) == 0 && $was_quote ) {
					return __( 'There are no reviewable items in this order', 'yith-woocommerce-review-reminder' );
				}

				global $wpdb;

				$order          = wc_get_order( $order_id );
				$scheduled_date = date( 'Y-m-d', strtotime( current_time( 'mysql' ) . ' + ' . get_option( 'ywrr_mail_schedule_day' ) . ' days' ) );
				$order_date     = yit_get_prop( $order, 'date_modified' );

				if ( ! $order_date ) {
					$order_date = yit_get_prop( $order, 'date_created' );

				}

				$wpdb->insert(
					$wpdb->prefix . 'ywrr_email_schedule',
					array(
						'order_id'       => $order_id,
						'mail_status'    => 'pending',
						'scheduled_date' => $scheduled_date,
						'order_date'     => date( 'Y-m-d', yit_datetime_to_timestamp( $order_date ) ),
						'request_items'  => $forced_list
					),
					array( '%d', '%s', '%s', '%s', '%s' )
				);

				return '';
			}

			return __( 'This mail cannot be scheduled', 'yith-woocommerce-review-reminder' );

		}

		/**
		 * Checks if order has a scheduled email
		 *
		 * @since   1.0.0
		 *
		 * @param   $order_id int the order id
		 *
		 * @return  int
		 * @author  Alberto Ruggiero
		 */
		public function check_exists_schedule( $order_id ) {

			$was_quote = false;

			if ( function_exists( 'YITH_YWRAQ_Order_Request' ) ) {
				$was_quote = YITH_YWRAQ_Order_Request()->is_quote( $order_id );
			}

			if ( wp_get_post_parent_id( $order_id ) && ! $was_quote ) {
				return 0;
			}

			global $wpdb;

			$count = $wpdb->get_var( $wpdb->prepare( "
                    SELECT    COUNT(*)
                    FROM      {$wpdb->prefix}ywrr_email_schedule
                    WHERE     order_id = %d
                    ", $order_id ) );

			return $count;
		}

		/**
		 * Changes email schedule status
		 *
		 * @since   1.0.0
		 *
		 * @param   $order_id int the order id
		 * @param   $status   string the status of scheduling
		 *
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function change_schedule_status( $order_id, $status = 'cancelled' ) {

			$was_quote = false;

			if ( function_exists( 'YITH_YWRAQ_Order_Request' ) ) {
				$was_quote = YITH_YWRAQ_Order_Request()->is_quote( $order_id );
			}

			if ( wp_get_post_parent_id( $order_id ) && ! $was_quote ) {
				return;
			}

			global $wpdb;

			$wpdb->update(
				$wpdb->prefix . 'ywrr_email_schedule',
				array(
					'mail_status'   => $status,
					'request_items' => ''
				),
				array( 'order_id' => $order_id ),
				array( '%s' ),
				array( '%d' )
			);

		}

		/**
		 * Handles the daily mail sending
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function daily_schedule() {
			global $wpdb;

			$count = $wpdb->get_var( $wpdb->prepare( "
                    SELECT    COUNT(*)
                    FROM      {$wpdb->prefix}ywrr_email_schedule
                    WHERE     mail_status = 'pending' AND scheduled_date <= %s
                    ", current_time( 'mysql' ) ) );

			$number = ceil( $count / 24 );

			update_option( 'ywrr_hourly_send_number', $number );

		}

		/**
		 * Handles the hourly mail sending
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function hourly_schedule() {
			global $wpdb;

			$number = get_option( 'ywrr_hourly_send_number', 10 );
			$orders = $wpdb->get_results( $wpdb->prepare( "
							SELECT  	order_id,
										order_date,
										request_items
							FROM    	{$wpdb->prefix}ywrr_email_schedule
							WHERE		mail_status = 'pending' AND scheduled_date <= %s
							ORDER BY	id DESC
							LIMIT		{$number}
							", current_time( 'mysql' ) ) );

			foreach ( $orders as $item ) {
				$list = maybe_unserialize( $item->request_items );

				$today        = new DateTime( current_time( 'mysql' ) );
				$pay_date     = new DateTime( $item->order_date );
				$days         = $pay_date->diff( $today );
				$email_result = YWRR_Emails()->send_email( $item->order_id, $days->days, array(), $list );

				if ( $email_result ) {

					$this->change_schedule_status( $item->order_id, 'sent' );

				}

			}

		}

		/**
		 * Removes from schedule list if order is deleted
		 *
		 * @since   1.0.0
		 *
		 * @param   $post_id
		 *
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function on_order_deletion( $post_id ) {

			global $wpdb;

			$wpdb->delete(
				$wpdb->prefix . 'ywrr_email_schedule',
				array( 'order_id' => $post_id ),
				array( '%d' )
			);

		}

	}

	/**
	 * Unique access to instance of YWRR_Schedule class
	 *
	 * @return \YWRR_Schedule
	 */
	function YWRR_Schedule() {
		return YWRR_Schedule::get_instance();
	}

	new YWRR_Schedule();

}