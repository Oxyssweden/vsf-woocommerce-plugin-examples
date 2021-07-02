#Example VSF wishlist plugin for Woocommerce.

This is a super simple user favourite products plugin for Vue Storefront 2. You can adapt this to work with other existing WooCommerce favourites plugins by adjusting the database queris in this plugin.  

You can use it as it is if you create this DB table:

```

CREATE TABLE `user_favourites2` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `product_id` int(9) NOT NULL,
  `user_id` int(9) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci

```