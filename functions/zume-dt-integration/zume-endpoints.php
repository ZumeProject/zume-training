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

    public static function instance() {
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
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'add_api_routes' ] );
    } // End __construct()

    public function add_api_routes() {
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

        register_rest_route(
            $namespace, '/zume/get_project_stats', [
                [
                    'methods'  => WP_REST_Server::CREATABLE,
                    'callback' => [ $this, 'get_project_stats' ],
                ],
            ]
        );

        $private_namespace = 'zume/v1';
        register_rest_route( $private_namespace, '/send_coaching_request', array(
            array(
                'methods'         => WP_REST_Server::CREATABLE,
                'callback'        => array( $this, 'send_coaching_request' ),
            ),
        ) );

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
        dt_write_log( $params );
        $site_key = Site_Link_System::verify_transfer_token( $params['transfer_token'] );

        if ( ! is_wp_error( $site_key ) && $site_key ) {

            if ( isset( $params['zume_foreign_key'] )
            && ! empty( $params['zume_foreign_key'] )
            && isset( $params['zume_check_sum'] )
            && ! empty( $params['zume_check_sum'] )
            && isset( $params['zume_groups_check_sum'] )
            && ! empty( $params['zume_groups_check_sum'] )
            && isset( $params['type'] )
            && ! empty( $params['type'] )
            ) {
                if ( $params['type'] === 'contact' ) {

                    // get user_id by zume foreign key
                    $user_id = Zume_Integration::get_user_by_foreign_key( $params['zume_foreign_key'] );
                    if ( ! $user_id ) {
                        return new WP_Error( 'user_lookup_failure', 'Did not find user.' );
                    }

                    // check supplied check_sum
                    $check_sum = get_user_meta( $user_id, 'zume_check_sum', true );
                    $zume_groups_check_sum = get_user_meta( $user_id, 'zume_groups_check_sum', true );

                    if ( $check_sum == $params['zume_check_sum'] && $zume_groups_check_sum == $params['zume_groups_check_sum'] ) {
                        return [
                        'status' => 'OK'
                        ];
                    } else {
                        // prepare user data
                        $zume = new Zume_Integration();
                        $user_data = $zume->get_transfer_user_array( $user_id );
                        $group_data = $zume->get_all_groups( $user_id );

                        return [
                        'status' => 'Update_Needed',
                        'raw_record' => $user_data,
                        'raw_group_records' => $group_data,
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

    public function get_project_stats( WP_REST_Request $request ) {
        dt_write_log( __METHOD__ );

        $params = $request->get_params();
        $site_key = Site_Link_System::verify_transfer_token( $params['transfer_token'] );

        if ( ! is_wp_error( $site_key ) && $site_key ) {

            if ( isset( $params['zume_stats_check_sum'] ) && ! empty( $params['zume_stats_check_sum'] ) ) {

                if ( get_transient( 'dt_zume_site_stats' ) ) {
                    $report = get_transient( 'dt_zume_site_stats' );
                    if ( $report['zume_stats_check_sum'] == $params['zume_stats_check_sum'] ) {
                        return [
                            'status' => 'OK'
                        ];
                    } else {
                        return [
                            'status' => 'Update_Needed',
                            'raw_record' => $report,
                        ];
                    }
                }

                $report = Zume_Site_Stats::build();

                if ( $report['zume_stats_check_sum'] == $params['zume_stats_check_sum'] ) {
                    return [
                        'status' => 'OK'
                    ];
                } else {
                    return [
                        'status' => 'Update_Needed',
                        'raw_record' => $report,
                    ];
                }
            } else {
                return new WP_Error( 'malformed_type', 'Missing check sum' );
            }
        } else {
            return new WP_Error( 'failed_authentication', 'Failed id and/or token authentication.' );
        }
    }

    public function send_coaching_request( WP_REST_Request $request ) {
        $params = $request->get_params();
        $user = wp_get_current_user();

        // get new elements and update profile
        if ( isset( $params['zume_full_name'] ) && ! empty( $params['zume_full_name'] ) ) {
            update_user_meta( $user->ID, 'zume_full_name', $params['zume_full_name'] );
        } else {
            return new WP_Error( __METHOD__, 'Missing name.' );
        }
        if ( isset( $params['zume_phone_number'] ) && ! empty( $params['zume_phone_number'] ) ) {
            update_user_meta( $user->ID, 'zume_phone_number', $params['zume_phone_number'] );
        }
        if ( isset( $params['address_profile'] ) && ! empty( $params['address_profile'] ) ) {
            update_user_meta( $user->ID, 'address_profile', $params['address_profile'] );
        }
        if ( isset( $params['zume_contact_preference'] ) && ! empty( $params['zume_contact_preference'] ) ) {
            update_user_meta( $user->ID, 'zume_contact_preference', $params['zume_contact_preference'] );
        }
        if ( isset( $params['zume_affiliation_key'] ) && ! empty( $params['zume_affiliation_key'] ) ) {
            update_user_meta( $user->ID, 'zume_affiliation_key', $params['zume_affiliation_key'] );
        }

        // submit for a transfer
        $object = new Zume_Integration();
        $result = $object->send_coaching_request_transfer( $user->ID );

        dt_write_log( __METHOD__ );
        dt_write_log( $result );

        // updated user record with submitted record
        if ( isset( $result['status'] ) && 'OK' === $result['status'] ) {
            update_user_meta( $user->ID, 'zume_transferred', current_time( 'timestamp' ) );
            return __( 'Successfully send!' );
        } else {
            update_user_meta( $user->ID, 'zume_transferred', 0 );
            $result->add( 'error_message', __( 'Failed to send request. Please try again.' ) );
            return $result;
        }
    }
}
Zume_Integration_Endpoints::instance();