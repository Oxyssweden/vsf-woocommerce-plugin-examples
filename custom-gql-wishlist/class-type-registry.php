<?php
/**
 * Registers WooGraphQL types to the schema.
 *
 * @package \CustomWishlist
 * @since   0.0.1
 */

namespace CustomWishlist;

require_once 'includes/class-favourites.php';
require_once 'includes/mutation/class-favourite-mutation.php';
require_once 'includes/type/class-favourite-fields.php';

/**
 * Class Type_Registry
 */
class Type_Registry {

	/**
	 * Registers WooGraphQL types, connections, unions, and mutations to GraphQL schema
	 */
	public function init() {
		// Object fields.
    \CustomWishlist\Type\FavouriteFields::register_fields();

		// Mutations.
		\CustomWishlist\Mutation\FavouriteMutation::register_mutation();
	}
}
