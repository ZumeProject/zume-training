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
            $namespace, '/zume/check_for_update', [
            [
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => [ $this, 'check_for_update' ],
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
    public function check_for_update( WP_REST_Request $request ) {

        dt_write_log( __METHOD__ );

        $params = $request->get_params();
        $site_key = Site_Link_System::verify_transfer_token( $params['transfer_token'] );

        if ( ! is_wp_error( $site_key ) && $site_key ) {

            if ( isset( $params['zume_foreign_key'] )
            && ! empty( $params['zume_foreign_key'] )
            && isset( $params['zume_check_sum'] )
            && ! empty( $params['zume_check_sum'] )
            && isset( $params['type'] )
            && ! empty( $params['type'] )
            ) {
                if ( $params['type'] === 'contact' ) {

                    // get user_id by zume foreign key
                    $user_id = Zume_Integration::get_user_by_foreign_key( $params['zume_foreign_key'] );
                    if ( ! $user_id ) {
                        return new WP_Error( 'user_lookup_failure', 'Did not find user.' );
                    }

                    // prepare user data
                    $zume = new Zume_Integration();
                    $user_data = $zume->get_transfer_user_array( $user_id );

                    // check supplied check_sum
                    $check_sum = get_user_meta( $user_id, 'zume_check_sum', true );
                    if ( $check_sum == $params['zume_check_sum'] ) {
                        return [
                        'status' => 'OK'
                        ];
                    } else {
                        return [
                        'status' => 'Update_Needed',
                        'raw_record' => $user_data,
                        ];
                    }
                } elseif ( $params['type'] === 'group' ) {
                    // get user_id by zume foreign key
                    $group = Zume_Integration::get_group_by_foreign_key( $params['zume_foreign_key'] );
                    if ( empty( $group ) ) {
                        return new WP_Error( 'group_lookup_failure', 'Did not find group.' );
                    }

                    // prepare user data
                    $zume = new Zume_Integration();
                    $group_meta = $zume->get_transfer_group_array( $group['group_key'], $group['user_id'] );

                    // check supplied check_sum
                    $check_sum = $group_meta['zume_check_sum'];
                    if ( $check_sum === $params['zume_check_sum'] ) {
                        return [
                        'status' => 'OK'
                        ];
                    } else {
                        return [
                        'status' => 'Update_Needed',
                        'raw_record' => $group_meta,
                        ];
                    }
                } else {
                    return new WP_Error( 'malformed_type', 'Type must be either `contact` or `group`' );
                }
            } else {
                return new WP_Error( 'malformed_content', 'Did not find correct params in array.' );
            }
        } else {
            return new WP_Error( 'failed_authentication', 'Failed id and/or token authentication.' );
        }
    }

}
Zume_Integration_Endpoints::instance();