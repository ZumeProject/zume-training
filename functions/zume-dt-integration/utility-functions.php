<?php
/**
 * Misc utility functions
 */

function zume_integration_is_this_zumeproject() : bool {
    $current_theme = get_option( 'current_theme' );
    if ( 'Zúme Project' == $current_theme ) {
        return true;
    }
    return false;
}

function zume_integration_is_this_disciple_tools() : bool {
    $current_theme = get_option( 'current_theme' );
    if ( 'Disciple Tools' == $current_theme ) {
        return true;
    }
    return false;
}

/**
 * Send Post Request
 * $args = [
 *  'method' => 'POST',
 *   'body' => [
 *   'transfer_token' => $site['transfer_token'],
 *   'transfer_record' => $fields,
 *   'zume_foreign_key' => $user_data['zume_foreign_key'],
 *   'zume_language' => $user_data['zume_language'],
 *   'zume_check_sum' => $user_data['zume_check_sum'],
 * ]
 * ];
 *
 * @param $endpoint
 * @param $url
 * @param $args
 *
 * @return array|\WP_Error
 */
function zume_integration_remote_send( $endpoint, $url, $args ) {

    $result = wp_remote_post( 'https://' . $url . '/wp-json/dt-public/v1/zume/' . $endpoint, $args );

    if ( is_wp_error( $result ) ) {
        return new WP_Error( 'failed_remote_get', $result->get_error_message() );
    }
    return $result;
}

/**
 * Filters for the appropriate site key
 *
 * @param $user_data
 *
 * @return bool|int|string
 */
function zume_integration_filter_for_site_key( $user_data = null ) {

    // @TODO Potentially add routing logic.
    // Evaluate routing factors of the user_data to route the user to a certain site.
    // Is language set, then potentially route to language DT site
    // Is location set, then potentially route to location site

    $key = get_option( 'zume_default_site' ); // Currently, the default site is returned as the only routing option.
    if ( ! $key ) {

        $keys = DT_Site_Link_System::get_site_keys();
        if ( empty( $keys ) ) {
            return false;
        }

        foreach ( $keys as $key => $value ) { //picks first site, modifies the $key value, updates option
            update_option( 'zume_site_default', $key );
            break;
        }
    }
    return $key;
}

/**
 * Get the token and url of the site
 *
 * @param $site_key
 *
 * @return array
 */
function zume_integration_get_site_details( $site_key ) {
    $keys = DT_Site_Link_System::get_site_keys();

    $site1 = $keys[$site_key]['site1'];
    $site2 = $keys[$site_key]['site2'];

    $url = DT_Site_Link_System::get_non_local_site( $site1, $site2 );
    $transfer_token = DT_Site_Link_System::create_transfer_token_for_site( $site_key );

    return [
    'url' => $url,
    'transfer_token' => $transfer_token
    ];
}
