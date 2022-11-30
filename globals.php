<?php

add_filter( 'login_redirect', function( $url, $query, $user ) {
    return zume_dashboard_url();
}, 10, 3 );

function zume_mirror_url(){
    return 'https://storage.googleapis.com/zume-file-mirror/';
}

function zume_alt_video( $current_language = null ) {
    $alt_video = false;

    if ( ! $current_language ) {
        $current_language = zume_current_language();
    }

    if ( ! $alt_video ) {
        $alt_video = ( 'id' === $current_language ); // @todo expand this if more than indonesian is a problem
    }

    return $alt_video;
}

function zume_v4_ready_language() {
    $ready = array();

//    $ready['id'] = false;

    $current = zume_current_language();

    return $ready[$current] ?? true;
}

if ( ! function_exists( 'dt_recursive_sanitize_array' ) ) {
    function dt_recursive_sanitize_array( array $array ) : array {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = dt_recursive_sanitize_array( $value );
            }
            else {
                $value = sanitize_text_field( wp_unslash( $value ) );
            }
        }
        return $array;
    }
}
