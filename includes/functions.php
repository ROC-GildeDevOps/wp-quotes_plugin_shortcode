<?php

// Load quotes from JSON file
function quotes_plugin_load_quotes() {
    $quotes_file = QUOTES_PLUGIN_PATH . 'includes/quotes.json';

    if ( file_exists( $quotes_file ) ) {
        $quotes_content = file_get_contents( $quotes_file );
        $quotes = json_decode( $quotes_content, true );

        if ( json_last_error() === JSON_ERROR_NONE && is_array( $quotes ) ) {
            return $quotes;
        } else {
            error_log( 'Quotes Plugin: JSON decode error - ' . json_last_error_msg() );
        }
    } else {
        error_log( 'Quotes Plugin: Quotes file not found at ' . $quotes_file );
    }
    return [];
}