<?php
// changing price order in product view
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 1);

// hooks filter example
add_filter('loop_shop_per_page', 'products_per_page');

function products_per_page($products) {
    return 30;
}

// columns per produts page
function spa_columns($columns) {
    $columns = 4;
    return $columns;
}
add_filter('loop_shop_columns', 'spa_columns', 20);


// change to mexican pesos (MXN)
add_filter('woocommerce_currency_symbol', 'carolinaspa_mxn', 10, 2);

function carolinaspa_mxn($symbol, $coin) {
    $symbol = "MXN $";
    return $symbol;
}

// update footer's copyright
function spa_copyright() {
    remove_action('storefront_footer', 'storefront_credit', 20);
    add_action('storefront_after_footer', 'spa_new_footer', 20);
}
add_action('init', 'spa_copyright');
function spa_new_footer() {
    echo "<div class='copyright'>Copyright &copy;". get_bloginfo('name') . " " . get_the_date('Y') ."</div>";
}

// add image to homepage
function spa_discount() {
    $image = "<div class='offer'>";
    $image .= "<img src='".get_stylesheet_directory_uri()."/img/cupon.jpg' />";
    $image .= "</div>";
    echo $image;
}
add_action('homepage', 'spa_discount', 9);

// show 4 categories in homepage
function spa_categories($args) {
    $args['limit'] = 4;
    $args['columns'] = 4;
    return $args;
}
add_filter('storefront_product_categories_args','spa_categories', 100);

// change text to filter
function spa_change_sort($filter) {

    // Example to show variables content

    // echo "<pre>";
    // var_dump($filter);
    // echo "</pre>";

    $filter['date'] = __('New Products First', 'woocommerce');
    return $filter;
}
add_filter('woocommerce_catalog_orderby','spa_change_sort', 40);
