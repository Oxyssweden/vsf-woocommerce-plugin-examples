<?php
/**
 * Plugin Name: Woo Cart Session VSF integration
 */
add_filter( 'woocommerce_session_handler', 'wc_vsf_cart_woocommerce_session_handler');
add_filter( 'graphql_woocommerce_cart_session_header', 'wc_vsf_cart_graphql_woocommerce_cart_session_header');

function wc_vsf_cart_woocommerce_session_handler( $session_class ) {
  if (defined("IS_VSF") && class_exists('\WPGraphQL\WooCommerce\Utils\QL_Session_Handler')) {
    $session_class = '\WPGraphQL\WooCommerce\Utils\QL_Session_Handler';
  }
  return $session_class;
}

function wc_vsf_cart_graphql_woocommerce_cart_session_header( $session_header ) {
  if (!$session_header && isset($_COOKIE['vsf-customer'])) {
    $session_header = 'Session ' . $_COOKIE['vsf-customer'];
  }
  return $session_header;
}
