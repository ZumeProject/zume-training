<?php

/**
 * Zume_Welcome_Messages
 *
 * @class Zume_Welcome_Messages
 * @version 0.1
 * @since 0.1
 * @author Chasm.Solutions & Kingdom.Training
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
        // check for and get user message level
        $targeted_message = 0;

        // build messages
        $message = [
            'new' => [
                'type' => 'new',
                'name' => 'new_registration',
                'title' => __( 'Welcome!', 'zume' ),
                'message' => __( 'Praise God for your interest in sharpening your disciple-making!', 'zume' )
            ],
        ];

        // new, no group
        if ( 0 == $targeted_message ) {
            return $message['new'];
        }

        // @todo targeted messages

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
        // group, complete

    }

}














