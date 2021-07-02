<?php
/**
 * Registers WooGraphQL types to the schema.
 *
 * @package \CustomWishlist
 * @since   0.0.1
 */

namespace CustomWishlist\Mutation;

use CustomWishlist\Favourites;

/**
 * Class Type_Registry
 */
class FavouriteMutation {
  /**
   * Registers the CommentCreate mutation.
   *
   * @return void
   * @throws Exception
   */
  public static function register_mutation() {
    register_graphql_mutation(
        'addToWishlist',
        [
            'inputFields'         => self::get_input_fields(),
            'outputFields'        => self::get_output_fields(),
            'mutateAndGetPayload' => self::add_whishlist_mutate_and_get_payload(),
        ]
    );
    register_graphql_mutation(
        'removeFromWishlist',
        [
            'inputFields'         => self::get_input_fields(),
            'outputFields'        => self::get_output_fields(),
            'mutateAndGetPayload' => self::remove_whishlist_mutate_and_get_payload(),
        ]
    );
    register_graphql_mutation(
        'emptyWishlist',
        [
            'outputFields'        => self::get_output_fields(),
            'mutateAndGetPayload' => self::empty_whishlist_mutate_and_get_payload(),
        ]
    );
  }

  /**
   * Defines the mutation data modification closure.
   *
   * @return callable
   */
  public static function add_whishlist_mutate_and_get_payload() {
    return function( $input, $context, $info ) {
      global $wpdb;
      $favourites = [];

      // Do any logic here to sanitize the input, check user capabilities, etc
      $user = wp_get_current_user();
      if ( $user instanceof \WP_User && 0 !== $user->ID ) {
        $favourites = Favourites::get_user_favourites($user->ID);

        if (!in_array($input['productId'], $favourites)) {
          $data = [
              'product_id' => $input['productId'],
              'user_id' => $user->ID,
              'added' => date("Y-m-d H:i:s", time()),
          ];
          $wpdb->insert('user_favourites', $data, ['%d', '%d', '%s', '%s']);
          $favourites[] = $input['productId'];
        }
      }

      return ['wishlist' => $favourites];
    };
  }

  /**
   * Defines the mutation data modification closure.
   *
   * @return callable
   */
  public static function remove_whishlist_mutate_and_get_payload() {
    return function( $input, $context, $info ) {
      global $wpdb;
      $favourites = [];

      // Do any logic here to sanitize the input, check user capabilities, etc
      $user = wp_get_current_user();
      if ( $user instanceof \WP_User && 0 !== $user->ID ) {
        $data = [
            'product_id' => $input['productId'],
            'user_id' => $user->ID,
        ];
        $wpdb->delete('user_favourites', $data, ['%d', '%d']);

        $favourites = Favourites::get_user_favourites($user->ID);
      }

      return ['wishlist' => $favourites];
    };
  }

  /**
   * Defines the mutation data modification closure.
   *
   * @return callable
   */
  public static function empty_whishlist_mutate_and_get_payload() {
    return function( $input, $context, $info ) {
      global $wpdb;

      // Do any logic here to sanitize the input, check user capabilities, etc
      $user = wp_get_current_user();
      if ( $user instanceof \WP_User && 0 !== $user->ID ) {
        $data = [ 'user_id' => $user->ID ];
        $wpdb->delete('user_favourites', $data, ['%d']);
      }

      return ['wishlist' => []];
    };
  }

  /**
   * Defines the mutation input field configuration.
   *
   * @return array
   */
  public static function get_input_fields() {
    return [
        'productId' => [
            'type' => 'Int',
            'description' => __( 'Product database ID', 'picsmart' ),
        ]
    ];
  }

  /**
   * Defines the mutation output field configuration.
   *
   * @return array
   */
  public static function get_output_fields() {
    return [
        'wishlist' => [
            'type' => [ 'list_of' => 'Int' ],
            'description' => __( 'Customers favourite products', 'picsmart' ),
            'resolve' => function( $payload, $args, $context, $info ) {
              return $payload['wishlist'];
            }
        ]
    ];
  }
}
