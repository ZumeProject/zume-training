<?php

/**
 * Location_Lookup_REST_API
 *
 * @class Location_Lookup_REST_API
 * @version	0.1
 * @since 0.1
 * @package	Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Location_Lookup_REST_API {

    private $version = 1;
    private $context = "lookup";
    private $namespace;

    /**
     * Location_Lookup_REST_API The single instance of Location_Lookup_REST_API.
     * @var 	object
     * @access  private
     * @since 	0.1
     */
    private static $_instance = null;

    /**
     * Main Location_Lookup_REST_API Instance
     *
     * Ensures only one instance of Location_Lookup_REST_API is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Location_Lookup_REST_API instance
     */
    public static function instance () {
        if ( is_null( self::$_instance ) )
            self::$_instance = new self();
        return self::$_instance;
    } // End instance()

    /**
     * Constructor function.
     * @access  public
     * @since   0.1
     */
    public function __construct () {
        $this->namespace = $this->context . "/v" . intval($this->version);
        add_action('rest_api_init', array($this,  'add_api_routes'));

    } // End __construct()

    public function add_api_routes () {
        $version = '1';
        $namespace = 'lookup/v' . $version;
        $base = 'tract';
        register_rest_route( $namespace, '/' . $base . '/findbyaddress', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'find_by_address' ),
            ),
        ) );
        register_rest_route( $namespace, '/' . $base. '/gettractmap', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'get_tract_map' ),

            ),
        ) );
        register_rest_route( $namespace, '/' . $base. '/getmapbygeoid', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'get_map_by_geoid' ),

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
    public function find_by_address (WP_REST_Request $request){
        $params = $request->get_params();
        if (isset($params['address'])){
            $result = Location_Lookup_Controller::get_tract_by_address($params['address']);
            if ($result["status"] == 'OK'){
                return $result["tract"];
            } else {
                return new WP_Error("tract_status_error", $result["message"], array('status', 400));
            }
        } else {
            return new WP_Error("tract_param_error", "Please provide a valid address", array('status', 400));
        }
    }

    /**
     * Get tract from submitted address
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error The contact on success
     */
    public function get_tract_map (WP_REST_Request $request){
        $params = $request->get_params();
        if (isset($params['address'])){
            $result = Location_Lookup_Controller::get_tract_map($params['address']);
            if ($result["status"] == 'OK'){
                return $result;
            } else {
                return new WP_Error("map_status_error", $result["message"], array('status', 400));
            }
        } else {
            return new WP_Error("map_param_error", "Please provide a valid address", array('status', 400));
        }
    }

    /**
     * Get map by geoid
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error The contact on success
     */
    public function get_map_by_geoid (WP_REST_Request $request){
        $params = $request->get_params();
        if (isset($params['geoid'])){
            $result = Location_Lookup_Controller::get_map_by_geoid ($params);
            if ($result["status"] == 'OK'){
                return $result;
            } else {
                return new WP_Error("map_status_error", $result["message"], array('status', 400));
            }
        } else {
            return new WP_Error("map_param_error", "Please provide a valid address", array('status', 400));
        }
    }

}