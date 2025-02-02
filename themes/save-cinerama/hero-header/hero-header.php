<?php
function hero_header() {
    return '<h1>hello world</h1>';
}

add_shortcode('cinerama_hero_header', 'hero_header');

// Debugging information
if (shortcode_exists('cinerama_hero_header')) {
    error_log('Shortcode cinerama_hero_header registered successfully.');
} else {
    error_log('Failed to register shortcode cinerama_hero_header.');
}
?>