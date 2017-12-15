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
}

Zume_Logging::instance();
