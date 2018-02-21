<?php
/**
 * Zume_Stats
 *
 * @class Zume_Stats
 */
//require_once __DIR__ . '../../vendor/autoload.php';

class Zume_Stats{

    /**
     * Zume_Stats The single instance of Zume_Stats.
     * @var  object
     * @access  private
     * @since 0.1
     */
    private static $_instance = null;
    private static $key_location = __DIR__ .'/../../../../../analytics.json';

    /**
     * Main Zume_Stats Instance
     *
     * Ensures only one instance of Zume_Stats is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Stats instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    /**
     * Constructor function.
     * @access  public
     * @since   0.1
     */
    public function __construct() {
//		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_buddypress_styles_to_zume' ) );
        $this->get_coach_groups();
    } // End __construct()


    public function enqueue_buddypress_styles_to_zume() {

//		wp_register_style( 'zume_stats_style', ZUME_PLUGIN_URL . '/includes/css/zume-stats.css' );
//		wp_enqueue_style( 'zume_stats_stylesheet', ZUME_PLUGIN_URL . '/includes/css/zume-stats.css');
    }

    /**
     * get the number of verified users
     * @return mixed
     */
    public function get_user_count(){
        $users = count_users();
        return $users["total_users"];
    }

    public function get_group_locations(){
        global $wpdb;
        $latitudes = $wpdb->get_results( 'SELECT * FROM wp_bp_groups_groupmeta WHERE meta_key = "lat"', OBJECT );
        $longitudes = $wpdb->get_results( 'SELECT * FROM wp_bp_groups_groupmeta WHERE meta_key = "lng"', OBJECT );
        $address = $wpdb->get_results( 'SELECT * FROM wp_bp_groups_groupmeta WHERE meta_key = "address"', OBJECT );

        $a = [];
        foreach ( $latitudes as $lat ){
            $a[$lat->group_id]["lat"] = (int) $lat->meta_value;
        }
        foreach ( $longitudes as $lng ){
            $a[$lng->group_id]["lng"] = (int) $lng->meta_value;
        }
        foreach ( $address as $adr ){
            $a[$adr->group_id]["address"] = $adr->meta_value;
        }
        $result =[]; // ["address"]
        foreach ($a as $key => $val){
            if (isset( $val["lat"] ) && isset( $val["lng"] )){
                $result[] = [ $val["lat"], $val["lng"] ];
            }
        }

        return $result;

    }

    public function get_group_sizes(){
        global $wpdb;
        $groups = $wpdb->get_results( "SELECT group_id, COUNT(*) AS `num` FROM wp_bp_groups_members a INNER JOIN wp_bp_groups b ON a.group_id = b.id GROUP BY group_id" );
        $counts = [];
        foreach ($groups as $group){
            if ( !isset( $counts[ $group->num ] ) ){
                $counts[$group->num] = 1;
            } else {

                $counts[$group->num]++;

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

    public function get_group_steps(){
        global $wpdb;
        $groups = $wpdb->get_results( "SELECT id FROM wp_bp_groups" );
        $steps = $wpdb->get_results( "SELECT post_name, COUNT(*) AS `num` FROM wp_posts WHERE post_name LIKE '%step-complete%' GROUP BY post_name" );
        $number_ready_groups = $wpdb->get_results(
            "SELECT COUNT(*) as `groups`
            FROM (
                SELECT group_id
                FROM wp_bp_groups_members a INNER JOIN wp_bp_groups b ON a.group_id = b.id
                GROUP BY group_id
                HAVING COUNT(*) > 3
            ) T1"
        );

        $groups_ids = array_map(
            function($a){
                return $a->id;
            },
            $groups
        );
        $count = [
            "More than 4 members" => (int) $number_ready_groups[0]->groups,
            "session1" =>0,
            "session2" =>0,
            "session3" =>0,
            "session4" =>0,
            "session5" =>0,
            "session6" =>0,
            "session7" =>0,
            "session8" =>0,
            "session9" =>0,
            "session10" =>0,
        ];
        function ends_with( $haystack, $needle ){
            $length = strlen( $needle );
            return $length === 0 || ( substr( $haystack, -$length ) === $needle );
        }
        foreach ( $steps as $step ){
            $group_id = explode( '-', $step->post_name )[1];
            if ( in_array( $group_id, $groups_ids ) ){
                if ( ends_with( $step->post_name, "session-10" )){
                    $count["session10"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-2" ) ){
                    $count["session2"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-3" ) ){
                    $count["session3"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-4" ) ){
                    $count["session4"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-5" ) ){
                    $count["session5"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-6" ) ){
                    $count["session6"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-7" ) ){
                    $count["session7"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-8" ) ){
                    $count["session8"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-9" ) ){
                    $count["session9"] += $step->num;
                } elseif ( ends_with( $step->post_name, "session-1" )){
                    $count["session1"] += 1;
                }
            }
        }
        $result = [ [ "Session", "number completed", [ "role" => "annotation" ] ] ];
        foreach ( $count as $session => $number ){
            $result[] = [ $session, $number, $number ];
        }

        return $result;
    }




    public function initialize_analytics()
    {
        // Creates and returns the Analytics Reporting service object.

        // Use the developers console and download your service account
        // credentials in JSON format. Place them in this directory or
        // change the key file location if necessary.


        // Create and configure a new client object.
        $client = new Google_Client();
        $client->setApplicationName( "Hello Analytics Reporting" );
        $client->setAuthConfig( self::$key_location );
        $client->setScopes( [ 'https://www.googleapis.com/auth/analytics.readonly', 'https://www.googleapis.com/auth/youtube.force-ssl' ] );
        $analytics = new Google_Service_Analytics( $client );

        return $analytics;
    }

    public function get_first_profile_id($analytics) {
        // Get the user's first view (profile) ID.

        // Get the list of accounts for the authorized user.
        $accounts = $analytics->management_accounts->listManagementAccounts();

        if ( count( $accounts->getItems() ) > 0) {
            $items = $accounts->getItems();
            $first_account_id = $items[0]->getId();

            // Get the list of properties for the authorized user.
            $properties = $analytics->management_webproperties
                ->listManagementWebproperties( $first_account_id );

            if (count( $properties->getItems() ) > 0) {
                $items = $properties->getItems();
                $first_property_id = $items[0]->getId();

                // Get the list of views (profiles) for the authorized user.
                $profiles = $analytics->management_profiles
                    ->listManagementProfiles( $first_account_id, $first_property_id );

                if (count( $profiles->getItems() ) > 0) {
                    $items = $profiles->getItems();

                    // Return the first view (profile) ID.
                    return $items[0]->getId();

                } else {
                    throw new Exception( 'No views (profiles) found for this user.' );
                }
            } else {
                throw new Exception( 'No properties found for this user.' );
            }
        } else {
            throw new Exception( 'No accounts found for this user.' );
        }
    }

    public function get_results($analytics, $profile_id) {
        // Calls the Core Reporting API and queries for the number of sessions
        // for the last seven days.
        return $analytics->data_ga->get(
            'ga:' . $profile_id,
            '2010-01-01',
            'today',
            'ga:pageviews',
            array(
                'dimensions' => "ga:pagePath",
                'filters' => "ga:pagePath==/"
            )
        );
    }

    public function return_results($results) {
        // Parses the response from the Core Reporting API and prints
        // the profile name and total sessions.
        if ( count( $results->getRows() ) > 0 ) {

            // Get the profile name.
            $profile_name = $results->getProfileInfo()->getProfileName();

            // Get the entry for the first entry in the first row.
            $rows = $results->getRows();
            $sessions = $rows[0][1];

            return $sessions;
            // Print the results.
        } else {
            return "";
        }
    }

    public function analytics(){
        $analytics = $this->initialize_analytics();
        $profile = $this->get_first_profile_id( $analytics );
        $results = $this->get_results( $analytics, $profile );
//        return $results;
        return $this->return_results( $results );

    }


    public function get_client(){
        $client = new Google_Client();
        $client->setApplicationName( "Hello Analytics Reporting" );
        $client->setAuthConfig( self::$key_location );
        $client->setScopes( [ 'https://www.googleapis.com/auth/youtube.force-ssl' ] );
        $service = new Google_Service_YouTube( $client );

        return $service;
    }

    public function get_intro_video_views(){

        $service = $this->get_client();

        function videos_list_by_id( $service, $part, $params ) {
            $params = array_filter( $params );
            $response = $service->videos->listVideos(
                $part,
                $params
            );
            return $response;
        }

        $views_response = videos_list_by_id($service,
            'statistics',
            array( 'id' => 'EOdSAdJ6AhI' )
        );
        $views = $views_response->getItems();
        return $views[0]["statistics"]["viewCount"];
    }


    public function get_coach_groups(){
        global $wpdb;

        $zume_groups = $wpdb->get_results( "SELECT id, date_created FROM wp_bp_groups" );
        $address = $wpdb->get_results( 'SELECT * FROM wp_bp_groups_groupmeta m WHERE meta_key = "address" GROUP BY group_id', OBJECT );
        $states = $wpdb->get_results( 'SELECT * FROM wp_bp_groups_groupmeta m WHERE meta_key = "state"', OBJECT );
        $counties = $wpdb->get_results( 'SELECT * FROM wp_bp_groups_groupmeta m WHERE meta_key = "county"', OBJECT );
        $tracts = $wpdb->get_results( 'SELECT * FROM wp_bp_groups_groupmeta m WHERE meta_key = "tract"', OBJECT );
        $members_count = $wpdb->get_results( 'SELECT * FROM wp_bp_groups_groupmeta m WHERE meta_key = "total_member_count"', OBJECT );
        $leaders = $wpdb->get_results(
            "SELECT  p.id,   wp_users.user_email, wp_users.display_name
            FROM    wp_bp_groups p LEFT JOIN wp_users ON (p.creator_id=wp_users.ID)",
        ARRAY_A);
        $steps = $wpdb->get_results( "SELECT post_name, COUNT(*) AS `num` FROM wp_posts WHERE post_name LIKE '%step-complete%' GROUP BY post_name" );


        $groups = [];
        foreach ( $leaders as $leader ){
            $groups[$leader["id"]] = [ //the group id
                "email" => $leader["user_email"],
                "name" => $leader["display_name"],
                "group_id" => $leader["id"],
            ];
        }

        foreach ( $address as $a ){
            if (isset( $groups[ $a->group_id ] )){
                $groups[$a->group_id]["address"] = $a->meta_value;
            }
        }
        foreach ( $members_count as $a ){
            if (isset( $groups[ $a->group_id ] )){
                $groups[$a->group_id]["member_count"] = $a->meta_value;
            }
        }
        $codes = json_decode( file_get_contents( plugin_dir_path( __FILE__ ) . '../json/usa-tracts-file-directory.json' ) )->USA_tracts;
        foreach ( $states as $a ){
            if (isset( $groups[ $a->group_id ] )){
                if (isset( $a->meta_value ) && isset( $codes->{$a->meta_value} )){
                    $state = $codes->{$a->meta_value}->STUSAB;
                } else {
                    $state = $a->meta_value;
                }
                $groups[$a->group_id]["state"] = $state;
                $groups[$a->group_id]["stateCode"] = $a->meta_value;
            }
        }
        $county_codes = json_decode( file_get_contents( plugin_dir_path( __FILE__ ) . '../json/usa-county-codes.json' ) );
        foreach ( $counties as $a ){
            if (isset( $groups[ $a->group_id ] )){
                if (isset( $a->meta_value ) && isset( $groups[$a->group_id]["stateCode"] )){
                    foreach ( $county_codes as $code ){
                        if ( $code->STATE == $groups[$a->group_id]["stateCode"] && $code->COUNTY == $a->meta_value ){
                            $groups[$a->group_id]["county"] = $code->COUNTY_NAME;
                        }
                    }
                } else {
                    $groups[$a->group_id]["county"] = $a->meta_value;
                }
            }
        }
        foreach ( $tracts as $tract ){
            if ( isset( $groups[$tract->group_id] )){
                $groups[$tract->group_id]["tract"] = $tract->meta_value;
            }
        }
        foreach ( $steps as $step ){
            $exploded = explode( '-', $step->post_name );
            $group_id = $exploded[1];
            if ( !isset( $exploded[5] )){
                $session = $exploded[4];
            } else {
                $session = $exploded[5];
            }
            if ( isset( $groups[ $group_id ] ) ){
                if ( !isset( $groups[ $group_id ]["session"] )){
                    $groups[ $group_id ]["session"] = 0;
                }
                if ( (int) $session > (int) $groups[ $group_id ]["session"] ){
                    $groups[ $group_id ]["session"] = $session;
                }
            }
        }
        $group_array = [];
//        foreach ($groups as $group_id => $group_vals){
//            $group_array[] = $group_vals;
//        }

        foreach ( $zume_groups as $g ){
            if ( isset( $groups[$g->id] )){
                $groups[$g->id]['created'] = $g->date_created;
                $group_array[] = $groups[$g->id];
            }
        }

        return $group_array;
    }

}
