<?php
/**
 * Registers WooGraphQL types to the schema.
 *
 * @package \CustomWishlist
 * @since   0.0.1
 */

namespace CustomWishlist;

/**
 * Class Type_Registry
 */
class Favourites {
  /**
   * @param int $user_id
   * @return array
   */
  public static function get_user_favourites(int $user_id) {
    /** @var \wpdb $wpdb */
    global $wpdb;
    $sql = $wpdb->prepare(
        "select product_id from user_favourites where user_id = %d",
        $user_id
    );
    $product_ids = $wpdb->get_col($sql);
    return $product_ids ? $product_ids : [];
  }
}
