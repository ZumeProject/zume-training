<?php

add_action('zume_create_group', 'trigger_group_to_training_transfer', 10, 3 );
function trigger_group_to_training_transfer( $user_id, $group_key, $group ) {
    
    // build fields for transfer
    $fields = [
        "title" => $group['group_name'],
        "zume_group_id" => $group_key,
        "contact_count" => $group['members'],
        "start_date" => strtotime( $group['created_date'] ),
        "status" => "new",
    ];

    $site = Site_Link_System::get_site_connection_vars( 21033 ); // @todo remove hardcoded
    if ( ! $site ) {
        return new WP_Error( __METHOD__, 'Missing site to site data' );
    }

    $args = [
        'method' => 'POST',
        'body' => $fields,
        'headers' => [
            'Authorization' => 'Bearer ' . $site['transfer_token'],
        ],
    ];

    $result = wp_remote_post( 'https://' . trailingslashit( $site['url'] ) . 'wp-json/dt-posts/v2/trainings', $args );
    if ( is_wp_error( $result ) ) {
        return new WP_Error( 'failed_remote_post', $result->get_error_message() );
    }

    $body = json_decode( $result['body'], true );

    return $body;

}
