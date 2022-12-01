<?php
/*
Template Name: Zume About
*/

$zume_current_lang = zume_current_language();
$alt_video = zume_alt_video( $zume_current_lang );


?>

<?php get_header(); ?>

    <div id="content" class="grid-x grid-padding-x"><div class="cell">

        <div id="inner-content">

            <!-- Challenge -->
            <div class="grid-x grid-margin-x">
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell center">
                    <h1 class="primary-color-text">
                        <strong><?php esc_html_e( 'About Zúme Training', 'zume' ) ?></strong>
                    </h1>
                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <div class="grid-x ">
                <div class="large-2 cell"></div>

                <div class="large-8 small-12 cell">

                    <!-- 32 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="about-video-section">
                            <video style="border: 1px solid lightgrey;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() . '/32.mp4' ) ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="responsive-embed widescreen">
                            <iframe allowFullScreen frameborder="0" height="564" mozallowfullscreen
                                    src="<?php echo esc_url( Zume_Course::get_video_by_key( '32' ) ) ?>" webkitAllowFullScreen
                                    width="640"></iframe>
                        </div>
                    <?php endif; ?>

                    <div class="grid-x row vertical-padding">
                        <div class="cell ">
                            <p style="font-size: 150%; margin: 20px 0 40px 0; text-align: center;"><?php esc_html_e( 'Zúme uses an online training platform to equip participants in basic disciple-making and simple church planting multiplication principles, processes, and practices.', 'zume' ) ?></p>
                        </div>
                    </div>

                </div>
                <div class="large-2 cell"></div>
            </div>

            <!-- Goals of the Zume Project -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="background-color:#323A68;">
                <div class="large-2 cell"></div>
                <div class="cell large-8" style="color: white;">
                    <h3 class="secondary" style="color: white;"><?php esc_html_e( 'Goals of the Zúme Project:', 'zume' ) ?></h3>
                    <p>
                        <?php esc_html_e( 'Zúme means yeast in Greek. In Matthew 13:33, Jesus is quoted as saying, "The Kingdom of Heaven is like a woman who took yeast and mixed it into a large amount of flour until it was all leavened." This illustrates how ordinary people, using ordinary resources, can have an extraordinary impact for the Kingdom of God. Zúme aims to equip and empower ordinary believers to saturate the globe with multiplying disciples in our generation.', 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'Zúme uses an online training platform to equip participants in basic disciple-making and simple church planting multiplication principles, processes, and practices.', 'zume' ) ?>
                    </p>
                </div>
                <div class="large-2 cell"></div>
            </div>

            <!-- Description -->
            <div class="grid-x vertical-padding">
                <div class="medium-2 cell"></div>
                <div class="medium-8 cell ">

                    <div class="grid-x grid-padding-x grid-padding-y">
                        <div class="medium-4 cell center">
                            <img src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>training2.png"
                                 alt="Zúme consists of 10 sessions, 2 hours each" height="150"/>
                        </div>
                        <div class="medium-8 cell ">
                            <h3><?php esc_html_e( 'Zúme consists of 10 sessions, 2 hours each', 'zume' ) ?>:</h3>
                            <ul>
                                <li><?php esc_html_e( 'Video and Audio to help your group understand basic principles of multiplying disciples.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Group Discussions to help your group think through what’s being shared.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Simple Exercises to help your group put what you’re learning into practice.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Session Challenges to help your group keep learning and growing between sessions.', 'zume' ) ?></li>
                            </ul>
                        </div>
                    </div>


                    <div class="grid-x grid-padding-x grid-padding-y">
                        <div class="medium-4 cell center">
                            <img src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>getstarted.png"
                                 alt="" width="230" height="150"/>
                        </div>
                        <div class="medium-8 cell ">
                            <h3><?php esc_html_e( 'How to get started:', 'zume' ) ?></h3>
                            <ul style="margin-bottom: 1.8rem;">
                                <li><?php esc_html_e( 'If you haven\'t created a login yet, please do so.', 'zume' ) ?></li>
                                <li>
                                    <?php esc_html_e( 'Invite 3-11 friends. A minimum group of 3-4 is needed for the practice and elements of the training.', 'zume' ) ?>
                                </li>
                                <li><?php esc_html_e( 'Schedule a time to get together with your friends.', 'zume' ) ?></li>
                                <li><?php esc_html_e( 'Make sure you have access to an internet-enabled device.', 'zume' ) ?></li>
                            </ul>
                        </div>
                    </div>

                    <div class="grid-x grid-padding-x grid-padding-y">
                        <div class="medium-4 cell center">
                            <img src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>guidebook.png"
                                 alt=""
                                 width="230" height="150"/>
                        </div>
                        <div class="medium-8 cell ">
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

        </div> <!-- cell -->
    </div> <!-- content -->

<?php get_footer(); ?>
