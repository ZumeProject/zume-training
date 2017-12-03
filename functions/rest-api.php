<?php

/**
 * Zume_REST_API
 *
 * @class Zume_REST_API
 * @version	0.1
 * @since 0.1
 * @package	Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Zume_REST_API {

    private $version = 1;
    private $context = "lookup";
    private $namespace;

    /**
     * Zume_REST_API The single instance of Zume_REST_API.
     * @var 	object
     * @access  private
     * @since 	0.1
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
        $namespace = 'zume/v' . $version;
        register_rest_route( $namespace, '/' . 'attendance/log', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'log_attendance' ),
                "permission_callback" => function () {
                    return current_user_can( 'publish_steplogs' );
                }
            ),
        ) );
    }

    /**
     * Log attendance
     * @param WP_REST_Request $request
     * @access public
     * @since 0.1
     * @return string|WP_Error
     */
    public function log_attendance (WP_REST_Request $request){
        $params = $request->get_params();
        if (isset($params['members'])){
            $result = $this->record_members_attendance($params);
            if ($result["status"] == true){
                return 'success';
            } else {
                return new WP_Error("log_status_error", $result["message"], array('status', 400));
            }
        } else {
            return new WP_Error("log_param_error", "Please provide a valid address", array('status', 400));
        }
    }

    /**
     * Adds session record to members who where noted as attending the session.
     * @param $params
     * @return array|bool|false|int|string
     */
    public function record_members_attendance ($params) {

        $members = json_decode($params['members']);
        $session = $params['session'];
        $group_id = $params['group_id'];
        $status = '';

        foreach($members as $member) {
            // key is $session & $group_id is value. This would record the highest session attended and which group it was attended with.
            if(get_user_meta($member, 'session_' . $session) == '') {
                $status = add_user_meta($member, 'session_' . $session, $group_id, true);
            } else {
                $status = update_user_meta($member, 'session_' . $session, $group_id,  $group_id);
            }
        }

        $status = array('status' => $status);
        return $status;

    }

}