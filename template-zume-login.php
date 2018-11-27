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


add_action( 'wp_head', 'wp_no_robots' );

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
                $form_errors->add( 'invalidkey', __( 'Your password reset link appears to be invalid. Please request a new link below.' ) );
            } elseif ( 'expiredkey' == $_GET['error'] ) {
                $form_errors->add( 'expiredkey', __( 'Your password reset link has expired. Please request a new link below.' ) );
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
                            <div class="cell center"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" /></div>
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
                                            <label for="user_login" ><?php esc_html_e( 'Email Address' ); ?><br />
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
                                        <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Get New Password' ); ?>" /></p>
                                    </form>
                                    <?php elseif ( $sent ): ?>
                                        <?php echo esc_html( 'Your password reset email has been sent. Check your email or junk mail for the link to reset your password.' ) ?>
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
        // @codingStandardsIgnoreLine
        list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
        $rp_cookie = 'wp-resetpass-' . COOKIEHASH;
        if ( isset( $_GET['key'] ) && isset( $_GET['login'] ) ) {
            $value = sprintf( '%s:%s', sanitize_text_field( wp_unslash( $_GET['login'] ) ), sanitize_key( wp_unslash( $_GET['key'] ) ) );
            setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            wp_safe_redirect( remove_query_arg( array( 'key', 'login' ) ) );
            exit;
        }

        if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( sanitize_text_field( wp_unslash( $_COOKIE[ $rp_cookie ] ) ), ':' ) ) {
            list( $rp_login, $rp_key ) = explode( ':', sanitize_text_field( wp_unslash( $_COOKIE[ $rp_cookie ] ) ), 2 );
            $user = check_password_reset_key( $rp_key, $rp_login );
            if ( isset( $_POST['pass1'] ) && isset( $_POST['rp_key'] ) && ! hash_equals( $rp_key, sanitize_key( wp_unslash( $_POST['rp_key'] ) ) ) ) {
                $user = false;
            }
        } else {
            $user = false;
        }

        if ( ! $user || is_wp_error( $user ) ) {
            setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( site_url( 'login/?action=lostpassword&error=expiredkey' ) );
            } else { wp_redirect( site_url( 'login/?action=lostpassword&error=invalidkey' ) );
            }
            exit;
        }

        $form_errors = new WP_Error();

        if ( isset( $_POST['pass1'] ) && isset( $_POST['pass2'] ) && $_POST['pass1'] != $_POST['pass2'] ) {
            $form_errors->add( 'password_reset_mismatch', __( 'The passwords do not match.' ) );
        }

        if ( ( ! $form_errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
            reset_password( $user, sanitize_text_field( wp_unslash( $_POST['pass1'] ) ) );
            setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );

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
                            <div class="cell"><?php echo sprintf( 'Your password is reset. %s You can login %', '<a href="' . esc_url( zume_login_url( $current_language ) ) . '">', '</a>' ) ?></div>
                        </div>
                    </div>
                    <div class="cell medium-3 large-4"></div>
                </div>
            </div>
            <?php
            login_footer();
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
                            <div class="cell center"><img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" /></div>
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
                                            <label><?php esc_html_e( 'Password Required' ) ?> <strong>*</strong>
                                                <input type="password" id="pass1" name="pass1" placeholder="yeti4preZ" aria-errormessage="password-error-1" required >
                                                <span class="form-error" id="password-error-1">
                                                    <?php esc_html_e( 'Password required' ) ?>
                                                </span>
                                            </label>
                                            <meter max="4" id="password-strength-meter" value="0"></meter>
                                            <p id="password-strength-text"></p>
                                        </p>
                                        <p>
                                            <label><?php esc_html_e( 'Re-enter Password' ) ?> <strong>*</strong>
                                                <input type="password" name="pass2" placeholder="yeti4preZ" aria-errormessage="password-error-2" data-equalto="pass1">
                                                <span class="form-error" id="password-error-2">
                                                    <?php esc_html_e( 'Passwords do not match. Please, try again.' ) ?>
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
                                        <p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="<?php esc_attr_e( 'Reset Password' ); ?>" /></p>
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
                                <h2 style="font-weight: bolder;">
                                    <?php esc_html_e( "Let's get started.") ?>
                                </h2>
                                <span style="color:gray;"><?php esc_html_e( "Sign up using:") ?></span>
                            </div>

                            <div class="cell">
                                <p class="google_elements" style="display:none;">
                                    <?php zume_google_sign_in_button( ) ?>
                                </p>
                                <p class="facebook_elements" style="display:none;">
                                    <?php zume_facebook_login_button( ); ?>
                                </p>

                                <span><hr /></span>
                                <div class="button hollow" onclick="jQuery('#email_signup_form').toggle();" style="width:100%;">
                                    <span style="float:left;">
                                        <img src="<?php echo get_theme_file_uri('/assets/images/public_mail_hollow.png') ?>" style="width:20px;" />
                                    </span>
                                    <?php esc_attr_e( 'Email', 'zume' ) ?>
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

                                <a href="<?php echo esc_url( zume_login_url( $current_language ) ) ?>"><?php esc_html_e( 'Login' ) ?></a>
                                &nbsp;|&nbsp;
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

    case 'confirmation' :
        if ( ! isset( $_GET['request_id'] ) ) {
            wp_die( esc_attr__( 'Invalid request.' ) );
        }

        $request_id = (int) $_GET['request_id'];

        if ( isset( $_GET['confirm_key'] ) ) {
            $key    = sanitize_text_field( wp_unslash( $_GET['confirm_key'] ) );
            $result = wp_validate_user_request_key( $request_id, $key );
        } else {
            $result = new WP_Error( 'invalid_key', __( 'Invalid key' ) );
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

        login_header( __( 'User action confirmed.' ), $message );
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
                                <img src="<?php echo esc_url( get_theme_file_uri( '/assets/images/zume-logo-white.png' ) ) ?>" />
                            </div>
                            <div class="cell">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell small-6">
                                        <?php zume_google_sign_in_button() ?>
                                    </div>
                                    <div class="cell small-6">
                                    <?php zume_facebook_login_button(); ?>
                                    </div>
                                </div>
                            <hr>
                            </div>
                            <div class="cell">
                                <div class="wp_login_form">
                                    <?php
                                    $args = array(
                                        'redirect' => site_url(),
                                        'id_username' => 'user',
                                        'id_password' => 'pass',
                                        'value_remember' => true,
                                        'label_username' => __( 'Email Address' ),
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

                            <a href="<?php echo esc_url( zume_register_url( $current_language ) ) ?>"><?php esc_html_e( 'Register' ) ?></a>
                            &nbsp;|&nbsp;
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