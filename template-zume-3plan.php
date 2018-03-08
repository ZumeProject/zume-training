<?php
/*
Template Name: Three-Month Plan
*/
zume_force_login();

/* Process $_POST content */
if ( isset( $_POST['thee_month_plan_nonce'] ) ) {
    // validate nonce
    if ( isset( $_POST['thee_month_plan_nonce'] ) && ! wp_verify_nonce( sanitize_key( $_POST['thee_month_plan_nonce'] ), "thee_month_plan_" . get_current_user_id() ) ) {
        return new WP_Error( 'fail_nonce_verification', 'The form requires a valid nonce, in order to process.' );
    }

    Zume_Three_Month_Plan::process_post( $_POST );
}

/* Build variables for page */
$zume_three_month_plan = get_user_meta( get_current_user_id(), 'three_month_plan' );
if ( empty( $zume_three_month_plan ) ) {
    $zume_three_month_plan = [];
}
?>

<?php get_header(); ?>

<div id="content" class="grid-x grid-padding-x"><div class="cell">
        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
            <div class="large-8 medium-8 small-12 grid-margin-x cell" style="max-width: 900px; margin: 0 auto">
                <h3 class="section-header"><?php echo esc_html__( 'Three Month Plan', 'zume' )?> </h3>
                <hr size="1" style="max-width:100%"/>
                <form data-abide method="post">

                    <?php wp_nonce_field( "thee_month_plan_" . get_current_user_id(), "thee_month_plan_nonce", false, true ); ?>

                    <table class="hover stack">
                        <?php
                        $zume_fields = Zume_Three_Month_Plan::plan_items();
                        foreach ( $zume_fields as $zume_key => $zume_label ) :
                        ?>
                        <tr style="vertical-align: top;">
                            <td>
                                <label for="<?php echo esc_attr( $zume_key ) ?>"><?php echo esc_html( $zume_label )?></label><br>

                                <textarea id="<?php echo esc_attr( $zume_key ) ?>" name="<?php echo esc_attr( $zume_key ) ?>">
                                    <?php echo esc_html( $zume_three_month_plan[ $zume_key ] ?? '' ) ?>
                                </textarea>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>

                    <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
                        <strong><?php echo esc_html__( 'Oh snap!', 'zume' )?></strong>
                    </div>

                    <button class="button" type="submit" id="submit_profile"><?php echo esc_html__( 'Save', 'zume' )?></button>

                </form>
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

    public static function plan_items() {
        $plan_items = [
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

            return $plan_items;
    }

    public static function plan_items_filter( $plan_meta) {
        if ( is_serialized( $plan_meta ) ) {
            $group_meta = maybe_unserialize( $plan_meta );
        }

    }

    public static function process_post( $response ) {
        return 1;
    }


}
