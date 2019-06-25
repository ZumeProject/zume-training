<?php

class Zume_Site_Stats
{
    public static function temp_load_hook() {
        dt_write_log( 'FUNCTION RESPONSE' );
        dt_write_log( self::build() );
    }

    public static function build() {
        $report = [
            'hero_stats' => self::get_hero_stats(),
            'groups_progress_by_month' => self::get_groups_progress_by_month(),
            'people_progress_by_month' => self::get_people_progress_by_month(),
            'active_by_month' => self::get_active_by_month(),
            'members_per_group' => self::get_group_sizes(),
            'current_session_of_group' => self::get_groups_next_session(),
            'sessions_completed_by_groups' => self::get_sessions_completed_by_groups(),
            'logins_by_month' => self::get_logins_by_month(),
            'people_languages' => self::get_people_languages(),
            'country_list_by_group' => self::get_country_list_by_group(),
            'country_list_by_people' => self::get_country_list_by_people(),
            'group_coordinates' => self::get_group_coordinates(),
        ];


        $report['zume_stats_check_sum'] = md5( maybe_serialize( $report ) );
        $report['timestamp'] = current_time( 'mysql' );

        // store record until midnight
        $midnight = mktime( 0, 0, 0, date( 'n' ), date( 'j' ) +1, date( 'Y' ) );
        $the_time_until_midnight = $midnight - current_time( 'timestamp' );
        delete_transient( 'dt_zume_site_stats' );
        set_transient( 'dt_zume_site_stats', $report, $the_time_until_midnight );
        // end store record

        return $report;
    }

    public static function get_hero_stats() {
        $groups_meta = self::query_zume_group_records();

        $hero_stats = [
            'registered_people' => 0, // total people registered on Zume Project
            'engaged_people' => 0, // total members reported in groups who have finished at least one session
            'active_people' => 0, // count of members for sessions that finished the last 30 days
            'trained_people' => 0, // finished the 10 sessions

            'total_people_in_groups' => 0,

            'registered_groups' => 0,
            'engaged_groups' => 0, // groups that have at least finished 1 session
            'active_groups' => 0, // finished a session in the last 45 days
            'trained_groups' => 0, // finished the entire course

            'total_languages' => 0, // number of languages installed and available
            'total_countries' => 0, // number of countries groups or users are located in
            'hours_trained_as_group' => 0, // number of sessions * 2 = hours of training
            'hours_trained_per_person' => 0, // number of sessions * 2 = hours of training
            'groups_over_4_members' => 0,
        ];

        // Registered people
        $hero_stats['registered_people'] = self::query_registered_people();
        // languages
        $language = 0;
        $dir_scan = scandir( get_template_directory() . '/translations/' );
        if ( ! empty( $dir_scan ) ) {
            foreach ( $dir_scan as $file ) {
                if ( preg_match( '/.po/', $file ) ) {
                    $language++;
                }
            }
        }
        $hero_stats['total_languages'] = $language;

        $countries = [];

        // Loop group details
        foreach ($groups_meta as $v){
            $fields = Zume_Dashboard::verify_group_array_filter( $v );
            if ( isset( $fields["members"] ) && intval( $fields["members"] ) ){

                $members_in_group = intval( $fields["members"] );

                // engaged people
                if ( intval( $fields["next_session"] ) > 1 ) {
                    $hero_stats['engaged_people'] = $hero_stats['engaged_people'] + $members_in_group;
                    $hero_stats['engaged_groups'] = $hero_stats['engaged_groups'] + 1;
                }

                // active people
                $thirty_days_ago = date( 'Y-m-d H:i:s', strtotime( '-30 days' ) );
                if ( $fields['session_1_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_2_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_3_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_4_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_5_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_6_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_7_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_8_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_9_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }elseif ( $fields['session_10_complete'] > $thirty_days_ago ) {
                    $hero_stats['active_people'] = $hero_stats['active_people'] + $members_in_group;
                    $hero_stats['active_groups'] = $hero_stats['active_groups'] + 1;
                }

                // trained people
                if ( $fields['session_9'] || $fields['session_10'] ) {
                    $hero_stats['trained_people'] = $hero_stats['trained_people'] + $members_in_group;
                    $hero_stats['trained_groups'] = $hero_stats['trained_groups'] + 1;
                }

                // total people in groups
                $hero_stats['total_people_in_groups'] = $hero_stats['total_people_in_groups'] + $members_in_group;
                $hero_stats['registered_groups'] = $hero_stats['registered_groups'] + 1;

                // hours trained
                if ( $fields['session_1'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_2'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_3'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_4'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_5'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_6'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_7'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_8'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_9'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }
                if ( $fields['session_10'] ) {
                    $hero_stats['hours_trained_as_group'] = $hero_stats['hours_trained_as_group'] + 2;
                    $hero_stats['hours_trained_per_person'] = $hero_stats['hours_trained_per_person'] + ( 2 * $members_in_group );
                }

                // groups over 4 members
                if ( $members_in_group > 3 ) {
                    $hero_stats['groups_over_4_members'] = $hero_stats['groups_over_4_members'] + 1;
                }

                // countries of trained groups
                $user_location = $fields['raw_location'];
                $ip_location = $fields['ip_raw_location'];
                if ( ! empty( $user_location ) && ( $fields['session_9'] || $fields['session_10'] ) ) {
                    $response = Disciple_Tools_Google_Geocode_API::parse_raw_result( $user_location, 'country' );
                    if ( $response ) {
                        $countries[$response] = true;
                    }
                } elseif ( ! empty( $ip_location ) && ( $fields['session_9'] || $fields['session_10'] ) ) {
                    $response = Disciple_Tools_Google_Geocode_API::parse_raw_result( $ip_location, 'country' );
                    if ( $response ) {
                        $countries[$response] = true;
                    }
                }
            }
        }

        $hero_stats['total_countries'] = count( $countries );

        return $hero_stats;
    }

    public static function get_group_coordinates() {
        $groups_meta = self::query_zume_group_records();

        $result = [ [ 'number','number' ] ];

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

    public static function get_group_sizes() {
        $groups_meta = self::query_zume_group_records();

        $counts = [];

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

        return $result;
    }

    public static function get_group_steps_completed() {

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

        $result = [ [ 'Session', 'Groups', [ 'role' => 'annotation' ] ] ];

        foreach ( $count as $key => $value ) {
            $result[] = [ $key, $value, $value ];
        }

        return $result;
    }

    public static function get_sessions_completed_by_groups() {

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

        $result = [ [ 'Session', 'Groups', [ 'role' => 'annotation' ] ] ];

        foreach ( $count as $key => $value ) {
            $result[] = [ $key, $value, $value ];
        }

        return $result;
    }

    public static function get_groups_next_session() {

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

            $count[ intval( $fields['next_session'] ) ] = $count[ intval( $fields['next_session'] ) ] + 1;
        }

        $current_session_of_group = [
            [ 'Session', 'Groups', [ 'role' => 'annotation' ] ],
            [ 'Session 1', $count[1], $count[1] ],
            [ 'Session 2', $count[2], $count[2] ],
            [ 'Session 3', $count[3], $count[3] ],
            [ 'Session 4', $count[4], $count[4] ],
            [ 'Session 5', $count[5], $count[5] ],
            [ 'Session 6', $count[6], $count[6] ],
            [ 'Session 7', $count[7], $count[7] ],
            [ 'Session 8', $count[8], $count[8] ],
            [ 'Session 9', $count[9], $count[9] ],
            [ 'Session 10', $count[10], $count[10] ],
        ];

        return $current_session_of_group;
    }

    public static function get_country_list_by_group() {
        /**
         * Gets a list of countries from parsing geodata and counts number of groups
         * @return array
         */
        $groups_meta = self::query_zume_group_records();

        $country = [];

        foreach ($groups_meta as $group_meta){
            $fields = Zume_Dashboard::verify_group_array_filter( $group_meta );
            if ( isset( $fields['ip_raw_location'] ) && ! empty( $fields['ip_raw_location'] ) ) {
                $label = Disciple_Tools_Google_Geocode_API::parse_raw_result( $fields['ip_raw_location'], 'country' );
                if ( ! isset( $country[$label] ) ) {
                    $country[$label] = 0;
                }
                $country[$label] = $country[$label] + 1;
            }
        }

        $countries_by_groups = [
            [ 'Country', 'Groups' ],
        ];

        foreach ( $country as $key => $value ) {
            if ( '0' == $key ) {
                array_push( $countries_by_groups, [ '-', $value ] );
            } else {
                array_push( $countries_by_groups, [ $key, $value ] );
            }
        }

        return $countries_by_groups;
    }

    public static function get_country_list_by_people() {
        $user_results = self::query_raw_user_ip_locations();

        $country = [];

        array_filter( $user_results );

        foreach ($user_results as $user_result){
            if ( ! empty( $user_result ) ) {
                $user_result = maybe_unserialize( $user_result );
                $label = Disciple_Tools_Google_Geocode_API::parse_raw_result( $user_result, 'country' );
                if ( ! isset( $country[$label] ) ) {
                    $country[$label] = 0;
                }
                $country[$label] = $country[$label] + 1;
            }
        }

        $countries_by_users = [
            [ 'Country', 'People' ],
        ];

        foreach ( $country as $key => $value ) {
            if ( '0' == $key ) {
                array_push( $countries_by_users, [ '-', $value ] );
            } else {
                array_push( $countries_by_users, [ $key, $value ] );
            }
        }

        return $countries_by_users;
    }

    public static function get_logins_by_month() {

        $results = self::query_logins_by_month();

        $logins = [
            [ 'Month', 'Logins' ]
        ];

        foreach ( $results as $result ) {
            $logins[] = [ date( 'M', strtotime( $result['date'] ) ), intval( $result['total'] ) ];
        }

        return $logins;
    }

    public static function get_people_languages() {

        $results = self::query_languages_users();

        $people_languages = [
            [ 'Languages', 'Users', [ "role" => "annotation" ] ],
        ];

        foreach ( $results as $value ) {
            // translate to readable name
            $readable_language_name = self::language_codes_and_names( $value['language_code'] );

            $people_languages[] = [ $readable_language_name, intval( $value['people'] ), intval( $value['people'] ) ];
        }

        return $people_languages;
    }


    public static function get_groups_progress_by_month() {

        // Get dates YYYY-M
        $five_months_back = date( 'Y-n', strtotime( '-5 months -3 days' ) );
        $four_months_back = date( 'Y-n', strtotime( '-4 months -3 days' ) );
        $three_months_back = date( 'Y-n', strtotime( '-3 months -3 days' ) );
        $two_months_back = date( 'Y-n', strtotime( '-2 months -3 days' ) );
        $one_month_back = date( 'Y-n', strtotime( '-1 month -3 days' ) );
        $this_month = date( 'Y-n' );

        // build default date array
        $expected_dates = [
            $five_months_back => 0,
            $four_months_back => 0,
            $three_months_back => 0,
            $two_months_back => 0,
            $one_month_back => 0,
            $this_month => 0,
        ];

        // get data and format array
        $registered = self::combine_by_month_array( self::query_groups_registered_by_month() );
        $engaged = self::combine_by_month_array( self::query_groups_engaged_by_month() );
        $trained = self::combine_by_month_array( self::query_groups_trained_by_month() );

        // parse results against default so that we have an expected amount of array elements, if even with a 0 value
        $registered = wp_parse_args( $registered, $expected_dates );
        $engaged = wp_parse_args( $engaged, $expected_dates );
        $trained = wp_parse_args( $trained, $expected_dates );

        $stats = [
            [
                'Month',
                'Registered',
                'Engaged',
                'Trained',
                'Average'
            ],
            [
                date( 'M', strtotime( '-5 months -3 days' ) ),
                $registered[$five_months_back],
                $engaged[$five_months_back],
                $trained[$five_months_back],
                $average = round(array_sum([
                        $registered[$five_months_back],
                        $engaged[$five_months_back],
                        $trained[$five_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-4 months -3 days' ) ),
                $registered[$four_months_back],
                $engaged[$four_months_back],
                $trained[$four_months_back],
                $average = round(array_sum([
                        $registered[$four_months_back],
                        $engaged[$four_months_back],
                        $trained[$four_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-3 months -3 days' ) ),
                $registered[$three_months_back],
                $engaged[$three_months_back],
                $trained[$three_months_back],
                $average = round(array_sum([
                        $registered[$three_months_back],
                        $engaged[$three_months_back],
                        $trained[$three_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-2 months -3 days' ) ),
                $registered[$two_months_back],
                $engaged[$two_months_back],
                $trained[$two_months_back],
                $average = round(array_sum([
                        $registered[$two_months_back],
                        $engaged[$two_months_back],
                        $trained[$two_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-1 month -3 days' ) ),
                $registered[$one_month_back],
                $engaged[$one_month_back],
                $trained[$one_month_back],
                $average = round(array_sum([
                        $registered[$one_month_back],
                        $engaged[$one_month_back],
                        $trained[$one_month_back],
                ]) /6 )
            ],
            [
                date( 'M' ),
                $registered[$this_month],
                $engaged[$this_month],
                $trained[$this_month],
                $average = round(array_sum([
                        $registered[$this_month],
                        $engaged[$this_month],
                        $trained[$this_month],
                ]) /6 )
            ],
        ];

        return $stats;
    }

    public static function get_people_progress_by_month() {

        // Get dates YYYY-M
        $five_months_back = date( 'Y-n', strtotime( '-5 months -3 days' ) );
        $four_months_back = date( 'Y-n', strtotime( '-4 months -3 days' ) );
        $three_months_back = date( 'Y-n', strtotime( '-3 months -3 days' ) );
        $two_months_back = date( 'Y-n', strtotime( '-2 months -3 days' ) );
        $one_month_back = date( 'Y-n', strtotime( '-1 month -3 days' ) );
        $this_month = date( 'Y-n' );

        // build default date array
        $expected_dates = [
            $five_months_back => 0,
            $four_months_back => 0,
            $three_months_back => 0,
            $two_months_back => 0,
            $one_month_back => 0,
            $this_month => 0,
        ];

        // get data and format array
        $registered = self::combine_by_month_array( self::query_people_registered_by_month() );
        $engaged = self::combine_by_month_array( self::query_people_engaged_by_month() );
        $trained = self::combine_by_month_array( self::query_people_trained_by_month() );

        // parse results against default so that we have an expected amount of array elements, if even with a 0 value
        $registered = wp_parse_args( $registered, $expected_dates );
        $engaged = wp_parse_args( $engaged, $expected_dates );
        $trained = wp_parse_args( $trained, $expected_dates );

        $stats = [
            [
                'Month',
                'Registered',
                'Engaged',
                'Trained',
                'Average'
            ],
            [
                date( 'M', strtotime( '-5 months -3 days' ) ),
                $registered[$five_months_back],
                $engaged[$five_months_back],
                $trained[$five_months_back],
                $average = round(array_sum([
                        $registered[$five_months_back],
                        $engaged[$five_months_back],
                        $trained[$five_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-4 months -3 days' ) ),
                $registered[$four_months_back],
                $engaged[$four_months_back],
                $trained[$four_months_back],
                $average = round(array_sum([
                        $registered[$four_months_back],
                        $engaged[$four_months_back],
                        $trained[$four_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-3 months -3 days' ) ),
                $registered[$three_months_back],
                $engaged[$three_months_back],
                $trained[$three_months_back],
                $average = round(array_sum([
                        $registered[$three_months_back],
                        $engaged[$three_months_back],
                        $trained[$three_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-2 months -3 days' ) ),
                $registered[$two_months_back],
                $engaged[$two_months_back],
                $trained[$two_months_back],
                $average = round(array_sum([
                        $registered[$two_months_back],
                        $engaged[$two_months_back],
                        $trained[$two_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-1 month -3 days' ) ),
                $registered[$one_month_back],
                $engaged[$one_month_back],
                $trained[$one_month_back],
                $average = round(array_sum([
                        $registered[$one_month_back],
                        $engaged[$one_month_back],
                        $trained[$one_month_back],
                ]) /6 )
            ],
            [
                date( 'M' ),
                $registered[$this_month],
                $engaged[$this_month],
                $trained[$this_month],
                $average = round(array_sum([
                        $registered[$this_month],
                        $engaged[$this_month],
                        $trained[$this_month],
                ]) /6 )
            ],
        ];

        return $stats;
    }

    public static function get_active_by_month() {
        // Get dates YYYY-M
        $five_months_back = date( 'Y-n', strtotime( '-5 months -3 days' ) );
        $four_months_back = date( 'Y-n', strtotime( '-4 months -3 days' ) );
        $three_months_back = date( 'Y-n', strtotime( '-3 months -3 days' ) );
        $two_months_back = date( 'Y-n', strtotime( '-2 months -3 days' ) );
        $one_month_back = date( 'Y-n', strtotime( '-1 month -3 days' ) );
        $this_month = date( 'Y-n' );

        // build default date array
        $expected_dates = [
            $five_months_back => 0,
            $four_months_back => 0,
            $three_months_back => 0,
            $two_months_back => 0,
            $one_month_back => 0,
            $this_month => 0,
        ];

        // get data and format array
        $active_groups = self::combine_by_month_array( self::query_groups_active_by_month() );
        $active_people = self::combine_by_month_array( self::query_people_active_by_month() );

        // parse results against default so that we have an expected amount of array elements, if even with a 0 value
        $active_groups = wp_parse_args( $active_groups, $expected_dates );
        $active_people = wp_parse_args( $active_people, $expected_dates );

        $stats = [
            [
                'Month',
                'Groups',
                'People',
                'Average'
            ],
            [
                date( 'M', strtotime( '-5 months -3 days' ) ),
                $active_groups[$five_months_back],
                $active_people[$five_months_back],
                $average = round(array_sum([
                        $active_groups[$five_months_back],
                        $active_people[$five_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-4 months -3 days' ) ),
                $active_groups[$four_months_back],
                $active_people[$four_months_back],
                $average = round(array_sum([
                        $active_groups[$four_months_back],
                        $active_people[$four_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-3 months -3 days' ) ),
                $active_groups[$three_months_back],
                $active_people[$three_months_back],
                $average = round(array_sum([
                        $active_groups[$three_months_back],
                        $active_people[$three_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-2 months -3 days' ) ),
                $active_groups[$two_months_back],
                $active_people[$two_months_back],
                $average = round(array_sum([
                        $active_groups[$two_months_back],
                        $active_people[$two_months_back],
                ]) /6 )
            ],
            [
                date( 'M', strtotime( '-1 month -3 days' ) ),
                $active_groups[$one_month_back],
                $active_people[$one_month_back],
                $average = round(array_sum([
                        $active_groups[$one_month_back],
                        $active_people[$one_month_back],
                ]) /6 )
            ],
            [
                date( 'M' ),
                $active_groups[$this_month],
                $active_people[$this_month],
                $average = round(array_sum([
                        $active_groups[$this_month],
                        $active_people[$this_month],
                ]) /6 )
            ],
        ];

        return $stats;
    }

    public static function query_zume_group_records() {
        global $wpdb;
        $groups_meta = $wpdb->get_col(
            $wpdb->prepare( "
                  SELECT meta_value 
                  FROM $wpdb->usermeta 
                  WHERE meta_key LIKE %s LIMIT 10000", // @todo Returning all results, but at some point we should limit this
                $wpdb->esc_like( 'zume_group' ).'%'
            )
        );
        return $groups_meta;
    }

    public static function query_languages_users() {
        global $wpdb;
        $results = $wpdb->get_results("
            SELECT meta_value as language_code, count(umeta_id) as people 
            FROM $wpdb->usermeta 
            WHERE meta_key = 'zume_language' 
            GROUP BY meta_value
            ", ARRAY_A );
        return $results;
    }

    public static function query_raw_user_ip_locations() {
        global $wpdb;
        $raw_user_georesults = $wpdb->get_col(
            "
                  SELECT meta_value 
                  FROM wp_usermeta 
                  WHERE meta_key = 'zume_raw_location_from_ip'"
        );
        return $raw_user_georesults;
    }

    public static function query_groups_registered_by_month() {
        global $wpdb;
        $result = $wpdb->get_results(
            "
                    SELECT CONCAT( YEAR(created_date), '-', MONTH(created_date) ) as date, count(id) as total
                    FROM $wpdb->zume_logging
                    WHERE page = 'dashboard' AND action = 'create_group'
                    AND created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH)
                    GROUP BY MONTH(created_date)
                    ORDER BY YEAR(created_date), MONTH(created_date) LIMIT 6;
                  ", ARRAY_A
        );
        return $result;
    }

    public static function query_groups_engaged_by_month() {
        global $wpdb;
        $result = $wpdb->get_results(
            "
                    SELECT CONCAT( YEAR(created_date), '-', MONTH(created_date) ) as date, count(id) as total
                    FROM $wpdb->zume_logging
                    WHERE page = 'course' AND action = 'session_1' AND meta LIKE 'group%'
                    AND created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH)
                    GROUP BY MONTH(created_date)
                    ORDER BY YEAR(created_date), MONTH(created_date) LIMIT 6;
                  ", ARRAY_A
        );
        return $result;
    }

    public static function query_groups_trained_by_month() {
        global $wpdb;
        $result = $wpdb->get_results(
            "
                    SELECT CONCAT( YEAR(created_date), '-', MONTH(created_date) ) as date, count(id) as total
                    FROM $wpdb->zume_logging
                    WHERE page = 'course' AND ( action = 'session_9' OR action = 'session_10' ) AND meta LIKE 'group%'
                    AND created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH)
                    GROUP BY MONTH(created_date)
                    ORDER BY YEAR(created_date), MONTH(created_date) LIMIT 6;
                  ", ARRAY_A
        );
        return $result;
    }

    public static function query_logins_by_month() {
        global $wpdb;

        $results = $wpdb->get_results("
            SELECT CONCAT( YEAR(created_date), '-', MONTH(created_date) ) as date, count(id) as total
            FROM $wpdb->zume_logging
            WHERE page = 'login' AND action = 'logged_in'
            AND created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH)
            GROUP BY MONTH(created_date)
            ORDER BY YEAR(created_date), MONTH(created_date) 
            LIMIT 6
        ", ARRAY_A );

        return $results;
    }

    public static function query_groups_active_by_month() {
        global $wpdb;
        $result = $wpdb->get_results(
            "
                    SELECT CONCAT( YEAR(created_date), '-', MONTH(created_date) ) as date, count(id) as total
                    FROM $wpdb->zume_logging
                    WHERE page = 'course' AND action LIKE 'session_%' AND meta LIKE 'group%'
                    AND created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH)
                    GROUP BY MONTH(created_date)
                    ORDER BY YEAR(created_date), MONTH(created_date) LIMIT 6;
                  ", ARRAY_A
        );
        return $result;
    }

    public static function query_people_registered_by_month() {
        global $wpdb;
        $result = $wpdb->get_results(
            "
                    SELECT CONCAT( YEAR(created_date), '-', MONTH(created_date) ) as date, count(id) as total
                    FROM $wpdb->zume_logging
                    WHERE action = 'registered' 
                    AND created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH)
                    GROUP BY MONTH(created_date)
                    ORDER BY YEAR(created_date), MONTH(created_date) LIMIT 6;
                  ", ARRAY_A
        );
        return $result;
    }

    public static function query_people_engaged_by_month() {
        global $wpdb;
        $result = $wpdb->get_results(
            "
                    SELECT CONCAT( YEAR(a.created_date), '-', MONTH(a.created_date) ) as date, SUM(b.members) as total 
                    FROM $wpdb->zume_logging as a
                      INNER JOIN (
                                   SELECT *, REPLACE( meta, 'group_', '') as members FROM $wpdb->zume_logging
                                   WHERE page = 'course' AND action = 'session_1' AND meta LIKE 'group%'
                                   GROUP BY group_id, action, MONTH(created_date)
                                 ) as b
                        ON a.id=b.id
                    WHERE a.created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH)
                    GROUP BY MONTH(a.created_date)
                    ORDER BY YEAR(a.created_date), MONTH(a.created_date) LIMIT 6
                  ", ARRAY_A
        );
        return $result;
    }

    public static function query_people_trained_by_month() {
        global $wpdb;
        $result = $wpdb->get_results(
            "
                    SELECT CONCAT( YEAR(a.created_date), '-', MONTH(a.created_date) ) as date, SUM(b.members) as total 
                    FROM $wpdb->zume_logging as a
                      INNER JOIN (
                                   SELECT *, REPLACE( meta, 'group_', '') as members FROM $wpdb->zume_logging
                                   WHERE page = 'course' AND ( action = 'session_9' OR action = 'session_10' ) AND meta LIKE 'group%'
                                   GROUP BY group_id, action, MONTH(created_date)
                                 ) as b
                        ON a.id=b.id
                    WHERE a.created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH)    
                    GROUP BY MONTH(a.created_date)
                    ORDER BY YEAR(a.created_date), MONTH(a.created_date) LIMIT 6
                  ", ARRAY_A
        );
        return $result;
    }

    public static function query_people_active_by_month() {
        global $wpdb;
        $result = $wpdb->get_results(
            "
                    SELECT CONCAT( YEAR(a.created_date), '-', MONTH(a.created_date) ) as date, SUM(b.members) as total 
                    FROM $wpdb->zume_logging as a
                    INNER JOIN (
                        SELECT *, REPLACE( meta, 'group_', '') as members FROM $wpdb->zume_logging
                        WHERE meta LIKE 'group_%'
                        GROUP BY group_id, action, MONTH(created_date)
                        ) as b
                    ON a.id=b.id
                    WHERE a.created_date > DATE_SUB( CONCAT( YEAR(NOW()), '-', MONTH(NOW()), '-01'), INTERVAL 5 MONTH) 
                    GROUP BY MONTH(a.created_date)
                    ORDER BY YEAR(a.created_date), MONTH(a.created_date) LIMIT 6
                  ", ARRAY_A
        );
        return $result;
    }

    public static function query_registered_people() {
        /**
         * Returns count of all registered users of ZumeProject.com
         * @return int
         */
        $result = count_users();
        return $result['total_users'];
    }

    public static function query_engaged_people() {
        /**
         * Returns the number of engaged people. People who have completed at least session 1.
         * @return int
         */
        $groups_meta = self::query_zume_group_records();
        $count = 0;

        foreach ($groups_meta as $group_meta){
            $fields = Zume_Dashboard::verify_group_array_filter( $group_meta );
            if ( isset( $fields["members"] ) && intval( $fields["members"] )){
                if ( intval( $fields["next_session"] ) > 1 ) {
                    $count = $count + $fields["members"];
                }
            }
        }

        return $count;
    }

    private static function combine_by_month_array( $array ) {
        $new_array = [];
        foreach ( $array as $value ) {
            $new_array[$value['date']] = intval( $value['total'] );
        }
        return $new_array;
    }

    public static function language_codes_and_names( $code ) {

        $matching_names = [
            'ab' => 'Abkhazian',
            'aa' => 'Afar',
            'af' => 'Afrikaans',
            'ak' => 'Akan',
            'sq' => 'Albanian',
            'am' => 'Amharic',
            'ar' => 'Arabic',
            'an' => 'Aragonese',
            'hy' => 'Armenian',
            'as' => 'Assamese',
            'av' => 'Avaric',
            'ae' => 'Avestan',
            'ay' => 'Aymara',
            'az' => 'Azerbaijani',
            'bm' => 'Bambara',
            'ba' => 'Bashkir',
            'eu' => 'Basque',
            'be' => 'Belarusian',
            'bn' => 'Bengali',
            'bh' => 'Bihari languages',
            'bi' => 'Bislama',
            'bs' => 'Bosnian',
            'br' => 'Breton',
            'bg' => 'Bulgarian',
            'my' => 'Burmese',
            'ca' => 'Catalan, Valencian',
            'km' => 'Central Khmer',
            'ch' => 'Chamorro',
            'ce' => 'Chechen',
            'ny' => 'Chichewa, Chewa, Nyanja',
            'zh' => 'Chinese',
            'cu' => 'Church Slavonic, Old Bulgarian, Old Church Slavonic',
            'cv' => 'Chuvash',
            'kw' => 'Cornish',
            'co' => 'Corsican',
            'cr' => 'Cree',
            'hr' => 'Croatian',
            'cs' => 'Czech',
            'da' => 'Danish',
            'dv' => 'Divehi, Dhivehi, Maldivian',
            'nl' => 'Dutch, Flemish',
            'dz' => 'Dzongkha',
            'en' => 'English',
            'eo' => 'Esperanto',
            'et' => 'Estonian',
            'ee' => 'Ewe',
            'fo' => 'Faroese',
            'fj' => 'Fijian',
            'fi' => 'Finnish',
            'fr' => 'French',
            'ff' => 'Fulah',
            'gd' => 'Gaelic, Scottish Gaelic',
            'gl' => 'Galician',
            'lg' => 'Ganda',
            'ka' => 'Georgian',
            'de' => 'German',
            'ki' => 'Gikuyu, Kikuyu',
            'el' => 'Greek (Modern)',
            'kl' => 'Greenlandic, Kalaallisut',
            'gn' => 'Guarani',
            'gu' => 'Gujarati',
            'ht' => 'Haitian, Haitian Creole',
            'ha' => 'Hausa',
            'he' => 'Hebrew',
            'hz' => 'Herero',
            'hi' => 'Hindi',
            'ho' => 'Hiri Motu',
            'hu' => 'Hungarian',
            'is' => 'Icelandic',
            'io' => 'Ido',
            'ig' => 'Igbo',
            'id' => 'Indonesian',
            'ia' => 'Interlingua (International Auxiliary Language Association)',
            'ie' => 'Interlingue',
            'iu' => 'Inuktitut',
            'ik' => 'Inupiaq',
            'ga' => 'Irish',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'jv' => 'Javanese',
            'kn' => 'Kannada',
            'kr' => 'Kanuri',
            'ks' => 'Kashmiri',
            'kk' => 'Kazakh',
            'rw' => 'Kinyarwanda',
            'kv' => 'Komi',
            'kg' => 'Kongo',
            'ko' => 'Korean',
            'kj' => 'Kwanyama, Kuanyama',
            'ku' => 'Kurdish',
            'ky' => 'Kyrgyz',
            'lo' => 'Lao',
            'la' => 'Latin',
            'lv' => 'Latvian',
            'lb' => 'Letzeburgesch, Luxembourgish',
            'li' => 'Limburgish, Limburgan, Limburger',
            'ln' => 'Lingala',
            'lt' => 'Lithuanian',
            'lu' => 'Luba-Katanga',
            'mk' => 'Macedonian',
            'mg' => 'Malagasy',
            'ms' => 'Malay',
            'ml' => 'Malayalam',
            'mt' => 'Maltese',
            'gv' => 'Manx',
            'mi' => 'Maori',
            'mr' => 'Marathi',
            'mh' => 'Marshallese',
            'ro' => 'Moldovan, Moldavian, Romanian',
            'mn' => 'Mongolian',
            'na' => 'Nauru',
            'nv' => 'Navajo, Navaho',
            'nd' => 'Northern Ndebele',
            'ng' => 'Ndonga',
            'ne' => 'Nepali',
            'se' => 'Northern Sami',
            'no' => 'Norwegian',
            'nb' => 'Norwegian Bokmål',
            'nn' => 'Norwegian Nynorsk',
            'ii' => 'Nuosu, Sichuan Yi',
            'oc' => 'Occitan (post 1500)',
            'oj' => 'Ojibwa',
            'or' => 'Oriya',
            'om' => 'Oromo',
            'os' => 'Ossetian, Ossetic',
            'pi' => 'Pali',
            'pa' => 'Panjabi, Punjabi',
            'ps' => 'Pashto, Pushto',
            'fa' => 'Persian',
            'pl' => 'Polish',
            'pt' => 'Portuguese',
            'qu' => 'Quechua',
            'rm' => 'Romansh',
            'rn' => 'Rundi',
            'ru' => 'Russian',
            'sm' => 'Samoan',
            'sg' => 'Sango',
            'sa' => 'Sanskrit',
            'sc' => 'Sardinian',
            'sr' => 'Serbian',
            'sn' => 'Shona',
            'sd' => 'Sindhi',
            'si' => 'Sinhala, Sinhalese',
            'sk' => 'Slovak',
            'sl' => 'Slovenian',
            'so' => 'Somali',
            'st' => 'Sotho, Southern',
            'nr' => 'South Ndebele',
            'es' => 'Spanish, Castilian',
            'su' => 'Sundanese',
            'sw' => 'Swahili',
            'ss' => 'Swati',
            'sv' => 'Swedish',
            'tl' => 'Tagalog',
            'ty' => 'Tahitian',
            'tg' => 'Tajik',
            'ta' => 'Tamil',
            'tt' => 'Tatar',
            'te' => 'Telugu',
            'th' => 'Thai',
            'bo' => 'Tibetan',
            'ti' => 'Tigrinya',
            'to' => 'Tonga (Tonga Islands)',
            'ts' => 'Tsonga',
            'tn' => 'Tswana',
            'tr' => 'Turkish',
            'tk' => 'Turkmen',
            'tw' => 'Twi',
            'ug' => 'Uighur, Uyghur',
            'uk' => 'Ukrainian',
            'ur' => 'Urdu',
            'uz' => 'Uzbek',
            've' => 'Venda',
            'vi' => 'Vietnamese',
            'vo' => 'Volap_k',
            'wa' => 'Walloon',
            'cy' => 'Welsh',
            'fy' => 'Western Frisian',
            'wo' => 'Wolof',
            'xh' => 'Xhosa',
            'yi' => 'Yiddish',
            'yo' => 'Yoruba',
            'za' => 'Zhuang, Chuang',
            'zu' => 'Zulu'
        ];

        if ( isset( $matching_names[$code] ) ) {
            return $matching_names[$code];
        } else {
            return $code;
        }
    }
}
