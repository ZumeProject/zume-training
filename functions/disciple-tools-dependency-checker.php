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
$symlink_mapping_folder = get_theme_file_path() . '/functions/dt-mapping/';
if ( is_link(  $symlink_mapping_folder ) ) {
    // load through sym
    $dir = scandir( $symlink_mapping_folder . 'geocode-api/' );
    foreach ( $dir as $file ) {
        if ( 'php' === substr( $file, -3, 3 ) ) {
            require_once( $symlink_mapping_folder . 'geocode-api/' . $file );
        }
    }
} else {
    // load direct
    $dir = scandir( $disciple_tools_theme . 'dt-mapping/geocode-api/' );
    foreach ( $dir as $file ) {
        if ( 'php' === substr( $file, -3, 3 ) ) {
            require_once( $disciple_tools_theme . 'dt-mapping/geocode-api/' . $file );
        }
    }
}
