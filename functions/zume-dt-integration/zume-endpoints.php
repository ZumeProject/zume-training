<?php
/**
 * Zume_Integration_Endpoints
 *
 * @class      Zume_Integration_DT_Endpoints
 * @since      0.1.0
 * @package    DT_Webform
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}


/**
 * Class DT_Webform_Home_Endpoints
 */
class Zume_Integration_Endpoints
{
    private static $_instance = null;

    public static function instance()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor function.
     *
     * @access  public
     * @since   0.1.0
     */
    public function __construct()
    {
        add_action( 'rest_api_init', [ $this, 'add_api_routes' ] );
    } // End __construct()

    public function add_api_routes()
    {
        $version = '1';
        $namespace = 'dt-public/v' . $version;

        register_rest_route(
            $namespace, '/zume/get_contact_by_foreign_key', [
            [
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => [ $this, 'get_contact_by_foreign_key' ],
            ],
            ]
        );

    }

    /**
     * Respond to transfer request of files
     *
     * @param \WP_REST_Request $request
     * @return array|\WP_Error
     */
    public function get_contact_by_foreign_key( WP_REST_Request $request ) {

        dt_write_log( __METHOD__ );

        $params = $request->get_params();
        $site_key = DT_Site_Link_System::verify_transfer_token( $params['transfer_token'] );

        if ( ! is_wp_error( $site_key ) && $site_key ) {

            if ( isset( $params['zume_foreign_key'] ) && ! empty( $params['zume_foreign_key'] ) ) {

                // get user_id by zume foreign key
                $user_id = Zume_Integration::get_user_by_foreign_key( $params['zume_foreign_key'] );
                if ( ! $user_id ) {
                    return new WP_Error( 'user_lookup_failure', 'Did not find user.' );
                }

                // prepare user data
                $zume = new Zume_Integration();
                $user_data = $zume->get_transfer_user_array( $user_id );
                return [
                    'raw_record' => $user_data,
                ];

            } else {
                return new WP_Error( 'malformed_content', 'Did not find `selected_records` in array.' );
            }
        } else {
            return new WP_Error( 'failed_authentication', 'Failed id and/or token authentication.' );
        }
    }

}
Zume_Integration_Endpoints::instance();