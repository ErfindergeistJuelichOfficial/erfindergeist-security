<?PHP
/**
 * Plugin Name: Erfindergeist Security
 * Description: Security Erfindergeist Jülich e.V.
 * Author: Lars 'vreezy' Eschweiler
 * Author URI: https://www.vreezy.de
 * Version: 1.0.0
 * Text Domain: erfindergeist
 * Domain Path: /languages
 * Tested up to: 6.5
 *
 *
 * @package Erfindergeist-Security
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
  exit;
}


require_once 'vars.php';
require_once 'apis.php';

function egj_security_settings_page() {



  // getting new tokens handle
  if( isset($_POST[ $_SESSION['egj_security_hidden_field_input_name'] ]) && $_POST[ $_SESSION['egj_security_hidden_field_input_name'] ] == 'Y' ) {
    // Read their posted value
    $token_write_val = $_POST[ $_SESSION['egj_security_token_write_input_name'] ];
    $token_read_val = $_POST[ $_SESSION['egj_security_token_read_input_name'] ];

    // Save the posted value in the database
    update_option( $_SESSION['egj_security_token_write_option_name'],  $token_write_val );
    update_option( $_SESSION['egj_security_token_read_option_name'], $token_read_val );

    // Put a "settings saved" message on the screen
    ?>
      <div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
    <?php
  }

  // read tokens from options
  $token_write = get_option( $_SESSION['egj_security_token_write_option_name'] );
  $token_read = get_option( $_SESSION['egj_security_token_read_option_name'] );

  // Form
  ?>
    <div>
      <h3>Erfindergeist Security Settings</h3>
      <form name="form1" method="post" action="">
        <input type="hidden" name="<?php echo $_SESSION['egj_security_hidden_field_input_name']; ?>" value="Y">
        <p>Write Token:</p>
        <input type="text" name="<?php echo $_SESSION['egj_security_token_write_input_name']; ?>" value="<?php echo isset($token_write) ? esc_attr($token_write) : ''; ?>">
        <p>Read Token:</p>
        <input type="text" name="<?php echo $_SESSION['egj_security_token_read_input_name']; ?>" value="<?php echo isset($token_read) ? esc_attr($token_read) : ''; ?>">

        <p class="submit">
          <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>
      </form>
    </div>
  <?php


}

function egj_security_plugin_options() {



  ?>
    <div>
      <h3>Erfindergeist</h3>
      <p>Please use Submenus for Options</p>
    </div>
  <?php
}


function egj_security_plugin_menu() {

  if ( empty ( $GLOBALS['admin_page_hooks']['erfindergeist'] ) ) {
    add_menu_page(
      'Erfindergeist',
      'Erfindergeist',
      'manage_options',
      'erfindergeist',
      'egj_security_plugin_options'
    );
  }

  add_submenu_page(
    'erfindergeist',
    'Security',
    'Security Settings',
    'manage_options',
    'egj-security-options-submenu-handle',
    'egj_security_settings_page'
  );
}

add_action( 'admin_menu', 'egj_security_plugin_menu' );