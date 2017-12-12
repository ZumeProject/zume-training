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
$dt_user = wp_get_current_user(); // Returns WP_User object
$dt_user_meta = get_user_meta( get_current_user_id() ); // Full array of user meta data
?>

<?php get_header(); ?>

    <div id="content">

        <div id="inner-content" class="grid-x grid-margin-x grid-margin-y">



            <div class="large-offset-2 large-8 medium-8 small-12 cell ">

                <div class="bordered-box cell" id="profile" data-magellan-target="profile">

                    <span class="section-header">Your Profile</span>
                    <hr size="1" style="max-width:100%"/>


                    <div class="grid-x grid-margin-x grid-padding-x grid-padding-y ">
                        <div class="row column medium-12">

                            <p><?php echo get_avatar( get_current_user_id(), '150' ); ?></p>
                            <form method="post">

                                <?php wp_nonce_field( "user_" . $dt_user->ID . "_update", "user_update_nonce", false, true ); ?>

                                <table class="table">

                                    <tr>
                                        <td>User Name</td>
                                        <td> <?php echo esc_html( $dt_user->user_login ); ?> (can not change)</td>
                                    </tr>
                                    <tr>
                                        <td><label for="user_email">Email</label></td>
                                        <td><input type="text" class="profile-input" id="user_email" name="user_email"
                                                   value="<?php echo esc_html( $dt_user->user_email ); ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td><label for="first_name">First Name</label></td>
                                        <td><input type="text" class="profile-input" id="first_name"
                                                   name="first_name"
                                                   value="<?php echo esc_html( $dt_user->first_name ); ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td><label for="last_name">Last Name</label></td>
                                        <td><input type="text" class="profile-input" id="last_name" name="last_name"
                                                   value="<?php echo esc_html( $dt_user->last_name ); ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td><label for="nickname">Nickname</label></td>
                                        <td><input type="text" class="profile-input" id="nickname" name="nickname"
                                                   value=" <?php echo esc_html( $dt_user->nickname ); ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td><label for="description">Description</label></td>
                                        <td><textarea type="text" class="profile-input" id="description"
                                                      name="description"
                                                      rows="5"><?php echo esc_html( $dt_user->description ); ?></textarea>
                                        </td>
                                    </tr>

                                </table>

                                <div class="alert alert-box" style="display:none;" id="alert"><strong>Oh
                                        snap!</strong>
                                </div>

                                <button class="button" type="submit">Save</button>

                            </form>
                        </div>
                    </div>
                </div> <!-- End Profile -->
            </div>
        </div>
    </div> <!-- end #content -->

<?php get_footer(); ?>
