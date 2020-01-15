<?php
/**
 * Email instock class
 *
 * @author YITH
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCWTL_Mail_Instock' ) ) {
	/**
	 * Email Class
	 * Extend WC_Email to send mail to waitlist users
	 *
	 * @class   YITH_WCWTL_Mail_Instock
	 * @extends  WC_Email
	 */
	class YITH_WCWTL_Mail_Instock extends WC_Email {

		/**
		 * Constructor
		 *
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function __construct() {

			$this->id           = 'yith_waitlist_mail_instock';
			$this->title        = __( 'YITH Waiting list In Stock Email', 'yith-woocommerce-waiting-list' );
			$this->description  = __( 'When a product is back in stock, this email is sent to all the users registered in the waiting list of that product.', 'yith-woocommerce-waiting-list' );

			$this->heading      = __( '{product_title} is now back in stock on {blogname}', 'yith-woocommerce-waiting-list' );
			$this->subject      = __( 'A product you are waiting for is back in stock', 'yith-woocommerce-waiting-list' );
			$this->mail_content = __( 'Hi, {product_title} is now back in stock on {blogname}. You have been sent this email because your email address was registered in a waiting list for this product. If you would like to purchase {product_title}, please visit the following link: {product_link}', 'yith-woocommerce-waiting-list' );

			$this->template_base    = YITH_WCWTL_TEMPLATE_PATH . '/email/';
			$this->template_html    = 'yith-wcwtl-mail.php';
			$this->template_plain   = 'plain/yith-wcwtl-mail.php';

            $this->customer_email = true;

			// Triggers for this email
			add_action( 'send_yith_waitlist_mail_instock_notification', array( $this, 'trigger' ), 10, 2 );

			// Call parent constructor
			parent::__construct();
		}

		/**
		 * @return string|void
		 */
		public function init_form_fields() {

			parent::init_form_fields();

			unset( $this->form_fields['additional_content'] );

			$this->form_fields['mail_content'] = array(
				'title'         => __( 'Email content', 'yith-woocommerce-waiting-list' ),
				'type'          => 'yith_wcwtl_textarea',
				'description'   => sprintf( __( 'Defaults to <code>%s</code>', 'yith-woocommerce-waiting-list' ), $this->mail_content ),
				'placeholder'   => '',
				'default'       => $this->mail_content
			);
		}

		/**
		 * Return YITh Texteditor HTML.
		 *
		 * @param $key
		 * @param $data
		 * @return string
		 */
		public function generate_yith_wcwtl_textarea_html( $key, $data ) {

			// get html
			$html = yith_waitlist_textarea_editor_html( $key, $data, $this );

			return $html;
		}

		/**
		 * Trigger Function
		 *
		 * @access public
		 * @since 1.0.0
		 * @param mixed $users Waitlist users array
		 * @param integer $product_id Product id
		 * @return void
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function trigger( $users, $product_id ) {

			$this->object = wc_get_product( $product_id );

			if( ! $this->is_enabled() || ! $this->object ) {
				return;
			}

			// build link
			$link_label = apply_filters( 'yith_waitlist_link_label_instock_email', __( 'link', 'yith-woocommerce-waiting-list' ) );
			$link =  ( $this->get_email_type() == 'html' ) ? '<a href="' . $this->object->get_permalink() . '">' . $link_label . '</a>' : $this->object->get_permalink();
			// let third part filter link
			$link = apply_filters( 'yith_waitlist_link_html_instock_email', $link, $this->object, $this->get_email_type() );
			
			if( version_compare( WC()->version, '3.2.0', '>=' ) ) {
				$this->placeholders['{product_title}'] = $this->object->get_name();
				$this->placeholders['{product_link}'] = $link;
				$this->placeholders['{blogname}'] = $this->get_blogname();
			} 
			else {
				$this->find['product-title']       = '{product_title}';
				$this->replace['product-title']    = $this->object->get_name();
				$this->find['product-link']        = '{product_link}';
				$this->replace['product-link']     = $link;
			}
			
            $response = false;
            foreach( (array) $users as $user ) {
                $response = parent::send( $user, $this->get_subject(), $this->get_content(), $this->get_headers(),  $this->get_attachments() );
            }

			if( $response ) {
				add_filter( 'yith_wcwtl_mail_instock_send_response', '__return_true' );
			}
		}

		/**
		 * get custom email content from options
		 *
		 * @access public
		 * @since 1.0.0
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function get_custom_option_content() {
			$content = $this->get_option( 'mail_content' );

			return $this->format_string( $content );
		}

		/**
		 * get_content_html function.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function get_content_html() {

            $args = apply_filters( 'yith_wcwtl_email_instock_args', array(
                'product_link'  => $this->object->get_permalink(),
                'email_heading' => $this->get_heading(),
				'email_content' => $this->get_custom_option_content(),
                'email'         => $this
            ));

            ob_start();

            wc_get_template( $this->template_html, $args, false, $this->template_base
            );

            return ob_get_clean();
		}

		/**
		 * get_content_plain function.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function get_content_plain() {

            $args = apply_filters( 'yith_wcwtl_email_subscribe_plain_args', array(
				'product_title' => $this->object->get_name(),
                'product_link'  => $this->object->get_permalink(),
                'email_heading' => $this->get_heading(),
                'email_content' => $this->get_custom_option_content()
            ));

            ob_start();

            wc_get_template( $this->template_plain, $args, false, $this->template_base
            );

            return ob_get_clean();
		}
	}

}

return new YITH_WCWTL_Mail_Instock();