<?php
/*
Template Name: Zúme Overview
*/

/**
 * Begin page template for Zume Overview
 */


get_header();

?>

    <div id="content">

        <div id="inner-content" class="grid-x grid-padding-x">
            <div class="cell medium-1 hide-for-small-only"></div>

            <div id="main" class="cell auto" role="main">

                <?php
                /**
                 * Zúme Overview Content Loader
                 *
                 * @param 'id' in the url the id and session number is used to call the correct session.
                 */

                $zume_session  = 1;
                $zume_language = zume_current_language();
                if ( is_wp_error( $zume_language ) ) {
                    $zume_language = 'en';
                }

                Zume_Overview_Content::load_sessions();

                ?>

            </div> <!-- end #main -->
            <div class="cell medium-1 hide-for-small-only"></div>

        </div> <!-- end #inner-content -->

    </div><!-- end #content -->

<?php

get_footer();

/**
 * End Page Template
 */

?>


<?php

/**
 * HTML Content for the Zume Overview
 */
class Zume_Overview_Content {

    /**
     * Zume Overview: Primary content section
     * @return mixed
     */
    public static function load_sessions() {
        ?>

        <div class="grid-x hide-for-large">
            <div class="cell large-8">
                <h2 class="" style="font-weight: 600;text-align: center"><?php esc_html_e( "Sessions Overview", 'zume' ) ?></h2>
            </div>
        </div>
        <div class="grid-x">

            <div class="cell large-3 left" data-sticky-container>
                <div class="sticky" data-sticky data-top-anchor="overview" data-sticky-on="large" data-margin-top="10" style="min-width:150px">
                    <?php self::menu() ?>
                </div>
            </div>
            <div id="left-column" class="large-auto cell" style="max-width: 1000px">
                <div class="grid-x show-for-large">
                    <div class="cell large-8">
                        <h2 class="" style="font-weight: 600;text-align: center"><?php esc_html_e( "Sessions Overview", 'zume' ) ?></h2>
                    </div>
                </div>
                <div id="overview">
                    <section class="vertical-padding" id="session1" data-magellan-target="session1">

                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding" style="margin-top:20px"><?php echo esc_html__( 'Session 1', 'zume' ) ?></h3>
                            </div>
                        </div>
                        <?php self::session_overview_1(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding"  id="session2" data-magellan-target="session2">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 2", 'zume' ) ?></h3>
                            </div>
                        </div>
                        <?php self::session_overview_2(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding" id="session3" data-magellan-target="session3">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 3", 'zume' ) ?></h3>
                            </div>
                        </div>
                        <?php self::session_overview_3(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding" id="session4" data-magellan-target="session4">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 4", 'zume' ) ?></h3>
                            </div>
                        </div>
                        <?php self::session_overview_4(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding" id="session5" data-magellan-target="session5">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 5", 'zume' ) ?></h3>
                            </div>
                        </div>

                        <?php self::session_overview_5(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding" id="session6" data-magellan-target="session6">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 6", 'zume' ) ?></h3>
                            </div>
                        </div>

                        <?php self::session_overview_6(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding" id="session7" data-magellan-target="session7">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 7", 'zume' ) ?></h3>
                            </div>
                        </div>

                        <?php self::session_overview_7(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding" id="session8" data-magellan-target="session8">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 8", 'zume' ) ?></h3>
                            </div>
                        </div>

                        <?php self::session_overview_8(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding" id="session9" data-magellan-target="session9">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 9", 'zume' ) ?></h3>
                            </div>
                        </div>

                        <?php self::session_overview_9(); ?>
                    </section>

                    <h3></h3>
                    <section class="vertical-padding" id="session10" data-magellan-target="session10">
                        <div class="grid-x">
                            <div class="cell large-8">
                                <h3 class="vertical-padding"><?php echo esc_html__( "Session 10 - Advanced Training", 'zume' ) ?></h3>
                            </div>
                        </div>

                        <?php self::session_overview_10(); ?>
                    </section>

                </div>
            </div>

        </div>




        <?php if ( is_user_logged_in() ) {
            self::next_session_block();
        }
        ?>

        <?php
    }

    public static function menu() {
        ?>
        <div  >
            <ul class="vertical menu" data-smooth-scroll style="text-align: center;">
                <li><a href="#session1"><?php esc_html_e( "Session 1", 'zume' ) ?></a></li>
                <li><a href="#session2"><?php esc_html_e( "Session 2", 'zume' ) ?></a></li>
                <li><a href="#session3"><?php esc_html_e( "Session 3", 'zume' ) ?></a></li>
                <li><a href="#session4"><?php esc_html_e( "Session 4", 'zume' ) ?></a></li>
                <li><a href="#session5"><?php esc_html_e( "Session 5", 'zume' ) ?></a></li>
                <li><a href="#session6"><?php esc_html_e( "Session 6", 'zume' ) ?></a></li>
                <li><a href="#session7"><?php esc_html_e( "Session 7", 'zume' ) ?></a></li>
                <li><a href="#session8"><?php esc_html_e( "Session 8", 'zume' ) ?></a></li>
                <li><a href="#session9"><?php esc_html_e( "Session 9", 'zume' ) ?></a></li>
                <li><a href="#session10"><?php esc_html_e( "Session 10", 'zume' ) ?></a></li>
            </ul>
        </div>

        <?php
    }

    public static function next_session_block() {
        ?>
        <br>
        <div class="grid-x grid-margin-x">
            <div class="large-3 small-1 cell"></div>
            <div class="large-6 small-10 cell center">
                <div class="callout">
                    <p class="center padding-bottom"><?php echo esc_html__( 'Go to the Dashboard to select your Group and start the next session', 'zume' ) ?></p>
                    <p class="center"><a href="<?php echo esc_html( zume_dashboard_url() ); ?>" class="button large"><?php echo esc_html__( 'Dashboard', 'zume' ) ?></a></p>
                </div>
            </div>
            <div class="large-3 small-1 cell"></div>
        </div>

        <?php
    }

    public static function session_overview_1() {
        ?>

        <div class="grid-x grid-margin-x">
            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>1.1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <img class="alignnone wp-image-944 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>1.2.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>1.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1564"/>
                            </div>
                            <div class="small-10 cell">
                                <?php esc_html_e( 'WELCOME TO ZÚME — You\'ll see how God uses ordinary people doing simple things to make a big impact.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-2.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1565"/>
                            </div>
                            <div class="small-10 cell">
                                <?php esc_html_e( 'TEACH THEM TO OBEY — Discover the essence of being a disciple, making a disciple, and what is the church.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-3.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1566"/>
                            </div>
                            <div class="small-10 cell">
                                <?php esc_html_e( 'SPIRITUAL BREATHING — Being a disciple means we hear from God and we obey God.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Tools -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Tools', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1.png"
                                     alt=""
                                     width="40" height="40" class="alignnone size-full wp-image-1035"/>
                            </div>
                            <div class="small-10 cell">
                                <?php esc_html_e( 'S.O.A.P.S. BIBLE READING — a tool for daily Bible study that helps you understand, obey, and share God’s Word.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y grid-margin-y">
                            <div class="small-2 cell center">
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-2.png"
                                     alt=""
                                     width="40" height="40" class="alignnone size-full wp-image-1567"/>
                            </div>
                            <div class="small-10 cell">
                                <?php esc_html_e( 'ACCOUNTABILITY GROUPS — a tool for two or three people of the same gender to meet weekly and encourage each other in areas that are going well and reveal areas that need correction.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-2.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1568"/>
                            </div>
                            <div class="small-10 cell">
                                <?php esc_html_e( 'ACCOUNTABILITY GROUPS — Break into groups of two or three people to work through the Accountability Questions. (45 minutes)', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php
    }

    public static function session_overview_2() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">
            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>2.1.png"
                             alt="" class="alignnone size-full wp-image-948"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>2.2.png"
                             alt="" class="alignnone size-full wp-image-949"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img
                                src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>2.3-1.png"
                                alt="List 100 people you know, 3 categories: those who follow Jesus, those who don&#039;t follow Jesus, those they&#039;re not sure about"
                                width="400" height="225" class="alignnone size-full wp-image-1066"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-1-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1576"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "PRODUCERS VS. CONSUMERS — You'll discover the four main ways God makes everyday followers more like Jesus.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Tools -->
                <div class="grid-x grid-margin-y grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Tools', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-1-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1577"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( 'PRAYER CYCLE — See how easy it is to spend an hour in prayer.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-2-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1578"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( 'LIST OF 100 — a tool designed to help you be a good steward of your relationships.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>

                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y grid-margin-y ">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-1-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1579"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( 'PRAYER CYCLE — Spend 60 minutes in prayer individually.', 'zume' ) ?>
                            </div>
                        </div>
                        <div class="grid-x grid-margin-y grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-2-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1580"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( 'LIST OF 100 — Create your own list of 100. (30 minutes)', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
    }

    public static function session_overview_3() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">

            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y  hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img
                                src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>3.1-1.png"
                                alt="Whoever can be trusted with very little can also be trusted with much. - Jesus. Breathe in, hear, breathe out, obey and share. Giving God&#039;s blessings"
                                width="400" height="225" class="alignnone size-full wp-image-1068"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img
                                src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>3.2.png"
                                alt="Obey, do, practise, share, teach, pass on" width="400" height="225"
                                class="alignnone size-full wp-image-955"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img
                                src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>3.3.png"
                                alt="" width="400" height="225" class="alignnone size-full wp-image-957"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-1-2.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1023"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "SPIRITUAL ECONOMY — Learn how God's economy is different from the world's. God invests more in those who are faithful with what they've already been given.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-2-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1024"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "THE GOSPEL — Learn a way to share God’s Good News from the beginning of humanity all the way to the end of this age.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>

                </div>



                <!-- Tools -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Tools', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-baptism.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1183"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( 'BAPTISM — Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of the Son and of the Holy Spirit…” Learn how to put this into practice.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1026"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( 'SHARE GOD’S STORY — Break into groups of two or three and practice sharing God’s Story. (45 minutes)', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php
    }

    public static function session_overview_4() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">

            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>4.1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-944 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>4.2.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>4.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-1-2-2.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( 'GREATEST BLESSING — Learn a simple pattern of making not just one follower of Jesus but entire spiritual families who multiply for generations to come.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-2-2-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1029"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( 'EYES TO SEE — Begin to see where God’s Kingdom isn’t. These are usually the places where God wants to work the most.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>duckling-discipleship.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "DUCKLING DISCIPLESHIP — Learn what ducklings have to do with disciple-making.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Tools -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Tools', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-1-5.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1035"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "3-MINUTE TESTIMONY — Learn how to share your testimony in three minutes by sharing how Jesus has impacted your life.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-2-3.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1186"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "THE LORD'S SUPPER — It’s a simple way to celebrate our intimate connection and ongoing relationship with Jesus. Learn a simple way to celebrate.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-1-5.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "SHARING YOUR TESTIMONY — Break into groups of two or three and practice sharing your Testimony with others. (45 minutes)", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-2-3.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1186"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "THE LORD'S SUPPER — Take time as a group to do this together. (10 minutes)", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }

    public static function session_overview_5() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">

            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>5.1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-944 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>5.2.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>5.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-5.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "PERSON OF PEACE — Learn who a person of peace might be and how to know when you've found one.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Tools -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Tools', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-4.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1035"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "PRAYER WALKING — It’s a simple way to obey God’s command to pray for others. And it's just what it sounds like — praying to God while walking around!", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-1-1-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "B.L.E.S.S. PRAYER — Practice a simple mnemonic to remind you of ways to pray for others. (15 minutes)", 'zume' ) ?>
                            </div>
                        </div>
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-4.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "PRAYER WALKING — Break into groups of two or three and go out into the community to practice Prayer Walking. (60-90 minutes)", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php
    }

    public static function session_overview_6() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">

            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>6.1-1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-944 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>6.2.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>6.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-4.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "FAITHFULNESS — It's important what disciples know — but it's much more important what they DO with what they know.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Tools -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Tools', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-5.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1035"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "3/3 GROUP FORMAT — A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow, fellowship and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not just a small group but a Simple Church. (80 minutes)", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
    }

    public static function session_overview_7() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">

            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>7.1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-944 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>7.2-1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>7.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-1-6.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1570"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "TRAINING CYCLE — Learn the training cycle and consider how it applies to disciple making.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-5.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "3/3 GROUP — Your entire group will spend 90 minutes practicing the 3/3 Group Format.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php
    }

    public static function session_overview_8() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">

            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>8.1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img
                                class="alignnone wp-image-944 size-full"
                                src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>8.2.png"
                                alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>8.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-1-4.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "LEADERSHIP CELLS — A Leadership Cell is a way someone who feels called to lead can develop their leadership by practicing serving.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-5.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "3/3 GROUP — Your entire group will spend 90 minutes practicing the 3/3 Group Format.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php
    }

    public static function session_overview_9() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">

            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>9.1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-944 size-full"
                                src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>9.2.png"
                                alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>9.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-1-5.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "NON-SEQUENTIAL — See how disciple making doesn't have to be linear. Multiple things can happen at the same time.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-2-3.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1029"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "PACE — Multiplying matters and multiplying quickly matters even more. See why pace matters.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>concept-3-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1030"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "PART OF TWO CHURCHES — Learn how to obey Jesus' commands by going AND staying.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-1-3-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "3-MONTH PLAN — Create and share your plan for how you will implement the Zúme tools over the next three months. (60 minutes)", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php
    }

    public static function session_overview_10() {
        ?>

        <div class="grid-x grid-margin-y grid-margin-x">

            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x grid-margin-y hide-for-small-only">
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>10.1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img
                                class="alignnone wp-image-944 size-full"
                                src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>10.2.png"
                                alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <!-- image -->
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>10.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>



                <!-- Concepts -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Concepts', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "LEADERSHIP IN NETWORKS — Learn how multiplying churches stay connected and live life together as an extended, spiritual family.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Tools -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Tools', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>practice-1-4-1.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1572"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "COACHING CHECKLIST — The Coaching Checklist is a powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply.", 'zume' ) ?>
                            </div>
                        </div>
                    </div><div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-6.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1572"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "PEER MENTORING GROUPS — This is a group that consists of people who are leading and starting 3/3 Groups. It also follows a 3/3 format and is a powerful way to assess the spiritual health of God’s work in your area.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>

                </div>



                <!-- Practice -->
                <div class="grid-x grid-margin-y">
                    <div class="cell">
                        <h3 class="overview"><?php esc_html_e( 'Practice', 'zume' ) ?></h3>
                    </div>

                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="small-2 cell center">
                                <!-- image -->
                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ) ?>tool-1-6.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/>
                            </div>
                            <div class="small-10 cell">
                                <?php echo esc_html__( "PEER MENTORING GROUPS — Break into groups of two or three and work through the Peer Mentoring Group format. (60 minutes)", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <?php
    }

}
