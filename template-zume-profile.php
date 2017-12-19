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
                <span class="section-header"><?php echo esc_html__( 'Your Profile', 'zume' )?> </span>
                <hr size="1" style="max-width:100%"/>
                <p><?php echo get_avatar( get_current_user_id(), '150' ); ?></p>
                <form data-abide method="post">

                    <?php wp_nonce_field( "user_" . $zume_user->ID . "_update", "user_update_nonce", false, true ); ?>

                    <table class="hover stack">
                        <tr style="vertical-align: top;">
                            <td>
                                <label><?php echo esc_html__( 'User Name', 'zume' )?></label>
                            </td>
                            <td>
                                <?php echo esc_html( $zume_user->user_login ); ?> <?php echo esc_html__( '(can not change)', 'zume' )?>
                            </td>
                        </tr>
                        <tr style="vertical-align: top;">
                            <td>
                                <label for="first_name"><?php echo esc_html__( 'First Name', 'zume' )?></label>
                            </td>
                            <td>
                                <input type="text"
                                       placeholder="<?php echo esc_html__( 'First Name', 'zume' )?>"
                                       aria-describedby="<?php echo esc_html__( 'First Name', 'zume' )?>"
                                       class="profile-input"
                                       id="first_name"
                                       name="first_name"
                                       value="<?php echo esc_html( $zume_user->first_name ); ?>"
                                       data-abide-ignore />
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <label for="last_name"><?php echo esc_html__( 'Last Name', 'zume' )?></label>
                            </td>
                            <td>
                                <input type="text"
                                       placeholder="<?php echo esc_html__( 'Last Name', 'zume' )?>"
                                       aria-describedby="<?php echo esc_html__( 'Last Name', 'zume' )?>"
                                       class="profile-input"
                                       id="last_name"
                                       name="last_name"
                                       value="<?php echo esc_html( $zume_user->last_name ); ?>"
                                       data-abide-ignore />
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <label for="user_email"><?php echo esc_html__( 'Email', 'zume' )?></label>
                            </td>
                            <td>
                                <input type="text"
                                       class="profile-input"
                                       placeholder="name@email.com"
                                       id="user_email"
                                       name="user_email"
                                       value="<?php echo esc_html( $zume_user->user_email ); ?>"
                                       data-abide-ignore
                                />
                                <span class="form-error">
                                  Yo, you had better fill this out, it's required.
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <label for="zume_phone_number"><?php echo esc_html__( 'Phone Number', 'zume' )?></label>
                            </td>
                            <td>
                                <input type="tel"
                                       placeholder="111-111-1111"
                                       class="profile-input"
                                       id="zume_phone_number"
                                       name="zume_phone_number"
                                       value="<?php echo isset( $zume_user_meta['zume_phone_number'][0] ) ? esc_html( $zume_user_meta['zume_phone_number'][0] ) : ''; ?>"
                                       data-abide-ignore
                                />
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top;">
                                <label for="validate_address">
                                    <?php echo esc_html__( 'Address', 'zume' )?>
                                </label>
                            </td>
                            <td>
                                <div class="input-group">
                                    <input type="text"
                                           placeholder="example: 1000 Broadway, Denver, CO 80126"
                                           class="profile-input input-group-field"
                                           id="validate_address"
                                           name="validate_address"
                                           value="<?php echo isset( $zume_user_meta['zume_user_address'][0] ) ? esc_html( $zume_user_meta['zume_user_address'][0] ) : ''; ?>"
                                    />
                                    <div class="input-group-button">
                                        <input type="button" class="button" id="validate_address_button" value="Validate">
                                    </div>
                                </div>

                                <div id="possible-results">
                                    <input type="hidden" name="address" value="<?php echo isset( $zume_user_meta['zume_user_address'][0] ) ? esc_html( $zume_user_meta['zume_user_address'][0] ) : ''; ?>" />
                                </div>

                                <?php if ( ! empty( $zume_user_meta['zume_user_address'][0] ) && ! empty( $zume_user_meta['zume_user_lng'][0] ) && ! empty( $zume_user_meta['zume_user_lat'][0] ) ) : ?>
                                <div id="map" >
                                    <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo esc_attr( $zume_user_meta['zume_user_lat'][0] ) . ',' . esc_attr( $zume_user_meta['zume_user_lng'][0] ) ?>&zoom=5&size=600x250&markers=color:red|<?php echo esc_attr( $zume_user_meta['zume_user_lat'][0] ) . ',' . esc_attr( $zume_user_meta['zume_user_lng'][0] ) ?>&key=<?php echo esc_attr( Zume_Google_Geolocation::$key ); ?>" />
                                </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>

                    <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
                        <strong><?php echo esc_html__( 'Oh snap!', 'zume' )?></strong>
                    </div>

                    <button class="button" type="submit"><?php echo esc_html__( 'Save', 'zume' )?></button>
                </form>
            </div>
        </div>
    </div> <!-- end #content -->

<?php get_footer(); ?>
