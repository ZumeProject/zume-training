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

if ( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Class Mapbox_Location_API
 */
if ( ! class_exists( 'Mapbox_Location_API' ) ) {
    class Mapbox_Location_API {

        public $key;

        public function __construct() {
            $this->key = get_option( 'mapbox-location-api.php' );
            
        }
        public function query_mapbox_api() {

        }

        public function parse_raw_result(){

        }
    }
}
