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

        register_rest_route(
            $namespace, '/zume/get_project_stats', [
                [
                    'methods'  => WP_REST_Server::CREATABLE,
                    'callback' => [ $this, 'get_project_stats' ],
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

    public function get_project_stats( WP_REST_Request $request ) {
        dt_write_log( __METHOD__ );

        $params = $request->get_params();
        $site_key = Site_Link_System::verify_transfer_token( $params['transfer_token'] );

        if ( ! is_wp_error( $site_key ) && $site_key ) {

            if ( isset( $params['zume_stats_check_sum'] ) && ! empty( $params['zume_stats_check_sum'] ) ) {

                $report = [
                    'hero_stats' => Zume_Site_Stats::hero_stats(),
                    'groups_progress_by_month' => [
                        [ 'Month', 'Registered', 'Engaged', 'Active', 'Trained', 'Average' ],
                        [ '2004/05',  165,      938,         522,             998,             614.6 ],
                        [ '2005/06',  135,      1120,        599,             1268,          682 ],
                        [ '2006/07',  157,      1167,        587,             807,             623 ],
                        [ '2007/08',  139,      1110,        615,             968,            609.4 ],
                        [ '2008/09',  136,      691,         629,             1026,          569.6 ],
                        [ '2008/09',  136,      691,         629,             1026,           569.6 ],
                    ],
                    'people_progress_by_month' => [
                        [ 'Month', 'Registered', 'Engaged', 'Active', 'Trained', 'Average' ],
                        [ '2004/05',  165,      938,         522,             998,             614.6 ],
                        [ '2005/06',  135,      1120,        599,             1268,          682 ],
                        [ '2006/07',  157,      1167,        587,             807,             623 ],
                        [ '2007/08',  139,      1110,        615,             968,            609.4 ],
                        [ '2008/09',  136,      691,         629,             1026,          569.6 ],
                        [ '2008/09',  136,      691,         629,             1026,           569.6 ],
                    ],
                    'table_totals_group_people' => [
                        [ 'Type', 'Groups', 'People', ],
                        [ 'Registrations', 200, 150 ],
                        [ 'Active', 100, 90 ],
                        [ 'Trained', 100, 90 ],
                        [ 'System Total', 100, 90 ],
                    ],
                    'table_total_misc' => [
                        [ 'Type', 'Groups', 'People', ],
                        [ 'Registrations', 200, 150 ],
                        [ 'Active', 100, 90 ],
                        [ 'Trained', 100, 90 ],
                        [ 'System Total', 100, 90 ],
                    ],
                    'members_per_group' => Zume_Site_Stats::get_group_sizes(),
                    'current_session_of_group' => Zume_Site_Stats::get_groups_next_session(),
                    'sessions_completed_by_groups' => Zume_Site_Stats::get_sessions_completed_by_groups(),
                    'trained_groups_coordinates' => Zume_Site_Stats::get_group_coordinates(), // @todo needs filtered for just trained groups
                    'session_progress_people' => [
                        [ 'Session', 'People', [ 'role' => 'annotation' ] ],
                        [ 'Session 1', 3000, 3000 ],
                        [ 'Session 2', 2000, 2000 ],
                        [ 'Session 3', 1900, 1900 ],
                        [ 'Session 4', 500, 500 ],
                        [ 'Session 5', 900, 900 ],
                        [ 'Session 6', 670, 670 ],
                        [ 'Session 7', 550, 550 ],
                        [ 'Session 8', 460, 460 ],
                        [ 'Session 9', 100, 100 ],
                        [ 'Session 10', 40, 40 ],
                    ],
                    'active_people_timeline' => [
                        [ 'Month', 'Logins', 'Completed Sessions' ],
                        [ 'Feb', 1000, 121 ],
                        [ 'Mar', 1000, 101 ],
                        [ 'Apr', 1000, 191 ],
                        [ 'May', 1000, 101 ],
                        [ 'Jun', 1000, 101 ],
                        [ 'Jul', 1000, 151 ],
                        [ 'Aug', 1000, 101 ],
                        [ 'Sep', 1000, 121 ],
                        [ 'Oct', 1000, 101 ],
                        [ 'Nov', 1000, 171 ],
                        [ 'Dec', 1000, 101 ],
                        [ 'Jan', 1000, 101 ],
                        [ 'Feb', 1170, 111 ],
                    ],
                    'people_info' => [
                        [ 'Label', 'Number' ],
                        [ 'No Group', 3456 ],
                        [ 'More than 1 Group', 56 ],
                    ],
                    'people_languages' => Zume_Site_Stats::get_people_languages(),
                    'group_coordinates' => Zume_Site_Stats::get_group_coordinates(),
                ];


                $report['zume_stats_check_sum'] = md5( maybe_serialize( $report ) );
                $report['timestamp'] = current_time( 'mysql' );

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
}
Zume_Integration_Endpoints::instance();