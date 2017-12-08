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
		    'group_members' => false,
		    'group_meeting_time' => '',
		    'group_address' => false,
		    'ip_address' => zume_get_real_ip_address(),
	    );
	    $args = wp_parse_args( $args, $defaults );
	    zume_write_log($args);

	    if( ! $args['group_name'] ) {
	    	return new WP_Error('missing_info', 'You are missing the group name' );
	    }
	    if( ! $args['group_members'] ) {
		    return new WP_Error('missing_info', 'You are missing number of group members' );
	    }
	    if( ! $args['group_address'] ) {
		    return new WP_Error('missing_info', 'You are missing the group address' );
	    }

	    // Geo lookup address
	    $google_result = Zume_Google_Geolocation::query_google_api( $args['group_address'], $type = 'core' ); // get google api info
	    if ($google_result == 'ZERO_RESULTS') {
		    $results = Zume_Google_Geolocation::geocode_ip_address( $args['ip_address'] );// TODO: Need to still wire up the api to get ip address location
		    $lng = $results['lng'];
		    $lat = $results['lat'];
		    $formatted_address = $args['group_address'];
	    } else {
		    $lng = $google_result['lng'];
		    $lat = $google_result['lat'];
		    $formatted_address = $google_result['formatted_address'];
	    }

	    // Prepare record array
	    $current_user_id = get_current_user_id();
	    $group_key = uniqid ('zume_group_');
	    $group_values = [
		    'owner' => $current_user_id,
		    'name' => $args['group_name'],
		    'members' => $args['group_members'],
		    'meeting_time' => $args['group_meeting_time'],
		    'address' => $formatted_address,
		    'last_modified_date' => current_time( 'mysql'),
		    'created_date' => current_time( 'mysql'),
		    'lng' => $lng,
		    'lat' => $lat,
		    'next_session' => '1',
		    'session_1' => false,
		    'session_2' => false,
		    'session_3' => false,
		    'session_4' => false,
		    'session_5' => false,
		    'session_6' => false,
		    'session_7' => false,
		    'session_8' => false,
		    'session_9' => false,
		    'session_10' => false,
		    'ip_address' => $args['ip_address'],
	    ];
	    zume_write_log($group_values);
	    zume_write_log($group_key);


	    $result = add_user_meta( $current_user_id, $group_key, $group_values, true );
	    zume_write_log('User meta submitted');
	    zume_write_log($result);

    }
    public static function edit_group( $args ) {
	    zume_write_log($args);
    }
    public static function delete_group( $args ) {
	    zume_write_log($args);
    }
}
