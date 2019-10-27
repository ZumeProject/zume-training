<?php
/*
Template Name: 11 - Baptism
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 11;
        set_query_var( 'session_number', absint( $session_number ) )
        ?>

        <!-- Wrappers -->
        <div id="content" class="grid-x grid-padding-x training"><div  id="inner-content" class="cell">

                <!------------------------------------------------------------------------------------------------>
                <!-- Title section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                    <div class="medium-2 small-1 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="medium-8 small-10 cell center">

                        <img src="<?php echo get_theme_file_uri() ?>/assets/images/zume_images/V5.1/1Waving1Not.svg" width="200px" />

                        <h1>
                            <strong><?php the_title(); ?></strong>
                        </h1>
                        <p>
                            <a href="<?php echo esc_url( zume_training_url() ) ?>"><?php echo esc_html__( 'This concept comes from the Zúme Training Course', 'zume' ) ?></a> - <a onclick="open_session(<?php echo esc_attr( $session_number ); ?>)"> <?php echo esc_html__( 'Session', 'zume' ) ?> <?php echo esc_html( $session_number ) ?></a>.
                        </p>
                    </div>

                    <div class="medium-2 small-1 cell"></div><!-- Side spacer -->
                </div>


                <!------------------------------------------------------------------------------------------------>
                <!-- Unique page content section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x ">
                    <div class="large-2 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="large-8 small-12 cell" id="training-content">
                        <section>

                            <!-- Step Title -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="step-title cell">
                                    <?php esc_html_e( 'Read and Discuss (15min)', 'zume' ) ?>
                                </div> <!-- step-title cell -->
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="large-3 cell activity-title"><?php esc_html_e( 'READ', 'zume' ) ?></div>
                                <div class="large-9 cell activity-description">
                                    <p class="read-section">
                                        <?php esc_html_e( 'Baptism', 'zume' ) ?>
                                    </p>
                                    <p>
                                        <?php esc_html_e( 'Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of the Son and of the Holy Spirit…”', 'zume' ) ?>
                                    </p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Inset Block -->
                            <div class="grid-x grid-margin-x grid-margin-y single">
                                <div class="cell auto"></div>
                                <div class="large-9 cell activity-description well">
                                    <div class="grid-x grid-padding-x grid-padding-y center" >
                                        <div class="cell session-boxes">
                                            <?php esc_html_e( 'Find the "Baptism" section in your Zúme Guidebook, and listen to the audio below.', 'zume' ) ?>
                                        </div>
                                    </div>

                                </div>
                                <div class="cell auto"></div>
                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 11 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_11' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '11' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                    <p class="center hide-for-small-only"><a target="_blank" rel="noopener noreferrer nofollow"
                                                                             href="<?php echo esc_url( Zume_Course::get_download_by_key( '44' ) ) ?>"><img
                                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                                alt=""
                                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Baptism", 'zume' ) ?></a></p>
                                </div>
                            </div> <!-- grid-x -->
                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                                <div class="large-9 cell activity-description">
                                    <ol>
                                        <li><?php esc_html_e( 'Have you ever baptized someone?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'Would you even consider it?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'If the Great Commission is for every follower of Jesus, does that mean every follower is allowed to baptize others? Why or why not?', 'zume' ) ?>
                                        </li>
                                    </ol>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Inset Block -->
                            <div class="grid-x grid-margin-x grid-margin-y single">
                                <div class="cell auto"></div>
                                <div class="large-9 cell activity-description well">
                                    <div class="grid-x grid-padding-x grid-padding-y center" >
                                        <div class="cell session-boxes">
                                            <p>
                                                <?php esc_html_e( 'IMPORTANT REMINDER – Have you been baptized?', 'zume' ) ?>
                                            </p>
                                            <p>
                                                <?php esc_html_e( 'If not, then we encourage you to plan this before even one more session of this training. Invite your group to be a part of this important day when you celebrate saying "yes" to Jesus.', 'zume' ) ?>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                                <div class="cell auto"></div>
                            </div> <!-- grid-x -->
                        </section>
                    </div>

                    <div class="large-2 cell"></div><!-- Side spacer -->
                </div> <!-- grid-x -->


                <!------------------------------------------------------------------------------------------------>
                <!-- Share section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x ">
                    <div class="large-2 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="large-8 small-12 cell">

                        <?php get_template_part( 'parts/content', 'share' ); ?>

                    </div>
                    <div class="large-2 cell"></div><!-- Side spacer -->
                </div> <!-- grid-x -->


                <!------------------------------------------------------------------------------------------------>
                <!-- Transcription section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x">
                    <div class="large-2 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="large-8 small-12 cell">

                        <div class="grid-x grid-margin-x grid-margin-y">
                            <div class="large-12 cell activity-description-no-border center">
                                <h3 class="center"><?php echo esc_html__( 'Video Transcript', 'zume' ) ?></h3>
                            </div>
                            <div class="large-12 cell activity-description-no-border">

                                <?php the_content(); ?>

                            </div>
                        </div>

                    </div>


                    <div class="large-2 cell"></div><!-- Side spacer -->
                </div> <!-- grid-x -->

            </div> <!-- end #inner-content --></div> <!-- end #content -->

        <?php get_template_part( "parts/content", "modal" ); ?>

        <?php
    endwhile;
endif;
get_footer();
