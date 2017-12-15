<?php
/**
 * Functions used in the Zúme implementation
 *
 * @since 0.1
 * @author  Chasm Solutions
 */

/* Require Authentication for Zúme */
function zume_force_login() {

    // if user is not logged in redirect to login
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
            wp_redirect( zume_dashboard_url() );
        }
    }
}
add_action( 'template_redirect', 'zume_dashboard_redirect' );


// Remove admin bar on the front end.
if ( ! current_user_can( 'administrator' ) ) {
    add_filter( 'show_admin_bar', '__return_false' );
}

/*
 * Zúme Invite Page Content // todo see if this is needed.
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

function zume_update_user_contact_info()
{
    $current_user = wp_get_current_user();

    // validate nonce
    if ( isset( $_POST['user_update_nonce'] ) && !wp_verify_nonce( sanitize_key( $_POST['user_update_nonce'] ), 'user_' . $current_user->ID . '_update' ) ) {
        return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
    }

    $args = [];
    $args['ID'] = $current_user->ID;

    // build user name variables
    if ( isset( $_POST['first_name'] ) ) {
        $args['first_name'] = sanitize_text_field( wp_unslash( $_POST['first_name'] ) );
    }
    if ( isset( $_POST['last_name'] ) ) {
        $args['last_name'] = sanitize_text_field( wp_unslash( $_POST['last_name'] ) );
    }
    if ( isset( $_POST['display_name'] ) && !empty( $_POST['display_name'] ) ) {
        $args['display_name'] = sanitize_text_field( wp_unslash( $_POST['display_name'] ) );
    }
    if ( isset( $_POST['user_email'] ) && !empty( $_POST['user_email'] ) ) {
        $args['user_email'] = sanitize_email( wp_unslash( $_POST['user_email'] ) );
    }
    if ( isset( $_POST['description'] ) ) {
        $args['description'] = sanitize_text_field( wp_unslash( $_POST['description'] ) );
    }
    if ( isset( $_POST['nickname'] ) ) {
        $args['nickname'] = sanitize_text_field( wp_unslash( $_POST['nickname'] ) );
    }

    // _user table defaults
    $result = wp_update_user( $args );

    if ( is_wp_error( $result ) ) {
        return new WP_Error( 'fail_update_user_data', 'Error while updating user data in user table.' );
    }

    return true;
}

/**
 * This returns a simple array versus the multi dimensional array from the get_user_meta function
 * @param $user_id
 *
 * @return array
 */
function zume_get_user_meta( $user_id = null ) {
	if ( is_null( $user_id ) ) {
		$user_id = get_current_user_id();
	}
    return array_map( function ( $a ) { return $a[0];
    }, get_user_meta( $user_id ) );
}

function zume_home_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'home', $current_lang );
    return $url;
}

function zume_dashboard_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'dashboard', $current_lang );
    return $url;
}

function zume_course_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'course', $current_lang );
    return $url;
}

function zume_overview_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'overview', $current_lang );
    return $url;
}

function zume_guidebook_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'guidebook', $current_lang );
    return $url;
}

function zume_profile_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'profile', $current_lang );
    return $url;
}

function zume_about_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'about', $current_lang );
    return $url;
}

function zume_faq_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'faq', $current_lang );
    return $url;
}