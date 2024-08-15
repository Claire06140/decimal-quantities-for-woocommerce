<?php

function dqfwc_custom_quantity_input_step($step, $product) {
    return 0.1;
}

function dqfwc_debug_quantity_input_args($args, $product) {
  error_log('Quantity input args: ' . print_r($args, true));
  return $args;
}


// Defined quantity arguments
function dqfwc_custom_quantity_input_args( $args, $product ) {
	$integer_quantity = get_post_meta($product->get_id(), '_integer_quantity', true);
    if ($integer_quantity === 'yes') {
        $args['step'] = 1;
        $args['min_value'] = max(1, $args['min_value']);
        $args['max_value'] = isset($args['max_value']) ? floor($args['max_value']) : '';
    } else {
    $args['step']        = 0.1;
	$args['min_value'] = 1;
	}
	return $args;			
}

add_filter('woocommerce_quantity_input_step', 'dqfwc_custom_quantity_input_step', 10, 2);
add_filter('woocommerce_quantity_input_args', 'dqfwc_debug_quantity_input_args', 20, 2);
add_filter( 'woocommerce_quantity_input_args', 'dqfwc_custom_quantity_input_args', 30, 2 );

// Change integer for float filter (frontend and backend)
remove_filter('woocommerce_stock_amount', 'intval');
add_filter('woocommerce_stock_amount', 'floatval', 5);

