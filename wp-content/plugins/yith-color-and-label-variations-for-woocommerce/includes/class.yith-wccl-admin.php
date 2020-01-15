<?php
/**
 * Admin class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Colors and Labels Variations
 * @version 1.1.0
 */

if ( !defined( 'YITH_WCCL' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_WCCL_Admin' ) ) {
    /**
     * Admin class.
     * The class manage all the admin behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCCL_Admin {

        /**
         * @var string Quick View panel page
         */
        protected $_panel_page = 'yith_ywcl_panel';

        /**
         * @var string Premium landing url
         */
        public $premium_landing_url = 'https://yithemes.com/themes/plugins/yith-woocommerce-color-and-label-variations/';

        /**
         * @var boolean Check if WooCommerce is 2.7
         */
        public $wc_is_27 = false;

        /**
         * Constructor
         *
         * @access public
         * @since 1.0.0
         */
        public function __construct() {

            $this->wc_is_27     = ywccl_check_wc_version( '2.7', '>=' );
            
            //product attribute taxonomies
            add_action('init', array($this, 'attribute_taxonomies'));

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YITH_WCCL_DIR . '/' . basename( YITH_WCCL_FILE ) ), array( $this, 'action_links' ) );
            add_filter( 'yith_show_plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 5 );

            //print attribute field type
            add_action('yith_wccl_print_attribute_field', array($this, 'print_attribute_type'), 10, 3);

            //save new term
            add_action('created_term', array($this, 'attribute_save'), 10, 3);
            add_action('edit_term', array($this, 'attribute_save'), 10, 3);

            //choose variations in product page
            add_action('woocommerce_product_option_terms', array($this, 'product_option_terms'), 10, 2);

            //enqueue static content
            add_action('admin_enqueue_scripts', array($this, 'enqueue'));

            //Add YITH Plugin Panel
            add_action( 'admin_menu', array( $this, 'register_panel' ),5 );
            //Add premium tab
            add_action( 'ywcl_premium_tab', array( $this, 'print_premium_tab' ) );

            // YITH WCCL Loaded
            do_action( 'yith_wccl_loaded' );

        }


        /**
         * Enqueue static content
         */
        public function enqueue() {
            global $pagenow;

            if( in_array( $pagenow, array( 'term.php', 'edit-tags.php' ) ) && isset( $_GET['post_type'] ) && 'product' == $_GET['post_type'] ) {
                wp_enqueue_media();
                wp_enqueue_style( 'yith-wccl-admin', YITH_WCCL_URL . '/assets/css/admin.css', array('wp-color-picker'), YITH_WCCL_VERSION );
                wp_enqueue_script( 'yith-wccl-admin', YITH_WCCL_URL . '/assets/js/admin.js', array('jquery', 'wp-color-picker' ), YITH_WCCL_VERSION, true );
            }
        }

        /**
         * Init product attribute taxonomies
         *
         * @access public
         * @since 1.0.0
         */
        public function attribute_taxonomies() {

            global $woocommerce;

            $attribute_taxonomies = function_exists('wc_get_attribute_taxonomies') ? wc_get_attribute_taxonomies() : $woocommerce->get_attribute_taxonomies();
            if ($attribute_taxonomies) {
                foreach ($attribute_taxonomies as $tax) {

                    $name = wc_attribute_taxonomy_name( $tax->attribute_name );

                    add_action(  $name . '_add_form_fields', array($this, 'add_attribute_field') );
                    add_action(  $name . '_edit_form_fields', array($this, 'edit_attribute_field'), 10, 2);

                    add_filter('manage_edit-' .  $name . '_columns', array($this, 'product_attribute_columns') );
                    add_filter('manage_' .  $name . '_custom_column', array($this, 'product_attribute_column'), 10, 3);
                }
            }
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
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed
         * @use plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {
            $links = yith_add_action_links( $links, $this->_panel_page, false );
            return $links;
        }

        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use plugin_row_meta
         */
        public function plugin_row_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status ) {

            if ( defined( 'YITH_WCCL_FREE_INIT' ) && YITH_WCCL_FREE_INIT == $plugin_file ) {
                $new_row_meta_args['slug']   = YITH_WCCL_SLUG;

                $new_row_meta_args[ 'live_demo' ] = array(
                    'url'   => 'https://plugins.yithemes.com/yith-woocommerce-color-and-label-variations/'
                );
                $new_row_meta_args[ 'documentation' ] = array(
                    'url'   => 'https://docs.yithemes.com/yith-woocommerce-color-label-variations/'
                );
                $new_row_meta_args[ 'premium_version' ] = array(
                    'url'   => $this->premium_landing_url
                );
            }

            return $new_row_meta_args;
        }


        /**
         * Add field for each product attribute taxonomy
         *
         * @access public
         * @since 1.0.0
         */
        public function add_attribute_field( $taxonomy ) {
            global $wpdb;

            $attribute = substr($taxonomy, 3);
            $attribute = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attribute'");

            do_action('yith_wccl_print_attribute_field', $attribute, false );
        }

        /**
         * Edit field for each product attribute taxonomy
         *
         * @access public
         * @since 1.0.0
         */
        public function edit_attribute_field( $term, $taxonomy ) {
            global $wpdb;

            $attribute = substr( $taxonomy, 3 );
            $attribute = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attribute'" );

            $value = ywccl_get_term_meta( $term->term_id, $taxonomy . '_yith_wccl_value' );

            do_action('yith_wccl_print_attribute_field', $attribute, $value, 1);
        }


        /**
         * Print Color Picker Type HTML
         *
         * @access public
         * @since 1.0.0
         */
        public function print_attribute_type($attribute, $value = '', $table = 0){

            $type = $attribute->attribute_type;
            $custom_types = ywccl_get_custom_tax_types();

            if( ! isset( $custom_types[$type] ) ) {
                return;
            }

            if( $table ): ?>
             <tr class="form-field">
                <th scope="row" valign="top"><label for="term-value"><?php echo $custom_types[$type]; ?></label></th>
                <td>
            <?php else: ?>
            <div class="form-field">
                <label for="term-value"><?php echo $custom_types[$type]; ?></label>
            <?php endif ?>

            <input type="text" name="term-value" id="term-value" value="<?php if ($value) echo $value ?>" data-type="<?php echo $type ?>" />

            <?php if( $table ): ?>
                </td>
                </tr>
            <?php else: ?>
                </div>
            <?php endif ?>
        <?php
        }


        /**
         * Save attribute field
         *
         * @access public
         * @since 1.0.0
         */
        public function attribute_save($term_id, $tt_id, $taxonomy) {
            if (isset($_POST['term-value'])) {
                ywccl_update_term_meta( $term_id, $taxonomy . '_yith_wccl_value', $_POST['term-value'] );
            }
        }

        /**
         * Create new column for product attributes
         *
         * @access public
         * @since 1.0.0
         */
        public function product_attribute_columns( $columns ) {

            if( empty( $columns ) ) {
                return $columns;
            }

            $temp_cols = array();
            $temp_cols['cb'] = $columns['cb'];
            $temp_cols['yith_wccl_value'] = __('Value', 'yith-color-and-label-variations-for-woocommerce');
            unset($columns['cb']);
            $columns = array_merge( $temp_cols, $columns );
            return $columns;
        }

        /**
         * Print the column content
         *
         * @access public
         * @since 1.0.0
         */
        public function product_attribute_column($columns, $column, $id) {
            global $taxonomy, $wpdb;

            if ($column == 'yith_wccl_value') {
                $attribute = substr($taxonomy, 3);
                $attribute = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attribute'");
                $att_type 	= $attribute->attribute_type;

                $value = ywccl_get_term_meta( $id, $taxonomy . '_yith_wccl_value' );
                $columns .= $this->_print_attribute_column( $value, $att_type );
            }

            return $columns;
        }


        /**
         * Print the column content according to attribute type
         *
         * @access public
         * @since 1.0.0
         */
        protected function _print_attribute_column( $value, $type ) {
            $output = '';

            if( $type == 'colorpicker' ) {
                $output = '<span class="yith-wccl-color" style="background-color:'. $value .'"></span>';
            } elseif( $type == 'label' ) {
                $output = '<span class="yith-wccl-label">'. $value .'</span>';
            } elseif( $type == 'image' ) {
                $output = '<img class="yith-wccl-image" src="'. $value .'" alt="" />';
            }

            return $output;
        }

        /**
         * Print select for product variations
         *
         *
         */
        function product_option_terms( $tax, $i ) {
            global $woocommerce, $thepostid;

            if( in_array( $tax->attribute_type, array( 'colorpicker', 'image', 'label' ) ) ) {

                if ( function_exists('wc_attribute_taxonomy_name') ) {
                    $attribute_taxonomy_name = wc_attribute_taxonomy_name( $tax->attribute_name );
                } else {
                    $attribute_taxonomy_name = $woocommerce->attribute_taxonomy_name( $tax->attribute_name );
                }
                
                ( is_null( $thepostid ) && isset( $_REQUEST['post_id'] ) ) && $thepostid = intval( $_REQUEST['post_id'] );

                ?>
	            <select multiple="multiple" data-placeholder="<?php _e( 'Select terms', 'yith-color-and-label-variations-for-woocommerce' ); ?>" class="multiselect attribute_values wc-enhanced-select" name="attribute_values[<?php echo $i; ?>][]">
		            <?php
		            $all_terms = $this->get_terms( $attribute_taxonomy_name );
		            if ( $all_terms ) {
			            foreach ( $all_terms as $term ) {
				            echo '<option value="' . esc_attr( $term['value'] ) . '" ' . selected( has_term( absint( $term['id'] ), $attribute_taxonomy_name, $thepostid ), true, false ) . '>' . $term['name'] . '</option>';
			            }
		            }
		            ?>
	            </select>
                <button class="button plus select_all_attributes"><?php _e( 'Select all', 'yith-color-and-label-variations-for-woocommerce' ); ?></button>
	            <button class="button minus select_no_attributes"><?php _e( 'Select none', 'yith-color-and-label-variations-for-woocommerce' ); ?></button>
                <button class="button fr plus add_new_attribute" data-attribute="<?php echo $attribute_taxonomy_name; ?>"><?php _e( 'Add new', 'yith-color-and-label-variations-for-woocommerce' ); ?></button>
                <?php
            }
        }

        /**
         * Get terms attributes array
         *
         * @since 1.3.0
         * @author Francesco Licandro
         * @param string $tax_name
         * @return array
         */
        protected function get_terms( $tax_name ) {

            global $wp_version;

            if( version_compare($wp_version, '4.5', '<' ) ) {
                $terms = get_terms( $tax_name, array(
                    'orderby'       => 'name',
                    'hide_empty'    => '0'
                ) );
            }
            else {
                $args = array(
                    'taxonomy'      => $tax_name,
                    'orderby'       => 'name',
                    'hide_empty'    => '0'
                );
                // get terms
                $terms = get_terms( $args );
            }
            $all_terms = array();

            foreach( $terms as $term ) {
                $all_terms[] = array(
                    'id'    => $term->term_id,
                    'value' => $this->wc_is_27 ? $term->term_id : $term->slug,
                    'name'  => $term->name
                );
            }

            return $all_terms;
        }

        
        /**
         * Register YITH Panel
         *
         * @since   1.2.4
         * @author  Alessio Torrisi <alessio.torrisi@yithemes.com>
         * @return  void
         */
        public function register_panel() {

            if ( !empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs = array(
                'premium' => __( 'Premium Version', 'yith-color-and-label-variations-for-woocommerce' ),
            );

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => _x( 'Color and Label Variations', 'plugin name in admin page title', 'yith-color-and-label-variations-for-woocommerce' ),
                'menu_title'       => _x( 'Color and Label Variations', 'plugin name in admin WP menu', 'yith-color-and-label-variations-for-woocommerce' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YITH_WCCL_DIR . '/plugin-options'
            );

            /* === Fixed: not updated theme  === */
            if ( !class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
                require_once( 'plugin-fw/lib/yit-plugin-panel-wc.php' );
            }

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
        }

        /**
         * Prints premium tab
         *
         * @since   1.2.4
         * @author  Alessio Torrisi <alessio.torrisi@yithemes.com>
         * @return  void
         */
        public function print_premium_tab() {
            include( YITH_WCCL_DIR . '/templates/admin/premium.php' );
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.2.4
         * @author  Alessio Torrisi <alessio.torrisi@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri(){
            return $this->premium_landing_url;
        }

    }
}
