<?php
/*
Plugin Name: Decimal Quantities for WooCommerce NEW
Description: Adds decimal quantity option for WooCommerce products while allowing integer (non-decimal) quantities
Version: 1.0
Author: Claire Marchyllie
Text Domain: dqfwc
*/

if (!defined('WPINC')) {
    exit;
}

// Définir le chemin du plugin
if ( ! defined( 'DQFWC_PLUGIN_PATH' ) ) {
    define( 'DQFWC_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'DQFWC_PLUGIN_URL' ) ) {
    define( 'DQFWC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}


function dqfwc_load_textdomain() {
    load_plugin_textdomain( 'dqfwc', false, basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'dqfwc_load_textdomain' );

// Inclure les fichiers principaux qui enqueue les scripts et lancent les fonctions du plugin après avoir vérifié si woo commerce était bien installé
require_once DQFWC_PLUGIN_PATH . 'includes/enqueue-scripts.php';
require_once DQFWC_PLUGIN_PATH . 'includes/check-woocommerce.php';
