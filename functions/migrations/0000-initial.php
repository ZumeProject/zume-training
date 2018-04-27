<?php
declare(strict_types=1);

require_once( 'abstract.php' );

class Zume_Migration_0000 extends Zume_Migration {
    public function up() {
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        /* Activity Log */
        $table_name = $wpdb->zume_logging;
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
        } else {
            zume_write_log(__METHOD__ );
            zume_write_log('checked for table' );
        }
    }

    public function down() {
        dt_write_log(__METHOD__);
    }

    public function test() {
        try {
            $this->test_expected_tables();
        } catch ( Exception $e ) {
            zume_write_log( __METHOD__ );
            zume_write_log( $e );
        }
    }

    public function get_expected_tables(): array {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table_name = $wpdb->zume_logging;

        return array(
            "$table_name" =>
                "CREATE TABLE IF NOT EXISTS `{$table_name}` (
					  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
					  `created_date` DATETIME NOT NULL,
					  `user_id` BIGINT(20) NOT NULL,
					  `group_id` varchar(100) NULL,
					  `page` varchar(50) NOT NULL,
					  `action` varchar(50) NOT NULL,
					  `meta` varchar(255) NULL,
					  PRIMARY KEY (`id`)
				) $charset_collate;",
        );
    }
}
