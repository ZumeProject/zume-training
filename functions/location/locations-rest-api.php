<?php

/**
 * Zume_Location_Lookup_REST_API
 *
 * @class Zume_Location_Lookup_REST_API
 * @version 0.1
 * @since 0.1
 * @package Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

class Zume_Location_Lookup_REST_API {

    private $version = 1;
    private $context = "zume";
    private $namespace;

    /**
     * Zume_Location_Lookup_REST_API The single instance of Zume_Location_Lookup_REST_API.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Location_Lookup_REST_API Instance
     *
     * Ensures only one instance of Zume_Location_Lookup_REST_API is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Location_Lookup_REST_API instance
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
        $this->namespace = $this->context . "/v" . intval( $this->version );
        add_action( 'rest_api_init', array( $this,  'add_api_routes' ) );

    } // End __construct()

    public function add_api_routes() {
        $namespace = $this->namespace;
        $base = 'locations';
        register_rest_route( $namespace, '/' . $base . '/validate_address', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'validate_by_address' ),
            ),
        ) );

    }

    /**
     * Get tract from submitted address
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error The contact on success
     */
    public function validate_by_address( WP_REST_Request $request){
        $params = $request->get_json_params();
        if ( isset( $params['address'] ) ){

            $result = Zume_Google_Geolocation::query_google_api( $params['address'] );

            if ( $result['status'] == 'OK'){
                return $result;
            } else {
                return new WP_Error( "tract_status_error", 'Zero Results', array( 'status', 400 ) );
            }
        } else {
            return new WP_Error( "tract_param_error", "Please provide a valid address", array( 'status', 400 ) );
        }
    }

}
