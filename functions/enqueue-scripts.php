<?php
/**
 * Standard Enqueue
 */
function zume_site_scripts() {
    global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

    // Load What-Input files in footer
//    wp_enqueue_script( 'what-input', get_template_directory_uri() . '/vendor/what-input/dist/what-input.min.js', array(), '', true );

    // Load fitvids script https://github.com/rosszurowski/fitvids
//    wp_enqueue_script('fitvids', get_template_directory_uri() . '/assets/scripts/fitvids.min.js', array(), '', false);

    // Adding Foundation scripts file in the footer
//    wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/assets/scripts/foundation.min.js', array( 'jquery' ), '6.4.3', true );

    // Adding scripts file in the footer
    wp_enqueue_script( 'site-js', get_template_directory_uri() . '/assets/scripts/scripts.js', array( 'jquery' ), '', true );

//    wp_enqueue_style( 'buddypress-css', get_template_directory_uri() . '/assets/css/buddypress.css', array(), '', 'all' );

    // Register main stylesheet
    wp_enqueue_style( 'site-css', get_template_directory_uri() . '/assets/styles/style.min.css', array(), '', 'all' );

    // Comment reply script for threaded comments
    if ( is_singular() and comments_open() and ( get_option( 'thread_comments' ) == 1 )) {
        wp_enqueue_script( 'comment-reply' );
    }

    wp_register_script( 'jquery-steps', get_template_directory_uri() . '/assets/scripts/jquery.steps.js', array( 'jquery' ), null, true );
    wp_register_style( 'zume-course', get_template_directory_uri() . '/assets/styles/zume-course.css', false, null, 'all' ); // Relocated into the _main.scss theme file

    wp_enqueue_script( 'jquery-steps' );
    wp_enqueue_style( 'zume-course' );

    wp_register_style( 'zume_dashboard_style', get_template_directory_uri() . '/assets/styles/zume-dashboard.css' ); // Relocated to the _main.scss in the theme
    wp_enqueue_style( 'zume_dashboard_stylesheet', get_template_directory_uri() . '/assets/styles/zume-dashboard.css' );


}
add_action( 'wp_enqueue_scripts', 'zume_site_scripts', 999 );

/**
 * Login Enqueue
 */
function zume_login_css() {
    wp_enqueue_style( 'zume_login_css', get_template_directory_uri() . '/assets/styles/login.min.css', false );
}
add_action( 'login_enqueue_scripts', 'zume_login_css', 999 );
