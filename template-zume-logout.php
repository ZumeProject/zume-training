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

<?php get_footer(); ?>
