<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

require_once 'vars.php';

function egj_security_read_api( $data ) {
  // https://stackoverflow.com/questions/53126137/wordpress-rest-api-custom-endpoint-with-url-parameter
  // $product_ID = $data['id'];
  $token_param = $data->get_param( 'token' );
  $token_read = get_option( $_SESSION['egj_security_token_read_option_name'] );

  if($token_param != $token_read) {
    return new WP_Error('rest_custom_error', 'Unknown Error', array('status' => 400));
  }

}

// CUSTOM APIS
// https://egj.vreezy.de/wp-json/erfindergeist/v1/gcalendar
function egj_security_read_route() {
  register_rest_route('erfindergeist/v1', '/security/read/', array(
    'methods'  => 'GET',
    'callback' => 'egj_security_read_api'
  ));

  register_rest_route('erfindergeist/v1', '/security/write/', array(
    'methods'  => 'GET',
    'callback' => 'egj_security_write_api'
  ));
};

add_action('rest_api_init', egj_security_read_route());


?>