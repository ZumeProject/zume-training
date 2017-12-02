<?php

define('ZUME_DOMAIN', 'zume_project');
define('ZUME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
require_once('includes/utilities/debugger-log.php'); // debug logger used for development. Use z_write_log();


/**
 * INCLUDED FILES
 */

// Language Files
require_once( 'assets/translation/translation.php'); // Adds support for multiple languages

// Zume Theme Files
require_once( 'includes/enqueue-scripts.php'); // Register scripts and stylesheets
require_once( 'includes/utilities/config-required-plugins.php' ); // monitors required plugin dependencies
require_once( 'includes/utilities/theme-support.php' ); // Theme support options
require_once( 'includes/utilities/cleanup.php'); // WP Head and other cleanup functions
require_once( 'includes/utilities/menu.php' ); // Register custom menus and menu walkers
require_once( 'includes/utilities/comments.php' ); // Makes WordPress comments suck less
require_once( 'includes/login/login.php' ); // Customize the WordPress login menu
require_once( 'includes/login/wplogin_redirect.php' ); // login redirect

// Zume Core Files
require_once( 'includes/zume-course.php' ); // zume course
$zume_course = Zume_Course::instance();
require_once( 'includes/zume-overview.php' ); // zume overview page
$zume_overview = Zume_Overview::instance();
require_once ('includes/zume-functions.php'); // general zume functions
require_once( 'includes/zume-dashboard.php' ); // zume dashboard
require_once( 'includes/location/group-js-maps.php' ); // loads the group address meta fields

require_once( 'includes/rest-api.php' );
$zume_rest = Zume_REST_API::instance();

require_once( 'includes/location/class-census-geolocation-api.php' );
require_once( 'includes/location/class-google-geolocation-api.php' );
require_once( 'includes/location/class-coordinates-db.php' );

require_once( 'includes/location/locations-rest-controller.php' );
require_once( 'includes/location/locations-rest-api.php' );
$location_api = Location_Lookup_REST_API::instance();


include_once( 'includes/utilities/zume-mailchimp-settings.php' ); // Creates the options page for mailchimp automation
include_once( 'includes/login/user-register.php' );

require_once( 'includes/email/class-zume-emails.php' );


/**
 * CATCH URL AND LOAD CUSTOM TEMPLATE
 */
add_action('init', function() {
    $template_for_url = array(
	    'about'     => 'template-zume-about.php',
	    'course'    => 'template-zume-course.php',
	    'dashboard' => 'template-zume-dashboard.php',
	    'overview'  => 'template-zume-overview.php',
	    'profile'   => 'template-zume-profile.php',
	    'resources' => 'template-zume-resources.php',
    );
    $url_path = trim( parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );

    if ( isset( $template_for_url[ $url_path ] ) ) {
        $template_filename = locate_template( $template_for_url[ $url_path ], true );
        if ( $template_filename ) {
            exit(); // just exit if template was found and loaded
        } else {
            throw new Error( "Expected to find template " . $template_for_url[ $url_path ] );
        }
    }

});

function initialize_custom_emails(){
    require_once( 'includes/email/class-zume-emails.php' );
    your_three_month_plan_email();
    group_enough_members_email();
    invite_to_group_email();
    automatically_added_to_group_email();
}
register_activation_hook( __FILE__, 'initialize_custom_emails' );



