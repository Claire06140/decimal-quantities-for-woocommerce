<?php
function dqfwc_check_woocommerce_active() {
    if ( class_exists( 'WooCommerce' ) ) {
        // Inclure les fichiers nécessaires
        require_once DQFWC_PLUGIN_PATH . 'includes/quantity-management.php';
        require_once DQFWC_PLUGIN_PATH . 'includes/integer-or-decimals-settings.php';
    } else {
        // Affiche un avis d'administration si WooCommerce n'est pas actif
        add_action( 'admin_notices', 'dqfwc_woocommerce_missing_notice' );
    }
}
add_action( 'plugins_loaded', 'dqfwc_check_woocommerce_active', 10 ); 

function dqfwc_woocommerce_missing_notice() {
    echo '<div class="error"><p>' . esc_html__( 'WooCommerce is required for the Decimal Quantities For WooCommerce Plugin to work. Please install and activate WooCommerce.', 'dqfwc' ) . '</p></div>';
}
