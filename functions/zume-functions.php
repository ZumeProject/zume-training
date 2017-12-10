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

    if ( is_page( $exception_pages ) || $GLOBALS['pagenow'] === 'wp-login.php' || $GLOBALS['pagenow'] === 'index.php' ) {
        return;
    }

    $action = isset( $_REQUEST['action'] ) ? sanitize_key( $_REQUEST['action'] ) : 'login';
    if ( $action == 'rp' || $action == 'resetpass' ) {
        return;
    }

    // Otherwise, if user is not logged in redirect to login
    if ( !is_user_logged_in()) {
        auth_redirect();
    }
}


/*
 * Redirects logged on users from home page requests to dashboard.
 */
function zume_dashboard_redirect() {
    global $post;
    if ( is_user_logged_in() && isset( $post )) {
        if ($post->post_name == 'home') {
            wp_redirect( home_url( '/dashboard' ) );
        }
    }
}
add_action( 'template_redirect', 'zume_dashboard_redirect' );


// Remove admin bar on the front end.
if ( ! current_user_can( 'administrator' ) ) {
    add_filter( 'show_admin_bar', '__return_false' );
}

/*
 * Zúme Invite Page Content
 * contains tailored content for the user to select the kind of invitation they want to make.
 */
function zume_invite_page_content( $content ) {
    if ( is_page( 'zume-invite' ) ) {

         require_once( 'templates/zume-invites.php' );
         zume_page_content_zume_invites();

    }
    return $content;
}
add_filter( 'the_content', 'zume_invite_page_content' );

/**
 * Remove menu items for coaches in the admin dashboard.
 */
function zume_custom_menu_page_removing() {

    if (is_admin() && current_user_can( 'coach' ) && !current_user_can( 'administrator' ) ) {

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
add_action( 'admin_menu', 'zume_custom_menu_page_removing' );


function zume_wp_insert_post( $post_id, $post, $update ) {
    if ( wp_is_post_revision( $post_id ) ) {
        return;
    }
    if ( $post->post_type === 'steplog' && preg_match( '/^group-(\d+)-step-complete-session-(\d+)/i', $post->post_name, $matches ) ) {
        zume_session_completed_trigger_mailchimp( (int) $matches[1], (int) $matches[2] );
    }
}
add_action( 'wp_insert_post', 'zume_wp_insert_post', 10, 3 );


function zume_get_real_ip_address()
{
    if ( !empty( $_SERVER['HTTP_CLIENT_IP'] ))   //check ip from share internet
    {
        $ip =$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ))   //to check ip is pass from proxy
    {
        $ip =$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
        $ip =$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}