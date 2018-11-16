<?php
/*
Template Name: Zume Login
*/

/**
 * Catch Logout Request and Process Immediately
 */
$current_language = zume_current_language();
if ( isset( $_GET['action'] ) && 'logout' === $_GET['action'] ) {
    wp_destroy_current_session();
    wp_clear_auth_cookie();
    wp_safe_redirect( zume_home_url( $current_language ) );
    exit;
}

add_action( 'wp_head', 'wp_no_robots' );

nocache_headers();

// Fix for page title
$wp_query->is_404 = false;

function zume_signup_header() {
    ?>
    <script src="https://apis.google.com/js/platform.js?onload=start" async defer></script>
    <script>
        function start() {
            gapi.load('auth2', function() {
                auth2 = gapi.auth2.init({
                    client_id: '<?php echo get_option( 'dt_google_sso_key' ); ?>',
                    scope: 'profile email'
                });
            });
        }
    </script>
    <?php
}
add_action( 'wp_head', 'zume_signup_header' );


$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
$errors = new WP_Error();
$home_url = zume_home_url();

if ( isset($_GET['key']) )
    $action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array( $action, array( 'postpass', 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login', 'confirmation' ), true ) && false === has_filter( 'login_form_' . $action ) )
    $action = 'login';

switch ($action) {

case 'logout' :
    wp_destroy_current_session();
    wp_clear_auth_cookie();
    wp_safe_redirect( zume_home_url( $current_language ) );
    exit();

case 'postpass' :
    if ( ! array_key_exists( 'post_password', $_POST ) ) {
        wp_safe_redirect( wp_get_referer() );
        exit();
    }

    require_once ABSPATH . WPINC . '/class-phpass.php';
    $hasher = new PasswordHash( 8, true );

    $expire = apply_filters( 'post_password_expires', time() + 10 * DAY_IN_SECONDS );
    $referer = wp_get_referer();
    if ( $referer ) {
        $secure = ( 'https' === parse_url( $referer, PHP_URL_SCHEME ) );
    } else {
        $secure = false;
    }
    setcookie( 'wp-postpass_' . COOKIEHASH, $hasher->HashPassword( wp_unslash( $_POST['post_password'] ) ), $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );

    if ( $switched_locale ) {
        restore_previous_locale();
    }

    wp_safe_redirect( wp_get_referer() );
    exit();

case 'lostpassword' :
case 'retrievepassword' :

    dt_write_log(__METHOD__ . ': lost password' );
    if ( $http_post ) {
        $errors = zume_retrieve_password();
        if ( !is_wp_error($errors) ) {
            $redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : zume_home_url( $current_language );
            wp_safe_redirect( $redirect_to );
            exit();
        }
    }

    if ( isset( $_GET['error'] ) ) {
        if ( 'invalidkey' == $_GET['error'] ) {
            $errors->add( 'invalidkey', __( 'Your password reset link appears to be invalid. Please request a new link below.' ) );
        } elseif ( 'expiredkey' == $_GET['error'] ) {
            $errors->add( 'expiredkey', __( 'Your password reset link has expired. Please request a new link below.' ) );
        }
    }

    $lostpassword_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
    /**
     * Filters the URL redirected to after submitting the lostpassword/retrievepassword form.
     *
     * @since 3.0.0
     *
     * @param string $lostpassword_redirect The redirect destination URL.
     */
    $redirect_to = apply_filters( 'lostpassword_redirect', $lostpassword_redirect );

    /**
     * Fires before the lost password form.
     *
     * @since 1.5.1
     */
    do_action( 'lost_password' );

    $user_login = '';

    if ( isset( $_POST['user_login'] ) && is_string( $_POST['user_login'] ) ) {
        $user_login = wp_unslash( $_POST['user_login'] );
    }

    get_header();
    ?>

    <div id="content">
        <div id="login">
            <br>
            <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
                <div class="cell medium-3 large-4"></div>
                <div class="cell callout medium-6 large-4">
                    <div class="grid-x grid-padding-x grid-padding-y">
                        <div class="cell center"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" /></div>
                        <div class="cell">
                            <div class="wp_lostpassword_form">
                                <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( zume_lostpassword_url( $current_language ) ); ?>" method="post">
                                    <p>
                                        <label for="user_login" ><?php _e( 'Username or Email Address' ); ?><br />
                                            <input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr($user_login); ?>" size="20" /></label>
                                    </p>
                                    <?php
                                    /**
                                     * Fires inside the lostpassword form tags, before the hidden fields.
                                     *
                                     * @since 2.1.0
                                     */
                                    do_action( 'lostpassword_form' ); ?>
                                    <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
                                    <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Get New Password'); ?>" /></p>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell medium-3 large-4"></div>
            </div>

        </div>
    </div>



    <?php
    zume_login_styles();
    get_footer();
    break;

case 'resetpass' :
case 'rp' :
    get_header();

    list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
    $rp_cookie = 'wp-resetpass-' . COOKIEHASH;
    if ( isset( $_GET['key'] ) ) {
        $value = sprintf( '%s:%s', wp_unslash( $_GET['login'] ), wp_unslash( $_GET['key'] ) );
        setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
        wp_safe_redirect( remove_query_arg( array( 'key', 'login' ) ) );
        exit;
    }

    if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( $_COOKIE[ $rp_cookie ], ':' ) ) {
        list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[ $rp_cookie ] ), 2 );
        $user = check_password_reset_key( $rp_key, $rp_login );
        if ( isset( $_POST['pass1'] ) && ! hash_equals( $rp_key, $_POST['rp_key'] ) ) {
            $user = false;
        }
    } else {
        $user = false;
    }

    if ( ! $user || is_wp_error( $user ) ) {
        setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
        if ( $user && $user->get_error_code() === 'expired_key' )
            wp_redirect( site_url( 'login/?action=lostpassword&error=expiredkey' ) );
        else
            wp_redirect( site_url( 'login/?action=lostpassword&error=invalidkey' ) );
        exit;
    }

    $errors = new WP_Error();

    if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] )
        $errors->add( 'password_reset_mismatch', __( 'The passwords do not match.' ) );

    /**
     * Fires before the password reset procedure is validated.
     *
     * @since 3.5.0
     *
     * @param object           $errors WP Error object.
     * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
     */
    do_action( 'validate_password_reset', $errors, $user );

    if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
        reset_password($user, $_POST['pass1']);
        setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
        login_header( __( 'Password Reset' ), '<p class="message reset-pass">' . __( 'Your password has been reset.' ) . ' <a href="' . esc_url( wp_login_url() ) . '">' . __( 'Log in' ) . '</a></p>' );
        login_footer();
        exit;
    }

    wp_enqueue_script('utils');
    wp_enqueue_script('user-profile');

 ?>

    <div id="content">
        <div id="login">
            <br>
            <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
                <div class="cell medium-3 large-4"></div>
                <div class="cell callout medium-6 large-4">
                    <div class="grid-x grid-padding-x grid-padding-y">
                        <div class="cell center"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" /></div>
                        <div class="cell">
                            <div class="wp_resetpassword_form">
                                <form name="resetpassform" id="resetpassform" action="<?php echo esc_url( zume_login_url( $current_language ) . '/?action=resetpass' ); ?>" method="post" autocomplete="off">
                                    <input type="hidden" id="user_login" value="<?php echo esc_attr( $rp_login ); ?>" autocomplete="off" />

                                    <div class="user-pass1-wrap">
                                        <p>
                                            <label for="pass1"><?php _e( 'New password' ) ?></label>
                                        </p>

                                        <div class="wp-pwd">
                                            <div class="password-input-wrapper">
                                                <input type="password" data-reveal="1" data-pw="<?php echo esc_attr( wp_generate_password( 16 ) ); ?>" name="pass1" id="pass1" class="input password-input" size="24" value="" autocomplete="off" aria-describedby="pass-strength-result" />
                                                <span class="button button-secondary wp-hide-pw hide-if-no-js">
                                                    <span class="dashicons dashicons-hidden"></span>
                                                </span>
                                            </div>
                                            <div id="pass-strength-result" class="hide-if-no-js" aria-live="polite"><?php _e( 'Strength indicator' ); ?></div>
                                        </div>
                                        <div class="pw-weak">
                                            <label>
                                                <input type="checkbox" name="pw_weak" class="pw-checkbox" />
                                                <?php _e( 'Confirm use of weak password' ); ?>
                                            </label>
                                        </div>
                                    </div>

                                    <p class="user-pass2-wrap">
                                        <label for="pass2"><?php _e( 'Confirm new password' ) ?></label><br />
                                        <input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off" />
                                    </p>

                                    <p class="description indicator-hint"><?php echo wp_get_password_hint(); ?></p>
                                    <br class="clear" />

                                    <?php
                                    /**
                                     * Fires following the 'Strength indicator' meter in the user password reset form.
                                     *
                                     * @since 3.9.0
                                     *
                                     * @param WP_User $user User object of the user whose password is being reset.
                                     */
                                    do_action( 'resetpass_form', $user );
                                    ?>
                                    <input type="hidden" name="rp_key" value="<?php echo esc_attr( $rp_key ); ?>" />
                                    <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e('Reset Password'); ?>" /></p>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell medium-3 large-4"></div>
            </div>
        </div>
    </div>

    <?php
    zume_login_styles();
    get_footer();
    break;

case 'register' :
    get_header(); ?>

    <div id="content">
        <div id="login">
            <br>
            <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
                <div class="cell medium-3 large-4"></div>
                <div class="cell callout medium-6 large-4">
                    <div class="grid-x grid-padding-x grid-padding-y">
                        <div class="cell center"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" /></div>
                        <div class="cell"><?php zume_google_sign_in_button() ?></div>
                        <div class="cell">
                            <div class="wp_register_form">
                                <?php

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell medium-3 large-4"></div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="cell medium-3 large-4"></div>
                <div class="cell medium-6 large-4">
                    <p id="nav">
                        <?php echo '<a href="' . esc_url( zume_login_url( $current_language ) ) . '">'. esc_html__( 'Login' ) .'</a>'; ?>
                    </p>
                </div>
                <div class="cell medium-3 large-4"></div>
            </div>
        </div>
    </div>

    <?php
    zume_login_styles();
    get_footer();
    break;

case 'confirmation' :
    if ( ! isset( $_GET['request_id'] ) ) {
        wp_die( __( 'Invalid request.' ) );
    }

    $request_id = (int) $_GET['request_id'];

    if ( isset( $_GET['confirm_key'] ) ) {
        $key    = sanitize_text_field( wp_unslash( $_GET['confirm_key'] ) );
        $result = wp_validate_user_request_key( $request_id, $key );
    } else {
        $result = new WP_Error( 'invalid_key', __( 'Invalid key' ) );
    }

    if ( is_wp_error( $result ) ) {
        wp_die( $result );
    }

    /**
     * Fires an action hook when the account action has been confirmed by the user.
     *
     * Using this you can assume the user has agreed to perform the action by
     * clicking on the link in the confirmation email.
     *
     * After firing this action hook the page will redirect to wp-login a callback
     * redirects or exits first.
     *
     * @param int $request_id Request ID.
     */
    do_action( 'user_request_action_confirmed', $request_id );

    $message = _wp_privacy_account_request_confirmed_message( $request_id );

    login_header( __( 'User action confirmed.' ), $message );
    login_footer();
    exit;

case 'login' :
default: get_header(); ?>

    <div id="content">
        <div id="login">
            <br>
            <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
                <div class="cell medium-3 large-4"></div>
                <div class="cell callout medium-6 large-4">
                    <div class="grid-x grid-padding-x grid-padding-y">
                        <div class="cell center"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" /></div>
                        <div class="cell"><?php zume_google_sign_in_button() ?></div>
                        <div class="cell">
                            <div class="wp_login_form">
                                <?php
                                $args = array(
                                    'redirect' => site_url(),
                                    'id_username' => 'user',
                                    'id_password' => 'pass',
                                    'value_remember' => true,
                                );
                                wp_login_form( $args );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cell medium-3 large-4"></div>
            </div>
            <div class="grid-x grid-padding-x">
                <div class="cell medium-3 large-4"></div>
                <div class="cell medium-6 large-4">
                    <p id="nav">
                        <?php if ( ! isset( $_GET['checkemail'] ) || ! in_array( wp_unslash( $_GET['checkemail'] ), array( 'confirm', 'newpass' ) ) ) :
                            if ( get_option( 'users_can_register' ) ) :
                                echo '<a href="' . esc_url( zume_register_url( $current_language ) ) . '">'. esc_html__( 'Register' ) .'</a>';
                            endif;
                            ?>
                            <a href="<?php echo esc_url( zume_lostpassword_url( $current_language ) ); ?>"><?php esc_html_e( 'Lost your password?' ); ?></a>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="cell medium-3 large-4"></div>
            </div>
        </div>
    </div>

    <?php
    zume_login_styles();
    get_footer();
    break;


} // end action switch


function zume_google_sign_in_button() {
    ?>
    <button id="signinButton" class="button">Sign in with Google</button>
    <div id="google_error"></div>

    <script>
        jQuery('#signinButton').click(function() {
            auth2.signIn().then(onSignIn);
        });

        function onSignIn(googleUser) {
            // Useful data for your client-side scripts:
            jQuery('#signinButton').attr('style', 'background-color: grey');
            console.log(googleUser)

            let profile = googleUser.getBasicProfile();
            console.log("ID: " + profile.getId()); // Don't send this directly to your server!
            console.log('Full Name: ' + profile.getName());
            console.log('Given Name: ' + profile.getGivenName());
            console.log('Family Name: ' + profile.getFamilyName());
            console.log("Image URL: " + profile.getImageUrl());
            console.log("Email: " + profile.getEmail());

            // The ID token you need to pass to your backend:
            let id_token = googleUser.getAuthResponse().id_token;
            console.log("ID Token: " + id_token);

            let data = {
                "google_id": profile.getId(),
                "username": profile.getId(),
                "user_email": profile.getEmail(),
                "first_name": profile.getGivenName(),
                "last_name": profile.getFamilyName(),
                "website": profile.getImageUrl(),
                "token": googleUser.getAuthResponse().id_token
            };
            register_user_with_google_auth( data );
        }

        function register_user_with_google_auth( data ) {
            return jQuery.ajax({
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                url: '<?php echo rest_url('/zume/v1/register_via_google') ?>',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', '<?php echo wp_create_nonce( 'wp_rest' ) ?>');
                },
            })
                .done(function (data) {
                    console.log(data)
                    window.location = "<?php echo esc_url( site_url() ) ?>"
                })
                .fail(function (err) {
                    signOut()
                    jQuery('#google_error').text('Failed to authenticate your Google account')
                    console.log("error")
                    console.log(err)
                })
        }

    </script>
    <?php
}







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
