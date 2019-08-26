<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly
/**
 * To avoid duplicating classes and resources, this theme/plugin requires Disciple Tools Theme to be installed on
 * the hosting system. The Disciple Tools system does not need to be active, but it does need to be an installed theme
 * inside the themes folder with this theme.
 */

// Setup Disciple Tools
$disciple_tools_theme = ABSPATH . 'wp-content/themes/disciple-tools-theme/';

if ( ! file_exists( $disciple_tools_theme ) ) {
    error_log( 'Disciple Tools Theme not found. Please, install Disciple Tools Theme.' );
    exit;
}

// Load Mapping Symlink
if ( ! is_link(  get_theme_file_path() . '/functions/dt-mapping' ) ) {
    error_log('fail: ' . get_theme_file_path() . '/functions/dt-mapping' );
}

if ( ! file_exists( 'dt-mapping/geocode-api/google-api.php' ) ) {
    require_once( $disciple_tools_theme . 'dt-mapping/geocode-api/google-api.php' );
}
if ( ! file_exists( 'dt-mapping/geocode-api/ipstack-api.php' ) ) {
    require_once( $disciple_tools_theme . 'dt-mapping/geocode-api/ipstack-api.php' );
}
if ( ! file_exists( 'dt-mapping/geocode-api/mapbox-api.php' ) ) {
    require_once( $disciple_tools_theme . 'dt-mapping/geocode-api/mapbox-api.php' );
}
