<?php

/**
 * Zume_Welcome_Messages
 *
 * @class Zume_Welcome_Messages
 * @version 0.1
 * @since 0.1
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

class Zume_Welcome_Messages {

    /**
     * Zume_Welcome_Messages The single instance of Zume_Welcome_Messages.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Welcome_Messages Instance
     *
     * Ensures only one instance of Zume_Welcome_Messages is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Welcome_Messages instance
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

    public static function get_encouragement() {

        // get cached current message
        $current_message = get_user_meta( get_current_user_id(), 'zume_message', true );
        if ( ! $current_message ) {
            $current_message = [
                'key' => 'new',
                'date' => current_time( 'mysql' ),
            ];
            update_user_meta( get_current_user_id(), 'zume_message', $current_message );
            $current_message = get_user_meta( get_current_user_id(), 'zume_message', true );
        }

        // check if you need to recalulate
        if ( ! $current_message['date'] > date( "Y-m-j H:i:s", strtotime( '1 day ago' ) ) ) {
            return self::get_message_text( $current_message['key'] );
        }

        // calculate
        $message = self::calculate_message();

        return $message;
    }

    public static function calculate_message( $key = 'new' ) { // @todo build the decision tree for which message to deliver
        // group, no sessions
        // group, no address (encourage to participate in global plan)
        // group, < 3 members
        // group, first session complete
        // >1 group
        // group, next session 2
        // group, next session 3
        // group, next session 4
        // group, next session 5
        // group, next session 6
        // group, next session 7
        // group, next session 8
        // group, next session 9
        // group, next session 10


//        $next_session = Zume_Course::get_next_session();
        // group, complete
        return self::get_message_text( $key = 'new' );
    }

    public static function get_message_text( $key = 'new' ) { // @todo create the different messages for the different situations.
        $message = [];
        $message['new'] = [
                'type' => 'new',
                'name' => 'new_registration',
                'title' => __( 'Welcome!', 'zume' ),
                'message' => __( 'I want to make disciples who multiply!', 'zume' )
        ];


        return $message[$key];
    }


}














