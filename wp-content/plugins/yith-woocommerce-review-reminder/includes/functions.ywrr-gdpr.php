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

add_filter( 'wp_privacy_personal_data_exporters', 'ywrr_register_scheduled_reminders_exporter' );
add_filter( 'wp_privacy_personal_data_exporters', 'ywrr_register_blocklist_exporter' );
add_filter( 'wp_privacy_personal_data_erasers', 'ywrr_register_scheduled_reminders_eraser' );
add_filter( 'wp_privacy_personal_data_erasers', 'ywrr_register_blocklist_eraser' );

/**
 * Registers the personal data exporter for scheduled reminders.
 *
 * @since   1.3.8
 *
 * @param   $exporters
 *
 * @return  array
 * @author  Alberto Ruggiero
 */
function ywrr_register_scheduled_reminders_exporter( $exporters ) {
	$exporters['ywrr-reminders'] = array(
		'exporter_friendly_name' => __( 'Review Reminders', 'yith-woocommerce-review-reminder' ),
		'callback'               => 'ywrr_scheduled_reminders_exporter',
	);

	return $exporters;
}

/**
 * Registers the personal data exporter for blocklist elements.
 *
 * @since   1.3.8
 *
 * @param   $exporters
 *
 * @return  array
 * @author  Alberto Ruggiero
 */
function ywrr_register_blocklist_exporter( $exporters ) {
	$exporters['ywrr-blocklist'] = array(
		'exporter_friendly_name' => __( 'Review Reminder Blocklist', 'yith-woocommerce-review-reminder' ),
		'callback'               => 'ywrr_blocklist_exporter',
	);

	return $exporters;
}

/**
 * Finds and exports personal data associated with an email address from the scheduled reminders table.
 *
 * @since   1.3.8
 *
 * @param   $email_address
 * @param   $page
 *
 * @return  array
 * @author  Alberto Ruggiero
 */
function ywrr_scheduled_reminders_exporter( $email_address, $page = 1 ) {
	// Limit us to 500 comments at a time to avoid timing out.
	global $wpdb;

	$number         = 500;
	$page           = (int) $page;
	$offset         = $number * ( $page - 1 );
	$data_to_export = array();
	$reminders      = $wpdb->get_results( $wpdb->prepare( "
                    SELECT    a.*
                    FROM      {$wpdb->prefix}ywrr_email_schedule a 
                    INNER JOIN {$wpdb->prefix}posts b ON a.order_id = b.ID 
                    INNER JOIN {$wpdb->prefix}postmeta c ON  b.ID = c.post_id 
                    WHERE c.meta_key='_billing_email' 
                    AND c.meta_value = %s 
                    ORDER BY  a.order_id ASC
                    LIMIT {$offset },{$number}
                    ", $email_address ) );

	$reminder_prop_to_export = array(
		'order_id'       => __( 'Order Number', 'yith-woocommerce-review-reminder' ),
		'request_items'  => __( 'Items to review', 'yith-woocommerce-review-reminder' ),
		'order_date'     => __( 'Date of Order Completed', 'yith-woocommerce-review-reminder' ),
		'scheduled_date' => __( 'E-mail Scheduled Date', 'yith-woocommerce-review-reminder' ),
		'mail_status'    => __( 'Status', 'yith-woocommerce-review-reminder' )
	);

	foreach ( (array) $reminders as $reminder ) {
		$reminder_data_to_export = array();

		foreach ( $reminder_prop_to_export as $key => $name ) {

			switch ( $key ) {
				case 'order_date':
				case 'scheduled_date':
					$value = date_i18n( get_option( 'date_format' ), strtotime( $reminder->{$key} ) );
					break;

				case 'request_items':
					$items       = maybe_unserialize( $reminder->request_items );
					$items_names = array();

					if ( ! empty( $items ) ) {
						foreach ( $items as $item ) {

							$items_names[] = $item['name'];
						}
					}

					$value = implode( ', ', $items_names );
					break;
				default:
					$value = $reminder->{$key};

			}

			if ( ! empty( $value ) ) {
				$reminder_data_to_export[] = array(
					'name'  => $name,
					'value' => $value,
				);
			}
		}
		$data_to_export[] = array(
			'group_id'    => 'ywrr_reminders',
			'group_label' => __( 'Scheduled Review Reminders', 'yith-woocommerce-review-reminder' ),
			'item_id'     => "reminder-{$reminder->id}",
			'data'        => $reminder_data_to_export,
		);

	}

	$done = count( $reminders ) < $number;

	return array(
		'data' => $data_to_export,
		'done' => $done,
	);
}

/**
 * Finds and exports personal data associated with an email address from the blocklist table.
 *
 * @since   1.3.8
 *
 * @param  $email_address
 *
 * @return  array
 * @author  Alberto Ruggiero
 */
function ywrr_blocklist_exporter( $email_address ) {
	global $wpdb;

	$data_to_export = array();
	$is_blocklist   = $wpdb->get_var( $wpdb->prepare( "
                    SELECT    COUNT(*)
                    FROM      {$wpdb->prefix}ywrr_email_blocklist 
                    WHERE customer_email = %s 
                    ", $email_address ) );

	if ( $is_blocklist ) {

		$data_to_export[] = array(
			'group_id'    => 'ywrr_blocklist',
			'group_label' => __( 'Review Reminder Status', 'yith-woocommerce-review-reminder' ),
			'item_id'     => "blocklist-0",
			'data'        => array(
				array(
					'name'  => __( 'Blocklist', 'yith-woocommerce-review-reminder' ),
					'value' => __( 'This customer doesn\'t want to receive any more review requests', 'yith-woocommerce-review-reminder' ),
				)
			),
		);

	}

	return array(
		'data' => $data_to_export,
		'done' => true,
	);
}

/**
 * Registers the personal data eraser for scheduled reminders.
 *
 * @since   1.3.8
 *
 * @param   $erasers
 *
 * @return  array
 * @author  Alberto Ruggiero
 */
function ywrr_register_scheduled_reminders_eraser( $erasers ) {
	$erasers['ywrr-reminders'] = array(
		'eraser_friendly_name' => __( 'Review Reminders', 'yith-woocommerce-review-reminder' ),
		'callback'             => 'ywrr_scheduled_reminders_eraser',
	);

	return $erasers;
}

/**
 * Erases personal data associated with an email address from the scheduled reminders table.
 *
 * @since 1.3.8
 *
 * @param  $email_address
 * @param  $page
 *
 * @return array
 */
function ywrr_scheduled_reminders_eraser( $email_address, $page = 1 ) {
	global $wpdb;

	if ( empty( $email_address ) ) {
		return array(
			'items_removed'  => false,
			'items_retained' => false,
			'messages'       => array(),
			'done'           => true,
		);
	}

	// Limit us to 500 comments at a time to avoid timing out.
	$number        = 500;
	$page          = (int) $page;
	$offset        = $number * ( $page - 1 );
	$items_removed = false;
	$reminders     = $wpdb->get_col( $wpdb->prepare( "
                    SELECT    a.id
                    FROM      {$wpdb->prefix}ywrr_email_schedule a 
                    INNER JOIN {$wpdb->prefix}posts b ON a.order_id = b.ID 
                    INNER JOIN {$wpdb->prefix}postmeta c ON  b.ID = c.post_id 
                    WHERE c.meta_key='_billing_email' 
                    AND c.meta_value = %s 
                    ORDER BY  a.order_id ASC
                    LIMIT {$offset },{$number}
                    ", $email_address ) );

	if ( ! empty( $reminders ) ) {

		$items_removed = true;

		foreach ( $reminders as $reminder ) {
			$wpdb->delete(
				$wpdb->prefix . 'ywrr_email_schedule',
				array( 'id' => $reminder ),
				array( '%d' )
			);
		}

	}

	$done = count( $reminders ) < $number;

	return array(
		'items_removed'  => $items_removed,
		'items_retained' => false,
		'messages'       => array(),
		'done'           => $done,
	);
}

/**
 * Registers the personal data eraser for scheduled reminders.
 *
 * @since   1.3.8
 *
 * @param   $erasers
 *
 * @return  array
 * @author  Alberto Ruggiero
 */
function ywrr_register_blocklist_eraser( $erasers ) {
	$erasers['ywrr-blocklist'] = array(
		'eraser_friendly_name' => __( 'Review Reminder Blocklist', 'yith-woocommerce-review-reminder' ),
		'callback'             => 'ywrr_blocklist_eraser',
	);

	return $erasers;
}

/**
 * Erases personal data associated with an email address from the blocklist table.
 *
 * @since 1.3.8
 *
 * @param  $email_address
 *
 * @return array
 */
function ywrr_blocklist_eraser( $email_address ) {
	global $wpdb;

	if ( empty( $email_address ) ) {
		return array(
			'items_removed'  => false,
			'items_retained' => false,
			'messages'       => array(),
			'done'           => true,
		);
	}

	// Limit us to 500 comments at a time to avoid timing out.
	$items_removed = false;

	$deleted = $wpdb->delete(
		$wpdb->prefix . 'ywrr_email_blocklist',
		array( 'customer_email' => $email_address ),
		array( '%s' )
	);

	if ( $deleted > 0 ) {

		$items_removed = true;

	}

	return array(
		'items_removed'  => $items_removed,
		'items_retained' => false,
		'messages'       => array(),
		'done'           => true,
	);
}