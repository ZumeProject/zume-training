<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly




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
        register_rest_route( $namespace, '/logout', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'logout' ],
            ],
        ] );
    }

    public function register_via_google( WP_REST_Request $request ) {
        dt_write_log(__METHOD__ );
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
            $user_email = $payload['email'];
            $user_nicename = $payload['name'];
            $first_name = $payload['given_name'];
            $last_name = $payload['family_name'];
            $language = $payload['locale'];
            $picture_url = $payload['picture'];
            $user_url = $payload['hd'];

            $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
            $username = str_replace( ' ', '_', $payload['name'] );

        } else {
            return new WP_Error(__METHOD__, 'Failed Google Verification of User Token' ); // Invalid ID token
        }

        // if does not exist
        $user_id = email_exists( $user_email );
        if ( empty( $user_id ) ) {

            // create a user from Google data
            $userdata = [
                'user_login'      => sanitize_user( $username, false ) . '_'. rand( 100, 999),
                'user_url'        => sanitize_text_field( $picture_url ),
                'user_pass'       => $random_password,  // When creating an user, `user_pass` is expected.
                'user_nicename'   => sanitize_text_field( $user_nicename ),
                'user_email'      => sanitize_email( $user_email ),
                'display_name'    => sanitize_text_field( $user_nicename ),
                'nickname'        => sanitize_text_field( $user_nicename ),
                'first_name'      => sanitize_text_field( $first_name ),
                'last_name'       => sanitize_text_field( $last_name ),
                'user_registered' => current_time( 'mysql' ),
            ];
            dt_write_log($userdata);

            $user_id = wp_insert_user( $userdata );

            if ( is_wp_error( $user_id ) || 0 === $user_id ) {
                dt_write_log($user_id);
                // return WP_Error
                return $user_id;
            }

            zume_update_user_ip_address_and_location( $user_id ); // record ip address and location

            add_user_meta( $user_id, 'zume_language', zume_current_language(), true );
            add_user_meta( $user_id, 'zume_phone_number', null, true );
            add_user_meta( $user_id, 'zume_address', null, true );
            add_user_meta( $user_id, 'zume_affiliation_key', null, true );

            add_user_to_blog( get_current_blog_id(), $user_id, 'subscriber' ); // add user to ZumeProject site.

        }

        // add google id if needed
        if ( ! ( $google_id = get_user_meta( $user_id, 'google_sso_id' ) ) ) {
            update_user_meta( $user_id, 'google_sso_id', $google_user_id );
        }

        // store google session token
        update_user_meta( $user_id, 'google_session_token', $google_token );

        // log user in
        $user = get_user_by( 'id', $user_id );
        if( $user ) {
            wp_set_current_user( $user_id, $user->user_login );
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user->user_login, $user );
            return true;
        } else {
            return new WP_Error(__METHOD__, 'No user found.' );
        }
    }

    public function logout() {
        wp_destroy_current_session();
        wp_clear_auth_cookie();
        wp_logout();
        return true;
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

    registration_form(
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













































//add_filter('lostpassword_url', 'zume_lost_password_url');
//function zume_lost_password_url() {
//    $url = zume_get_posts_translation_url('Forgot Password');
//    return $url;
//}
/**********************************************************************************************************************/

function zume_mu_register_styles() {
    ?>
    <style type="text/css">
        div#signup-content {
            margin: 1% auto;
            width: 40%;
            border: 1px solid #323A68;
            padding: 15px;
        }

        p .submit {
            padding: 15px;
        }
        p.submit input:hover {
            background-color: #323A68;
            color: white;
            cursor: pointer;
        }

        /* On screens that are 992px or less, set the background color to blue */
        @media screen and (max-width: 992px) {
            div#signup-content {
                margin: 10px auto;
                width: 60%;
            }
        }

        /* On screens that are 600px or less, set the background color to olive */
        @media screen and (max-width: 600px) {
            div#signup-content {
                margin: 10px auto;
                width: 95%;
            }
        }
    </style>
    <?php
}

function zume_mu_disable_header() {
    ?>
    <style type="text/css">
        #zume-main-menu {display:none;}
        .wp-activate-container a {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
    <script>
        jQuery(document).ready(function() {
            jQuery('#signup-content').append('<p style="text-align:center;"><a class="button" href="<?php echo esc_url( site_url( '/login' ) )  ?>"><?php esc_attr( 'Login' ) ?></a></p>')

        })
    </script>
    <?php
}
add_action( 'signup_header', 'zume_mu_register_styles' );
add_action( 'activate_wp_head', 'zume_mu_register_styles' );
add_action( 'activate_wp_head', 'zume_mu_disable_header' );


/***********************************************************************************************************************
 * Modify Registration Form
 */

function zume_mu_register_form() {

    ?>
    <p>
        <label for="first_name"><?php esc_attr_e( 'First Name (optional for coaching)', 'zume' ) ?><br />
            <input type="text" name="first_name" id="first_name" class="input" value="" size="25" /></label>
    </p>
    <p>
        <label for="last_name"><?php esc_attr_e( 'Last Name (optional for coaching)', 'zume' ) ?><br />
            <input type="text" name="last_name" id="last_name" class="input" value="" size="25" /></label>
    </p>
    <p>
        <label for="zume_phone_number"><?php esc_attr_e( 'Phone Number (optional for coaching)', 'zume' ) ?><br />
            <input type="text" name="zume_phone_number" id="zume_phone_number" class="input" value="" size="25" /></label>
    </p>
    <p>
        <label for="zume_address"><?php esc_attr_e( 'Address (optional for coaching)', 'zume' ) ?><br />
            <input type="text" name="zume_address" id="zume_address" class="input" value="" size="25" />
        </label>
    </p>
    <?php
    $key = '';
    if ( isset( $_GET['affiliation'] ) ) {
        $key = strtoupper( sanitize_key( wp_unslash( $_GET['affiliation'] ) ) );
    }
    ?>
    <p class="grid-x grid-padding-x" style="width:100%">
        <label for="zume_affiliation_key"><?php esc_attr_e( 'Affiliation Key (optional)', 'zume' ) ?></label><br>
        <input type="text" value="<?php echo esc_html( $key ) ?>" id="zume_affiliation_key"
               name="zume_affiliation_key" maxlength="5" />
    </p>
    <br clear="all" />
    <style>#signup-content .wp-signup-container h2 {display:none;}</style>
    <?php wp_nonce_field( 'custom_registration_actions', 'custom_registration_nonce', false, true ) ?>

    <?php
    dt_write_log( __METHOD__ );
    dt_write_log( 'step 1' );
}
add_action( 'signup_extra_fields', 'zume_mu_register_form' );

//2. Add validation. In this case, we make sure first_name is required.
add_filter( 'registration_errors', 'zume_mu_registration_errors', 10, 3 );
function zume_mu_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( isset( $_POST['custom_registration_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['custom_registration_nonce'] ) ), 'custom_registration_actions' ) ) {
        if ( empty( $_POST['zume_address'] ) || ! empty( $_POST['zume_address'] ) && trim( sanitize_text_field( wp_unslash( $_POST['zume_address'] ) ) ) == '' ) {

            $results = Disciple_Tools_Google_Geocode_API::query_google_api( trim( sanitize_text_field( wp_unslash( $_POST['zume_address'] ) ) ), 'validate' );

            if ( ! $results ) {
                $errors->add( 'zume_address_error', esc_attr__( '<strong>ERROR</strong>: We can not recognize this address as valid location. Please, check spelling.', 'zume' ) );
            }
        }
    }

    dt_write_log( __METHOD__ );
    dt_write_log( 'validation step' );
    return $errors;
}

// Stores form data for activation
add_filter( 'add_signup_meta', 'custom_add_signup_meta' );
function custom_add_signup_meta( $meta ) {
    if ( isset( $_POST['custom_registration_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['custom_registration_nonce'] ) ), 'custom_registration_actions' ) ) {
        $first_name = '';
        $last_name = '';
        $zume_phone_number = '';
        $zume_address = '';
        $zume_affiliation_key = '';

        if ( ! empty( $_POST['first_name'] ) ) {
            $first_name = trim( sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) );
        }
        if ( ! empty( $_POST['last_name'] ) ) {
            $last_name = trim( sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) );
        }
        if ( ! empty( $_POST['zume_phone_number'] ) ) {
            $zume_phone_number = trim( sanitize_text_field( wp_unslash( $_POST['zume_phone_number'] ) ) );
        }
        if ( ! empty( $_POST['zume_address'] ) ) {
            $zume_address = trim( sanitize_text_field( wp_unslash( $_POST['zume_address'] ) ) );
        }
        if ( ! empty( $_POST['zume_affiliation_key'] ) ) {
            $zume_affiliation_key = trim( sanitize_key( wp_unslash( $_POST['zume_affiliation_key'] ) ) );
        }

        $user_meta = [
            'first_name'           => $first_name,
            'last_name'            => $last_name,
            'zume_phone_number'    => $zume_phone_number,
            'zume_address'         => $zume_address,
            'zume_affiliation_key' => $zume_affiliation_key,
        ];

        $meta['user_meta'] = $user_meta;
        dt_write_log( __METHOD__ );
        dt_write_log( 'Step 2' );
        dt_write_log( $meta );
    }

    return $meta;
}

// Save after activation step
add_action( 'wpmu_activate_user', 'custom_wpmu_activate_blog', 10, 3 );
function custom_wpmu_activate_blog(  $user_id, $password, $meta ) {
    dt_write_log( __METHOD__ );
    dt_write_log( "Save step" );

    // Capture user submitted fields
    if ( isset( $meta['user_meta']['first_name'] ) && ! empty( $meta['user_meta']['first_name'] ) ) {
        update_user_meta( $user_id, 'first_name', trim( sanitize_key( wp_unslash( $meta['user_meta']['first_name'] ) ) ) );
    }
    if ( isset( $meta['user_meta']['last_name'] ) && ! empty( $meta['user_meta']['last_name'] ) ) {
        update_user_meta( $user_id, 'last_name', trim( sanitize_key( wp_unslash( $meta['user_meta']['last_name'] ) ) ) );
    }
    if ( isset( $meta['user_meta']['zume_phone_number'] ) && ! empty( $meta['user_meta']['zume_phone_number'] ) ) {
        update_user_meta( $user_id, 'zume_phone_number', trim( sanitize_key( wp_unslash( $meta['user_meta']['zume_phone_number'] ) ) ) );
    }
    if ( isset( $meta['user_meta']['zume_address'] ) && ! empty( $meta['user_meta']['zume_address'] ) ) {

        $results = Disciple_Tools_Google_Geocode_API::query_google_api( trim( sanitize_key( wp_unslash( $meta['user_meta']['zume_address'] ) ) ), 'core' );

        if ( $results ) {
            update_user_meta( $user_id, 'zume_user_address', $results['formatted_address'] );
            update_user_meta( $user_id, 'zume_user_lng', $results['lng'] );
            update_user_meta( $user_id, 'zume_user_lat', $results['lat'] );
            update_user_meta( $user_id, 'zume_raw_location', $results );
        }
    }
    if ( isset( $meta['user_meta']['zume_affiliation_key'] ) && ! empty( $meta['user_meta']['zume_affiliation_key'] ) ) {
        update_user_meta( $user_id, 'zume_affiliation_key', trim( sanitize_key( wp_unslash( $meta['user_meta']['zume_affiliation_key'] ) ) ) );
    }

    zume_update_user_ip_address_and_location( $user_id ); // record ip address and location

    update_user_meta( $user_id, 'zume_language', zume_current_language() );

    add_user_to_blog( get_current_blog_id(), $user_id, 'subscriber' ); // add user to ZumeProject site.

}

/**********************************************************************************************************************/