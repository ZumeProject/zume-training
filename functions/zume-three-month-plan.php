<?php

/**
 * Zume_Three_Month_Plan
 *
 * @class Zume_Three_Month_Plan
 * @version 0.1
 * @since 0.1
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}


/**
 * Class Zume_Three_Month_Plan
 */
class Zume_Three_Month_Plan
{

    /**
     * Filter all db gets of the three-month plan so that the array conforms and is upgraded.
     *
     * @param $plan_meta
     * @return array|mixed
     */
    public static function plan_items_filter( $plan_meta = null ) {
        if ( is_null( $plan_meta ) ) {
            $plan_meta = array();
        }
        elseif ( is_serialized( $plan_meta ) ) {
            $plan_meta = maybe_unserialize( $plan_meta );
        }
        elseif ( ! is_array( $plan_meta ) ) {
            $plan_meta = array();
        }

        $active_keys = array(
            'group_key' => '',
            'people_to_share_with' => '',
            'people_for_accountablity' => '',
            'people_to_challenge' => '',
            'people_to_3_3_invite' => '',
            'people_to_3_3_challenge' => '',
            'people_to_discover_invite' => '',
            'people_to_prayer_walk_with' => '',
            'people_to_equip_list_100' => '',
            'people_to_challenge_prayer' => '',
            'my_prayer_commitment' => '',
            'my_prayer_walk_commitment' => '',
            'people_for_leadership_cell' => '',
            'people_for_zume' => '',
            'other_commitments' => '',
        );
        $deprecated_keys = array(
            'linked',
            'public_key',
        );

        // Active keys
        foreach ( $active_keys as $key => $value ) {
            if ( ! isset( $plan_meta[$key] ) ) {
                $plan_meta[$key] = $value;
            }
        }

        // Deprecated keys
        foreach ( $deprecated_keys as $deprecated_key ) {
            if ( isset( $plan_meta[ $deprecated_key ] ) ) {
                unset( $plan_meta[$deprecated_key] );
            }
        }

        return $plan_meta;

    }

    public static function plan_labels( $key = null ) {
        $active_plan_items = array(
            'people_to_share_with' => __( 'I will share My Story [Testimony] and God’s Story [the Gospel] with the following individuals:', 'zume' ),
            'people_for_accountablity' => __( 'I will invite the following people to begin an Accountability Group with me:', 'zume' ),
            'people_to_challenge' => __( 'I will challenge the following people to begin their own Accountability Groups and train them how to do it:', 'zume' ),
            'people_to_3_3_invite' => __( 'I will invite the following people to begin a 3/3 Group with me:', 'zume' ),
            'people_to_3_3_challenge' => __( 'I will challenge the following people to begin their own 3/3 Groups and train them how to do it:', 'zume' ),
            'people_to_discover_invite' => __( 'I will invite the following people to participate in a 3/3 Hope or Discover Group [see Appendix of Zúme Guidebook]', 'zume' ),
            'people_to_prayer_walk_with' => __( 'I will invite the following people to participate in Prayer Walking with me:', 'zume' ),
            'my_prayer_walk_commitment' => __( 'I will Prayer Walk once every [days / weeks / months].', 'zume' ),
            'people_to_equip_list_100' => __( 'I will equip the following people to share their story and God’s Story and make a List of 100 of the people in their relational network:', 'zume' ),
            'people_to_challenge_prayer' => __( 'I will challenge the following people to use the Prayer Cycle tool on a periodic basis:', 'zume' ),
            'my_prayer_commitment' => __( 'I will use the Prayer Cycle tool once every [days / weeks / months].', 'zume' ),
            'people_for_leadership_cell' => __( 'I will invite the following people to be part of a Leadership Cell that I will lead:', 'zume' ),
            'people_for_zume' => __( 'I will encourage the following people to go through this Zúme Training course:', 'zume' ),
            'other_commitments' => __( 'Other commitments:', 'zume' ),
        );

        if ( is_null( $key ) ) {
            return $active_plan_items;
        } else {
            return $active_plan_items[ $key ];
        }

    }

    public static function edit_post( $submitted_plan ) {

        $plan = array();
        $current_plan = self::plan_items_filter( get_user_meta( get_current_user_id(), 'three_month_plan', true ) );

        $default_keys = array_keys( self::plan_labels() ); // get expected keys

        // filter
        foreach ( $default_keys as $key ) {
            if ( isset( $submitted_plan[ $key ] ) ) {
                $plan[ $key ] = sanitize_text_field( wp_unslash( $submitted_plan[ $key ] ) );
            }
        }

        // test for group key
        $public_key_error = false;
        if ( isset( $plan['public_key'] ) && ! empty( $plan['public_key'] ) ) {

            $group_key = Zume_Dashboard::verify_public_key_for_group( $plan['public_key'] );
            if ( $group_key ) {
                // setup public key success
                $plan['linked'] = self::add_user_to_group_three_month_list( $group_key, get_current_user_id() );
                if ( $plan['linked'] ) {
                    $plan['group_key'] = $group_key;
                }
            } else {
                $public_key_error = true; // set up public key fail
            }
        }


        $plan = wp_parse_args( $plan, $current_plan );

        $result = update_user_meta( get_current_user_id(), 'three_month_plan', $plan );
        if ( ! $result ) {
            return array(
            'status' => 'Fail',
            'message' => __( 'Unable to save three month plan.', 'zume' )
            );
        }

        if ( $public_key_error ) {
            return array(
            'status' => 'Public_Key_Error',
            'message' => __( 'Unable to find key:', 'zume' ) . ' ' . $plan['public_key']
            );
        }

        do_action( 'zume_update_three_month_plan', get_current_user_id(), $plan );

        return array( 'status' => 'OK' );
    }

    public static function add_user_to_group_three_month_list( $group_key, $user_id ) {

        $group_meta = Zume_Dashboard::get_group_by_key( $group_key );
        if ( array_search( $user_id, $group_meta['three_month_plans'] ) ) {
            return true;
        }

        array_push( $group_meta['three_month_plans'], $user_id );

        return update_user_meta( $group_meta['owner'], $group_key, $group_meta );

    }


    /**
     * Gets the three month plan for a user
     * Warning: Does not do permission checking. This must be done previously.
     *
     * @param int $user_id
     * @param bool $full_plan
     * @return array|bool
     */
    public static function get_user_three_month_plan( int $user_id, bool $full_plan = true ) {

        $user = get_user_by( 'id', $user_id );
        if ( ! $user ) {
            return false;
        }

        $plan = self::plan_items_filter( get_user_meta( $user_id, 'three_month_plan', true ) );
        $labels = self::plan_labels();

        $full = array(
            'user' => $user,
            'plan' => $plan,
            'labels' => $labels,
        );

        if ( $full_plan ) {
            return $full;
        } else {
            return $plan;
        }
    }

    public static function reset_plan() {
        delete_user_meta( get_current_user_id(), 'three_month_plan' );
        update_user_meta( get_current_user_id(), 'three_month_plan', self::plan_items_filter() );
    }

    public static function get_group_name_by_group_key( $group_key ) {
        $group_meta = Zume_Dashboard::get_group_by_key( $group_key );
        if ( ! $group_meta ) {
            // unlink the group from the three month plan
            self::unlink_plan_from_group( $group_key );
        }
        return $group_meta['group_name'];
    }

    /**
     * Connect to a group via a public key
     *
     * @param $public_key
     * @return array|bool|WP_Error
     */
    public static function connect_plan_to_group( $public_key ) {

        // get group key
        $group_key = Zume_Dashboard::verify_public_key_for_group( $public_key );
        if ( ! $group_key ) {
            return new WP_Error( 'key_not_found', 'The key supplied was not found' );
        }

        // open group by key
        $group_meta = Zume_Dashboard::get_group_by_key( $group_key );
        if ( ! $group_meta ) {
            return new WP_Error( 'group_data_failure', 'Group found, but with no data.' );
        }

        // user to three month plan list of group
        if ( ! array_search( get_current_user_id(), $group_meta['three_month_plans'] ) ) {
            array_push( $group_meta['three_month_plans'], get_current_user_id() );
            update_user_meta( $group_meta['owner'], $group_meta['key'], $group_meta );
        }

        // update user three month plan
        $user_three_month_plan = self::get_user_three_month_plan( get_current_user_id(), false );
        $user_three_month_plan['linked'] = true;
        $user_three_month_plan['group_key'] = $group_key;
        $user_three_month_plan['public_key'] = $public_key;
        update_user_meta( get_current_user_id(), 'three_month_plan', $user_three_month_plan );

        // return true
        return $group_meta;
    }

    /**
     * Unlink a plan from a group
     *
     * @param $group_key
     * @return bool
     */
    public static function unlink_plan_from_group( $group_key ) {

        // REMOVE FROM CURRENT USER THREE MONTH PLAN
        $three_month_plan = self::get_user_three_month_plan( get_current_user_id(), false );
        unset( $three_month_plan['group_key'] );
        update_user_meta( get_current_user_id(), 'three_month_plan', $three_month_plan );


        // REMOVE FROM GROUP
        if ( empty( $group_key ) ) {
            return false;
        }

        $group_meta = Zume_Dashboard::get_group_by_key( $group_key );
        if ( ! $group_meta ) {
            return false;
        }

        // validate the current user is listed in the three_month_plans section
        if ( array_search( get_current_user_id(), $group_meta['three_month_plans'] ) === true ) {

            // remove from group
            foreach ( $group_meta['three_month_plans'] as $three_month_plan ) {
                if ( get_current_user_id() == $three_month_plan ) {
                    unset( $group_meta['three_month_plans'] );
                }
            }
            update_user_meta( $group_meta['owner'], $group_meta['key'], $group_meta );

        }
        return true;
    }

}
