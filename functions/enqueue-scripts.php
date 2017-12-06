<?php
/**
 * Load scripts
 *
 * @param string $handle
 * @param string $rel_src
 * @param array  $deps
 * @param bool   $in_footer
 */
function zume_enqueue_script( $handle, $rel_src, $deps = array(), $in_footer = false ) {
    if ( $rel_src[0] === "/" ) {
        throw new Error( "zume_enqueue_script took \$rel_src argument which unexpectedly started with /" );
    }
    wp_enqueue_script( $handle, get_template_directory_uri() . "/$rel_src", $deps, filemtime( get_template_directory() . "/$rel_src" ), $in_footer );
}

/**
 * Load styles
 *
 * @param string $handle
 * @param string $rel_src
 * @param array  $deps
 * @param string $media
 */
function zume_enqueue_style( $handle, $rel_src, $deps = array(), $media = 'all' ) {
    if ( $rel_src[0] === "/" ) {
        throw new Error( "zume_enqueue_style took \$rel_src argument which unexpectedly started with /" );
    }
    wp_enqueue_style( $handle, get_template_directory_uri() . "/$rel_src", $deps, filemtime( get_template_directory() . "/$rel_src" ), $media );
}

/**
 * Standard Enqueue
 */
function zume_site_scripts() {
    global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

    // Load What-Input files in footer
//  zume_enqueue_script( 'what-input', 'vendor/what-input/dist/what-input.min.js', array(), true );

    // Load fitvids script https://github.com/rosszurowski/fitvids
//    zume_enqueue_script( 'fitvids', 'assets/scripts/fitvids.min.js', array(), false );

    // Adding Foundation scripts file in the footer
//    zume_enqueue_script( 'foundation-js', 'assets/scripts/foundation.min.js', array( 'jquery' ), true );

    // Adding scripts file in the footer
    zume_enqueue_script( 'site-js', 'assets/scripts/scripts.js', array( 'jquery' ), true );

//    zume_enqueue_style( 'buddypress-css', 'assets/css/buddypress.css', array(), 'all' );

    // Register main stylesheet
    zume_enqueue_style( 'site-css', 'assets/styles/style.min.css', array(), 'all' );

    // Comment reply script for threaded comments
    if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1 )) {
        wp_enqueue_script( 'comment-reply' );
    }

    zume_enqueue_script( 'jquery-steps', 'assets/scripts/jquery.steps.js', array( 'jquery' ), true );
    zume_enqueue_style( 'zume-course', 'assets/styles/zume-course.css', array(), 'all' ); // Relocated into the _main.scss theme file

    zume_enqueue_style( 'zume_dashboard_style', 'assets/styles/zume-dashboard.css' ); // Relocated to the _main.scss in the theme


}
add_action( 'wp_enqueue_scripts', 'zume_site_scripts', 999 );

/**
 * Login Enqueue
 */
function zume_login_css() {
    zume_enqueue_style( 'zume_login_css', 'assets/styles/login.min.css', array() );
}
add_action( 'login_enqueue_scripts', 'zume_login_css', 999 );
