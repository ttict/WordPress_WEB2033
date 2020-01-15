<?php
/**
 * Frontend class
 *
 * @author YITH
 * @package YITH WooCommerce Waiting List
 * @version 1.1.1
 */

if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if( ! class_exists( 'YITH_WCWTL_Frontend' ) ) {
	/**
	 * Frontend class.
	 * The class manage all the Frontend behaviors.
	 *
	 * @since 1.0.0
	 */
	class YITH_WCWTL_Frontend {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCWTL_Frontend
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
         * Frontend script was enqueued
         *
         * @var boolean
         * @since 1.0.0
         */
        public $scripts_enqueued = false;

		/**
		 * Current object product
		 *
		 * @var object
		 * @since 1.0.0
		 */
		protected $current_product = false;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCWTL_Frontend
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
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct() {

			// add form
			add_action( 'woocommerce_before_single_product', array( $this, 'add_form' ) );
            // add form on quick view
			add_action( 'jck_qv_summary', array( $this, 'add_form' ) );
			add_action( 'yith_wcqv_before_product_summary', array( $this, 'add_form' ) );
            // add form on get variation AJAX call
            add_action( 'init', array( $this, 'add_form_ajax' ) );

			add_action( 'template_redirect', array( $this, 'yith_waiting_submit' ), 100 );

			// enqueue frontend js
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );

            // shortcode for print form
            add_shortcode( 'ywcwtl_form', array( $this, 'shortcode_form' ) );
		}

		/**
		 * Register scripts frontend
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function register_scripts(){
			$min = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';
			wp_register_script( 'yith-wcwtl-frontend', YITH_WCWTL_ASSETS_URL . '/js/frontend'.$min.'.js', array( 'jquery'), YITH_WCWTL_VERSION, true );
			wp_register_style( 'yith-wcwtl-frontend', YITH_WCWTL_ASSETS_URL . '/css/ywcwtl.css', array(), YITH_WCWTL_VERSION, 'all' );

			$this->enqueue_scripts();
		}

		/**
		 * Enqueue scripts and style
		 *
		 * @since 1.0.8
		 * @access public
		 * @author Francesco Licandro
		 */
		public function enqueue_scripts() {
            if( ! $this->scripts_enqueued ) {
                wp_enqueue_script('yith-wcwtl-frontend');
                wp_enqueue_style('yith-wcwtl-frontend');

                // all scripts enqueued
                $this->scripts_enqueued = true;
            }
		}

        /**
         * Check if the product can have the waitlist form
         *
         * @since 1.1.3
         * @param object $product WC Product The product to check
         * @return boolean
         * @author Francesco Licandro
         */
        public function can_have_waitlist( $product ){

            $return = ! ( ! $product->is_type( array( 'simple', 'variable', 'variation' ) ) || $product->is_in_stock() );

            // can third part filter this result
            return apply_filters( 'yith_wcwtl_can_product_have_waitlist', $return, $product );
        }

		/**
		 * Add form to stock html
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function add_form(){
			global $post;

			if( get_post_type( $post->ID ) == 'product' && is_product() || $this->is_quick_view() ) {

				$this->current_product = wc_get_product( $post->ID );

                if( ! $this->current_product ) {
                    return;
                }

				// check for WooCommerce 3.0.0
				if( function_exists( 'wc_get_stock_html' ) ) {
					add_filter( 'woocommerce_get_stock_html', array( $this, 'output_form_3_0'), 20, 2 );
				}
				else {
					if ($this->current_product->is_type('variable')) {
						add_action('woocommerce_stock_html', array($this, 'output_form'), 20, 3);
					} else {
						add_action('woocommerce_stock_html', array($this, 'output_form'), 20, 2);
					}
				}
			}
		}

        /**
         * Check if is quick view action
         *
         * @since 1.1.5
         * @author Francesco Licandro
         * @return boolean
         */
        public function is_quick_view(){
            return isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'jckqv';
        }

		/**
		 * Add form to stock html
		 *
		 * @access public
		 * @since 1.0.0
		 * @param string $html
		 * @param int $availability
		 * @param object | boolean $product
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function output_form( $html, $availability, $product = false ) {

			if( ! $product ) {
				$product = $this->current_product;
			}

			// check first id product is excluded
			if( is_callable( array( $product, 'get_id' ) ) ) {
				$id = $product->get_id();
			}
			else {
				$id = isset( $product->variation_id ) ? $product->variation_id : $product->id;
			}

			ob_start();
			echo do_shortcode( '[ywcwtl_form product_id="' . $id .'"]' );

			// then add form to current html
			$html .= ob_get_clean();

			return $html;
		}

		/**
		 * Output form for WooCommerce 3.0.0
		 *
		 * @since 1.1.0
		 * @author Francesco Licandro
		 * @param string $html
		 * @param object $product
		 * @return string
		 */
		public function output_form_3_0( $html, $product ) {
			return $this->output_form( $html, false, $product );
		}

		/**
		 * Output the form according to product type and user
		 *
		 * @access public
		 * @since 1.0.0
		 * @param $product
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function the_form( $product ) {

			/**
			 * @type $product WC_Product
			 */

			$html = '';
			$user           = wp_get_current_user();
			$waitlist       = yith_waitlist_get( $product );
			$url            = $product->get_permalink();

			// check first id product is excluded
			if( is_callable( array( $product, 'get_id' ) ) ) {
				$product_id = $product->get_id();
			}
			else {
				$product_id = isset( $product->variation_id ) ? $product->variation_id : $product->id;
			}
			
			// set query
			$url = add_query_arg( YITH_WCWTL_META , $product_id, $url );
			$url = add_query_arg( YITH_WCWTL_META . '-action', 'register', $url );

			//add message
			$html .= '<div id="yith-wcwtl-output"><p class="yith-wcwtl-msg">' . get_option( 'yith-wcwtl-form-message' ) . '</p>';

			// get buttons label from options
			$label_button_add   = get_option( 'yith-wcwtl-button-add-label' );
			$label_button_leave = get_option( 'yith-wcwtl-button-leave-label' );

			if( ! $product->is_type( 'variation' ) && ! $user->exists() ) {

				$html .= '<form method="post" action="' . esc_url( $url ) . '">';
				$html .= '<label for="yith-wcwtl-email">' . __( 'Email Address', 'yith-woocommerce-waiting-list' ) . '<input type="email" name="yith-wcwtl-email" id="yith-wcwtl-email" /></label>';
				$html .= '<input type="submit" value="' . $label_button_add . '" class="button alt" />';
				$html .= '</form>';

			}
			elseif( $product->is_type ( 'variation' ) && ! $user->exists() ) {

				$html .= '<input type="email" name="yith-wcwtl-email" id="yith-wcwtl-email" class="wcwtl-variation" />';
				$html .= '<a href="' . esc_url( $url ) . '" class="button alt">' . $label_button_add . '</a>';
			}
			elseif( yith_waitlist_user_is_register( $user->user_email, $waitlist ) ) {
				$url   = add_query_arg( YITH_WCWTL_META . '-action', 'leave', $url );
				$html .= '<a href="' . esc_url( $url ) . '" class="button button-leave alt">' . $label_button_leave . '</a>';
			}
			else {
				$html .= '<a href="' . esc_url( $url ) . '" class="button alt">' . $label_button_add . '</a>';
			}

			$html .= '</div>';

			return apply_filters( 'yith_wcwtl_form_html', $html, $product );
		}

		/**
		 * Add user to waitlist
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function yith_waiting_submit() {

			$user = wp_get_current_user();

			if( ! ( isset( $_REQUEST[ YITH_WCWTL_META ] ) && is_numeric( $_REQUEST[ YITH_WCWTL_META ] ) && isset( $_REQUEST[ YITH_WCWTL_META . '-action' ] ) ) ) {
				return;
			}
			
			$action = $_REQUEST[ YITH_WCWTL_META . '-action' ];

			$user_email = ( isset( $_REQUEST[ 'yith-wcwtl-email' ] ) ) ? $_REQUEST[ 'yith-wcwtl-email' ] : $user->user_email;
			$product_id = $_REQUEST[ YITH_WCWTL_META ];
			$product = wc_get_product( $product_id );
            // lets filter redirection url
            $dest = remove_query_arg( array( YITH_WCWTL_META, YITH_WCWTL_META . '-action', 'yith-wcwtl-email' ) );
            $dest = apply_filters( 'yith_wcwtl_destination_url_after_submit', $dest, $product );

			if( ! $user->exists() && empty( $_REQUEST[ 'yith-wcwtl-email' ] ) ) {
				wc_add_notice( __( 'You must provide a valid email address to join the waiting list of this product', 'yith-woocommerce-waiting-list' ), 'error' );
				wp_redirect( esc_url( $dest ) );
				exit();
			}
			
			// set standard msg and type
			$msg        = get_option( 'yith-wcwtl-button-success-msg' );
			$msg_type   = 'success';

			// start user session and set cookies
			if( ! isset( $_COOKIE['woocommerce_items_in_cart'] ) ) {
				do_action( 'woocommerce_set_cart_cookies', true );
			}

			if( $action == 'register' ) {
				// register user;
				$res = yith_waitlist_register_user( $user_email, $product_id );

				if( ! $res ) {
					$msg = __( 'You have already registered for this waiting list', 'yith-woocommerce-waiting-list' );
					$msg_type = 'error';
				}
			}
			elseif( $action == 'leave' ) {
				// unregister user
				yith_waitlist_unregister_user( $user_email, $product_id );
				$msg = __( 'You have been removed from the waiting list for this product', 'yith-woocommerce-waiting-list' );
			}
			else {
				$msg = __( 'An error has occurred. Please try again.', 'yith-woocommerce-waiting-list' );
				$msg_type = 'error';
			}

			//redirect to product page
			wc_add_notice( $msg, $msg_type );
			wp_redirect( esc_url( $dest ) );
			exit;
		}

		/**
         * Shortcode for print waiting list form
         *
         * @since 1.0.8
         * @author Francesco Licandro
         * @param array $atts
         * @return string
         */
		public function shortcode_form( $atts ) {
            extract( shortcode_atts( array(
                'product_id'   => ''
            ), $atts ) );

			if( $product_id ) {
				$product = wc_get_product( $product_id );
			}
			else {
				// get global
				global $product;
			}

			// exit if product is null or if can't have waitlist
			if( is_null( $product ) || ! $product || ! $this->can_have_waitlist( $product ) ) {
				return '';
			}

			// first enqueue scripts
			$this->enqueue_scripts();

			ob_start();
            echo $this->the_form( $product );

            return ob_get_clean();
        }

        /**
         * Add form on WC AJAX get variations method
         *
         * @since 1.3.1
         * @author Francesco Licandro
         */
        public function add_form_ajax(){
            if ( ! isset( $_REQUEST['wc-ajax'] ) || $_REQUEST['wc-ajax'] != 'get_variation'
                || empty( $_POST['product_id'] ) || ! ( $variable_product = wc_get_product( absint( $_POST['product_id'] ) ) ) ) {
                return;
            }

            $data_store   = WC_Data_Store::load( 'product' );
            $variation_id = $data_store->find_matching_product_variation( $variable_product, wp_unslash( $_POST ) );

            $this->current_product = wc_get_product( $variation_id );

            add_action('woocommerce_stock_html', array($this, 'output_form'), 20, 2);
        }
	}
}
/**
 * Unique access to instance of YITH_WCWT_Frontend class
 *
 * @return \YITH_WCWTL_Frontend
 * @since 1.0.0
 */
function YITH_WCWTL_Frontend(){
	return YITH_WCWTL_Frontend::get_instance();
}
