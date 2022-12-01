<?php
/**
 * This file contains removed functions as a staging area. This file is not loaded with the system. It is simply a
 * place to move functions until they are confirmed to have no dependencies in plugins or the theme.
 */
class Deprecated {
    public static function get_group_by_foreign_key( $zume_foreign_key ) {
        global $wpdb;
        $group = $wpdb->get_results( $wpdb->prepare( "
            SELECT user_id, meta_key as group_key FROM $wpdb->usermeta WHERE meta_key LIKE %s AND meta_value LIKE %s LIMIT 1
        ",
            $wpdb->esc_like( 'zume_group' ) . '%',
            '%' . $wpdb->esc_like( $zume_foreign_key ) . '%'
        ), ARRAY_A );

        if ( ! $group ) {
            return array();
        }

        return $group[0];
    }
}
