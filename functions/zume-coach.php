<?php

/**
 * Zume Coach Class
 *
 * @class Zume_Coach
 * @version 0.1
 * @since 0.1
 * @package Zume
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

class Zume_Coach {

    /**
     * Zume_Coach The single instance of Zume_Coach.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Coach Instance
     *
     * Ensures only one instance of Zume_Coach is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Coach instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    /**
     * Constructor function.
     * @access  public
     * @since   0.1
     */
    public function __construct() {
        add_action( 'user_register', [ &$this, 'add_meta_data' ] );

    } // End __construct()

    public function add_meta_data( $user_id ) {
        add_user_meta( $user_id, 'zume_coach', '', true );
        add_user_meta( $user_id, 'zume_phone', '', true );
        zume_log_last_active( $user_id );
    }

    public static function zume_get_coaches() {
        global $wpdb;
        $results = $wpdb->get_results( "SELECT user_id FROM $wpdb->usermeta WHERE ( meta_value LIKE '%coach%' OR meta_value LIKE '%administrator%' ) AND meta_key = 'wp_capabilities'", ARRAY_A );
        return $results;
    }

    public static function zume_get_unassigned_users() {
        global $wpdb;
        $results = $wpdb->get_results("SELECT `user_id` FROM $wpdb->usermeta WHERE meta_key = 'zume_coach' AND meta_value = '' AND user_id NOT IN (
                                                SELECT user_id FROM $wpdb->usermeta WHERE ( meta_value LIKE '%coach%' OR meta_value LIKE '%administrator%') AND meta_key = 'wp_capabilities'
                                              )", ARRAY_A);
        return $results;
    }

    public static function zume_get_coach_assignees( $user_id ) {
        global $wpdb;
        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT user_id
                    FROM $wpdb->usermeta 
                    WHERE meta_key = 'zume_coach' 
                      AND meta_value = %s",
            $user_id
        ), ARRAY_A );
        return $results;
    }

    public static function assign( $args ) {
        // coach and user
        $defaults = array(
            'coach_id' => false,
            'user_id' => false,
        );
        $args = wp_parse_args( $args, $defaults );

        update_user_meta( $args['user_id'], 'zume_coach', $args['coach_id'] );

    }

    public static function count_zume_groups_by_user( $user_id ) {
        global $wpdb;
        $results = $wpdb->get_var( $wpdb->prepare(
            "SELECT count(umeta_id) 
                    FROM $wpdb->usermeta 
                    WHERE meta_key LIKE %s 
                      AND user_id = %s",
            $wpdb->esc_like( 'zume_group' ) . '%',
            $user_id
        ) );
        return $results;
    }

}
Zume_Coach::instance();
