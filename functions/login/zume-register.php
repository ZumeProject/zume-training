<?php

/********************************************************************************************************************
 * Google Signon Registration
 ********************************************************************************************************************/

class Zume_User_Registration
{
    private static $_instance = null;
    public static function instance() {
        if ( is_null( self::$_instance ) ){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        add_action( 'rest_api_init', array( $this,  'add_api_routes' ) );
    }

    public function add_api_routes()
    {
        $namespace = 'zume/v1';
        register_rest_route( $namespace, '/register_via_google', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'register_via_google' ],
            ],
        ] );
    }

    public function register_via_google( WP_REST_Request $request ) {
        $params = $request->get_json_params();

        // verify token authenticity
        /** @see https://developers.google.com/identity/sign-in/web/backend-auth */

        require_once( get_theme_file_path() . '/vendor/autoload.php' );

        // Get $id_token via HTTPS POST.
        $google_sso_key = get_option( 'dt_google_sso_key' );
        $google_token = $params['token'];

        $client = new Google_Client([ 'client_id' => $google_sso_key ]);  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken( $google_token );
        if ( $payload ) {
            $google_user_id = $payload['sub'];
            $username = $payload['username'];
            $user_email = $payload['email'];
            $first_name = $payload['given_name'];
            $last_name = $payload['family_name'];
            $language = $payload['locale'];
            $picture_url = $payload['picture'];
            $user_nicename = $payload['name'];
            $user_url = $payload['hd'];
            $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );

            dt_write_log( $payload );
        } else {
            return new WP_Error(__METHOD__, 'Failed Google Verification of User Token' ); // Invalid ID token
        }

        if ( email_exists( $user_email ) === true ) {

        }

//        $userdata = [
//            'user_login'  =>  'login_name',
//            'user_url'    =>  '',
//            'user_pass'   =>  $random_password,  // When creating an user, `user_pass` is expected.
//        ];
//        wp_insert_user( $userdata );
        return $payload;

    }

}
Zume_User_Registration::instance();

/********************************************************************************************************************
 * Form Registration
 ********************************************************************************************************************/

/**
 * @see https://code.tutsplus.com/tutorials/creating-a-custom-wordpress-registration-form-plugin--cms-20968
 */
/**
 * @param $username
 * @param $password
 * @param $email
 * @param $website
 * @param $first_name
 * @param $last_name
 * @param $nickname
 * @param $bio
 */
function registration_form( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio ) {
    echo '
                <style>
                div {
                    margin-bottom:2px;
                }
                 
                input{
                    margin-bottom:4px;
                }
                </style>
                ';

    echo '
                <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                <div>
                <label for="username">Username <strong>*</strong></label>
                <input type="text" name="username" value="' . ( isset( $_POST['username'] ) ? $username : null ) . '">
                </div>
                 
                <div>
                <label for="password">Password <strong>*</strong></label>
                <input type="password" name="password" value="' . ( isset( $_POST['password'] ) ? $password : null ) . '">
                </div>
                 
                <div>
                <label for="email">Email <strong>*</strong></label>
                <input type="text" name="email" value="' . ( isset( $_POST['email']) ? $email : null ) . '">
                </div>
                 
                <div>
                <label for="website">Website</label>
                <input type="text" name="website" value="' . ( isset( $_POST['website']) ? $website : null ) . '">
                </div>
                 
                <div>
                <label for="firstname">First Name</label>
                <input type="text" name="fname" value="' . ( isset( $_POST['fname']) ? $first_name : null ) . '">
                </div>
                 
                <div>
                <label for="website">Last Name</label>
                <input type="text" name="lname" value="' . ( isset( $_POST['lname']) ? $last_name : null ) . '">
                </div>
                 
                <div>
                <label for="nickname">Nickname</label>
                <input type="text" name="nickname" value="' . ( isset( $_POST['nickname']) ? $nickname : null ) . '">
                </div>
                 
                <div>
                <label for="bio">About / Bio</label>
                <textarea name="bio">' . ( isset( $_POST['bio']) ? $bio : null ) . '</textarea>
                </div>
                <input type="submit" name="submit" value="Register"/>
                </form>
                ';
}

function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        registration_validation(
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $_POST['website'],
            $_POST['fname'],
            $_POST['lname'],
            $_POST['nickname'],
            $_POST['bio']
        );

        // sanitize user form input
        global $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );
        $website    =   esc_url( $_POST['website'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        $nickname   =   sanitize_text_field( $_POST['nickname'] );
        $bio        =   esc_textarea( $_POST['bio'] );

        // call @function complete_registration to create the user
        // only when no WP_error is found
        complete_registration(
            $username,
            $password,
            $email,
            $website,
            $first_name,
            $last_name,
            $nickname,
            $bio
        );
    }

//    registration_form(
//        $username,
//        $password,
//        $email,
//        $website,
//        $first_name,
//        $last_name,
//        $nickname,
//        $bio
//    );
}
function complete_registration( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio ) {
    global $reg_errors, $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio;
    if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
            'user_login'    =>   $username,
            'user_email'    =>   $email,
            'user_pass'     =>   $password,
            'user_url'      =>   $website,
            'first_name'    =>   $first_name,
            'last_name'     =>   $last_name,
            'nickname'      =>   $nickname,
            'description'   =>   $bio,
        );
        $user = wp_insert_user( $userdata );
        echo 'Registration complete. Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>.';
    }
}

function registration_validation( $username, $password, $email, $website, $first_name, $last_name, $nickname, $bio )  {
    global $reg_errors;
    $reg_errors = new WP_Error;

    if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
        $reg_errors->add('field', 'Required form field is missing');
    }
    if ( 4 > strlen( $username ) ) {
        $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
    }
    if ( username_exists( $username ) ) {
        $reg_errors->add('user_name', 'Sorry, that username already exists!');
    }
    if ( ! validate_username( $username ) ) {
        $reg_errors->add( 'username_invalid', 'Sorry, the username you entered is not valid' );
    }
    if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'Password length must be greater than 5' );
    }
    if ( !is_email( $email ) ) {
        $reg_errors->add( 'email_invalid', 'Email is not valid' );
    }
    if ( email_exists( $email ) ) {
        $reg_errors->add( 'email', 'Email Already in use' );
    }
    if ( ! empty( $website ) ) {
        if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
            $reg_errors->add( 'website', 'Website is not a valid URL' );
        }
    }
    if ( is_wp_error( $reg_errors ) ) {

        foreach ( $reg_errors->get_error_messages() as $error ) {

            echo '<div>';
            echo '<strong>ERROR</strong>:';
            echo $error . '<br/>';
            echo '</div>';

        }

    }
}