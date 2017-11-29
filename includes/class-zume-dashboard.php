<?php

/**
 * Zume_Dashboard
 *
 * @class Zume_Dashboard
 * @version	0.1
 * @since 0.1
 * @package	Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Zume_Dashboard {

    /**
     * Zume_Dashboard The single instance of Zume_Dashboard.
     * @var 	object
     * @access  private
     * @since 	0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Dashboard Instance
     *
     * Ensures only one instance of Zume_Dashboard is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Dashboard instance
     */
    public static function instance () {
        if ( is_null( self::$_instance ) )
            self::$_instance = new self();
        return self::$_instance;
    } // End instance()

    /**
     * Constructor function.
     * @access  public
     * @since   0.1
     */
    public function __construct () {
    } // End __construct()


    /**
     * Loads the display for Dashboard section "Your Groups"
     * @return mixed
     */
    public function display_your_groups() {
        echo $this->load_your_groups();
    }

    /**
     * Loads the display for Dashboard section "Your Groups"
     * @return mixed
     */
    protected function load_your_groups () {

        // Check for number of groups
        $user_groups = $this->zume_get_groups_of_user();

        // if user has no groups, then invite them to find a group or start a group
        if (empty($user_groups)) {
            echo '<p>Welcome! It looks like you have no group(s). </p>
                    <ul><li>If you are the first of your friends, try starting a group and then inviting friends. </li>
                    <li>If you were invited to Zúme, look to find your friend in our directory and connect with them. Then they can invite you to a group.</li>
                    </ul>
                    ';
            return;
        }

        foreach($user_groups as $one_group) {

            $group = groups_get_group($one_group->group_id); // gets group object
            $group_name = $group->name;

            echo $group_name . '<br>';
        }
    }

    /**
     * Loads the display for Dashboard section "Your Groups"
     * @return mixed
     */
    public function display_your_coach() {
        // Check for number of groups
        $user_groups = $this->zume_get_groups_of_user();


        foreach($user_groups as $one_group) {

            $group = groups_get_group($one_group->group_id); // gets group object
            $group_name = $group->name;

            if ( empty(groups_get_group_mods( $one_group->group_id ) )  ) {
                echo '<li> ';
                echo 'No coaches yet for ' . $group_name;
                echo '</li>';

            } else {
                $group_mods = groups_get_group_mods( $one_group->group_id );

                foreach ($group_mods as $mod_user) {
                    if (get_current_user_id() != $mod_user->user_id) {
                        echo '<li> ';
                        echo bp_core_fetch_avatar( array( 'html' => true, 'item_id' => $mod_user->user_id ) ) . '<br>';
                        echo bp_core_get_userlink($mod_user->user_id);
                        echo '<br> coach for ' . $group_name ;
                        echo '</li>';

                    }

                }

            }
        }

    }

    /**
     * Loads the display for Dashboard section "Your Groups"
     * @return mixed
     */
    public function get_coach_ids() {
        // Check for number of groups
        $user_groups = $this->zume_get_groups_of_user();
        $coaches = '';
        $i = 0;

        foreach($user_groups as $one_group) {

            $group_mods = groups_get_group_mods( $one_group->group_id );

            foreach ($group_mods as $mod_user) {
                if(!empty($mod_user->user_id)) {
                    $coaches .= $mod_user->user_id;

                }
            }
        }


        return $coaches;

    }

    /**
     * Builds the display for Dashboard section "Your Groups"
     * @return mixed
     */
    protected function zume_get_groups_of_user () {
        return bp_get_user_groups( bp_loggedin_user_id(), array( 'is_admin' => null, 'is_mod' => null, ) );
    }



}
