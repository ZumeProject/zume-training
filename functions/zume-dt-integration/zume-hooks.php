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

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    /**
     * Build hook classes
     */
    public function __construct() {
        new Zume_Integration_Hook_User();
        new Zume_Integration_Hook_Groups();
        new Zume_Integration_Metabox();
    }
}
Zume_Integration_Hooks::instance();

/**
 * Empty class for now..
 * Class Zume_Integration_Hook_Base
 */
abstract class Zume_Integration_Hook_Base
{
    public function __construct() {
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
//        add_action( 'zume_session_complete', [ &$this, 'hooks_session_complete' ], 10, 4 ); // @remove to disable session 8 transfer

        parent::__construct();
    }
}

/**
 * Class Zume_Integration_Hook_User
 */
class Zume_Integration_Hook_User extends Zume_Integration_Hook_Base {

    public function add_zume_foreign_key( $user_id ) { // add zume foreign key on registration
        $new_key = Zume_Integration::get_foreign_key( $user_id );
        add_user_meta( $user_id, 'zume_foreign_key', $new_key, true );
    }

    public function check_for_zume_default_meta( $user_login, $user ) {

        if ( empty( get_user_meta( $user->ID, 'zume_foreign_key' ) ) ) {
            Zume_Integration::get_foreign_key( $user->ID );
        }
        if ( empty( get_user_meta( $user->ID, 'zume_language' ) ) ) {
            update_user_meta( $user->ID, 'zume_language', zume_current_language() );
        }

        return;
    }

    public function __construct() {
        add_action( 'user_register', [ &$this, 'add_zume_foreign_key' ], 99, 1 );
        add_action( 'wp_login', [ &$this, 'check_for_zume_default_meta' ], 10, 2 );

        parent::__construct();
    }

}

/**
 * Class Zume_Integration_Hook_Groups
 */
class Zume_Integration_Metabox extends Zume_Integration_Hook_Base {

    public function meta_box_setup() {
        add_meta_box( 'site_link_system_extensions', 'Zúme Configuration', [ $this, 'meta_box_extensions' ], 'site_link_system', 'normal', 'low' );
    }

    public function meta_box_extensions() {
        Site_Link_System::instance()->meta_box_content( 'zume' );

        global $post, $pagenow;
        if ( ! ( $pagenow == 'post-new.php' ) ) {
            echo '<table class="form-table"><tr><th scope="row" width="33%"><label>Affiliation URL</label></th><td>';
            echo '<a href="' . esc_url( site_url() ) . '/local-signup/?affiliation=' . esc_attr( get_post_meta(
                $post->ID,
            'affiliation_key', true ) ) . '" target="">' . esc_url( site_url() ) . '/local-signup/?affiliation=' . esc_attr( get_post_meta(
                $post->ID,
            'affiliation_key', true ) ) . '</a>';
            echo '</td></tr></table>';
        }
    }

    public function add_fields( $fields ) {

        $fields['visibility'] = [
            'name'        => __( 'Visibility' ),
            'description' => 'Private keeps the site connection from being listed on registration and profile.',
            'type'        => 'key_select',
            'default'     => [
        '0' => __( 'Public (Default)' ),
        '1' => __( 'Private' )
            ],
            'section'     => 'zume',
            ];
        $fields['affiliation_key'] = [
            'name'        => __( 'Affiliation Key' ),
            'description' => '',
            'type'        => 'readonly',
            'default'     => Zume_Dashboard::get_unique_public_key(),
            'section'     => 'zume',
        ];

        return $fields;
    }

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'meta_box_setup' ], 20 );
        add_filter( 'site_link_fields_settings', [ $this, 'add_fields' ] );

        parent::__construct();
    }
}
