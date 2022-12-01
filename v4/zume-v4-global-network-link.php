<?php
// @todo remove

add_action( 'zume_create_group', 'trigger_group_to_training_transfer', 10, 3 );
function trigger_group_to_training_transfer( $user_id, $group_key, $group ) {

    // build fields for transfer
    $fields = [
        "title" => $group['group_name'],
        "zume_group_id" => $group_key,
        "zume_public_key" => $group['public_key'],
        "member_count" => $group['members'],
        "leader_count" => 1,
        "start_date" => strtotime( $group['created_date'] ),
        "status" => "new",
    ];

    if ( get_user_meta( $user_id, 'wp_3_corresponds_to_contact', true ) ) {
        $fields['assigned_to'] = $user_id;
    }

    $site = Site_Link_System::get_site_connection_vars( 21116 ); // @todo remove hardcoded
    if ( ! $site ) {
        dt_write_log( __METHOD__ . ' FAILED TO GET SITE LINK TO GLOBAL ' );
        return false;
    }

    $args = [
        'method' => 'POST',
        'body' => json_encode( $fields ),
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $site['transfer_token'],
        ],
    ];

    $result = wp_remote_post( 'https://' . trailingslashit( $site['url'] ) . 'wp-json/dt-posts/v2/trainings', $args );
    if ( is_wp_error( $result ) ) {
        dt_write_log( __METHOD__ . ' TO CREATE TRAINING FOR ' . $group['name'] );
        return false;
    }

    $body = json_decode( $result['body'], true );

    return $body;

}
