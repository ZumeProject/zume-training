<?php
/*
Template Name: Three-Month Plan
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

<div id="content" class="grid-x grid-padding-x"><div class="cell">
        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
            <div class="large-8 medium-8 small-12 grid-margin-x cell" style="max-width: 900px; margin: 0 auto">
                <h3 class="section-header"><?php echo esc_html__( 'Three Month Plan', 'zume' )?> </h3>
                <hr size="1" style="max-width:100%"/>
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
                    </table>

                    <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
                        <strong><?php echo esc_html__( 'Oh snap!', 'zume' )?></strong>
                    </div>

                    <button class="button" type="submit" id="submit_profile"><?php echo esc_html__( 'Save', 'zume' )?></button>

                    <script>
                        jQuery('#validate_addressprofile').keyup( function() {
                            check_address('profile')
                        });
                    </script>

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
    /**
     * Zume_Three_Month_Plan The single instance of Zume_Three_Month_Plan.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Three_Month_Plan Instance
     *
     * Ensures only one instance of Zume_Three_Month_Plan is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Three_Month_Plan instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    private $plan_labels = array();

    /**
     * Constructor function.
     * @access  public
     * @since   0.1
     */
    public function __construct() {
        $this->plan_labels = array(
            "I will share My Story [Testimony] and God’s Story [the Gospel] with the following individuals:",
            "I will invite the following people to begin an Accountability Group with me:",
            "I will challenge the following people to begin their own Accountability Groups and train them how to do it:",
            "I will invite the following people to begin a 3/3 Group with me:",
            "I will challenge the following people to begin their own 3/3 Groups and train them how to do it:",
            "I will invite the following people to participate in a 3/3 Hope or Discover Group [see Appendix]:",
            "I will invite the following people to participate in Prayer Walking with me:",
            "I will equip the following people to share their story and God’s Story and make a List of 100 of the people in their relational network:",
            "I will challenge the following people to use the Prayer Cycle tool on a periodic basis:",
            "I will use the Prayer Cycle tool once every [days / weeks / months].",
            "I will Prayer Walk once every [days / weeks / months].",
            "I will invite the following people to be part of a Leadership Cell that I will lead:",
            "I will encourage the following people to go through this Zúme Training course:",
            "Other commitments:"
        );
    }

    public static function plan_items() {
        $plan_items = [
                [
                    'key' => 'individuals_to_share_with',
                    'label' => __( 'I will share My Story [Testimony] and God’s Story [the Gospel] with the following individuals:' , 'zume' ),
                ],
                [
                    'key' => 'individuals_for_accountablity',
                    'label' => __( 'I will invite the following people to begin an Accountability Group with me:', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('I will challenge the following people to begin their own Accountability Groups and train them how to do it:', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('I will invite the following people to begin a 3/3 Group with me:', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('', 'zume' ),
                ],
                [
                    'key' => '',
                    'label' => __('', 'zume' ),
                ],


            "",
            "",
            "",
            "",
            "I will challenge the following people to begin their own 3/3 Groups and train them how to do it:",
            "I will invite the following people to participate in a 3/3 Hope or Discover Group [see Appendix]:",
            "I will invite the following people to participate in Prayer Walking with me:",
            "I will equip the following people to share their story and God’s Story and make a List of 100 of the people in their relational network:",
            "I will challenge the following people to use the Prayer Cycle tool on a periodic basis:",
            "I will use the Prayer Cycle tool once every [days / weeks / months].",
            "I will Prayer Walk once every [days / weeks / months].",
            "I will invite the following people to be part of a Leadership Cell that I will lead:",
            "I will encourage the following people to go through this Zúme Training course:",
            "Other commitments:"
        ];

            return $plan_items;
    }


}
