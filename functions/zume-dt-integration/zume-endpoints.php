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
                    'site' => [
                        'total_users' => 3000,
                        'total_groups' => 400,
                        'session_progress_groups' => [
                            'session_1' => 500,
                            'session_2' => 500,
                            'session_3' => 400,
                            'session_4' => 300,
                            'session_5' => 200,
                            'session_6' => 100,
                            'session_7' => 90,
                            'session_8' => 70,
                            'session_9' => 40,
                            'session_10' => 30,
                        ],
                        'session_progress_users' => [
                            'session_1' => 1000,
                            'session_2' => 100,
                            'session_3' => 100,
                            'session_4' => 100,
                            'session_5' => 100,
                            'session_6' => 100,
                            'session_7' => 100,
                            'session_8' => 100,
                            'session_9' => 100,
                            'session_10' => 100,
                        ],
                        'members_per_group' => [
                            '1' => 200,
                            '2' => 200,
                            '3' => 20,
                            '4' => 20,
                            '5' => 20,
                            '6' => 100,
                            '7' => 20,
                            '8' => 20,
                            '9' => 20,
                            '10' => 10,
                        ],
                        'logins' => [
                            'last_day' => 5,
                            'last_week' => 200,
                            'last_month' => 1200,
                            'last_3_months' => 5000,
                        ],
                        'top_cities' => [
                            0 => 'Denver, CO',
                            1 => 'Lexington, KY',
                            2 => 'Nampa, FL',
                            3 => 'Los Angelos, CA',
                            4 => 'Lexington, KY',
                        ],
                        'top_countries' => [
                            0 => [
                                'name' => 'U.S.A.',
                                'count' => 400,
                            ],
                            1 => [
                                'name' => 'U.S.A.',
                                'count' => 100,
                            ],
                            2 => [
                                'name' => 'U.S.A.',
                                'count' => 50,
                            ],
                            3 => [
                                'name' => 'U.S.A.',
                                'count' => 40,
                            ],
                            4 => [
                                'name' => 'U.S.A.',
                                'count' => 10,
                            ],
                        ],
                        'top_languages' => [
                            0 => [
                                'name' => 'English',
                                'count' => 3000,
                            ],
                            1 => [
                                'name' => 'Farsi',
                                'count' => 500,
                            ],
                            2 => [
                                'name' => 'Arabic',
                                'count' => 300,
                            ],
                            3 => [
                                'name' => 'French',
                                'count' => 200,
                            ],
                            4 => [
                                'name' => 'Spanish',
                                'count' => 100,
                            ],

                        ],
                        'group_locations' => [
                            0 => '39.550007, -105.988124',
                            1 => '33.550007, -104.988124',
                            2 => '34.550007, -105.988124',
                            3 => '35.550007, -104.988124',
                            4 => '39.550007, -105.988124',
                            5 => '36.550007, -104.988124',
                            6 => '39.550007, -105.988124',
                            7 => '35.550007, -105.988124',
                            8 => '31.550007, -104.988124',
                            9 => '38.550007, -105.988124',
                            10 => '39.550007, -104.988124',
                            11 => '34.550007, -105.988124',
                            12 => '35.550007, -104.988124',
                            13 => '34.550007, -105.988124',
                            14 => '34.550007, -105.988124',
                            15 => '33.550007, -104.988124',
                            16 => '32.550007, -102.988124',
                        ]
                    ],
                    'global' => [
                        'total_users' => 3000,
                        'total_groups' => 400,
                        'session_progress_groups' => Zume_Site_Stats::get_group_steps_completed(),
                        'session_progress_users' => [
                            'session_1' => 1000,
                            'session_2' => 100,
                            'session_3' => 100,
                            'session_4' => 100,
                            'session_5' => 100,
                            'session_6' => 100,
                            'session_7' => 100,
                            'session_8' => 100,
                            'session_9' => 100,
                            'session_10' => 100,
                        ],
                        'members_per_group' => Zume_Site_Stats::get_group_sizes(),
                        'logins' => [
                            'last_day' => 5,
                            'last_week' => 200,
                            'last_month' => 1200,
                            'last_3_months' => 5000,
                        ],
                        'top_cities' => [
                            0 => 'Denver, CO',
                            1 => 'Lexington, KY',
                            2 => 'Nampa, FL',
                            3 => 'Los Angelos, CA',
                            4 => 'Lexington, KY',
                        ],
                        'top_countries' => [
                            0 => [
                                'name' => 'U.S.A.',
                                'count' => 400,
                            ],
                            1 => [
                                'name' => 'U.S.A.',
                                'count' => 100,
                            ],
                            2 => [
                                'name' => 'U.S.A.',
                                'count' => 50,
                            ],
                            3 => [
                                'name' => 'U.S.A.',
                                'count' => 40,
                            ],
                            4 => [
                                'name' => 'U.S.A.',
                                'count' => 10,
                            ],
                        ],
                        'top_languages' => [],
                        'group_coordinates' => Zume_Site_Stats::get_group_coordinates(),
                    ]
                ];


                $report['zume_stats_check_sum'] = md5( maybe_serialize( $report ) );
                dt_write_log( $report['zume_stats_check_sum'] );
                dt_write_log( $params['zume_stats_check_sum'] );
                if ( $report['zume_stats_check_sum'] == $params['zume_stats_check_sum'] ) {
                    dt_write_log( 'Okay' );
                    return [
                        'status' => 'OK'
                    ];
                } else {
                    dt_write_log( $report );
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