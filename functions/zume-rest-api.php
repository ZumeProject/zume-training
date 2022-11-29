<?php
// @todo remove


/**
 * Zume_REST_API
 *
 * @class Zume_REST_API
 * @version 0.1
 * @since 0.1
 * @package Disciple_Tools
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}
// @todo delete after 4.0
// unlink group and link group are the only endpoints that might move forward with 4.0

class Zume_REST_API {

    /**
     * Zume_REST_API The single instance of Zume_REST_API.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_REST_API instance
     *
     * Ensures only one instance of Zume_REST_API is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_REST_API instance
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
        $version = '1';
        $namespace = 'zume/v' . $version;

        register_rest_route( $namespace, '/locations/validate_address', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'validate_by_address' ),
                "permission_callback" => function () {
                    return ( current_user_can( 'zume' ) || current_user_can( 'subscriber' ) );
                }
            ),
        ) );



        register_rest_route( $namespace, '/change_public_key', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'change_public_key' ),
                "permission_callback" => function () {
                    return ( current_user_can( 'zume' ) || current_user_can( 'subscriber' ) );
                }
            ),
        ) );

        register_rest_route( $namespace, '/connect_plan_to_group', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'connect_plan_to_group' ),
                "permission_callback" => function () {
                    return ( current_user_can( 'zume' ) || current_user_can( 'subscriber' ) );
                }
            ),
        ) );

        register_rest_route( $namespace, '/unlink_plan_from_group', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'unlink_plan_from_group' ),
                "permission_callback" => function () {
                    return ( current_user_can( 'zume' ) || current_user_can( 'subscriber' ) );
                }
            ),
        ) );

        register_rest_route( $namespace, '/coleaders_delete', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'coleader_delete' ),
                "permission_callback" => function () {
                    return ( current_user_can( 'zume' ) || current_user_can( 'subscriber' ) );
                }
            ),
        ) );

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

    /**
     * Coleader Delete
     *
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error The contact on success
     */
    public function coleader_delete( WP_REST_Request $request){
        $params = $request->get_json_params();
        if ( isset( $params['email'] ) && isset( $params['group_id'] ) ){

            $result = Zume_Dashboard::delete_coleader( $params['email'], $params['group_id'] );

            if ( $result['status'] == 'OK'){
                return true;
            } else {
                return new WP_Error( "coleader_delete_error", $result['status'] );
            }
        } else {
            return new WP_Error( "coleader_param_error", "Please provide a valid params", array( 'status' => 400 ) );
        }
    }

    /**
     * Coleader Delete
     *
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error The contact on success
     */
    public function connect_plan_to_group( WP_REST_Request $request){
        $params = $request->get_json_params();
        if ( isset( $params['public_key'] ) ){

            $result = Zume_Three_Month_Plan::connect_plan_to_group( $params['public_key'] );

            return $result;

        } else {
            return new WP_Error( "coleader_param_error", "Please provide a valid params", array( 'status' => 400 ) );
        }
    }

    /**
     * Change public key
     *
     * @param WP_REST_Request $request
     * @return string|WP_Error
     */
    public function change_public_key( WP_REST_Request $request ) {
        $params = $request->get_json_params();
        if ( isset( $params['group_key'] ) ){

            $result = Zume_Dashboard::change_group_public_key( $params['group_key'] );

            return $result;

        } else {
            return new WP_Error( "public_key_param_error", "Please provide a valid params", array( 'status' => 400 ) );
        }
    }

    /**
     * Update Session Complete
     *
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error
     */
    public function update_session_complete( WP_REST_Request $request){
        $params = $request->get_params();
        if ( isset( $params['group_key'] ) && isset( $params['session_id'] ) ) {

            $result = Zume_Dashboard::update_session_complete( $params['group_key'], $params['session_id'] );

            if ($result["status"] == true){
                return 'success';
            } else {
                return new WP_Error( "log_status_error", $result["message"], array( 'status' => 400 ) );
            }
        } else {
            return new WP_Error( "log_param_error", "Please provide a valid address", array( 'status' => 400 ) );
        }
    }

    /**
     * Update Session Complete
     *
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error
     */
    public function unlink_plan_from_group( WP_REST_Request $request){
        $params = $request->get_params();
        if ( isset( $params['group_key'] ) ) {

            $result = Zume_Three_Month_Plan::unlink_plan_from_group( $params['group_key'] );
            return $result;

        } else {
            return new WP_Error( "log_param_error", "Please provide a valid address", array( 'status' => 400 ) );
        }
    }



}
Zume_REST_API::instance();
