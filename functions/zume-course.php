<?php

/**
 * Zúme Course Core
 *
 * @class Zume_Admin_Menus
 * @version    0.1
 * @since 0.1
 * @package    Disciple_Tools
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

class Zume_Course {

    /**
     * Zume_Admin_Menus The single instance of Zume_Admin_Menus.
     * @var    object
     * @access  private
     * @since    0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Course Instance
     *
     * Ensures only one instance of Zume_Admin_Menus is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Course instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    } // End instance()

    private $session_nine_labels = array();

    /**
     * Constructor function.
     * @access  public
     * @since   0.1
     */
    public function __construct() {
    } // End __construct()

    public static function get_next_session( $group_meta ) {

        if ( $group_meta['session_1'] == false ) {
            return 1;
        }
        if ( $group_meta['session_2'] == false ) {
            return 2;
        }
        if ( $group_meta['session_3'] == false ) {
            return 3;
        }
        if ( $group_meta['session_4'] == false ) {
            return 4;
        }
        if ( $group_meta['session_5'] == false ) {
            return 5;
        }
        if ( $group_meta['session_6'] == false ) {
            return 6;
        }
        if ( $group_meta['session_7'] == false ) {
            return 7;
        }
        if ( $group_meta['session_8'] == false ) {
            return 8;
        }
        if ( $group_meta['session_9'] == false ) {
            return 9;
        }
        if ( $group_meta['session_10'] == false ) {
            return 10;
        }
        if ( $group_meta['session_10'] == true ) {
            return 11;
        }
        return 0;

    }

    public static function update_session_complete( $group_key, $session_id, $user_id = '' ) {
        if ( empty( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        $group_meta = get_user_meta( $user_id, $group_key, true );
        if ( empty( $group_meta ) ) {
            return false;
        }

        // update current session complete
        $group_previous = $group_meta;
        $session_key = 'session_' . $session_id;
        $group_meta[ $session_key ] = true;
        $session_date_key = $session_key . '_complete';
        if ( '' == $group_meta[ $session_date_key ] ) {
            $group_meta[ $session_date_key ] = current_time( 'mysql' );
        }

        // update next session
        $next_session = self::get_next_session( $group_meta );
        $group_meta['next_session'] = $next_session;

        update_user_meta( $user_id, $group_key, $group_meta, $group_previous );

        return true;

    }

    public static function get_video_by_key( $meta_key, $player = true ) {
        // get language
        $current_lang = zume_current_language();
        // get custom post type by language title
        $page = get_page_by_title( $current_lang, OBJECT, 'zume_video' );
        if ( ! $page ) {
            return '';
        }
        $video_id = get_post_meta( $page->ID, $meta_key, true );
        if ( ! $video_id ) {
            return '';
        }
        if ( ! $player ) { // if not the player, then return just the vimeo url.
            return 'https://vimeo.com/' . $video_id;
        }
        return 'https://player.vimeo.com/video/' . $video_id;
    }

    public static function get_download_by_key( $meta_key ) {
        // get language
        $current_lang = zume_current_language();
        // get custom post type by language title
        $page = get_page_by_title( $current_lang, OBJECT, 'zume_video' );
        if ( ! $page ) {
            return '';
        }
        $video_id = get_post_meta( $page->ID, $meta_key, true );
        if ( ! $video_id ) {
            return '';
        }
        return 'https://player.vimeo.com/video/' . $video_id;
    }
}
