<?php
/**
 * YITH WooCommerce Waiting List Mail Template Plain
 *
 * @author YITH
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) exit; // Exit if accessed directly

echo $email_heading . "\n\n";

echo nl2br( $email_content ). "\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );