<?php

/**
 * Zume_v4_REST_API
 *
 * @class Zume_v4_REST_API
 * @version 0.1
 * @since 0.1
 * @package Disciple_Tools
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


class Zume_v4_REST_API {

    /**
     * Zume_v4_REST_API The single instance of Zume_v4_REST_API.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_v4_REST_API instance
     *
     * Ensures only one instance of Zume_v4_REST_API is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_v4_REST_API instance
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
                "permission_callback" => function () {
                    return current_user_can( 'zume' );
                }
            ),
        ) );

        /* Groups */
        register_rest_route( $namespace, '/groups/create', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'groups_create' ),
                "permission_callback" => function () {
                    return current_user_can( 'zume' );
                }
            ),
        ) );
        register_rest_route( $namespace, '/groups/read', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'groups_read' ),
                "permission_callback" => function () {
                    return current_user_can( 'zume' );
                }
            ),
        ) );
        register_rest_route( $namespace, '/groups/update', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'groups_update' ),
                "permission_callback" => function () {
                    return current_user_can( 'zume' );
                }
            ),
        ) );

        /** Locations */
        register_rest_route( $namespace, '/locations/validate_address', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'validate_by_address' ),
                "permission_callback" => function () {
                    return current_user_can( 'zume' );
                }
            ),
        ) );
    }



    public function progress_update( WP_REST_Request $request){
        $params = $request->get_params();
        if ( isset( $params['key'] ) && ! empty( $params['key'] ) && isset( $params['state'] ) ) {
            $params['key'] = sanitize_text_field( wp_unslash( $params['key'] ) );
            $params['state'] = sanitize_text_field( wp_unslash( $params['state'] ) );
            return Zume_v4_Progress::update_user_progress( $params['key'], $params['state'] );
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

        switch( $params['item'] ) {
            case 'group_name':
                return Zume_v4_Groups::update_group_name( $params['key'], $params['value'] );
                break;
            case 'members':
                return Zume_v4_Groups::update_member_count( $params['key'], $params['value'] );
                break;
            case 'coleaders_add':
                return Zume_v4_Groups::add_coleader( $params['key'], $params['value'] );
                break;
            case 'coleaders_delete':
                return Zume_v4_Groups::delete_coleader( $params['value'], $params['key'] );
                break;
            case 'session_complete':
                return Zume_v4_Groups::update_group_session_status( $params['key'], $params['value'], true );
                break;
            case 'archive_group':
                $result = Zume_v4_Groups::archive_group( $params['key'] );
                if ( $result ) {
                    return Zume_v4_Groups::get_all_groups( get_current_user_id() );
                }
                return false;
                break;
            case 'activate_group':
                $result = Zume_v4_Groups::activate_group( $params['key'] );
                if ( $result ) {
                    return Zume_v4_Groups::get_all_groups( get_current_user_id() );
                }
                return false;
                break;
            case 'delete_group':
                $result = Zume_v4_Groups::delete_group( $params['key'] );
                if ( $result ) {
                    return Zume_v4_Groups::get_all_groups( get_current_user_id() );
                }
                return false;
                break;
            case 'coleader_invitation_response':
                $result = Zume_v4_Groups::coleader_invitation_response( $params['key'], $params['value'] );
                if ( $result ) {
                    return [
                        'invitations' => Zume_v4_Groups::get_colead_groups( 'waiting_acceptance_minimum' ),
                        'groups' => Zume_v4_Groups::get_all_groups( get_current_user_id() ),
                    ];
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

        $args = [
            'group_name' => sanitize_text_field( wp_unslash( $params['name'] ) ),
            'members' => sanitize_text_field( wp_unslash( $params['members'] ) ),
        ];
        $meta_id = Zume_v4_Groups::create_group( $args );
        if ( $meta_id ) {
            return Zume_v4_Groups::get_all_groups( get_current_user_id() );
        } else {
            dt_write_log(__METHOD__ . ': Failed to create new group.');
            return false;
        }
    }
    public function groups_read( WP_REST_Request $request){
        return Zume_v4_Groups::get_all_groups();
    }

    /**
     * Get tract from submitted address
     *
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error The contact on success
     */
    public function validate_by_address( WP_REST_Request $request){
        $params = $request->get_json_params();
        if ( isset( $params['address'] ) ){

            $result = DT_Mapbox_API::lookup( $params['address'] );

            if ( isset( $result['features'] ) ){
                return $result;
            } else {
                return new WP_Error( "tract_status_error", 'Zero Results', array( 'status' => 400 ) );
            }
        } else {
            return new WP_Error( "tract_param_error", "Please provide a valid address", array( 'status' => 400 ) );
        }
    }

}
Zume_v4_REST_API::instance();
