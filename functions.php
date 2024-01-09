<?php
/**
 * Zume Project
 */

// Debugging Functions
require_once( 'functions/utilities/debugger-log.php' ); // debug logger used for development.
require_once( 'functions/utilities/global-functions.php' ); // debug logger used for development.

// Post Types
//require_once( 'functions/post-types/video-post-type.php' );
//require_once( 'functions/post-types/pdf-download-post-type.php' );
require_once( 'functions/post-types/qr-meta-box.php' );

// Integrations Files
require_once( 'functions/integrations/zume-polylang-integration.php' ); // Adds support for multiple languages
require_once( 'functions/integrations/network-dashboard-remote-integration.php' );
require_once( 'functions/integrations/yoast-integration.php' );

// Zume Theme Files
require_once( 'functions/login/zume-login.php' ); // Customize the login page
require_once( 'translations/translation.php' ); // Adds support for multiple languages
require_once( 'functions/utilities/enqueue-scripts.php' ); // Register scripts and stylesheets
require_once( 'functions/utilities/theme-support.php' ); // Theme support options
require_once( 'functions/utilities/cleanup.php' ); // WP Head and other cleanup functions
require_once( 'functions/utilities/menu.php' ); // Register custom menus and menu walkers
require_once( 'functions/multi-role/multi-role.php' ); // Adds multi role features

// Rest
require_once( 'functions/utilities/restrict-rest-api.php' ); // Restricts the default REST API to logged in users
remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );
require_once( 'functions/utilities/restrict-xml-rpc-pingback.php' ); // Restricts RPC vulnerability

// Zume 3.0 Files to Deprecate after 4.0 upgrade
require_once( 'functions/zume-course.php' ); // zume course
$zume_course = Zume_Course::instance();
require_once( 'functions/zume-dashboard.php' ); // zume dashboard
require_once( 'functions/zume-rest-api.php' );
// end 3.0

// Mapping
require_once( 'dt-mapping/loader.php' );
new DT_Mapping_Module_Loader( 'theme' );

// zume 4.0
require_once( 'functions/zume-v4-rest-api.php' );
require_once( 'functions/zume-v4-users.php' );
require_once( 'functions/zume-v4-groups.php' );
require_once( 'functions/zume-v4-progress.php' );
require_once( 'functions/zume-v4-pieces.php' );
require_once( 'functions/zume-v4-seo-strings.php' );
require_once( 'functions/zume-content.php' );
require_once( 'functions/zume-three-month-plan.php' );
require_once( 'functions/zume-v4-modal-pieces-content.php' );
require_once( 'functions/zume-functions.php' ); // general zume functions
require_once( 'functions/report-log.php' );


require_once( 'functions/logging/zume-mailchimp.php' );

// Zume - DT - Integration
require_once( 'functions/integrations/site-link-post-type.php' );
Site_Link_System::instance();
require_once( 'functions/zume-v4-global-network-link.php' );


if ( is_admin() ) {

    require_once( 'functions/post-types/pieces-page-metabox.php' );
    require_once( 'functions/post-types/landing-template-metaboxes.php' );

    require_once( 'functions/integrations/tab-keys.php' );
    require_once( 'functions/integrations/menu-and-tabs.php' );
    require_once( 'functions/post-types/zume-resource-metabox.php' );
//    require_once( 'functions/zume-dt-integration/system-check-metabox.php' );

    require_once( 'functions/utilities/tgm-config.php' );

    add_filter( 'manage_pages_columns', 'add_template_column' );
    add_action( 'manage_pages_custom_column', 'add_template_value', 10, 2 );
}

function add_template_column( $cols ) {
    $cols['template'] = 'Template';
    return $cols;
}
function add_template_value( $column_name, $post_id ) {
    if ( 'template' === $column_name ) {
        $template = get_post_meta( $post_id, '_wp_page_template', true );
        if ( isset( $template ) && $template ) {
            echo esc_html( $template );
        } else {
            echo 'None';
        }
    }

}


/**
 * redirect all logins to the home page
 */
add_filter( 'login_redirect', function( $url, $query, $user ) {
    return zume_dashboard_url();
}, 10, 3 );

function zume_mirror_url(){
    return 'https://storage.googleapis.com/zume-file-mirror/';
}

function zume_alt_video( $current_language = null ) {
    $alt_video = false;

    if ( ! $current_language ) {
        $current_language = zume_current_language();
    }

    if ( ! $alt_video ) {
        $alt_video = ( 'id' === $current_language ); // @todo expand this if more than indonesian is a problem
    }

    return $alt_video;
}

/**
 * @return bool|mixed
 */
function zume_v4_ready_language() {
    $ready = array();

//    $ready['id'] = false;

    $current = zume_current_language();

    return $ready[$current] ?? true;
}

if ( ! function_exists( 'dt_recursive_sanitize_array' ) ) {
    function dt_recursive_sanitize_array( array $array ) : array {
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = dt_recursive_sanitize_array( $value );
            }
            else {
                $value = sanitize_text_field( wp_unslash( $value ) );
            }
        }
        return $array;
    }
}




