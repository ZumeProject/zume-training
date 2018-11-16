<?php
/**
 * Template Name: Zume Logout
 */
$current_language = zume_current_language();

wp_destroy_current_session();
wp_clear_auth_cookie();

if ( ! isset( $_GET['logout'] ) ) {
    wp_redirect( zume_get_posts_translation_url( 'Logout', $current_language ) . '?logout=true' );
}

if ( 'en' != $current_language ) {
    $home_url = site_url() . '/' . $current_language;
} else {
    $home_url = site_url();
}

function zume_signup_header() {
    ?>
    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="<?php echo get_option( 'dt_google_sso_key' ); ?>">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <?php
}

add_action( 'wp_head', 'zume_signup_header' );

?>

<?php get_header(); ?>

<div id="content">
    <div id="login">
        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x grid-margin-y grid-padding-y">
            <div class="cell medium-4"></div>
            <div class="cell callout medium-4 large-4 center">
                <?php echo esc_html__( "You have been logged out." ); ?>
                <br><br>
                <?php echo '<a class="button" href="'. esc_url( $home_url ) .'">'. esc_html__( 'Back to home page' ) .'</a>' ?>
            </div>
            <div class="cell medium-4"></div>
        </div>
    </div>
</div>
<script>
    function signOut() {

        let auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('Google User signed out.');
        });
    }
    jQuery(document).ready(function() {
        signOut()
    })

</script>

<?php get_footer(); ?>
