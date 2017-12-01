<?php

function send_group_ready_email($user_id, $group_id, $inviter_id){
	$count = groups_get_total_member_count( $group_id );
	$emails = [];
	if ($count == 4){
		if (bp_group_has_members('group_id=' . $group_id . '&exclude_admins_mods=0' )){
			while (bp_group_members()): bp_group_the_member();
				$emails[] = bp_get_member_user_email();
			endwhile;
		}
		$group = groups_get_group($group_id);
		$args = array(
			'tokens' => array (
				'group.name'    => $group->name,
				'group.url'     => esc_url(bp_get_group_permalink($group))
			)
		);
		bp_send_email('group_enough_members', $emails, $args);
	}
}
add_action('groups_accept_invite', 'send_group_ready_email', 1, 3);

/**
 * Automatically add people to a group
 */
//example url zume.dev/?zume-group-id=16
//
if (!session_id()) {
    session_start();
}
if (isset($_GET["group-id"]) && isset($_GET["zgt"])){
	$_SESSION["zume_group_id"] = $_GET["group-id"];
	$_SESSION["zume_group_token"] = $_GET["zgt"];
}



if (isset($_SESSION["zume_group_id"]) && isset($_SESSION["zume_group_token"])){
	$group = groups_get_group((int)$_SESSION["zume_group_id"]);
	$group_token = groups_get_groupmeta($group->id, "group_token");
	if (isset($group_token) && $group_token == $_SESSION["zume_group_token"]){
		if (!groups_is_user_member(get_current_user_id(), $_SESSION["zume_group_id"]) && $group->creator_id){
//			$_SESSION["test"] = groups_invite_user(array(
//				"user_id"=>get_current_user_id(),
//				"group_id" => $_SESSION["zume_group_id"],
//				"inviter_id" => $group->creator_id,
//				"is_confirmed" => true
//				)
//			);

			if (groups_accept_invite(get_current_user_id(), $_SESSION["zume_group_id"])){
				$_SESSION["zume_group_id"] = "";
				$_SESSION["zume_group_token"] = "";
				//send welcome to group email
				$args = array(
					'tokens' => array (
						'group.name'    => $group->name,
						'group.url'     => esc_url(bp_get_group_permalink($group))
					)
				);
				bp_send_email('member_automatically_added_to_group', get_current_user_id(), $args);
			};
		}
	}
}

function generate_string($length) {

	$chars = "0123456789abcdefghijklmnopqrstuvwxyz";
	$string = "";

        for ($i = 0; $i < $length; $i++) {
	  $string .= $chars[mt_rand(0, strlen($chars) - 1)];
	}

	return $string;
}

function set_group_defaults($group_id){
	groups_edit_group_settings($group_id, false, "private", "admins");
	if (!groups_get_groupmeta($group_id, "group_token")){
		$token = generate_string(10);
		groups_update_groupmeta($group_id, "group_token",$token);
	}
}

add_action( 'groups_created_group',  'set_group_defaults' );



/**
 * Parses email addresses, comma-separated or line-separated, into an array
 *
 * @package Invite Anyone
 * @since 0.8.8
 *
 * @param str $address_string The raw string from the input box
 * @return array $emails An array of addresses
 */
function invite_by_email_parse_addresses( $address_string ) {

	$emails = array();

	// First, split by line breaks
	$rows = explode( "\n", $address_string );

	// Then look through each row to split by comma
	foreach( $rows as $row ) {
		$row_addresses = explode( ',', $row );

		// Then walk through and add each address to the array
		foreach( $row_addresses as $row_address ) {
			$row_address_trimmed = trim( $row_address );

			// We also have to make sure that the email address isn't empty
			if ( ! empty( $row_address_trimmed ) && ! in_array( $row_address_trimmed, $emails ) )
				$emails[] = $row_address_trimmed;
		}
	}

	return apply_filters( 'invite_anyone_parse_addresses', $emails, $address_string );
}

function group_invite_by_email() {
	if (!wp_verify_nonce( $_POST["_wpnonce"],"invite_by_email")){
		return false;
	}
	$group = groups_get_group($_POST["group_id"]);
	$errors = array();
	if ( isset( $_POST["invite_by_email_addresses"] ) ) {
		$addresses = invite_by_email_parse_addresses($_POST["invite_by_email_addresses"]);
		foreach ($addresses as $address){
			$args = array(
				'tokens' => array (
					'group.name'    => $group->name,
					'inviter.name'  => $_POST["inviter_name"],
					'group.sign_up' => $_POST["sign_up_url"]
				)
			);
			$sent = bp_send_email('invite_to_group_email', $address, $args);
			if ($sent !== true){
				$errors[] = $address;
			}
		}
	}

	if (!empty($errors)){
		bp_core_add_message("Emails not sent to: " . implode(" ", $errors), "error");
	} else {
		bp_core_add_message("Emails sent.");
	}

	return wp_redirect($_POST["_wp_http_referer"]);
}


add_action("admin_post_group_invite_by_email", "group_invite_by_email");


