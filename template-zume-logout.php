<?php
/**
 * Template Name: Zume Logout
 */
$current_language = zume_current_language();

wp_destroy_current_session();
wp_clear_auth_cookie();

if ( 'en' != $current_language ) {
    $home_url = site_url() . '/' . $current_language;
} else {
    $home_url = site_url();
}
wp_safe_redirect( $home_url );