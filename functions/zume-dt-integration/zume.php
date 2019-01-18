<?php
/**
 * Prepare Zume Data to Send
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Class Zume_Integration
 */
class Zume_Integration
{

    public function send_session_complete_transfer( $zume_group_key, $owner_id ) {
        dt_write_log( __METHOD__ );

        // Get owner prepared data
        $owner_user_data = $this->get_transfer_user_array( $owner_id );

        // Group data
        $zume_group_meta = $this->get_transfer_group_array( $zume_group_key, $owner_id );

        // Get foreign keys for coleaders
        $coleaders = $this->get_coleader_foreign_keys( $zume_group_meta );

        // Get target site for transfer
        $site_key = $this->filter_for_site_key( $owner_user_data, $owner_id );
        if ( ! $site_key ) {
            dt_write_log( __METHOD__ . ' (Failure: filter_for_site_key)' );
            return; // no sites setup
        }
        $site = zume_integration_get_site_details( $site_key );
        if ( ! $site ) {
            dt_write_log( __METHOD__ . ' (Failure: zume_integration_get_site_details | '.$site_key.')' );
            return;
        }

        // Send remote request
        $args = [
        'method' => 'POST',
        'body' => [
            'transfer_token' => $site['transfer_token'],
            'owner_raw_record' => $owner_user_data,
            'group_raw_record' => $zume_group_meta,
            'coleaders' => $coleaders,
            ]
        ];
        $result = zume_integration_remote_send( 'session_complete_transfer', $site['url'], $args );

        dt_write_log( $result );
        return;
    }

    public function send_coaching_request_transfer( $user_id ) {
        dt_write_log( __METHOD__ );

        // Get prepared data for user
        $user_data = $this->get_transfer_user_array( $user_id );

        // check if user has groups, if so then stop.
        $groups = $this->get_all_groups( $user_id );

        // Get target site for transfer
        $site_key = $this->filter_for_site_key( $user_data, $user_id );
        if ( ! $site_key ) {
            dt_write_log( __METHOD__ . ' (Failure: filter_for_site_key)' );
            return new WP_Error( __METHOD__, 'Failure: filter_for_site_key' ); // no sites setup
        }

        $site = zume_integration_get_site_details( $site_key );
        if ( ! $site ) {
            dt_write_log( __METHOD__ . ' (Failure: zume_integration_get_site_details)' );
            return new WP_Error( __METHOD__, 'Failure: zume_integration_get_site_details' );
        }

        // Send remote request
        $args = [
            'method' => 'POST',
            'body' => [
                'transfer_token' => $site['transfer_token'],
                'raw_user' => $user_data,
                'raw_groups' => $groups,
            ]
        ];
        $result = zume_integration_remote_send( 'coaching_request', $site['url'], $args );
        $body = json_decode( wp_remote_retrieve_body( $result ), true );
        return $body;
    }

    public function get_all_groups( $user_id ) {
        // check if user has groups, if so then stop.
        $groups = Zume_Dashboard::get_current_user_groups( $user_id );
        if ( ! empty( $groups ) ) {
            foreach ( $groups as $key => $group ) {
                $groups[$key]['zume_check_sum'] = md5( serialize( $group ) );
            }
        }

        $user = get_user_by( 'id', $user_id );
        $zume_colead_groups = Zume_Dashboard::get_colead_groups( 'accepted', $user );
        if ( ! empty( $zume_colead_groups ) ) {
            foreach ( $zume_colead_groups as $zume_colead_key => $zume_colead_value ) {
                $groups[ $zume_colead_key ] = $zume_colead_value;
                $groups[ $zume_colead_key ]['zume_check_sum'] = md5( serialize( $zume_colead_value ) );
            }
        }

        if ( ! empty( $groups ) ) {
            $groups['groups_check_sum'] = md5( serialize( $groups ) );
            return $groups;
        } else {
            return [];
        }
    }



    public function send_three_month_plan_transfer( $user_id ) {
        dt_write_log( __METHOD__ );

        // Get prepared data for user
        $user_data = $this->get_transfer_user_array( $user_id );

        // check if user has groups, if so then stop.
        $has_groups = Zume_Dashboard::get_current_user_groups( $user_id );
        if ( $has_groups ) {
            return;
        }

        // Get target site for transfer
        $site_key = $this->filter_for_site_key( $user_data, $user_id );
        if ( ! $site_key ) {
            dt_write_log( __METHOD__ . ' (Failure: filter_for_site_key)' );
            return; // no sites setup
        }

        $site = zume_integration_get_site_details( $site_key );
        if ( ! $site ) {
            dt_write_log( __METHOD__ . ' (Failure: zume_integration_get_site_details)' );
            return;
        }

        // Send remote request
        $args = [
        'method' => 'POST',
            'body' => [
            'transfer_token' => $site['transfer_token'],
            'raw_record' => $user_data,
            ]
        ];
        $result = zume_integration_remote_send( 'three_month_plan_submitted', $site['url'], $args );

        dt_write_log( $result );
        return;
    }

    public function get_coleader_foreign_keys( $group_meta ): array {
        $group_meta = Zume_Dashboard::verify_group_array_filter( $group_meta );

        if ( empty( $group_meta['coleaders'] ) ) {
            return [];
        }

        if ( empty( $group_meta['coleaders_accepted'] ) ) {
            return [];
        }

        if ( ! empty( $group_meta['coleaders_declined'] ) ) {
            foreach ( $group_meta['coleaders_declined'] as $declined_email ) {
                $index = array_search( $group_meta['coleaders_declined'], $group_meta['coleaders_accepted'] );
                unset( $group_meta['coleaders_accepted'][$index] );
            }
        }

        $coleaders = [];
        foreach ( $group_meta['coleaders_accepted'] as $coleader_email ) {
            $user = get_user_by( 'email', $coleader_email );
            $user_data = $this->get_transfer_user_array( $user->ID );
            $coleaders[$user_data['zume_foreign_key']] = $user_data;
        }

        return $coleaders;
    }

    /**
     * Filters for the appropriate site key
     *
     * @param $user_data
     *
     * @return bool|int|string
     */
    public function filter_for_site_key( $user_data, $user_id ) {

        $key = get_option( 'zume_default_site' ); // Currently, the default site is returned as the only routing option.
        if ( ! $key ) {

            $keys = Site_Link_System::get_site_keys();
            if ( empty( $keys ) ) {
                return false;
            }

            foreach ( $keys as $key => $value ) { //picks first site, modifies the $key value, updates option
                update_option( 'zume_site_default', $key );
                break;
            }
        }

        // @TODO Potentially add routing logic.
        // Evaluate routing factors of the user_data to route the user to a certain site.
        // Is location set, then potentially route to location site

        if ( get_user_meta( $user_id, 'zume_affiliation_key', true ) ) {
            // @todo build function to lookup affiliation key
            dt_write_log( 'build zume_affiliation_key' );
        }
        if ( get_user_meta( $user_id, 'zume_affiliation', true ) ) {
            // @todo build filter to return zume_affiliation
            dt_write_log( 'build zume_affiliation' );
        }
        if ( $lang_site_key = $this->route_by_language( $user_data['zume_language'] ) ) {
            return $lang_site_key;
        }

        return $key;
    }

    /**
     * Filters language for associated site keys. These keys are defined in the languages tab of the Zume menu item.
     * @param $zume_language
     *
     * @return bool
     */
    public function route_by_language( $zume_language ) {
        if ( 'en' === $zume_language ) {
            return false;
        }

        $map = get_option( 'zume_dt_language_map' );
        if ( empty( $map ) ) {
            return false;
        }

        foreach ( $map as $lang_code => $site ) {
            if ( $lang_code === $zume_language ) {
                return $site;
            }
        }

        return false;
    }

    /**
     * Transfer user data
     * This function puts together the complete user data package to send to Disciple Tools
     *
     * @param null $user_id
     *
     * @return array
     */
    public function get_transfer_user_array( $user_id = null ) {
        if ( is_null( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        $user = get_user_by( 'id', $user_id );
        $user_meta = zume_get_user_meta( $user->ID );

        $full_name = $user_meta['zume_full_name'] ?? '';
        if ( empty( $full_name ) ) {
            $user_meta['first_name'] = $user_meta['first_name'] ?? '';
            $user_meta['last_name'] = $user_meta['last_name'] ?? '';

            $full_name = trim( $user_meta['first_name'] . ' ' . $user_meta['last_name'] );

            if ( empty( $full_name ) ) {
                $full_name = $user_meta['nickname'] ?: $user->data->display_name;
            }
        }

        $three_month_plan = get_user_meta( $user_id, 'three_month_plan', true );
        if ( class_exists( 'Zume_Three_Month_Plan' ) ) {
            $three_month_plan = Zume_Three_Month_Plan::plan_items_filter( $three_month_plan );
        }

        $zume_groups = $this->get_groups_for_user( $user_meta );

        $zume_colead_groups = $this->get_colead_groups_for_user( $user->data->user_email );

        $prepared_user_data = [
            'title' => sanitize_text_field( wp_unslash( ucwords( $full_name ) ) ),
            'user_login' => $user->data->user_login,
            'first_name' => sanitize_text_field( wp_unslash( $user_meta['first_name'] ?? '' ) ),
            'last_name' => sanitize_text_field( wp_unslash( $user_meta['last_name'] ?? '' ) ),
            'user_registered' => $user->data->user_registered,
            'user_email' => sanitize_email( wp_unslash( $user->data->user_email ) ),
            'last_activity' => $user_meta['last_activity'] ?? '',
            'zume_language' => maybe_unserialize( $user_meta['zume_language'] ?? zume_current_language() ?: zume_default_language() ) ,
            'zume_phone_number' => sanitize_text_field( wp_unslash( $user_meta['zume_phone_number'] ?? '' ) ),
            'zume_user_address' => sanitize_text_field( wp_unslash( $user_meta['zume_user_address'] ?? '' ) ),
            'zume_user_lng' => sanitize_text_field( wp_unslash( $user_meta['zume_user_lng'] ?? '' ) ),
            'zume_user_lat' => sanitize_text_field( wp_unslash( $user_meta['zume_user_lat'] ?? '' ) ),
            'zume_raw_location' => maybe_unserialize( sanitize_text_field( wp_unslash( $user_meta['zume_raw_location'] ?? '' ) ) ),
            'zume_address_from_ip' => $user_meta['zume_address_from_ip'] ?? '',
            'zume_lng_from_ip' => $user_meta['zume_lng_from_ip'] ?? '',
            'zume_lat_from_ip' => $user_meta['zume_lat_from_ip'] ?? '',
            'zume_raw_location_from_ip' => maybe_unserialize( sanitize_text_field( wp_unslash( $user_meta['zume_raw_location_from_ip'] ?? '' ) ) ),
            'zume_foreign_key' => $user_meta['zume_foreign_key'] ?? self::get_foreign_key( $user_id ),
            'zume_three_month_plan' => $three_month_plan ?: [],
            'zume_groups' => $zume_groups ?? [],
            'zume_colead_groups' => $zume_colead_groups ?? [],
            'zume_affiliation_key' => sanitize_text_field( wp_unslash( $user_meta['zume_affiliation_key'] ?? '' ) ),
        ];

        update_user_meta( $user_id, 'zume_check_sum', md5( serialize( $prepared_user_data ) ) );
        $prepared_user_data['zume_check_sum'] = md5( serialize( $prepared_user_data ) );

        return $prepared_user_data;
    }

    public function get_transfer_group_array( $zume_group_key, $owner_id = null ) : array {
        if ( is_null( $owner_id ) ) {
            global $wpdb;
            $group_meta = $wpdb->get_var( $wpdb->prepare( "
                SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = %s
            ",
                $zume_group_key
            ));

            if ( ! $group_meta ) {
                return [];
            }
        } else {
            $group_meta = get_user_meta( $owner_id, $zume_group_key, true );
        }

        $group_meta['zume_check_sum'] = md5( serialize( $group_meta ) );

        return $group_meta;
    }

    public function get_groups_for_user( $user_meta ) : array {
        $groups = [];
        foreach ( $user_meta as $zume_key => $v ) {
            $zume_key_beginning = substr( $zume_key, 0, 10 );
            if ( 'zume_group' == $zume_key_beginning ) {
                $groups[] = $zume_key;
            }
        }
        return $groups;
    }

    /**
     * @see Zume_Dashboard::get_colead_groups()
     */
    public function get_colead_groups_for_user( $user_email ) : array {
        global $wpdb;
        $groups = [];
        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT *
                        FROM `$wpdb->usermeta`
                        WHERE meta_key LIKE %s
                          AND meta_value LIKE %s",
            $wpdb->esc_like( 'zume_group_' ).'%',
            '%'. $wpdb->esc_like( $user_email ). '%'
        ), ARRAY_A );
        if ( empty( $results ) ) {
            return $groups;
        }

        foreach ( $results as $v ){
            $zume_key = $v['meta_key'];
            $zume_value = maybe_unserialize( $v['meta_value'] );
            $zume_value = Zume_Dashboard::verify_group_array_filter( $zume_value );

            if ( in_array( $user_email, $zume_value['coleaders'] ) && // is added as coleader
            in_array( $user_email, $zume_value['coleaders_accepted'] ) && // is accepted
            ! in_array( $user_email, $zume_value['coleaders_declined'] ) ) // not declined
            {
                $zume_value['no_edit'] = true; // tags record as no owned
                $prepared[$zume_key] = $zume_value;
            }
        }

        return $groups;
    }

    public static function get_foreign_key( $user_id ) {
        $key = get_user_meta( $user_id, 'zume_foreign_key', true );
        if ( empty( $key ) ) {
            $key = Site_Link_System::generate_token( 40 ); // forty bits equals 1.1 trillion combinations
            update_user_meta( $user_id, 'zume_foreign_key', $key );
        }
        return $key;
    }

    public static function get_user_by_foreign_key( $zume_foreign_key ) {
        global $wpdb;
        $user_id = $wpdb->get_var( $wpdb->prepare( "
            SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'zume_foreign_key' AND meta_value = %s
        ",
            $zume_foreign_key
        ) );

        return $user_id;
    }

    public static function get_group_by_foreign_key( $zume_foreign_key ) {
        global $wpdb;
        $group = $wpdb->get_results( $wpdb->prepare( "
            SELECT user_id, meta_key as group_key FROM $wpdb->usermeta WHERE meta_key LIKE %s AND meta_value LIKE %s LIMIT 1
        ",
            $wpdb->esc_like( 'zume_group' ) . '%',
            '%' . $wpdb->esc_like( $zume_foreign_key ) . '%'
        ), ARRAY_A );

        if ( ! $group ) {
            return [];
        }

        return $group[0];
    }

    /**
     * Goes through database and adds foreign key to any users missing
     * Called from the Zume Settings page. Used during database installation
     */
    // @todo VIP coding standard is flagging this sql query saying "Usage of users/usermeta tables is highly discouraged in VIP context, For storing user additional user metadata, you should look at User Attributes."
    // @codingStandardsIgnoreStart
    public function verify_check_sum_installed() {
//        dt_write_log(__METHOD__);
        global $wpdb;
        $results = $wpdb->get_col( "SELECT ID FROM $wpdb->users WHERE id NOT IN ( SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'zume_check_sum' )" );

        $i = 0;
        if ( ! empty( $results ) ) {
            foreach ( $results as $user_id ) {
                $this->get_transfer_user_array( $user_id );
                $i++;
            }
//            dt_write_log( 'Updated: ' . $i );
            return $i;
        } else {
            return $i;
        }
    }

    /**
     * Goes through database and adds foreign key to any users missing
     */
    public function verify_foreign_key_installed() {
//        dt_write_log(__METHOD__);
        global $wpdb;
        $results = $wpdb->get_col( "SELECT ID FROM $wpdb->users WHERE id NOT IN ( SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'zume_foreign_key' )" );

        $i = 0;
        if ( ! empty( $results ) ) {
            foreach ( $results as $user_id ) {
                $key = Site_Link_System::generate_token( 40 ); // forty bits equals 1.1 trillion combinations
                update_user_meta( $user_id, 'zume_foreign_key', $key );
                $i++;
            }
//            dt_write_log( 'Updated: ' . $i );
            return $i;
        } else {
            return $i;
        }
    }

    public function verify_foreign_key_installed_on_group() {
//        dt_write_log(__METHOD__);
        global $wpdb;
        $results = $wpdb->get_results( "SELECT user_id, meta_key as group_key FROM $wpdb->usermeta WHERE meta_key LIKE 'zume_group%'", ARRAY_A );

//        dt_write_log( $results );

        if ( ! empty( $results ) ) {
            foreach ( $results as $v ) {
                $group_meta = Zume_Dashboard::verify_group_array_filter( get_user_meta( $v['user_id'], $v['group_key'], true ) );

                if ( isset( $group_meta['foreign_key'] ) ) {
//                    dt_write_log( $v['group_key'] . '; true' );
                } else {
                    dt_write_log( $v['group_key'] . '; false' );
                }
            }
            return;
        } else {
            return;
        }
    }
    // @codingStandardsIgnoreEnd

}

/**
 * Send Post Request
 * $args = [
 *  'method' => 'POST',
 *   'body' => [
 *   'transfer_token' => $site['transfer_token'],
 *   'transfer_record' => $fields,
 *   'zume_foreign_key' => $user_data['zume_foreign_key'],
 *   'zume_language' => $user_data['zume_language'],
 *   'zume_check_sum' => $user_data['zume_check_sum'],
 * ]
 * ];
 *
 * @param $endpoint
 * @param $url
 * @param $args
 *
 * @return array|\WP_Error
 */
function zume_integration_remote_send( $endpoint, $url, $args ) {

    $result = wp_remote_post( 'https://' . $url . '/wp-json/dt-public/v1/zume/' . $endpoint, $args );

    if ( is_wp_error( $result ) ) {
        return new WP_Error( 'failed_remote_get', $result->get_error_message() );
    }
    return $result;
}

/**
 * Get the token and url of the site
 *
 * @param $site_key
 *
 * @return bool|array
 */
function zume_integration_get_site_details( $site_key ) {
    $keys = Site_Link_System::get_site_keys();

    if ( ! isset( $keys[$site_key] ) ) {
        return false;
    }

    $site1 = $keys[$site_key]['site1'];
    $site2 = $keys[$site_key]['site2'];

    $url = Site_Link_System::get_non_local_site( $site1, $site2 );
    $transfer_token = Site_Link_System::create_transfer_token_for_site( $site_key );

    return [
        'url' => $url,
        'transfer_token' => $transfer_token
    ];
}

function zume_get_public_site_links() {

    global $wpdb;
    $list = $wpdb->get_results( $wpdb->prepare( "
        SELECT ID as id, post_title as label 
        FROM $wpdb->posts as posts 
          JOIN $wpdb->postmeta as postmeta ON posts.ID=postmeta.post_id 
        WHERE post_type = 'site_link_system' 
          AND post_status = 'publish'
          AND postmeta.meta_key = 'visibility'
          AND postmeta.meta_value = %s
          AND ID IN ( SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'site_key' )
    ",
    0 ), ARRAY_A );

//    dt_write_log( $list );
    return $list;
}