<?php
// Calling your own login css so you can style it
function joints_login_css() {
	wp_enqueue_style( 'joints_login_css', get_template_directory_uri() . '/assets/css/login.min.css', false );
}

// changing the logo link from wordpress.org to your site
function joints_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function joints_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'joints_login_css', 10 );
add_filter('login_headerurl', 'joints_login_url');
add_filter('login_headertitle', 'joints_login_title');


//set the display name before the user is created/activate
add_filter("bp_email_recipient_get_name", "get_name_for_email", 10, 3);
function get_name_for_email($name, $recipient){
    $user = $recipient->get_user();
    $display_name = null;
    if (isset($user->ID)){
        $id = $user->ID;
        $display_name =  xprofile_get_field_data(1, $id);
    }

    if ($display_name){
        return $display_name;
    } else {
        if (isset($_POST["field_1"])){
            return $_POST["field_1"];
        } else {
            return $name;
        }
    }
}




