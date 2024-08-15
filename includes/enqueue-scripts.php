<?php

function dqfwc_enqueue_custom_quantity_script() {
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_script('custom-quantity', DQFWC_PLUGIN_URL . 'js/custom-quantity.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'dqfwc_enqueue_custom_quantity_script', 10);
