<?php

class Zume_Report_Log {

    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    public function __construct() {
        add_action( 'zume_session_complete', [ $this, 'add_report' ], 10, 4 );
    }
    public function add_report( $group_key, $session_number, $group_owner, $current_user_id ) {
        $group = Zume_v4_Groups::get_group_by_key( $group_key );
        $users = [];
        $users[] = $current_user_id;
        if ( isset( $group['coleaders'] ) && ! empty( $group['coleaders'] ) ) {
            foreach( $group['coleaders'] as $coleader_email ) {
                $u = get_user_by( 'email', $coleader_email );
                if ( $u ) {
                    $users[] = $u->ID;
                }
            }
        }
        $session_key = 'session_'.$session_number.'_complete';
        foreach( $users as $user_id ) {
            $report = $this->get_array( $group, $session_number, $session_key, $user_id );
            $report['hash'] = hash( 'sha256', maybe_serialize( $report ) );
            $report['timestamp'] = time();
            $duplicate_found = $this->check_dup($report['hash']);
            if ( ! $duplicate_found ) {
                $this->insert( $report );
            }
        }
    }
    public function get_array( $session, $number, $session_label, $user_id ) {
        return [
            'user_id' => $user_id,
            'parent_id' => null,
            'post_id' => null,
            'post_type' => null,
            'type' => 'zume_session',
            'subtype' => $number,
            'payload' => null,
            'value' => 0,
            'lng' => $session['location_grid_meta']['lng'] ?? null,
            'lat' => $session['location_grid_meta']['lat'] ?? null,
            'level' => $session['location_grid_meta']['level'] ?? null,
            'label' => $session['location_grid_meta']['label'] ?? null,
            'grid_id' => $session['location_grid_meta']['grid_id'] ?? null,
            'time_begin' => null,
            'time_end' => time()
        ];
    }
    public function check_dup( $hash ) {
        global $wpdb;
        return $wpdb->get_row(
            $wpdb->prepare(
                "SELECT
                    `id`
                FROM
                    wp_dt_reports
                WHERE hash = %s AND hash IS NOT NULL;",
                $hash
            )
        );
    }
    public function insert( $report ) {
        global $wpdb;
        return $wpdb->insert( 'wp_dt_reports', $report,
            [
                '%d', // user_id
                '%d', // parent_id
                '%d', // post_id
                '%s', // post_type
                '%s', // type
                '%s', // subtype
                '%s', // payload
                '%d', // value
                '%f', // lng
                '%f', // lat
                '%s', // level
                '%s', // label
                '%d', // grid_id
                '%d', // time_begin
                '%d', // time_end
                '%s', // timestamp
                '%s', // hash
            ] );
    }
}
Zume_Report_Log::instance();
