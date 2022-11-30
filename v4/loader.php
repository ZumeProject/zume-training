<?php

$dir = scandir( __DIR__ );
foreach ( $dir as $file ){
    if ( 'php' === substr( $file, -3, 3 ) ){
        require_once( $file );
    }
}

// Debugging Functions
require_once( 'utilities/debugger-log.php' ); // debug logger used for development.
require_once( 'utilities/global-functions.php' ); // debug logger used for development.

// Post Types
require_once( 'post-types/video-post-type.php' );
require_once( 'post-types/pdf-download-post-type.php' );
require_once( 'post-types/qr-meta-box.php' );

// Integrations to other systems
require_once( 'integrations/zume-polylang-integration.php' ); // Adds support for multiple languages
require_once( 'integrations/network-dashboard-remote-integration.php' );
require_once( 'integrations/yoast-integration.php' );

// Zume Theme Files
//require_once( 'login/zume-login.php' ); // Customize the login page

require_once( 'utilities/enqueue-scripts.php' ); // Register scripts and stylesheets
require_once( 'utilities/theme-support.php' ); // Theme support options
require_once( 'utilities/cleanup.php' ); // WP Head and other cleanup v4
require_once( 'utilities/menu.php' ); // Register custom menus and menu walkers
require_once( 'multi-role/multi-role.php' ); // Adds multi role features

// Rest
require_once( 'utilities/restrict-rest-api.php' ); // Restricts the default REST API to logged in users
remove_action( 'rest_api_init', 'create_initial_rest_routes', 99 );
require_once( 'utilities/restrict-xml-rpc-pingback.php' ); // Restricts RPC vulnerability

// Zume 3.0 Files to Deprecate after 4.0 upgrade
//require_once( 'zume-course.php' ); // zume course
//$zume_course = Zume_Course::instance();
//require_once( 'zume-dashboard.php' ); // zume dashboard
//require_once( 'zume-rest-api.php' );
// end 3.0


// zume 4.0
//require_once( 'zume-v4-rest-api.php' );
//require_once( 'zume-v4-users.php' );
//require_once( 'zume-v4-groups.php' );
//require_once( 'zume-v4-progress.php' );
//require_once( 'zume-v4-pieces.php' );
//require_once( 'zume-v4-seo-strings.php' );
//require_once( 'zume-content.php' );
//require_once( 'zume-three-month-plan.php' );
//require_once( 'zume-v4-modal-pieces-content.php' );
//require_once( 'zume-functions.php' ); // general zume functions


require_once( 'integrations/zume-mailchimp.php' );

// Zume - DT - Integration
require_once( 'integrations/site-link-post-type.php' );
Site_Link_System::instance();
//require_once( 'zume-v4-global-network-link.php' );


if ( is_admin() ) {

    require_once( 'post-types/pieces-page-metabox.php' );
    require_once( 'post-types/landing-template-metaboxes.php' );

    require_once( 'integrations/tab-keys.php' );
    require_once( 'integrations/menu-and-tabs.php' );
    require_once( 'post-types/zume-resource-metabox.php' );

    require_once( 'utilities/tgm-config.php' );

    add_filter( 'manage_pages_columns', 'add_template_column' );
    add_action( 'manage_pages_custom_column', 'add_template_value', 10, 2 );
}
