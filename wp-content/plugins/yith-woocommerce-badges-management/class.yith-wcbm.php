<?php
/**
 * Main class
 *
 * @author  Yithemes
 * @package YITH WooCommerce Badge Management
 * @version 1.0.0
 */


if ( !defined( 'YITH_WCBM' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YITH_WCBM' ) ) {
    /**
     * YITH WooCommerce Badge Management
     *
     * @since 1.0.0
     */
    class YITH_WCBM {

        /**
         * Single instance of the class
         *
         * @var YITH_WCBM
         * @since 1.0.0
         */
        protected static $_instance;

        /**
         * @var YITH_WCBM_Admin|YITH_WCBM_Admin_Premium
         */
        public $admin;

        /**
         * @var YITH_WCBM_Frontend|YITH_WCBM_Frontend_Premium
         */
        public $frontend;

        /**
         * Returns single instance of the class
         *
         * @return YITH_WCBM|YITH_WCBM_Premium
         * @since 1.0.0
         */
        public static function get_instance() {
            $self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

            return !is_null( $self::$_instance ) ? $self::$_instance : $self::$_instance = new $self;
        }

        /**
         * Constructor
         *
         * @return YITH_WCBM
         * @since 1.0.0
         */
        public function __construct() {

            // Load Plugin Framework
            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

            YITH_WCBM_Post_Types::init();

            // Class admin
            if ( is_admin() && ( !isset( $_REQUEST[ 'action' ] ) || ( isset( $_REQUEST[ 'action' ] ) && $_REQUEST[ 'action' ] != 'yith_load_product_quick_view' ) ) ) {
                $this->admin = YITH_WCBM_Admin();
            }

            $is_ajax_request = defined( 'DOING_AJAX' ) && DOING_AJAX;
            if ( !is_admin() || $is_ajax_request ) {
                $this->frontend = YITH_WCBM_Frontend();
            }
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
            if ( !defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if ( !empty( $plugin_fw_data ) ) {
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file );
                }
            }
        }
    }
}

/**
 * Unique access to instance of YITH_WCBM class
 *
 * @return YITH_WCBM|YITH_WCBM_Premium
 * @since 1.0.0
 */
function YITH_WCBM() {
    return YITH_WCBM::get_instance();
}