<?php
/**
* Plugin Name: YITH WooCommerce Badge Management
* Plugin URI: https://yithemes.com/themes/plugins/yith-woocommerce-badges-management/
* Description: <code><strong>YITH WooCommerce Badge Management</strong></code> allows you to highlight your products through custom badges, that show offers, discounts, and so on. You can use text badges and image badges to attract your customers. <a href="https://yithemes.com/" target="_blank">Get more plugins for your e-commerce shop on <strong>YITH</strong></a>
* Version: 1.3.19
* Author: YITH
* Author URI: https://yithemes.com/
* Text Domain: yith-woocommerce-badges-management
* Domain Path: /languages/
* WC requires at least: 3.0.0
* WC tested up to: 3.7.x
*
* @author Yithemes
* @package YITH WooCommerce Badge Management
* @version 1.3.19
*/
/*  Copyright 2015  Your Inspiration Themes  (email : plugins@yithemes.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* == COMMENT == */ 

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function yith_wcbm_install_woocommerce_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'YITH WooCommerce Badge Management is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-badges-management' ); ?></p>
    </div>
    <?php
}


function yith_wcbm_install_free_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Badge Management while you are using the premium one.', 'yith-woocommerce-badges-management' ); ?></p>
    </div>
    <?php
}

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


if ( ! defined( 'YITH_WCBM_VERSION' ) ){
    define( 'YITH_WCBM_VERSION', '1.3.19' );
}

if ( ! defined( 'YITH_WCBM_FREE_INIT' ) ) {
    define( 'YITH_WCBM_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCBM' ) ) {
    define( 'YITH_WCBM', true );
}

if ( ! defined( 'YITH_WCBM_FILE' ) ) {
    define( 'YITH_WCBM_FILE', __FILE__ );
}

if ( !defined( 'YITH_WCBM_SLUG' ) ) {
    define( 'YITH_WCBM_SLUG', 'yith-woocommerce-badges-management' );
}

if ( ! defined( 'YITH_WCBM_URL' ) ) {
    define( 'YITH_WCBM_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_WCBM_DIR' ) ) {
    define( 'YITH_WCBM_DIR', plugin_dir_path( __FILE__ )  );
}

if ( ! defined( 'YITH_WCBM_TEMPLATE_PATH' ) ) {
    define( 'YITH_WCBM_TEMPLATE_PATH', YITH_WCBM_DIR . 'templates' );
}

if ( ! defined( 'YITH_WCBM_ASSETS_URL' ) ) {
    define( 'YITH_WCBM_ASSETS_URL', YITH_WCBM_URL . 'assets' );
}


function yith_wcbm_init() {

    load_plugin_textdomain( 'yith-woocommerce-badges-management', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

    // Load required classes and functions
    require_once('class.yith-wcbm-post-types.php');
    require_once('class.yith-wcbm-admin.php');
    require_once('class.yith-wcbm-frontend.php');
    require_once('class.yith-wcbm.php');
    require_once('functions.yith-wcbm.php');

    // Let's start the game!
    YITH_WCBM();
}
add_action( 'yith_wcbm_init', 'yith_wcbm_init' );


function yith_wcbm_install() {

    if ( ! function_exists( 'WC' ) ) {
        add_action( 'admin_notices', 'yith_wcbm_install_woocommerce_admin_notice' );
    }
    elseif ( defined( 'YITH_WCBM_PREMIUM' ) ) {
        add_action( 'admin_notices', 'yith_wcbm_install_free_admin_notice' );
        deactivate_plugins( plugin_basename( __FILE__ ) );
    }
    else {
        do_action( 'yith_wcbm_init' );
    }
}
add_action( 'plugins_loaded', 'yith_wcbm_install', 11 );

/* Plugin Framework Version Check */
if ( !function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( plugin_dir_path( __FILE__ ) . 'plugin-fw/init.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( plugin_dir_path( __FILE__ ) );