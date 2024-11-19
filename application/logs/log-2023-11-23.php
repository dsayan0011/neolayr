<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2023-11-23 23:24:03 --> Query error: Unknown column 'product_variants.variant_id' in 'field list' - Invalid query: SELECT `products_translations`.`id` as `productsTranslationsID`, `products`.`id` as `productID`, `products_translations`.`title` as `productTitle`, `product_variants`.`variant_id` as `variantID`, `product_variants`.`price` as `variantPrice`, `products`.`image` as `image`, `products`.`product_title`
FROM `products`
JOIN `products_translations` ON `products_translations`.`for_id` = `products`.`id`
WHERE `products`.`sku` = '446'
ERROR - 2023-11-23 23:24:03 --> Severity: error --> Exception: Call to a member function result_array() on bool D:\xampp\htdocs\neolayr_v3\application\models\Public_model.php 2376
ERROR - 2023-11-23 23:25:25 --> 404 Page Not Found: /index
ERROR - 2023-11-23 23:57:22 --> Image Upload Error: <p>You did not select a file to upload.</p>
ERROR - 2023-11-23 23:58:06 --> Image Upload Error: <p>You did not select a file to upload.</p>
ERROR - 2023-11-23 23:58:54 --> Image Upload Error: <p>You did not select a file to upload.</p>
