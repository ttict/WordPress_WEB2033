<?php
/**
 * Admin class
 *
 * @author  Yithemes
 * @package YITH WooCommerce Badge Management
 * @version 1.0.0
 */

if ( !defined( 'YITH_WCBM' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YITH_WCBM_Admin' ) ) {
    /**
     * Admin class.
     * The class manage all the admin behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCBM_Admin {

        /**
         * Single instance of the class
         *
         * @var YITH_WCBM_Admin
         * @since 1.0.0
         */
        protected static $_instance;

        /**
         * Plugin options
         *
         * @var array
         * @access public
         * @since  1.0.0
         */
        public $options = array();

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version = YITH_WCBM_VERSION;

        /**
         * @var $_panel Panel Object
         */
        protected $_panel;

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing = 'https://yithemes.com/themes/plugins/yith-woocommerce-badges-management/';

        /**
         * @var string Quick View panel page
         */
        protected $_panel_page = 'yith_wcbm_panel';

        /**
         * Various links
         *
         * @var string
         * @access public
         * @since  1.0.0
         */
        public $doc_url    = 'https://docs.yithemes.com/yith-woocommerce-badge-management/';
        public $demo_url   = 'https://plugins.yithemes.com/yith-woocommerce-badge-management';
        public $yith_url   = 'https://www.yithemes.com';
        public $plugin_url = 'https://yithemes.com/themes/plugins/yith-woocommerce-badges-management/';

        /**
         * Returns single instance of the class
         *
         * @return YITH_WCBM_Admin | YITH_WCBM_Admin_Premium
         * @since 1.0.0
         */
        public static function get_instance() {
            $self = __CLASS__ . ( class_exists( __CLASS__ . '_Premium' ) ? '_Premium' : '' );

            return !is_null( $self::$_instance ) ? $self::$_instance : $self::$_instance = new $self;
        }

        /**
         * Constructor
         *
         * @access public
         * @since  1.0.0
         */
        public function __construct() {
            add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YITH_WCBM_DIR . '/' . basename( YITH_WCBM_FILE ) ), array( $this, 'action_links' ) );
            add_filter( 'yith_show_plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 5 );

            add_action( 'add_meta_boxes', array( $this, 'register_metabox' ) );
            add_action( 'add_meta_boxes', array( $this, 'badge_settings_metabox' ) );

            // Add Capabilities to Administrator and Shop Manager
            add_action( 'admin_init', array( $this, 'add_capabilities' ) );

            // Action per le metabox
            add_action( 'save_post', array( $this, 'metabox_save' ) );
            add_action( 'save_post', array( $this, 'badge_settings_save' ) );

            // Duplicate Badge
            add_action( 'admin_action_duplicate_badge', array( $this, 'admin_action_duplicate_badge' ) );
            add_filter( 'post_row_actions', array( $this, 'add_duplicate_action_on_badges' ), 10, 2 );


            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

            // Premium Tabs
            add_action( 'yith_wcbm_premium_tab', array( $this, 'show_premium_tab' ) );
        }

        /**
         * Do actions duplicate_badge
         *
         * @since       1.2.11 (free version) | 1.2.27 (premium version)
         * @author      Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function admin_action_duplicate_badge() {
            if ( empty( $_REQUEST[ 'post' ] ) ) {
                wp_die( __( 'No badge to duplicate has been supplied!', 'yith-woocommerce-badges-management' ) );
            }

            $id = isset( $_REQUEST[ 'post' ] ) ? absint( $_REQUEST[ 'post' ] ) : '';

            check_admin_referer( 'yith-wcbm-duplicate-badge_' . $id );

            $post = get_post( $id );

            if ( !$post || $post->post_type !== YITH_WCBM_Post_Types::$badge )
                wp_die( sprintf( __( 'Error while duplicating badge: badge #%s not found', 'yith-woocommerce-badges-management' ), $id ) );

            $new_post = array(
                'post_status' => $post->post_status,
                'post_type'   => YITH_WCBM_Post_Types::$badge,
                'post_title'  => $post->post_title . ' - ' . __( 'Copy', 'yith-woocommerce-badges-management' )
            );

            $new_post_id = wp_insert_post( $new_post );

            if ( $new_post_id ) {
                $meta_to_save = array(
                    '_badge_meta'
                );

                foreach ( $meta_to_save as $key ) {
                    $original_meta = get_post_meta( $id, $key, true );
                    update_post_meta( $new_post_id, $key, $original_meta );
                }

                $admin_edit_url = admin_url( 'edit.php?post_type=' . YITH_WCBM_Post_Types::$badge );
                wp_redirect( $admin_edit_url );
            }

        }

        /**
         * Add Duplicate action link in Membership Plans LIST
         *
         * @param array   $actions An array of row action links. Defaults are
         *                         'Edit', 'Quick Edit', 'Restore, 'Trash',
         *                         'Delete Permanently', 'Preview', and 'View'.
         * @param WP_Post $post    The post object.
         *
         * @since       1.2.11 (free version) | 1.2.27 (premium version)
         * @author      Leanza Francesco <leanzafrancesco@gmail.com>
         * @return array
         */
        public function add_duplicate_action_on_badges( $actions, $post ) {
            if ( $post->post_type === YITH_WCBM_Post_Types::$badge && $post->post_status === 'publish' ) {

                $duplicate_link = wp_nonce_url( add_query_arg( array( 'post_type' => YITH_WCBM_Post_Types::$badge,
                                                                      'action'    => 'duplicate_badge',
                                                                      'post'      => $post->ID
                                                               ), admin_url() ), 'yith-wcbm-duplicate-badge_' . $post->ID );

                $actions[ 'duplicate_badge' ] = '<a href="' . $duplicate_link . '" title="' . esc_attr__( 'Make a duplicate from this badge', 'yith-woocommerce-badges-management' )
                    . '" rel="permalink">' . __( 'Duplicate', 'yith-woocommerce-badges-management' ) . '</a>';
            }

            return $actions;
        }

        /**
         * Return an array of links for the YITH Sidebar
         *
         * @return array
         */
        public function get_panel_sidebar_links() {
            $links = array(
                array(
                    'url'   => $this->yith_url,
                    'title' => __( 'Your Inspiration Themes', 'yith-woocommerce-badges-management' ),
                ),
                array(
                    'url'   => $this->doc_url,
                    'title' => __( 'Plugin Documentation', 'yith-woocommerce-badges-management' ),
                ),
                array(
                    'url'   => $this->plugin_url,
                    'title' => __( 'Plugin Site', 'yith-woocommerce-badges-management' ),
                ),
                array(
                    'url'   => $this->demo_url,
                    'title' => __( 'Live Demo', 'yith-woocommerce-badges-management' ),
                ),
            );

            return $links;
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         * @return mixed
         * @use      plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {
            return yith_add_action_links( $links, $this->_panel_page, defined( 'YITH_WCBM_PREMIUM' ) );
        }

        /**
         * Adds action links to plugin admin page
         *
         * @param array  $row_meta_args
         * @param array  $plugin_meta
         * @param string $plugin_file
         * @param array  $plugin_data
         * @param string $status
         * @return array
         */
        public function plugin_row_meta( $row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status ) {
            $init = '';
            ( defined( 'YITH_WCBM_FREE_INIT' ) && $init = YITH_WCBM_FREE_INIT ) || ( defined( 'YITH_WCBM_INIT' ) && $init = YITH_WCBM_INIT );

            if ( $init === $plugin_file ) {
                $row_meta_args[ 'slug' ] = 'yith-woocommerce-badge-management';
                if ( !defined( 'YITH_WCBM_PREMIUM' ) ) {
                    $row_meta_args[ 'support' ] = array(
                        'url' => 'https://wordpress.org/support/plugin/yith-woocommerce-badges-management'
                    );
                } else {
                    $row_meta_args[ 'is_premium' ] = true;
                }
            }

            return $row_meta_args;
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         * @use      /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function register_panel() {

            if ( !empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs_free = array(
                'settings' => __( 'Settings', 'yith-woocommerce-badges-management' ),
                'premium'  => __( 'Premium Version', 'yith-woocommerce-badges-management' ),
            );

            $admin_tabs = apply_filters( 'yith_wcbm_settings_admin_tabs', $admin_tabs_free );

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => 'Badge Management',
                'menu_title'       => 'Badge Management',
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'links'            => $this->get_panel_sidebar_links(),
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YITH_WCBM_DIR . '/plugin-options',
            );

            $enable_shop_manager = get_option( 'yith-wcbm-enable-shop-manager', 'no' ) === 'yes';
            if ( $enable_shop_manager ) {
                $args[ 'capability' ] = 'manage_woocommerce';
            }

            /* === Fixed: not updated theme  === */
            if ( !class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
                require_once( 'plugin-fw/lib/yit-plugin-panel-wc.php' );
            }

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
        }

        public function admin_enqueue_scripts() {
            $screen = get_current_screen();

            if ( in_array( $screen->id, array( 'yith-wcbm-badge', 'edit-yith-wcbm-badge', 'product', 'edit-product', 'yith-plugins_page_yith_wcbm_panel' ) ) ) {
                wp_enqueue_style( 'yith_wcbm_admin_style', YITH_WCBM_ASSETS_URL . '/css/admin.css', array(), YITH_WCBM_VERSION );
            }

            if ( in_array( $screen->id, array( 'yith-wcbm-badge', 'edit-yith-wcbm-badge' ) ) ) {
                wp_enqueue_style( 'googleFontsOpenSans', '//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' );

            }

            if ( in_array( $screen->id, array( 'yith-wcbm-badge' ) ) ) {
                wp_enqueue_style( 'wp-color-picker' );

                wp_enqueue_script( 'wp-color-picker' );
                wp_enqueue_script( 'jquery-ui-tabs' );

                $metabox_js = defined( 'YITH_WCBM_PREMIUM' ) ? 'metabox_options_premium.js' : 'metabox_options.js';

                wp_enqueue_script( 'yith_wcbm_metabox_options', YITH_WCBM_ASSETS_URL . '/js/' . $metabox_js, array( 'jquery', 'wp-color-picker' ), YITH_WCBM_VERSION, true );
                wp_localize_script( 'yith_wcbm_metabox_options', 'ajax_object', array( 'assets_url' => YITH_WCBM_ASSETS_URL, 'wp_ajax_url' => admin_url( 'admin-ajax.php' ) ) );

                $yith_wcbm_language = array(
                    'slider' => __( 'Slider', 'yith-woocommerce-badges-management' ),
                    'number' => __( 'Number', 'yith-woocommerce-badges-management' ),
                );

                wp_localize_script( 'yith_wcbm_metabox_options', 'yith_wcbm_language', $yith_wcbm_language );
            }
        }

        /**
         * Add badge management capabilities to Admin and Shop Manager
         *
         *
         * @access public
         * @since  1.0.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function add_capabilities() {
            $caps = yith_wcbm_create_capabilities( array( 'badge', 'badges' ) );

            // gets the admin and shop_manager roles
            $admin        = get_role( 'administrator' );
            $shop_manager = get_role( 'shop_manager' );

            foreach ( $caps as $cap => $value ) {
                if ( $admin )
                    $admin->add_cap( $cap );

                if ( $shop_manager )
                    $shop_manager->add_cap( $cap );
            }
        }

        public function register_metabox() {
            add_meta_box( 'yith-wcbm-metabox', __( 'Badge Options', 'yith-woocommerce-badges-management' ), array( $this, 'metabox_render' ), 'yith-wcbm-badge', 'normal', 'high' );
        }

        public function metabox_render( $post ) {
            $bm_meta = get_post_meta( $post->ID, '_badge_meta', true );

            $default = array(
                'type'              => 'text',
                'text'              => '',
                'txt_color_default' => '#000000',
                'txt_color'         => '#000000',
                'bg_color_default'  => '#2470FF',
                'bg_color'          => '#2470FF',
                'width'             => '100',
                'height'            => '50',
                'position'          => 'top-left',
                'image_url'         => '',
            );

            $args = wp_parse_args( $bm_meta, $default );

            $args = apply_filters( 'yith_wcbm_metabox_options_content_args', $args );

            yith_wcbm_metabox_options_content( $args );
        }

        public function metabox_save( $post_id ) {
            if ( !empty( $_POST[ '_badge_meta' ] ) ) {
                $badge_meta[ 'type' ]      = ( !empty( $_POST[ '_badge_meta' ][ 'type' ] ) ) ? $_POST[ '_badge_meta' ][ 'type' ] : '';
                $badge_meta[ 'text' ]      = ( !empty( $_POST[ '_badge_meta' ][ 'text' ] ) ) ? $_POST[ '_badge_meta' ][ 'text' ] : '';
                $badge_meta[ 'txt_color' ] = ( !empty( $_POST[ '_badge_meta' ][ 'txt_color' ] ) ) ? $_POST[ '_badge_meta' ][ 'txt_color' ] : '';
                $badge_meta[ 'bg_color' ]  = ( !empty( $_POST[ '_badge_meta' ][ 'bg_color' ] ) ) ? esc_url( $_POST[ '_badge_meta' ][ 'bg_color' ] ) : '';
                $badge_meta[ 'width' ]     = ( !empty( $_POST[ '_badge_meta' ][ 'width' ] ) ) ? $_POST[ '_badge_meta' ][ 'width' ] : '';
                $badge_meta[ 'height' ]    = ( !empty( $_POST[ '_badge_meta' ][ 'height' ] ) ) ? $_POST[ '_badge_meta' ][ 'height' ] : '';
                $badge_meta[ 'position' ]  = ( !empty( $_POST[ '_badge_meta' ][ 'position' ] ) ) ? $_POST[ '_badge_meta' ][ 'position' ] : 'top-left';
                $badge_meta[ 'image_url' ] = ( !empty( $_POST[ '_badge_meta' ][ 'image_url' ] ) ) ? $_POST[ '_badge_meta' ][ 'image_url' ] : '';

                //--wpml-------------
                yith_wcbm_wpml_register_string( 'yith-woocommerce-badges-management', sanitize_title( $badge_meta[ 'text' ] ), $badge_meta[ 'text' ] );
                //-------------------

                update_post_meta( $post_id, '_badge_meta', $badge_meta );
            }
        }


        function badge_settings_metabox() {
            add_meta_box( 'yith-wcbm-badge_metabox', __( 'Product Badge', 'yith-woocommerce-badges-management' ), array( $this, 'badge_settings_tabs' ), 'product', 'side', 'core' );
        }

        /**
         * Add badge select in metabox
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */

        function badge_settings_tabs() {
            global $post;
            $product  = wc_get_product( $post->ID );
            $bm_meta  = yit_get_prop( $product, '_yith_wcbm_product_meta', true );
            $id_badge = ( isset( $bm_meta[ 'id_badge' ] ) ) ? $bm_meta[ 'id_badge' ] : '';
            ?>
            <p class="form-field">
                <select name="_yith_wcbm_product_meta[id_badge]" class="select">
                    <option value="" selected="selected"><?php echo __( 'none', 'yith-woocommerce-badges-management' ) ?></option>
                    <?php

                    $args   = ( array(
                        'posts_per_page'   => -1,
                        'post_type'        => 'yith-wcbm-badge',
                        'orderby'          => 'title',
                        'order'            => 'ASC',
                        'post_status'      => 'publish',
                        'suppress_filters' => false,
                    ) );
                    $badges = get_posts( $args );

                    foreach ( $badges as $badge ) {
                        ?>
                        <option value="<?php echo $badge->ID ?>" <?php selected( $id_badge, $badge->ID ) ?>><?php echo get_the_title( $badge->ID ) ?></option><?php
                    }

                    ?>
                </select>
            </p>
            <?php
        }


        public function badge_settings_save( $product_id ) {
            if ( !empty( $_POST[ '_yith_wcbm_product_meta' ] ) ) {
                update_post_meta( $product_id, '_yith_wcbm_product_meta', $_POST[ '_yith_wcbm_product_meta' ] );
            }
        }

        /**
         * Show premium landing tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function show_premium_tab() {
            $landing = YITH_WCBM_TEMPLATE_PATH . '/premium.php';
            file_exists( $landing ) && require( $landing );
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri() {
            return $this->_premium_landing;
        }
    }
}

/**
 * Unique access to instance of YITH_WCBM_Admin class
 *
 * @return YITH_WCBM_Admin
 * @since 1.0.0
 */
function YITH_WCBM_Admin() {
    return YITH_WCBM_Admin::get_instance();
}
