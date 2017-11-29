<?php

/**
 * Zume Coaches Class
 *
 * @class Zume_Coaches
 * @version	0.1
 * @since 0.1
 * @package	Zume
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Zume_Coaches {

    /**
     * Zume_Coaches The single instance of Zume_Coaches.
     * @var 	object
     * @access  private
     * @since 	0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Coaches Instance
     *
     * Ensures only one instance of Zume_Coaches is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Coaches instance
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

        if( user_can( get_current_user_id(), 'manage_options')) {
            // Add coach tab
            require_once('class-coaches-group-stats.php');
            require_once('class-coaches-unassigned-groups.php');
            require_once('class-coaches-list.php');
            require_once('class-coaches-group-csv.php');
            add_action( 'admin_menu', array( $this, 'load_admin_menu_item' ) );
        }

        add_action('groups_accept_invite', array($this, 'check_for_groups_needing_assignment'), 3, 10);
    } // End __construct()

    /**
     * Create the coach role if it is not created.
     */
    private static function create_coach_role () {
        add_role( 'coach', 'Coach',
            array(
                'add_users' => true,
                'edit_users' => true,
                'edit_others_steplogs' => true,
                'edit_steplogs' => true,
                'edit_users_higher_level' => true,
                'promote_users' => true,
                'delete_posts' => true,
                'edit_posts' => true,
                'read' => true,
                'promote_users_higher_level' => true,
                'promote_users_to_higher_level' => true,
                'publish_steplogs' => true,
                'read_private_steplogs' => true,
                'remove_users' => true,
                'coach_tools' => true,
            ) );
    }

    /**
     *
     */
    public function check_for_groups_needing_assignment ( $user_id, $group_id, $inviter_id) {
        global $wpdb;

        $group = $wpdb->get_results("SELECT meta_value FROM $wpdb->bp_groups_groupmeta WHERE group_id = '$group_id' AND (meta_key = 'total_member_count' OR meta_key = 'assigned_to')", ARRAY_A);
        $total_member_count = '';
        $assigned_to = '';
        foreach($group as $key => $value) {
            if($key == 'total_member_count') {$total_member_count = $value;}
            if($key == 'assigned_to') {$assigned_to = $value;}
        }

        if(empty($assigned_to)) {
            groups_update_groupmeta($group_id, 'assigned_to', 'dispatch');
            $assigned_to = 'dispatch';
        }

        if($total_member_count < 4 /* if Group has <4 members, then return and do nothing */) {
            return true;
        }
        elseif ($total_member_count >= 4 && $assigned_to != 'dispatch' /* Group has 4+ members and has an assigned coach who is not dispatch */) {
            return true;
        }
        else { /* If a group has 4+ members and their coach is dispatch, then begin assignment process */
            // Check if county coach exists


            // Check if state coach exists


            // Check if global coach exists.


        }

        return true;
    }



    /**
     * Load Admin menu into Settings
     */
    public function load_admin_menu_item () {
        add_menu_page( 'Coach', 'Coach Tools', 'manage_options', 'coach_tools', array($this, 'page_content'), 'dashicons-admin-users', '30' );
    }

    /**
     * Builds the tab bar
     * @since 0.1
     */
    public function page_content() {


        if ( !current_user_can( 'coach_tools' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        /**
         * Begin Header & Tab Bar
         */
        if (isset($_GET["tab"])) {$tab = $_GET["tab"];} else {$tab = 'group_stats';}

        $tab_link_pre = '<a href="admin.php?page=coach_tools&tab=';
        $tab_link_post = '" class="nav-tab ';

        $html = '<div class="wrap">
            <h2>Coach Tools</h2>
            <h2 class="nav-tab-wrapper">';

        $html .= $tab_link_pre . 'group_stats' . $tab_link_post;
        if ($tab == 'group_stats' || !isset($tab)) {$html .= 'nav-tab-active';}
        $html .= '">Group List with Assigned Coach</a>';

//        $html .= $tab_link_pre . 'groups_csv' . $tab_link_post;
//        if ($tab == 'groups_csv' ) {$html .= 'nav-tab-active';}
//        $html .= '">Groups CSV</a>';

//        $html .= $tab_link_pre . 'coach_list' . $tab_link_post;
//        if ($tab == 'coach_list' ) {$html .= 'nav-tab-active';}
//        $html .= '">Coach List</a>';

        $html .= '</h2>';

        echo $html; // Echo tabs

        $html = '';
        // End Tab Bar

        /**
         * Begin Page Content
         */
        switch ($tab) {

            case "coach_list":
                $list_class = new Zume_Coaches_List();
                if( isset($_POST['s']) ){
                    $list_class->prepare_items($_POST['s']);
                } else {
                    $list_class->prepare_items();
                }
                ?>
                <div class="wrap">
                    <div id="icon-users" class="icon32"></div>
                    <h2>Active Coaches</h2>
                    <form method="post">
                        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                        <?php $list_class->search_box('Search Table', 'your-element-id'); ?>
                    </form>
                    <?php $list_class->display(); ?>
                </div>
                <?php
                break;
            case "unassigned":
                    $list_class = new Zume_Unassigned_Groups_List();
                    if( isset($_POST['s']) ){
                        $list_class->prepare_items($_POST['s']);
                    } else {
                        $list_class->prepare_items();
                    }
                    ?>
                    <div class="wrap">
                        <div id="icon-users" class="icon32"></div>
                        <h2>Unassigned Groups</h2>
                        <form method="post">
                            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                            <?php $list_class->search_box('Search Table', 'your-element-id'); ?>
                        </form>
                        <?php $list_class->display(); ?>
                    </div>
                    <?php
                break;

            default:
                $list_class = new Zume_Group_Stats_List();
                if( isset($_POST['s']) ){
                    $list_class->prepare_items($_POST['s']);
                } else {
                    $list_class->prepare_items();
                }
                ?>
                <div class="wrap">
                    <div id="icon-users" class="icon32"></div>
                    <h2>Group Stats</h2>
                    <form method="post">
                        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
                        <?php $list_class->search_box('Search Table', 'your-element-id'); ?>
                    </form>
                    <?php $list_class->display(); ?>
                </div>
                <?php
                break;
        }

        $html .= '</div>'; // end div class wrap

        echo $html; // Echo contents
    }

}
