<?php

if ( ! function_exists( 'post_exists' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/post.php' );
}
/**
 * New Email Template to copy
 */
/*
function email(){
	$title = __("", 'zume_project');
	// Do not create if it already exists and is not in the trash
    $post_exists = post_exists( '[{{{site.name}}}] ' . $title );

    if ( $post_exists != 0 && get_post_status( $post_exists ) == 'publish' )
       return;

    $email_html = __('', 'zume_project');
    $email_content = __('', 'zume_project');

    // Create post object
    $my_post = array(
      'post_title'    => '[{{{site.name}}}] ' . $title,
      'post_content'  => $email_html,
      'post_excerpt'  => $email_content,
      'post_status'   => 'publish',
      'post_type' => bp_get_email_post_type() // this is the post type for email
    );

    // Insert the email post into the database
    $post_id = wp_insert_post( $my_post );

    if ( $post_id ) {
    // add our email to the taxonomy term 'post_received_comment'
        // Email is a custom post type, therefore use wp_set_object_terms

        $tt_ids = wp_set_object_terms( $post_id, '[[ fill this out ]]', bp_get_email_tax_type() );
        foreach ( $tt_ids as $tt_id ) {
            $term = get_term_by( 'term_taxonomy_id', (int) $tt_id, bp_get_email_tax_type() );
            wp_update_term( (int) $term->term_id, bp_get_email_tax_type(), array(
                'description' => '',
            ) );
        }
    }

}
add_action( 'bp_core_install_emails', 'email' );
*/



function zume_group_enough_members_email() {

    $title = __( "Your group has enough members to start the first session", 'zume_project' );
    // Do not create if it already exists and is not in the trash
    $post_exists = post_exists( '[{{{site.name}}}] ' . $title );

    if ( $post_exists != 0 && get_post_status( $post_exists ) == 'publish' ) {
        return;
    }

    $email_html = __('Hi {{recipient.name}},

Fantastic! Your Zúme Training Group, {{group.name}}, now has at least four people who have activated their accounts. You are ready to begin your first session. Pick a time that works for all of you and get started!

', 'zume_project');
    $email_content = __('Hi {{recipient.name}},

Fantastic! Your Zúme Training Group, {{group.name}}, now has at least four people who have activated their accounts. You are ready to begin your first session. Pick a time that works for all of you and get started!

', 'zume_project');

    // Create post object
    $my_post = array(
      'post_title'    => '[{{{site.name}}}] ' . $title,
      'post_content'  => $email_html,
      'post_excerpt'  => $email_content,
      'post_status'   => 'publish',
      'post_type' => bp_get_email_post_type() // this is the post type for email
    );

    // Insert the email post into the database
    $post_id = wp_insert_post( $my_post );

    if ( $post_id ) {
    // add our email to the taxonomy term 'post_received_comment'
        // Email is a custom post type, therefore use wp_set_object_terms

        $tt_ids = wp_set_object_terms( $post_id, 'group_enough_members', bp_get_email_tax_type() );
        foreach ( $tt_ids as $tt_id ) {
            $term = get_term_by( 'term_taxonomy_id', (int) $tt_id, bp_get_email_tax_type() );
            wp_update_term( (int) $term->term_id, bp_get_email_tax_type(), array(
                'description' => 'Group has enough members',
            ) );
        }
    }

}
add_action( 'bp_core_install_emails', 'zume_group_enough_members_email' );


function zume_your_three_month_plan_email(){
    $title = __( "Your plan", 'zume_project' );
    // Do not create if it already exists and is not in the trash
    $post_exists = post_exists( '[{{{site.name}}}] ' . $title );

    if ( $post_exists != 0 && get_post_status( $post_exists ) == 'publish' ) {
        return;
    }

    $email_html = __('Hi {{recipient.name}},

Here\'s a copy of the 3-month plan you submitted. A copy was sent to your coach. You can keep it for your personal reference. Feel free to forward it on to your training partner so you can pray for one another and hold each other accountable to these commitments.

{{three_month_plan}}

Zúme. Multiplying disciples. It\'s who we are. It\'s what we do.', 'zume_project');
    $email_content = __('Hi {{recipient.name}},

Here\'s a copy of the 3-month plan you submitted. A copy was sent to your coach. You can keep it for your personal reference. Feel free to forward it on to your training partner so you can pray for one another and hold each other accountable to these commitments.

{{three_month_plan}}

Zúme. Multiplying disciples. It\'s who we are. It\'s what we do.', 'zume_project');

    // Create post object
    $my_post = array(
        'post_title'    => '[{{{site.name}}}] ' . $title,
        'post_content'  => $email_html,
        'post_excerpt'  => $email_content,
        'post_status'   => 'publish',
        'post_type' => bp_get_email_post_type() // this is the post type for email
    );

    // Insert the email post into the database
    $post_id = wp_insert_post( $my_post );

    if ( $post_id ) {
        // add our email to the taxonomy term 'post_received_comment'
        // Email is a custom post type, therefore use wp_set_object_terms

        $tt_ids = wp_set_object_terms( $post_id, 'your_three_month_plan', bp_get_email_tax_type() );
        foreach ( $tt_ids as $tt_id ) {
            $term = get_term_by( 'term_taxonomy_id', (int) $tt_id, bp_get_email_tax_type() );
            wp_update_term( (int) $term->term_id, bp_get_email_tax_type(), array(
                'description' => 'Here is your 3 month plan.',
            ) );
        }
    }

}
add_action( 'bp_core_install_emails', 'zume_your_three_month_plan_email' );


function zume_automatically_added_to_group_email() {

    $title = __( 'Added to Group', 'zume_project' );

    // Do not create if it already exists and is not in the trash
    $post_exists = post_exists( '[{{{site.name}}}] ' . $title );

    if ( $post_exists != 0 && get_post_status( $post_exists ) == 'publish' ) {
        return;
    }

    $post_content = 'Congratulations! You are now part of the Zúme group &quot;<a href="{{{group.url}}}">{{group.name}}</a>&quot;

Return to <a href="{{{site.url}}}">ZumeProject.com</a> to:
<ul>
	<li>Communicate with your group and begin planning your first session together.</li>
	<li>Invite others to the group. You will need at least 4 people present to start Session 1.</li>
	<li>Check out the "About" page to download the Guidebook and view other resources.</li>
</ul>
	';
    $post_excerpt = 'Congratulations! You are now part of the Zúme group "{{group.name}}"

To view the group, visit: {{{group.url}}}

Return to {{{site.url}}} to:
- Communicate with your group and begin planning your first session together.
- Invite others to the group. You will need at least 4 people present to start Session 1.
- Check out the "About" page to download the Guidebook and view other resources.';

    // Create post object
    $my_post = array(
        'post_title'    => '[{{{site.name}}}] ' . $title,
        'post_content'  => $post_content,
        'post_excerpt'  => $post_excerpt,
        'post_status'   => 'publish',
        'post_type' => bp_get_email_post_type() // this is the post type for email
    );

    // Insert the email post into the database
    $post_id = wp_insert_post( $my_post );

    if ( $post_id ) {
        // add our email to the taxonomy term 'post_received_comment'
        // Email is a custom post type, therefore use wp_set_object_terms

        $tt_ids = wp_set_object_terms( $post_id, 'member_automatically_added_to_group', bp_get_email_tax_type() );
        foreach ( $tt_ids as $tt_id ) {
            $term = get_term_by( 'term_taxonomy_id', (int) $tt_id, bp_get_email_tax_type() );
            wp_update_term( (int) $term->term_id, bp_get_email_tax_type(), array(
                'description' => 'A member is automatically added to a group',
            ) );
        }
    }

}
add_action( 'bp_core_install_emails', 'automatically_added_to_group' );




function zume_invite_to_group_email() {

    $title = __( 'Join my training group', "zume_project" );

    // Do not create if it already exists and is not in the trash
    $post_exists = post_exists( '[{{{site.name}}}] '. $title );

    if ( $post_exists != 0 && get_post_status( $post_exists ) == 'publish' ) {
        return;
    }

    $post_content = '
Hello from Zúme Project!

One of your friends just invited you to start an exciting journey -- a journey into learning how to make disciples who make disciples.

Your friend, {{inviter.name}}, would like you to join their Zúme training group, &quot;{{group.name}}&quot;.

Go <a href="{{{group.sign_up}}}">here</a> to accept your invitation. After you click on this link, it will ask you to create an account. Then you will be joined to your group.

When you, your friend who invited you and at least two other people are gathered together, you can begin going through the Zúme training.

Join the movement of ordinary people who God could use to change the world.
';
    $post_exerpt = '
Hello from Zúme Project!

One of your friends just invited you to start an exciting journey -- a journey into learning how to make disciples who make disciples.

Your friend, {{inviter.name}}, would like you to join their Zúme training group, "{{group.name}}".

Go to {{group.sign_up}} to accept your invitation. After you click on this link, it will ask you to create an account. Then you will be joined to your group.

When you, your friend who invited you and at least two other people are gathered together, you can begin going through the Zúme training.

Join the movement of ordinary people who God could use to change the world.
	';


    // Create post object
    $my_post = array(
        'post_title'    => '[{{{site.name}}}] '. $title,
        'post_content'  => $post_content,  // HTML email content.
        'post_excerpt'  => $post_exerpt,
        'post_status'   => 'publish',
        'post_type' => bp_get_email_post_type() // this is the post type for email
    );

    // Insert the email post into the database
    $post_id = wp_insert_post( $my_post );

    if ( $post_id ) {
        // add our email to the taxonomy term 'post_received_comment'
        // Email is a custom post type, therefore use wp_set_object_terms

        $tt_ids = wp_set_object_terms( $post_id, 'zume_invite_to_group_email', bp_get_email_tax_type() );
        foreach ( $tt_ids as $tt_id ) {
            $term = get_term_by( 'term_taxonomy_id', (int) $tt_id, bp_get_email_tax_type() );
            wp_update_term( (int) $term->term_id, bp_get_email_tax_type(), array(
                'description' => 'Invite to a group by email',
            ) );
        }
    }

}
add_action( 'bp_core_install_emails', 'zume_invite_to_group_email' );

