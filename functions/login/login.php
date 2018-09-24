<?php
/**
 * Login customizations
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

/**
 * Changes the logo link from wordpress.org to your site
 */
function zume_site_url() {
    return site_url();
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
        $login_page  = zume_get_posts_translation_url( 'Login' );
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
    $login_page  = zume_get_posts_translation_url( 'Login' );
    wp_redirect( $login_page . '?login=failed' );
    exit;
}
add_action( 'wp_login_failed', 'zume_custom_login_failed' );

/* Where to go if any of the fields were empty */
function zume_verify_user_pass($user, $username, $password) {
    $login_page  = zume_get_posts_translation_url( 'Login' );
    if ($username == "" || $password == "") {
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
add_filter( 'authenticate', 'zume_verify_user_pass', 1, 3 );

/* What to do on logout */
function zume_logout_redirect() {
    $login_page  = zume_get_posts_translation_url( 'Logout' );
    wp_redirect( $login_page . "?login=false" );
    exit;
}
add_action( 'wp_logout', 'zume_logout_redirect' );

/* Modify default link for login */
function zume_login_url( $login_url, $redirect, $force_reauth ) {
    return zume_get_posts_translation_url( 'Login' );
}
add_filter( 'login_url', 'zume_login_url', 99, 3 );