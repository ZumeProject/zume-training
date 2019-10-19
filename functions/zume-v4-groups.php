<?php

/**
 * Class Zume_v4_Groups
 */
class Zume_v4_Groups {

    /**
     * Zume_v4_Groups The single instance of Zume_v4_Groups.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_v4_Groups Instance
     *
     * Ensures only one instance of Zume_v4_Groups is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_v4_Groups instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    /**
     * Constructor function.
     * @access  public
     * @since   0.1
     */
    public function __construct() { } // End __construct()

    /**
     * @version 4
     * @param $args
     * @return bool|false|int
     */
    public static function create_group( $args ) {

        // Validate post data
        $group_values = self::verify_group_array_filter( [], true );

        if ( ! empty( $args['address'] ) ) {
            // Geo lookup address
            $mapbox = DT_Mapbox_API::lookup( $args['address'] ); // get google api info
            if ( isset( $mapbox['features'] ) ) {
                $args['lng'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'longitude', true );
                $args['lat'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'latitude', true );
                $args['address'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'place_name', true );
                $args['raw_location'] = $mapbox;
            }
        }

        if ( isset( $args['ip_address'] ) ) {
            $results = DT_Ipstack_API::geocode_ip_address( $args['ip_address'] );
        } else {
            $results = DT_Ipstack_API::geocode_ip_address( DT_Ipstack_API::get_real_ip_address() );
        }
        if ( isset( $results['id'] ) ) {
            $args['ip_lng'] = $results['longitude'];
            $args['ip_lat'] = $results['latitude'];
            $args['ip_raw_location'] = $results;
        }

        if ( isset( $args['type'] ) ) {
            unset( $args['type'] );
        }

        $new_group = wp_parse_args( $args, $group_values );

        if ( __( 'No Name', 'zume' ) === $new_group['group_name'] ) {
            return false;
        }

        $result = add_user_meta( get_current_user_id(), $new_group['key'], $new_group, true );

        do_action( 'zume_create_group', get_current_user_id(), $new_group['key'], $new_group );

        return $result;

    }


    /**
     * Edit Group
     *
     * @param $args
     * @return bool|WP_Error
     */
    public static function edit_group( $args ) {
        // Check if this user can edit this group
        $current_user_id = get_current_user_id();
        $group_meta = get_user_meta( $current_user_id, $args['key'], true );
        $group_meta = self::verify_group_array_filter( $group_meta );

        if ( empty( $group_meta ) ) {
            return new WP_Error( 'no_group_match', 'Hey, you cheating? No, group with id found for you.' );
        }

        if ( empty( $args['validate_address'] ) ) {
            $args['address'] = '';
        }
        if ( isset( $args['address'] ) && ! ( $args['address'] == $group_meta['address'] ) && ! empty( $args['address'] ) ) {
            // Geo lookup address
            $mapbox = DT_Mapbox_API::lookup( $args['address'] ); // get google api info
            if ( isset( $mapbox['features'] ) ) {
                $group_meta['lng'] = '';
                $group_meta['lat'] = '';
                $group_meta['address'] = '';
                $group_meta['raw_location'] = '';

                $args['lng'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'longitude', true );
                $args['lat'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'latitude', true );
                $args['address'] = DT_Mapbox_API::parse_raw_result( $mapbox, 'place_name', true );
                $args['raw_location'] = $mapbox;
            }
        }

        $args['ip_address'] = $args['ip_address'] ?? DT_Ipstack_API::get_real_ip_address();
        if ( isset( $args['ip_address'] ) && ! empty( $args['ip_address'] ) ) {
            $results = DT_Ipstack_API::geocode_ip_address( $args['ip_address'] );
            if ( isset( $results['ip'] ) ) {
                $args['ip_lng'] = $results['longitude'];
                $args['ip_lat'] = $results['latitude'];
                $args['ip_raw_location'] = $results;
            }
        }

        // Add coleaders
        $args['coleaders'] = ( ! empty( $args['coleaders'] ) ) ? array_filter( $args['coleaders'] ) : []; // confirm or establish array variable.
        $args['coleaders_accepted'] = ( ! empty( $args['coleaders_accepted'] ) ) ? array_filter( $args['coleaders_accepted'] ) : [];
        $args['coleaders_declined'] = ( ! empty( $args['coleaders_declined'] ) ) ? array_filter( $args['coleaders_declined'] ) : [];
        if ( isset( $args['new_coleader'] ) && ! empty( $args['new_coleader'] && is_array( $args['new_coleader'] ) ) ) { // test if new coleader added
            foreach ( $args['new_coleader'] as $coleader ) { // loop potential additions

                $coleader = trim( strtolower( $coleader ) );
                // check if empty
                if ( empty( $coleader ) || ! is_email( $coleader ) ) {
                    continue;
                }

                // duplicate check
                if ( ! empty( $args['coleaders'] ) ) { // if coleaders exist
                    foreach ( $args['coleaders'] as $previous_coleader ) {
                        if ( $previous_coleader == $coleader ) {
                            continue 2;
                        }
                    }
                }

                // insert new values
                array_push( $args['coleaders'], $coleader );
            }
            unset( $args['new_coleader'] );
        }

        // Combine array with new data
        if ( isset( $args['type'] ) ) { // keeps from storing the form parse info
            unset( $args['type'] );
        }
        $args['last_modified_date'] = current_time( 'mysql' );
        $args = wp_parse_args( $args, $group_meta );

        update_user_meta( $current_user_id, $args['key'], $args );

        do_action( 'zume_edit_group', $current_user_id, $args['key'], $args );

        return true;
    }

    public static function update_ip_address( $group_key ) {
        $status = false;
        $group_meta = self::get_group_by_key( $group_key );
        if ( ! $group_meta ) {
            return false;
        }
        $group_meta['ip_address'] = DT_Ipstack_API::get_real_ip_address();
        $results = DT_Ipstack_API::geocode_ip_address( $group_meta['ip_address'] );
        if ( isset( $results['ip'] ) ) {
            $group_meta['ip_lng'] = $results['longitude'];
            $group_meta['ip_lat'] = $results['latitude'];
            $group_meta['ip_raw_location'] = $results;
            $status = update_user_meta( $group_meta['owner'], $group_meta['key'], $group_meta );
        }
        if ( $status ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @version 4
     * @param $group_key
     * @return bool
     */
    public static function delete_group( $group_key ) {
        $user_id = get_current_user_id();

        $result = delete_user_meta( $user_id, $group_key );

        do_action( 'zume_delete_group', $user_id, $group_key );

        return $result;
    }

    /**
     * @version 4
     * @param $group_key
     * @return bool|int|WP_Error
     */
    public static function archive_group( $group_key ) {
        $user_id = get_current_user_id();

        $modified_group = $group = get_user_meta( $user_id, $group_key, true );
        if ( empty( $modified_group ) ) {
            return new WP_Error( 'no_group_match', 'Hey, you cheating? No, group with id found for you.' );
        }
        $modified_group['closed'] = true;

        self::filter_last_modified_to_now( $modified_group );

        $result = update_user_meta( $user_id, $group_key, $modified_group, $group );

        do_action( 'zume_close_group', $user_id, $group_key );

        return $result;
    }

    /**
     * @version 4
     * @param $group_id
     * @return bool|int
     */
    public static function activate_group( $group_id ) {

        $modified_group = $group = get_user_meta( get_current_user_id(), $group_id, true );

        $modified_group = self::verify_group_array_filter( $modified_group );

        $modified_group['closed'] = false;

        self::filter_last_modified_to_now( $modified_group );

        $result = update_user_meta( get_current_user_id(), $group_id, $modified_group, $group );

        do_action( 'zume_activate_group', get_current_user_id(), $group_id );

        return $result;
    }

    public static function get_highest_session( $user_id ) {
        $highest_session = 0;
        $zume_user_meta = zume_get_user_meta( $user_id );
        foreach ( $zume_user_meta as $key => $v ) {
            $key_beginning = substr( $key, 0, 10 );
            if ( 'zume_group' == $key_beginning ) { // check if zume_group
                $value = maybe_unserialize( $v );
                $next_session = self::get_next_session( $value );
                if ( $highest_session < $next_session ) {
                    $highest_session = $next_session;
                }
            }
        }
        $zume_colead_groups = self::get_colead_groups();
        foreach ( $zume_colead_groups as $key => $v ) {
            $key_beginning = substr( $key, 0, 10 );
            if ( 'zume_group' == $key_beginning ) { // check if zume_group
                $value = maybe_unserialize( $v );
                $next_session = self::get_next_session( $value );
                if ( $highest_session < $next_session ) {
                    $highest_session = $next_session;
                }
            }
        }
        return $highest_session;
    }

    /**
     * @version 4
     * @param $zume_group_key
     * @return string|void
     */
    public static function get_group_public_key( $zume_group_key ) {
        global $wpdb;
        $zume_group_meta = $wpdb->get_var( $wpdb->prepare( "
            SELECT meta_value 
            FROM $wpdb->usermeta 
            WHERE meta_key = %s
        ",
            $zume_group_key
        ));

        if ( ! $zume_group_meta ) {
            return __( '( Key not available. Check dashboard. )', 'zume' );
        }

        $zume_group_meta = self::verify_group_array_filter( $zume_group_meta );

        return $zume_group_meta['public_key'] ?? '';
    }

    /**
     * @version 4
     * @param array $group_meta
     * @return int
     */
    public static function get_next_session( array $group_meta ) : int {

        if ( $group_meta['session_1'] === false ) {
            return 1;
        }
        if ( $group_meta['session_2'] === false ) {
            return 2;
        }
        if ( $group_meta['session_3'] === false ) {
            return 3;
        }
        if ( $group_meta['session_4'] === false ) {
            return 4;
        }
        if ( $group_meta['session_5'] === false ) {
            return 5;
        }
        if ( $group_meta['session_6'] === false ) {
            return 6;
        }
        if ( $group_meta['session_7'] === false ) {
            return 7;
        }
        if ( $group_meta['session_8'] === false ) {
            return 8;
        }
        if ( $group_meta['session_9'] === false ) {
            return 9;
        }
        if ( $group_meta['session_10'] === false ) {
            return 10;
        }
        if ( $group_meta['session_10'] === true ) {
            return 11;
        }
        return 1;

    }

    public static function get_available_videos_count( $next_session ) {
        switch ( $next_session ) {
            case '1':
                echo 2;
                break;
            case '2':
                echo 7;
                break;
            case '3':
                echo 10;
                break;
            case '4':
                echo 13;
                break;
            case '5':
                echo 18;
                break;
            case '6':
                echo 20;
                break;
            case '7':
                echo 23;
                break;
            case '8':
                echo 24;
                break;
            case '9':
                echo 25;
                break;
            case '10':
                echo 29;
                break;
            case '11':
                echo 32;
                break;
            default:
                echo 2;
                break;

        }
    }

    public static function get_available_tools_count( $next_session ) {
        switch ( $next_session ) {
            case '1':
                echo 0;
                break;
            case '2':
                echo 3;
                break;
            case '3':
                echo 5;
                break;
            case '4':
                echo 6;
                break;
            case '5':
                echo 8;
                break;
            case '6':
                echo 9;
                break;
            case '7':
                echo 10;
                break;
            case '8':
                echo 10;
                break;
            case '9':
                echo 10;
                break;
            case '10':
                echo 10;
                break;
            case '11':
                echo 12;
                break;
            default:
                echo 0;
                break;

        }
    }

    public static function get_coleader_input( $email_address, $li_id, $group_key ) {
        // check if email is a user
        $user = get_user_by( 'email', $email_address );

        $has_coleader_accepted = self::has_coleader_accepted( $email_address, $group_key );

        if ( $user ) {
            // if email is a user
            ?>
            <li class="coleader" id="<?php echo esc_attr( $li_id ) ?>"><?php echo esc_attr( $email_address ) ?>
                <?php if ( $has_coleader_accepted ) : ?>
                    ( <?php echo get_avatar( $email_address, 15 ) ?>  <?php echo esc_attr( $user->display_name ) ?> )
                <?php endif; ?>
                <input type="hidden" name="coleaders[]" value="<?php echo esc_attr( $email_address ) ?>" />
            </li>
            <?php

        } else {
            // if email is not a user
            ?>
            <li class="coleader" id="<?php echo esc_attr( $li_id ) ?>">
                <?php echo esc_attr( $email_address ) ?><input type="hidden" name="coleaders[]" value="<?php echo esc_attr( $email_address ) ?>" />
            </li>
            <?php
        }
    }

    public static function has_coleader_accepted( $email_address, $group_key ) {

        $group_meta = get_user_meta( get_current_user_id(), $group_key, true );
        $group_meta = self::verify_group_array_filter( $group_meta );

        return in_array( $email_address, $group_meta['coleaders_accepted'] );
    }



    /**
     * Gets the displayable list of Colead Groups
     * These groups have the user email added to their record
     * These groups have user email listed as accepted for coleadership
     *
     * @version 4
     * @return array
     */
    public static function get_colead_groups( $status = 'accepted' ) : array {
        global $wpdb;
        $prepared = [];
        $user = get_user_by( 'id', get_current_user_id() );

        $results = $wpdb->get_col( $wpdb->prepare(
            "SELECT meta_value
                        FROM `$wpdb->usermeta`
                        WHERE meta_key LIKE %s
                          AND meta_value LIKE %s",
            $wpdb->esc_like( 'zume_group_' ).'%',
            '%'. $wpdb->esc_like( $user->user_email ). '%'
        ) );
        if ( empty( $results ) ) {
            return $prepared;
        }

        switch ( $status ) {
            case 'accepted':
                foreach ( $results as $v ){
                    $zume_value = self::verify_group_array_filter( $v );

                    // skip if they are not in coleaders list
                    if ( ! in_array( $user->user_email, $zume_value['coleaders'] ) ) {
                        continue;
                    }

                    // skip if they have declined
                    if ( in_array( $user->user_email, $zume_value['coleaders_declined'] ) ) {
                        continue;
                    }

                    // if they have already accepted
                    if ( in_array( $user->user_email, $zume_value['coleaders_accepted'] ) ) {
                        $prepared[$zume_value['key']] = $zume_value;
                    }
                }

                break;

            case 'waiting_acceptance':
                foreach ( $results as $v ){
                    $zume_value = self::verify_group_array_filter( $v );

                    // skip if they are not in coleaders list
                    if ( ! in_array( $user->user_email, $zume_value['coleaders'] ) ) {
                        continue;
                    }

                    // skip if they have declined
                    if ( in_array( $user->user_email, $zume_value['coleaders_declined'] ) ) {
                        continue;
                    }

                    // skip if they have already accepted
                    if ( in_array( $user->user_email, $zume_value['coleaders_accepted'] ) ) {
                        continue;
                    }

                    $prepared[$zume_value['key']] = $zume_value;
                }
                break;

            case 'waiting_acceptance_minimum':
                foreach ( $results as $v ){
                    $zume_value = self::verify_group_array_filter( $v );

                    // skip if they are not in coleaders list
                    if ( ! in_array( $user->user_email, $zume_value['coleaders'] ) ) {
                        continue;
                    }

                    // skip if they have declined
                    if ( in_array( $user->user_email, $zume_value['coleaders_declined'] ) ) {
                        continue;
                    }

                    // skip if they have already accepted
                    if ( in_array( $user->user_email, $zume_value['coleaders_accepted'] ) ) {
                        continue;
                    }

                    $user = get_user_by('id', $zume_value['owner'] );
                    if ( $user ) {
                        $prepared[] = [
                            'key' => $zume_value['key'],
                            'owner' => $user->display_name,
                            'group_name' => $zume_value['group_name'],
                        ];
                    }
                }

                break;

            case 'declined':
                foreach ( $results as $v ){
                    $zume_value = self::verify_group_array_filter( $v );

                    // if they have declined
                    if ( in_array( $user->user_email, $zume_value['coleaders_declined'] ) ) {
                        $prepared[$zume_value['key']] = $zume_value;
                    }

                }
                break;
            default:
                break;
        }

        return $prepared;
    }

    /**
     * @version 4
     * @param $key
     * @param $decision
     * @return bool
     */
    public static function coleader_invitation_response( $key, $decision ) {
        global $wpdb;
        $result = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = %s",  $key ) );
        if ( empty( $result ) ) {
            dt_write_log(__METHOD__ . ': Could not find ' . $key );
            return false;
        }
        $modified_group = $group = self::verify_group_array_filter( $result );

        $user = get_user_by( 'id', get_current_user_id() );

        switch( $decision ) {
            case 'accepted':
                // skip if they are not in coleaders list
                if ( ! in_array( $user->user_email, $modified_group['coleaders'] ) ) {
                    return false;
                }

                if ( in_array( $user->user_email, $modified_group['coleaders_accepted'] ) ) {
                    return false;
                }

                array_push( $modified_group['coleaders_accepted'], $user->user_email );

                if ( ( $index = array_search( $user->user_email, $modified_group['coleaders_declined'] ) ) !== false) {
                    unset($modified_group['coleaders_declined'][$index]);
                }

                update_user_meta( $modified_group['owner'], $modified_group['key'], $modified_group, $group );

                break;
            case 'declined':
                // skip if they are not in coleaders list
                if ( ! in_array( $user->user_email, $modified_group['coleaders'] ) ) {
                    return false;
                }

                if ( in_array( $user->user_email, $modified_group['coleaders_declined'] ) ) {
                    return false;
                }

                array_push( $modified_group['coleaders_declined'], $user->user_email );

                if ( ( $index = array_search( $user->user_email, $modified_group['coleaders_accepted'] ) ) !== false) {
                    unset($modified_group['coleaders_accepted'][$index]);
                }

                update_user_meta( $modified_group['owner'], $modified_group['key'], $modified_group, $group );

                break;
        }

        do_action( 'zume_coleader_invitation_response', $user->ID,  $key, $decision );

        return true;
    }

    /**
     * Gets user owned groups
     *
     * @return array|bool
     */
    public static function get_current_user_groups( $user_id = null ) {
        if ( is_null( $user_id ) ){
            $user_id = get_current_user_id();
        }
        $zume_user_meta = zume_get_user_meta( $user_id );
        $groups = [];
        foreach ( $zume_user_meta as $zume_key => $v ) {
            $zume_key_beginning = substr( $zume_key, 0, 10 );
            if ( 'zume_group' == $zume_key_beginning ) {
                $zume_value = self::verify_group_array_filter( $v );
                $groups[$zume_key] = $zume_value;
            }
        }

        if ( ! empty( $groups ) ) {
            return $groups;
        } else {
            return false;
        }
    }

    public static function get_current_user_group( $key, $user_id = null ) {
        if ( empty( $user_id ) ){
            $user_id = get_current_user_id();
        }
        $group = get_user_meta( $user_id, $key, true );
        if ( empty( $group ) ) {
            return new WP_Error( __METHOD__, 'Did not find group in user meta' );
        }
        return self::verify_group_array_filter( $group );
    }

    /**
     * Returns true of false if user owns groups
     * This does not test if they are a coleader or named participant.
     *
     * @return bool  True if user owns groups, False if use does not own groups.
     */
    public static function current_user_has_groups() : bool  {
        $zume_user_meta = zume_get_user_meta( get_current_user_id() );
        foreach ( $zume_user_meta as $zume_key => $v ) {
            $zume_key_beginning = substr( $zume_key, 0, 10 );
            if ( 'zume_group' == $zume_key_beginning ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Verify public key for group
     *
     * @param $public_key
     * @return bool|mixed returns false if false, returns group key if success.
     */
    public static function verify_public_key_for_group( $public_key ) {
        global $wpdb;

        $public_key = self::filter_public_key( $public_key );

        $results = $wpdb->get_var( $wpdb->prepare( "
                  SELECT meta_value 
                  FROM $wpdb->usermeta 
                  WHERE meta_key LIKE %s 
                    AND meta_value LIKE %s LIMIT 1",
            $wpdb->esc_like( 'zume_group' ). '%',
            '%'.$wpdb->esc_like( $public_key ).'%'
        ) );

        if ( empty( $results ) ) {
            return false;
        }

        $group_meta = self::verify_group_array_filter( $results );

        $group_meta['public_key'] = strtoupper( $group_meta['public_key'] );
        $public_key = strtoupper( $public_key );
        if ( $public_key == $group_meta['public_key'] ) {
            return $group_meta['key'];
        }

        return false;
    }

    public static function filter_public_key( $public_key ) {
        $fail = '00000'; // returns a false key

        // must not be empty
        if ( empty( $public_key ) ) {
            return $fail;
        }

        // must be alphanumberic
        if ( ! ctype_alnum( $public_key ) ) {
            return $fail;
        }

        // must have 5 digits
        if ( ! strlen( $public_key ) === 5 ) {
            return $fail;
        }

        $public_key = sanitize_key( $public_key );

        return $public_key;
    }

    /**
     * @param $group_key
     * @return string|WP_Error
     */
    public static function change_group_public_key( $group_key ) {
        // check if owner of group
        $group_meta = get_user_meta( get_current_user_id(), $group_key, true );
        if ( ! $group_meta ) {
            return new WP_Error( 'authorization_failure', 'Not authorized to make this change.' );
        }
        $group_meta = self::verify_group_array_filter( $group_meta );

        // get new key
        $new_key = self::get_unique_public_key();

        // save to group
        $group_meta['public_key'] = $new_key;

        $result = update_user_meta( get_current_user_id(), $group_key, $group_meta );

        if ( ! $result ) {
            return new WP_Error( 'update_failure', 'Failed to update record.' );
        } else {
            return $new_key;
        }
    }

    /**
     * Zume 4.0 Functions below
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     *
     */


    /**
     * Creates and verifies default values for the groups array.
     * This is the master location for defining the zume_groups array.
     *
     * If called empty, it will return an empty group array with default values. ex group_array_filter()
     * If passed a group array, it will verify that all required keys are present, add any missing, and return
     * group array. ex.group_array_filter( $group_meta )
     *
     * @version 4
     * @param $group_meta
     * @param bool $new
     * @return array|mixed
     */
    public static function verify_group_array_filter( $group_meta, $new = false ) {
        if ( is_serialized( $group_meta ) ) {
            $group_meta = maybe_unserialize( $group_meta );
        }

        $active_keys = [
            'owner'               => get_current_user_id(),
            'group_name'          => __( 'No Name', 'zume' ),
            'key'                 => self::get_unique_group_key(),
            'public_key'          => self::get_unique_public_key(),
            'members'             => 1,
            'meeting_time'        => '',
            'address'             => '',
            'lng'                 => '',
            'lat'                 => '',
            'raw_location'        => [],
            'ip_address'          => '',
            'ip_lng'              => '',
            'ip_lat'              => '',
            'ip_raw_location'     => [],
            'created_date'        => current_time( 'mysql' ),
            'next_session'        => '1',
            'session_1'           => false,
            'session_1_complete'  => '',
            'session_2'           => false,
            'session_2_complete'  => '',
            'session_3'           => false,
            'session_3_complete'  => '',
            'session_4'           => false,
            'session_4_complete'  => '',
            'session_5'           => false,
            'session_5_complete'  => '',
            'session_6'           => false,
            'session_6_complete'  => '',
            'session_7'           => false,
            'session_7_complete'  => '',
            'session_8'           => false,
            'session_8_complete'  => '',
            'session_9'           => false,
            'session_9_complete'  => '',
            'session_10'          => false,
            'session_10_complete' => '',
            'last_modified_date'  => time(),
            'closed'              => false,
            'coleaders'           => [],
            'coleaders_accepted'  => [],
            'coleaders_declined'  => [],
            'three_month_plans'   => [],
            'foreign_key'         => hash( 'sha256', time() . rand( 0, 100000 ) ),
        ];

        $deprecated_keys = [
            // 'deprecated_key_name',
        ];

        if ( ! is_array( $group_meta ) ) {
            $group_meta = [];
        }

        $trigger_update = false;

        // Active keys
        foreach ( $active_keys as $k => $v ) {
            if ( !isset( $group_meta[ $k ] ) ) {
                $group_meta[$k] = $v;
                $trigger_update = true;
            }
        }

        // Deprecated keys
        foreach ( $deprecated_keys as $deprecated_key ) {
            if ( isset( $group_meta[ $deprecated_key ] ) ) {
                unset( $group_meta[$deprecated_key] );
                $trigger_update = true;
            }
        }

        // Members can be always more, never less than participants
        if ( isset( $group_meta['coleaders_accepted'] ) ) {
            if ( count( $group_meta['coleaders_accepted'] ) + 1 > $group_meta['members'] ) {
                $group_meta['members'] = count( $group_meta['coleaders_accepted'] ) + 1;
                $trigger_update = true;
            }
        }

        if ( $new ) {
            $trigger_update = false;
        }

        if ( $trigger_update ) {
            if ( ! ( __( 'No Name', 'zume' ) == $group_meta['group_name'] ) ) {
                update_user_meta( $group_meta['owner'], $group_meta['key'], $group_meta );
            }
        }

        return $group_meta;
    }

    /**
     * @version 4
     * @return string
     */
    public static function get_unique_group_key() {
        global $wpdb;
        $duplicate_check = 1;
        while ( $duplicate_check != 0 ) {
            $group_key = uniqid( 'zume_group_' );
            $duplicate_check = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $wpdb->usermeta WHERE meta_key = %s", $group_key ) );
        }
        return $group_key;
    }

    /**
     * @version 4
     * @return mixed|string
     */
    public static function get_unique_public_key() {
        $key = hash( 'sha256', time() . rand( 0, 100000 ) );
        $key = str_replace( '0', '', $key );
        $key = str_replace( 'O', '', $key );
        $key = str_replace( 'o', '', $key );
        $key = strtoupper( substr( $key, 0, 5 ) );
        return $key;
    }

    /**
     * @version 4
     * @param int|null $user_id
     * @return array
     */
    public static function get_all_groups( int $user_id = null ) : array {
        $groups = [];
        if ( empty( $user_id) ) {
            $user_id = get_current_user_id();
        }
        $owned_groups = self::get_current_user_groups( $user_id );
        $colead_groups = self::get_colead_groups( 'accepted', $user_id );

        if ( ! empty( $owned_groups ) ) {
            foreach ( $owned_groups as $g ) {
                $check_sum = hash( 'sha256', serialize($g ) );
                $g['zume_check_sum'] = $check_sum;
                $groups[$g['last_modified_date']] = $g;
            }
        }
        if ( ! empty( $colead_groups ) ) {
            foreach ( $colead_groups as $g ) {
                $check_sum = hash( 'sha256', serialize($g ) );
                $g['zume_check_sum'] = $check_sum;
                $groups[$g['last_modified_date']] = $g;
            }
        }

        krsort( $groups );
        $groups = array_values( $groups );

        return $groups;
    }

    /**
     * @version 4
     * @param $group_key
     * @return array|bool
     */
    public static function get_group_by_key( $group_key ) {
        global $wpdb;

        $group_meta = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM $wpdb->usermeta WHERE meta_key = %s", $group_key ) );
        if ( empty( $group_meta ) ) {
            return false;
        }

        return self::verify_group_array_filter( $group_meta );
    }

    /**
     * @version 4
     * @param string $foreign_key
     * @return array
     */
    public static function get_group_by_foreign_key( string $foreign_key ) : array {
        global $wpdb;
        $group = $wpdb->get_var( $wpdb->prepare( "
            SELECT meta_value FROM $wpdb->usermeta WHERE meta_key LIKE %s AND meta_value LIKE %s LIMIT 1
        ",
            $wpdb->esc_like( 'zume_group' ) . '%',
            '%' . $wpdb->esc_like( $foreign_key ) . '%'
        ) );

        if ( empty( $group ) ) {
            return [];
        }

        return self::verify_group_array_filter( $group );
    }

    /**
     * @version 4
     * @param string $key
     * @param string $value
     * @return array|bool|int|mixed|WP_Error
     */
    public static function update_group_name( string $key, string $value ) {
        $modified_group = $group = self::get_current_user_group( $key );
        if ( is_wp_error( $group ) ) {
            return $group;
        }

        if ( empty( $value ) ) {
            $value = __( 'No Name', 'zume' );
        }

        $modified_group['group_name'] = sanitize_text_field( wp_unslash( $value ) );

        self::filter_last_modified_to_now( $modified_group ); // add new timestamp

        return update_user_meta( get_current_user_id(), $key, $modified_group, $group );
    }


    /**
     * @version 4
     * @param string $key
     * @param int $session_number
     * @param bool $toggle
     * @return bool|int
     */
    public static function update_group_session_status( string $key, $session_number, bool $toggle = false ) {

        // get current userid
        $user = get_user_by( 'id', get_current_user_id() );
        $user_id = $user->ID;
        $user_email = $user->user_email;

        // get group by key
        $modified_group = $group = self::get_group_by_key( $key );
        if ( empty( $modified_group )  ) {
            return false;
        }

        // test if userid is owner
        if ( intval( $group['owner'] ) !== intval( $user_id ) ) {
            // test if useremail is in coleaders
            if ( array_search( $user_email, $group['coleaders'] ) === false ) {
                dt_write_log( new WP_Error(__METHOD__, 'Did not find matching owner id or coleader id for group.'));
                return false;
            }
        }

        // update session and time
        if ( ! isset( $modified_group['session_'.$session_number] ) ) {
            dt_write_log( new WP_Error(__METHOD__, 'Did not find matching session number.'));
            return false;
        }

        /**
         * Toggle status
         * @note toggle allows removal of session information
         */
        if ( ! $modified_group['session_'.$session_number] ) {
            /* current session is false  = add session */
            $modified_group['session_'.$session_number] = true;
            $modified_group['session_'.$session_number.'_complete'] = current_time( 'mysql' );
            $modified_group['next_session'] = self::get_next_session( $modified_group );

        }  else if ( $modified_group['session_'.$session_number] && $toggle ) {
            /* current session is true, toggle is true = remove session */
            $modified_group['session_'.$session_number] = false;
            $modified_group['session_'.$session_number.'_complete'] = '';
            $modified_group['next_session'] = self::get_next_session( $modified_group );

        } else {
            /* current session is true, toggle is false = do nothing */
            return false;
        }

        self::filter_last_modified_to_now( $modified_group ); // add new timestamp

        return update_user_meta( $group['owner'], $group['key'], $modified_group, $group );
    }

    /**
     * @version 4
     * @param $key
     * @param $value
     * @return array|bool|int|mixed|WP_Error
     */
    public static function update_member_count( $key, $value ) {
        $modified_group = $group = self::get_current_user_group( $key );
        if ( is_wp_error( $group ) ) {
            return $group;
        }

        if ( empty( $value ) ) {
            return new WP_Error( __METHOD__, 'No value provided.');
        }

        if ( absint( $value ) < count( $group['coleaders_accepted'] ) ) {
            $value = count( $group['coleaders_accepted'] );
        }

        $modified_group['members'] = sanitize_text_field( wp_unslash( absint ($value ) ) );

        self::filter_last_modified_to_now( $modified_group ); // add new timestamp

        return update_user_meta( get_current_user_id(), $key, $modified_group, $group );
    }

    /**
     * @version 4
     * @param $key
     * @param $value
     * @return array|bool|int|mixed|WP_Error
     */
    public static function add_coleader( $key, $value ) {
        $modified_group = $group = self::get_current_user_group( $key );
        if ( is_wp_error( $group ) ) {
            return $group;
        }

        if ( empty( $value ) ) {
            return new WP_Error( __METHOD__, 'No value provided.');
        }

        if ( array_search( $value, $modified_group['coleaders'] ) ) {
            return new WP_Error( __METHOD__, 'Email already added.');
        }

        $modified_group['coleaders'][] = sanitize_email( wp_unslash( $value ) );

        sort( $modified_group['coleaders'] ); // reindex

        self::filter_last_modified_to_now( $modified_group );

        return update_user_meta( get_current_user_id(), $key, $modified_group, $group );
    }

    /**
     * @version 4
     * @param $email
     * @param $group_id
     * @param null $user_id
     * @return array
     */
    public static function delete_coleader( $email, $group_id, $user_id = null ) {

        if ( is_null( $user_id ) ) {
            $user_id = get_current_user_id();
        }

        $modified_group = $group = get_user_meta( $user_id, $group_id, true );
        $modified_group = self::verify_group_array_filter( $modified_group );

        if ( empty( $modified_group ) ) {
            return [ 'status' => 'Permission failure' ];
        }

        if ( empty( $email ) ) {
            return [ 'status' => 'Email failure' ];
        }

        if ( empty( $modified_group['coleaders'] ) ) {
            return [ 'status' => 'Coleader not present' ];
        }

        foreach ( $modified_group['coleaders'] as $key => $coleader ) {
            if ( $email === $coleader) {
                unset( $modified_group['coleaders'][$key] );
                unset( $modified_group['coleaders_accepted'][$key] );
                unset( $modified_group['coleaders_declined'][$key] );

                sort( $modified_group['coleaders'] ); //

                self::filter_last_modified_to_now( $modified_group ); // add new timestamp

                update_user_meta( $user_id, $group_id, $modified_group, $group );
                return [ 'status' => 'OK' ];
            }
        }
        return [ 'status' => 'Coleader not found' ];
    }

    /**
     * @version 4
     * @param $group
     * @return array
     */
    public static function filter_last_modified_to_now( &$group ) : array {
        $group['last_modified_date'] = time();
        return $group;
    }

}