<?php
/**
 * This utility is to assist with themes and plugins determining if Disciple Tools exists and files can be loaded
 */


if ( ! defined( 'IS_DISCIPLE_TOOLS' ) ) {
    global $dt_starter_required_dt_theme_version;
    $wp_theme = wp_get_theme();
    $version = $wp_theme->version;
    /*
     * Check if the Disciple.Tools theme is loaded and is the latest required version
     */
    $is_theme_dt = strpos( $wp_theme->get_template(), "disciple-tools-theme" ) !== false || $wp_theme->name === "Disciple Tools";
    define ( 'IS_DISCIPLE_TOOLS', $is_theme_dt );
}
dt_write_log(IS_DISCIPLE_TOOLS);
if ( ! defined( 'DISCIPLE_TOOLS_EXISTS') ) {
    if ( file_exists( get_theme_root() . '/disciple-tools-theme/functions.php' ) ) {
        $exists = true;
    } else {
        $exists = false;
    }
    define( 'DISCIPLE_TOOLS_EXISTS', $exists );
}

if ( ! defined( '__DISCIPLE_TOOLS_PATH__' ) ) {
    if ( DISCIPLE_TOOLS_EXISTS ) {
        $path = get_theme_root() . '/disciple-tools-theme/';
        define( '__DISCIPLE_TOOLS_PATH__', $path );
    } else {
        error_log('Disciple Tools theme is unreachable. Tried to connect to: '.get_theme_root() . '/disciple-tools-theme/functions.php' );
        die('Disciple Tools theme is unreachable');
    }
}

if ( ! function_exists( 'disciple_tools_load_dependencies' ) ) {
    function disciple_tools_load_dependencies( $file = null ) {
        $requested_files = apply_filters( 'disciple_tools_required_file', [] );
        if ( ! empty( $file ) ) {
            $requested_files[] = $file;
        }
        if ( ! empty( $requested_files ) && is_array( $requested_files ) ) { // check for loaded array
            $required_files = get_required_files(); // get currently required files
            foreach ( $requested_files as $file ) {
                $full_path = __DISCIPLE_TOOLS_PATH__ . ltrim( $file, '/');
                if ( array_search( $full_path, $required_files ) === false && file_exists( $full_path ) ) { // test if previously included & requested file exists
                    require_once( $full_path );
                }
            }
        }
    }
}
add_action( 'setup_theme', 'disciple_tools_load_dependencies' );
