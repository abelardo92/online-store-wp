<?php
// changing price order in product view
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 1);

// hooks filter example
add_filter('loop_shop_per_page', 'products_per_page');

function products_per_page($columns) {
    return 3;
}
