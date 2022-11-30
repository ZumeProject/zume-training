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
if ( is_user_logged_in() ) {
    wp_safe_redirect( zume_home_url( $current_language ) );
    exit;
}

nocache_headers();

// Fix for page title
$wp_query->is_404 = false;

add_action( 'wp_head', 'zume_signup_header' );

// set variables
// @codingStandardsIgnoreLine
$request_action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : 'login';

// @codingStandardsIgnoreLine
$http_post = ( 'POST' == $_SERVER['REQUEST_METHOD'] );
$form_errors = new WP_Error();
$home_url = zume_home_url();

// preset defaults
if ( isset( $_GET['key'] ) ) {
    $request_action = 'resetpass';
}
if ( !in_array( $request_action, array( 'postpass', 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login', 'confirmation' ), true ) && false === has_filter( 'login_form_' . $request_action ) ) {
    $request_action = 'login'; // validate action so as to default to the login screen
}


switch ($request_action) {

    case 'lostpassword' :
    case 'retrievepassword' :
        $sent = false;
        $user_login_response = '';

        if ( $http_post ) {
            if ( isset( $_POST['retrieve_password_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['retrieve_password_nonce'] ) ), 'retrieve_password' ) ) {

                $form_errors = zume_retrieve_password();
                if ( ! is_wp_error( $form_errors ) ) {
                    $sent = true;
                }

                if ( isset( $_POST['user_login'] ) ) {
                    $user_login_response = sanitize_text_field( wp_unslash( $_POST['user_login'] ) );
                }
            }
        }

        if ( isset( $_GET['error'] ) ) {
            if ( 'invalidkey' == $_GET['error'] ) {
                $form_errors->add( 'invalidkey', __( 'Your password reset link appears to be invalid. Please request a new link below.', 'zume' ) );
            } elseif ( 'expiredkey' == $_GET['error'] ) {
                $form_errors->add( 'expiredkey', __( 'Your password reset link has expired. Please request a new link below.', 'zume' ) );
            }
        }

        $lostpassword_redirect = ! empty( $_REQUEST['redirect_to'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['redirect_to'] ) ) : '';
        $redirect_to = apply_filters( 'lostpassword_redirect', $lostpassword_redirect );

        do_action( 'lost_password' );

        get_header();
        ?>

        <div id="content">
            <div id="login">
                <br>
                <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
                    <div class="cell medium-3 large-4"></div>
                    <div class="cell callout medium-6 large-4">
                        <div class="grid-x grid-padding-x grid-padding-y">
                            <div class="cell center">
                                <p><img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" alt="zume logo" /></p>
                                <h1 style="color:gray;font-size: 14px;margin:0;padding:5px;font-weight: normal;"><?php esc_html_e( "Get new password", 'zume' ) ?></h1>
                            </div>
                            <?php if ( ! empty( $form_errors->errors ) ) : ?>
                                <div class="cell alert callout">
                                    <?php
                                    echo esc_html( $form_errors->get_error_message() );
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="cell">
                                <div class="wp_lostpassword_form">
                                    <?php if ( ! $sent ) : ?>
                                    <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( zume_lostpassword_url( $current_language ) ); ?>" method="post">
                                        <?php wp_nonce_field( 'retrieve_password', 'retrieve_password_nonce', false, true ) ?>
                                        <p>
                                            <label for="user_login" ><?php echo esc_html__( 'Email Address', 'zume' ); ?><br />
                                                <input type="text" name="user_login" id="user_login" class="input" value="<?php echo esc_attr( $user_login_response ); ?>" size="20" /></label>
                                        </p>
                                        <?php
                                        /**
                                         * Fires inside the lostpassword form tags, before the hidden fields.
                                         *
                                         * @since 2.1.0
                                         */
                                        do_action( 'lostpassword_form' ); ?>
                                        <input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
                                        <p><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php echo esc_html__( 'Get New Password', 'zume' ); ?>" /></p>
                                    </form>
                                    <?php elseif ( $sent ): ?>
                                        <?php echo esc_html__( 'Your password reset email has been sent. Check your email or junk mail for the link to reset your password.', 'zume' ) ?>
                                    <?php endif; ?>

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
        // @codingStandardsIgnoreStart
        list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
        $rp_cookie = 'wp-resetpass-' . COOKIEHASH;
        if ( isset( $_GET['key'] ) && isset( $_GET['login'] ) ) {
            $value = sprintf( '%s:%s', wp_unslash( $_GET['login'] ), wp_unslash( $_GET['key'] ) );
            setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            wp_safe_redirect( remove_query_arg( array( 'key', 'login' ) ) );
            exit;
        }

        if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( sanitize_text_field( wp_unslash( $_COOKIE[ $rp_cookie ] ) ), ':' ) ) {
            list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[ $rp_cookie ] ), 2 );
            $user                      = check_password_reset_key( $rp_key, $rp_login );
            if ( isset( $_POST['pass1'] ) && ! hash_equals( $rp_key, $_POST['rp_key'] ) ) {
                $user = false;
            }
        } else {
            $user = false;
        }


        if ( ! $user || is_wp_error( $user ) ) {
            setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( site_url( 'login/?action=lostpassword&error=expiredkey' ) );
            } else {
                wp_redirect( site_url( 'login/?action=lostpassword&error=invalidkey' ) );
            }
            exit;
        }

        $form_errors = new WP_Error();

        if ( isset( $_POST['pass1'] ) && $_POST['pass1'] != $_POST['pass2'] ) {
            $form_errors->add( 'password_reset_mismatch', __( 'The passwords do not match.', 'zume' ) );
        }

        /**
         * Fires before the password reset procedure is validated.
         *
         * @since 3.5.0
         *
         * @param object           $errors WP Error object.
         * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
         */
        do_action( 'validate_password_reset', $form_errors, $user );

        if ( ( ! $form_errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
            reset_password( $user, $_POST['pass1'] );
            setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
        // @codingStandardsIgnoreEnd
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
                            <div class="cell"><?php echo sprintf( 'Your password is reset. %s You can login here %', '<a href="' . esc_url( zume_login_url( $current_language ) ) . '">', '</a>' ) ?></div>
                        </div>
                    </div>
                    <div class="cell medium-3 large-4"></div>
                </div>
            </div>
            <?php
            get_footer();
            exit;
        }

        get_header();
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
        <div id="content">
            <div id="login">
                <br>
                <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
                    <div class="cell medium-3 large-4"></div>
                    <div class="cell callout medium-6 large-4">
                        <div class="grid-x grid-padding-x grid-padding-y">
                            <div class="cell center">
                                <img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" alt="zume logo"/>
                                <h1 style="color:gray;font-size: 14px;margin:0;padding:5px;font-weight: normal;"><?php esc_html_e( "Reset Password", 'zume' ) ?></h1>

                            </div>
                            <?php if ( ! empty( $form_errors->errors ) ) :?>
                                <div class="cell alert callout">
                                    <?php
                                    echo esc_html( $form_errors->get_error_message() );
                                    ?>
                                </div>
                            <?php endif; ?>
                            <div class="cell">
                                <div class="wp_resetpassword_form">
                                    <form name="resetpassform" id="resetpassform" action="<?php echo esc_url( zume_login_url( $current_language ) . '/?action=resetpass' ); ?>" method="post" autocomplete="off" data-abide novalidate>
                                        <input type="hidden" id="user_login" value="<?php echo esc_attr( $rp_login ); ?>" autocomplete="off" />

                                        <p>
                                            <label><?php esc_html_e( 'Password Required', 'zume' ) ?> <strong>*</strong>
                                                <input type="password" id="pass1" name="pass1" placeholder="yeti4preZ" aria-errormessage="password-error-1" required >
                                                <span class="form-error" id="password-error-1">
                                                    <?php esc_html_e( 'Password required', 'zume' ) ?>
                                                </span>
                                            </label>
                                            <meter max="4" id="password-strength-meter" value="0"></meter>
                                            <p id="password-strength-text"></p>
                                        </p>
                                        <p>
                                            <label><?php esc_html_e( 'Re-enter Password', 'zume' ) ?> <strong>*</strong>
                                                <input type="password" name="pass2" placeholder="yeti4preZ" aria-errormessage="password-error-2" data-equalto="pass1">
                                                <span class="form-error" id="password-error-2">
                                                    <?php esc_html_e( 'Passwords do not match. Please, try again.', 'zume' ) ?>
                                                </span>
                                            </label>
                                        </p>


                                        <p class="description indicator-hint"><?php echo esc_html( wp_get_password_hint() ); ?></p>
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

                                        <p><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_html_e( 'Reset Password', 'zume' ); ?>" /></p>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cell medium-3 large-4"></div>
                </div>
            </div>
        </div>
        <script>
            var strength = {
                0: "Worst",
                1: "Bad",
                2: "Weak",
                3: "Good",
                4: "Strong"
            }
            var password = document.getElementById('pass1');
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
        get_footer();
    break;

    case 'register' :
        $register = Zume_User_Registration::instance();
        $reg_status = $register->custom_registration_function();

        get_header(); ?>

        <div id="content">
            <div id="login">
                <br>
                <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
                    <div class="cell medium-3 large-4"></div>
                    <div class="cell callout medium-6 large-4">
                        <div class="grid-x grid-padding-x grid-padding-y">
                            <div class="cell center" style="padding-bottom: 0;">
                                <span style="font-weight: bolder;font-size:2.5em;">
                                    <?php echo esc_html__( "Let's get started.", 'zume' ) ?>
                                </span>
                                <h1 style="color:gray;font-size: 14px;margin:0;padding:5px;font-weight: normal;"><?php esc_html_e( "Register", 'zume' ) ?></h1>
                            </div>

                            <div class="cell">

                                <p class="google_elements" style="display:none;">
                                    <?php zume_google_sign_in_button() ?>
                                </p>
                                <p class="facebook_elements" style="display:none;">
                                    <?php zume_facebook_login_button(); ?>
                                </p>

                                <span><hr /></span>
                                <div class="button hollow" onclick="jQuery('#email_signup_form').toggle();" style="width:100%;">
                                    <span style="float:left;">
                                        <img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/public_mail_hollow.png' ) ) ?>" style="width:20px;" />
                                    </span>
                                    <?php esc_html_e( 'Email', 'zume' ) ?>
                                </div>

                                <div id="email_signup_form" style="display:none;">
                                    <?php if ( is_wp_error( $reg_status ) ) :?>
                                        <div class="cell alert callout">
                                            <?php echo esc_html( $reg_status->get_error_message() ) ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="cell">
                                        <div class="wp_register_form">
                                            <?php
                                            $register->registration_form();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cell medium-3 large-4"></div>
                </div>
                <div class="grid-x grid-padding-x">
                    <div class="cell medium-3 large-4"></div>
                    <div class="cell medium-6 large-4">
                        <p>
                            <?php if ( ! isset( $_GET['checkemail'] ) || ! in_array( wp_unslash( $_GET['checkemail'] ), array( 'confirm', 'newpass' ) ) ) : ?>

                                <a href="<?php echo esc_url( zume_login_url( $current_language ) ) ?>"><?php esc_html_e( 'Login', 'zume' ) ?></a>
                                &nbsp;|&nbsp;
                                <a href="<?php echo esc_url( zume_lostpassword_url( $current_language ) ); ?>"><?php esc_html_e( 'Lost your password?', 'zume' ); ?></a>

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

    case 'confirmation' :
        if ( ! isset( $_GET['request_id'] ) ) {
            wp_die( esc_html__( 'Invalid request.', 'zume' ) );
        }

        $request_id = (int) $_GET['request_id'];

        if ( isset( $_GET['confirm_key'] ) ) {
            $key    = sanitize_text_field( wp_unslash( $_GET['confirm_key'] ) );
            $result = wp_validate_user_request_key( $request_id, $key );
        } else {
            $result = new WP_Error( 'invalid_key', __( 'Invalid key', 'zume' ) );
        }

        if ( is_wp_error( $result ) ) {
            wp_die( esc_attr( serialize( $result ) ) );
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

        login_header( __( 'User action confirmed.', 'zume' ), $message );
        login_footer();
    exit; // @todo possibly remove

    case 'login' :
    default:
        get_header(); ?>

        <div id="content">
            <div id="login">
                <br>
                <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
                    <div class="cell medium-3 large-4"></div>
                    <div class="cell callout medium-6 large-4">
                        <div class="grid-x grid-padding-x grid-padding-y">
                            <div class="cell center">
                                <img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" alt="zume logo" />
                                <h1 style="color:gray;font-size: 14px;margin:0;padding:5px;font-weight: normal;"><?php esc_html_e( "Login", 'zume' ) ?></h1>
                            </div>
                            <?php
                            if ( isset( $_GET['login'] ) && $_GET['login'] === 'failed' ) {
                                ?>
                                <div class="callout warning cell center">
                                    <?php echo esc_html__( 'Username or password does not match. Try again.', 'zume' ); ?>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="cell small-6">
                                <?php zume_google_sign_in_button() ?>
                            </div>
                            <div class="cell small-6">
                                <?php zume_facebook_login_button(); ?>
                            </div>
                            <div class="cell" style="border-top: 1px solid lightgray;">
                                <div class="wp_login_form">
                                    <?php
                                    $args = array(
                                        'redirect' => zume_dashboard_url(),
                                        'id_username' => 'user',
                                        'id_password' => 'pass',
                                        'value_remember' => true,
                                        'label_username' => __( 'Email Address', 'zume' ),
                                        'label_password' => __( 'Password', 'zume' ),
                                        'label_remember' => __( 'Remember Me', 'zume' ),
                                        'label_log_in' => __( 'Login', 'zume' ),
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
                        <p>
                        <?php if ( ! isset( $_GET['checkemail'] ) || ! in_array( wp_unslash( $_GET['checkemail'] ), array( 'confirm', 'newpass' ) ) ) : ?>

                            <a href="<?php echo esc_url( zume_register_url( $current_language ) ) ?>"><?php esc_html_e( 'Register', 'zume' ) ?></a>
                            &nbsp;|&nbsp;
                            <a href="<?php echo esc_url( zume_lostpassword_url( $current_language ) ); ?>"><?php esc_html_e( 'Lost your password?', 'zume' ); ?></a>

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
