<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly
/**
 * Require plugins with the TGM library.
 *
 * This defines the required and suggested plugins.
 */


/**
 * Include the TGM_Plugin_Activation class. This class makes other plugins required for the Disciple_Tools system.
 * @see https://github.com/TGMPA/TGM-Plugin-Activation
 */
require_once( 'tgm-plugin-activation-class.php' );

/**
 * Register the required plugins for this theme.
 *
// Example of array options:
//
//        array(
//        'name'               => 'REST API Console', // The plugin name.
//        'slug'               => 'rest-api-console', // The plugin slug (typically the folder name).
//        'source'             => dirname( __FILE__ ) . '/lib/plugins/rest-api-console.zip', // The plugin source.
//        'required'           => true, // If false, the plugin is only 'recommended' instead of required.
//        'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
//        'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
//        'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
//        'external_url'       => '', // If set, overrides default API URL and points to an external URL.
//        'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
//        ),
//
 */
function zume_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'              => 'Psalm 119',
            'slug'              => 'psalm-119',
            'required'          => true,
            'version'            => '1.1',
            'force_activation'  => true,
            'force_deactivation' => false,
            'is_callable'       => 'Psalm_119',
        ),
        array(
            'name' => 'Host Header Injection Fix',
            'slug' => 'host-header-injection-fix',
            'version' => '1.1',
            'required' => true,
        ),
        array(
            'name' => 'iThemes Security',
            'slug' => 'better-wp-security',
            'version' => '6.7.0',
            'required' => true,
        ),
        array(
            'name' => 'Classic Editor',
            'slug' => 'classic-editor',
            'version' => '1.5',
            'required' => true,
        ),
        array(
            'name' => 'Disciple Tools - Network Dashboard Remote',
            'slug' => 'disciple-tools-network-dashboard-remote',
            'version' => '1.0',
            'required' => true,
        ),
//        array(
//            'name' => 'Infinite WP',
//            'slug' => 'iwp-client',
//            'version' => '1.6.6.3',
//            'required' => false,
//        ),
//        array(
//            'name' => 'Analytics Cat',
//            'slug' => 'analytics-cat',
//            'version' => '1.0.2',
//            'required' => false,
//        ),
//        array(
//            'name' => 'Database Browser',
//            'slug' => 'database-browser',
//            'version' => '1.4',
//            'required' => false,
//        ),
        array(
            'name' => 'PolyLang',
            'slug' => 'polylang',
            'version' => '2.2.7',
            'required' => true,
            'force_activation'  => true,
        ),
        array(
            'name' => 'Nav Menu Roles',
            'slug' => 'nav-menu-roles',
            'version' => '1.9.1',
            'required' => true,
            'force_activation'  => true,
        ),
//        array(
//            'name' => 'Peter\'s Login Redirect',
//            'slug' => 'peters-login-redirect',
//            'version' => '2.9.1',
//            'required' => false,
//            'force_activation'  => false,
//        )
    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'zume',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '/includes/',     // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'plugins.php',            // Parent menu slug.
        'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => 'For the Zume system to work correction, these additional plugins must be installed.',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.

        /*
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'disciple_tools' ),
            'menu_title'                      => __( 'Install Plugins', 'disciple_tools' ),
            /* translators: %s: plugin name. * /
            'installing'                      => __( 'Installing Plugin: %s', 'disciple_tools' ),
            /* translators: %s: plugin name. * /
            'updating'                        => __( 'Updating Plugin: %s', 'disciple_tools' ),
            'oops'                            => __( 'Something went wrong with the plugin API.', 'disciple_tools' ),
            'notice_can_install_required'     => _n_noop(
                /* translators: 1: plugin name(s). * /
                'This theme requires the following plugin: %1$s.',
                'This theme requires the following plugins: %1$s.',
                'disciple_tools'
            ),
            'notice_can_install_recommended'  => _n_noop(
                /* translators: 1: plugin name(s). * /
                'This theme recommends the following plugin: %1$s.',
                'This theme recommends the following plugins: %1$s.',
                'disciple_tools'
            ),
            'notice_ask_to_update'            => _n_noop(
                /* translators: 1: plugin name(s). * /
                'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
                'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
                'disciple_tools'
            ),
            'notice_ask_to_update_maybe'      => _n_noop(
                /* translators: 1: plugin name(s). * /
                'There is an update available for: %1$s.',
                'There are updates available for the following plugins: %1$s.',
                'disciple_tools'
            ),
            'notice_can_activate_required'    => _n_noop(
                /* translators: 1: plugin name(s). * /
                'The following required plugin is currently inactive: %1$s.',
                'The following required plugins are currently inactive: %1$s.',
                'disciple_tools'
            ),
            'notice_can_activate_recommended' => _n_noop(
                /* translators: 1: plugin name(s). * /
                'The following recommended plugin is currently inactive: %1$s.',
                'The following recommended plugins are currently inactive: %1$s.',
                'disciple_tools'
            ),
            'install_link'                    => _n_noop(
                'Begin installing plugin',
                'Begin installing plugins',
                'disciple_tools'
            ),
            'update_link'                     => _n_noop(
                'Begin updating plugin',
                'Begin updating plugins',
                'disciple_tools'
            ),
            'activate_link'                   => _n_noop(
                'Begin activating plugin',
                'Begin activating plugins',
                'disciple_tools'
            ),
            'return'                          => __( 'Return to Required Plugins Installer', 'disciple_tools' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'disciple_tools' ),
            'activated_successfully'          => __( 'The following plugin was activated successfully:', 'disciple_tools' ),
            /* translators: 1: plugin name. * /
            'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'disciple_tools' ),
            /* translators: 1: plugin name. * /
            'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'disciple_tools' ),
            /* translators: 1: dashboard link. * /
            'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'disciple_tools' ),
            'dismiss'                         => __( 'Dismiss this notice', 'disciple_tools' ),
            'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'disciple_tools' ),
            'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'disciple_tools' ),

            'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
        ),
        */
    );

    tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'zume_register_required_plugins' );
