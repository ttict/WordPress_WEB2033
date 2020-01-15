<?php
/**
 * Main class
 *
 * @author YITH
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */


if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCWTL' ) ) {
	/**
	 * YITH WooCommerce Waiting List
	 *
	 * @since 1.0.0
	 */
	class YITH_WCWTL {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCWTL
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WCWTL_VERSION;


		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCWTL
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			$enable = get_option( 'yith-wcwtl-enable' ) == 'yes';

			// Load Plugin Framework
			add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );

			// Class admin
			if ( $this->is_admin() ) {

			    // required class
				include_once( 'class.yith-wcwtl-admin.php' );
				include_once( 'class.yith-wcwtl-meta.php' );
				
				YITH_WCWTL_Admin();
				// add meta in product edit page
				if( $enable ) {
					YITH_WCWTL_Meta();
				}
			}
			elseif( $this->load_frontend() ) {

			    // required class
				include_once( 'class.yith-wcwtl-frontend.php' );

				// Class frontend
				YITH_WCWTL_Frontend();
			}

			// Email actions
			add_filter( 'woocommerce_email_classes', array( $this, 'add_woocommerce_emails' ) );
			add_action( 'woocommerce_init', array( $this, 'load_wc_mailer' ) );

            // gdpr actions
            add_filter( 'wp_privacy_personal_data_exporters', array( $this, 'register_exporters' ) );
            add_filter( 'wp_privacy_personal_data_erasers', array( $this, 'register_erasers' ) );
		}

		/**
		 * Load Plugin Framework
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 * @author Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if( ! empty( $plugin_fw_data ) ){
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file );
                }
		    }
		}

        /**
         * Check if is admin
         *
         * @since 1.1.0
         * @access public
         * @author Francesco Licandro
         * @return boolean
         */
        public function is_admin(){
            $context_check = isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend';
            $actions_to_check = apply_filters( 'yith_wcwtl_actions_to_check_admin', array(
                'jckqv'
            ) );
            $action_check  = isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], $actions_to_check );
            $is_admin = is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX && ( $context_check || $action_check ) );

	        return apply_filters( 'yith_wcwtl_check_is_admin', $is_admin );
        }

		/**
		 * Check to load frontend class
		 *
		 * @since 1.2.0
		 * @author Francesco Licandro
		 * @return boolean
		 */
		public function load_frontend(){
			return apply_filters( 'yith_wcwtl_check_load_frontend', get_option( 'yith-wcwtl-enable' ) == 'yes' );
        }

		/**
		 * Filters woocommerce available mails, to add waitlist related ones
		 *
		 * @param $emails array
		 *
		 * @return array
		 * @since 1.0
		 */
		public function add_woocommerce_emails( $emails ) {
			$emails['YITH_WCWTL_Mail_Instock'] = include( 'email/class.yith-wcwtl-mail-instock.php' );
			return $emails;
		}

		/**
		 * Loads WC Mailer when needed
		 *
		 * @return void
		 * @since 1.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.it>
		 */
		public function load_wc_mailer() {
			add_action( 'send_yith_waitlist_mail_instock', array( 'WC_Emails', 'send_transactional_email' ), 10, 2 );
		}

        /**
         * Get customer products subscription list
         *
         * @return array
         * @since 1.3.0
         * @author Francesco Licandro
         * @param string $user_email
         */
        protected static function get_customer_products_list( $user_email ) {
            global $wpdb;

            $products_list = array();
            // get all products list
            $q = $wpdb->prepare( "SELECT post_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key = '%s' AND meta_value NOT LIKE 'a:0{}'", array( YITH_WCWTL_META ) );
            $products_list_encoded = $wpdb->get_results( $q, ARRAY_A );
            foreach( $products_list_encoded as $list ){
                $waitlist = maybe_unserialize( $list['meta_value'] );
                if( ! in_array( $user_email, $waitlist ) ){
                    continue;
                }
                $products_list[] = $list['post_id'];
            }

            return $products_list;
        }

        /**
         * Register exporter for GDPR compliance
         *
         * @since 1.5.0
         * @author Francesco Licandro
         * @param array $exporters List of exporter callbacks.
         * @return array
         */
        public function register_exporters( $exporters = array() ){
            $exporters['yith-wcwtl-customer-data'] = array(
                'exporter_friendly_name'    => __( 'Waiting List Data', 'yith-woocommerce-waiting-list' ),
                'callback'                  => array( 'YITH_WCWTL', 'customer_data_exporter' )
            );

            return $exporters;
        }

        /**
         * GDPR exporter callback
         *
         * @since 1.5.0
         * @author Francesco Licandro
         * @param string $email_address The user email address.
         * @param int    $page  Page.
         * @return array
         */
        public static function customer_data_exporter( $email_address, $page ){
            $user           = get_user_by( 'email', $email_address );
            $data_to_export = array();
            $products_list  = array();
            // get products list if any
            if( $user instanceof WP_User ){
                $products_list = self::get_customer_products_list( $email_address );

                if( ! empty( $products_list ) ) {
                    $products = array();
                    foreach( $products_list as $product_id ){
                        $product = wc_get_product( $product_id );
                        $product && $products[] = $product->get_name();
                    }

                    $data_to_export[] = array(
                        'group_id'    => 'yith_wcwtl_data',
                        'group_label' => __( 'Waiting List Data', 'yith-woocommerce-waiting-list' ),
                        'item_id'     => 'waiting-list',
                        'data'        => array(
                            array(
                                'name'  => __( 'Waiting List Subscriptions', 'yith-woocommerce-waiting-list' ),
                                'value' => implode( ', ', $products ),
                            )
                        )
                    );
                }
            }

            return array(
                'data' => $data_to_export,
                'done' => true,
            );
        }

        /**
         * Register ereaser for GDPR compliance
         *
         * @since 1.5.0
         * @author Francesco Licandro
         * @param array $erasers List of erasers callbacks.
         * @return array
         */
        public function register_erasers( $erasers = array() ){
            $erasers['yith-wcwtl-customer-data'] = array(
                'eraser_friendly_name'    => __( 'Waiting List Data', 'yith-woocommerce-waiting-list' ),
                'callback'                => array( 'YITH_WCWTL', 'customer_data_ereaser' )
            );

            return $erasers;
        }

        /**
         * GDPR ereaser callback
         *
         * @since 1.5.0
         * @author Francesco Licandro
         * @param string $user_email The user email
         * @param int $page
         * @return array
         */
        public static function customer_data_ereaser( $user_email, $page ) {
            $response = array(
                'items_removed'  => false,
                'items_retained' => false,
                'messages'       => array(),
                'done'           => true,
            );

            $user = get_user_by( 'email', $user_email ); // Check if user has an ID in the DB to load stored personal data.
            if ( ! $user instanceof WP_User ) {
                return $response;
            }

            $products_list = self::get_customer_products_list( $user_email );
            foreach( $products_list as $product_id ){
                $product = wc_get_product( $product_id );
                if( $product && yith_waitlist_unregister_user( $user_email, $product ) ){
                    $response['messages'][]    = sprintf( __( 'Removed customer from waiting list for "%s"', 'woocommerce' ), $product->get_name() );
                    $response['items_removed'] = true;
                }
            }

            return $response;
        }
	}
}

/**
 * Unique access to instance of YITH_WCWTL class
 *
 * @return \YITH_WCWTL
 * @since 1.0.0
 */
function YITH_WCWTL(){
	return YITH_WCWTL::get_instance();
}