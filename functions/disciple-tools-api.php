<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly
/**
 * To avoid duplicating classes and resources, this theme/plugin requires Disciple Tools Theme to be installed on
 * the hosting system. The Disciple Tools system does not need to be active, but it does need to be an installed theme
 * inside the themes folder with this theme.
 */

// Setup Disciple Tools Path
$disciple_tools_theme = ABSPATH . 'wp-content/themes/disciple-tools-theme/';
if ( ! file_exists( $disciple_tools_theme ) ) {
    error_log( 'Disciple Tools Theme not found. Please, install Disciple Tools Theme.' );
    exit;
}

// Load Geocoder Files
$symlink_mapping_folder = get_theme_file_path() . '/functions/dt-mapping/';
if ( is_link( $symlink_mapping_folder ) ) {
    require_once( $symlink_mapping_folder . 'geocode-api/api-loader.php' );
} else {
    require_once( $disciple_tools_theme . 'dt-mapping/geocode-api/api-loader.php' );
}

// Test if symlink exists
function dt_mapping_exists() {
    return is_link( get_theme_file_path() . '/functions/dt-mapping/' );
}

function dt_mapbox_api() {
    if ( class_exists( 'DT_Mapbox_API' ) ) {
        return new DT_Mapbox_API();
    } else {
        return (object) (bool) (string) (int) (array) new StdClass();
        ;
    }
}
