<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Colors and Labels Variations
 * @version 1.1.1
 */

if ( !defined( 'YITH_WCCL' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_WCCL' ) ) {
    /**
     * YITH WooCommerce Ajax Navigation
     *
     * @since 1.0.0
     */
    class YITH_WCCL {

        /**
         * Plugin object
         *
         * @var string
         * @since 1.0.0
         */
        public $obj = null;

        /**
         * Constructor
         *
         * @return mixed|YITH_WCCL_Admin|YITH_WCCL_Frontend
         * @since 1.0.0
         */
        public function __construct() {

            // actions
            add_action( 'init', array( $this, 'init' ) );

            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

            if( is_admin() ) {
                $this->obj = new YITH_WCCL_Admin();
            }  else {
                $this->obj = new YITH_WCCL_Frontend();
            }

            // add new attribute types
            add_filter( 'product_attributes_type_selector', array( $this, 'attribute_types' ), 10, 1 );
        }

        /**
         * Plugin Framework loader
         * 
         * @since 1.0.0
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
         * Add new attribute types to standard WooCommerce
         *
         * @since 1.5.0
         * @author Francesco Licandro <francesco.licandro@yithemes.com>
         * @param array $default_type
         * @return array
         */
        public function attribute_types( $default_type ){
            $custom = ywccl_get_custom_tax_types();
            return is_array( $custom ) ? array_merge( $default_type, $custom ) : $default_type;
        }

        /**
         * Init method
         *
         * @access public
         * @since 1.0.0
         */
        public function init() {}

    }
}