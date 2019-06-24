<?php
/**
 * Zume Project
 */
require_once( 'functions/utilities/debugger-log.php' ); // debug logger used for development.

define( 'ZUME_DOMAIN', 'zume' );
define( 'ZUME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ZUME_VERSION', '1.0' );

/**
 * Add custom table
 */
global $wpdb;
require_once 'functions/activator.php';
$wpdb->zume_logging = $wpdb->prefix . 'zume_logging';
require_once( 'functions/post-types/video-post-type.php' );
require_once( 'functions/post-types/pdf-download-post-type.php' );

/**
 * We want to make sure migrations are run on updates.
 *
 * @see https://www.sitepoint.com/wordpress-plugin-updates-right-way/
 */
try {
    require_once( 'functions/class-migration-engine.php' );
    Zume_Migration_Engine::migrate( 0 );
} catch ( Throwable $e ) {
    new WP_Error( 'migration_error', 'Migration engine failed to migrate.' );
}

/**
 * INCLUDED FILES
 */

// Language Files
require_once( 'translations/translation.php' ); // Adds support for multiple languages
require_once( 'functions/zume-polylang-integration.php' ); // Adds support for multiple languages

// Zume Theme Files
require_once( 'functions/login/zume-login.php' ); // Customize the login page
require_once( 'functions/enqueue-scripts.php' ); // Register scripts and stylesheets
require_once( 'functions/utilities/tgm-config.php' ); // monitors required plugin dependencies
require_once( 'functions/utilities/theme-support.php' ); // Theme support options
require_once( 'functions/utilities/cleanup.php' ); // WP Head and other cleanup functions
require_once( 'functions/utilities/menu.php' ); // Register custom menus and menu walkers
require_once( 'functions/multi-role/multi-role.php' ); // Adds multi role features

require_once( 'functions/restrict-rest-api.php' ); // Restricts the default REST API to logged in users
remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );
require_once( 'functions/restrict-xml-rpc-pingback.php' ); // Restricts RPC vulnerability

// Zume Core Files
require_once( 'functions/zume-course.php' ); // zume course
$zume_course = Zume_Course::instance();
require_once( 'functions/zume-functions.php' ); // general zume functions
require_once( 'functions/zume-dashboard.php' ); // zume dashboard
require_once( 'functions/zume-welcome-messages.php' ); // zume welcome messages
require_once( 'functions/logging/zume-logging.php' ); // zume logging of critical path actions
require_once( 'functions/zume-stats.php' ); // zume logging of critical path actions
require_once( 'functions/zume-three-month-plan.php' );

require_once( 'functions/logging/zume-mailchimp.php' ); // zume logging of critical path actions
require_once( 'functions/zume-dt-integration/zume-dashboard-sync.php' ); // zume dashboard sync

// REST API
require_once( 'functions/zume-rest-api.php' );

// Locations System
require_once( 'functions/geocoding-api.php' );

// Zume - DT - Integration
require_once( 'functions/zume-dt-integration/site-link-post-type.php' );
Site_Link_System::instance();
require_once( 'functions/zume-dt-integration/wp-async-request.php' );
require_once( 'functions/tab-keys.php' );
require_once( 'functions/zume-dt-integration/menu-and-tabs.php' );
require_once( 'functions/zume-dt-integration/zume.php' );
require_once( 'functions/zume-dt-integration/zume-hooks.php' );
require_once( 'functions/zume-dt-integration/zume-async-send.php' );
require_once( 'functions/zume-dt-integration/zume-endpoints.php' );
require_once( 'functions/zume-dt-integration/zume-site-stats.php' );
require_once( 'functions/zume-dt-integration/system-check-metabox.php' );

if ( is_admin() ) {
    require_once( 'functions/zume-resource-metabox.php' ); // zume logging of critical path actions
}


/**
 * redirect all logins to the home page
 */
add_filter( 'login_redirect', function( $url, $query, $user ) {
    return zume_dashboard_url();
}, 10, 3 );

/**
 * A simple function to assist with development and non-disruptive debugging.
 * -----------
 * -----------
 * REQUIREMENT:
 * WP Debug logging must be set to true in the wp-config.php file.
 * Add these definitions above the "That's all, stop editing! Happy blogging." line in wp-config.php
 * -----------
 * define( 'WP_DEBUG', true ); // Enable WP_DEBUG mode
 * define( 'WP_DEBUG_LOG', true ); // Enable Debug logging to the /wp-content/debug.log file
 * define( 'WP_DEBUG_DISPLAY', false ); // Disable display of errors and warnings
 * @ini_set( 'display_errors', 0 );
 * -----------
 * -----------
 * EXAMPLE USAGE:
 * (string)
 * write_log('THIS IS THE START OF MY CUSTOM DEBUG');
 * -----------
 * (array)
 * $an_array_of_things = ['an', 'array', 'of', 'things'];
 * write_log($an_array_of_things);
 * -----------
 * (object)
 * $an_object = new An_Object
 * write_log($an_object);
 */
if ( ! function_exists( 'dt_write_log' ) ) {
    /**
     * A function to assist development only.
     * This function allows you to post a string, array, or object to the WP_DEBUG log.
     *
     * @param $log
     */
    // @codingStandardsIgnoreLine
    function dt_write_log( $log )
    {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}
