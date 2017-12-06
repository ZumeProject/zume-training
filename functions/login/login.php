<?php

/**
 * Changes the logo link from wordpress.org to your site
 */
function zume_login_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'zume_login_url' );

/**
 * Changes the alt text on the logo to show your site name
 */
function zume_login_title() {
    return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'zume_login_title' );

/**
 * Sets the display name before the user is created/activate
 *
 * @param $name
 * @param $recipient
 *
 * @return mixed|null
 */
function zume_get_name_for_email( $name, $recipient ) {
    $user         = $recipient->get_user();
    $display_name = null;
    if ( isset( $user->ID ) ) {
        $id           = $user->ID;
        $display_name = xprofile_get_field_data( 1, $id );
    }

    if ( $display_name ) {
        return $display_name;
    } else {
        if ( isset( $_POST["field_1"] ) ) {
            return $_POST["field_1"];
        } else {
            return $name;
        }
    }
}
add_filter( "bp_email_recipient_get_name", "zume_get_name_for_email", 10, 3 );