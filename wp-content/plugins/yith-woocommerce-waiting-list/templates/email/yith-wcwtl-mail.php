<?php
/**
 * YITH WooCommerce Waiting List Mail Template
 *
 * @author YITH
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) exit; // Exit if accessed directly

do_action('woocommerce_email_header', $email_heading, $email );
?>

<p>
	<?php _ex( "Hi There,", 'Email salutation', 'yith-woocommerce-waiting-list' ); ?>
</p>

<p>
	<?php echo nl2br( $email_content ); ?>
</p>

<?php do_action('woocommerce_email_footer', $email ); ?>