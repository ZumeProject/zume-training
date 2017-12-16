<?php
/*
Template Name: Zume About
*/
?>

<?php get_header(); ?>

    <div id="content">

        <div id="inner-content">

            <div class="grid-x ">
                <div class="large-2 cell"></div>

                <div class="large-8 small-12 cell">

                    <!-- Video -->
                    <div class="responsive-embed widescreen"><!-- TODO: Add multilanguage video switcher-->
                        <iframe allowFullScreen frameborder="0" height="564" mozallowfullscreen
                                src="https://player.vimeo.com/video/245293029" webkitAllowFullScreen
                                width="640"></iframe>
                    </div>

                    <div class="grid-x row vertical-padding">
                        <div class="cell ">
                            <p style="font-size: 150%; margin: 20px 0 40px 0; text-align: center;"><?php esc_html_e( 'Zúme Training is an on-line and in-life learning experience designed for small groups who follow Jesus to learn how to obey His Great Commission and make disciples who multiply.', 'zume' ) ?></p>
                        </div>
                    </div>

                </div>
                <div class="large-2 cell"></div>
            </div>

            <!-- Goals -->
            <div class="grid-x">
                <div class="cell vertical-padding" style="background-color:#323A68;">
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-2 cell"></div>
                        <div class="cell large-8" style="color: white;">
                            <h3 style="color: white;"><?php esc_html_e( 'Goals of the Zúme Project:', 'zume' ) ?></h3>
                            <p>
                                <?php esc_html_e( 'Zúme means yeast in Greek. In Matthew 13:33 Jesus is quoted as saying, "The Kingdom of Heaven is like a woman who took yeast and mixed it into a large amount of flour until it was all leavened." This illustrates how ordinary people, using ordinary resources, can have an extraordinary impact for the Kingdom of God. Zúme aims to equip and empower ordinary believers to reach every neighborhood.', 'zume' ) ?>
                            </p>
                            <p>
                                <?php __( 'The initial goal of Zúme is for there to be a training group of four to twelve people in each census tract in the country. Each of these training groups will start two first-generation churches which will then begin to reproduce. There are about 75,000 census tracts in the U.S.', 'zume' ) ?>
                            </p>
                        </div>
                        <div class="large-2 cell"></div>
                    </div>

                </div>
            </div>

            <!-- Description -->
            <div class="grid-x vertical-padding">
                <div class="medium-2 cell"></div>
                <div class="medium-8 cell ">

                    <div class="grid-x  vertical-padding">
                        <div class="large-4 cell ">
                            <img src="/wp-content/themes/zume-project-multilingual/assets/images/pages/training2.png"
                                 alt="Zúme in 10 sessions, 2 hours each, cost: free" height="150"/>
                        </div>
                        <div class="large-8 cell ">
                            <h3><?php esc_html_e( 'Zúme Training consists of nine (two-hour) Basic Sessions and includes:', 'zume' ) ?></h3>
                            <ul>
                                <li><?php esc_html_e( 'Video and Audio to help your group understand basic principles of multiplying disciples.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Group Discussions to help your group think through what’s being shared.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Simple Exercises to help your group put what you’re learning into practice.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Session Challenges to help your group keep learning and growing between sessions.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'There is an optional Session 10 with extra material.', 'zume' ) ?></li>
                            </ul>
                        </div>
                    </div>


                    <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                        <div class="medium-4 cell ">
                            <img src="/wp-content/themes/zume-project-multilingual/assets/images/pages/getstarted.png"
                                 alt="" width="230" height="150"/>
                        </div>
                        <div class="medium-8 cell ">
                            <h3><?php esc_html_e( 'How to get started:', 'zume' ) ?></h3>
                            <ul style="margin-bottom: 1.8rem;">
                                <li><?php esc_html_e( 'If you haven\'t created a login yet, please do so.', 'zume' ) ?></li>
                                <li>
                                    <?php esc_html_e( 'Invite 3-11 friends. You must have at least four people present, who have accepted your invitation, to start the first session.', 'zume' ) ?>
                                </li>
                                <li><?php esc_html_e( 'Schedule a time to get together with your friends.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Make sure you have access to an internet-enabled device.', 'zume' ) ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                        <div class="medium-4 cell ">
                            <img src="/wp-content/themes/zume-project-multilingual/assets/images/pages/guidebook.png"
                                 alt=""
                                 width="230" height="150"/>
                        </div>
                        <div class="medium-8 cell">
                            <h3><?php esc_html_e( 'Optional prep for your first meeting:', 'zume' ) ?></h3>
                            <ul>
                                <li><?php esc_html_e( 'Download the Zúme Guidebook.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'If you\'d like, you can print out copies for the members of your group.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Consider connecting to a TV or projector so everyone in your group can view the content.', 'zume' ) ?>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="large-2 cell"></div>
            </div><!-- end #main -->

        </div> <!-- end #inner-content -->

    </div>

<?php get_footer(); ?>
