<?php
/**
 * Functions used in the Zúme implementation
 *
 * @since 0.1
 * @author  Chasm Solutions
 */

/* Require Authentication for Zúme */
function zume_force_login() {

    // Pages that should not be redirected. Add to array exception pages.
    $exception_pages = array(
        'Home',
        'Register',
        'Activate',
        'Complete',
        'Overview',
        'About',
        'Resources'
    );

    if(is_page($exception_pages) || $GLOBALS['pagenow'] === 'wp-login.php' || $GLOBALS['pagenow'] === 'index.php' ) {
        return;
    }

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
    if ( $action == 'rp' || $action == 'resetpass' ) {
        return;
    }

    // Otherwise, if user is not logged in redirect to login
    if (!is_user_logged_in()) {
        auth_redirect();
    }

    // If user is logged in, check that key plugins exist for the course.
    if (! class_exists('Zume_Course') ) {
        echo 'Zúme Course plugin is disabled or otherwise unreachable. Please, check with administrator to verify course availability.';
        return;
    }


}

/*
 * Redirects logged on users from home page requests to dashboard.
 *
 */
function zume_dashboard_redirect () {
    global $post;
    if ( is_user_logged_in() && isset($post)) {
	    if($post->post_name == 'home') {
		  wp_redirect( home_url('/dashboard') );
	    }
    }
}
add_action('template_redirect', 'zume_dashboard_redirect');

/**
 * Queries the Steplog table and finds the highest session completed
 * @since 0.1
 * @return integer
 */
function zume_group_highest_session_completed ($group_id) {
    global $wpdb;

    $where_query = 'group-'.$group_id.'-step-complete%';
    $querystr =  $wpdb->prepare("SELECT MAX(post_excerpt) as completed FROM $wpdb->posts WHERE post_type = 'steplog' AND post_name LIKE %s", $where_query);

    $result = $wpdb->get_results($querystr, ARRAY_A);

    return (int) $result[0]['completed'];
}

/**
 * Gets the session number for the next session of the group, null if there is
 * no next session for the group.
 * @since 0.1
 * @return integer or null
 */
function zume_group_next_session ($group_id) {
    $highest_session = (int) zume_group_highest_session_completed($group_id);
    if ($highest_session >= 10) {
        return null;
    } else {
        return $highest_session + 1;
    }
}


// BuddyPress Group Creation Modifications
add_action('bp_before_create_group_content_template', 'zume_create_group_content');
function zume_create_group_content () {
    echo '<h2 class="center padding-bottom">Create Group</h2>';
}


// Remove admin bar on the front end.
add_filter('show_admin_bar', '__return_false');


/*
 * Zúme Invite Page Content
 * contains tailored content for the user to select the kind of invitation they want to make.
 */
function zume_invite_page_content ( $content ) {
    if ( is_page( 'zume-invite' ) ) {

         require_once('templates/zume-invites.php');
         zume_page_content_zume_invites ();

    }
    return $content;
}
add_filter( 'the_content', 'zume_invite_page_content');

/**
 * Hide appropriate tabs on User Profile
 * Overrides defaults on the profile page
 */
function zume_hide_tabs() {
    global $bp;
    /**
     * class_exists() & bp_is_active are recommanded to avoid problems during updates
     * or when Component is deactivated
     */

    if( class_exists( 'bbPress' ) || bp_is_active ( 'groups' ) ) :

        /** here we fix the conditions.
         * Are we on a profile page ?
         */
        if ( bp_is_user()  ) {

            /* and here we remove our stuff ! */
//            bp_core_remove_nav_item( 'activity' );
            bp_core_remove_nav_item( 'friends' );
            bp_core_remove_nav_item( 'groups' );
            bp_core_remove_nav_item( 'forums' );
        }
    endif;
}
add_action( 'bp_setup_nav', 'zume_hide_tabs', 15 );


/**
 * Removes unnecisary tabs in group.
 */
function zume_remove_group_admin_tab() {
    if ( ! bp_is_group() || ! ( bp_is_current_action( 'admin' ) && bp_action_variable( 0 ) )  ) {
        return;
    }
    // Add the admin subnav slug you want to hide in the
    // following array
    $hide_tabs = array(
        'group-settings' => 1,
        /* 'delete-group' => 1, */
    );
    $parent_nav_slug = bp_get_current_group_slug() . '_manage';
    // Remove the nav items
    foreach ( array_keys( $hide_tabs ) as $tab ) {
        // Since 2.6, You just need to add the 'groups' parameter at the end of the bp_core_remove_subnav_item
        bp_core_remove_subnav_item( $parent_nav_slug, $tab, 'groups' );
    }
    // You may want to be sure the user can't access
    if ( ! empty( $hide_tabs[ bp_action_variable( 0 ) ] ) ) {
        bp_core_add_message( 'Sorry buddy, but this part is restricted to super admins!', 'error' );
        bp_core_redirect( bp_get_group_permalink( groups_get_current_group() ) );
    }
}
add_action( 'bp_init', 'zume_remove_group_admin_tab', 9 );

/**
 * Redirect members directory pages
 */
function zume_redirect () {

    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';


    ?>
    <script>window.location.replace('<?php echo home_url('/'); ?>');</script>
    <noscript>

        <div class="awesome-fancy-styling">
            This site requires JavaScript and directories are not available. I will only be visible if you have javascript disabled and likely you are looking in the wrong part of our site. Please don't hack. You're IP Address is <?php echo $ipaddress; ?>.
        </div>

    </noscript>
    <?php
    die();
}
add_action('bp_before_directory_members_page', 'zume_redirect_members_directory');

/**
 * Add next session to group tab menu
 */
function zume_add_next_session_to_group_tabs () {
	$group_next_session = zume_group_next_session(bp_get_group_id());
	$link = "/zume-training/?id=";
  if (is_null($group_next_session)){
    $link = $link . "10&group_id=". bp_get_group_id();
  } else {
    $link = $link . $group_next_session . "&group_id=" . bp_get_group_id();
  }
  if (groups_is_user_member( get_current_user_id(), bp_get_group_id() )){
  ?>
    <li><a href="<?php echo $link?>">Start Next Session</a></li>
  <?php
  }
}
add_action('bp_group_options_nav', 'zume_add_next_session_to_group_tabs');

//disable the welcome email
add_filter( 'wpmu_welcome_notification', '__return_false' );

//redirect to the dashboard after deleting a group
function redirect_after_group_delete(){
  bp_core_redirect( "/dashboard" );
}
add_action('groups_delete_group', "redirect_after_group_delete");

//disable the public message button
add_filter('bp_get_send_public_message_button', '__return_false');


/**
 * Remove menu items for coaches in the admin dashboard.
 */
function custom_menu_page_removing() {

    if(is_admin() && current_user_can('coach') && !current_user_can('administrator') ) {

        remove_menu_page( 'index.php' );                  //Dashboard
        remove_menu_page( 'jetpack' );                    //Jetpack*
        remove_menu_page( 'edit.php' );                   //Posts
        remove_menu_page( 'upload.php' );                 //Media
        remove_menu_page( 'edit.php?post_type=page' );    //Pages
        remove_menu_page( 'edit.php?post_type=steplog' );    //Pages
        remove_menu_page( 'edit-comments.php' );          //Comments
        remove_menu_page( 'themes.php' );                 //Appearance
        remove_menu_page( 'plugins.php' );                //Plugins
    //    remove_menu_page( 'users.php' );                  //Users
        remove_menu_page( 'tools.php' );                  //Tools
        remove_menu_page( 'options-general.php' );        //Settings

    }
}
add_action( 'admin_menu', 'custom_menu_page_removing' );

/**
 * Get User Name from Assigned To Field
 * @param $contact_id
 */
function zume_get_assigned_name ( $assigned_to ) {
return $assigned_to;
//    if(!empty( $assigned_to )) {
//        $meta_array = explode( '-', $assigned_to ); // Separate the type and id
//        $type = $meta_array[0];
//        $id = $meta_array[1];
//
//        if($type == 'user') {
//            $value = get_user_by( 'id', $id );
//            return $value->display_name;
//        } else {
//            $value = get_term( $id );
//            return $assigned_to;
////            return $value->name;
//        }
//    }

}

function zume_wp_insert_post( $post_id, $post, $update ) {
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }
    if ( $post->post_type === 'steplog' && preg_match('/^group-(\d+)-step-complete-session-(\d+)/i', $post->post_name, $matches ) ) {
        session_completed_trigger_mailchimp( (int) $matches[1], (int) $matches[2] );
    }
}
add_action( 'wp_insert_post', 'zume_wp_insert_post', 10, 3 );
