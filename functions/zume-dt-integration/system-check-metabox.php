<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// @codingStandardsIgnoreLine
class System_Check_Metabox
{
    public static function check_user_ip_geocode( $force = false ) {
        global $wpdb;
        $report = [];
        // build user ip address locations
        // @codingStandardsIgnoreStart
        $results = $wpdb->get_results("
                        SELECT a.ID, b.meta_value as ip_address, c.meta_value as raw
                        FROM $wpdb->users as a
                          JOIN $wpdb->usermeta as b
                            ON a.ID=b.user_id
                               AND b.meta_key = 'zume_recent_ip'
                          LEFT JOIN $wpdb->usermeta as c
                            ON a.ID=c.user_id
                               AND c.meta_key = 'zume_raw_location_from_ip'
                    ", ARRAY_A);
        // @codingStandardsIgnoreEnd
        foreach ( $results as $result ) {
            $empty_field = empty( $value['zume_raw_location_from_ip'] );
            if ( $force ) { // force rebuild
                $empty_field = true;
            }
            if ( $empty_field && ! empty( $result['ip_address'] ) ) {
                $raw = DT_Ipstack_API::geocode_ip_address( $result['ip_address'] );
                if ( ! $raw ) {
                    $report[] = $result['ID'] . ' FAIL';
                    continue;
                }

                update_user_meta( $result['ID'], 'zume_raw_location_from_ip', $raw['raw'] );
                update_user_meta( $result['ID'], 'zume_lng_from_ip', $raw['lng'] );
                update_user_meta( $result['ID'], 'zume_lat_from_ip', $raw['lat'] );
                update_user_meta( $result['ID'], 'zume_address_from_ip', $raw['formatted_address'] );
                $report[] = $result['ID'];
            }
        }

        return $report;
    }

    public static function check_group_address_geocode( $force = false ) {
        global $wpdb;
        $report = [];

        $groups_meta = $wpdb->get_col(
            $wpdb->prepare( "
                  SELECT meta_value 
                  FROM $wpdb->usermeta 
                  WHERE meta_key LIKE %s",
                $wpdb->esc_like( 'zume_group' ).'%'
            )
        );

        foreach ($groups_meta as $v){
            $fields = Zume_Dashboard::verify_group_array_filter( $v );
            $updated = false;

            $empty_field = empty( $fields['raw_location'] );
            if ( $force ) { // force rebuild
                $empty_field = true;
            }
            if ( $empty_field && ! empty( $fields['address'] ) ) {
                $google_result = DT_Mapbox_API::forward_lookup( $fields['address'], $type = 'core' ); // get google api info
                if ( $google_result ) {

                    $fields['lng'] = $google_result['lng'];
                    $fields['lat'] = $google_result['lat'];
                    $fields['address'] = $google_result['formatted_address'];
                    $fields['raw_location'] = $google_result['raw'];
                }
                $updated = true;
                $report[] = 'Updated Group ' . $fields['key'] . ": Location";
                dt_write_log( 'Updated Group ' . $fields['key'] . ": Location" );
            }

            if ( $updated ) {

                $fields['last_modified_date'] = current_time( 'mysql' );

                update_user_meta( $fields['owner'], $fields['key'], $fields );
            }
        }

        return $report;

    }

    public static function check_group_ip_geocode( $force = false ) {
        global $wpdb;
        $report = [];

        $groups_meta = $wpdb->get_col(
            $wpdb->prepare( "
                  SELECT meta_value 
                  FROM $wpdb->usermeta 
                  WHERE meta_key LIKE %s",
                $wpdb->esc_like( 'zume_group' ).'%'
            )
        );

        foreach ($groups_meta as $v){
            $fields = Zume_Dashboard::verify_group_array_filter( $v );
            $updated = false;

            $empty_field = empty( $fields['ip_raw_location'] );
            if ( $force ) { // force rebuild
                $empty_field = true;
            }
            if ( $empty_field && ! empty( $fields['ip_address'] ) ) {
                $results = DT_Ipstack_API::geocode_ip_address( $fields['ip_address'] );
                if ( $results ) {
                    $fields['ip_lng'] = $results['lng'];
                    $fields['ip_lat'] = $results['lat'];
                    $fields['ip_raw_location'] = $results['raw'];
                }
                $updated = true;
                $report[] = 'Updated Group ' . $fields['key'] . ": IP Location";
                dt_write_log( 'Updated Group ' . $fields['key'] . ": IP Location" );
            }

            if ( $updated ) {

                $fields['last_modified_date'] = current_time( 'mysql' );

                update_user_meta( $fields['owner'], $fields['key'], $fields );
            }
        }

        return $report;
    }


    public static function check_user_address_geocode( $force = false ) {
        global $wpdb;
        $report = [];

        // build locations for users
        $users_with_addresses = $wpdb->get_results(
            "SELECT * FROM $wpdb->usermeta WHERE meta_key = 'zume_user_address'", ARRAY_A
        );

        foreach ( $users_with_addresses as $value ) {
            $empty_field = empty( $value['meta_value'] );
            if ( $force ) { // force rebuild
                $empty_field = true;
            }
            if ( $empty_field ) {

                dt_write_log( 'Empty value' );
                dt_write_log( $value );
                continue;
            }
            $results = DT_Mapbox_API::forward_lookup( trim( sanitize_text_field( wp_unslash( $value['meta_value'] ) ) ), 'core' );

            if ( $results ) {
                update_user_meta( $value['user_id'], 'zume_user_lng', $results['lng'] );
                update_user_meta( $value['user_id'], 'zume_user_lat', $results['lat'] );
                update_user_meta( $value['user_id'], 'zume_raw_location', $results['raw'] );
            }
            $report[] = 'Updated User ' . $value['user_id'];
            dt_write_log( 'Updated User ' . $value['user_id'] );
        }

        return $report;

    }

}
