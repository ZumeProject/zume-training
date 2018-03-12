<?php
/*
Template Name: Three-Month Plan
*/
zume_force_login();

/* Process $_POST content */
$zume_error_message = '';
if ( isset( $_POST['thee_month_plan_nonce'] ) ) {
    // validate nonce
    zume_write_log( $_POST );

    if ( isset( $_POST['thee_month_plan_nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['thee_month_plan_nonce'] ), "thee_month_plan_" . get_current_user_id() ) ) {
        return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
    } else {
        unset( $_POST['thee_month_plan_nonce'] );
    }

    if ( isset( $_POST['reset_three_month_plan'] ) ) {

        Zume_Three_Month_Plan::reset_plan();
    }
    else {
        $status = Zume_Three_Month_Plan::edit_post( $_POST );
        if ( 'Public_Key_Error' === $status['status'] ) {
            $zume_error_message = $status['message'];
        }
    }
}

/* Build variables for page */
$zume_three_month_plan = Zume_Three_Month_Plan::plan_items_filter( get_user_meta( get_current_user_id(), 'three_month_plan', true ) );
$zume_groups = Zume_Dashboard::get_current_user_groups();
zume_write_log( $zume_three_month_plan );
?>

<?php get_header(); ?>

<div id="content" class="grid-x grid-padding-x"><div class="cell">
        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
            <div class="large-8 medium-8 small-12 grid-margin-x cell" style="max-width: 900px; margin: 0 auto">

                <h3 class="section-header"><?php echo esc_html__( 'Three Month Plan', 'zume' )?> </h3>

                <p><?php esc_attr_e('The Three Month Plan is part of the session 9 training and helps you become specific on how you will apply the training in the near future.
                You can connect your three month plan to a group by adding the the group key. Check with your group leader to get the key.', 'zume') ?></p>
                <hr>

                <?php echo empty( $zume_error_message ) ? '' : '<div class="callout alert">'. esc_attr( $zume_error_message ) .'</div>' ?>

                <?php
                /**
                 * Groups tabbing first half wrapper
                 */
                if ( $zume_groups ) : ?>

                    <ul class="tabs" data-tabs id="plan-tabs">
                        <li class="tabs-title is-active"><a href="#panel1" aria-selected="true"><?php esc_attr_e( 'My Plan', 'zume' ) ?></a></li>
                        <li class="tabs-title"><a data-tabs-target="panel2" href="#panel2"><?php esc_attr_e( 'Groups Plan', 'zume' ) ?></a></li>
                    </ul>

                    <div class="tabs-content" data-tabs-content="plan-tabs">
                        <div class="tabs-panel is-active" id="panel1">

                <?php endif; // if user owns no groups ?>

                <!-- Begin My Plan Form-->
                <form data-abide method="post">
                    <?php wp_nonce_field( "thee_month_plan_" . get_current_user_id(), "thee_month_plan_nonce", false, true ); ?>
                    <table class="hover stack">
                        <?php
                        $zume_fields = Zume_Three_Month_Plan::plan_labels(); // get labels for fields
                        $zume_index = 1; // number the questions
                        foreach ( $zume_fields as $zume_key => $zume_label ) :

                            /* Handle the public key */
                            if ( 'public_key' === $zume_key ) {
                                ?>
                                <tr>
                                    <td id="linked_group">
                                        <label for="public_key"><strong> <?php echo esc_html( $zume_label )?></strong></label>
                                        <div id="add-public-key" class="input-group">
                                            <input type="text"
                                                   placeholder="<?php esc_attr_e( 'example: ABC12', 'zume' ) ?>"
                                                   class="profile-input input-group-field"
                                                   name="public_key"
                                                   id="public_key"
                                                   value=""
                                            />
                                            <div class="input-group-button">
                                                <input type="button" class="button"
                                                       onclick="connect_plan_to_group( jQuery('#public_key').val() )"
                                                       value="<?php echo esc_html__( 'Link', 'zume' ) ?>"
                                                       id="public_key_button">
                                            </div>
                                        </div>
                                        <div id="display-public-key grid-x" style="display:none;">
                                            <div class="cell"></div>
                                            <div class="cell medium-2 small-2"></div>
                                            <?php esc_attr_e( 'Connected to group', 'zume' ) ?>: <span></span><span></span>
                                        </div>
                                        <script>
                                            if( <?php $zume_three_month_plan['linked'] ?> ) {
                                                jQuery('#add-public-key').hide();
                                                jQuery('#display-public-key').show();
                                            } else {
                                                jQuery('#add-public-key').show();
                                                jQuery('#display-public-key').hide();
                                            }

                                        </script>
                                        <?php
                                        /**
                                         * Description area with a quick list of groups
                                         */
                                        if ( count( $zume_groups ) > 0 ) {
                                            echo '<span class="text-small">'.esc_attr__( 'Add one of your groups? ', 'zume' ).'</span>';

                                            $zume_colead_groups = Zume_Dashboard::get_colead_groups();
                                            foreach ( $zume_colead_groups as $zume_colead_key => $zume_colead_value ) {
                                                $zume_groups[ $zume_colead_key ] = $zume_colead_value;
                                            }
                                            foreach ( $zume_groups as $zume_group ) {
                                                $zume_group_meta = Zume_Dashboard::verify_group_array_filter( $zume_group );
                                                print '<a class="small" onclick="jQuery(\'#public_key\').val(\''.esc_attr( $zume_group_meta['public_key'] ) .'\')">(' . esc_attr( $zume_group_meta['group_name'] ) . ': ' . esc_attr( $zume_group_meta['public_key'] ) . ')</a> ';
                                            }
                                        }
                                        ?>

                                    </td>
                                </tr>
                                <?php
                            }

                            /* Generate all rows */
                            ?>
                            <tr>
                                <td>
                                    <label for="<?php echo esc_attr( $zume_key ) ?>"><strong>(<?php echo esc_attr( $zume_index ) ?>) <?php echo esc_html( $zume_label )?></strong></label>
                                    <textarea id="<?php echo esc_attr( $zume_key ) ?>" name="<?php echo esc_attr( $zume_key ) ?>" rows="3"><?php echo esc_html( $zume_three_month_plan[ $zume_key ] ?? '' ) ?></textarea>
                                </td>
                            </tr>
                            <?php $zume_index++;
endforeach; ?>
                    </table>
                    <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
                        <strong><?php echo esc_html__( 'Oh snap!', 'zume' )?></strong>
                    </div>
                    <button class="button" type="submit" id="submit_profile"><?php echo esc_html__( 'Save', 'zume' )?></button>
                    <button class="button hollow clear float-right" type="submit" name="reset_three_month_plan"><?php echo esc_html__( 'Reset', 'zume' )?></button>
                </form>
                <!-- End My Plan Form -->

                <?php
                /**
                 * Groups tabbing second half wrapper
                 */
                if ( $zume_groups ) : ?>

                        </div> <!-- end first tab-->
                        <div class="tabs-panel" id="panel2">

                            <?php foreach ( $zume_groups as $zume_group ) : ?>

                                <h4><?php echo esc_attr( $zume_group['group_name'] ) ?></h4>

                                <?php if ( ! empty( $zume_group['three_month_plans'] ) ) : ?>

                                    <ul>
                                    <?php foreach ( $zume_group['three_month_plans'] as $zume_plan_user_id ) :
                                        $zume_participant_plan = Zume_Three_Month_Plan::get_user_three_month_plan( $zume_plan_user_id );
                                        if ( $zume_participant_plan ) :
                                        ?>
                                        <li><a data-open="<?php echo esc_html( $zume_key ); ?>"><?php echo esc_attr( $zume_participant_plan['user']->user_name ) ?></a></li>
                                        <div class="grid-x">
                                            <div class="cell">

                                            </div>
                                        </div>
                                    <?php endif;
/* End check for user content */ endforeach; /* End loop through users plans */ ?>
                                    </ul>
                                <?php else : ?>
                                    <p class="small text-gray" style="padding: 0 .5rem;"><?php esc_attr_e( 'No plans found', 'zume' ) ?></p>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </div> <!-- end second tab-->
                    </div>
                <?php endif; ?>


            </div>
        </div>
    </div> <!--cell -->
</div><!-- end #content -->

<?php get_footer(); ?>