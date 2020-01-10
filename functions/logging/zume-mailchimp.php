<?php

class Zume_Mailchimp_Integration {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }
        add_action( 'zume_session_complete', array( $this, 'session_complete_hook' ), 50, 4 );
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            'Mailchimp Key',
            'manage_options',
            'zume-mailchimp',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page() {
        // Set class property
        $this->options = get_option( 'zume_mailchimp' );
        ?>
        <div class="wrap">
            <h1>Zume Mailchimp Integration</h1>
            <form action="" method="post">
                <?php wp_nonce_field( 'save_mailchimp_api', 'mailchimp_api' ); ?>
                <button type="submit" name="sync_tags">Sync tags</button>
            </form>
            <form method="post" action="options.php">
                <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'zume-mailchimp' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init() {
        register_setting(
            'my_option_group', // Option group
            'zume_mailchimp', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'zume-mailchimp' // Page
        );

        add_settings_field(
            'api_key',
            'API Key',
            array( $this, 'api_key_callback' ),
            'zume-mailchimp',
            'setting_section_id'
        );

        if ( isset( $_POST['mailchimp_api'] ) && wp_verify_nonce( sanitize_key( $_POST['mailchimp_api'] ), 'save_mailchimp_api' ) && isset( $_POST["sync_tags"] ) ) {
            $this->update_all_tags();
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

        if ( isset( $input['api_key'] ) ) {
            $new_input['api_key'] = sanitize_text_field( $input['api_key'] );
        }

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info() {
        print 'Enter the mailchimp api below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function api_key_callback() {
        printf(
            '<input type="text" id="api_key" name="zume_mailchimp[api_key]" value="%s" />',
            isset( $this->options['api_key'] ) ? '*******' : ''
        );
    }

    public function get_session_mailchimp_key( $session, $user_lang ){
        $sessions = array(
            "en" => array(
                "1" => array(
                    "workflow_id" => "d03393c000",
                    "workflow_email_id" => "d82e85e7e0"
                ),
                "2" => array(
                    "workflow_id" => "31e37f560c",
                    "workflow_email_id" => "21c409c528"
                ),
                "3" => array(
                    "workflow_id" => "410761da92",
                    "workflow_email_id" => "a34de58b7c"
                ),
                "4" => array(
                    "workflow_id" => "b314e148ca",
                    "workflow_email_id" => "6e089a5446"
                ),
                "5" => array(
                    "workflow_id" => "29f7b2444a",
                    "workflow_email_id" => "17935f0df8"
                ),
                "6" => array(
                    "workflow_id" => "deb158f30d",
                    "workflow_email_id" => "16c4897891"
                ),
                "7" => array(
                    "workflow_id" => "bc4ca5edde",
                    "workflow_email_id" => "377b4a7a15"
                ),
                "8" => array(
                    "workflow_id" => "e3539d0421",
                    "workflow_email_id" => "635d3a5c00"
                ),
                "9" => array(
                    "workflow_id" => "dbadd46358",
                    "workflow_email_id" => "68e5ac464d"
                ),
                "10" => array(
                    "workflow_id" => "a34c19efc1",
                    "workflow_email_id" => "54cd7a3562"
                )
            ),
            "ar" => array(
                "1" => array(
                    "workflow_id" => "01357bcec5",
                    "workflow_email_id" => "358c68f49f"
                ),
                "2" => array(
                    "workflow_id" => "63657c9a4b",
                    "workflow_email_id" => "5e9fe17b39"
                ),
                "3" => array(
                    "workflow_id" => "1cd43272f6",
                    "workflow_email_id" => "4b8743d30e"
                ),
                "4" => array(
                    "workflow_id" => "2b3b9df137",
                    "workflow_email_id" => "fb1ea2e36f"
                ),
                "5" => array(
                    "workflow_id" => "971e93b186",
                    "workflow_email_id" => "6ddb3eab14"
                ),
                "6" => array(
                    "workflow_id" => "896778bed5",
                    "workflow_email_id" => "ebdb1a85f0"
                ),
                "7" => array(
                    "workflow_id" => "14c2c44fd6",
                    "workflow_email_id" => "29da656b72"
                ),
                "8" => array(
                    "workflow_id" => "0b13303517",
                    "workflow_email_id" => "6cdf3b6a12"
                ),
                "9" => array(
                    "workflow_id" => "c546bc27f3",
                    "workflow_email_id" => "cf9ea7242a"
                ),
                "10" => array(
                    "workflow_id" => "129b0ed280",
                    "workflow_email_id" => "5d35ac8455"
                )
            )
        );
        if ( isset( $sessions[$user_lang][$session] ) ){
            return $sessions[$user_lang][$session];
        } else {
            return array();
        }
    }

    public function get_group_members( $group_key ){
        global $wpdb;
        $results = $wpdb->get_results( $wpdb->prepare(
            "SELECT meta_value
                FROM `$wpdb->usermeta`
                WHERE meta_key = %s
                ",
            esc_sql( $group_key )
        ), ARRAY_A );
        if ( !isset( $results[0]["meta_value"] ) ) {
            return array();
        }
        $group_meta = maybe_unserialize( $results[0]["meta_value"] );
        $members = $group_meta["coleaders"];
        $current_user = wp_get_current_user();
        $members[] = $current_user->user_email;
        return $members;
    }



    /**
     * When a user completes a session
     * Kick off the email related to completing the session
     * add a tag saying the user completed the session
     */
    public function session_complete_hook( $zume_group_key, $zume_session, $owner_id, $current_user_id ){
        // @todo add english filter
        $allowed_languages = array( "en", "ar" );
        $user_lang = get_user_meta( get_current_user_id(), 'zume_language', true );
        if ( !in_array( $user_lang, $allowed_languages ) ) {
            return;
        }

        $this->options = get_option( 'zume_mailchimp' );
        $api_key = $this->options["api_key"] ?? false;
        $session_workflow = $this->get_session_mailchimp_key( $zume_session, $user_lang );
        $members_emails = $this->get_group_members( $zume_group_key );
        $completed_key = "completed_" . $zume_session;
        if ( !empty( $api_key ) && !empty( $session_workflow ) ) {
            foreach ( $members_emails as $member_email ) {
                $member = get_user_by( "email", $member_email );
                if ( $member ) {
                    $mailchimp_emails_sent = get_user_meta( $member->ID, 'mailchimp_emails_sent', true );
                    if ( empty( $mailchimp_emails_sent ) ){
                        $mailchimp_emails_sent = array();
                    }
                    if ( !in_array( $completed_key, $mailchimp_emails_sent ) ){
                        $mailchimp_emails_sent[] = $completed_key;
                        update_user_meta( $member->ID, 'mailchimp_emails_sent', $mailchimp_emails_sent );
                        $automation_url = "https://us14.api.mailchimp.com/3.0/automations/" . $session_workflow['workflow_id'] . "/emails/" . $session_workflow['workflow_email_id'] . "/queue";
                        $response       = wp_remote_post( $automation_url, array(
                            "body"        => json_encode( array(
                                "email_address" => $member->user_email,
                            ) ),
                            "headers"     => array(
                                "Authorization" => "auto $api_key",
                                'Content-Type'  => 'application/json; charset=utf-8'
                            ),
                            'data_format' => 'body',
                        ) );
                        if ( is_wp_error( $response ) ) {
                            error_log( $response );
                        }

                        $tag_data   = array();
                        $tag_data[] = array(
                            "name"   => $completed_key,
                            "status" => "active"
                        );
                        $user_hash  = md5( strtolower( $member->user_email ) );
                        $tag_url    = "https://us14.api.mailchimp.com/3.0/lists/dcc3f0b14e/members/$user_hash/tags";
                        $response   = wp_remote_post( $tag_url, array(
                            "body"        => json_encode( array(
                                "tags" => $tag_data
                            ) ),
                            "headers"     => array(
                                "Authorization" => "tags $api_key",
                                'Content-Type'  => 'application/json; charset=utf-8'
                            ),
                            'data_format' => 'body',
                        ) );
                        if ( is_wp_error( $response ) ) {
                            error_log( $response );
                        }
                    }
                }
            }
        }
    }

    public function update_all_tags(){
        $this->options = get_option( 'zume_mailchimp' );
        if ( isset( $this->options["api_key"] ) ) {
            $api_key = $this->options["api_key"];
            global $wpdb;
            $users = $wpdb->get_results( "
                SELECT * from wp_users as users
                WHERE user_status = 0
                AND users.ID NOT IN ( SELECT user_id from wp_usermeta WHERE meta_key = 'synced_mailchimp' )
                GROUP BY users.ID
                LIMIT 500
            ", ARRAY_A );

            foreach ( $users as $user ) {
                $user = get_user_by( "ID", $user["ID"] );

                //get groups
                $groups = $wpdb->get_results( $wpdb->prepare(
                    "SELECT *
                    FROM `$wpdb->usermeta`
                    WHERE meta_key LIKE %s
                    AND ( user_id = %s OR meta_value LIKE %s )
                   ",
                    $wpdb->esc_like( 'zume_group_' ) . '%',
                    $user->ID,
                    '%'. $wpdb->esc_like( $user->user_email ). '%'
                ), ARRAY_A );

                $tags = array();
//                @todo remove closed groups and groups you have not accepted
                foreach ( $groups as $group ) {
                    $group_data = maybe_unserialize( $group["meta_value"] );
                    for ( $i = 1; $i < $group_data["next_session"]; $i ++ ) {
                        $tag = "completed_" . $i;
                        if ( !in_array( $tag, $tags )){
                            $tags[] = $tag;
                        }
                    }
                }
                $tags_data = array();
                foreach ( $tags as $tag ){
                    $tags_data[] = array(
                        "name"   => $tag,
                        "status" => "active"
                    );
                }
                if ( !empty( $tags ) ) {
                    //update tags
                    $user_hash = md5( strtolower( $user->user_email ) );
                    $tag_url   = "https://us14.api.mailchimp.com/3.0/lists/dcc3f0b14e/members/$user_hash/tags";
                    $response  = wp_remote_post( $tag_url, array(
                        "body"        => json_encode( array(
                            "tags" => $tags_data
                        ) ),
                        "headers"     => array(
                            "Authorization" => "tags $api_key",
                            'Content-Type'  => 'application/json; charset=utf-8'
                        ),
                        'data_format' => 'body',
                    ) );
                    if ( is_wp_error( $response ) ) {
                        error_log( $response );
                    }
                    if ( !isset( $response["response"]["code"] ) || ( $response["response"]["code"] != 204 && $response["response"]["code"] != 404 ) ){
                        return false;
                    }
                }
                update_user_meta( $user->ID, 'synced_mailchimp', 1 );
            }
        }
    }
}


new Zume_Mailchimp_Integration();
