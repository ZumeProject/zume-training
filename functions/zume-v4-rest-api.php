<?php

// @todo remove

/**
 * Zume_V4_REST_API
 *
 * @class Zume_V4_REST_API
 * @version 0.1
 * @since 0.1
 * @package Disciple_Tools
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


class Zume_V4_REST_API {

    /**
     * Zume_V4_REST_API The single instance of Zume_V4_REST_API.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_V4_REST_API instance
     *
     * Ensures only one instance of Zume_V4_REST_API is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_V4_REST_API instance
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
        add_action( 'rest_api_init', array( $this,  'add_api_routes' ) );

    } // End __construct()

    public function add_api_routes() {
        $version = '4';
        $namespace = 'zume/v' . $version;

        /* Zume 4.0 */
        /* Progress */
        register_rest_route( $namespace, '/progress/update', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'progress_update' ),
                'permission_callback' => '__return_true'
            ),
        ) );

        /* Groups */
        register_rest_route( $namespace, '/groups/create', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'groups_create' ),
                'permission_callback' => '__return_true'
            ),
        ) );
        register_rest_route( $namespace, '/groups/read', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'groups_read' ),
                'permission_callback' => '__return_true'
            ),
        ) );
        register_rest_route( $namespace, '/groups/update', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'groups_update' ),
                'permission_callback' => '__return_true'
            ),
        ) );

        /** Locations */
        register_rest_route( $namespace, '/locations/update', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'location_update' ),
                'permission_callback' => '__return_true'
            ),
        ) );
        register_rest_route( $namespace, '/coaching_request', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'coaching_request' ),
                'permission_callback' => '__return_true'
            ),
        ) );
        register_rest_route( $namespace, '/update_profile', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'update_profile' ),
                'permission_callback' => '__return_true'
            ),
        ) );
        register_rest_route( $namespace, '/unlink_profile', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'unlink_profile' ),
                'permission_callback' => '__return_true'
            ),
        ) );
        register_rest_route( $namespace, '/piece', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'piece_content' ),
                'permission_callback' => '__return_true'
            ),
        ) );
    }

    public function progress_update( WP_REST_Request $request){
        $params = $request->get_params();
        if ( isset( $params['key'] ) && ! empty( $params['key'] ) && isset( $params['state'] ) ) {
            $params['key'] = sanitize_text_field( wp_unslash( $params['key'] ) );
            $params['state'] = sanitize_text_field( wp_unslash( $params['state'] ) );
            return Zume_V4_Progress::update_user_progress( $params['key'], $params['state'] );
        } else {
            return new WP_Error( __METHOD__, "Missing parameters", array( 'status' => 400 ) );
        }
    }

    public function groups_update( WP_REST_Request $request){
        $params = $request->get_params();
        if ( empty( $params['key'] ?? null ) || empty( $params['value'] ?? null ) || empty( $params['item'] ?? null ) ) {
            return new WP_Error( __METHOD__, "Missing parameters", array( 'status' => 400 ) );
        }
        $params['key'] = sanitize_text_field( wp_unslash( $params['key'] ) );
        $params['value'] = sanitize_text_field( wp_unslash( $params['value'] ) );
        $params['item'] = sanitize_text_field( wp_unslash( $params['item'] ) );

        switch ( $params['item'] ) {
            case 'group_name':
                return Zume_V4_Groups::update_group_name( $params['key'], $params['value'] );
                break;
            case 'members':
                return Zume_V4_Groups::update_member_count( $params['key'], $params['value'] );
                break;
            case 'coleaders_add':
                return Zume_V4_Groups::add_coleader( $params['key'], $params['value'] );
                break;
            case 'coleaders_delete':
                return Zume_V4_Groups::delete_coleader( $params['value'], $params['key'] );
                break;
            case 'session_complete':
                return Zume_V4_Groups::update_group_session_status( $params['key'], $params['value'], true );
                break;
            case 'archive_group':
                $result = Zume_V4_Groups::archive_group( $params['key'] );
                if ( $result ) {
                    return Zume_V4_Groups::get_all_groups( get_current_user_id() );
                }
                return false;
                break;
            case 'activate_group':
                $result = Zume_V4_Groups::activate_group( $params['key'] );
                if ( $result ) {
                    return Zume_V4_Groups::get_all_groups( get_current_user_id() );
                }
                return false;
                break;
            case 'delete_group':
                $result = Zume_V4_Groups::delete_group( $params['key'] );
                if ( $result ) {
                    return Zume_V4_Groups::get_all_groups( get_current_user_id() );
                }
                return false;
                break;
            case 'coleader_invitation_response':
                $result = Zume_V4_Groups::coleader_invitation_response( $params['key'], $params['value'] );
                if ( $result ) {
                    return array(
                        'invitations' => Zume_V4_Groups::get_colead_groups( 'waiting_acceptance_minimum' ),
                        'groups' => Zume_V4_Groups::get_all_groups( get_current_user_id() ),
                    );
                }
                return false;
                break;
            default:
                return new WP_Error( __METHOD__, "Incorrect type", array( 'status' => 400 ) );
                break;
        }
    }

    public function groups_create( WP_REST_Request $request){
        $params = $request->get_params();
        if ( ! isset( $params['name'] ) || ! isset( $params['members'] ) ) {
            return new WP_Error( "log_param_error", "Missing parameters", array( 'status' => 400 ) );
        }

        $ip = DT_Ipstack_API::get_real_ip_address();
        $hash_ip = hash( 'sha256', $ip );
        if ( false !== get_transient( $hash_ip ) ) {
            dt_write_log( __METHOD__ . ': Duplicate check on group creation triggered for ip:' . $ip );
            return false;
        } else {
            set_transient( $hash_ip, true, 45 );
        }

        $args = array(
            'group_name' => sanitize_text_field( wp_unslash( $params['name'] ) ),
            'members' => sanitize_text_field( wp_unslash( $params['members'] ) ),
        );
        $meta_id = Zume_V4_Groups::create_group( $args );
        if ( $meta_id ) {
            return Zume_V4_Groups::get_all_groups( get_current_user_id() );
        } else {
            dt_write_log( __METHOD__ . ': Failed to create new group.' );
            return false;
        }
    }

    public function groups_read( WP_REST_Request $request){
        return Zume_V4_Groups::get_all_groups();
    }

    public function location_update( WP_REST_Request $request){
        $params = $request->get_json_params();
        if ( isset( $params['key'] ) ) {
            $result = Zume_V4_Groups::update_location( $params['key'], $params );
            if ( $result ) {
                return Zume_V4_Groups::get_all_groups( get_current_user_id() );
            }
            return false;
        } else {
            return new WP_Error( "tract_param_error", "Please provide a valid address", array( 'status' => 400 ) );
        }
    }

    public function unlink_profile( WP_REST_Request $request){
        $params = $request->get_json_params();
        if ( isset( $params['type'] ) ) {
            switch ( $params['type'] ) {
                case 'facebook':
                    delete_user_meta( get_current_user_id(), 'facebook_sso_email' );
                    delete_user_meta( get_current_user_id(), 'facebook_sso_id' );
                    delete_user_meta( get_current_user_id(), 'facebook_session_token' );
                    break;
                case 'google':
                    delete_user_meta( get_current_user_id(), 'google_sso_email' );
                    delete_user_meta( get_current_user_id(), 'google_sso_id' );
                    delete_user_meta( get_current_user_id(), 'google_session_token' );
                    break;
                default:
                    return new WP_Error( "tract_param_error", "Unable to unlink profile", array( 'status' => 400 ) );
                    break;
            }
        } else {
            return new WP_Error( "tract_param_error", "Unable to unlink profile", array( 'status' => 400 ) );
        }
        return true;
    }

    public function update_profile( WP_REST_Request $request){
        $params = $request->get_json_params();
        $user_info = get_userdata( get_current_user_id() );

        // update name
        $name = sanitize_text_field( wp_unslash( $params['name'] ) );
        if ( empty( $name ) ) {
            delete_user_meta( $user_info->ID, 'zume_full_name' );
        } else {
            update_user_meta( $user_info->ID, 'zume_full_name', $name );
        }

        // update phone
        $phone = sanitize_text_field( wp_unslash( $params['phone'] ) );
        if ( empty( $phone ) ) {
            delete_user_meta( $user_info->ID, 'zume_phone_number' );
        } else {
            update_user_meta( $user_info->ID, 'zume_phone_number', $phone );
        }

        // update email
        $email = sanitize_email( wp_unslash( $params['email'] ) );
        if ( $email !== $user_info->ID && ! empty( $email ) ) {
            $args = array();
            $args['ID'] = $user_info->ID;
            $args['user_email'] = $email;

            $result = wp_update_user( $args );
            if ( is_wp_error( $result ) ) {
                return new WP_Error( 'fail_update_user_data', 'Error while updating user data in user table.' );
            }
        }

        // update affiliation key
        $affiliation_key = sanitize_text_field( wp_unslash( trim( $params['affiliation_key'] ) ) );
        if ( empty( $affiliation_key ) ) {
            delete_user_meta( $user_info->ID, 'zume_affiliation_key' );
        } else {
            update_user_meta( $user_info->ID, 'zume_affiliation_key', $affiliation_key );
        }

        // update location_grid_meta
        if ( empty( $params['location_grid_meta'] ) ) {
            delete_user_meta( $user_info->ID, 'location_grid_meta' );
        } else {
            if ( ! class_exists( 'Location_Grid_Geocoder' ) ) {
                require_once( get_stylesheet_directory() . '/dt-mapping/geocode-api/location-grid-geocoder.php' );
            }
            $geocoder = new Location_Grid_Geocoder();

            $location_grid_meta = array_map( 'sanitize_text_field', wp_unslash( $params['location_grid_meta'] ) );
            $lng = empty( $location_grid_meta['lng'] ) ? false : $location_grid_meta['lng'];
            $lat = empty( $location_grid_meta['lat'] ) ? false : $location_grid_meta['lat'];
            if ( $lng && $lat ) {
                $grid = $geocoder->get_grid_id_by_lnglat( $lng, $lat );
                if ( isset( $grid['grid_id'] ) ) {
                    $location_grid_meta['grid_id'] = $grid['grid_id'];
                }
            }

            Location_Grid_Meta::validate_location_grid_meta( $args['location_grid_meta'] );

            update_user_meta( $user_info->ID, 'location_grid_meta', $location_grid_meta );
        }

        $zume_user = wp_get_current_user();
        $zume_user_meta = zume_get_user_meta( $zume_user->ID );

        return [
            'id' => $zume_user->data->ID,
            'name' => $zume_user_meta['zume_full_name'] ?? '',
            'email' => $zume_user->data->user_email,
            'phone' => $zume_user_meta['zume_phone_number'] ?? '',
            'location_grid_meta' => ( empty( $zume_user_meta['location_grid_meta'] ?? '' ) ) ? [] : maybe_unserialize( $zume_user_meta['location_grid_meta'] ),
            'affiliation_key' => $zume_user_meta['zume_affiliation_key'] ?? '',
            'facebook_sso_email' => $zume_user_meta['facebook_sso_email'] ?? false,
            'google_sso_email' => $zume_user_meta['google_sso_email'] ?? false,
        ];
    }

    /**
     * @param WP_REST_Request $request
     * @return array|WP_Error
     */
    public function coaching_request( WP_REST_Request $request ) {
        $user_id = get_current_user_id();
        $params = $request->get_params();
        if ( ! isset( $params['name'] ) ) {
            return new WP_Error( "log_param_error", "Missing parameters", array( 'status' => 400 ) );
        }

        $args = array(
            'name' => sanitize_text_field( wp_unslash( $params['name'] ) ),
            'phone' => sanitize_text_field( wp_unslash( $params['phone'] ) ),
            'email' => sanitize_text_field( wp_unslash( $params['email'] ) ),
            'preference' => sanitize_text_field( wp_unslash( $params['preference'] ) ),
            'language_preference' => sanitize_text_field( wp_unslash( $params['language_preference'] ) ),
            'affiliation_key' => sanitize_text_field( wp_unslash( $params['affiliation_key'] ) ),
            'coaching_preference' => wp_kses_post( $params['coaching_preference'] ?? "" ),
        );
        $notes = [
            'preference' => 'Requested contact method is: ' .$args['preference'],
            'affiliation' => 'Requested affiliation is: ' . $args['affiliation_key'],
            "coaching_preference" => "Coaching Preference is:\n" . $args['coaching_preference'],
        ];
        $zume_foreign_key = self::get_foreign_key( $user_id );

        // build fields for transfer
        $fields = [
            "title" => $args['name'],
            "sources" => [
                "values" => [
                    [ "value" => "zume_training" ],  //add new, or make sure it exists
                ],
            ],
            "contact_phone" => [
                [ "value" => $args['phone'] ],
            ],
            "contact_email" => [
                [ "value" => $args['email'] ],
            ],
            'language_preference' => $args['language_preference'],
            'zume_training_id' => $user_id,
            'zume_foreign_key' => $zume_foreign_key,
            "notes" => $notes,
        ];

        // Additional fields that may or may not be present

        // Build location_grid_meta
        if ( ! class_exists( 'Location_Grid_Meta' ) ) {
            require_once( get_stylesheet_directory() . '/dt-mapping/location-grid-meta.php' );
        }
        if ( ! class_exists( 'DT_Ipstack_API' ) ) {
            require_once( get_stylesheet_directory() . '/dt-mapping/geocode-api/ipstack-api.php' );
        }

        if ( empty( $params['location_grid_meta'] ) ) {
            // if no provided location, get ip address location
            $ip_result = DT_Ipstack_API::geocode_current_visitor();
            $args['location_grid_meta'] = Location_Grid_Meta::convert_ip_result_to_location_grid_meta( $ip_result );
        } else if ( ! empty( $params['location_grid_meta'] ) ) {
            $args['location_grid_meta'] = $params['location_grid_meta'];
        } else {
            $args['location_grid_meta'] = [];
        }

        Location_Grid_Meta::validate_location_grid_meta( $args['location_grid_meta'] );

        if ( isset( $args['location_grid_meta'] ) ) {
            $fields['location_grid_meta'] = [
                "values" => []
            ];
            $fields['location_grid_meta']['values'][] = $args['location_grid_meta'];
//            $fields['contact_address'] = [
//                [ "value" => $args['location_grid_meta']['label'] ],
//            ];
        }

        $site = Site_Link_System::get_site_connection_vars( 20125 ); // @todo remove hardcoded
        if ( ! $site ) {
            return new WP_Error( __METHOD__, 'Missing site to site data' );
        }

        $args = [
            'method' => 'POST',
            'body' => $fields,
            'headers' => [
                'Authorization' => 'Bearer ' . $site['transfer_token'],
            ],
            'timeout' => 15, //instead of 5 seconds
        ];

        $result = wp_remote_post( 'https://' . trailingslashit( $site['url'] ) . 'wp-json/dt-posts/v2/contacts', $args );
        if ( is_wp_error( $result ) ) {
            return new WP_Error( 'failed_remote_post', $result->get_error_message() );
        }

        $body = json_decode( $result['body'], true );

        if ( isset( $body['ID'] ) ) {
            update_user_meta( $user_id, 'zume_global_network', [
                "contact_id" => $body['ID'],
                "date_transferred" => time()
            ] );
        }

        return $result;

    }

    public function piece_content( WP_REST_Request $request ) {
        $params = $request->get_params();
        if ( ! isset( $params['id'], $params['lang'], $params['strings'] ) ) {
            return new WP_Error( "log_param_error", "Missing parameters", array( 'status' => 400 ) );
        }
        $lang = 'en';
        if ( ! empty( $params['lang'] ) ) {
            $lang = sanitize_text_field( wp_unslash( $params['lang'] ) );
        }

        $postid = sanitize_text_field( wp_unslash( $params['id'] ) );
        $strings = dt_recursive_sanitize_array( $params['strings'] );

        return get_modal_content( $postid, $lang, $strings );
    }

    public static function get_foreign_key( $user_id ) {
        $key = get_user_meta( $user_id, 'zume_foreign_key', true );
        if ( empty( $key ) ) {
            $key = Site_Link_System::generate_token( 40 ); // forty bits equals 1.1 trillion combinations
            update_user_meta( $user_id, 'zume_foreign_key', $key );
        }
        return $key;
    }

}
Zume_V4_REST_API::instance();
