<?php

// decimal_quantity for product helper
/* function dqfwc_is_integer_quantity_product($product_id) {
	return get_post_meta($product_id, '_integer_quantity', true) === 'yes';
} */
function dqfwc_is_integer_quantity_product($product_id) {
    $is_integer = get_post_meta($product_id, '_integer_quantity', true) === 'yes';
    error_log("Product ID in IS INTEGER function: $product_id, Is Integer: " . ($is_integer ? 'Yes' : 'No'));
    return $is_integer;
}
add_action('woocommerce_product_options_inventory_product_data', 'dqfwc_add_integer_quantity_field');

function dqfwc_add_integer_quantity_field() {
    woocommerce_wp_checkbox(array(
        'id' => '_integer_quantity',
        'label' => __('Non-decimal Quantity (integer)', 'dqfwc'),
        'description' => __('Leave unchecked for decimal quantity (check this box if the product quantity should be an integer, non-decimal number)', 'dqfwc')
    ));
}

add_action('woocommerce_process_product_meta', 'dqfwc_save_integer_quantity_field');
// Save value on product update
function dqfwc_save_integer_quantity_field($post_id) {
    $integer_quantity = sanitize_text_field($_POST['_integer_quantity']) === 'yes' ? 'yes' : 'no';
    update_post_meta($post_id, '_integer_quantity', $integer_quantity);
}

// Classe integer-quantity in product page
add_filter('post_class', 'dqfwc_add_integer_quantity_class', 10, 3);
function dqfwc_add_integer_quantity_class($classes, $class, $post_id) {
    if (get_post_type($post_id) === 'product' && dqfwc_is_integer_quantity_product($post_id)) {
        $classes[] = 'integer-quantity';
    }
    return $classes;
}

// Class quantity in cart
add_filter('woocommerce_cart_item_class', 'dqfwc_add_integer_quantity_class_to_cart_item', 10, 3);
function dqfwc_add_integer_quantity_class_to_cart_item($class, $cart_item, $cart_item_key) {
    error_log('Cart Item Key: ' . $cart_item_key);
    error_log('Cart Item: ' . print_r($cart_item, true));
    error_log('Class: ' . $class);
    error_log('Cart Item Product ID: ' . ($cart_item['product_id']) ? $cart_item['product_id'] : 'Not set');
    if (isset($cart_item['product_id'])) {
        $product_id = $cart_item['product_id'];
        error_log('Product ID in ADD ITG QUANTITY CLASS TO CART IETM function: ' . $product_id);
        $is_integer = dqfwc_is_integer_quantity_product($product_id);
        error_log("Cart Item: Product ID: $product_id, Is Integer: " . ($is_integer ? 'Yes' : 'No'));
        if ($is_integer) {
            $class .= ' integer-quantity';
        }
        else {
            $class .= ' decimal-quantity';
        }
    }
    return $class;
}
