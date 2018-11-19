<?php
/**
 * Login customizations
 */

if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

require_once( get_theme_file_path() . '/vendor/autoload.php' );

/**********************************************************************************************************************
 * Customize links for signup and registration
 * @see wp-login.php:765
 */
add_filter( 'wp_signup_location', 'zume_multisite_signup_location', 99, 1 );
function zume_multisite_signup_location( $url ) {
    $url = zume_get_posts_translation_url( 'Login', zume_current_language() );
    return $url;
}
add_filter( 'register_url', 'zume_multisite_register_location', 99, 1 );
function zume_multisite_register_location( $url ) {
    $url = zume_get_posts_translation_url( 'Login', zume_current_language() ) . '/?action=registration';
    return $url;
}

/**
 * Modify default link for login
 * @see zume-functions.php for the function
 */
add_filter( 'login_url', 'zume_login_url', 99, 3 );

/**
 * Update User IP Address location on login
 */
add_action( 'wp_login', 'zume_login_update_ip_info', 10, 2 );
function zume_login_update_ip_info( $user_login, $user ) {
    zume_update_user_ip_address_and_location( $user->ID );
}

/**
 * LOGIN
 */
/**
 * Changes the logo link from wordpress.org to your site
 */
function zume_site_url() {
    $current_language = zume_current_language();
    if ( 'en' != $current_language ) {
        $home_url = site_url() . '/' . $current_language;
    } else {
        $home_url = site_url();
    }
    return $home_url;
}
add_filter( 'login_headerurl', 'zume_site_url' );

/**
 * Changes the alt text on the logo to show your site name
 */
function zume_login_title() {
    return get_option( 'blogname' );
}
add_filter( 'login_headertitle', 'zume_login_title' );

/* Main redirection of the default login page */
function zume_redirect_login_page() {
    if ( isset( $_SERVER['REQUEST_URI'] ) && !empty( $_SERVER['REQUEST_URI'] ) ) {
        $login_page  = zume_get_posts_translation_url( 'Login', zume_current_language() );
        $page_viewed = basename( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) );

        if ( isset( $_SERVER['REQUEST_METHOD'] ) && $page_viewed == "wp-login.php" && $_SERVER['REQUEST_METHOD'] == 'GET') {
            wp_redirect( $login_page );
            exit;
        }
    }
}
add_action( 'init', 'zume_redirect_login_page' );

/* Where to go if a login failed */
function zume_custom_login_failed() {
    $login_page  = zume_get_posts_translation_url( 'Login', zume_current_language() );
    wp_redirect( $login_page . '?login=failed' );
    exit;
}
add_action( 'wp_login_failed', 'zume_custom_login_failed' );

/* Where to go if any of the fields were empty */
function zume_verify_user_pass($user, $username, $password) {
    $login_page  = zume_get_posts_translation_url( 'Login', zume_current_language() );
    if ($username == "" || $password == "") {
        wp_redirect( $login_page . "?login=empty" );
        exit;
    }
}
add_filter( 'authenticate', 'zume_verify_user_pass', 1, 3 );


function zume_retrieve_password() {
    $errors = new WP_Error();

    if ( empty( $_POST['user_login'] ) || ! is_string( $_POST['user_login'] ) ) {
        $errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or email address.'));
    } elseif ( strpos( $_POST['user_login'], '@' ) ) {
        $user_data = get_user_by( 'email', trim( wp_unslash( $_POST['user_login'] ) ) );
        if ( empty( $user_data ) )
            $errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
    } else {
        $login = trim($_POST['user_login']);
        $user_data = get_user_by('login', $login);
    }

    /**
     * Fires before errors are returned from a password reset request.
     *
     * @since 2.1.0
     * @since 4.4.0 Added the `$errors` parameter.
     *
     * @param WP_Error $errors A WP_Error object containing any errors generated
     *                         by using invalid credentials.
     */
    do_action( 'lostpassword_post', $errors );

    if ( $errors->get_error_code() )
        return $errors;

    if ( !$user_data ) {
        $errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or email.'));
        return $errors;
    }

    // Redefining user_login ensures we return the right case in the email.
    $user_login = $user_data->user_login;
    $user_email = $user_data->user_email;
    $key = get_password_reset_key( $user_data );

    if ( is_wp_error( $key ) ) {
        return $key;
    }

    if ( is_multisite() ) {
        $site_name = get_network()->site_name;
    } else {
        /*
         * The blogname option is escaped with esc_html on the way into the database
         * in sanitize_option we want to reverse this for the plain text arena of emails.
         */
        $site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
    }

    $message = __( 'Someone has requested a password reset for the following account:' ) . "\r\n\r\n";
    /* translators: %s: site name */
    $message .= sprintf( __( 'Site Name: %s'), $site_name ) . "\r\n\r\n";
    /* translators: %s: user login */
    $message .= sprintf( __( 'Username: %s'), $user_login ) . "\r\n\r\n";
    $message .= __( 'If this was a mistake, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
    $message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
    $message .= '<' . zume_login_url() . "?action=rp&key=$key&login=" . rawurlencode( $user_login ) . ">\r\n";

    /* translators: Password reset email subject. %s: Site name */
    $title = sprintf( __( '[%s] Password Reset' ), $site_name );

    /**
     * Filters the subject of the password reset email.
     *
     * @since 2.8.0
     * @since 4.4.0 Added the `$user_login` and `$user_data` parameters.
     *
     * @param string  $title      Default email title.
     * @param string  $user_login The username for the user.
     * @param WP_User $user_data  WP_User object.
     */
    $title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

    /**
     * Filters the message body of the password reset mail.
     *
     * If the filtered message is empty, the password reset email will not be sent.
     *
     * @since 2.8.0
     * @since 4.1.0 Added `$user_login` and `$user_data` parameters.
     *
     * @param string  $message    Default mail message.
     * @param string  $key        The activation key.
     * @param string  $user_login The username for the user.
     * @param WP_User $user_data  WP_User object.
     */
    $message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

    if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
        wp_die( __('The email could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.') );

    return true;
}



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

    /**
     * Handles sign in and registration via Google account
     * @param \WP_REST_Request $request
     *
     * @return bool|\WP_Error
     */
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
            $picture_url = $payload['picture'];

            $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
            $username = str_replace( ' ', '_', $payload['name'] );

        } else {
            return new WP_Error(__METHOD__, 'Failed Google Verification of User Token' ); // Invalid ID token
        }


        $user_id = $this->query_google_email( $user_email );
        // if no google_sso_email found and user with email does not exist
        if ( empty( $user_id ) && ! email_exists( $user_email ) ) {

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

            add_user_meta( $user_id, 'google_sso_email', $user_email, true );

            add_user_to_blog( get_current_blog_id(), $user_id, 'subscriber' ); // add user to ZumeProject site.

        }
        // if no google_sso_email found but user with email does exist
        else if (  empty( $user_id ) && email_exists( $user_email ) ) {
            $user_id = email_exists( $user_email );
            add_user_meta( $user_id, 'google_sso_email', $user_email, true );
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

    /**
     * Gets first match for Google email or returns false.
     *
     * @param $email_address
     *
     * @return bool|string
     */
    public function query_google_email( $email_address ) {
        global $wpdb;
        $result = $wpdb->get_var( $wpdb->prepare( "
        SELECT user_id 
        FROM $wpdb->usermeta 
        WHERE meta_key = 'google_sso_email'
          AND meta_value = %s
          LIMIT 1
        ", $email_address ), ARRAY_A );

        if ( ! empty( $result ) ) {
            return $result;
        } else {
            return false;
        }
    }


    /********************************************************************************************************************
     * Form Registration
     ********************************************************************************************************************/

    /**
     * @see https://code.tutsplus.com/tutorials/creating-a-custom-wordpress-registration-form-plugin--cms-20968
     *
     * @see https://css-tricks.com/password-strength-meter/
     *
     */
    public function registration_form() {
        $this->custom_registration_function();
        ?>
        <style>
            meter{
                width:100%;
            }
            /* Webkit based browsers */
            meter[value="1"]::-webkit-meter-optimum-value { background: red; }
            meter[value="2"]::-webkit-meter-optimum-value { background: yellow; }
            meter[value="3"]::-webkit-meter-optimum-value { background: orange; }
            meter[value="4"]::-webkit-meter-optimum-value { background: green; }

            /* Gecko based browsers */
            meter[value="1"]::-moz-meter-bar { background: red; }
            meter[value="2"]::-moz-meter-bar { background: yellow; }
            meter[value="3"]::-moz-meter-bar { background: orange; }
            meter[value="4"]::-moz-meter-bar { background: green; }

        </style>
        <div id="loginform">
            <form action="" method="post" data-abide novalidate>
                <div data-abide-error class="alert callout" style="display: none;">
                    <p><i class="fi-alert"></i><?php esc_html_e('There are some errors in your form.' ) ?></p>
                </div>
                <div class="grid-container">
                    <div class="grid-x grid-margin-x">
                        <div class="cell small-12">
                            <label for="email"><?php esc_attr_e( 'Email' ) ?> <strong>*</strong></label>
                            <input type="text" name="email" id="email" value="<?php echo $info['email'] ?? null ?>" required pattern="email">
                        </div>
                        <div class="cell small-12">
                            <label><?php esc_html_e( 'Password Required') ?> <strong>*</strong>
                                <input type="password" id="password" name="password" placeholder="yeti4preZ" aria-errormessage="password-error-1" required >
                                <span class="form-error" id="password-error-1">
                                <?php esc_html_e('Password required' ) ?>
                              </span>
                            </label>
                            <meter max="4" id="password-strength-meter" value="0"></meter>
<!--                            <p id="password-strength-text"></p>-->
                        </div>
                        <div class="cell small-12">
                            <label><?php esc_html_e( 'Re-enter Password') ?> <strong>*</strong>
                                <input type="password" placeholder="yeti4preZ" aria-errormessage="password-error-2" data-equalto="password">
                                <span class="form-error" id="password-error-2">
                                <?php esc_html_e( 'Passwords do not match. Please, try again.' ) ?>
                              </span>
                            </label>
                        </div>
                        </div>
                        <div class="cell small-12">
                            <div class="g-recaptcha" id="g-recaptcha"></div><br>
                        </div>
                        <div class="cell small-12">
                            <input type="submit" class="button button-primary" id="submit" value="<?php esc_html_e( 'Register') ?>" disabled />
                        </div>
                        <script>
                            jQuery(document).ready( function() {

                                console.log(<?php echo json_encode( $_POST ) ?>);

                                jQuery('#g-recaptcha-response').change( function() {
                                    console.log( 'captcha created' )
                                })
                            })
                        </script>
                    </div>
                </div>
            </form>
            <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
            <script>
                var strength = {
                    0: "Worst",
                    1: "Bad",
                    2: "Weak",
                    3: "Good",
                    4: "Strong"
                }
                var password = document.getElementById('password');
                var meter = document.getElementById('password-strength-meter');
                var text = document.getElementById('password-strength-text');

                password.addEventListener('input', function() {
                    var val = password.value;
                    var result = zxcvbn(val);

                    // Update the password strength meter
                    meter.value = result.score;

                    // Update the text indicator
                    if (val !== "") {
                        text.innerHTML = "Strength: " + strength[result.score];
                    } else {
                        text.innerHTML = "";
                    }
                });
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
        </div>
        <?php
    }

    public function custom_registration_function() {

       // validate recaptcha with Google
        if ( empty( $_POST ) || ! isset( $_POST['g-recaptcha-response'] ) ) {
            return 'Missing captcha response. How did you do that?';
        }
        $args = [
            'method' => 'POST',
            'body' => [
                'secret' => get_option('dt_google_captcha_key'),
                'response' => sanitize_text_field( $_POST['g-recaptcha-response'] ),
            ]
        ];
        $post_result = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', $args );
        $post_body = json_decode( wp_remote_retrieve_body($post_result), true );
        if ( ! isset( $post_body['success'] ) || false === $post_body['success'] ) {
            return 'Captcha failure. Try again, if you are human.';
        }

        // validate elements
        if ( empty( $_POST['email'] ) || empty( $_POST['password'] ) ) {
            return 'Missing email or password';
        }

        // sanitize user form input
        $password   =   esc_attr( $_POST['password'] );
        $email      =   sanitize_email( $_POST['email'] );
        $explode_email = explode( '@', $email );
        if ( isset( $explode_email[0] ) ) {
            $username = $explode_email[0];
        } else {
            $username = str_replace( '@', '_', $email );
            $username = str_replace( '.', '_', $username );
        }
        $username   =   sanitize_user( $username );

        if ( email_exists( $email ) ) {
            return 'Sorry. This email is already registered. If you forgot your password, use the forgot password form.';
        }

        if ( username_exists( $username ) ) {
            $username = $username . rand( 0, 9 );
        }

        $user_id = wp_create_user( $username, $password, $email );

        if ( is_wp_error( $user_id ) ) {
            return 'Something went wrong. Sorry. Could you try again?';
        }

        zume_update_user_ip_address_and_location( $user_id ); // record ip address and location

        $current_language = zume_current_language();
        add_user_meta( $user_id, 'zume_language', $current_language, true );
        add_user_meta( $user_id, 'zume_phone_number', null, true );
        add_user_meta( $user_id, 'zume_address', null, true );
        add_user_meta( $user_id, 'zume_affiliation_key', null, true );

        add_user_to_blog( get_current_blog_id(), $user_id, 'subscriber' ); // add user to ZumeProject site.

        // log user in
        $user = get_user_by( 'id', $user_id );
        if( $user ) {
            wp_set_current_user( $user_id, $user->user_login );
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user->user_login, $user );
            wp_safe_redirect( zume_home_url( $current_language ) );
            exit;
        } else {
            return 'No user found.';
        }
    }
}
Zume_User_Registration::instance();
