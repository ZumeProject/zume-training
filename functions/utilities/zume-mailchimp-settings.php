<?php

const ZUME_SECTION_ID = "zume_project_plugin_main";
const ZUME_PAGE_ID = "zume_project_plugin";
const ZUME_SETTING_ID_MAILCHIMP_KEY = "zume_mailchimp_api_key";
const ZUME_SETTING_ID_MAILCHIMP_DC = "zume_mailchimp_dc";
const ZUME_SETTING_ID_MAILCHIMP_LIST_ID = "zume_mailchimp_list_id";
const ZUME_PREFIX_SETTING_ID_MAILCHIMP_AUTOMATION_SESSION = "zume_mailchimp_automation_session_";

add_action( 'admin_menu', 'zume_plugin_admin_menu' );

function zume_plugin_admin_menu() {
    add_options_page( 'Zúme Project Plugin', 'Zúme Project Plugin', 'manage_options', 'zume-project-plugin', 'zume_options_page' );
}

function zume_options_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( "Zúme Project Theme" ); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( ZUME_SECTION_ID );
            do_settings_sections( ZUME_PAGE_ID );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action( 'admin_init', 'zume_plugin_admin_init' );

function zume_plugin_admin_init() {
    register_setting( ZUME_SECTION_ID, ZUME_SETTING_ID_MAILCHIMP_KEY, 'trim' );
    register_setting( ZUME_SECTION_ID, ZUME_SETTING_ID_MAILCHIMP_DC, 'trim' );
    register_setting( ZUME_SECTION_ID, ZUME_SETTING_ID_MAILCHIMP_LIST_ID, 'trim' );
    for ($i = 1; $i <= 10; $i++) {
        register_setting( ZUME_SECTION_ID, ZUME_PREFIX_SETTING_ID_MAILCHIMP_AUTOMATION_SESSION . "$i", "trim" );
    }

    add_settings_section( ZUME_SECTION_ID, 'MailChimp Settings', 'zume_section_text', ZUME_PAGE_ID );
    add_settings_field( ZUME_SETTING_ID_MAILCHIMP_KEY, 'MailChimp API key', 'zume_mailchimp_api_key_input_html', ZUME_PAGE_ID, ZUME_SECTION_ID );
    add_settings_field( ZUME_SETTING_ID_MAILCHIMP_DC, 'MailChimp data center', 'zume_mailchimp_dc_input_html', ZUME_PAGE_ID, ZUME_SECTION_ID );
    add_settings_field( ZUME_SETTING_ID_MAILCHIMP_LIST_ID, 'MailChimp List ID', 'zume_mailchimp_list_id_html', ZUME_PAGE_ID, ZUME_SECTION_ID );

    for ($i = 1; $i <= 10; $i++) {
        add_settings_field(
            ZUME_PREFIX_SETTING_ID_MAILCHIMP_AUTOMATION_SESSION . "$i",
            "MailChimp automation trigger when session $i is completed",
            'zume_mailchimp_automation_session_input_html',
            ZUME_PAGE_ID,
            ZUME_SECTION_ID,
            array( $i )
        );
    }
}

function zume_section_text() {
    echo '<p>Please fill in your MailChimp API key here for use in the website.</p>';
}

function zume_mailchimp_api_key_input_html() {
    $option = get_option( ZUME_SETTING_ID_MAILCHIMP_KEY );
    printf(
        '<input id="%s" name="%s" size="40" type="text" value="%s" placeholder="eg: 2af544907acd90-us14">',
        esc_attr( ZUME_SETTING_ID_MAILCHIMP_KEY ), esc_attr( ZUME_SETTING_ID_MAILCHIMP_KEY ), esc_attr( $option )
    );
}

function zume_mailchimp_dc_input_html() {
    $option = get_option( ZUME_SETTING_ID_MAILCHIMP_DC );
    printf(
        '<input id="%s" name="%s" size="40" type="text" value="%s" placeholder="eg: us14">',
        esc_attr( ZUME_SETTING_ID_MAILCHIMP_DC ), esc_attr( ZUME_SETTING_ID_MAILCHIMP_DC ), esc_attr( $option )
    );
}

function zume_mailchimp_list_id_html() {
    $option = get_option( ZUME_SETTING_ID_MAILCHIMP_LIST_ID );
    printf(
        '<input id="%s" name="%s" size="40" type="text" value="%s" placeholder="eg: ab43ae">',
        esc_attr( ZUME_SETTING_ID_MAILCHIMP_LIST_ID ), esc_attr( ZUME_SETTING_ID_MAILCHIMP_LIST_ID ), esc_attr( $option )
    );
}

function zume_mailchimp_automation_session_input_html( $args ) {
    $session_number = $args[0];
    $option = get_option( ZUME_PREFIX_SETTING_ID_MAILCHIMP_AUTOMATION_SESSION . "$session_number" );
    printf(
        '<input id="%s" name="%s" size="80" type="url" value="%s" placeholder="eg: https://us14.mailchimp.com/3.0/automations/533a4/emails/43a0/queue">',
        esc_attr( ZUME_PREFIX_SETTING_ID_MAILCHIMP_AUTOMATION_SESSION . "$session_number" ),
        esc_attr( ZUME_PREFIX_SETTING_ID_MAILCHIMP_AUTOMATION_SESSION . "$session_number" ),
        esc_attr( $option )
    );
}


