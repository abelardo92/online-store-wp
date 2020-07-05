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

// create new section in home
function spa_new_product_presentation() {
    echo "<div class='spa-in-home'>";
    echo "<div class='image-category'>";
    $image = get_woocommerce_term_meta(20, 'thumbnail_id', true);
    $image_category = wp_get_attachment_image_src($image, 'full');
    if($image_category) {
        echo "<div class='image-destacada' style='background-image:url(".$image_category[0].")'></div>";
        echo "<h1>Spa en casa</h1>";
        echo "</div>";
    }
    echo "<div class='products'>";
    echo do_shortcode('[product_category columns="3" category="spa-en-casa"]');
    echo "</div>";
    echo "</div>";
}
add_action('homepage', 'spa_new_product_presentation', 30);

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

//  remove tabs
add_filter('woocommerce_product_tabs', 'spa_product_tabs', 11, 1);
function spa_product_tabs($tabs) {
    // example to remove a description
    // unset($tabs['description']);
    return $tabs;
}

// show discounts in amount

// add_filter('woocommerce_get_price_html', 'spa_quantity_saved', 10, 2);
// function spa_quantity_saved($price, $product) {
//     if($product->sale_price) {
//         $saving = wc_price($product->regular_price - $product->sale_price);
//         return $price ."<br>". sprintf(__('<span class="saving"> You will save %s</span>', 'woocommerce'), $saving);
//     }
//     return $price;
// }

// show discounts in percentaje
// add_filter('woocommerce_get_price_html', 'spa_percentaje_saved', 10, 2);
// function spa_percentaje_saved($price, $product) {
//     if($product->sale_price) {
//         $percentaje = round(($product->regular_price - $product->sale_price)/($product->regular_price) * 100);
//         return $price ."<br>". sprintf(__('<span class="saving"> You will save %s &#37</span>', 'woocommerce'), $percentaje);
//     }
//     return $price;
// }

// show saving in percentaje or amount depending on product price
function spa_saved_money($price, $product) {
    $regular_price = $product->get_regular_price();
    if($product->sale_price) {
        if($regular_price < 100) {
            $percentaje = round(($product->regular_price - $product->sale_price)/($product->regular_price) * 100);
            return $price ."<br>". sprintf(__('<span class="saving"> <strong>Save</strong> %s &#37</span>', 'woocommerce'), $percentaje);
        } else {
            $saving = wc_price($product->regular_price - $product->sale_price);
            return $price ."<br>". sprintf(__('<span class="saving"> <strong>Save</strong> %s</span>', 'woocommerce'), $saving);
        }
    }
    return $price;
}
add_filter('woocommerce_get_price_html', 'spa_saved_money', 10, 2);

// change tab text for product name
function spa_change_tab_text($tabs) {
    global $post;
    if(isset($tabs['description']['title'])) {
        $tabs['description']['title'] = $post->post_title;
    }
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'spa_change_tab_text', 10, 1);

function spa_change_title_tab($title) {
    global $post;
    return $post->post_title;
}
add_filter('woocommerce_product_description_heading', 'spa_change_title_tab', 10, 1);

// print subtitle with advanced custom fields
function spa_print_subtitle() {
    global $post;
    echo "<p class='subtitle'>".get_field('subtitle', $post->ID)."</p>";
}

add_filter('woocommerce_single_product_summary', 'spa_print_subtitle', 6);

// new tab for video with advanced custom fields
function spa_print_video($tabs) {
    $tabs['video'] = array(
        "title" => "Video",
        "priority" => 25,
        "callback" => 'my_product_video'
    );
    return $tabs;
}

function my_product_video() {
    global $post;
    $video = get_field('video', $post->ID);
    if($video) {
        echo "<video controls autoplay>";
        echo "<source src='" . $video . "'>";
        echo "</video>";
    } else {
        "Video is not available";
    }
}

add_filter('woocommerce_product_tabs', 'spa_print_video', 11, 1);

// Button to empty cart
function spa_clean_cart() {
    echo "<a class='button' href='?empty-cart=true'>".__('Empty Cart','woocommerce')."</a>";
}
add_action('woocommerce_cart_actions', 'spa_clean_cart');

function spa_empty_cart() {
    if(isset($_GET['empty-cart']) && $_GET['empty-cart'] == "true") {
        global $woocommerce;
        $woocommerce->cart->empty_cart();
    }
}
add_action('init', 'spa_empty_cart');

// print banner in cart
function spa_print_banner_cart() {
    global $post;
    $image = get_field('image', $post->ID);
    if($image) {
        echo "<div class='coupon-cart'>";
        echo "<img src='".$image."'/>";
        echo "</div>";
    }

}
add_action('woocommerce_check_cart_items', 'spa_print_banner_cart', 10);

// remove field from checkout form

function spa_remove_phone($fields) {
    unset($fields['billing']['billing_phone']);
    // example to add class to field
    $fields['billing']['billing_email']['class'] = array('form-row-wide','test');
    return $fields;
}

add_filter('woocommerce_checkout_fields', 'spa_remove_phone', 20, 1);

// Add field to checkout
function spa_checkout_fields($fields) {

    $fields['billing']['billing_factura'] = array(
        'type' => 'checkbox',
        'class' => array('form-row-wide'),
        'label' => 'Requiere factura?',
        'id' => 'factura'
    );

    $fields['billing']['billing_rfc'] = array(
        'type' => 'text',
        'class' => array('form-row-wide'),
        'label' => 'RFC'
    );

    // select2 class added but not working
    $fields['order']['billing_heard_us'] = array(
        'type' => 'select',
        'css' => array('form-row-wide','select2'),
        'label' => 'How did you find us?',
        'options' => array(
            'default' => 'Select one option...',
            'tv' => 'TV',
            'radio' => 'Radio',
            'newspapper' => 'Newspapper',
            'facebook' => 'Facebook',
        ),

    );

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'spa_checkout_fields', 40, 1);

// hide/show RFC
function spa_hide_show_rfc() {
    if(is_checkout()) {
        ?>
        <script>
            jQuery(document).ready(function(){
                jQuery("input[type='checkbox']#factura").on('change', function(){
                    jQuery("#billing_rfc_field").slideToggle();
                });
            });
        </script>
        <?php
    }
}
add_action('wp_footer', 'spa_hide_show_rfc');


// insert custom fields data in database

function spa_insert_checkout_custom_fields($order_id) {
    if(!empty($_POST['billing_rfc'])) {
        update_post_meta($order_id, 'rfc', sanitize_text_field($_POST['billing_rfc']));
    }
    if(!empty($_POST['billing_factura'])) {
        update_post_meta($order_id, 'factura', sanitize_text_field($_POST['billing_factura']));
    }
    if(!empty($_POST['billing_heard_us'])) {
        update_post_meta($order_id, 'heard_us', sanitize_text_field($_POST['billing_heard_us']));
    }
}
add_action('woocommerce_checkout_update_order_meta', 'spa_insert_checkout_custom_fields');

// add custom fields to orders
function spa_columns_orders($columns) {
    $columns['factura'] = __('Factura', 'woocommerce');
    $columns['rfc'] = __('RFC', 'woocommerce');
    $columns['heard_us'] = __('How did you heard about us?', 'woocommerce');
    return $columns;
}
add_filter('manage_edit-shop_order_columns', 'spa_columns_orders');

// show content inside orders columns
function spa_columns_orders_data($columns) {
    global $post, $woocommerce, $order;
    
    if(empty($order) || $order->id != $post->ID) {
        $order = new WC_Order($post->ID);
    }

    if($columns === "factura") {
        $factura = get_post_meta($post->ID, 'factura', true);
        echo $factura ? "Yes" : "No";
    }
    if($columns === "rfc") {
        echo get_post_meta($post->ID, 'rfc', true);
    }
    if($columns === "heard_us") {
        echo get_post_meta($post->ID, 'heard_us', true);
    }

    return $columns;
}
add_action('manage_shop_order_posts_custom_column', 'spa_columns_orders_data');

// Show custom field in orders
function spa_show_orders_info($order) {
    $factura = get_post_meta($order->ID, 'factura', true);
    if($factura) {
        echo "<p><strong>".__('Factura', 'woocommerce').":</strong> " . ($factura ? "Yes" : "No") . "</p>";
        $rfc = get_post_meta($order->ID, 'rfc', true);
        echo "<p><strong>".__('RFC', 'woocommerce').":</strong> $rfc</p>";
    }
    $heard_us = get_post_meta($order->ID, 'heard_us', true);
    echo "<p><strong>".__('How did you heard about us?', 'woocommerce').":</strong> $heard_us</p>";
}
add_action('woocommerce_admin_order_data_after_billing_address', 'spa_show_orders_info');