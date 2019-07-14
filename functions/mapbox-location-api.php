<?php
/**
 * Mapbox Location API
 *
 * @version  0.2
 *
 * @since 0.1     Initialize
 *        0.2     Added class exists protection
 *
 */

//if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



/**
 * Class Mapbox_Location_API
 */
if ( ! class_exists( 'Mapbox_Location_API' ) ) {
    class Mapbox_Location_API {

        public $key;
        private $options;

        /** Singleton @var null  */
        private static $_instance = null;
        public static function instance()
        {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        } // End Singleton

        public function __construct() {
            $this->key = get_option( 'mapbox-location-api.php' );

            if ( is_admin() ) {
                add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
                add_action( 'admin_init', array( $this, 'page_init' ) );
            }

        }

        public static function get_key() {
            $key = get_option( 'mapbox_location_key' );
            return $key['mapbox_api_key'];
        }

        public function query_mapbox_with_lnglat( $longitude, $latitutde ) {
            $mapbox_key = self::get_key();
            $json = file_get_contents('https://api.mapbox.com/geocoding/v5/mapbox.places/'. $longitude. ',' . $latitutde . '.json?access_token=' . $mapbox_key  );
            dt_write_log($json);
            return $json;
        }

        public function query_mapbox_with_address( $address ) {
            $mapbox_key = self::get_key();

            $address = urlencode( $address );

            $json = file_get_contents('https://api.mapbox.com/geocoding/v5/mapbox.places/'. $address . '.json?access_token=' . $mapbox_key  );
            dt_write_log($json);
            return $json;
        }

        public function parse_raw_result(){

        }


        /******************
         * OPTIONS PAGE
         ******************/
        public function add_plugin_page() {
            // This page will be under "Settings"
            add_options_page(
                'Settings Admin',
                'Mapbox API Key',
                'manage_options',
                'mapbox-location-key',
                array( $this, 'create_admin_page' )
            );
        }
        public function create_admin_page() {
            // Set class property
            $this->options = get_option( 'mapbox_location_key' );
            ?>
            <div class="wrap">

                <form method="post" action="options.php">
                    <?php
                    // This prints out all hidden setting fields
                    settings_fields( 'mabox_option_group' );
                    do_settings_sections( 'mapbox-location-key' );
                    submit_button();
                    ?>
                </form>
            </div>
            <?php
        }
        public function page_init() {
            register_setting(
                'mabox_option_group', // Option group
                'mapbox_location_key', // Option name
                array( $this, 'sanitize' ) // Sanitize
            );

            add_settings_section(
                'setting_section_id', // ID
                'Mapbox API Key', // Title
                array( $this, 'print_section_info' ), // Callback
                'mapbox-location-key' // Page
            );

            add_settings_field(
                'mapbox_api_key',
                'API Key',
                array( $this, 'mapbox_api_key_callback' ),
                'mapbox-location-key',
                'setting_section_id'
            );

        }
        public function sanitize( $input ) {
            $new_input = array();
            if ( isset( $input['mapbox_api_key'] ) ) {
                $new_input['mapbox_api_key'] = sanitize_text_field( $input['mapbox_api_key'] );
            }
            return $new_input;
        }
        public function print_section_info() {
            print 'Enter the api key you received from <a href="https://mapbox.com/" target="_blank">mapbox.com</a>:';
//            dt_write_log(Mapbox_Location_API::instance()->query_mapbox_with_lnglat( -118.521456965901, 33.9018913203336 ) );
            dt_write_log(Mapbox_Location_API::instance()->query_mapbox_with_address( '9134 Woodland Dr. Highlands Ranch, CO' ) );
        }
        public function mapbox_api_key_callback() {
            printf(
                '<input type="text" class="regular-text" id="mapbox_api_key" name="mapbox_location_key[mapbox_api_key]" value="%s" />',
                isset( $this->options['mapbox_api_key'] ) ? '*******' . substr( $this->options['mapbox_api_key'], -4, 4 ) : ''
            );
        }
        /** END OPTIONS PAGE */
    }
    Mapbox_Location_API::instance();
}

