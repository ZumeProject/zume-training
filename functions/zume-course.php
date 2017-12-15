<?php

/**
 * Zúme Course Core
 *
 * @class Zume_Admin_Menus
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

    public static function get_video_by_key( $meta_key ) {
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
