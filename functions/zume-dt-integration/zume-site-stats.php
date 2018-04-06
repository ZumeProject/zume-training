<?php

class Zume_Site_Stats
{
    private static function query_zume_group_records() {
        global $wpdb;
        $groups_meta = $wpdb->get_col(
            $wpdb->prepare( "
                  SELECT meta_value 
                  FROM $wpdb->usermeta 
                  WHERE meta_key LIKE %s LIMIT 10000", // @todo Returning all results, but at some point we should limit this
                $wpdb->esc_like('zume_group').'%'
            ) );
        return $groups_meta;
    }

    public static function get_group_coordinates() {
        $groups_meta = self::query_zume_group_records();

        $result = [];

        foreach ( $groups_meta as $group_meta ){
            $fields = Zume_Dashboard::verify_group_array_filter( $group_meta );
            if ( !empty( $fields["lat"] ) && !empty( $fields["lng"] ) ) {
                $result[] = [ $fields["lat"], $fields["lng"] ];
            } elseif ( !empty( $fields["ip_lat"] ) && !empty( $fields["ip_lng"] ) ) {
                $result[] = [ $fields["ip_lat"], $fields["ip_lng"] ];
            }
        }

        return $result;
    }

    public static function get_group_sizes(){
        $groups_meta = self::query_zume_group_records();

        $counts = [];
        $group_sizes = [];

        foreach ($groups_meta as $group_meta){
            $fields = Zume_Dashboard::verify_group_array_filter( $group_meta );
            if ( isset( $fields["members"] ) && intval( $fields["members"] )){
                if ( !isset( $counts[ $fields["members"] ] ) ){
                    $counts[ $fields["members"] ] = 1;
                } else {
                    $counts[ $fields["members"] ]++;
                }
            }
        }

        ksort( $counts );

        $result = [ [ "Group Size", "Number of groups", [ "role" => "annotation" ] ] ];
        foreach ($counts as $group_size => $occurrence){
            $string = $group_size . " members";
            $result[] = [ $string, $occurrence, $occurrence ];
        }

        dt_write_log( $result);

        return $result;
    }

    public static function get_group_steps_completed(){

        $groups_meta = self::query_zume_group_records();

        $count = [
            "session_1" => 0,
            "session_2" => 0,
            "session_3" => 0,
            "session_4" => 0,
            "session_5" => 0,
            "session_6" => 0,
            "session_7" => 0,
            "session_8" => 0,
            "session_9" => 0,
            "session_10" => 0,
        ];

        foreach ($groups_meta as $group_meta){
            $fields = Zume_Dashboard::verify_group_array_filter( $group_meta );
            foreach ($count as $key => $value ){
                if ( $fields[$key] == true ){
                    $count[$key]++;
                }
            }
        }

        return $count;
    }

    public static function get_groups_next_session(){

        $groups_meta = self::query_zume_group_records();

        $count = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            ];

        foreach ($groups_meta as $group_meta){
            $fields = Zume_Dashboard::verify_group_array_filter( $group_meta );
            $count[ (int) $fields['next_session'] ] = $count[ (int) $fields['next_session'] ]++;
        }

        return $count;
    }
}