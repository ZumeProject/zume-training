<?php

define('ZUME_DOMAIN', 'zume_project');
define('ZUME_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
require_once(get_template_directory().'/includes/debugger-log.php'); // debug logger used for development. Use z_write_log();


/**
 * INCLUDED FILES
 */

// Theme Files
require_once(get_template_directory().'/includes/enqueue-scripts.php'); // Register scripts and stylesheets
require_once(get_template_directory().'/includes/config-required-plugins.php');
require_once(get_template_directory().'/includes/theme-support.php'); // Theme support options
require_once(get_template_directory().'/includes/cleanup.php'); // WP Head and other cleanup functions
require_once(get_template_directory().'/includes/menu.php'); // Register custom menus and menu walkers
require_once(get_template_directory().'/includes/sidebar.php'); // Register sidebars/widget areas
require_once(get_template_directory().'/includes/comments.php'); // Makes WordPress comments suck less
require_once(get_template_directory().'/includes/page-navi.php'); // Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/assets/translation/translation.php'); // Adds support for multiple languages
require_once(get_template_directory().'/includes/admin.php'); // Customize the WordPress admin
require_once(get_template_directory().'/includes/login.php'); // Customize the WordPress login menu
require_once(get_template_directory().'/includes/wplogin_redirect.php'); // login redirect

// Zume Core Files
require_once ('includes/steplog-post-type.php');
$steplog = Zume_Steplog::instance();
require_once ('includes/class-zume-course.php'); // zume course
$zume_course = Zume_Course::instance();
require_once ('includes/class-zume-overview.php'); // zume overview page
$zume_overview = Zume_Overview::instance();
require_once ('includes/zume-functions.php'); // general zume functions
require_once ('includes/class-zume-dashboard.php'); // zume dashboard
require_once ('includes/functions-group-address.php'); // loads the group address meta fields

require_once ('includes/rest-api.php');
$zume_rest = Zume_REST_API::instance();

require_once('includes/class-census-geolocation-api.php');
require_once('includes/class-google-geolocation-api.php');
require_once('includes/class-coordinates-db.php');

require_once('includes/locations-rest-controller.php');
require_once('includes/locations-rest-api.php');
$location_api = Location_Lookup_REST_API::instance();


include_once('includes/zume-options.php');
include_once('includes/user-register.php');

require_once ('includes/class-zume-emails.php');
require_once ('includes/group_creation.php');


if(is_admin()) {
//    require_once('includes/coaching/class-coaches.php');
//    $zume_coaches = Zume_Coaches::instance();

    require_once('includes/coaching/class-coach-metabox.php');
}


/**
 * CATCH URL AND LOAD CUSTOM TEMPLATE
 */
add_action('init', function() {
    $template_for_url = array(
        'profile' => 'template-profile.php'

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


/**
 * INITIALIZE INTERNATIONALIZATION
 * References:
 *      http://codex.wordpress.org/I18n_for_WordPress_Developers
 *      http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 * @return void
 */
function ZumeProject_i18n_init() {
    $pluginDir = dirname(plugin_basename(__FILE__));
    load_plugin_textdomain('zume_project', false, $pluginDir . '/languages/');
}
add_action('plugins_loadedi','ZumeProject_i18n_init'); // Initialize i18n


function initialize_custom_emails(){
    require_once ('includes/class-zume-emails.php');
    your_three_month_plan_email();
    group_enough_members_email();
    invite_to_group_email();
    automatically_added_to_group_email();
}
register_activation_hook( __FILE__, 'initialize_custom_emails' );



