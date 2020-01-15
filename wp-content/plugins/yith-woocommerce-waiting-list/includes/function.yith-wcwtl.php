<?php
/**
 * General Function
 *
 * @author YITH
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if( ! function_exists( 'yith_waitlist_get' ) ) {
	/**
	 * Get waiting list for product id
	 *
	 * @since 1.0.0
	 * @param object|integer $product
	 * @return array
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_get( $product ) {
		if( ! is_object( $product ) ) {
			$product = wc_get_product( $product );
		}
		return yith_waitlist_check_for_multiple_meta( $product );
	}
}

if( ! function_exists( 'yith_waitlist_save' ) ) {
	/**
	 * Save waiting list for product id
	 *
	 * @since 1.0.0
	 * @param object|integer $product
	 * @param array $list
	 * @return void
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_save( $product, $list ) {
		if( ! is_object( $product ) ) {
			$product = wc_get_product( $product );
		}
		yit_save_prop( $product, YITH_WCWTL_META, $list );
	}
}

if( ! function_exists( 'yith_waitlist_user_is_register' ) ) {
	/**
	 * Check if user is already register for a waiting list
	 *
	 * @since 1.0.0
	 * @param string $user
	 * @param array $list
	 * @return bool
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_user_is_register( $user, $list ) {
		return is_array( $list ) && in_array( $user, $list );
	}
}

if( ! function_exists( 'yith_waitlist_register_user' ) ) {
	/**
	 * Register user to waiting list
	 *
	 * @since 1.0.0
	 * @param string $user User email
	 * @param object|int $product
	 * @return bool
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_register_user( $user, $product ) {
		if( ! is_object( $product ) ) {
			$product = wc_get_product( $product );
		}

		$list = yith_waitlist_get( $product );

		if ( ! is_email( $user ) || yith_waitlist_user_is_register( $user, $list ) ) {
			return false;
		}

		$list[] = $user;
		// save it in product meta
		yith_waitlist_save( $product, $list );

		return true;
	}
}

if( ! function_exists( 'yith_waitlist_unregister_user' ) ) {
	/**
	 * Unregister user from waiting list
	 *
	 * @since 1.0.0
	 * @param string $user User email
	 * @param object|integer $product Product id
	 * @return bool
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_unregister_user( $user, $product ) {

		$list = yith_waitlist_get( $product );

		if( yith_waitlist_user_is_register( $user, $list ) ) {
			$list = array_diff( $list, array ( $user ) );
			// save it in product meta
			yith_waitlist_save( $product, $list );
			return true;
		}

		return false;
	}
}

if( ! function_exists( 'yith_waitlist_get_registered_users' ) ) {
	/**
	 * Get registered users for product waitlist
	 *
	 * @since 1.0.0
	 * @param object|integer $product
	 * @return mixed
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_get_registered_users( $product ) {

		$list = yith_waitlist_get( $product );
		$users = array();

		if( is_array( $list ) ) {
			foreach( $list as $key => $email ) {
				$users[] = $email;
			}
		}

		return $users;
	}
}

if( ! function_exists( 'yith_waitlist_empty' ) ) {
	/**
	 * Empty waitlist by product id
	 *
	 * @since 1.0.0
	 * @param object|integer $product
	 * @return void
	 * @author Francesco Licandro <francesco.licandro@yithemes.com>
	 */
	function yith_waitlist_empty( $product ) {
		if( ! is_object( $product ) ) {
			$product = wc_get_product( $product );
		}
		// now empty waiting list
		yit_save_prop( $product, YITH_WCWTL_META, array() );
	}
}

if( ! function_exists( 'yith_waitlist_textarea_editor_html' ) ) {
	/**
	 * Print textarea editor html for email options
	 *
	 * @access public
	 * @since 1.0.0
	 * @param string $key
	 * @param array $data
	 * @param object $email
	 * @return string
	 * @author Francesco Licandro
	 */
	function yith_waitlist_textarea_editor_html( $key, $data, $email ){

		$field  = $email->get_field_key( $key );

		$defaults = array(
			'title'             => '',
			'disabled'          => false,
			'class'             => '',
			'css'               => '',
			'placeholder'       => '',
			'type'              => 'text',
			'desc_tip'          => false,
			'description'       => '',
			'custom_attributes' => array()
		);

		$data = wp_parse_args( $data, $defaults );

		$editor_args = array(
			'wpautop'       => true, // use wpautop?
			'media_buttons' => true, // show insert/upload button(s)
			'textarea_name' => esc_attr( $field ), // set the textarea name to something different, square brackets [] can be used here
			'textarea_rows' => 20, // rows="..."
			'tabindex'      => '',
			'editor_css'    => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the <style> tags, can use "scoped".
			'editor_class'  => '', // add extra class(es) to the editor textarea
			'teeny'         => false, // output the minimal editor config used in Press This
			'dfw'           => false, // replace the default fullscreen with DFW (needs specific DOM elements and css)
			'tinymce'       => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
			'quicktags'     => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
		);

		ob_start();
		?>

		<tr valign="top">
			<th scope="row" class="select_categories">
				<label for="<?php echo esc_attr( $field ); ?>"><?php echo wp_kses_post( $data['title'] );  ?></label>
				<?php echo $email->get_tooltip_html( $data ); ?>
			</th>
			<td class="forminp">
				<fieldset>
					<div id="<?php echo esc_attr( $field ); ?>-container">
						<div class="editor"><?php wp_editor( $email->get_option( $key ), esc_attr( $field ), $editor_args ); ?></div>
						<?php echo $email->get_description_html( $data ); ?>
					</div>
				</fieldset>
			</td>
		</tr>

		<?php

		return ob_get_clean();
	}
}

if( ! function_exists( 'yith_waitlist_check_for_multiple_meta' ) ) {
	/**
	 * Check for multiple meta, merge these and delete
	 *
	 * @since 1.2.1
	 * @author Francesco Licandro
	 * @param object $product \WC_Product
	 * @return array
	 */
	function yith_waitlist_check_for_multiple_meta( $product ) {
		// get product id
		if( is_callable( array( $product, 'get_id' ) ) ) {
			$product_id = $product->get_id();
		}
		else {
			$product_id = $product->is_type( 'variation' ) ? $product->variation_id : $product->id;
		}

		// check for multiple meta
		$list = get_post_meta( $product_id, YITH_WCWTL_META, false );
		$new_list = array();
		if( ! empty( $list ) && count( $list ) > 1 ) {
			foreach ( $list as $elem => $single_list ){
				if( ! is_array( $single_list ) ) {
					continue;
				}
				$new_list = array_merge( $new_list, $single_list );
			}

			delete_post_meta( $product_id, YITH_WCWTL_META );
			$new_list = array_filter( $new_list );
			$new_list = array_unique( $new_list );

			update_post_meta( $product_id, YITH_WCWTL_META, $new_list );

			$return = $new_list;
		}
		else {
			$return = empty( $list ) ? array() : array_shift( $list );
		}

		return is_array( $return ) ? $return : (array) $return;
	}
}