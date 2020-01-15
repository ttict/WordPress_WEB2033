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

if ( ! class_exists( 'YWRR_Review_Reminder' ) ) {

	/**
	 * Implements features of YWRR plugin
	 *
	 * @class   YWRR_Review_Reminder
	 * @package Yithemes
	 * @since   1.0.0
	 * @author  Your Inspiration Themes
	 */
	class YWRR_Review_Reminder {

		/**
		 * Panel object
		 *
		 * @var     /Yit_Plugin_Panel object
		 * @since   1.0.0
		 * @see     plugin-fw/lib/yit-plugin-panel.php
		 */
		protected $_panel;

		/**
		 * @var $_premium string Premium tab template file name
		 */
		protected $_premium = 'premium.php';

		/**
		 * @var string Premium version landing link
		 */
		protected $_premium_landing = 'https://yithemes.com/themes/plugins/yith-woocommerce-review-reminder/';

		/**
		 * @var string Plugin official documentation
		 */
		protected $_official_documentation = 'https://docs.yithemes.com/yith-woocommerce-review-reminder/';

		/**
		 * @var string Yith WooCommerce Review Reminder panel page
		 */
		protected $_panel_page = 'yith_ywrr_panel';

		/**
		 * @var array
		 */
		protected $_email_types = array();

		/**
		 * @var array
		 */
		var $_email_templates = array();

		/**
		 * Single instance of the class
		 *
		 * @var \YWRR_Review_Reminder
		 * @since 1.1.5
		 */
		protected static $instance;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YWRR_Review_Reminder
		 * @since 1.1.5
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {

				self::$instance = new self;

			}

			return self::$instance;

		}

		/**
		 * Constructor
		 *
		 * Initialize plugin and registers actions and filters to be used
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function __construct() {

			if ( ! function_exists( 'WC' ) ) {
				return;
			}

			$this->_email_types = array(
				'request' => array(
					'class' => 'YWRR_Request_Mail',
					'file'  => 'class-ywrr-request-email.php',
				),
			);

			// Load Plugin Framework
			add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 12 );
			add_action( 'plugins_loaded', array( $this, 'include_privacy_text' ), 20 );

			//Add action links
			add_filter( 'plugin_action_links_' . plugin_basename( YWRR_DIR . '/' . basename( YWRR_FILE ) ), array( $this, 'action_links' ) );
			add_filter( 'yith_show_plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 5 );

			// Include required files

			add_action( 'init', array( $this, 'init_crons' ) );
			add_action( 'init', array( $this, 'includes' ), 15 );
			add_action( 'init', array( $this, 'init_blocklist' ), 16 );

			//  Add stylesheets and scripts files
			add_action( 'admin_menu', array( $this, 'add_menu_page' ), 5 );
			add_action( 'yith_review_reminder_premium', array( $this, 'premium_tab' ) );

			if ( is_admin() ) {

				add_action( 'admin_enqueue_scripts', array( $this, 'ywrr_admin_scripts' ) );
				add_action( 'ywrr_howto', array( $this, 'get_howto_content' ) );

			}

			add_filter( 'woocommerce_email_classes', array( $this, 'ywrr_custom_email' ) );
			add_action( 'woocommerce_init', array( $this, 'load_wc_mailer' ) );

			add_option( 'ywrr_mail_schedule_day', 7 );
			add_option( 'ywrr_mail_template', 'base' );

			add_action( 'ywrr_email_header', array( $this, 'ywrr_email_header' ), 10, 2 );
			add_action( 'ywrr_email_footer', array( $this, 'ywrr_email_footer' ), 10, 3 );

			if ( get_option( 'ywrr_enable_plugin' ) == 'yes' ) {

				if ( get_option( 'ywrr_refuse_requests' ) == 'yes' ) {

					add_action( 'woocommerce_after_checkout_billing_form', array( $this, 'ywrr_show_request_option' ) );
					add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'ywrr_save_request_option' ) );
					add_action( 'woocommerce_edit_account_form', array( $this, 'ywrr_show_request_option_my_account' ) );
					add_action( 'woocommerce_save_account_details', array( $this, 'ywrr_save_request_option_my_account' ) );

				}

			}

		}

		/**
		 * Cron initialization
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function init_crons() {
			$ve = get_option( 'gmt_offset' ) > 0 ? '+' : '-';

			if ( ! wp_next_scheduled( 'ywrr_daily_send_mail_job' ) ) {
				wp_schedule_event( strtotime( '00:00 ' . $ve . get_option( 'gmt_offset' ) . ' HOURS' ), 'daily', 'ywrr_daily_send_mail_job' );
			}

			if ( ! wp_next_scheduled( 'ywrr_hourly_send_mail_job' ) ) {
				wp_schedule_event( strtotime( '00:00 ' . $ve . get_option( 'gmt_offset' ) . ' HOURS' ), 'hourly', 'ywrr_hourly_send_mail_job' );
			}
		}

		/**
		 * Files inclusion
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function includes() {

			include_once( 'includes/class-ywrr-unsubscribe.php' );
			include_once( 'includes/class-ywrr-emails.php' );
			include_once( 'includes/class-ywrr-blocklist.php' );
			include_once( 'includes/class-ywrr-schedule.php' );
			include_once( 'includes/functions.ywrr-gdpr.php' );
			include_once( 'includes/admin/class-ywrr-ajax.php' );

			if ( is_admin() ) {
				include_once( 'includes/admin/class-yith-custom-table.php' );
				include_once( 'templates/admin/class-yith-wc-custom-textarea.php' );
				include_once( 'templates/admin/class-ywrr-custom-send.php' );
				include_once( 'templates/admin/blocklist-table.php' );
			}

			$is_wpml_configured = apply_filters( 'wpml_setting', false, 'setup_complete' );
			if ( $is_wpml_configured && defined( 'WCML_VERSION' ) ) {
				require_once( 'includes/emails/class.ywrr-multilingual-email.php' );
			}

		}

		/**
		 * Blocklist initialization
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function init_blocklist() {
			if ( is_admin() ) {
				add_action( 'ywrr_blocklist', array( YWRR_Blocklist_Table(), 'output' ) );
			}
		}

		/**
		 * Initializes Javascript with localization
		 *
		 * @since   1.1.5
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_admin_scripts() {
			global $post;

			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_enqueue_style( 'ywrr-admin', YWRR_ASSETS_URL . 'css/ywrr-admin' . $suffix . '.css' );

			wp_enqueue_script( 'ywrr-admin', YWRR_ASSETS_URL . 'js/ywrr-admin' . $suffix . '.js' );

			$params = apply_filters( 'ywrr_admin_scripts_filter', array(
				'ajax_url'               => admin_url( 'admin-ajax.php' ),
				'after_send_test_email'  => __( 'Test email has been sent successfully!', 'yith-woocommerce-review-reminder' ),
				'test_mail_wrong'        => __( 'Please insert a valid email address', 'yith-woocommerce-review-reminder' ),
				'before_send_test_email' => __( 'Sending test email...', 'yith-woocommerce-review-reminder' ),
			), $post );

			wp_localize_script( 'ywrr-admin', 'ywrr_admin', $params );

		}

		/**
		 * Get placeholder reference content.
		 *
		 * @since   1.1.5
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function get_howto_content() {

			?>
            <div id="plugin-fw-wc">
                <h3>
					<?php _e( 'Placeholder reference', 'yith-woocommerce-review-reminder' ); ?>
                </h3>
                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{customer_name}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with the customer\'s name', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{customer_email}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with the customer\'s email', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{site_title}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with the site title', 'yith-woocommerce-review-reminder' ); ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{order_id}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with the order ID', 'yith-woocommerce-review-reminder' ); ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{order_date}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with the date and time of the order', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{order_date_completed}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with the date the order was marked completed', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{order_list}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with a list of products purchased but not reviewed (Do not forget it!!!)', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{days_ago}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with the days ago the order was made', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{unsubscribe_link}</b>
                        </th>
                        <td class="forminp">
							<?php _e( 'Replaced with the link to the unsubscribe page (If you use standard WooCommerce template, do not forget it!)', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
			<?php
		}

		/**
		 * Get the email header.
		 *
		 * @since   1.0.0
		 *
		 * @param   $email_heading
		 * @param   $template
		 *
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_email_header( $email_heading, $template = false ) {

			if ( ! $template ) {
				$template = get_option( 'ywrr_mail_template' );
			}

			if ( array_key_exists( $template, $this->_email_templates ) ) {

				$path   = $this->_email_templates[ $template ]['path'];
				$folder = $this->_email_templates[ $template ]['folder'];

				wc_get_template( $folder . '/email-header.php', array( 'email_heading' => $email_heading ), '', $path );

			} else {

				wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading, 'mail_type' => 'yith-review-reminder' ) );

			}

		}

		/**
		 * Get the email footer.
		 *
		 * @since   1.0.0
		 *
		 * @param   $unsubscribe_url
		 * @param   $template
		 * @param   $unsubscribe_text
		 *
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_email_footer( $unsubscribe_url, $template = false, $unsubscribe_text ) {

			if ( ! $template ) {
				$template = get_option( 'ywrr_mail_template' );
			}

			if ( array_key_exists( $template, $this->_email_templates ) ) {

				$path   = $this->_email_templates[ $template ]['path'];
				$folder = $this->_email_templates[ $template ]['folder'];

				wc_get_template( $folder . '/email-footer.php', array( 'unsubscribe_url' => $unsubscribe_url, 'unsubscribe_text' => $unsubscribe_text ), '', $path );

			} else {

				wc_get_template( 'emails/email-footer.php', array( 'mail_type' => 'yith-review-reminder' ) );

			}

		}

		/**
		 * Set the list item for the selected template.
		 *
		 * @since   1.0.0
		 *
		 * @param   $item_list
		 * @param   $template
		 *
		 * @return  string
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_email_items_list( $item_list, $template = false ) {

			if ( defined( 'YWRR_PREMIUM' ) && YWRR_PREMIUM ) {

				$style = wc_get_template_html( 'emails/email-items-list-premium.php', array( 'item_list' => $item_list ), '', YWRR_TEMPLATE_PATH );

			} else {

				$style = wc_get_template_html( 'emails/email-items-list.php', array( 'item_list' => $item_list ), '', YWRR_TEMPLATE_PATH );

			}

			return $style;

		}

		/**
		 * ADMIN FUNCTIONS
		 */

		/**
		 * Add a panel under YITH Plugins tab
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 * @use     /Yit_Plugin_Panel class
		 * @see     plugin-fw/lib/yit-plugin-panel.php
		 */
		public function add_menu_page() {

			if ( ! empty( $this->_panel ) ) {
				return;
			}

			$admin_tabs = array();

			if ( defined( 'YWRR_PREMIUM' ) && YWRR_PREMIUM ) {

				$admin_tabs['premium-mail'] = __( 'Mail Settings', 'yith-woocommerce-review-reminder' );
				$admin_tabs['settings']     = __( 'Request Settings', 'yith-woocommerce-review-reminder' );
				$admin_tabs['mandrill']     = __( 'Mandrill Settings', 'yith-woocommerce-review-reminder' );
				$admin_tabs['schedule']     = __( 'Schedule List', 'yith-woocommerce-review-reminder' );

			} else {

				$admin_tabs['mail'] = __( 'Mail Settings', 'yith-woocommerce-review-reminder' );

			}

			$admin_tabs['blocklist'] = __( 'Blocklist', 'yith-woocommerce-review-reminder' );
			$admin_tabs['howto']     = __( 'How-To', 'yith-woocommerce-review-reminder' );

			if ( ! defined( 'YWRR_PREMIUM' ) || ! YWRR_PREMIUM ) {

				$admin_tabs['premium-landing'] = __( 'Premium Version', 'yith-woocommerce-review-reminder' );

			}

			$args = array(
				'create_menu_page' => true,
				'parent_slug'      => '',
				'page_title'       => __( 'Review Reminder', 'yith-woocommerce-review-reminder' ),
				'menu_title'       => 'Review Reminder',
				'capability'       => 'manage_options',
				'parent'           => '',
				'parent_page'      => 'yit_plugin_panel',
				'page'             => $this->_panel_page,
				'admin-tabs'       => $admin_tabs,
				'options-path'     => YWRR_DIR . '/plugin-options'
			);

			$this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
		}


		/**
		 * Add the YWRR_Request_Mail class to WooCommerce mail classes
		 *
		 * @since   1.0.0
		 *
		 * @param   $email_classes
		 *
		 * @return  array
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_custom_email( $email_classes ) {

			foreach ( $this->_email_types as $type => $email_type ) {
				$email_classes[ $email_type['class'] ] = include( "includes/emails/{$email_type['file']}" );
			}

			return $email_classes;
		}

		/**
		 * Hook the mailer functions
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function load_wc_mailer() {

			add_filter( 'send_ywrr_mail', array( $this, 'send_transactional_email' ), 10, 1 );

		}

		/**
		 * Instantiate WC_Emails instance and send transactional emails
		 *
		 * @since   1.0.0
		 *
		 * @param   $args
		 *
		 * @return  bool
		 * @author  Alberto Ruggiero
		 */
		public function send_transactional_email( $args = array() ) {

			try {

				WC_Emails::instance(); // Init self so emails exist.

				return apply_filters( 'send_ywrr_mail_notification', $args );

			} catch ( Exception $e ) {

				if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
					trigger_error( 'Transactional email triggered fatal error for callback ' . current_filter(), E_USER_WARNING );
				}

				return false;
			}

		}

		/**
		 * Check if order has reviewable items
		 *
		 * @since   1.2.7
		 *
		 * @param   $post_id
		 *
		 * @return  int
		 * @author  Alberto Ruggiero
		 */
		public function check_reviewable_items( $post_id ) {

			$order            = wc_get_order( $post_id );
			$order_items      = $order->get_items();
			$reviewable_items = 0;

			foreach ( $order_items as $item ) {

				if ( ! YWRR_Emails()->items_has_comments_closed( $item['product_id'] ) ) {

					$reviewable_items ++;

				}

			}

			return $reviewable_items;

		}

		/**
		 * FRONTEND FUNCTIONS
		 */


		/**
		 * Format email date
		 *
		 * @since   1.2.3
		 *
		 * @param   $date
		 *
		 * @return  string
		 * @author  Alberto Ruggiero
		 */
		public function format_date( $date ) {

			/**
			 * Y = YEAR
			 * m = month
			 * d = day
			 * H = hour
			 * i = minutes
			 * s = seconds
			 */

			$date_format = apply_filters( 'ywrr_custom_date_format', 'Y-m-d H:i:s' );
			$date_time   = new DateTime( $date );

			return $date_time->format( $date_format );

		}

		/**
		 * Show email request checkbox in checkout page
		 *
		 * @since   1.2.6
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_show_request_option() {

			if ( ! YWRR_Blocklist()->check_blocklist( get_current_user_id(), '' ) ) {
				return;
			}

			$label = apply_filters( 'ywrr_checkout_option_label', __( 'I accept to receive review requests via email', 'yith-woocommerce-review-reminder' ) ); //@since 1.2.6

			if ( ! empty( $label ) ) {

				woocommerce_form_field( 'ywrr_receive_requests', array(
					'type'  => 'checkbox',
					'class' => array( 'form-row-wide' ),
					'label' => $label,
				), 0 );

			}

		}

		/**
		 * Save email request checkbox in checkout page
		 *
		 * @since   1.2.6
		 *
		 * @param   $order_id
		 *
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_save_request_option( $order_id ) {

			if ( empty( $_POST['ywrr_receive_requests'] ) && isset( $_POST['billing_email'] ) && $_POST['billing_email'] != '' ) {

				YWRR_Blocklist()->add_to_blocklist( get_current_user_id(), $_POST['billing_email'] );

			}

		}

		/**
		 * Add customer request option to edit account page
		 *
		 * @since   1.2.6
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_show_request_option_my_account() {

			$label = apply_filters( 'ywrr_checkout_option_label', __( 'I accept to receive review requests via email', 'yith-woocommerce-review-reminder' ) ); //@since 1.2.6

			?>

            <p class="form-row form-row-wide">

                <label for="ywrr_receive_requests">
                    <input
                        name="ywrr_receive_requests"
                        type="checkbox"
                        class=""
                        value="1"
						<?php checked( YWRR_Blocklist()->check_blocklist( get_current_user_id(), '' ) ); ?>
                    /> <?php echo $label ?>
                </label>

            </p>

			<?php

		}

		/**
		 * Save customer request option from edit account page
		 *
		 * @since   1.2.6
		 *
		 * @param   $customer_id
		 *
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function ywrr_save_request_option_my_account( $customer_id ) {

			if ( isset( $_POST['billing_email'] ) && $_POST['billing_email'] != '' ) {

				if ( isset( $_POST['ywrr_receive_requests'] ) ) {

					YWRR_Blocklist()->remove_from_blocklist( $customer_id );

				} else {

					$email = get_user_meta( $customer_id, 'billing_email' );

					YWRR_Blocklist()->add_to_blocklist( $customer_id, $email );

				}

			}

		}

		/**
		 * YITH FRAMEWORK
		 */

		/**
		 * Load plugin framework
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
				global $plugin_fw_data;
				if ( ! empty( $plugin_fw_data ) ) {
					$plugin_fw_file = array_shift( $plugin_fw_data );
					require_once( $plugin_fw_file );
				}
			}
		}

		/**
		 * Premium Tab Template
		 *
		 * Load the premium tab template on admin page
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function premium_tab() {
			$premium_tab_template = YWRR_TEMPLATE_PATH . '/admin/' . $this->_premium;
			if ( file_exists( $premium_tab_template ) ) {
				include_once( $premium_tab_template );
			}
		}

		/**
		 * Action Links
		 *
		 * add the action links to plugin admin page
		 * @since   1.0.0
		 *
		 * @param   $links | links plugin array
		 *
		 * @return  mixed
		 * @author  Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use     plugin_action_links_{$plugin_file_name}
		 */
		public function action_links( $links ) {

			$links = yith_add_action_links( $links, $this->_panel_page, false );

			return $links;

		}

		/**
		 * Plugin row meta
		 *
		 * add the action links to plugin admin page
		 *
		 * @since   1.0.0
		 *
		 * @param   $plugin_meta
		 * @param   $plugin_file
		 * @param   $plugin_data
		 * @param   $status
		 * @param   $init_file
		 *
		 * @return  array
		 * @author  Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use     plugin_row_meta
		 */
		public function plugin_row_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status, $init_file = 'YWRR_FREE_INIT' ) {

			if ( defined( $init_file ) && constant( $init_file ) == $plugin_file ) {
				$new_row_meta_args['slug'] = YWRR_SLUG;
			}

			return $new_row_meta_args;

		}

		/**
		 * Get the premium landing uri
		 *
		 * @since   1.0.0
		 * @return  string
		 * @author  Alberto Ruggiero
		 */
		public function get_premium_landing_uri() {
			return $this->_premium_landing;
		}

		/**
		 * Register privacy text
		 *
		 * @since   1.0.0
		 * @return  void
		 * @author  Alberto Ruggiero
		 */
		public function include_privacy_text() {
			include_once( 'includes/class-ywrr-privacy.php' );
		}

	}

}