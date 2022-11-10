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


function zume_update_user_contact_info() {
    $user_id = get_current_user_id();

    // validate nonce
    if ( isset( $_POST['user_update_nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['user_update_nonce'] ), 'user_' . $user_id. '_update' ) ) {
        return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
    }

    $args = array();
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
        if ( empty( $_POST['validate_address'] ) ) {
            update_user_meta( $user_id, 'zume_user_address', false );
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
        update_user_meta( $user_id, 'zume_raw_location_from_ip', $ip_results );

        if ( class_exists( 'DT_Ipstack_API' ) ) {
            $country = DT_Ipstack_API::parse_raw_result( $ip_results, 'country_name' );
            $region = DT_Ipstack_API::parse_raw_result( $ip_results, 'region_name' );
            $city = DT_Ipstack_API::parse_raw_result( $ip_results, 'city' );

            $address = '';
            if ( ! empty( $country ) ) {
                $address = $country;
            }
            if ( ! empty( $region ) ) {
                $address = $region . ', ' . $address;
            }
            if ( ! empty( $city ) ) {
                $address = $city . ', ' . $address;
            }

            update_user_meta( $user_id, 'zume_address_from_ip', $address ); // location grid id only

            $location_grid_meta = DT_Ipstack_API::convert_ip_result_to_location_grid_meta( $ip_results );
            if ( isset( $location_grid_meta['grid_id'] ) ) {
                update_user_meta( $user_id, 'zume_location_grid_meta_from_ip', $location_grid_meta ); // location grid meta array
                update_user_meta( $user_id, 'zume_location_grid_from_ip', $location_grid_meta['grid_id'] ); // location grid id only
            }
        }
    }

}

function get_location_grid_meta_array() {
    return [
        'lng' => '',
        'lat' => '',
        'level' => '',
        'label' => '',
        'source' => '',
        'grid_id' => '',
    ];
}




/**
 * This returns a simple array versus the multi dimensional array from the get_user_meta function
 * @param $user_id
 *
 * @return array
 */
if ( ! function_exists( 'zume_get_user_meta' ) ) {
    function zume_get_user_meta( $user_id = null ) {
        if ( is_null( $user_id ) ) {
            $user_id = get_current_user_id();
        }
        return array_map( function ( $a ) { return $a[0];
        }, get_user_meta( $user_id ) );
    }
}


function zume_home_url( $current_language = null ) {
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    if ( 'en' === $current_language ) {
        $home_url = site_url();
    } else {
        $home_url = site_url() . '/' . $current_language;
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
        $url = trailingslashit( site_url() ) . 'login';
    }
    else if ( empty( $current_language ) ) {
        $url = trailingslashit( site_url() ) . 'login';
    } else {
        $url = trailingslashit( zume_get_posts_translation_url( 'Login', $current_language ) );
    }
    return $url;
}

function zume_lostpassword_url( $current_language = null ) {
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    if ( 'en' != $current_language && ! empty( $current_language ) ) {
        $url = trailingslashit( zume_get_posts_translation_url( 'Login', $current_language ) ) . '?action=lostpassword';
    } else {
        $url = trailingslashit( site_url() ) . 'login/?action=lostpassword';
    }
    return $url;
}

function zume_register_url( $current_language = null ) {
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    if ( 'en' !== $current_language && ! empty( $current_language ) ) {
        $trans_url = zume_get_posts_translation_url( 'Login', $current_language );
        if ( empty( $trans_url ) || is_wp_error( $trans_url ) ) {
            $url = trailingslashit( site_url() ) . 'login/?action=register';
        } else {
            $url = trailingslashit( zume_get_posts_translation_url( 'Login', $current_language ) ) . '?action=register';
        }
    } else {
        $url = trailingslashit( site_url() ) . 'login/?action=register';
    }
    return $url;
}

function zume_dashboard_url( $current_language = null ) {
    return zume_training_url( $current_language );
}

function zume_training_url( $current_language = null ) {
    if ( is_null( $current_language ) ) {
        $current_language = zume_current_language();
    }
    $url = zume_get_posts_translation_url( 'Training', $current_language );
    return $url;
}

function zume_course_url() {
    $current_lang = zume_current_language();
    return zume_get_posts_translation_url( 'Course', $current_lang );
}

function zume_three_month_plan_url() {
    $current_lang = zume_current_language();
    return zume_get_posts_translation_url( 'Three-Month Plan', $current_lang );
}

function zume_overview_url() {
    $current_lang = zume_current_language();
    return zume_get_posts_translation_url( 'Overview', $current_lang );
}

function zume_guidebook_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'Guidebook', $current_lang );
    return $url;
}

function zume_profile_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'Profile', $current_lang );
    return $url;
}

function zume_about_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'About', $current_lang );
    return $url;
}

function zume_faq_url() {
    $current_lang = zume_current_language();
    $url = zume_get_posts_translation_url( 'FAQ', $current_lang );
    return $url;
}




/**
 * Returns the full URI of the images folder with the ending slash, either as images/ or as images/sub_folder/.
 *
 * @param string $sub_folder
 * @return string
 */
function zume_images_uri( $sub_folder = '' ) {
    $zume_images_uri = site_url( '/wp-content/themes/zume-training/assets/images/' );
    if ( empty( $sub_folder ) ) {
        return $zume_images_uri;
    } else {
        return $zume_images_uri . $sub_folder . '/';
    }
}

function zume_files_uri() {
    return zume_mirror_url() . zume_current_language() . '/';
}

function zume_language_file(){
    return json_decode( file_get_contents( get_theme_file_path( '/languages.json' ) ), true );
}


function zume_files_download_uri() {
    // post id of downloads / meta field
    return zume_files_uri() . '/';
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

function zume_landing_page_post_id( int $number ) : int {
    /**
     * These are the root post ids for the english page, which is used to find the translation page in the
     * polylang system.
     */
    $list = array(
        1 => 20730, // God uses ordinary people
        2 => 20731, // teach them to obey
        3 => 20732, // spiritual breathing
        4 => 20733, // soaps bible reading
        5 => 20735, // accountability groups
        6 => 20737, // consumers vs producers
        7 => 20738, // prayer cycle
        8 => 20739, // list of 100
        9 => 20740, // kingdom economy
        10 => 20741, // the gospel
        11 => 20742, // baptism
        12 => 20743, // 3-minute testimony
        13 => 20744, // greatest blessing
        14 => 20745, // duckling discipleship
        15 => 20746, // seeing where God's kingdom isn't
        16 => 20747, // the lord's supper
        17 => 20748, // prayer walking
        18 => 20750, // person of peace
        19 => 20749, // bless prayer
        20 => 20751, // faithfulness
        21 => 20752, // 3/3 group pattern
        22 => 20753, // training cycle
        23 => 20755, // leadership cells
        24 => 20756, // non-sequential
        25 => 20757, // pace
        26 => 20758, // part of two churches
        27 => 19848, // 3-month plan
        28 => 20759, // coaching checklist
        29 => 20760, // leadership in networks
        30 => 20761, // peer mentoring groups
        31 => 20762, // four fields tool
        32 => 20763, // generation mapping
        20730 => 1, // God uses ordinary people
        20731 => 2, // teach them to obey
        20732 => 3, // spiritual breathing
        20733 => 4, // soaps bible reading
        20735 => 5, // accountability groups
        20737 => 6, // consumers vs producers
        20738 => 7, // prayer cycle
        20739 => 8, // list of 100
        20740 => 9, // kingdom economy
        20741 => 10, // the gospel
        20742 => 11, // baptism
        20743 => 12, // 3-minute testimony
        20744 => 13, // greatest blessing
        20745 => 14, // duckling discipleship
        20746 => 15, // seeing where God's kingdom isn't
        20747 => 16, // the lord's supper
        20748 => 17, // prayer walking
        20750 => 18, // person of peace
        20749 => 19, // bless prayer
        20751 => 20, // faithfulness
        20752 => 21, // 3/3 group pattern
        20753 => 22, // training cycle
        20755 => 23, // leadership cells
        20756 => 24, // non-sequential
        20757 => 25, // pace
        20758 => 26, // part of two churches
        19848 => 27, // 3-month plan
        20759 => 28, // coaching checklist
        20760 => 29, // leadership in networks
        20761 => 30, // peer mentoring groups
        20762 => 31, // four fields tool
        20763 => 32, // generation mapping

    );

    return $list[$number] ?? 0;
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



