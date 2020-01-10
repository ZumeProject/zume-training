<?php
/**
 *
 */

class Zume_V4_Progress {
    public static $progress_key = 'zume_progress';

    public static function verify_progress_array( $args ) {
        $defaults = array(
            '1h' => '',
            '1o' => '',
            '1s' => '',
            '1t' => '',
            '2h' => '',
            '2o' => '',
            '2s' => '',
            '2t' => '',
            '3h' => '',
            '3o' => '',
            '3s' => '',
            '3t' => '',
            '4h' => '',
            '4o' => '',
            '4s' => '',
            '4t' => '',
            '5h' => '',
            '5o' => '',
            '5s' => '',
            '5t' => '',
            '6h' => '',
            '6o' => '',
            '6s' => '',
            '6t' => '',
            '7h' => '',
            '7o' => '',
            '7s' => '',
            '7t' => '',
            '8h' => '',
            '8o' => '',
            '8s' => '',
            '8t' => '',
            '9h' => '',
            '9o' => '',
            '9s' => '',
            '9t' => '',
            '10h' => '',
            '10o' => '',
            '10s' => '',
            '10t' => '',
            '11h' => '',
            '11o' => '',
            '11s' => '',
            '11t' => '',
            '12h' => '',
            '12o' => '',
            '12s' => '',
            '12t' => '',
            '13h' => '',
            '13o' => '',
            '13s' => '',
            '13t' => '',
            '14h' => '',
            '14o' => '',
            '14s' => '',
            '14t' => '',
            '15h' => '',
            '15o' => '',
            '15s' => '',
            '15t' => '',
            '16h' => '',
            '16o' => '',
            '16s' => '',
            '16t' => '',
            '17h' => '',
            '17o' => '',
            '17s' => '',
            '17t' => '',
            '18h' => '',
            '18o' => '',
            '18s' => '',
            '18t' => '',
            '19h' => '',
            '19o' => '',
            '19s' => '',
            '19t' => '',
            '20h' => '',
            '20o' => '',
            '20s' => '',
            '20t' => '',
            '21h' => '',
            '21o' => '',
            '21s' => '',
            '21t' => '',
            '22h' => '',
            '22o' => '',
            '22s' => '',
            '22t' => '',
            '23h' => '',
            '23o' => '',
            '23s' => '',
            '23t' => '',
            '24h' => '',
            '24o' => '',
            '24s' => '',
            '24t' => '',
            '25h' => '',
            '25o' => '',
            '25s' => '',
            '25t' => '',
            '26h' => '',
            '26o' => '',
            '26s' => '',
            '26t' => '',
            '27h' => '',
            '27o' => '',
            '27s' => '',
            '27t' => '',
            '28h' => '',
            '28o' => '',
            '28s' => '',
            '28t' => '',
            '29h' => '',
            '29o' => '',
            '29s' => '',
            '29t' => '',
            '30h' => '',
            '30o' => '',
            '30s' => '',
            '30t' => '',
            '31h' => '',
            '31o' => '',
            '31s' => '',
            '31t' => '',
            '32h' => '',
            '32o' => '',
            '32s' => '',
            '32t' => '',
        );

        return wp_parse_args( $args, $defaults );
    }

    /**
     * CREATE && READ
     *
     * @param int|null $user_id
     * @return array
     */
    public static function get_user_progress( int $user_id = null ) : array {
        if ( empty( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        $progress = get_user_meta( $user_id, self::$progress_key, true );

        if ( empty( $progress ) || ! is_array( $progress ) ) {
            update_user_meta( $user_id, self::$progress_key, self::verify_progress_array( array() ) );
            $progress = get_user_meta( $user_id, self::$progress_key, true );
        }

        return self::verify_progress_array( $progress );
    }

    /**
     * UPDATE && DELETE
     *
     * @param $key
     * @param $state
     * @param null $user_id
     *
     * @return int|bool
     */
    public static function update_user_progress( $key, $state, $user_id = null ) {
        if ( empty( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        $user_progress = self::get_user_progress( $user_id );
        if ( ! isset( $user_progress[$key] ) ) {
            return false;
        }

        if ( empty( $state ) || 'off' === $state ) {
            $user_progress[$key] = '';
            return update_user_meta( $user_id, self::$progress_key, $user_progress );
        } else {
            if ( ! empty( $user_progress[$key] ) ) { // don't update to a new timestamp, if timestamp exists
                return false;
            }
            $user_progress[$key] = time();
            return update_user_meta( $user_id, self::$progress_key, $user_progress );
        }
    }
}
