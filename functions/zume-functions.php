<?php
/**
 * Functions used in the Zúme implementation
 *
 * @since 0.1
 */

/* Require Authentication for Zúme */
function zume_force_login() {

    // if user is not logged in redirect to login
    if ( ! is_user_logged_in() ) {
        wp_safe_redirect( zume_login_url() );
        exit;
    }
}


/*
 * Redirects logged on users from home page requests to dashboard.
 */
//function zume_dashboard_redirect() {
//    global $post;
//    if ( is_user_logged_in() && isset( $post )) {
////        if ($post->post_name == 'home') {
////            wp_redirect( zume_dashboard_url() );
////        }
//    }
//}
//add_action( 'template_redirect', 'zume_dashboard_redirect' );


// Remove admin bar on the front end.
if ( ! current_user_can( 'administrator' ) ) {
    add_filter( 'show_admin_bar', '__return_false' );
}


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


function zume_update_user_contact_info() { dt_write_log($_POST);
    $user_id = get_current_user_id();

    // validate nonce
    if ( isset( $_POST['user_update_nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['user_update_nonce'] ), 'user_' . $user_id. '_update' ) ) {
        return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
    }

    $args = [];
    $args['ID'] = $user_id;

    // build user name variables
    if ( isset( $_POST['zume_full_name'] ) ) {
        update_user_meta( $user_id, 'zume_full_name', sanitize_text_field( wp_unslash( $_POST['zume_full_name'] ) ) );
    }
    if ( isset( $_POST['user_email'] ) && !empty( $_POST['user_email'] ) ) {
        $args['user_email'] = sanitize_email( wp_unslash( $_POST['user_email'] ) );
    }
    if ( isset( $_POST['zume_phone_number'] ) ) {
        update_user_meta( $user_id, 'zume_phone_number', sanitize_text_field( wp_unslash( $_POST['zume_phone_number'] ) ) );
    }
    if ( isset( $_POST['zume_user_address'] ) ) {
        if ( empty( $_POST['zume_user_address'] ) ) {
            update_user_meta( $user_id, 'zume_user_address', sanitize_text_field( wp_unslash( $_POST['zume_user_address'] ) ) );
        }
        else {
            $results = DT_Mapbox_API::lookup( trim( sanitize_text_field( wp_unslash( $_POST['zume_user_address'] ) ) ) );

            if ( isset( $results['features'] ) ) {
                update_user_meta( $user_id, 'zume_user_address', trim( sanitize_text_field( wp_unslash( $_POST['zume_user_address'] ) ) ) );
                update_user_meta( $user_id, 'zume_user_lng', DT_Mapbox_API::parse_raw_result( $results, 'longitude', true ) );
                update_user_meta( $user_id, 'zume_user_lat', DT_Mapbox_API::parse_raw_result( $results, 'latitude', true ) );
                update_user_meta( $user_id, 'zume_raw_location', $results );
            }
        }
    }
    if ( isset( $_POST['zume_affiliation_key'] ) ) {
        update_user_meta( $user_id, 'zume_affiliation_key', trim( sanitize_text_field( wp_unslash( $_POST['zume_affiliation_key'] ) ) ) );
    }

    zume_update_user_ip_address_and_location( $user_id );

    // _user table defaults
    $result = wp_update_user( $args );

    if ( is_wp_error( $result ) ) {
        return new WP_Error( 'fail_update_user_data', 'Error while updating user data in user table.' );
    }

    do_action( 'zume_update_profile', $user_id );

    return true;
}

function zume_update_user_ip_address_and_location( $user_id = null ) {
    if ( is_null( $user_id ) )
    {
        $user_id = get_current_user_id();
    }
    // Geocode and store ip address
    $ip_address = DT_Ipstack_API::get_real_ip_address();
    update_user_meta( $user_id, 'zume_recent_ip', $ip_address );

    $ip_results = DT_Ipstack_API::geocode_ip_address( $ip_address );
    if ( isset( $ip_results['ip'] ) ) {
        update_user_meta( $user_id, 'zume_lng_from_ip', DT_Ipstack_API::parse_raw_result( $ip_results, 'longitude' ) );
        update_user_meta( $user_id, 'zume_lat_from_ip', DT_Ipstack_API::parse_raw_result( $ip_results, 'latitude' ) );
        update_user_meta( $user_id, 'zume_raw_location_from_ip', $ip_results );
    }
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

function zume_home_url( $current_language = null ) {
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    if ( 'en' != $current_language ) {
        $home_url = site_url() . '/' . $current_language;
    } else {
        $home_url = site_url();
    }
    return $home_url;
}

function zume_login_url( $current_language = null ) {
    if ( strpos( $current_language, "http" ) !== false ){
        $current_language = null;
    }
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    if ( 'en' === $current_language ) {
        $url = site_url() . '/login';
    }
    else if ( empty( $current_language ) ) {
        $url = site_url() . '/login';
    } else {
        $url = zume_get_posts_translation_url( 'Login', $current_language );
    }
    return $url;
}

function zume_lostpassword_url( $current_language = null ) {
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    if ( 'en' != $current_language && ! empty( $current_language ) ) {
        $url = zume_get_posts_translation_url( 'Login', $current_language ) . '/?action=lostpassword';
    } else {
        $url = site_url() . '/login/?action=lostpassword';
    }
    return $url;
}

function zume_register_url( $current_language = null ) {
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    if ( 'en' != $current_language && ! empty( $current_language ) ) {
        $trans_url = zume_get_posts_translation_url( 'Login', $current_language );
        if ( empty( $trans_url ) || is_wp_error( $trans_url ) ) {
            $url = site_url() . '/login/?action=register';
        } else {
            $url = zume_get_posts_translation_url( 'Login', $current_language ) . '/?action=register';
        }
    } else {
        $url = site_url() . '/login/?action=register';
    }
    return $url;
}

function zume_dashboard_url( $current_language = null ) {
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    $url = zume_get_posts_translation_url( 'dashboard', $current_language );
    return $url;
}

function zume_course_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'course', $current_lang );
    return $url;
}

function zume_three_month_plan_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'three-month plan', $current_lang );
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


/**
 * Returns the full URI of the images folder with the ending slash, either as images/ or as images/sub_folder/.
 *
 * @param string $sub_folder
 * @return string
 */
function zume_images_uri( $sub_folder = '' ) {
    $zume_images_uri = site_url( '/wp-content/themes/zume-project-multilingual/assets/images/' );
    if ( empty( $sub_folder ) ) {
        return $zume_images_uri;
    } else {
        return $zume_images_uri . $sub_folder . '/';
    }
}

function zume_files_uri() {
    return 'https://storage.googleapis.com/zume-file-mirror/' . zume_current_language() . '/';
}

function zume_home_id() {
    $current_lang = zume_current_language();
    $id = zume_get_home_translation_id( 'home', $current_lang );
    if ( is_wp_error( $id ) ) {
        return 'en';
    }
    return $id;
}

function zume_alternate_home_id() {
    $current_lang = zume_current_language();
    $id = zume_get_home_translation_id( 'Alternate Home', $current_lang );
    if ( is_wp_error( $id ) || empty( $id ) ) {
        return false;
    }
    return $id;
}

/***********************************************************************************************************************
 *
 * ADMIN AREA
 *
 *
 **********************************************************************************************************************/

// Adds columns to the user table in the admin area
function zume_mu_add_user_admin_columns( $columns ) {

    $columns['zume_phone_number'] = __( 'Phone Number', 'zume' );
    $columns['zume_user_address'] = __( 'User Address', 'zume' );
    $columns['zume_address_from_ip'] = __( 'GeoCoded IP', 'zume' );
    return $columns;

} // end theme_add_user_zip_code_column
add_filter( 'manage_users_columns', 'zume_mu_add_user_admin_columns' );


function zume_mu_show_custom_column_content( $value, $column_name, $user_id ) {

    if ( 'zume_phone_number' == $column_name ) {
        return get_user_meta( $user_id, 'zume_phone_number', true );
    } // end if
    if ( 'zume_user_address' == $column_name ) {
        if ( empty( get_user_meta( $user_id, 'zume_user_address', true ) ) ) {
            $content = '';
        }
        else {
            $content = get_user_meta( $user_id, 'zume_user_address', true ) . '<br><a target="_blank" href="https://www.google.com/maps/search/?api=1&query='.get_user_meta( $user_id, 'zume_user_lat', true ).','.get_user_meta( $user_id, 'zume_user_lng', true ).'">map</a>';
        }
        return $content;
    } // end if
    if ( 'zume_address_from_ip' == $column_name ) {
        if ( empty( get_user_meta( $user_id, 'zume_address_from_ip', true ) ) ) {
            $content = '';
        }
        else {
            $content = get_user_meta( $user_id, 'zume_address_from_ip', true ) . '<br><a target="_blank" href="https://www.google.com/maps/search/?api=1&query='.get_user_meta( $user_id, 'zume_lat_from_ip', true ).','.get_user_meta( $user_id, 'zume_lng_from_ip', true ).'">map</a>';
        }
        return $content;
    } // end if

} // end theme_show_user_zip_code_data
add_action( 'manage_users_custom_column', 'zume_mu_show_custom_column_content', 10, 3 );
