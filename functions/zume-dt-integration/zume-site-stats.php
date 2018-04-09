<?php

class Zume_Site_Stats
{
    public static function temp_load_hook() {
        dt_write_log( 'FUNCTION RESPONSE' );
        dt_write_log( self::get_people_languages() );
    }

    private static function query_zume_group_records() {
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

    public static function get_group_sizes(){
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

        dt_write_log( $result );

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

        $result = [ [ 'Session', 'Groups', [ 'role' => 'annotation' ] ] ];

        foreach ( $count as $key => $value ) {
            $result[] = [ $key, $value, $value ];
        }

        return $result;
    }

    public static function get_sessions_completed_by_groups(){

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

    /**
     * Returns count of all registered users of ZumeProject.com
     * @return int
     */
    public static function get_registered_people(){
        $result = count_users();
        return $result['total_users'];
    }

    /**
     * Returns the number of engaged people. People who have completed at least session 1.
     * @return int
     */
    public static function get_engaged_people() {
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

    public static function hero_stats() {
        $groups_meta = self::query_zume_group_records();

        $hero_stats = [
            'engaged_people' => 0, // total members reported in groups who have finished at least one session
            'active_people' => 0, // count of members for sessions that finished the last 30 days
            'trained_people' => 0, // finished the 10 sessions
            'total_people_registered' => 0,
            'total_people_in_groups' => 0,
            'engaged_groups' => 0, // groups that have at least finished 1 session
            'active_groups' => 0, // finished a session in the last 45 days
            'trained_groups' => 0, // finished the entire course
            'total_groups_registered' => 0, // number of registered groups that have finished session 1
            'total_languages' => 0, // number of languages installed and available
            'total_countries' => 1, // number of countries groups or users are located in
            'hours_trained_as_group' => 0, // number of sessions * 2 = hours of training
            'hours_trained_per_person' => 0, // number of sessions * 2 = hours of training
            'groups_over_4_members' => 0,
        ];

        // Registered people
        $hero_stats['total_people_registered'] = Zume_Site_Stats::get_registered_people();
        $hero_stats['total_languages'] = count( pll_languages_list() );

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
                $hero_stats['total_groups_registered'] = $hero_stats['total_groups_registered'] + 1;

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
            }
        }

        return $hero_stats;
    }

    public static function get_people_languages() {
        global $wpdb;
        $results = $wpdb->get_results("
            SELECT meta_value as language_code, count(umeta_id) as people 
            FROM $wpdb->usermeta 
            WHERE meta_key = 'zume_language' 
            GROUP BY meta_value
            ", ARRAY_A );

        $people_languages = [
            [ 'Languages', 'Users', [ "role" => "annotation" ] ],
        ];

        $registered_people = self::get_registered_people();

        if ( empty( $results ) ) {
            $people_languages[] = [ 'English', $registered_people, $registered_people ];
            return $people_languages;
        }

        $non_english = 0;
        foreach( $results as $value ) {
            if( ! ( $value['language_code'] == 'en' ) ) {
                // translate to readable name
                $readable_language_name = self::language_codes_and_names( $value['language_code'] );

                $people_languages[] = [ $readable_language_name, intval( $value['people'] ), intval($value['people'] ) ];

                $non_english = $non_english + $value['people'];
            }
        }

        $english = $registered_people - $non_english;
        $people_languages[] = [ 'English', intval( $english ), intval( $english ) ];

        return $people_languages;

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
