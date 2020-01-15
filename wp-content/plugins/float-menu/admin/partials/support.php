<?php
/**
 * Support Page
 *
 * @package    Wow Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

if ( !defined( 'ABSPATH' ) ) exit;

$plugin = $this->plugin_name . ' v.' . $this->plugin_version;
$website = get_option( 'home' );
//$license = get_option( 'wow_license_key_' . $this->plugin_pref );

?>

<style>
  .feature-section.one-col p {
    font-size: 16px;
  }
  .wow-alert-error {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
  }
  .wow-alert-update {
    color: #94a540;
    background-color: #e7f7e3;
    border-color: #c7e5dc;
  }
  .wow-alert {
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    margin-bottom: 20px;
    padding: 10px;
    border: 1px solid transparent;
    vertical-align: middle;
  }
  p.wow_error {
    margin: 0 !important;
  }
</style>
<div class="about-wrap">
  <div class="feature-section one-col">
    <div class="col">

      <p>To get your support related question answered in the fastest timing, please send a message via the form below or write to us via the <a href="<?php echo $this->plugin_home_url;?>">plugin page</a>.</p>

      <p>Also, you can send us your ideas and suggestions for improving the plugin.</p>
      <?php $error = array();
if ( !empty( $_POST[ 'action' ] ) && !empty( $_POST[ 'wow_support_field' ] ) ) {
  if ( wp_verify_nonce( $_POST[ 'wow_support_field' ], 'wow_support_action' ) && current_user_can( 'manage_options' ) ) {

    $fname = !empty( $_POST[ 'wow-fname' ] ) ? sanitize_text_field( $_POST[ 'wow-fname' ] ) : '';
    $lname = !empty( $_POST[ 'wow-lname' ] ) ? sanitize_text_field( $_POST[ 'wow-lname' ] ) : '';
    $message = !empty( $_POST[ 'wow-message' ] ) ? sanitize_text_field( $_POST[ 'wow-message' ] ) : '';
    $email = !empty( $_POST[ 'wow-email' ] ) ? sanitize_email( $_POST[ 'wow-email' ] ) : '';
    $type = !empty( $_POST[ 'wow-message-type' ] ) ? sanitize_text_field( $_POST[ 'wow-message-type' ] ) : '';

    if ( empty( $fname ) ) {
      $error[] = __( 'Please, Enter your First Name.', $this->text_domain );
    }
    if ( empty( $lname ) ) {
      $error[] = __( 'Please, Enter your Last Name.', $this->text_domain );
    }
    if ( empty( $message ) ) {
      $error[] = __( 'Please, Enter your Message.', $this->text_domain );
    }
    if ( empty( $email ) ) {
      $error[] = __( 'Please, Enter your Email.', $this->text_domain );
    }
    if ( count( $error ) == 0 ) {




      $headers = array(
        'From: ' . $fname . ' ' . $lname . ' <' . $email . '>',
        'content-type: text/html',
      );
      $message = '				
				<html>
				<head></head>
				<body>
				<table>				
				<tr>
				<td><strong>Plugin:</strong></td>
				<td>' . $plugin . '</td>
				</tr>
				<tr>
				<td><strong>Website:</strong></td>
				<td>' . $website . '</td>
				</tr>
				</table>
				' . $message . '					
				</body>
				</html>';
      wp_mail( 'support@wow-company.com', 'Support Ticket: ' . $type, $message, $headers );
      echo '<div class="wow-alert wow-alert-update "><p class="wow_error">' . __( 'Your Message sent to the Support.', $this->text_domain ) . '</p></div>';

    }


  } else {
    echo '<div class="wow-alert wow-alert-error "><p class="wow_error">' . __( 'Sorry, but message did not send. Please, contact us support@wow-company.com', $this->text_domain ) . ' </p></div>';
  }
}
?>
      <?php if ( count( $error ) > 0 ) echo '<div class="wow-alert wow-alert-error "><p class="wow_error">' . implode( "<br />", $error ) . '</p></div>'; ?>


      <form method="post" action="" class="wow-plugin">
        <div class="container">
          <div class="element">
            <label><?php _e( 'First Name', $this->text_domain ); ?></label><br/>
            <input type="text" name="wow-fname" value=""
                   placeholder="<?php _e( 'Enter Your First Name', $this->text_domain ); ?>">
          </div>
          <div class="element">
            <label><?php _e( 'Last Name', $this->text_domain ); ?></label><br/>
            <input type="text" name="wow-lname" value=""
                   placeholder="<?php _e( 'Enter Your Last Name', $this->text_domain ); ?>">
          </div>
        </div>
        <div class="container">
          <div class="element">
            <label><?php _e( 'WebSite', $this->text_domain ); ?></label><br/>
            <input type="text" disabled name="wow-website" value="<?php echo get_option( 'home' ); ?>">
          </div>
          <div class="element">
            <label><?php _e( 'Contact email', $this->text_domain ); ?></label><br/>
            <input type="text" name="wow-email" value="<?php echo get_option( 'admin_email' ); ?>">
          </div>

        </div>

        <div class="container">
          <div class="element">
            <label><?php _e( 'Plugin', $this->text_domain ); ?></label><br/>
            <input type="text" disabled name="wow-plugin" value="<?php if ( !empty( $name ) ) {
              echo $plugin;
            }; ?>">
          </div>
          <div class="element">
            <label><?php _e( 'Message type', $this->text_domain ); ?></label><br/>
            <select name="wow-message-type">
              <option value="Issue"><?php _e( 'Issue', $this->text_domain ); ?></option>
              <option value="Idea"><?php _e( 'Idea', $this->text_domain ); ?></option>
            </select>
          </div>
        </div>

        <div class="container">
          <div class="element">
          <textarea name="wow-message" rows="10"
                    placeholder="<?php _e( 'Enter Your Message', $this->text_domain ); ?>"></textarea>
          </div>
        </div>
        <div class="container">
          <div class="element">
            <input type="submit" class="add-item" name="action"
                   value="<?php _e( 'Send to Support', $this->text_domain ); ?>">
          </div>
        </div>
        <?php wp_nonce_field( 'wow_support_action', 'wow_support_field' ); ?>
      </form>
    </div>

  </div>
</div>
