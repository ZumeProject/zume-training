<?php
/** Template Name: Zume Register
 *
 */
/** Sets up the WordPress Environment. */
require_once( ABSPATH . 'wp-load.php' ); // zume changed

add_action( 'wp_head', 'wp_no_robots' );

require_once( ABSPATH  . 'wp-blog-header.php' );

nocache_headers();

if ( is_array( get_site_option( 'illegal_names' ) ) && isset( $_GET['new'] ) && in_array( $_GET['new'], get_site_option( 'illegal_names' ) ) ) {
    wp_redirect( network_home_url() );
    die();
}

function do_signup_header() {
    /**
     * Fires within the head section of the site sign-up screen.
     *
     * @since 3.0.0
     */
    do_action( 'signup_header' );
}
add_action( 'wp_head', 'do_signup_header' );

// Fix for page title
$wp_query->is_404 = false;


function zume_signup_header() {
    ?>
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="<?php echo get_option( 'dt_google_sso_key' ); ?>">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <?php
}

add_action( 'wp_head', 'zume_signup_header' );

get_header( 'wp-signup' );

?>
<div class="grid-x">

    <div class="cell medium-6 center">
        <h2>Social Registration</h2>
        <!--<div class="g-signin2" data-onsuccess="onSign In" data-theme="dark"></div>-->
        <div class="g-signin2"  data-theme="dark"></div>
        <div id="google_error"></div>
        <script>
            function onSignIn(googleUser) {
                // Useful data for your client-side scripts:
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
                        //window.location = "<?php //echo esc_url( site_url() ) ?>//"
                    })
                    .fail(function (err) {
                        signOut()
                        jQuery('#google_error').text('Failed to authenticate your Google account')
                        console.log("error")
                        console.log(err)
                    })
            }

        </script>

        <a href="#" onclick="signOut();">Sign out</a>
        <script>
            function signOut() {
                jQuery.ajax({
                    type: "POST",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    url: '<?php echo rest_url('/zume/v1/logout') ?>',
                    beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-WP-Nonce', '<?php echo wp_create_nonce( 'wp_rest' ) ?>');
                    },
                })
                    .done(function (data) {
                        console.log('Wordpress User Signed Out')
                    })
                    .fail(function (err) {
                        console.log("Wordpress signout failure")
                        jQuery('#google_error').text(err.responseText )
                        console.log(err)
                    })

                let auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                    console.log('Google User signed out.');
                });
            }
        </script>


        <hr>
        <h2>Register by Email</h2>
        <?php custom_registration_function(); ?>
        <hr>

    </div>
</div>

<?php
get_footer( 'wp-signup' );


