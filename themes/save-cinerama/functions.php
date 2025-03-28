<?php
// Include the hero-header.php file before anything else

include_once get_stylesheet_directory() . '/mention-post-type/mention-post-type.php';




include get_stylesheet_directory() . '/hero-header/hero-header.php';

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'hello-elementor'; // This is 'twenty-twenty-one-style' for the Twenty Twenty-one theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(), // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'custom-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}

// function enqueue_hero_header_scripts() {
//     // Register the script
//     wp_register_script(
//         'animate-letters', // Handle
//         get_stylesheet_directory_uri() . '/hero-header/scripts/animateLetters.js', // Path to the script
//         [], // Dependencies (none in this case)
//         null, // Version (optional)
//         false // Load in the footer
//     );

//     // Enqueue the script
//     wp_enqueue_script('animate-letters');
// }
// add_action('wp_enqueue_scripts', 'enqueue_hero_header_scripts');

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_add_parent_dep' ) ):
function chld_thm_cfg_add_parent_dep() {
    global $wp_styles;
    array_unshift( $wp_styles->registered[ 'custom-style' ]->deps, 'hello-elementor' );
}
endif;
add_action( 'wp_head', 'chld_thm_cfg_add_parent_dep', 2 );

// END ENQUEUE PARENT ACTION
?>