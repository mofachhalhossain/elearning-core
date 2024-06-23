<?php
/*
Plugin Name: E-Learning Core
Description: Core functionality for E-Learning theme.
Version: 1.0
Author: Your Name
*/


require_once plugin_dir_path( __FILE__ ) . 'includes/loader.php';

function elearning_core_admin_menu() {
    add_menu_page(
        'Learning Core',
        'Learning Core',
        'manage_options',
        'learning-core',
        '',                  
        'dashicons-welcome-learn-more', 
        6                
    );
}
add_action( 'admin_menu', 'elearning_core_admin_menu' );


function elearning_core_activate() {

    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'elearning_core_activate' );


function elearning_core_deactivate() {

    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'elearning_core_deactivate' );
