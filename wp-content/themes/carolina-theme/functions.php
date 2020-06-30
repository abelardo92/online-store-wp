<?php
// changing price order in product view
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 1);

// hooks filter example
add_filter('loop_shop_per_page', 'products_per_page');

function products_per_page($columns) {
    return 3;
}

// change to mexican pesos (MXN)
add_filter('woocommerce_currency_symbol', 'carolinaspa_mxn', 10, 2);

function carolinaspa_mxn($symbol, $coin) {
    $symbol = "MXN $";
    return $symbol;
}