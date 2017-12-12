<?php

add_action('after_switch_theme', 'zume_theme_setup');

function zume_theme_setup () {
	Zume_Activator::activate();
}

class Zume_Activator
{
	public static function activate() {
		$version = ZUME_VERSION;
		self::create_tables( $version );
		zume_write_log('Should only see this after theme switch');
	}

	public static function create_tables( $version ) {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		/* Activity Log */
		$table_name = $wpdb->prefix . 'zume_logging';
		if( $wpdb->get_var( "show tables like '{$table_name}'" ) != $table_name ) {
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
}