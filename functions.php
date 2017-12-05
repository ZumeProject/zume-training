<?php
/**
 * Zume Project functions root
 */

define('ZUME_DOMAIN', 'zume');
define('ZUME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
require_once('functions/utilities/debugger-log.php'); // debug logger used for development. Use z_write_log();


/**
 * INCLUDED FILES
 */

// Language Files
require_once( 'assets/translation/translation.php' ); // Adds support for multiple languages
require_once( 'functions/zume-polylang-integration.php'); // Adds support for multiple languages

// Zume Theme Files
require_once( 'functions/enqueue-scripts.php'); // Register scripts and stylesheets
require_once( 'functions/utilities/config-required-plugins.php' ); // monitors required plugin dependencies
require_once( 'functions/utilities/theme-support.php' ); // Theme support options
require_once( 'functions/utilities/cleanup.php'); // WP Head and other cleanup functions
require_once( 'functions/utilities/menu.php' ); // Register custom menus and menu walkers
require_once( 'functions/utilities/comments.php' ); // Makes WordPress comments suck less
require_once( 'functions/login/login.php' ); // Customize the WordPress login menu
require_once( 'functions/login/wplogin_redirect.php' ); // login redirect

// Zume Core Files
require_once( 'functions/zume-course.php' ); // zume course
$zume_course = Zume_Course::instance();
require_once( 'functions/zume-overview.php' ); // zume overview page
require_once ('functions/zume-functions.php'); // general zume functions
require_once( 'functions/zume-dashboard.php' ); // zume dashboard

// Locations System
require_once( 'functions/location/group-js-maps.php' ); // loads the group address meta fields
require_once( 'functions/rest-api.php' );
Zume_REST_API::instance();
require_once( 'functions/location/class-census-geolocation-api.php' );
require_once( 'functions/location/class-google-geolocation-api.php' );
require_once( 'functions/location/class-coordinates-db.php' );
require_once( 'functions/location/locations-rest-controller.php' );
require_once( 'functions/location/locations-rest-api.php' );
Location_Lookup_REST_API::instance();

// Email System
/** TODO: Maybe remove. Language specific emails? */
include_once( 'functions/utilities/zume-mailchimp-settings.php' ); // Creates the options page for mailchimp automation
include_once( 'functions/login/user-register.php' );
require_once( 'functions/email/class-zume-emails.php' );

function initialize_custom_emails(){
    require_once( 'functions/email/class-zume-emails.php' );
    your_three_month_plan_email();
    group_enough_members_email();
    invite_to_group_email();
    automatically_added_to_group_email();
}
register_activation_hook( __FILE__, 'initialize_custom_emails' );