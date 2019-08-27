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
    } // End __construct()

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
        $groups = $wpdb->get_results( 'SELECT * FROM wp_usermeta WHERE meta_key LIKE "zume_group_%"' );
        $result = [];
        foreach ( $groups as $group ){
            $fields = maybe_unserialize( $group->meta_value );
            if (isset( $fields["lat"] ) && !empty( $fields["lat"] ) && isset( $fields["lng"] ) && !empty( $fields["lng"] )){
                $result[] = [ $fields["lat"], $fields["lng"] ];
            } elseif (isset( $fields["ip_lat"] ) && !empty( $fields["ip_lat"] ) && isset( $fields["ip_lng"] ) && !empty( $fields["ip_lng"] ) ) {
                $result[] = [ $fields["ip_lat"], $fields["ip_lng"] ];
            }
        }

        return $result;
    }

    public function get_group_sizes(){
        global $wpdb;

        $groups = $wpdb->get_results( 'SELECT * FROM wp_usermeta WHERE meta_key LIKE "zume_group_%"' );
        $counts = [];
        foreach ($groups as $group){
            $fields = maybe_unserialize( $group->meta_value );
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

    public function get_group_steps(){
        global $wpdb;

        $groups = $wpdb->get_results( 'SELECT * FROM wp_usermeta WHERE meta_key LIKE "zume_group_%"' );
        $count = [
            "More than 4 members" => 0,
            "session_1" =>0,
            "session_2" =>0,
            "session_3" =>0,
            "session_4" =>0,
            "session_5" =>0,
            "session_6" =>0,
            "session_7" =>0,
            "session_8" =>0,
            "session_9" =>0,
            "session_10" =>0,
        ];
        foreach ($groups as $group){
            $fields = maybe_unserialize( $group->meta_value );
            if ( isset( $fields["members"] ) && intval( $fields["members"] )){
                $members = intval( $fields["members"] );
                if ( $members >= 4 ) {
                    $count["More than 4 members"] ++;
                }
                foreach ($count as $session => $value){
                    if ( isset( $fields[$session] ) && $fields[$session] == true){
                        $count[$session]++;
                    }
                }
            }
        }

        $result = [ [ "Session", "number completed", [ "role" => "annotation" ] ] ];
        foreach ( $count as $session => $number ){
            $result[] = [ $session, $number, $number ];
        }

        return $result;
    }

    public function initialize_analytics() {
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

    public function get_first_profile_id( $analytics) {
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

    public function get_results( $analytics, $profile_id) {
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

    public function return_results( $results) {
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
}
