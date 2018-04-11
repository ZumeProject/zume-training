<?php
/**
 * Zume Logging Class
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

function zume_insert_log( $args = [] ) {
    Zume_Logging::insert( $args );
}
function zume_log_last_active( $user_id ) {
    $time = current_time( 'mysql' );
    $result = update_user_meta( $user_id, 'zume_last_active', $time );
    return $result;
}

class Zume_Logging {
    /**
     * Disciple_Tools The single instance of Disciple_Tools.
     *
     * @var    object
     * @access private
     * @since  0.1.0
     */
    private static $_instance = null;

    /**
     * Main Zume_Logging Instance
     * Ensures only one instance of Zume_Logging is loaded or can be loaded.
     *
     * @since  0.1.0
     * @static
     * @return Zume_Logging instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    } // End instance()

    /**
     * @since 0.1.0
     *
     * @param array $args
     *
     * @return void
     */
    public static function insert( $args ) {
        global $wpdb;

        $args = wp_parse_args(
            $args,
            [
                'created_date' => current_time( 'mysql' ),
                'user_id'      => get_current_user_id(),
                'group_id'     => '',
                'page'         => '',
                'action'       => '',
                'meta'         => '',
            ]
        );

        // Make sure for non duplicate.
        $check_duplicate = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT
                     `id`
                FROM
                    `$wpdb->zume_logging`
                WHERE
                     `created_date` = %s
                    AND `user_id` = %d
                    AND `group_id` = %s
                    AND `page` = %s
                    AND `action` = %s
                    AND `meta` = %s
				;",
                $args['created_date'],
                $args['user_id'],
                $args['group_id'],
                $args['page'],
                $args['action'],
                $args['meta']
            )
        );

        if ( $check_duplicate ) {
            return;
        }

        $wpdb->insert(
            $wpdb->zume_logging,
            [
                'created_date' => current_time( 'mysql' ),
                'user_id'      => $args['user_id'],
                'group_id'     => $args['group_id'],
                'page'         => $args['page'],
                'action'       => $args['action'],
                'meta'         => $args['meta'],
            ],
            [ '%s', '%d', '%s', '%s', '%s', '%s' ]
        );

        // Final action on insert.
        do_action( 'zume_insert_logging_activity', $args );
    }

    public function __construct() {
        add_action( 'wp_login', [ &$this, 'hooks_wp_login' ], 10, 2 );
        add_action( 'wp_logout', [ &$this, 'hooks_wp_logout' ] );
        add_action( 'delete_user', [ &$this, 'hooks_delete_user' ] );
        add_action( 'user_register', [ &$this, 'hooks_user_register' ] );
        add_action( 'zume_create_group', [ &$this, 'hooks_create_group' ], 10, 3 );
        add_action( 'zume_delete_group', [ &$this, 'hooks_delete_group' ], 10, 2 );
        add_action( 'zume_close_group', [ &$this, 'hooks_close_group' ], 10, 2 );
        add_action( 'zume_activate_group', [ &$this, 'hooks_activate_group' ], 10, 2 );
        add_action( 'zume_coleader_invitation_response', [ &$this, 'hooks_coleader_invitation_response' ], 99, 3 );
        add_action( 'zume_update_profile', [ &$this, 'hooks_update_profile' ], 10, 1 );
        add_action( 'zume_update_three_month_plan', [ &$this, 'hooks_update_three_month_plan' ], 10, 2 );
        add_action( 'added_user_meta', [ &$this, 'hooks_affiliation_key' ], 20, 4 );
    }

    public function hooks_wp_login( $user_login, $user ) {
        self::insert(
            [
                'user_id'  => $user->ID,
                'group_id' => '',
                'page'     => 'login',
                'action'   => 'logged_in',
                'meta'     => '',
            ]
        );
        update_user_meta( $user->ID, 'last_activity', current_time( 'mysql' ) );
    }

    public function hooks_user_register( $user_id ) {
        self::insert(
            [
                'user_id'  => $user_id,
                'group_id' => '',
                'page'     => 'register',
                'action'   => 'registered',
                'meta'     => '',
            ]
        );
    }

    public function hooks_delete_user( $user_id ) {
        self::insert(
            [
                'user_id'  => $user_id,
                'group_id' => '',
                'page'     => 'delete_user',
                'action'   => 'deleted',
                'meta'     => '',
            ]
        );
    }

    public function hooks_wp_logout() {
        $user = wp_get_current_user();

        self::insert(
            [
                'user_id'  => $user->ID,
                'group_id' => '',
                'page'     => 'logout',
                'action'   => 'logged_out',
                'meta'     => '',
            ]
        );
    }

    public function hooks_create_group( $user_id, $group_key, $new_group ) {
        self::insert(
            [
                'user_id'  => $user_id,
                'group_id' => $group_key,
                'page'     => 'dashboard',
                'action'   => 'create_group',
                'meta'     => '',
            ]
        );
    }

    public function hooks_update_profile( $user_id ) {
        self::insert(
            [
                'user_id'  => $user_id,
                'group_id' => '',
                'page'     => 'profile',
                'action'   => 'update_profile',
                'meta'     => '',
            ]
        );
    }

    public function hooks_delete_group( $user_id, $group_key ) {
        self::insert(
            [
                'user_id'  => $user_id,
                'group_id' => $group_key,
                'page'     => 'dashboard',
                'action'   => 'delete_group',
                'meta'     => '',
            ]
        );
    }

    public function hooks_update_three_month_plan( $user_id, $plan ) {
        self::insert(
            [
                'user_id'  => $user_id,
                'group_id' => '',
                'page'     => 'profile',
                'action'   => 'update_three_month_plan',
                'meta'     => '',
            ]
        );
    }

    public function hooks_activate_group( $user_id, $group_key ) {
        self::insert(
            [
                'user_id'  => $user_id,
                'group_id' => $group_key,
                'page'     => 'dashboard',
                'action'   => 'activate_group',
                'meta'     => '',
            ]
        );
    }

    public function hooks_coleader_invitation_response( $user_id, $group_key, $decision ) {
        self::insert(
            [
                'user_id'  => $user_id,
                'group_id' => $group_key,
                'page'     => 'dashboard',
                'action'   => 'coleader_invitation_response',
                'meta'     => $decision,
            ]
        );
    }

    public function hooks_affiliation_key( $meta_id, $object_id, $meta_key, $_meta_value ) {
        if ( 'zume_affiliation_key' === $meta_key ) {
            self::insert(
                [
                    'user_id'  => $object_id,
                    'group_id' => '',
                    'page'     => 'profile',
                    'action'   => 'added_affiliate_key',
                    'meta'     => $_meta_value,
                ]
            );
        }

    }
}

Zume_Logging::instance();
