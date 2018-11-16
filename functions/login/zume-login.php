<?php
/**
 * Login customizations
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

/**********************************************************************************************************************
 * Customize links for signup and registration
 * @see wp-login.php:765
 */
add_filter( 'wp_signup_location', 'zume_multisite_signup_location', 99, 1 );
function zume_multisite_signup_location( $url ) {
    $url = zume_get_posts_translation_url( 'Login', zume_current_language() );
    return $url;
}
add_filter( 'register_url', 'zume_multisite_register_location', 99, 1 );
function zume_multisite_register_location( $url ) {
    $url = zume_get_posts_translation_url( 'Login', zume_current_language() ) . '/?action=registration';
    return $url;
}

/**
 * Modify default link for login
 * @see zume-functions.php for the function
 */
add_filter( 'login_url', 'zume_login_url', 99, 3 );

/**
 * Update User IP Address location on login
 */
add_action( 'wp_login', 'zume_login_update_ip_info', 10, 2 );
function zume_login_update_ip_info( $user_login, $user ) {
    zume_update_user_ip_address_and_location( $user->ID );
}

/**
 * LOGIN
 */
/**
 * Changes the logo link from wordpress.org to your site
 */
function zume_site_url() {
    $current_language = zume_current_language();
    if ( 'en' != $current_language ) {
        $home_url = site_url() . '/' . $current_language;
    } else {
        $home_url = site_url();
    }
    return $home_url;
}
add_filter( 'login_headerurl', 'zume_site_url' );

/**
 * Changes the alt text on the logo to show your site name
 */
function zume_login_title() {
    return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'zume_login_title' );

/* Main redirection of the default login page */
function zume_redirect_login_page() {
    if ( isset( $_SERVER['REQUEST_URI'] ) && !empty( $_SERVER['REQUEST_URI'] ) ) {
        $login_page  = zume_get_posts_translation_url( 'Login', zume_current_language() );
        $page_viewed = basename( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );

        if ( isset( $_SERVER['REQUEST_METHOD'] ) && $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
            wp_redirect( $login_page );
            exit;
        }
    }
}
add_action( 'init', 'zume_redirect_login_page' );

/* Where to go if a login failed */
function zume_custom_login_failed() {
    $login_page  = zume_get_posts_translation_url( 'Login', zume_current_language() );
    wp_redirect( $login_page . '?login=failed' );
    exit;
}
add_action( 'wp_login_failed', 'zume_custom_login_failed' );

/* Where to go if any of the fields were empty */
function zume_verify_user_pass($user, $username, $password) {
    $login_page  = zume_get_posts_translation_url( 'Login', zume_current_language() );
    if ($username == "" || $password == "") {
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
add_filter( 'authenticate', 'zume_verify_user_pass', 1, 3 );