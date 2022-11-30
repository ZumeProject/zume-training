<?php
/*
Template Name: Training
*/

get_header();
$user = wp_get_current_user();

if ( isset( $_GET['iframe'] ) && ! empty( $_GET['iframe'] ) ) {
    ?>
    <style>
        #top-bar {
            display:none;
        }
        #inner-footer {
            display:none;
        }
        #challenge {
            display:none;
        }
    </style>
    <?php
}

$current_language = zume_current_language();

$zume_first_time = '';
if ( is_user_logged_in() ) {
    if ( get_user_meta( get_current_user_id(), 'first_time_login', true ) ) {
        delete_user_meta( get_current_user_id(), 'first_time_login' );
        $zume_first_time = 'user_has_just_registered';
    }
}
?>
<div id="<?php echo esc_attr( $zume_first_time ) ?>" class="training">
    <div  id="inner-content" class="grid-x padding-top-1">
        <!-------------------------------------------------------------------------------------------------------------

        Challenge section (logged out)

        ------------------------------------------------------------------------------------------------------------->
        <?php if ( ! is_user_logged_in() ) : ?>
        <div id="challenge" class="cell">
            <div class="grid-x ">
                <div class="large-1 cell"></div> <!-- side padding -->

                <!-- Center Column -->
                <div class="large-10 cell">

                    <div class="callout">
                        <div class="grid-x grid-padding-x">
                            <div class="cell hide-for-small-only medium-1"></div>
                            <div class="cell medium-7">
                                <p class="t-ad-message"><?php echo esc_html__( "Plan your group, add members, track your progress, connect with a coach, and add your effort to the global vision!", 'zume' ) ?></p>
                            </div>
                            <div class="cell medium-4">
                                <a href="<?php echo esc_url( zume_register_url( $current_language ) ) ?>" class="button large secondary-button" ><?php echo esc_html__( "Register Forever Free", 'zume' ) ?></a>
                            </div>
                        </div>
                    </div><!-- end #callout -->

                </div> <!-- end center column -->

                <div class="large-1 cell"></div> <!-- side padding -->
            </div>
        </div> <!-- end #challenge-->
        <?php endif; ?>
        <!-------------------------------------------------------------------------------------------------------------
        End Challenge
        -------------------------------------------------------------------------------------------------------------->

        <div id="course" class="cell">
            <div class="grid-x">
                <div class="large-1 cell"></div> <!-- side padding -->

                <div class="large-10 cell"><!-- Center Column -->

                    <!--------------------------------------------------------------------------------------------------

                    Tabs (logged in)

                    --------------------------------------------------------------------------------------------------->
                    <?php if ( is_user_logged_in() ) : ?>
                        <ul class="tabs" data-tabs id="training-tabs" data-deep-link="true" data-deep-link-smudge="true" data-auto-focus="false">
                            <li class="tabs-title is-active">
                                <a href="#panel1" aria-selected="true" onclick="show_panel1()">
                                    <span class="show-for-small-only"><?php echo esc_html__( "Overview", 'zume' ) ?></span>
                                    <span class="hide-for-small-only"><?php echo esc_html__( "Course Overview", 'zume' ) ?></span>
                                </a>
                            </li>
                            <li class="tabs-title">
                                <a data-tabs-target="panel2" href="#panel2" onclick="get_groups()">

                                    <span class="show-for-small-only"> <?php echo esc_html__( "Groups", 'zume' ) ?></span>
                                    <span class="hide-for-small-only"> <?php echo esc_html__( "My Groups", 'zume' ) ?></span>
                                </a>
                            </li>
                            <li class="tabs-title">
                                <a data-tabs-target="panel3" href="#panel3" onclick="get_progress()">
                                    <span class="show-for-small-only"><?php echo esc_html__( "Checklist", 'zume' ) ?></span>
                                    <span class="hide-for-small-only"><?php echo esc_html__( "My Checklist", 'zume' ) ?></span>
                                </a>
                            </li>
                            <li class="tabs-title">
                                <a data-tabs-target="panel4" href="#panel4" onclick="get_coach_request()">
                                    <span class="show-for-small-only"><i class="fi-torso"></i></span>
                                    <span class="hide-for-small-only"><?php echo esc_html__( "Get a Coach", 'zume' ) ?></span>
                                </a>
                            </li>

                        </ul>

                    <?php endif; ?>

                    <!-- Training Content Wrapper-->
                    <div class="callout<?php if ( is_user_logged_in() ) : ?> tabs-content<?php endif; ?>" id="zume-training-course" data-tabs-content="training-tabs">
                        <!----------------------------------------------------------------------------------------------

                        Course Tab

                        ----------------------------------------------------------------------------------------------->
                        <div class="tabs-panel is-active hide-for-load" id="panel1">

                            <!-- Training content header -->
                            <?php if ( ! is_user_logged_in() ) : ?>
                            <div class="grid-x">
                                <div class="cell center text-uppercase">
                                    <h1><?php echo esc_html__( "Zúme Training", 'zume' ) ?></span></h1>
                                    <p class="t-description"><?php echo esc_html__( "10 Sessions, 2 hours each, for groups of 3 - 12", 'zume' ) ?></p>
                                </div>
                                <div class="cell">
                                    <hr />
                                </div>
                            </div>

                            <?php endif; ?>

                            <div class="grid-x grid-padding-x grid-padding-y">

                            <div class="cell small padding-top-0 padding-bottom-0" id="display-buttons">
                                <button id="column_button" type="button" class="button hollow tiny" onclick="toggle_column()"><?php echo esc_html__( "Single Column", 'zume' ) ?></button>
                                <button id="extra_button" type="button" class="button hollow tiny" onclick="toggle_extra()"><?php echo esc_html__( "Show Session Plan", 'zume' ) ?></button>
                            </div>

                            <!-- Session 1 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 1 )"><h2><?php echo esc_html__( 'Session 1', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 1 )" class="button primary-button-hollow" id="start_session_1"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra" style="display:none;">
                                        <?php echo esc_html__( "Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 1, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'God Uses Ordinary People', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 1, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 1, $current_language ) ) ?></a>
                                        <?php endif; ?>

                                        <br><p class="t-description"><?php esc_html_e( "You'll see how God uses ordinary people doing simple things to make a big impact.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 2, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Simple Definition of Disciple and Church', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 2, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 2, $current_language ) ) ?></a>
                                        <?php endif; ?>

                                        <p class="t-description"><?php esc_html_e( 'Discover the essence of being a disciple, making a disciple, and what is the church.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 3, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Spiritual Breathing is Hearing and Obeying God', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 3, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 3, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php esc_html_e( 'Being a disciple means we hear from God and we obey God.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 4, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'SOAPS Bible Reading', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 4, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 4, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php esc_html_e( 'A tool for daily Bible study that helps you understand, obey, and share God’s Word.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 5, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Accountability Groups', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 5, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 5, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php esc_html_e( 'A tool for two or three people of the same gender to meet weekly and encourage each other in areas that are going well and reveal areas that need correction.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Accountability groups", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "45 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 2 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 2 )"><h2><?php echo esc_html__( 'Session 2', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 2 )" class="button primary-button-hollow" id="start_session_2"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 6, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Consumer vs Producer Lifestyle', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 6, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 6, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "You'll discover the four main ways God makes everyday followers more like Jesus.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 7, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'How to Spend an Hour in Prayer', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 7, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 7, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( 'See how easy it is to spend an hour in prayer.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Prayer Cycle", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "60 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Discuss - Prayer Cycle", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 8, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Relational Stewardship - List of 100', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 8, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 8, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( 'A tool designed to help you be a good steward of your relationships.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Create List of 100", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "30 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 3 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 3 )"><h2><?php echo esc_html__( 'Session 3', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 3 )" class="button primary-button-hollow" id="start_session_3"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 9, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'The Kingdom Economy', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 9, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 9, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Learn how God's economy is different from the world's. God invests more in those who are faithful with what they've already been given.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Discuss - Should every disciple share?", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 10, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'The Gospel and How to Share It', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 10, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 10, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Learn a way to share God’s Good News from the beginning of humanity all the way to the end of this age.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Sharing the Gospel", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "45 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 11, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Baptism and How To Do It', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 11, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 11, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( 'Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of the Son and of the Holy Spirit…” Learn how to put this into practice.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 4 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 4 )"><h2><?php echo esc_html__( 'Session 4', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 4 )" class="button primary-button-hollow" id="start_session_4"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 12, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Prepare Your 3-Minute Testimony', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 12, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 12, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Learn how to share your testimony in three minutes by sharing how Jesus has impacted your life.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Share your testimony", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "45 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 13, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Vision Casting the Greatest Blessing', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 13, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 13, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( 'Learn a simple pattern of making not just one follower of Jesus but entire spiritual families who multiply for generations to come.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 14, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Duckling Discipleship - Leading Immediately', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 14, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 14, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Learn what ducklings have to do with disciple-making.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 15, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( "Eyes to See Where the Kingdom Isn't", 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 15, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 15, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( 'Begin to see where God’s Kingdom isn’t. These are usually the places where God wants to work the most.', 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 16, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( "The Lord's Supper and How to Lead It", 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 16, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 16, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "It’s a simple way to celebrate our intimate connection and ongoing relationship with Jesus. Learn a simple way to celebrate.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Lord's Supper", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 5 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 5 )"><h2><?php echo esc_html__( 'Session 5', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 5 )" class="button primary-button-hollow" id="start_session_5"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 17, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Prayer Walking and How To Do It', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 17, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 17, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "It’s a simple way to obey God’s command to pray for others. And it's just what it sounds like — praying to God while walking around!", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 18, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'A Person of Peace and How To Find One', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 18, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 18, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Learn who a person of peace might be and how to know when you've found one.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 19, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'The BLESS Prayer Pattern', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 19, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 19, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Practice a simple mnemonic to remind you of ways to pray for others.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - BLESS Prayer", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Prayer Walking", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "90 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 6 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 6 )"><h2><?php echo esc_html__( 'Session 6', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 6 )" class="button primary-button-hollow" id="start_session_6"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 20, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Faithfulness is Better Than Knowledge', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 20, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 20, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "It's important what disciples know — but it's much more important what they DO with what they know.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 21, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( '3/3 Group Meeting Pattern', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 21, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 21, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow, fellowship and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not just a small group but a Simple Church.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "75 min", 'zume' ) ?>
                                    </div>

                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 7 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 7 )"><h2><?php echo esc_html__( 'Session 7', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 7 )" class="button primary-button-hollow" id="start_session_7"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 22, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Training Cycle for Maturing Disciples', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 22, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 22, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Learn the training cycle and consider how it applies to disciple making.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - 3/3 Group", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "90 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Discuss - 3/3 Group Experience", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 8 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 8 )"><h2><?php echo esc_html__( 'Session 8', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 8 )" class="button primary-button-hollow" id="start_session_8"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 23, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Leadership Cells', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 23, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 23, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "A Leadership Cell is a way someone who feels called to lead can develop their leadership by practicing serving.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - 3/3 Group", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "90 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 9 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 9 )"><h2><?php echo esc_html__( 'Session 9', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 9 )" class="button primary-button-hollow" id="start_session_9"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 24, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Expect Non-Sequential Growth', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 24, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 24, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "See how disciple making doesn't have to be linear. Multiple things can happen at the same time.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 25, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Pace of Multiplication Matters', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 25, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 25, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Multiplying matters and multiplying quickly matters even more. See why pace matters.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 26, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Always Part of Two Churches', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 26, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 26, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Learn how to obey Jesus' commands by going AND staying.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <a href="<?php echo esc_url( zume_get_landing_translation_url( 27, $current_language ) ) ?>" rel=“nofollow”><?php esc_html_e( 'Three-Month Plan', 'zume' ); ?>
                                            <?php echo ( is_user_logged_in() ) ? '' : '('. esc_html__( "login required", 'zume' )  . ')'; ?></a><br>
                                        <p class="t-description"><?php echo esc_html__( "Create and share your plan for how you will implement the Zúme tools over the next three months.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Create 3-Month Plan", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "60 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Discuss - Share 3-Month Plan with group", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "20 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Session 10 -->
                            <div class="cell small-12 large-6 session">
                                <div class="grid-x grid-padding-x">
                                    <div class="cell medium-9 overview-title"><a onclick="open_session( 10 )"><h2><?php echo esc_html__( 'Session 10', 'zume' ) ?></h2></a></div>
                                    <div class="cell medium-3 start">
                                        <a onclick="open_session( 10 )" class="button primary-button-hollow" id="start_session_10"><?php echo esc_html__( "Start", 'zume' ) ?></a>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Check-in, Prayer, Overview", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 28, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Coaching Checklist', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 28, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 28, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "A powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Coaching Checklist Self-Assessment", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 29, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Leadership in Networks', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 29, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 29, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "Learn how multiplying churches stay connected and live life together as an extended, spiritual family.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 30, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Peer Mentoring Groups', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 30, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 30, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php echo esc_html__( "This is a group that consists of people who are leading and starting 3/3 Groups. It also follows a 3/3 format and is a powerful way to assess the spiritual health of God’s work in your area.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 31, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Four Fields Tool', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 31, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 31, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php esc_html_e( "The four fields diagnostic chart is a simple tool to be used by a leadership cell to reflect on the status of current efforts and the kingdom activity around them.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell medium-10">
                                        <?php if ( empty( zume_get_landing_title( 32, $current_language ) ) ) : ?>
                                            <span class="training-item">
                                                <?php esc_html_e( 'Generational Mapping', 'zume' ); ?>
                                            </span>
                                        <?php else : ?>
                                            <a href="<?php echo esc_url( zume_get_landing_translation_url( 32, $current_language ) ) ?>"><?php echo esc_html( zume_get_landing_title( 32, $current_language ) ) ?></a>
                                        <?php endif; ?>
                                        <p class="t-description"><?php esc_html_e( "Generation mapping is another simple tool to help leaders in a movement understand the growth around them.", 'zume' ) ?></p>
                                    </div>
                                    <div class="cell medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "15 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - 3/3 Peer Mentoring", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "60 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Four Fields", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Practice - Generation Mapping", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "10 min", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-9 medium-10 t-activities hide-extra">
                                        <?php echo esc_html__( "Looking Forward", 'zume' ) ?>
                                    </div>
                                    <div class="cell small-3 medium-2 t-length hide-extra">
                                        <?php echo esc_html__( "5 min", 'zume' ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        </div>
                        <!----------------------------------------------------------------------------------------------

                        My Groups Tab (logged in)

                        ----------------------------------------------------------------------------------------------->
                        <div class="tabs-panel" id="panel2">
                            <div class="grid-x"><div class="cell center border-bottom " id="add_group_container"><!-- add button--></div></div>
                            <div id="invitation-list"><!-- invitation section--></div>
                            <div class="grid-x margin-top-2" id="group-list"><!-- group list --></div>
                            <div id="archive-list"><!-- archive section--></div>
                        </div>
                        <!----------------------------------------------------------------------------------------------

                        My Progress Tab (logged in)

                        ----------------------------------------------------------------------------------------------->
                        <div class="tabs-panel" id="panel3">
                            <div class="grid-x" id="progress-stats"><div class="loader">Loading...</div></div>
                        </div>
                        <!----------------------------------------------------------------------------------------------

                         Get a Coach (logged in)

                         ----------------------------------------------------------------------------------------------->
                        <div class="tabs-panel" id="panel4">
                            <div class="grid-x" id="coach-request"><div class="loader">Loading...</div></div>
                        </div>

                    </div> <!-- end #callout -->

                </div> <!-- end center column -->

                <div class="large-1 cell"></div> <!-- side padding -->
            </div>
        </div> <!-- end #challenge-->
    </div> <!-- end #inner-content -->
</div> <!-- end #content -->

<?php get_template_part( "parts/content", "modal" ); ?>

<?php

get_footer();
