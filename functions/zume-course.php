<?php

/**
 * Zúme Course Core
 *
 * @class Disciple_Tools_Admin_Menus
 * @version    0.1
 * @since 0.1
 * @package    Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

class Zume_Course {

    /**
     * Disciple_Tools_Admin_Menus The single instance of Disciple_Tools_Admin_Menus.
     * @var    object
     * @access  private
     * @since    0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Course Instance
     *
     * Ensures only one instance of Disciple_Tools_Admin_Menus is loaded or can be loaded.
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
        add_shortcode( 'session_nine_plan', array( $this, 'session_nine_plan' ) );
        add_action( "admin_post_session_nine_plan", array( $this, "session_nine_plan_submit" ) );
        $this->session_nine_labels = array(
            "I will share My Story [Testimony] and God’s Story [the Gospel] with the following individuals:",
            "I will invite the following people to begin an Accountability Group with me:",
            "I will challenge the following people to begin their own Accountability Groups and train them how to do it:",
            "I will invite the following people to begin a 3/3 Group with me:",
            "I will challenge the following people to begin their own 3/3 Groups and train them how to do it:",
            "I will invite the following people to participate in a 3/3 Hope or Discover Group [see Appendix]:",
            "I will invite the following people to participate in Prayer Walking with me:",
            "I will equip the following people to share their story and God’s Story and make a List of 100 of the people in their relational network:",
            "I will challenge the following people to use the Prayer Cycle tool on a periodic basis:",
            "I will use the Prayer Cycle tool once every [days / weeks / months].",
            "I will Prayer Walk once every [days / weeks / months].",
            "I will invite the following people to be part of a Leadership Cell that I will lead:",
            "I will encourage the following people to go through this Zúme Training course:",
            "Other commitments:"
        );


    } // End __construct()


    /**
     * Zúme Pre Content Load
     * @access  public
     * @since   0.1
     */
    public function zume_pre_content_load() {

        /*** VARIABLES ***/

        // Set variables
        $user_id  = get_current_user_id();
        $meta_key = 'zume_active_group';

        // Set variable for session
        if ( isset( $_GET['id'] ) ) {
            $zume_session = sanitize_key( wp_unslash( $_GET['id'] ) );
        } else {
            $zume_session = '1';
        }

        $group_id = '';

        if ( isset( $_GET['group_id'] ) && ! empty( $_GET['group_id'] ) ) {
            if ( groups_is_user_member( $user_id, sanitize_key( wp_unslash( $_GET['group_id'] ) ) ) ) {
                $group_id = sanitize_key( wp_unslash( $_GET['group_id'] ) );
            }
        }
        if ( empty( $group_id ) && ! empty( $_POST[ $meta_key ] ) ) {
            if ( groups_is_user_member( $user_id, sanitize_key( wp_unslash( $_POST[ $meta_key ] ) ) ) ) {
                $group_id = sanitize_key( wp_unslash( $_POST[ $meta_key ] ) );
            }
        }
        $group_id_user_meta = get_user_meta( $user_id, $meta_key, true );
        if ( empty( $group_id ) && $group_id_user_meta ) {
            if ( groups_is_user_member( $user_id, $group_id_user_meta ) ) {
                $group_id = $group_id_user_meta;
            }
        }

        //look at user's buddy press groups
        if ( empty( $group_id ) || ( empty( $_POST[ $meta_key ] ) && isset( $_GET["switch_zume_group"] ) ) ) {
            $user_groups = bp_get_user_groups( $user_id, array( 'is_admin' => null, 'is_mod' => null, ) );
            if ( count( $user_groups ) == 1 ) {
                $group_id = $user_groups[0]->group_id;
            } elseif ( count( $user_groups ) > 1 ) {
                echo 'More than one group<br>';
                echo '<form action=""  method="POST" >Which group do you prefer?<br>';

                foreach ( $user_groups as $agroup ) {

                    // Get group name from group id
                    $group_id   = $agroup->group_id;
                    $group      = groups_get_group( $group_id ); // gets group object
                    $group_name = $group->name;

                    // Create radio button
                    echo '<div class="radio">';
                    echo '<label><input type="radio" name="' . esc_attr( $meta_key ) . '" value="' . esc_attr( $group_id ) . '">' . esc_html( $group_name ) . ' </label>';
                    echo '</div>';

                }

                echo '<button type="submit" class="btn button">Select</button>';
                echo '</form>';

                return;
            }
        }

        if ( empty( $group_id ) ) {
            //user has no group.
            echo '<h3>You do not have a group selected.</h3>
					<p>To create or select one go here: <a href="' . esc_attr( get_site_url() ) . '/dashboard">Dashboard</a></p>
					<p>To see the Zúme course overview go here: <a href="' . esc_attr( get_site_url() ) . '/overview">Overview</a></p>';
            if ( isset( $_GET['group_id'] ) ) {
                $group = groups_get_group( sanitize_key( wp_unslash( $_GET['group_id'] ) ) );
                echo 'To see the page of the group in the link and request membership click: <a href="' . esc_attr( bp_get_group_permalink( $group ) ) . '">Here</a></p>';
            }

            return;
        } else {
            // Update or Add meta value with new_group_id
            update_user_meta( $user_id, $meta_key, $group_id );

            // Load Zúme content with variables
            $this->content_loader( $zume_session, $group_id );
        }

        /**
         * Create switch group link
         */
        $user_groups = bp_get_user_groups( $user_id, array(
            'is_admin' => null,
            'is_mod'   => null,
        ) ); // Check for number of groups

        // Check to select group
        if ( count( $user_groups ) > 1 ) {
            if ( get_user_meta( $user_id, $meta_key, true ) ) {

                $group_id   = get_user_meta( $user_id, $meta_key, true );
                $group      = groups_get_group( $group_id ); // gets group object
                $group_name = $group->name;

                echo '<div class="row columns"><div class="small-centered center"><br><br>(' . esc_html( $group_name ) . ')<br><a href="' . esc_attr( get_permalink() ) . '?id=' . esc_attr( $zume_session ) . '&switch_zume_group=true" >switch group</a></div></div>';
            }
        }
    }

    /**
     * Zúme Content Loader
     * @return mixed
     */
    public function content_loader( $session = '1', $group_id ) {

        // Check for highest session completed and redirect
        $next_session = zume_group_next_session( $group_id );
        if ( ! is_null( $next_session ) && $session > $next_session ) {
            $session = $next_session;
        }

        zume_course_loader( $session, $group_id ); // prints

    }

    /**
     * Pulls the content from the pages database and prints
     */
    public function zume_course_loader( $session, $group_id ) {

        $session_title = 'Session ' . $session . ' Course';
        $page_object   = get_page_by_title( $session_title, OBJECT, 'page' );

        $session  = (int) $session;
        $group_id = (int) $group_id;

        $prev_link = null;
        $next_link = null;
        if ( $session > 1 ) {
            $prev_link = '?id=' . ( $session - 1 ) . '&group_id=' . $group_id;
        }
        $group_next_session = zume_group_next_session( $group_id );
        if ( ! is_null( $group_next_session ) && ( $session + 1 ) <= $group_next_session ) {
            $next_link = '?id=' . ( $session + 1 ) . '&group_id=' . $group_id;
        }

        if ( ! empty( $page_object ) || ! empty( $page_object->post_content ) ) {

            $session_title = "Session $session";
            if ( $session == 10 ) {
                $session_title = "Session 10 — Advanced Training";
            }

            $this->jquery_steps( $group_id, $session ); // prints
            echo '<div class="row columns center">';
            if ( ! is_null( $prev_link ) ) {
                echo '<a href="' . esc_attr( $prev_link ) . '" title="Previous session"><span class="chevron chevron--left"><span>Previous session</span></span></a> ';
            }
            echo '<h2 style="color: #21336A; display: inline">' . esc_html( $session_title ) . '</h2>';
            if ( ! is_null( $next_link ) ) {
                echo ' <a href="' . esc_attr( $next_link ) . '" title="Next session"><span class="chevron chevron--right"><span>Next session</span></span></a>';
            }
            echo '</div>';
            echo '<br><div id="session' . esc_attr( $session . '-' . $group_id ) . '" class="course-steps">';

            if ( zume_group_highest_session_completed( $group_id ) < $session ) {
                $this->attendance_step( $group_id, $session ); // prints
            } // add attendance as the first step

            $post_content = $page_object->post_content . '';
            $post_content = str_replace( "[session_nine_plan]", $this->session_nine_plan(), $post_content );

            // @codingStandardsIgnoreLine
            echo $post_content;
            echo '</div>';

            echo '<div class="js-group-info" data-group-permalink="' . esc_attr( bp_get_group_permalink( groups_get_group( $group_id ) ) ) . '"></div>';

        } else {
            echo 'Please republish "' . esc_html( $session_title ) . '" with content for this section in the pages administration area.';
        }
    }







    public function session_nine_plan( $attr = null ) {
        $form = '<form id="session_nine_plan" action="/wp-admin/admin-post.php" method="post">';
        foreach ( $this->session_nine_labels as $index => $label ) {
            $form = $form . '<label style="font-size:16px">' . $label . '</label>';
            $form = $form . '<textarea name="field_' . $index . '"></textarea>';
        }

        $form = $form . wp_nonce_field( 'session_nine_plan' ) . '
		<input type="hidden" name="action" value="session_nine_plan">
		<input class="button" type="submit" name="submit" value="submit">
		</form>
		';

        return $form;
    }


    public function session_nine_plan_submit() {
        if ( isset( $_POST["_wpnonce"] ) && wp_verify_nonce( sanitize_key( $_POST["_wpnonce"] ), 'session_nine_plan' ) ) {
            $user         = wp_get_current_user();
            $user_id      = get_current_user_id();
            $group_id     = get_user_meta( $user_id, "zume_active_group", true );
            $group        = groups_get_group( $group_id );
            $fields       = [];
            $email_fields = "--------------------------------- \n";
            foreach ( $_POST as $key => $value ) {
                if ( strpos( $key, 'field_' ) !== false ) {
                    $index            = str_replace( "field_", "", $key );
                    $label            = $this->session_nine_labels[ (int) $index ];
                    $fields[ $label ] = $value;
                    $email_fields     .= '- ' . str_replace( "_", " ", $label ) . "\n";
                    $email_fields     .= '> ' . $value . "\n\n";
                }
            }


            $key = "group_" . $group_id . "-session_9";
            update_user_meta( $user_id, $key, $fields );


            $args = array(
                'tokens' => array(
                    "three_month_plan" => $email_fields
                )
            );
            bp_send_email( 'your_three_month_plan', $user_id, $args );

            $coaches = $this->zume_get_coach_ids_in_group( $group_id );

            $user_plan = "--------------------------------- \n";
            $user_plan .= "Here is the plan for: " . ( isset( $user->display_name ) ? $user->display_name : "[user]" ) . ", in group: " . $group->name . "\n";
            $user_plan .= $email_fields;
            $args      = array(
                'tokens' => array(
                    "three_month_plan" => $user_plan
                )
            );
            foreach ( $coaches as $coach_id ) {
                bp_send_email( 'your_three_month_plan', $coach_id, $args );
            }
            bp_core_add_message( "Your plan was submitted successfully" );
        }

        if (isset( $_POST["_wp_http_referer"] )) {
            return wp_redirect( sanitize_text_field( wp_unslash( $_POST["_wp_http_referer"] ) ) );
        } else {
            return wp_redirect( "/" );
        }
    }


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
        return false;

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
        if( '' == $group_meta[ $session_date_key ] ) {
	        $group_meta[ $session_date_key ] = current_time( 'mysql' );
        }

        // update next session
        $next_session = self::get_next_session( $group_meta );
        $group_meta['next_session'] = $next_session;

        update_user_meta( $user_id, $group_key, $group_meta, $group_previous );

        zume_write_log( $group_meta );

        return true;

    }

}
