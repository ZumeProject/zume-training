<?php
/*
Template Name: Three-Month Plan
*/
zume_force_login();

/* Process $_POST content */
$zume_error_message = '';
if ( isset( $_POST['thee_month_plan_nonce'] ) ) {
    // validate nonce
    if ( isset( $_POST['thee_month_plan_nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['thee_month_plan_nonce'] ), "thee_month_plan_" . get_current_user_id() ) ) {
        return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
    } else {
        unset( $_POST['thee_month_plan_nonce'] );
    }

    $status = Zume_Three_Month_Plan::edit_post( $_POST );
    if( 'Public_Key_Error' === $status['status'] ) {
        $zume_error_message = $status['message'];
    }
}

/* Build variables for page */
$zume_three_month_plan = Zume_Three_Month_Plan::plan_items_filter( get_user_meta( get_current_user_id(), 'three_month_plan', true ) );
$zume_groups = Zume_Dashboard::get_current_user_groups();

zume_write_log( $zume_groups );
?>

<?php get_header(); ?>

<div id="content" class="grid-x grid-padding-x"><div class="cell">
        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
            <div class="large-8 medium-8 small-12 grid-margin-x cell" style="max-width: 900px; margin: 0 auto">
                <h3 class="section-header"><?php echo esc_html__( 'Three Month Plan', 'zume' )?> </h3>

                <p><?php esc_attr_e('The Three Month Plan is part of the session 9 training and helps you become specific on how you will apply the training in the near future.
                You can connect your three month plan to a group by adding the the group key. Check with your group leader to get the key.', 'zume') ?></p>
                <hr>

                <?php echo empty( $zume_error_message ) ? '' : '<div class="callout alert">'. $zume_error_message .'</div>' ?>

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
                        $zume_fields = Zume_Three_Month_Plan::plan_labels();
                        $zume_index = 1;
                        foreach ( $zume_fields as $zume_key => $zume_label ) :

                            if ( 'public_key' === $zume_key ) {
                                Zume_Three_Month_Plan::get_public_key_field( $zume_key, $zume_label );
                                continue;
                            }
                            ?>
                            <tr>
                                <td>
                                    <label for="<?php echo esc_attr( $zume_key ) ?>"><strong>(<?php echo esc_attr( $zume_index ) ?>) <?php echo esc_html( $zume_label )?></strong></label>
                                    <textarea id="<?php echo esc_attr( $zume_key ) ?>" name="<?php echo esc_attr( $zume_key ) ?>" rows="3"><?php echo esc_html( $zume_three_month_plan[ $zume_key ] ?? '' ) ?></textarea>
                                </td>
                            </tr>
                         <?php $zume_index++; endforeach; ?>
                    </table>
                    <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
                        <strong><?php echo esc_html__( 'Oh snap!', 'zume' )?></strong>
                    </div>
                    <button class="button" type="submit" id="submit_profile"><?php echo esc_html__( 'Save', 'zume' )?></button>
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
                                        if( $zume_participant_plan ) :
                                        ?>
                                        <li><a data-open="<?php echo esc_html( $zume_key ); ?>"><?php echo $zume_participant_plan['user']->user_name ?></a></li>
                                        <div class="grid-x">
                                            <div class="cell">

                                            </div>
                                        </div>


                                    <?php endif; /* End check for user content */ endforeach; /* End loop through users plans */ ?>
                                    </ul>
                                <?php else : ?>
                                    <p class="small text-gray" style="padding: 0 .5rem;"><?php esc_attr_e('No plans found', 'zume' ) ?></p>
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

<?php

/**
 * Class Zume_Three_Month_Plan
 */
class Zume_Three_Month_Plan
{

    /**
     * Filter all db gets of the three-month plan so that the array conforms and is upgraded.
     *
     * @param $plan_meta
     * @return array|mixed
     */
    public static function plan_items_filter( $plan_meta ) {
        if ( is_serialized( $plan_meta ) ) {
            $plan_meta = maybe_unserialize( $plan_meta );
        }

        $active_keys = [
            'public_key' => '',
            'people_to_share_with' => '',
            'people_for_accountablity' => '',
            'people_to_challenge' => '',
            'people_to_3_3_invite' => '',
            'people_to_3_3_challenge' => '',
            'people_to_discover_invite' => '',
            'people_to_prayer_walk_with' => '',
            'people_to_equip_list_100' => '',
            'people_to_challenge_prayer' => '',
            'my_prayer_commitment' => '',
            'my_prayer_walk_commitment' => '',
            'people_for_leadership_cell' => '',
            'people_for_zume' => '',
            'other_commitments' => '',
        ];
        $deprecated_keys = [

        ];

        if ( ! is_array( $plan_meta ) || empty( $plan_meta ) ) {
            $plan_meta = [];
        }

        // Active keys
        foreach ( $active_keys as $active_key ) {
            if ( ! isset( $plan_meta[ $active_key ] ) ) {
                $plan_meta[$active_key] = '';
            }
        }

        // Deprecated keys
        foreach ( $deprecated_keys as $deprecated_key ) {
            if ( isset( $plan_meta[ $deprecated_key ] ) ) {
                unset( $plan_meta[$deprecated_key] );
            }
        }

        return $plan_meta;

    }

    public static function plan_labels( $key = null ) {
        $active_plan_items = [
            'public_key' => __('Group Key (optional)', 'zume'),
            'people_to_share_with' => __( 'I will share My Story [Testimony] and God’s Story [the Gospel] with the following individuals:', 'zume' ),
            'people_for_accountablity' => __( 'I will invite the following people to begin an Accountability Group with me:', 'zume' ),
            'people_to_challenge' => __( 'I will challenge the following people to begin their own Accountability Groups and train them how to do it:', 'zume' ),
            'people_to_3_3_invite' => __( 'I will invite the following people to begin a 3/3 Group with me:', 'zume' ),
            'people_to_3_3_challenge' => __( 'I will challenge the following people to begin their own 3/3 Groups and train them how to do it:', 'zume' ),
            'people_to_discover_invite' => __( 'I will invite the following people to participate in a 3/3 Hope or Discover Group [see Appendix]:', 'zume' ),
            'people_to_prayer_walk_with' => __( 'I will invite the following people to participate in Prayer Walking with me:', 'zume' ),
            'people_to_equip_list_100' => __( 'I will equip the following people to share their story and God’s Story and make a List of 100 of the people in their relational network:', 'zume' ),
            'people_to_challenge_prayer' => __( 'I will challenge the following people to use the Prayer Cycle tool on a periodic basis:', 'zume' ),
            'my_prayer_commitment' => __( 'I will use the Prayer Cycle tool once every [days / weeks / months].', 'zume' ),
            'my_prayer_walk_commitment' => __( 'I will Prayer Walk once every [days / weeks / months].', 'zume' ),
            'people_for_leadership_cell' => __( 'I will invite the following people to be part of a Leadership Cell that I will lead:', 'zume' ),
            'people_for_zume' => __( 'I will encourage the following people to go through this Zúme Training course:', 'zume' ),
            'other_commitments' => __( 'Other commitments:', 'zume' ),
        ];

        if ( is_null( $key ) ) {
            return $active_plan_items;
        } else {
            return $active_plan_items[ $key ];
        }

    }

    public static function edit_post( $submitted_plan ) {

        $current_plan = self::plan_items_filter( get_user_meta( get_current_user_id(), 'three_month_plan', true ) );

        $default_keys = array_keys( self::plan_labels() ); // get expected keys

        // filter
        foreach ( $default_keys as $key ) {
            if ( isset( $submitted_plan[ $key ] ) ) {
                $plan[ $key ] = sanitize_text_field( wp_unslash( $submitted_plan[ $key ] ) );
            }
        }

        // test for group key
        $public_key_error = false;
        if ( isset( $plan['public_key'] ) ) {
            $group_key = Zume_Dashboard::verify_public_key_for_group( $plan['public_key'] );
            if ( $group_key ) {
                // setup public key success

            } else {
                // set up public key fail
                $public_key_error = true;
            }
        }


        $plan = wp_parse_args( $plan, $current_plan );

        $result = update_user_meta( get_current_user_id(), 'three_month_plan', $plan );
        if ( ! $result ) {
            return [ 'status' => 'Fail', 'message' => __( 'Unable to save three month plan.', 'zume' ) ];
        }

        if ($public_key_error ) {
            return [ 'status' => 'Public_Key_Error', 'message' => __( 'Unable to find key:', 'zume' ) . ' ' . $plan['public_key'] ];
        }

        return [ 'status' => 'OK' ];
    }

    
    /**
     * Gets the three month plan for a user
     * Warning: Does not do permission checking. This must be done previously.
     *
     * @param int $user_id
     * @return array|bool
     */
    public static function get_user_three_month_plan( int $user_id ) {

        $user = get_user_by('id', $user_id );
        if ( ! $user ) {
            return false;
        }

        $plan = self::plan_items_filter(  get_user_meta( $user_id, 'three_month_plan', true ) );
        $labels = self::plan_labels();

        $full_plan = [
            'user' => $user,
            'plan' => $plan,
            'labels' => $labels,
        ];

        return $full_plan;


    }

}
