<?php
/**
 * Plugin Name: VSF custom GQL wishlist
 */

require_once 'class-type-registry.php';

// Initialize WooGraphQL TypeRegistry.
$registry = new \CustomWishlist\Type_Registry();
add_action( 'graphql_register_types', array( $registry, 'init' ), 10, 1 );
