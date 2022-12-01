<?php

// @todo remove or expand

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

class Zume_V4_Users {
    public static function zume_network_sites() {
        $zume_user_sites = get_blogs_of_user( get_current_user_id() );

        unset( $zume_user_sites[1] );
        unset( $zume_user_sites[14] );

        if ( count( $zume_user_sites ) >= 1 ) {
            return $zume_user_sites;
        }
        return false;
    }

}
