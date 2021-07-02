<?php
/**
 * Registers WooGraphQL types to the schema.
 *
 * @package \CustomWishlist
 * @since   0.0.1
 */

namespace CustomWishlist\Type;

use CustomWishlist\Favourites;

/**
 * Class Type_Registry
 */
class FavouriteFields {
  /**
   * Registers the favourites field.
   *
   * @return void
   * @throws Exception
   */
  public static function register_fields() {
    register_graphql_field( 'Customer', 'wishlist', [
        'type' => [ 'list_of' => 'Int' ],
        'description' => __( 'Customers favourite products', 'picsmart' ),
        'resolve'     => function( \WPGraphQL\WooCommerce\Model\Customer $source ) {
          return Favourites::get_user_favourites($source->get_id());
        },
    ] );
  }
}
