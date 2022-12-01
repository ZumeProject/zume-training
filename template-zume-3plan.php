<?php
/*
Template Name: Three-Month Plan
*/

/* Process $_POST content */
$zume_error_message = '';
if ( isset( $_POST['thee_month_plan_nonce'] ) ) {
    // validate nonce

    if ( isset( $_POST['thee_month_plan_nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['thee_month_plan_nonce'] ), "thee_month_plan_" . get_current_user_id() ) ) {
        return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
    } else {
        unset( $_POST['thee_month_plan_nonce'] );
    }

    if ( isset( $_POST['reset_three_month_plan'] ) ) {
        Zume_Three_Month_Plan::reset_plan();
    }
    else {
        // @codingStandardsIgnoreStart
        $post_content = $_POST;
        $status = Zume_Three_Month_Plan::edit_post( $post_content );
        // @codingStandardsIgnoreEnd
        if ( 'Public_Key_Error' === $status['status'] ) {
            $zume_error_message = $status['message'];
        }
    }
}

/* Build variables for page */
$zume_three_month_plan = Zume_Three_Month_Plan::plan_items_filter( get_user_meta( get_current_user_id(), 'three_month_plan', true ) );
$zume_groups = Zume_Dashboard::get_current_user_groups();
?>

<?php get_header(); ?>

<div id="content" class="grid-x grid-padding-x"><div class="cell">
        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
            <div class="large-8 medium-8 small-12 grid-margin-x cell" style="max-width: 900px; margin: 0 auto">

                <h3 class="section-header"><?php echo esc_html__( 'Three Month Plan', 'zume' )?> </h3>

                <p><?php esc_attr_e( 'The Three Month Plan is part of the Session 9 training. It is designed to help you identify specific action steps post Zúme Training. Further instructions about the Three Month Plan are found in Session 9.', 'zume' ) ?></p>
                <p><?php esc_attr_e( 'You can connect your Three Month Plan to a group by adding the group key. Click on your group name below the "Link to a Group with a Group Key" field or check with your group leader to get the 5 digit code.', 'zume' ) ?></p>
                <p><?php esc_attr_e( 'If you have completed a live training event, you can use the group key your trainer gives you to connect your plan with your training group.', 'zume' ) ?></p>
                <hr>

                <?php echo empty( $zume_error_message ) ? '' : '<div class="callout alert">'. esc_attr( $zume_error_message ) .'</div>' ?>

                <?php
                /**
                 * Groups tabbing first half wrapper
                 */
                if ( $zume_groups ) : ?>

                    <ul class="tabs" data-tabs id="plan-tabs">
                        <li class="tabs-title is-active"><a href="#panel1" aria-selected="true"><?php esc_attr_e( 'My Plan', 'zume' ) ?></a></li>
                        <li class="tabs-title"><a data-tabs-target="panel2" href="#panel2"><?php esc_attr_e( 'Plans in Your Groups', 'zume' ) ?></a></li>
                    </ul>

                    <div class="tabs-content" data-tabs-content="plan-tabs">
                        <div class="tabs-panel is-active" id="panel1">

                <?php endif; // if user owns no groups ?>

                <!-- Begin My Plan Form-->
                <form data-abide method="post" id="my-plan">
                    <?php wp_nonce_field( "thee_month_plan_" . get_current_user_id(), "thee_month_plan_nonce", false, true ); ?>
                    <table class="hover stack">
                        <tr>
                            <td id="linked_group">

                                <!-- Public Key Field -->
                                <div id="add-public-key">
                                    <label for="public_key"><strong> <?php esc_attr_e( 'Link to a Group with a Group Key (optional)', 'zume' ) ?></strong></label>
                                    <div class="input-group">
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
                                    <?php
                                    /* Description area with a quick list of groups */
                                    if ( $zume_groups ) {
                                        echo '<span class="text-small">'.esc_attr__( 'Add one of your groups? ', 'zume' ).'</span>';

                                        // Add colead groups to user owned groups
                                        $zume_colead_groups = Zume_Dashboard::get_colead_groups();
                                        foreach ( $zume_colead_groups as $zume_colead_key => $zume_colead_value ) {
                                            $zume_groups[ $zume_colead_key ] = $zume_colead_value;
                                        }
                                        // list groups available
                                        foreach ( $zume_groups as $zume_group ) {
                                            $zume_group_meta = Zume_Dashboard::verify_group_array_filter( $zume_group );
                                            print '<a class="small"
                                            onclick="jQuery(\'#public_key\').val(\''.esc_attr( $zume_group_meta['public_key'] ) .'\')">
                                            (' . esc_attr( $zume_group_meta['group_name'] ) . ': ' . esc_attr( $zume_group_meta['public_key'] ) . ')
                                            </a> ';
                                        }
                                    }
                                    ?>
                                </div>
                                <!-- End Public Key Field -->

                                <!-- Linked Group Info -->
                                <div id="display-public-key" style="display:none;">
                                    <?php esc_attr_e( 'Linked to', 'zume' ) ?>:
                                    <strong>
                                        <span id="display-group-name">
                                            <?php $zume_three_month_plan['group_key'] ? print esc_attr( Zume_Three_Month_Plan::get_group_name_by_group_key( $zume_three_month_plan['group_key'] ) ) : print ''; ?>
                                        </span>
                                    </strong>
                                    <span class="display-public-key-unlink text-small" style="display: none;">
                                        <a id="unlink-three-month-plan" onclick="unlink_three_month_plan('<?php echo esc_attr( $zume_three_month_plan['group_key'] )?>')"><?php esc_attr_e( 'Unlink Group', 'zume' ) ?></a>
                                    </span>
                                </div>
                                <script>
                                    /* toggle the view setting of the public key */
                                    if( <?php echo esc_attr( $zume_three_month_plan['group_key'] ? 1 : 0 ) ?> ) {
                                        jQuery('#add-public-key').hide();
                                        jQuery('#display-public-key').show();
                                    } else {
                                        jQuery('#add-public-key').show();
                                        jQuery('#display-public-key').hide();
                                    }

                                </script>
                                <!-- End Linked Group Info -->
                            </td>
                        </tr>

                        <?php
                        /**
                         * List the items of the plan
                         */
                        $zume_fields = Zume_Three_Month_Plan::plan_labels(); // get labels for fields
                        $zume_index = 1; // number the questions
                        foreach ( $zume_fields as $zume_key => $zume_label ) :
                            /* Generate all rows */
                            ?>
                            <tr>
                                <td>
                                    <label for="<?php echo esc_attr( $zume_key ) ?>"><strong>(<?php echo esc_attr( $zume_index ) ?>) <?php echo esc_html( $zume_label )?></strong></label>
                                    <textarea id="<?php echo esc_attr( $zume_key ) ?>" name="<?php echo esc_attr( $zume_key ) ?>" rows="3"><?php echo esc_html( $zume_three_month_plan[ $zume_key ] ?? '' ) ?></textarea>
                                </td>
                            </tr>
                            <?php
                            $zume_index++; // add increment
                        endforeach; ?>

                    </table>
                    <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
                        <strong><?php echo esc_html__( 'Oh snap!', 'zume' )?></strong>
                    </div>
                    <button class="button" type="submit" id="submit_profile"><?php echo esc_html__( 'Save', 'zume' )?></button>
                    <button class="button hollow clear float-right" type="submit" name="reset_three_month_plan"><?php echo esc_html__( 'Reset', 'zume' )?></button>
                        <button type="button" class="button hollow float-right" onclick="print_element('my-plan-print')"><?php esc_html_e( 'Print Saved Plan', 'zume' ) ?></button>

                    <div style="display:none;">
                        <div id="my-plan-print">
                            <h1><?php echo esc_html( ucwords( get_current_user() ) ) ?></h1><hr>
                            <?php
                            $zume_index = 1; // number the questions
                            foreach ( $zume_fields as $zume_key => $zume_label ) :
                                /* Generate all rows */
                                ?>
                                <h3><strong>(<?php echo esc_attr( $zume_index ) ?>) <?php echo esc_html( $zume_label )?></strong></h3>
                                <p><?php echo isset( $zume_three_month_plan[ $zume_key ] ) ? esc_html( $zume_three_month_plan[ $zume_key ] ) : esc_html__( 'not answered', 'zume' ); ?></p>
                                <?php
                                $zume_index++; // add increment
                            endforeach;
                            ?>
                        </div>
                    </div>
                </form>
                <!-- End My Plan Form -->

                <?php
                /**
                 * Groups tabbing.
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

                                        <li>
                                            <a data-open="participant-<?php echo esc_attr( $zume_participant_plan['user']->ID ) ?>">
                                                <?php echo esc_attr( $zume_participant_plan['user']->data->display_name ) ?>
                                            </a>
                                        </li>
                                        <div class="small reveal" id="participant-<?php echo esc_attr( $zume_participant_plan['user']->ID ) ?>" data-reveal>
                                            <div class="cell">
                                                <h1><?php echo esc_attr( $zume_participant_plan['user']->data->display_name ) ?></h1>
                                            </div>

                                            <?php $zume_i = 1; foreach ( $zume_participant_plan['labels'] as $zume_p_key => $zume_p_label ) : ?>
                                                <div class="cell padding-bottom callout">
                                                    (<?php echo esc_attr( $zume_i ) ?>) <?php echo esc_attr( $zume_p_label ) ?><br>
                                                    <strong><?php echo esc_attr( $zume_participant_plan['plan'][$zume_p_key] ) ?></strong><br>
                                                </div>
                                                <?php $zume_i++;
endforeach; ?>

                                            <div class="cell center">
                                                <button type="button" class="button" onclick="print_element('participant-<?php echo esc_attr( $zume_participant_plan['user']->ID ) ?>')"><?php esc_html_e( 'Print', 'Zume' ) ?></button>
                                            </div>

                                            <button class="close-button" data-close aria-label="Close modal" type="button">
                                                <span aria-hidden="true">&times;</span>
                                            </button>

                                        </div>

                                        <?php endif; /* End check for user content */

                                    endforeach; /* End loop through users plans */ ?>
                                    </ul>
                                <?php else : ?>
                                    <p class="small text-gray" style="padding: 0 .5rem;"><?php esc_attr_e( 'No plans linked to this group.', 'zume' ) ?></p>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </div> <!-- end second tab-->
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div> <!--cell -->
</div><!-- end #content -->

<?php do_action( 'zume_movement_log_3mplan', [ 'language' => zume_current_language() ] ) ?>

<?php get_footer(); ?>
