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
$zume_user_meta = get_user_meta( get_current_user_id() ); // Full array of user meta data
?>

<?php get_header(); ?>

    <div id="content">
        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
            <div class="large-8 medium-8 small-12 grid-margin-x cell" style="max-width: 900px; margin: 0 auto">
                <span class="section-header"><?php echo __( '', 'zume' )?> </span>
                <hr size="1" style="max-width:100%"/>
                <p><?php echo get_avatar( get_current_user_id(), '150' ); ?></p>
                <form method="post">
                    <?php wp_nonce_field( "user_" . $zume_user->ID . "_update", "user_update_nonce", false, true ); ?>

                    <table class="table">
                        <tr>
                            <td><?php echo __( 'User Name', 'zume' )?></td>
                            <td> <?php echo esc_html( $zume_user->user_login ); ?> <?php echo __( '(can not change)', 'zume' )?></td>
                        </tr>
                        <tr>
                            <td><label for="user_email"><?php echo __( 'Email', 'zume' )?></label></td>
                            <td><input type="text" class="profile-input" id="user_email" name="user_email"
                                       value="<?php echo esc_html( $zume_user->user_email ); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="first_name"><?php echo __( 'First Name', 'zume' )?></label></td>
                            <td><input type="text" class="profile-input" id="first_name"
                                       name="first_name"
                                       value="<?php echo esc_html( $zume_user->first_name ); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="last_name"><?php echo __( 'Last Name', 'zume' )?></label></td>
                            <td><input type="text" class="profile-input" id="last_name" name="last_name"
                                       value="<?php echo esc_html( $zume_user->last_name ); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="nickname"><?php echo __( 'Nickname', 'zume' )?></label></td>
                            <td><input type="text" class="profile-input" id="nickname" name="nickname"
                                       value=" <?php echo esc_html( $zume_user->nickname ); ?>"/></td>
                        </tr>
                        <tr>
                            <td><label for="description"><?php echo __( 'Description', 'zume' )?></label></td>
                            <td><textarea type="text" class="profile-input" id="description"
                                          name="description"
                                          rows="5"><?php echo esc_html( $zume_user->description ); ?></textarea>
                            </td>
                        </tr>

                    </table>

                    <div class="alert alert-box" style="display:none;" id="alert">
                        <strong><?php echo __( 'Oh snap!', 'zume' )?></strong>
                    </div>

                    <button class="button" type="submit"><?php echo __( 'Save', 'zume' )?></button>
                </form>
            </div>
        </div>
    </div> <!-- end #content -->

<?php get_footer(); ?>
