<?php

add_action( 'after_switch_theme', 'zume_theme_setup' );

function zume_theme_setup() {
    Zume_Activator::activate();
}

class Zume_Activator
{
    public static function activate() {
        $version = 1.0;
        self::create_tables( $version );

        self::add_coach_role();

        /**
         * Remove ability to reach dashboard and add zume cap to interact with REST API
         */
        $role = get_role( 'subscriber' );
        $role->add_cap( 'zume' );
        $role->remove_cap( 'read' );


    }

    public static function create_tables( $version ) {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        /* Activity Log */
        $table_name = $wpdb->prefix . 'zume_logging';
        // @codingStandardsIgnoreLine
        if ( $wpdb->get_var( "show tables like '{$table_name}'" ) != $table_name ) {
            $sql1 = "CREATE TABLE IF NOT EXISTS `{$table_name}` (
					  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
					  `created_date` DATETIME NOT NULL,
					  `user_id` BIGINT(20) NOT NULL,
					  `group_id` varchar(100) NULL,
					  `page` varchar(50) NOT NULL,
					  `action` varchar(50) NOT NULL,
					  `meta` varchar(255) NULL,
					  PRIMARY KEY (`id`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8;";
            dbDelta( $sql1 );
            update_option( 'zume_logging_db_version', $version );

        }
    }

    public static function add_coach_role() {
        if ( get_role( 'coach' ) ) {
            remove_role( 'coach' );
        }
        add_role(
            'coach', __( 'Coach' ),
            [
                'coach' => true,
                'zume' => true,
            ]
        );
        if ( get_role( 'coach_leader' ) ) {
            remove_role( 'coach_leader' );
        }
        add_role(
            'coach_leader', __( 'Coach Leader' ),
            [
                'coach_leader' => true,
                'zume' => true,
            ]
        );
        $role = get_role( 'administrator' );
        // If the administrator role exists, add required capabilities for the plugin.
        if ( !empty( $role ) ) {
            /* Manage DT configuration */
            $role->add_cap( 'coach' );
            $role->add_cap( 'coach_leader' );
            $role->add_cap( 'zume' );
        }


    }
}
