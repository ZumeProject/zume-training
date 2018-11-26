<?php
/**
 * Login customizations
 */

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

    public function __construct() {
        require_once( get_theme_file_path() . '/vendor/autoload.php' );

        add_action( 'rest_api_init', array( $this,  'add_api_routes' ) );
    }

    public function add_api_routes() {
        $namespace = 'zume/v1';
        register_rest_route( $namespace, '/register_via_google', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'register_via_google' ],
            ],
        ] );
        register_rest_route( $namespace, '/register_via_facebook', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'register_via_facebook' ],
            ],
        ] );
        register_rest_route( $namespace, '/link_account_via_google', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'link_account_via_google' ],
            ],
        ] );
        register_rest_route( $namespace, '/link_account_via_facebook', [
            [
                'methods'             => WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'link_account_via_facebook' ],
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
        dt_write_log( __METHOD__ );
        $params = $request->get_json_params();

        // verify token authenticity
        /** @see https://developers.google.com/identity/sign-in/web/backend-auth */

        // Get $id_token via HTTPS POST.
        $google_sso_key = get_option( 'dt_google_sso_key' );

        $google_token = $params['token'];

        \Firebase\JWT\JWT::$leeway = 300;

        $client = new Google_Client( [ 'client_id' => $google_sso_key ] );  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken( $google_token );
        if ( $payload ) {
            $google_user_id = $payload['sub'];
            $user_email = $payload['email'];
            $user_nicename = $payload['name'];
            $first_name = $payload['given_name'];
            $last_name = $payload['family_name'];
            $picture_url = $payload['picture'];

            $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
            $username = str_replace( ' ', '_', $payload['name'] );

        } else {
            dt_write_log( $payload );
            return new WP_Error( __METHOD__, 'Failed Google Verification of User Token' ); // Invalid ID token
        }


        $user_id = $this->query_google_email( $user_email );
        // if no google_sso_email found and user with email does not exist
        if ( empty( $user_id ) && ! email_exists( $user_email ) ) {

            // create a user from Google data
            $userdata = [
                'user_login'      => sanitize_user( $username, false ) . '_'. rand( 100, 999 ),
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
                dt_write_log( $user_id );
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
        else if ( empty( $user_id ) && email_exists( $user_email ) ) {
            $user_id = email_exists( $user_email );
            add_user_meta( $user_id, 'google_sso_email', $user_email, true );

            if ( empty( get_user_meta( $user_id, 'first_name' ) ) ) {
                update_user_meta( $user_id, 'first_name', $first_name );
            }
            if ( empty( get_user_meta( $user_id, 'last_name' ) ) ) {
                update_user_meta( $user_id, 'last_name', $last_name );
            }
            if ( empty( get_user_meta( $user_id, 'nickname' ) ) ) {
                update_user_meta( $user_id, 'nickname', $user_nicename );
            }

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
        if ( $user ) {
            wp_set_current_user( $user_id, $user->user_login );
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user->user_login, $user );
            return true;
        } else {
            return new WP_Error( __METHOD__, 'No user found.' );
        }
    }

    public function link_account_via_google( WP_REST_Request $request ) {
        dt_write_log( __METHOD__ );
        $params = $request->get_json_params();

        // verify token authenticity
        /** @see https://developers.google.com/identity/sign-in/web/backend-auth */

        // Get $id_token via HTTPS POST.
        $google_sso_key = get_option( 'dt_google_sso_key' );

        $google_token = $params['token'];

        \Firebase\JWT\JWT::$leeway = 300;

        $client = new Google_Client( [ 'client_id' => $google_sso_key ] );  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken( $google_token );
        if ( $payload ) {
            $google_user_id = $payload['sub'];
            $google_email = $payload['email'];
            $user_nicename = $payload['name'];
            $first_name = $payload['given_name'];
            $last_name = $payload['family_name'];

        } else {
            dt_write_log( $payload );
            return new WP_Error( __METHOD__, 'Failed Google Verification of User Token' ); // Invalid ID token
        }

        $current_user_id = get_current_user_id();
        $current_userdata = get_userdata( $current_user_id );
        if ( empty( $current_user_id ) || empty( $current_userdata ) ) {
            return new WP_Error( __METHOD__, __( 'No user found.', 'zume' ) );
        }

        if ( ! ( $google_email === $current_userdata->user_email ) ) { // if current user email is not the same as the facebook email

            // test if another wp user account is established with the facebook email
            $another_user_id_with_facebook_email = email_exists( $google_email );
            if ( $another_user_id_with_facebook_email ) {

                return new WP_Error( __METHOD__, 'Facebook email already linked with another account. Login to this account or use forgot password tool to access account.' );
            }

            // test if another wp user is linked with the facebook email account
            $existing_link = $this->query_facebook_email( $google_email );
            if ( $existing_link ) {
                return new WP_Error( __METHOD__, 'Facebook already linked with another account.' );
            }
        }

        add_user_meta( $current_user_id, 'google_sso_email', $google_email, true );

        if ( empty( get_user_meta( $current_user_id, 'first_name' ) ) ) {
            update_user_meta( $current_user_id, 'first_name', $first_name );
        }
        if ( empty( get_user_meta( $current_user_id, 'last_name' ) ) ) {
            update_user_meta( $current_user_id, 'last_name', $last_name );
        }
        if ( empty( get_user_meta( $current_user_id, 'nickname' ) ) ) {
            update_user_meta( $current_user_id, 'nickname', $user_nicename );
        }

        // add google id if needed
        if ( ! get_user_meta( $current_user_id, 'google_sso_id' ) ) {
            update_user_meta( $current_user_id, 'google_sso_id', $google_user_id );
        }

        // store google session token
        update_user_meta( $current_user_id, 'google_session_token', $google_token );

        return true;
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
        ", $email_address ) );

        if ( ! empty( $result ) ) {
            return $result;
        } else {
            return false;
        }
    }

    public function register_via_facebook( WP_REST_Request $request ) {
        dt_write_log( __METHOD__ );
        $params = $request->get_json_params();

        if ( empty( $params['token'] ) ) {
            return new WP_Error( __METHOD__, __( 'You are missing your sign-in token. Try signing in again.', 'zume' ) );
        }

        try {
            $fb = new \Facebook\Facebook([
                'app_id' => '762591594092101',
                'app_secret' => '030f8acd0eeab4dae9c2608e49f4042a',
                'default_graph_version' => 'v3.2',
                //                'default_access_token' => $params['token'],
            ]);
        } catch ( Exception $exception ) {
            return new WP_Error( __METHOD__, __( 'Failed to connect with Facebook. Try again.', 'zume' ), $exception );
        }

        try {
            $fb_response = $fb->get( '/me?fields=name,email,first_name,last_name', $params['token'] );

            $payload = $fb_response->getDecodedBody();

            $facebook_user_id = $payload['id'];
            $user_email = $payload['email'];
            $user_nicename = $payload['name'];
            $first_name = $payload['first_name'];
            $last_name = $payload['last_name'];

            $random_password = wp_generate_password( $length = 12, $include_standard_special_chars = false );
            $username = str_replace( ' ', '_', $payload['name'] );

        } catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
            // When Graph returns an error
            return new WP_Error( __METHOD__, __( 'Facebook user lookup error. Sorry for the inconvenience.', 'zume' ), $e->getMessage() );
        } catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
            // When validation fails or other local issues
            return new WP_Error( __METHOD__, __( 'Error with looking up user with Facebook. Sorry for the inconvenience.', 'zume' ), $e->getMessage() );
        }

        $user_id = $this->query_facebook_email( $user_email );
        // if no google_sso_email found and user with email does not exist
        if ( empty( $user_id ) && ! email_exists( $user_email ) ) {

            // create a user from Google data
            $userdata = [
                'user_login'      => sanitize_user( $username, false ) . '_'. rand( 100, 999 ),
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
                dt_write_log( $user_id );
                // return WP_Error
                return $user_id;
            }

            zume_update_user_ip_address_and_location( $user_id ); // record ip address and location

            add_user_meta( $user_id, 'zume_language', zume_current_language(), true );
            add_user_meta( $user_id, 'zume_phone_number', null, true );
            add_user_meta( $user_id, 'zume_address', null, true );
            add_user_meta( $user_id, 'zume_affiliation_key', null, true );

            add_user_meta( $user_id, 'facebook_sso_email', $user_email, true );

            add_user_to_blog( get_current_blog_id(), $user_id, 'subscriber' ); // add user to ZumeProject site.

        }
        // if no facebook_sso_email found but user with email does exist
        else if ( empty( $user_id ) && email_exists( $user_email ) ) {
            $user_id = email_exists( $user_email );

            add_user_meta( $user_id, 'facebook_sso_email', $user_email, true );

            if ( empty( get_user_meta( $user_id, 'first_name' ) ) ) {
                update_user_meta( $user_id, 'first_name', $first_name );
            }
            if ( empty( get_user_meta( $user_id, 'last_name' ) ) ) {
                update_user_meta( $user_id, 'last_name', $last_name );
            }
            if ( empty( get_user_meta( $user_id, 'nickname' ) ) ) {
                update_user_meta( $user_id, 'nickname', $user_nicename );
            }

            add_user_to_blog( get_current_blog_id(), $user_id, 'subscriber' ); // add user to ZumeProject site.
        }


        // add google id if needed
        if ( ! ( $facebook_user_id = get_user_meta( $user_id, 'facebook_sso_id' ) ) ) {
            update_user_meta( $user_id, 'facebook_sso_id', $facebook_user_id );
        }

        // store google session token
        update_user_meta( $user_id, 'facebook_session_token', $params['token'] );

        // log user in
        $user = get_user_by( 'id', $user_id );
        if ( $user ) {
            dt_write_log( 'User exists ' );
            wp_set_current_user( $user_id, $user->user_login );
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user->user_login, $user );
            return true;
        } else {
            return new WP_Error( __METHOD__, 'No user found.' );
        }


    }

    public function link_account_via_facebook( WP_REST_Request $request ) {

        dt_write_log( __METHOD__ );
        $params = $request->get_json_params();

        if ( empty( $params['token'] ) ) {
            return new WP_Error( __METHOD__, __( 'You are missing your sign-in token. Try signing in again.', 'zume' ) );
        }

        try {
            $fb = new \Facebook\Facebook([
                'app_id' => get_option( 'dt_facebook_sso_pub_key' ),
                'app_secret' => get_option( 'dt_facebook_sso_sec_key' ),
                'default_graph_version' => 'v3.2',
            ]);
        } catch ( Exception $exception ) {
            return new WP_Error( __METHOD__, __( 'Failed to connect with Facebook. Try again.', 'zume' ), $exception );
        }

        try {
            $fb_response = $fb->get( '/me?fields=name,email,first_name,last_name', $params['token'] );

            $payload = $fb_response->getDecodedBody();

            $facebook_user_id = $payload['id'];
            $facebook_email = $payload['email'];
            $user_nicename = $payload['name'];
            $first_name = $payload['first_name'];
            $last_name = $payload['last_name'];

        } catch ( \Facebook\Exceptions\FacebookResponseException $e ) {
            // When Graph returns an error
            return new WP_Error( __METHOD__, __( 'Facebook user lookup error. Sorry for the inconvenience.', 'zume' ), $e->getMessage() );
        } catch ( \Facebook\Exceptions\FacebookSDKException $e ) {
            // When validation fails or other local issues
            return new WP_Error( __METHOD__, __( 'Error with looking up user with Facebook. Sorry for the inconvenience.', 'zume' ), $e->getMessage() );
        }

        $current_user_id = get_current_user_id();
        $current_userdata = get_userdata( $current_user_id );
        if ( empty( $current_user_id ) || empty( $current_userdata ) ) {
            return new WP_Error( __METHOD__, __( 'No user found.', 'zume' ) );
        }

        if ( ! ( $facebook_email === $current_userdata->user_email ) ) { // if current user email is not the same as the facebook email

            // test if another wp user account is established with the facebook email
            $another_user_id_with_facebook_email = email_exists( $facebook_email );
            if ( $another_user_id_with_facebook_email ) {
                return new WP_Error( __METHOD__, 'Facebook email already linked with another account. Login to this account or use forgot password tool to access account.' );
            }

            // test if another wp user is linked with the facebook email account
            $existing_link = $this->query_facebook_email( $facebook_email );
            if ( $existing_link ) {
                return new WP_Error( __METHOD__, 'Facebook already linked with another account.' );
            }
        }

        add_user_meta( $current_user_id, 'facebook_sso_email', $facebook_email, true );

        if ( empty( get_user_meta( $current_user_id, 'first_name' ) ) ) {
            update_user_meta( $current_user_id, 'first_name', $first_name );
        }
        if ( empty( get_user_meta( $current_user_id, 'last_name' ) ) ) {
            update_user_meta( $current_user_id, 'last_name', $last_name );
        }
        if ( empty( get_user_meta( $current_user_id, 'nickname' ) ) ) {
            update_user_meta( $current_user_id, 'nickname', $user_nicename );
        }

        // add google id if needed
        if ( ! ( get_user_meta( $current_user_id, 'facebook_sso_id' ) ) ) {
            update_user_meta( $current_user_id, 'facebook_sso_id', $facebook_user_id );
        }

        // store google session token
        update_user_meta( $current_user_id, 'facebook_session_token', $params['token'] );

        return true;

    }

    public function query_facebook_email( $email_address ) {
        global $wpdb;
        $result = $wpdb->get_var( $wpdb->prepare( "
        SELECT user_id 
        FROM $wpdb->usermeta 
        WHERE meta_key = 'facebook_sso_email'
          AND meta_value = %s
          LIMIT 1
        ", $email_address ) );

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
                <?php wp_nonce_field( 'login_form', 'login_form_nonce' ) ?>
                <div data-abide-error class="alert callout" style="display: none;">
                    <p><i class="fi-alert"></i><?php esc_html_e( 'There are some errors in your form.' ) ?></p>
                </div>
                <div class="grid-container">
                    <div class="grid-x grid-margin-x">
                        <div class="cell small-12">
                            <label for="email"><?php esc_attr_e( 'Email' ) ?> <strong>*</strong></label>
                            <input type="text" name="email" id="email" value="" required pattern="email">
                        </div>
                        <div class="cell small-12">
                            <label><?php esc_html_e( 'Password Required' ) ?> <strong>*</strong>
                                <input type="password" id="password" name="password" placeholder="yeti4preZ" aria-errormessage="password-error-1" required >
                                <span class="form-error" id="password-error-1">
                                <?php esc_html_e( 'Password required' ) ?>
                              </span>
                            </label>
                            <meter max="4" id="password-strength-meter" value="0"></meter>
                            <!--                            <p id="password-strength-text"></p>-->
                        </div>
                        <div class="cell small-12">
                            <label><?php esc_html_e( 'Re-enter Password' ) ?> <strong>*</strong>
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
                        <input type="submit" class="button button-primary" id="submit" value="<?php esc_html_e( 'Register' ) ?>" disabled />
                    </div>
                    <script>
                        jQuery(document).ready( function() {
                            jQuery('#g-recaptcha-response').change( function() {
                                console.log( 'captcha created' )
                            })
                        })
                    </script>
                </div>
            </form>
        </div>

        <?php // @codingStandardsIgnoreStart ?>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
        <?php // @codingStandardsIgnoreEnd ?>
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
        <?php // @codingStandardsIgnoreStart ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.2.0/zxcvbn.js"></script>
        <?php // @codingStandardsIgnoreEnd ?>
        <?php
    }

    public function custom_registration_function() {
        $error = new WP_Error();

        if ( ! ( isset( $_POST['login_form_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['login_form_nonce'] ) ), 'login_form' ) ) ) {
            return 0;
        }

        if ( ! isset( $_POST['g-recaptcha-response'] ) ) {
            $error->add( __METHOD__, __( 'Missing captcha response. How did you do that?', 'zume' ) );
            return $error;
        }
        $args = [
            'method' => 'POST',
            'body' => [
                'secret' => get_option( 'dt_google_captcha_key' ),
                'response' => sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ),
            ]
        ];
        $post_result = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', $args );
        $post_body = json_decode( wp_remote_retrieve_body( $post_result ), true );
        if ( ! isset( $post_body['success'] ) || false === $post_body['success'] ) {
            $error->add( __METHOD__, __( 'Captcha failure. Try again, if you are human.', 'zume' ) );
            return $error;
        }

        // validate elements
        if ( empty( $_POST['email'] ) || empty( $_POST['password'] ) ) {
            $error->add( __METHOD__, __( 'Missing email or password.', 'zume' ) );
            return $error;
        }

        $current_language = zume_current_language();

        // sanitize user form input
        $password   = sanitize_text_field( wp_unslash( $_POST['password'] ) );
        $email      = sanitize_email( wp_unslash( $_POST['email'] ) );
        $explode_email = explode( '@', $email );
        if ( isset( $explode_email[0] ) ) {
            $username = $explode_email[0];
        } else {
            $username = str_replace( '@', '_', $email );
            $username = str_replace( '.', '_', $username );
        }
        $username   = sanitize_user( $username );

        if ( email_exists( $email ) ) {
            $error->add( __METHOD__, sprintf( __( 'Sorry. This email is already registered. %1$s Go to Login %2$s', 'zume' ), '<a href="'. zume_login_url( $current_language ).'">', '</a>' ) );
            return $error;
        }

        if ( username_exists( $username ) ) {
            $username = $username . rand( 0, 9 );
        }

        $user_id = wp_create_user( $username, $password, $email );

        if ( is_wp_error( $user_id ) ) {
            $error->add( __METHOD__, __( 'Something went wrong. Sorry. Could you try again?', 'zume' ) );
            return $error;
        }

        zume_update_user_ip_address_and_location( $user_id ); // record ip address and location

        add_user_meta( $user_id, 'zume_language', $current_language, true );
        add_user_meta( $user_id, 'zume_phone_number', null, true );
        add_user_meta( $user_id, 'zume_address', null, true );
        add_user_meta( $user_id, 'zume_affiliation_key', null, true );

        add_user_to_blog( get_current_blog_id(), $user_id, 'subscriber' ); // add user to ZumeProject site.

        // log user in
        $user = get_user_by( 'id', $user_id );
        if ( $user ) {
            wp_set_current_user( $user_id, $user->user_login );
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user->user_login, $user );
            wp_safe_redirect( zume_home_url( $current_language ) );
            exit;
        } else {
            $error->add( __METHOD__, __( 'No new user found.', 'zume' ) );
            return $error;
        }
    }
}
Zume_User_Registration::instance();

function zume_spinner( $size = '15', $echo = true ) {
    if ( $echo ) {
        ?>
        <img src="<?php echo esc_url( site_url() ) ?>/wp-content/themes/zume-project-multilingual/assets/images/spinner.svg" width="<?php echo esc_attr( $size ) ?>px" />
        <?php
    } else {
        return '<img src="'. esc_url( site_url() ) . '/wp-content/themes/zume-project-multilingual/assets/images/spinner.svg" width="'. $size .'px" />';
    }
}

function zume_google_sign_in_button( $label = 'signin') {
    if ( 'register' === $label ) {
        $label = __( 'Register with Google', 'zume' );
    } else {
        $label = __( 'Login with Google', 'zume' );
    }
    ?>

    <button id="signinButton" class="button" style="width:100%;"><i class="fi-social-google-plus"></i> <?php echo esc_attr( $label ) ?></button>
    <div id="google_error"></div>
    <script>
        jQuery('#signinButton').click(function() {
            auth2.signIn().then(onSignIn);
        });

        function onSignIn(googleUser) {
            // Useful data for your client-side scripts:
            jQuery('#signinButton').attr('style', 'background-color: grey; width:100%;').append(' <?php zume_spinner( '15' ) ?>');

            let data = {
                "token": googleUser.getAuthResponse().id_token
            };
            jQuery.ajax({
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                url: '<?php echo esc_url( rest_url( '/zume/v1/register_via_google' ) ) ?>',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', '<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ) ?>');
                },
            })
                .done(function (data) {
                    console.log(data)
                    window.location = "<?php echo esc_url( esc_url( site_url() ) ) ?>"
                })
                .fail(function (err) {
                    signOut()
                    jQuery('#google_error').text( err.responseJSON['message'] )
                    console.log("error")
                    console.log(err)
                })
        }
    </script>

    <?php
}

function zume_google_link_account_button() {
    $label = __( 'Link with Google', 'zume' );
    ?>

    <button id="signinButton" class="button" style="width:100%;"><i class="fi-social-google-plus"></i> <?php echo esc_attr( $label ) ?></button>
    <div id="google_error"></div>
    <script>
        jQuery('#signinButton').click(function() {
            auth2.signIn().then(onSignIn);
        });

        function onSignIn(googleUser) {
            // Useful data for your client-side scripts:
            jQuery('#signinButton').attr('style', 'background-color: grey; width:100%;').append(' <?php zume_spinner( '15' ) ?>');

            let data = {
                "token": googleUser.getAuthResponse().id_token
            };
            jQuery.ajax({
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                url: '<?php echo esc_url( rest_url( '/zume/v1/link_account_via_google' ) ) ?>',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', '<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ) ?>');
                },
            })
                .done(function (data) {
                    window.location = "<?php echo esc_url( zume_profile_url() ) ?>"
                })
                .fail(function (err) {
                    jQuery('#google_error').text( err.responseJSON['message'] )
                    console.log("error")
                    console.log(err)
                })
        }
    </script>

    <?php
}

function zume_facebook_link_account_button() {
    ?>

    <!--Facebook signin-->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '<?php echo esc_attr( get_option( 'dt_facebook_sso_pub_key' ) ) ?>',
                cookie     : true,
                xfbml      : true,
                version    : 'v3.2'
            });

            FB.AppEvents.logPageView();
            checkLoginState()

        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    console.log('checkLoginState facebook connected')
                    console.log(response)
                } else {
                    // The person is not logged into this app or we are unable to tell.
                    console.log(' checkLoginState facebook not connected')
                }
            });
        }

        function fbLogIn() {
            FB.login(function(response) {
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    console.log('fbLogIn facebook connected')

                    jQuery('#facebook_login').attr('style', 'background-color: grey; width:100%;').append(' <?php zume_spinner( '15' ) ?>')

                    let data = {
                        "token": response.authResponse.accessToken
                    };
                    jQuery.ajax({
                        type: "POST",
                        data: JSON.stringify(data),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        url: '<?php echo esc_url( rest_url( '/zume/v1/link_account_via_facebook' ) ) ?>',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-WP-Nonce', '<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ) ?>');
                        },
                    })
                        .done(function (data) {
                            window.location = "<?php echo esc_url( zume_profile_url() ) ?>"
                        })
                        .fail(function (err) {
                            jQuery('#facebook_error').text( err.responseJSON['message'] )
                            console.log("error")
                            console.log(err)
                        })
                } else {
                    // The person is not logged into this app or we are unable to tell.
                    console.log('fbLogIn facebook not connected')
                }
            }, {scope: 'email'} )
        }

    </script>
    <a onclick="fbLogIn()" id="facebook_login" class="button" style="width:100%;"><i class="fi-social-facebook"></i> <?php esc_attr_e( 'Link Facebook', 'zume' ) ?></a>
    <div id="facebook_error"></div>

    <?php
}

function zume_facebook_login_button( $label = 'login') {
    // @see https://developers.facebook.com/apps/762591594092101/fb-login/quickstart/
    if ( 'register' === $label ) {
        $label = __( 'Register Facebook', 'zume' );
    } else {
        $label = __( 'Login with Facebook', 'zume' );
    }
    ?>

    <!--Facebook signin-->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '<?php echo esc_attr( get_option( 'dt_facebook_sso_pub_key' ) ) ?>',
                cookie     : true,
                xfbml      : true,
                version    : 'v3.2'
            });

            FB.AppEvents.logPageView();
            checkLoginState()

        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    console.log('checkLoginState facebook connected')
                    console.log(response)
                } else {
                    // The person is not logged into this app or we are unable to tell.
                    console.log(' checkLoginState facebook not connected')
                }
            });
        }

        function fbLogIn() {
            FB.login(function(response) {
                if (response.status === 'connected') {
                    // Logged into your app and Facebook.
                    console.log('fbLogIn facebook connected')

                    let data = {
                        "token": response.authResponse.accessToken
                    };
                    jQuery.ajax({
                        type: "POST",
                        data: JSON.stringify(data),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        url: '<?php echo esc_url( rest_url( '/zume/v1/register_via_facebook' ) ) ?>',
                        beforeSend: function(xhr) {
                            xhr.setRequestHeader('X-WP-Nonce', '<?php echo esc_attr( wp_create_nonce( 'wp_rest' ) ) ?>');
                        },
                    })
                        .done(function (data) {
                            console.log(data)
                            if ( data ) {
                                window.location = "<?php echo esc_url( site_url() ) ?>"
                            }
                        })
                        .fail(function (err) {
                            jQuery('#facebook_error').text( err.responseJSON['message'] )
                            console.log("error")
                            console.log(err)
                        })
                } else {
                    // The person is not logged into this app or we are unable to tell.
                    console.log('fbLogIn facebook not connected')
                }
            }, {scope: 'email'} )
        }

    </script>
    <a onclick="fbLogIn()" id="facebook_login" class="button" style="width:100%;"><i class="fi-social-facebook"></i> <?php echo esc_attr( $label ) ?></a>
    <div id="facebook_error"></div>
    <?php
}


function zume_unlink_facebook_account( $user_id ) {
    if ( isset( $_POST['unlink_facebook'] ) ) {
        if ( isset( $_POST['user_update_nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['user_update_nonce'] ), 'user_' . $user_id. '_update' ) ) {
            return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
        }

        delete_user_meta( $user_id, 'facebook_sso_email' );
        delete_user_meta( $user_id, 'facebook_session_token' );
        delete_user_meta( $user_id, 'facebook_sso_id' );
    }
    return 1;
}
add_action( 'zume_update_profile', 'zume_unlink_facebook_account' );

function zume_unlink_google_account( $user_id ) {
    if ( isset( $_POST['unlink_google'] ) ) {
        if ( isset( $_POST['user_update_nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['user_update_nonce'] ), 'user_' . $user_id. '_update' ) ) {
            return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
        }

        delete_user_meta( $user_id, 'google_sso_email' );
        delete_user_meta( $user_id, 'google_session_token' );
        delete_user_meta( $user_id, 'google_sso_id' );
    }
    return 1;
}
add_action( 'zume_update_profile', 'zume_unlink_google_account' );



// modifies the buttons of the login form.
function zume_login_styles() {
    ?>
    <style>
        body.login {
            background: none;
        }
        #wp-submit {
            background: #fefefe;
            border: 0;
            color: #323A68;
            font-size: medium;
            cursor: pointer;
            outline: #323A68 solid 1px;
            padding: 0.85em 1em;
            text-align: center;
            text-decoration: none;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            margin: 2px;
            height: inherit;
            text-shadow: none;
            float:right;
        }
        #wp-submit:hover {
            background: #323A68;
            border: 0;
            color: #fefefe;
            font-size: medium;
            cursor: pointer;
            outline: #323A68 solid 1px;
            padding: 0.85em 1em;
            text-align: center;
            text-decoration: none;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            margin: 2px;
            height:inherit;
            float:right;
        }
        .login h1 a {
            background: url(<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>) no-repeat top center;
            width: 326px;
            height: 67px;
            text-indent: -9999px;
            overflow: hidden;
            padding-bottom: 15px;
            display: block;
        }
        #nav a {
            background: #fefefe;
            border: 0;
            color: #323A68;
            font-size: medium;
            cursor: pointer;
            outline: #323A68 solid 1px;
            padding: 1em;
            text-align: center;
            text-decoration: none;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            margin: 2px;
        }
        #nav a:hover {
            background: #323A68;
            border: 0;
            color: #fefefe;
            font-size: medium;
            cursor: pointer;
            outline: #323A68 solid 1px;
            padding: 5px;
            text-align: center;
            text-decoration: none;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            margin: 2px;
        }
        @media only screen and (min-width: 640px) {
            #nav a {
                padding: 1em !important;
            }
            #nav a:hover {
                padding: 1em !important;
            }
        }
    </style>
    <?php
}

function zume_retrieve_password() {
    $errors = new WP_Error();

    if ( ! ( isset( $_POST['retrieve_password_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['retrieve_password_nonce'] ) ), 'retrieve_password' ) ) ) {
        $errors->add( __METHOD__, 'Missing form verification. Refresh and try again.' );
        return $errors;
    }

    if ( isset( $_POST['user_login'] ) ) {
        $user_login = trim( sanitize_text_field( wp_unslash( $_POST['user_login'] ) ) );
    } else {
        $errors->add( __METHOD__, __( 'Missing username or email address.' ) );
        return $errors;
    }


    if ( empty( $user_login ) ) {
        $errors->add( __METHOD__, __( 'ERROR: Enter a username or email address.' ) );
    } elseif ( strpos( $user_login, '@' ) ) {
        $user_data = get_user_by( 'email', $user_login );
        if ( empty( $user_data ) ) {
            $errors->add( __METHOD__, __( 'ERROR: There is no user registered with that email address.' ) );
        }
    } else {
        $user_data = get_user_by( 'login', $user_login );
        if ( empty( $user_data ) ) {
            $errors->add( __METHOD__, __( 'ERROR: There is no user registered with that username.' ) );
        }
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

    if ( $errors->get_error_code() ) {
        return $errors;
    }

    if ( ! $user_data ) {
        $errors->add( 'invalidcombo', __( '<strong>ERROR</strong>: Invalid username or email.' ) );
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
    $message .= sprintf( __( 'Site Name: %s' ), $site_name ) . "\r\n\r\n";
    /* translators: %s: user login */
    $message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
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

    if ( $message && ! wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
        wp_die( esc_html__( 'The email could not be sent.' ) . "<br />\n" . esc_html__( 'Possible reason: your host may have disabled the mail() function.' ) );
    }

    return true;
}






















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







