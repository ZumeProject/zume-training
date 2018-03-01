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
 * INCLUDED FILES
 */

// Language Files
require_once( 'translation/translation.php' ); // Adds support for multiple languages
require_once( 'functions/zume-polylang-integration.php' ); // Adds support for multiple languages

// Zume Theme Files
require_once( 'functions/enqueue-scripts.php' ); // Register scripts and stylesheets
require_once( 'functions/utilities/tgm-config.php' ); // monitors required plugin dependencies
require_once( 'functions/enqueue-scripts.php' ); // Register scripts and stylesheets
require_once( 'functions/utilities/theme-support.php' ); // Theme support options
require_once( 'functions/utilities/cleanup.php' ); // WP Head and other cleanup functions
require_once( 'functions/utilities/menu.php' ); // Register custom menus and menu walkers
require_once( 'functions/login/login.php' ); // Customize the WordPress login menu
require_once( 'functions/login/user-register.php' ); // Customize the WordPress login menu
require_once( 'functions/multi-role/multi-role.php' ); // Adds multi role features
require_once( 'functions/restrict-rest-api.php' ); // Restricts the default REST API to logged in users
remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );
require_once( 'functions/restrict-xml-rpc-pingback.php' ); // Restricts RPC vulnerability

// Zume Core Files

require_once( 'functions/zume-course.php' ); // zume course
$zume_course = Zume_Course::instance();
require_once( 'functions/zume-functions.php' ); // general zume functions
require_once( 'functions/zume-dashboard.php' ); // zume dashboard
require_once( 'functions/zume-coach.php' ); // zume dashboard
require_once( 'functions/logging/zume-logging.php' ); // zume logging of critical path actions
require_once( 'functions/zume-stats.php' ); // zume logging of critical path actions

// REST API
require_once( 'functions/zume-rest-api.php' );

// Locations System
require_once( 'functions/geocoding-api.php' );

// Email System
include_once( 'functions/utilities/zume-mailchimp-settings.php' ); // Creates the options page for mailchimp automation
include_once( 'functions/login/user-register.php' );

