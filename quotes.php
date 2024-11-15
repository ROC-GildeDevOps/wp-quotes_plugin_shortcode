<?php
/*
Plugin Name: Quotes
Plugin URI: https://www.youtube.com/watch?v=8eZXq2k8UhM
Description: Displays 5-10 inspiring quotes.
Version: 0.0.1
Author: Tristán
Author URI: https://github.com/Tristan-23
*/

// Prevent direct access to the file
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin path
define( 'QUOTES_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Include functions file if it lives
if ( file_exists( QUOTES_PLUGIN_PATH . 'includes/functions.php' ) ) {
    require_once( QUOTES_PLUGIN_PATH . 'includes/functions.php' );
}

// Link the CSS and JS files
function quotes_plugin_enqueue_scripts() {
    wp_enqueue_style( 
        'quotes-plugin-styles', 
        plugin_dir_url( __FILE__ ) . 'assets/css/style.css' 
    );
    wp_enqueue_script( 
        'quotes-plugin-scripts', 
        plugin_dir_url( __FILE__ ) . 'assets/js/script.js', 
        array( 'jquery' ), 
        null, 
        true 
    );
}
add_action( 'wp_enqueue_scripts', 'quotes_plugin_enqueue_scripts' );

// Eventhandler when activated
function quotes_plugin_activate() {
    error_log( 'Quotes Plugin activated.' );
}
register_activation_hook( __FILE__, 'quotes_plugin_activate' );

// Eventhandler when stopped
function quotes_plugin_deactivate() {
    error_log( 'Quotes Plugin deactivated.' );
}
register_deactivation_hook( __FILE__, 'quotes_plugin_deactivate' );

// Shortcode for displaying a quote of the day
function quotes_plugin_shortcode() {
    $quotes = quotes_plugin_load_quotes();

    if ( empty( $quotes ) ) {
        return '<p class="quote">No quotes available at the moment.</p>';
    }

    // Select a random quote
    $random_quote = $quotes[ array_rand( $quotes ) ];

    // Create the mockup
    $output = '<div class="quotes-plugin">';
    if ( isset( $random_quote['quote'] ) && isset( $random_quote['author'] ) ) {
        $output .= '<p class="quote">"' . esc_html( $random_quote['quote'] ) . '"</p>';
        $output .= '<p class="author">- ' . esc_html( $random_quote['author'] ) . '</p>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode( 'quote_of_the_day', 'quotes_plugin_shortcode' );

