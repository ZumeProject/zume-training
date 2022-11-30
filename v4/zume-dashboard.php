<?php
// @todo remove

/**
 * Zume_Dashboard
 *
 * @class Zume_Dashboard
 * @version 0.1
 * @since 0.1
 * @package Disciple_Tools
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
        $group_values = self::verify_group_array_filter( array(), true );

        if ( ! empty( $args['address'] ) ) {
            // Geo lookup address
            $mapbox = DT_Mapbox_API::lookup( $args['address'] ); // get google api info
            if ( isset( $mapbox['features'] ) ) {
                $args['lng'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'longitude', true );
                $args['lat'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'latitude', true );
                $args['address'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'place_name', true );
//                $args['raw_location'] = $mapbox;
            }
        }

        $results = DT_Ipstack_API::geocode_ip_address( $args['ip_address'] );
        if ( isset( $results['id'] ) ) {
            $args['ip_lng'] = $results['longitude'];
            $args['ip_lat'] = $results['latitude'];
//            $args['ip_raw_location'] = $results;
        }
        if ( ! ( isset( $results['success'] ) && $results['success'] === false ) ) {
            $geocoder = new Location_Grid_Geocoder();
            $args['ip_location_grid_meta'] = Location_Grid_Meta::convert_ip_result_to_location_grid_meta( $results );
        }

        if ( isset( $args['type'] ) ) {
            unset( $args['type'] );
        }

        $new_group = wp_parse_args( $args, $group_values );

        if ( __( 'No Name', 'zume' ) == $new_group['group_name'] ) {
            return false;
        }

        $result = add_user_meta( get_current_user_id(), $new_group['key'], $new_group, true );

        do_action( 'zume_create_group', get_current_user_id(), $new_group['key'], $new_group );

        return $result;

    }


    /**
     * Creates and verifies default values for the groups array.
     * This is the master location for defining the zume_groups array.
     *
     * If called empty, it will return an empty group array with default values. ex group_array_filter()
     * If passed a group array, it will verify that all required keys are present, add any missing, and return
     * group array. ex.group_array_filter( $group_meta )
     *
     * @param $group_meta
     * @return array
     */
    public static function verify_group_array_filter( $group_meta, $new = false ) {
        if ( is_serialized( $group_meta ) ) {
            $group_meta = maybe_unserialize( $group_meta );
        }

        $active_keys = array(
            'owner'               => get_current_user_id(),
            'group_name'          => __( 'No Name', 'zume' ),
            'key'                 => self::get_unique_group_key(),
            'public_key'          => self::get_unique_public_key(),
            'members'             => 1,
            'meeting_time'        => '',
            'address'             => '',
            'lng'                 => '',
            'lat'                 => '',
            'ip_address'          => '',
            'ip_lng'              => '',
            'ip_lat'              => '',
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
            'last_modified_date'  => time(),
            'closed'              => false,
            'coleaders'           => array(),
            'coleaders_accepted'  => array(),
            'coleaders_declined'  => array(),
            'three_month_plans'   => array(),
            'foreign_key'         => hash( 'sha256', time() . rand( 0, 100000 ) ),
            'ip_location_grid_meta'  => array(
                'lng' => '',
                'lat' => '',
                'level' => '',
                'label' => '',
                'grid_id' => ''
            ),
            'location_grid_meta'  => array(
                'lng' => '',
                'lat' => '',
                'level' => '',
                'label' => '',
                'grid_id' => ''
            )
        );

        $deprecated_keys = array(
            'raw_location',
            'ip_raw_location'
        );

        if ( ! is_array( $group_meta ) ) {
            $group_meta = array();
        }

        $trigger_update = false;

        // Active keys
        foreach ( $active_keys as $k => $v ) {
            if ( !isset( $group_meta[ $k ] ) ) {
                $group_meta[$k] = $v;
                $trigger_update = true;
            }
        }

        // Deprecated keys
        foreach ( $deprecated_keys as $deprecated_key ) {
            if ( isset( $group_meta[ $deprecated_key ] ) ) {
                unset( $group_meta[$deprecated_key] );
                $trigger_update = true;
            }
        }

        // Members can be always more, never less than participants
        if ( isset( $group_meta['coleaders_accepted'] ) ) {
            if ( count( $group_meta['coleaders_accepted'] ) + 1 > $group_meta['members'] ) {
                $group_meta['members'] = count( $group_meta['coleaders_accepted'] ) + 1;
                $trigger_update = true;
            }
        }

        if ( $new ) {
            $trigger_update = false;
        }

        if ( $trigger_update ) {
            if ( ! ( __( 'No Name', 'zume' ) == $group_meta['group_name'] ) ) {
                update_user_meta( $group_meta['owner'], $group_meta['key'], $group_meta );
            }
        }

        return $group_meta;
    }

    public static function get_unique_group_key() {
        global $wpdb;
        $duplicate_check = 1;
        while ( $duplicate_check != 0 ) {
            $group_key = uniqid( 'zume_group_' );
            $duplicate_check = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $wpdb->usermeta WHERE meta_key = %s", $group_key ) );
        }
        return $group_key;
    }

    public static function get_unique_public_key() {
        global $wpdb;
        $duplicate_check = 1;
        while ( $duplicate_check != 0 ) {
            $key = hash( 'sha256', rand( 0, 100000 ) . uniqid( 'zume_' ) . time() . rand( 0, 100000 ) );
            $key = str_replace( '0', '', $key );
            $key = str_replace( 'O', '', $key );
            $key = str_replace( 'o', '', $key );
            $key = strtoupper( substr( $key, 0, 5 ) );
            $duplicate_check = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $wpdb->usermeta WHERE meta_key LIKE %s AND meta_value LIKE %s", $wpdb->esc_like( 'zume_group' ) . '%', '%public_key";s:5:"' . $wpdb->esc_like( $key ) . '%' ) );
        }
        return $key;
    }

    /**
     * Edit Group
     *
     * @param $args
     * @return bool|WP_Error
     */
    public static function edit_group( $args ) {
        // Check if this user can edit this group
        $current_user_id = get_current_user_id();
        $group_meta = get_user_meta( $current_user_id, $args['key'], true );
        $group_meta = self::verify_group_array_filter( $group_meta );

        if ( empty( $group_meta ) ) {
            return new WP_Error( 'no_group_match', 'Hey, you cheating? No, group with id found for you.' );
        }

        if ( empty( $args['validate_address'] ) ) {
            $args['address'] = '';
        }
        if ( isset( $args['address'] ) && ! ( $args['address'] == $group_meta['address'] ) && ! empty( $args['address'] ) ) {
            // Geo lookup address
            $mapbox = DT_Mapbox_API::lookup( $args['address'] ); // get google api info
            if ( isset( $mapbox['features'] ) ) {
                $group_meta['lng'] = '';
                $group_meta['lat'] = '';
                $group_meta['address'] = '';
                $group_meta['raw_location'] = '';

                $args['lng'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'longitude', true );
                $args['lat'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'latitude', true );
                $args['address'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'place_name', true );
//                $args['raw_location'] = $mapbox;

                $args['location_grid_meta'] = [
                    'lng' => DT_Mapbox_API::parse_raw_result( $mapbox, 'longitude', true ),
                    'lat' => DT_Mapbox_API::parse_raw_result( $mapbox, 'latitude', true ),
                    'level' => DT_Mapbox_API::parse_raw_result( $mapbox, 'place_type', true ),
                    'label' => DT_Mapbox_API::parse_raw_result( $mapbox, 'place_name', true ),
                    'source' => 'user',
                    'grid_id' => '',
                ];

            }
        }

        $args['ip_address'] = $args['ip_address'] ?? DT_Ipstack_API::get_real_ip_address();
        if ( isset( $args['ip_address'] ) && ! empty( $args['ip_address'] ) ) {
            $results = DT_Ipstack_API::geocode_ip_address( $args['ip_address'] );
            if ( isset( $results['ip'] ) ) {
                $args['ip_lng'] = $results['longitude'];
                $args['ip_lat'] = $results['latitude'];
//                $args['ip_raw_location'] = $results;
            }
            if ( ! ( isset( $results['success'] ) && $results['success'] === false ) ) {
                $geocoder = new Location_Grid_Geocoder();
                $args['ip_location_grid_meta'] = Location_Grid_Meta::convert_ip_result_to_location_grid_meta( $results );
            }
        }

        // Add coleaders
        $args['coleaders'] = ( ! empty( $args['coleaders'] ) ) ? array_filter( $args['coleaders'] ) : array(); // confirm or establish array variable.
        $args['coleaders_accepted'] = ( ! empty( $args['coleaders_accepted'] ) ) ? array_filter( $args['coleaders_accepted'] ) : array();
        $args['coleaders_declined'] = ( ! empty( $args['coleaders_declined'] ) ) ? array_filter( $args['coleaders_declined'] ) : array();
        if ( isset( $args['new_coleader'] ) && ! empty( $args['new_coleader'] && is_array( $args['new_coleader'] ) ) ) { // test if new coleader added
            foreach ( $args['new_coleader'] as $coleader ) { // loop potential additions

                $coleader = trim( strtolower( $coleader ) );
                // check if empty
                if ( empty( $coleader ) || ! is_email( $coleader ) ) {
                    continue;
                }

                // duplicate check
                if ( ! empty( $args['coleaders'] ) ) { // if coleaders exist
                    foreach ( $args['coleaders'] as $previous_coleader ) {
                        if ( $previous_coleader == $coleader ) {
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
        if ( isset( $args['type'] ) ) { // keeps from storing the form parse info
            unset( $args['type'] );
        }
        $args['last_modified_date'] = current_time( 'mysql' );
        $args = wp_parse_args( $args, $group_meta );

        update_user_meta( $current_user_id, $args['key'], $args );

        do_action( 'zume_edit_group', $current_user_id, $args['key'], $args );

        return true;
    }

    public static function update_ip_address( $group_key ) {
        $status = false;
        $group_meta = self::get_group_by_key( $group_key );
        if ( ! $group_meta ) {
            return false;
        }
        $group_meta['ip_address'] = DT_Ipstack_API::get_real_ip_address();
        $results = DT_Ipstack_API::geocode_ip_address( $group_meta['ip_address'] );
        if ( isset( $results['ip'] ) ) {
            $group_meta['ip_lng'] = $results['longitude'];
            $group_meta['ip_lat'] = $results['latitude'];
            $group_meta['ip_raw_location'] = $results;
            $status = update_user_meta( $group_meta['owner'], $group_meta['key'], $group_meta );
        }
        if ( $status ) {
            return true;
        } else {
            return false;
        }
    }

    public static function delete_group( $group_key ) {
        $user_id = get_current_user_id();
        delete_user_meta( $user_id, $group_key );
        do_action( 'zume_delete_group', $user_id, $group_key );
    }

    public static function closed_group( $group_key ) {
        $user_id = get_current_user_id();
        $user_meta = get_user_meta( $user_id, $group_key, true );
        if ( empty( $user_meta ) ) {
            return new WP_Error( 'no_group_match', 'Hey, you cheating? No, group with id found for you.' );
        }
        $user_meta['closed'] = true;
        update_user_meta( $user_id, $group_key, $user_meta );

        do_action( 'zume_close_group', $user_id, $group_key );
    }

    public static function activate_group( $group_id ) {
        $group_meta = get_user_meta( get_current_user_id(), $group_id, true );
        $group_meta = self::verify_group_array_filter( $group_meta );

        $group_meta['closed'] = false;

        update_user_meta( get_current_user_id(), $group_id, $group_meta );

        do_action( 'zume_activate_group', get_current_user_id(), $group_id );
    }

    public static function get_highest_session( $user_id ) {
        $highest_session = 0;
        $zume_user_meta = zume_get_user_meta( $user_id );
        foreach ( $zume_user_meta as $key => $v ) {
            $key_beginning = substr( $key, 0, 10 );
            if ( 'zume_group' == $key_beginning ) { // check if zume_group
                $value = maybe_unserialize( $v );
                $next_session = self::get_next_session( $value );
                if ( $highest_session < $next_session ) {
                    $highest_session = $next_session;
                }
            }
        }
        $zume_colead_groups = self::get_colead_groups();
        foreach ( $zume_colead_groups as $key => $v ) {
            $key_beginning = substr( $key, 0, 10 );
            if ( 'zume_group' == $key_beginning ) { // check if zume_group
                $value = maybe_unserialize( $v );
                $next_session = self::get_next_session( $value );
                if ( $highest_session < $next_session ) {
                    $highest_session = $next_session;
                }
            }
        }
        return $highest_session;
    }

    /**
     * @version 3
     * @param $group_meta
     * @return int
     */
    public static function get_next_session( $group_meta ) {

        if ( $group_meta['session_1'] == false ) {
            return 1;
        }
        if ( $group_meta['session_2'] == false ) {
            return 2;
        }
        if ( $group_meta['session_3'] == false ) {
            return 3;
        }
        if ( $group_meta['session_4'] == false ) {
            return 4;
        }
        if ( $group_meta['session_5'] == false ) {
            return 5;
        }
        if ( $group_meta['session_6'] == false ) {
            return 6;
        }
        if ( $group_meta['session_7'] == false ) {
            return 7;
        }
        if ( $group_meta['session_8'] == false ) {
            return 8;
        }
        if ( $group_meta['session_9'] == false ) {
            return 9;
        }
        if ( $group_meta['session_10'] == false ) {
            return 10;
        }
        if ( $group_meta['session_10'] == true ) {
            return 11;
        }
        return 0;

    }

    public static function update_session_complete( $group_key, $session_id, $user_id = '' ) {
        if ( empty( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        $group_meta = get_user_meta( $user_id, $group_key, true );
        if ( empty( $group_meta ) ) {
            return false;
        }

        // update current session complete
        $session_key = 'session_' . $session_id;
        $group_meta[ $session_key ] = true;
        $session_date_key = $session_key . '_complete';
        if ( '' == $group_meta[ $session_date_key ] ) {
            $group_meta[ $session_date_key ] = current_time( 'mysql' );
        }

        // update next session
        $next_session = self::get_next_session( $group_meta );
        $group_meta['next_session'] = $next_session;

        update_user_meta( $user_id, $group_key, $group_meta );

        return true;

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
                echo 32;
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

    public static function get_coleader_input( $email_address, $li_id, $group_key ) {
        // check if email is a user
        $user = get_user_by( 'email', $email_address );

        $has_coleader_accepted = self::has_coleader_accepted( $email_address, $group_key );

        if ( $user ) {
        // if email is a user
            ?>
            <li class="coleader" id="<?php echo esc_attr( $li_id ) ?>"><?php echo esc_attr( $email_address ) ?>
                <?php if ( $has_coleader_accepted ) : ?>
                 ( <?php echo get_avatar( $email_address, 15 ) ?>  <?php echo esc_attr( $user->display_name ) ?> )
                <?php endif; ?>
                <input type="hidden" name="coleaders[]" value="<?php echo esc_attr( $email_address ) ?>" />
            </li>
            <?php

        } else {
        // if email is not a user
            ?>
            <li class="coleader" id="<?php echo esc_attr( $li_id ) ?>">
                <?php echo esc_attr( $email_address ) ?><input type="hidden" name="coleaders[]" value="<?php echo esc_attr( $email_address ) ?>" />
                </li>
            <?php
        }
    }

    public static function has_coleader_accepted( $email_address, $group_key ) {
        $group_meta = get_user_meta( get_current_user_id(), $group_key, true );
        $group_meta = self::verify_group_array_filter( $group_meta );

        return in_array( $email_address, $group_meta['coleaders_accepted'] );
    }

    public static function delete_coleader( $email, $group_id, $user_id = null ) {

        if ( is_null( $user_id ) ) {
            $user_id = get_current_user_id();
        }

        $group = get_user_meta( $user_id, $group_id, true );
        $group = self::verify_group_array_filter( $group );
        $group_prev = $group;

        if ( empty( $group ) ) {
            return array( 'status' => 'Permission failure' );
        }

        if ( empty( $email ) ) {
            return array( 'status' => 'Email failure' );
        }

        if ( empty( $group['coleaders'] ) ) {
            return array( 'status' => 'Coleader not present' );
        }

        foreach ( $group['coleaders'] as $key => $coleader ) {
            if ( $email == $coleader) {
                unset( $group['coleaders'][$key] );
                unset( $group['coleaders_accepted'][$key] );
                unset( $group['coleaders_declined'][$key] );
                update_user_meta( $user_id, $group_id, $group, $group_prev );
                return array( 'status' => 'OK' );
            }
        }
        return array( 'status' => 'Coleader not found' );
    }

    /**
     * Gets the displayable list of Colead Groups
     * These groups have the user email added to their record
     * These groups have user email listed as accepted for coleadership
     *
     * @return array
     */
    public static function get_colead_groups( $status = 'accepted', $user = null ) {
        global $wpdb;
        $prepared = array();
        if ( is_null( $user ) ) {
            $user = get_user_by( 'id', get_current_user_id() );
        }
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT *
                        FROM `$wpdb->usermeta`
                        WHERE meta_key LIKE %s
                          AND meta_value LIKE %s",
            $wpdb->esc_like( 'zume_group_' ).'%',
            '%'. $wpdb->esc_like( $user->user_email ). '%'
        ), ARRAY_A );
        if ( empty( $results ) ) {
            return $prepared;
        }

        switch ( $status ) {
            case 'accepted':
                foreach ( $results as $v ){
                    $zume_key = $v['meta_key'];
                    $zume_value = maybe_unserialize( $v['meta_value'] );
                    $zume_value = self::verify_group_array_filter( $zume_value );

                    if ( in_array( $user->user_email, $zume_value['coleaders'] ) && // is added as coleader
                        in_array( $user->user_email, $zume_value['coleaders_accepted'] ) && // is accepted
                        ! in_array( $user->user_email, $zume_value['coleaders_declined'] ) ) // not declined
                    {
                        $zume_value['no_edit'] = true; // tags record as no owned
                        $prepared[$zume_key] = $zume_value;
                    }
                }

                return $prepared;
                break;

            case 'waiting_acceptance':
                foreach ( $results as $v ){
                    $zume_key = $v['meta_key'];
                    $zume_value = maybe_unserialize( $v['meta_value'] );
                    $zume_value = self::verify_group_array_filter( $zume_value );

                    // if not a currently listed coleader or is in the declined list
                    if ( in_array( $user->user_email, $zume_value['coleaders'] ) && // is added as coleader
                        ! in_array( $user->user_email, $zume_value['coleaders_declined'] ) && // not declined
                        ! in_array( $user->user_email, $zume_value['coleaders_accepted'] ) )  // not accepted
                    {
                        $zume_value['no_edit'] = true; // tags record as no owned
                        $prepared[$zume_key] = $zume_value;
                    }
                }

                return $prepared;
                break;

            case 'declined':
                foreach ( $results as $v ){
                    $zume_key = $v['meta_key'];
                    $zume_value = maybe_unserialize( $v['meta_value'] );
                    $zume_value = self::verify_group_array_filter( $zume_value );

                    if ( in_array( $user->user_email, $zume_value['coleaders_declined'] ) ) // is declined
                    {
                        $zume_value['no_edit'] = true; // tags record as no owned
                        $prepared[$zume_key] = $zume_value;
                    }
                }
                break;
            default:
                return array();
                break;
        }
    }

    public static function coleader_invitation_response( $response ) {
        global $wpdb;
        $user = get_user_by( 'id', get_current_user_id() );

        if ( isset( $response['accept'] ) ) {
            $decision = 'accepted';
            $group_key = $response['accept'];

        } elseif ( isset( $response['decline'] ) ) {
            $decision = 'declined';
            $group_key = $response['decline'];
        } else {
            return;
        }

        // query
        $results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->usermeta WHERE meta_key = %s", $group_key ), ARRAY_A );
        if ( empty( $results ) ) {
            return;
        }
        // process request
        foreach ( $results as $result ) {
            $group_meta = self::verify_group_array_filter( $result['meta_value'] );
            $group_user_id = $result['user_id'];

            // qualify that current user has invitation from this group
            if ( in_array( $user->user_email, $group_meta['coleaders'] ) && // is added as coleader
                ! in_array( $user->user_email, $group_meta['coleaders_declined'] ) ) // not declined
            {
                if ( ! in_array( $user->user_email, $group_meta['coleaders_'.$decision] ) ) { // test for potential duplicate
                    array_push( $group_meta['coleaders_'.$decision], $user->user_email );
                    update_user_meta( $group_user_id, $group_key, $group_meta );
                }
            }
        }

        do_action( 'zume_coleader_invitation_response', $user->ID, $group_key, $decision );
    }

    /**
     * Gets the group array by the group key
     *
     * @param $group_key
     * @return array|bool
     */
    public static function get_group_by_key( $group_key ) {
        global $wpdb;
        $result = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = %s", $group_key ) );
        if ( empty( $result ) ) {
            return false;
        }

        $group_meta = self::verify_group_array_filter( $result );
        return $group_meta;
    }

    /**
     * Gets user owned groups
     *
     * @return array|bool
     */
    public static function get_current_user_groups( $user_id = null ) {
        if ( is_null( $user_id ) ){
            $user_id = get_current_user_id();
        }
        $zume_user_meta = zume_get_user_meta( $user_id );
        $groups = array();
        foreach ( $zume_user_meta as $zume_key => $v ) {
            $zume_key_beginning = substr( $zume_key, 0, 10 );
            if ( 'zume_group' == $zume_key_beginning ) {
                $zume_value = self::verify_group_array_filter( $v );
                $groups[$zume_key] = $zume_value;
            }
        }

        if ( ! empty( $groups ) ) {
            return $groups;
        } else {
            return false;
        }
    }

    /**
     * Returns true of false if user owns groups
     * This does not test if they are a coleader or named participant.
     *
     * @return bool  True if user owns groups, False if use does not own groups.
     */
    public static function current_user_has_groups() : bool  {
        $zume_user_meta = zume_get_user_meta( get_current_user_id() );
        foreach ( $zume_user_meta as $zume_key => $v ) {
            $zume_key_beginning = substr( $zume_key, 0, 10 );
            if ( 'zume_group' == $zume_key_beginning ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verify public key for group
     *
     * @param $public_key
     * @return bool|mixed returns false if false, returns group key if success.
     */
    public static function verify_public_key_for_group( $public_key ) {
        global $wpdb;

        $public_key = self::filter_public_key( $public_key );

        $results = $wpdb->get_var( $wpdb->prepare( "
                  SELECT meta_value
                  FROM $wpdb->usermeta
                  WHERE meta_key LIKE %s
                    AND meta_value LIKE %s LIMIT 1",
            $wpdb->esc_like( 'zume_group' ). '%',
            '%'.$wpdb->esc_like( $public_key ).'%'
        ) );

        if ( empty( $results ) ) {
            return false;
        }

        $group_meta = self::verify_group_array_filter( $results );

        $group_meta['public_key'] = strtoupper( $group_meta['public_key'] );
        $public_key = strtoupper( $public_key );
        if ( $public_key == $group_meta['public_key'] ) {
            return $group_meta['key'];
        }

        return false;
    }

    public static function filter_public_key( $public_key ) {
        $fail = '00000'; // returns a false key

        // must not be empty
        if ( empty( $public_key ) ) {
            return $fail;
        }

        // must be alphanumberic
        if ( ! ctype_alnum( $public_key ) ) {
            return $fail;
        }

        // must have 5 digits
        if ( ! strlen( $public_key ) === 5 ) {
            return $fail;
        }

        $public_key = sanitize_key( $public_key );

        return $public_key;
    }

    /**
     * @param $group_key
     * @return string|WP_Error
     */
    public static function change_group_public_key( $group_key ) {
        // check if owner of group
        $group_meta = get_user_meta( get_current_user_id(), $group_key, true );
        if ( ! $group_meta ) {
            return new WP_Error( 'authorization_failure', 'Not authorized to make this change.' );
        }
        $group_meta = self::verify_group_array_filter( $group_meta );

        // get new key
        $new_key = self::get_unique_public_key();

        // save to group
        $group_meta['public_key'] = $new_key;

        $result = update_user_meta( get_current_user_id(), $group_key, $group_meta );

        if ( ! $result ) {
            return new WP_Error( 'update_failure', 'Failed to update record.' );
        } else {
            return $new_key;
        }
    }

    public static function get_all_groups( int $user_id = null ) : array {
        $groups = array();
        if ( empty( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        $owned_groups = self::get_current_user_groups( $user_id );
        $colead_groups = self::get_colead_groups( $user_id );

        if ( ! empty( $owned_groups ) ) {
            foreach ( $owned_groups as $g ) {
                $groups[] = $g;
            }
        }
        if ( ! empty( $colead_groups ) ) {
            foreach ( $colead_groups as $g ) {
                $groups[] = $g;
            }
        }

        return $groups;
    }

}
