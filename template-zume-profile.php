<?php
/*
Template Name: Zume Profile
*/

zume_force_login();

/* Process $_POST content */
// We're not checking the nonce here because update_user_contact_info will
// @codingStandardsIgnoreLine
if( isset( $_POST[ 'user_update_nonce' ] ) ) {
    zume_update_user_contact_info();
}
/* Build variables for page */
$zume_user = wp_get_current_user(); // Returns WP_User object
$zume_user_meta = zume_get_user_meta( get_current_user_id() ); // Full array of user meta data

add_action( 'wp_head', 'zume_signup_header' );

?>

<?php get_header(); ?>


<style>
    /* Fix for button inheritance on second social sign on. */
    button.button {
        padding-top: .85em;
        padding-bottom: .85em;
    }
</style>
<div id="content" class="grid-x grid-padding-x"><div class="cell">
    <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
        <div class="large-8 medium-8 small-12 grid-margin-x cell" style="max-width: 900px; margin: 0 auto">

            <div class="grid-x grid-padding-x">
                <div class="cell" id="profile"></div>
            </div>

            <div class="grid-x grid-padding-x">
                <div class="cell medium-4 google_elements">
                    <?php
                    if ( ! get_user_meta( $zume_user->ID, 'google_sso_email', true ) ) :
                        zume_google_link_account_button();
                    endif;
                    ?>
                </div>
                <div class="cell medium-4 facebook_elements">
                    <?php
                    if ( ! get_user_meta( $zume_user->ID, 'facebook_sso_email', true ) ) :
                        zume_facebook_link_account_button();
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </div>
    </div> <!--cell -->
</div><!-- end #content -->

<?php get_footer(); ?>
