<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Class Zume_Integration_Hooks
 */
class Zume_Integration_Hooks
{

    private static $_instance = null;

    public static function instance()
    {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    /**
     * Build hook classes
     */
    public function __construct()
    {
        new Zume_Integration_Hook_User();
        new Zume_Integration_Hook_Groups();
    }
}
Zume_Integration_Hooks::instance();

/**
 * Empty class for now..
 * Class Zume_Integration_Hook_Base
 */
abstract class Zume_Integration_Hook_Base
{
    public function __construct()
    {
    }
}

/**
 * Class Zume_Integration_Hook_Groups
 */
class Zume_Integration_Hook_Groups extends Zume_Integration_Hook_Base {

    public function hooks_session_complete( $zume_group_key, $zume_session, $owner_id, $current_user_id ) {
        if ( $zume_session >= get_option( 'zume_session_complete_transfer_level' ) ) {
            dt_write_log( __METHOD__ . ': Session ' . $zume_session . ' Completed' );
            try {
                $send_new_user = new Zume_Integration_Session_Complete_Transfer();
                $send_new_user->launch(
                    [
                    'zume_group_key'    => $zume_group_key,
                    'owner_id'          => $owner_id,
                    'current_user_id'   => $current_user_id,
                    ]
                );
            } catch ( Exception $e ) {
                dt_write_log( '@' . __METHOD__ );
                dt_write_log( 'Caught exception: ', $e->getMessage(), "\n" );
            }
        }
        return;
    }

    public function __construct() {
        add_action( 'zume_session_complete', [ &$this, 'hooks_session_complete' ], 10, 4 );

        parent::__construct();
    }
}


/**
 * Class Zume_Integration_Hook_User
 */
class Zume_Integration_Hook_User extends Zume_Integration_Hook_Base {

    public function add_zume_foreign_key( $user_id ) { // add zume foreign key on registration
        $new_key = Zume_Integration_Zume::get_foreign_key( $user_id );
        add_user_meta( $user_id, 'zume_foreign_key', $new_key, true );
    }

    public function hooks_three_month_plan_updated( $user_id, $plan ) {
        try {
            $send_new_user = new Zume_Integration_Three_Month_Plan_Updated();
            $send_new_user->launch(
                [
                'user_id'   => $user_id,
                ]
            );
        } catch ( Exception $e ) {
            dt_write_log( '@' . __METHOD__ );
            dt_write_log( 'Caught exception: ', $e->getMessage(), "\n" );
        }
        return;
    }

    public function check_for_zume_default_meta( $user_login, $user ) {

        if ( empty( get_user_meta( $user->ID, 'zume_foreign_key' ) ) ) {
            Zume_Integration_Zume::get_foreign_key( $user->ID );
        }
        if ( empty( get_user_meta( $user->ID, 'zume_language' ) ) ) {
            update_user_meta( $user->ID, 'zume_language', zume_current_language() );
        }

        return;
    }

    public function __construct() {
        add_action( 'user_register', [ &$this, 'add_zume_foreign_key' ], 99, 1 );
        add_action( 'zume_update_three_month_plan', [ &$this, 'hooks_three_month_plan_updated' ], 99, 2 );
        add_action( 'wp_login', [ &$this, 'check_for_zume_default_meta' ], 10, 2 );

        parent::__construct();
    }

}