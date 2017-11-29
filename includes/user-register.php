<?php

add_action("user_register", "zume_user_register");

function zume_user_register($user_id) {
    $user = get_user_by("id", $user_id);
    $email = $user->data->user_email;
    /*
     * I tried to get the display name that the user entered in the form, but I can't figure it out, here are the
     * things that I've tried:
     *
     * $display_name = bp_core_get_user_displayname($user_id);
     * $full_name = bp_get_displayed_user_fullname($user_id);
     * $display_name = xprofile_get_field_data(1, $user_id);
     * $display_name = bp_get_profile_field_data('field=DisplayName&user_id=' . $user_id);
     * $display_name = bp_get_profile_field_data('field=Display-Name&user_id=' . $user_id);
     * $display_name = bp_get_profile_field_data('field=Display_Name&user_id=' . $user_id);
     *
     */
    add_user_to_mailchimp($email);
}


function add_user_to_mailchimp($email, $name=null) {
    $dc      = get_option("zume_mailchimp_dc");
    $api_key = get_option("zume_mailchimp_api_key");
    $list_id = get_option("zume_mailchimp_list_id");
    $url = "https://$dc.api.mailchimp.com/3.0/lists/$list_id/members";
    $post_data = [
        'email_address' => $email,
        'status' => 'subscribed'
    ];
    if ($name !== null) {
        $post_data['merge_fields']['FNAME'] = $name;
    }

    $request = curl_init($url);
    curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($request, CURLOPT_USERPWD, "anystring:$api_key");
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($request, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    $response_string = curl_exec($request);
    $status_code = curl_getinfo($request, CURLINFO_HTTP_CODE);

    curl_close($request);

    if ($status_code != 200) {
        error_log(__FUNCTION__ . ": When sending post request to $url, got status code $status_code");
        $response = json_decode($response_string, TRUE);
        if ($response === NULL) {
            error_log(__FUNCTION__ . ": could not decode JSON of response, this was the response string: $response_string");
        } else {
            error_log(__FUNCTION__ . ": response is: " . var_export($response, TRUE));
        }
    }

}


function session_completed_trigger_mailchimp( $group_id, $session_number ) {
    $group_id = (int) $group_id;
    $session_number = (int) $session_number;
    $api_key = get_option("zume_mailchimp_api_key");
    $url = get_option("zume_mailchimp_automation_session_$session_number");

    if (! $url) { return; }

    if ( bp_group_has_members( "group_id=$group_id" ) ) {
        while ( bp_group_members( "group_id=$group_id" ) ) {
            bp_group_the_member();
            $user_id = bp_get_group_member_id();
            $user = get_user_by( 'id', $user_id );

            $post_data = [
                'email_address' => $user->user_email,
            ];
            $request = curl_init($url);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, json_encode($post_data));
            curl_setopt($request, CURLOPT_USERPWD, "anystring:$api_key");
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($request, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            $response_string = curl_exec($request);
            $status_code = curl_getinfo($request, CURLINFO_HTTP_CODE);

            curl_close($request);
            error_log("Running curl for URL $url and email $user->user_email got status code $status_code");
        }
    }

}
