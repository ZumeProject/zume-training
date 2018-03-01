<?php

/**
 * Zume_Dashboard
 *
 * @class Zume_Dashboard
 * @version 0.1
 * @since 0.1
 * @package Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

class Zume_Dashboard {

    /**
     * Zume_Dashboard The single instance of Zume_Dashboard.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Dashboard Instance
     *
     * Ensures only one instance of Zume_Dashboard is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Dashboard instance
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
    public function __construct() { } // End __construct()

    public static function create_group( $args ) {

        // Validate post data
        $defaults = array(
            'group_name' => false,
            'members' => false,
            'meeting_time' => '',
            'address' => false,
            'ip_address' => Zume_Google_Geolocation::get_real_ip_address(),
            'lng'   => '',
            'lat'   => '',
        );
        $args = wp_parse_args( $args, $defaults );

        if ( ! $args['group_name'] ) {
            return new WP_Error( 'missing_info', 'You are missing the group name' );
        }
        if ( ! $args['members'] ) {
            return new WP_Error( 'missing_info', 'You are missing number of group members' );
        }
        if ( $args['address'] ) {
            zume_write_log( 'begin locations' );
            // Geo lookup address
            $google_result = Zume_Google_Geolocation::query_google_api( $args['address'], $type = 'core' ); // get google api info
            if ( ! $google_result ) {
                $results = Zume_Google_Geolocation::geocode_ip_address( $args['ip_address'] );// TODO: Need to still wire up the api to get ip address location
                $args['lng'] = $results['lng'];
                $args['lat'] = $results['lat'];
            } else {
                $args['lng'] = $google_result['lng'];
                $args['lat'] = $google_result['lat'];
                $args['address'] = $google_result['formatted_address'];
            }
        }


        // Prepare record array
        $current_user_id = get_current_user_id();
        $group_key = uniqid( 'zume_group_' );
        $group_values = [
            'owner'               => $current_user_id,
            'group_name'          => $args['group_name'],
            'members'             => $args['members'],
            'meeting_time'        => $args['meeting_time'],
            'address'             => $args['address'],
            'ip_address'          => $args['ip_address'],
            'lng'                 => $args['lng'],
            'lat'                 => $args['lat'],
            'created_date'        => current_time( 'mysql' ),
            'next_session'        => '1',
            'session_1'           => false,
            'session_1_complete'  => '',
            'session_2'           => false,
            'session_2_complete'  => '',
            'session_3'           => false,
            'session_3_complete'  => '',
            'session_4'           => false,
            'session_4_complete'  => '',
            'session_5'           => false,
            'session_5_complete'  => '',
            'session_6'           => false,
            'session_6_complete'  => '',
            'session_7'           => false,
            'session_7_complete'  => '',
            'session_8'           => false,
            'session_8_complete'  => '',
            'session_9'           => false,
            'session_9_complete'  => '',
            'session_10'          => false,
            'session_10_complete' => '',
            'last_modified_date'  => current_time( 'mysql' ),
            'closed'              => false,
        ];

        add_user_meta( $current_user_id, $group_key, $group_values, true );

        return true;

    }

    public static function edit_group( $args ) {
        // Check if this user can edit this group
        $current_user_id = get_current_user_id();
        $user_meta = get_user_meta( $current_user_id, $args['key'], true );
        if ( empty( $user_meta ) ) {
            return new WP_Error( 'no_group_match', 'Hey, you cheating? No, group with id found for you.' );
        }

        if ( isset( $args['validate_address'] ) && empty( $args['validate_address'] ) ) {
            $args['address'] = '';
        }

        if ( isset( $args['address'] ) && ! $args['address'] == $user_meta['address'] && ! empty( $args['address'] ) ) {
            // Geo lookup address
            $google_result = Zume_Google_Geolocation::query_google_api( $args['address'], $type = 'core' ); // get google api info
            if ( ! $google_result ) {
                $results = Zume_Google_Geolocation::geocode_ip_address( $args['ip_address'] );
                $lng = $results['lng'];
                $lat = $results['lat'];
                $formatted_address = $args['address'];
            } else {
                $lng = $google_result['lng'];
                $lat = $google_result['lat'];
                $formatted_address = $google_result['formatted_address'];
            }

            // add new geo data as new variable info to the $args
            $args['lng'] = $lng;
            $args['lat'] = $lat;
            $args['address'] = $formatted_address;
        }

        // Add coleaders
        $args['coleaders'] = ( isset( $args['coleaders'] ) && is_array( $args['coleaders'] ) && ! empty( $args['coleaders'] ) ) ? array_filter( $args['coleaders'] ) : [];
        if ( isset( $args['new_coleader'] ) && ! empty( $args['new_coleader'] && is_array( $args['new_coleader'] ) ) ) { // test if new coleader added
            foreach( $args['new_coleader'] as $coleader ) { // loop potential additions

                // check if empty
                if ( empty( $coleader ) ) {
                    continue;
                }

                // duplicate check
                if ( ! empty( $args['coleaders'] ) ) { // if coleaders exist
                    foreach( $args['coleaders'] as $previous_coleader ) {
                        if( $previous_coleader == $coleader ) {
                            continue 2;
                        }
                    }
                }

                // insert new values
                array_push( $args['coleaders'], $coleader );
            }
            unset( $args['new_coleader'] );
        }

        // Combine array with new data
        unset( $args['type'] ); // keeps from storing the form parse info
        $args['last_modified_date'] = current_time( 'mysql' );
        $args = wp_parse_args( $args, $user_meta );

        update_user_meta( $current_user_id, $args['key'], $args );
        return true;
    }

    public static function delete_group( $group_key ) {
        $user_id = get_current_user_id();
        delete_user_meta( $user_id, $group_key );
    }

    public static function closed_group( $group_key ) {
        $user_id = get_current_user_id();
        $user_meta = get_user_meta( $user_id, $group_key, true );
        if ( empty( $user_meta ) ) {
            return new WP_Error( 'no_group_match', 'Hey, you cheating? No, group with id found for you.' );
        }
        $user_meta['closed'] = true;
        update_user_meta( $user_id, $group_key, $user_meta );
    }

    public static function activate_group( $user_id, $group_id ) {
        $group_meta = get_user_meta( $user_id, $group_id, true );
        $group_previous = $group_meta;
        $group_meta['closed'] = false;
        update_user_meta( $user_id, $group_id, $group_meta, $group_previous );
    }

    public static function get_highest_session( $user_id ) {
        $highest_session = 0;
        $zume_user_meta = zume_get_user_meta( $user_id );
        foreach ( $zume_user_meta as $key => $v ) {
            $key_beginning = substr( $key, 0, 10 );
            if ( 'zume_group' == $key_beginning ) { // check if zume_group
                $value = maybe_unserialize( $v );
                $next_session = Zume_Course::get_next_session( $value );
                if ( $highest_session < $next_session ) {
                    $highest_session = $next_session;
                }
            }
        }
        return $highest_session;
    }

    public static function get_available_videos_count( $next_session ) {
        switch ( $next_session ) {
            case '1':
                echo 2;
                break;
            case '2':
                echo 7;
                break;
            case '3':
                echo 10;
                break;
            case '4':
                echo 13;
                break;
            case '5':
                echo 18;
                break;
            case '6':
                echo 20;
                break;
            case '7':
                echo 23;
                break;
            case '8':
                echo 24;
                break;
            case '9':
                echo 25;
                break;
            case '10':
                echo 29;
                break;
            case '11':
                echo 31;
                break;
            default:
                echo 2;
                break;

        }
    }

    public static function get_available_tools_count( $next_session ) {
        switch ( $next_session ) {
            case '1':
                echo 0;
                break;
            case '2':
                echo 3;
                break;
            case '3':
                echo 5;
                break;
            case '4':
                echo 6;
                break;
            case '5':
                echo 8;
                break;
            case '6':
                echo 9;
                break;
            case '7':
                echo 10;
                break;
            case '8':
                echo 10;
                break;
            case '9':
                echo 10;
                break;
            case '10':
                echo 10;
                break;
            case '11':
                echo 12;
                break;
            default:
                echo 0;
                break;

        }
    }

    public static function get_encouragement() {
        // check for and get user message level
        $targeted_message = 0;

        // build messages
        $message = [
            'new' => [
                'type' => 'new',
                'name' => 'new_registration',
                'title' => __( 'Welcome!', 'zume'),
                'message' => __( 'Praise God for your interest in sharpening your disciple-making!', 'zume' )
            ],
        ];

        // new, no group
        if( 0 == $targeted_message ) {
            return $message['new'];
        }

        // @todo targeted messages

        // group, no sessions
        // group, no address (encourage to participate in global plan)
        // group, < 3 members
        // group, first session complete
        // >1 group
        // group, next session 2
        // group, next session 3
        // group, next session 4
        // group, next session 5
        // group, next session 6
        // group, next session 7
        // group, next session 8
        // group, next session 9
        // group, next session 10
        // group, complete

    }

    public static function get_coleader_input( $email_address ) {
        // check if email is a user
        $user = get_user_by( 'email', $email_address );

        if ( $user ) {
        // if email is a user
            ?>
            <li><?php echo esc_attr( $email_address ) ?><input type="hidden" name="coleaders[]" value="<?php echo esc_attr( $email_address ) ?>" /> ( <?php echo get_avatar( $email_address, 15 ) ?>  <?php esc_attr_e( $user->display_name ) ?> )</li>
            <?php

        } else {
        // if email is not a user
            ?>
            <li><?php echo esc_attr( $email_address ) ?><input type="hidden" name="coleaders[]" value="<?php echo esc_attr( $email_address ) ?>" /> ( <a href="mailto:<?php echo esc_attr( $email_address ) ?>"><?php esc_attr_e( 'Invite to Zúme') ?></a> )</li>
            <?php
        }
    }

}
