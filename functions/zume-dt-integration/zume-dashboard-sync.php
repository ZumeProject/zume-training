<?php
add_filter( 'https_ssl_verify', '__return_false' );
add_filter( 'http_request_args', function( $params, $url ) {
    // find out if this is the request you are targeting and if not: abort
    add_filter( 'https_ssl_verify', '__return_false' );

    return $params;
}, 10, 2 );

class Zume_Dashboard_Sync {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        $this->options = get_option( 'zume_dashboard' );

        if ( is_admin() ) {
            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }

        add_action( 'user_register', [ &$this, 'hooks_user_register' ] );
        add_action( 'zume_update_profile', [ &$this, 'hooks_update_profile' ], 10, 1 );
        add_action( 'zume_create_group', [ &$this, 'hooks_create_group' ], 10, 3 );
        add_action( 'zume_activate_group', [ &$this, 'hooks_activate_group' ], 10, 2 );
        add_action( 'zume_delete_group', [ &$this, 'hooks_delete_group' ], 10, 2 );
        add_action( 'zume_close_group', [ &$this, 'hooks_close_group' ], 10, 2 );
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(
            'Zume Dashboard Sync',
            'Zume Dashboard Sync',
            'manage_options',
            'zume-dashboard',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option( 'zume_dashboard' );
        ?>
        <div class="wrap">
            <h1>Zume Dashboard Sync</h1>
            <hr>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'zume_dashboard_option_group' );
                do_settings_sections( 'zume-dashboard' );
                submit_button();
                ?>
            </form>
            <hr><br>

            <form action="" method="post">
                <?php wp_nonce_field( 'save_dashboard_api', 'dashboard_api' ); ?>
                <button class="button" type="submit" name="sync_users">Sync Users to DT</button>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting(
            'zume_dashboard_option_group', // Option group
            'zume_dashboard', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Zume Dashboard Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'zume-dashboard' // Page
        );

        add_settings_field(
            'site_id',
            'Dashboard Site ID',
            array( $this, 'api_key_callback' ),
            'zume-dashboard',
            'setting_section_id'
        );

        if ( isset( $_POST['dashboard_api'] ) && wp_verify_nonce( sanitize_key( $_POST['dashboard_api'] ), 'save_dashboard_api' ) && isset( $_POST["sync_users"] ) ) {
            $this->update_all_users();
        }
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     *
     * @return array
     */
    public function sanitize( $input ) {
        $new_input = array();

        if ( isset( $input['site_id'] ) ) {
            $new_input['site_id'] = sanitize_text_field( $input['site_id'] );
        }
        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info() {
        print 'Enter the dashboard site id below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function api_key_callback() {
        printf(
            '<input type="text" id="site_id" name="zume_dashboard[site_id]" value="%s" />',
            isset( $this->options['site_id'] ) ? '*******' : ''
        );
    }

    public function update_all_users(){
        $site_id = $this->options;
        if ( ! $site_id ) {
            return;
        }


    }

    public function hooks_user_register( $user_id ) {
        $site_id = $this->options;
        if ( ! $site_id ) {
            return;
        }

        dt_write_log( __METHOD__ );



        // Get target site for transfer
        $site_key = get_option( 'zume_default_site' );
        if ( ! $site_key ) {
            dt_write_log( __METHOD__ . ' (Failure: filter_for_site_key)' );
            return; // no sites setup
        }
        $site = zume_integration_get_site_details( $site_key );
        if ( ! $site ) {
            dt_write_log( __METHOD__ . ' (Failure: zume_integration_get_site_details | '.$site_key.')' );
            return;
        }

        // Send remote request
        $args = [
            'method' => 'POST',
            'body' => [
                'transfer_token' => $site['transfer_token'],
                'create_contact' => [],
            ]
        ];
        $result = zume_integration_remote_send( 'create_contact', $site['url'], $args );

        dt_write_log( $result );

    }

    public function hooks_delete_user( $user_id ) {
        $site_id = $this->options;
        if ( ! $site_id ) {
            return;
        }
    }

    public function hooks_update_profile( $user_id ) {
        $site_id = $this->options;
        if ( ! $site_id ) {
            return;
        }
    }

    public function hooks_create_group( $user_id, $group_key, $new_group ) {
        $site_id = $this->options;
        if ( ! $site_id ) {
            return;
        }
    }

    public function hooks_delete_group( $user_id, $group_key ) {
        $site_id = $this->options;
        if ( ! $site_id ) {
            return;
        }
    }

    public function hooks_activate_group( $user_id, $group_key ) {
        $site_id = $this->options;
        if ( ! $site_id ) {
            return;
        }
    }

}


new Zume_Dashboard_Sync();
