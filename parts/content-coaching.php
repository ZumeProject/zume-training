<?php
/********************************************************************************************* -->
<!-- REQUEST COACHING -->
<!-- *********************************************************************************************/

?>
<!-- Edit current groups section -->
<div class="small reveal" id="new-registration-tour" data-reveal>

    <h1 class="primary-color" id="coach-modal-title"><?php echo esc_html__( 'Connect Me to a Coach', 'zume' ) ?></h1>
    <hr>

    <div class="grid-x" id="coaching-request-form-section">
        <div class="cell">
            <form data-abide novalidate id="coaching-request-form">
                <div class="grid-x grid-padding-x" >

                    <div class="cell small-6">
                        <i class="fi-torsos-all secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span style="font-size:2em; vertical-align: middle; text-wrap: none;"><?php esc_html_e( 'Coaches', 'zume' ) ?></span>
                        <p><?php esc_html_e( 'Our network of volunteer coaches are people like you, people who are passionate about loving God, loving others, and obeying the Great Commission.', 'zume' ) ?></p>
                    </div>

                    <div class="cell small-6">
                        <i class="fi-compass secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span style="font-size:2em; vertical-align: middle;"><?php esc_html_e( 'Advocates', 'zume' ) ?></span>
                        <p><?php esc_html_e( 'A coach is someone who will come alongside you as you implement the Zúme tools and training.', 'zume' ) ?></p>
                    </div>

                    <div class="cell small-6">
                        <i class="fi-map secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span style="font-size:2em; vertical-align: middle;"><?php esc_html_e( 'Local', 'zume' ) ?></span>
                        <p><?php esc_html_e( 'On submitting this request, we will do our best to connect you with a coach near you.', 'zume' ) ?></p>
                    </div>

                    <div class="cell small-6">
                        <i class="fi-dollar secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span style="font-size:2em; vertical-align: middle;text-wrap: none;"><?php esc_html_e( "It's Free", 'zume' ) ?></span>
                        <p><?php esc_html_e( 'Coaching is free. You can opt out at any time.', 'zume' ) ?></p>
                    </div>

                </div>
                <div data-abide-error class="alert callout" style="display: none;">
                    <p><i class="fi-alert"></i> <?php esc_html_e("There are some errors in your form.", 'zume' ) ?></p>
                </div>
                <table>
                    <tr style="vertical-align: top;">
                        <td>
                            <label for="zume_full_name"><?php echo esc_html__( 'Name', 'zume' )?></label>
                        </td>
                        <td>
                            <input type="text"
                                   placeholder="<?php echo esc_html__( 'First and last name', 'zume' )?>"
                                   aria-describedby="<?php echo esc_html__( 'First and last name', 'zume' )?>"
                                   class="profile-input"
                                   id="zume_full_name"
                                   name="zume_full_name"
                                   value="<?php echo esc_html( get_user_meta( $zume_user->ID, 'zume_full_name', true ) ); ?>"
                                   required />
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
                                   value="<?php echo isset( $zume_user_meta['zume_phone_number'] ) ? esc_html( $zume_user_meta['zume_phone_number'] ) : ''; ?>"
                                   data-abide-ignore
                            />
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
                                   required
                                   readonly
                            />
                            <span class="form-error">
                                <?php esc_attr_e( 'Email is required.', 'zume' ) ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top;">
                            <label for="validate_address">
                                <?php echo esc_html__( 'City', 'zume' )?>
                            </label>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text"
                                       placeholder="example: Denver, CO 80126"
                                       class="profile-input input-group-field"
                                       id="validate_addressprofile"
                                       name="validate_address"
                                       value="<?php echo isset( $zume_user_meta['zume_user_address'] ) ? esc_html( $zume_user_meta['zume_user_address'] ) : ''; ?>"
                                       data-abide-ignore
                                />
                                <div class="input-group-button">
                                    <input type="button" class="button" id="validate_address_buttonprofile" value="<?php echo esc_html__( 'Validate', 'zume' ) ?>" onclick="validate_user_address( jQuery('#validate_addressprofile').val() )">
                                </div>
                            </div>

                            <div id="possible-results">
                                <input type="hidden" name="address" id="address_profile" value="<?php echo isset( $zume_user_meta['zume_user_address'] ) ? esc_html( $zume_user_meta['zume_user_address'] ) : ''; ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <label><?php echo esc_html__( 'How should we contact you?', 'zume' )?></label>
                        </td>
                        <td>
                            <fieldset>
                                <input id="zume_contact_preference1" name="zume_contact_preference" type="radio" value="email" checked data-abide-ignore>
                                <label for="zume_contact_preference1"><?php esc_attr_e( 'Email', 'zume' ) ?></label>
                                <input id="zume_contact_preference2" name="zume_contact_preference" type="radio" value="text" data-abide-ignore>
                                <label for="zume_contact_preference2"><?php esc_attr_e( 'Text', 'zume' ) ?></label>
                                <input id="zume_contact_preference3" name="zume_contact_preference" type="radio" value="phone" data-abide-ignore>
                                <label for="zume_contact_preference3"><?php esc_attr_e( 'Phone', 'zume' ) ?></label><br>
                                <input id="zume_contact_preference3" name="zume_contact_preference" type="radio" value="whatsapp" data-abide-ignore>
                                <label for="zume_contact_preference3"><?php esc_attr_e( 'WhatsApp', 'zume' ) ?></label>
                                <input id="zume_contact_preference3" name="zume_contact_preference" type="radio" value="other" data-abide-ignore>
                                <label for="zume_contact_preference3"><?php esc_attr_e( 'Other', 'zume' ) ?></label>
                            </fieldset>

                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <label for="zume_affiliation_key"><?php echo esc_html__( 'Affiliation Key', 'zume' )?></label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo isset( $zume_user_meta['zume_affiliation_key'] )
                                ? esc_html( strtoupper( $zume_user_meta['zume_affiliation_key'] ) ) : ''; ?>"
                                   id="zume_affiliation_key"
                                   name="zume_affiliation_key" placeholder="" />
                        </td>
                    </tr>
                </table>
                <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
                    <strong><?php echo esc_html__( 'Oh snap!', 'zume' )?></strong>
                </div>
                <div class="cell">
                    <button class="button" type="button" onclick="validate_request()" id="submit_profile"><?php echo esc_html__( 'Submit', 'zume' )?></button><span id="request_spinner"></span>
                </div>
            </form>
        </div>
    </div>
    <script>
        jQuery(document).ready(function(){
            jQuery(document)
                .on("formvalid.zf.abide", function(ev,frm) {
                    send_coaching_request()
                })
        })
        function validate_request() {
            jQuery('#coaching-request-form').foundation('validateForm');
        }
    </script>

    <button class="close-button" data-close aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </button>

</div> <!-- End of reveal -->
