<?php
/*
Template Name: 02 - Obedience Focused Disciple Making
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 2;
        set_query_var( 'session_number', absint( $session_number ) )
        ?>

        <!-- Wrappers -->
        <div id="content" class="grid-x grid-padding-x"><div  id="inner-content" class="cell">

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
                            <a href="<?php echo esc_url( zume_training_url() ) ?>"><?php echo esc_html__( 'This concept comes from the Zúme Training Course', 'zume' ) ?></a> - <a onclick="open_session(<?php echo esc_attr( $session_number ); ?>)"> <?php echo esc_html__('Session', 'zume' ) ?> 5</a>.
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

                        <section><!-- Step Title -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="step-title cell"><?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?></div>
                                <!-- step-title cell -->

                            </div>
                            <!-- grid-x -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                                <div class="large-9 cell activity-description">
                                    <?php esc_html_e( 'What is a disciple? And how do you make one? How do you teach a follower of Jesus to do what He told us in His Great Commission – to obey all of His commands?', 'zume' ) ?>
                                </div>
                            </div>

                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">


                                    <!-- 2 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_2' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '2' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                    <p class="center hide-for-small-only"><a
                                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '35' ) ) ?>"
                                            target="_blank" rel="noopener noreferrer nofollow"><img
                                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                                alt=""
                                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                                style="vertical-align: text-bottom"/> <?php esc_html_e( 'Zúme Video Scripts: Teach Them to Obey', 'zume' ) ?></a></p>
                                </div>
                            </div>
                            <!-- grid-x -->
                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                                <div class="large-9 cell activity-description">
                                    <ol class="rectangle-list">
                                        <li><?php esc_html_e( 'When you think of a church, what comes to mind?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'What\'s the difference between that picture and what\'s described in the video as a "Simple Church"?', 'zume' ) ?>
                                        </li>
                                        <li><?php esc_html_e( 'Which one do you think would be easier to multiply and why?', 'zume' ) ?></li>
                                    </ol>
                                </div>
                            </div>
                            <!-- grid-x -->

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
                                <h3 class="center"><?php echo esc_html__('Video Transcript', 'zume' ) ?></h3>
                            </div>
                            <div class="large-12 cell activity-description-no-border">

                                <?php the_content(); ?>

                            </div>
                        </div>

                    </div>


                    <div class="large-2 cell"></div><!-- Side spacer -->
                </div> <!-- grid-x -->

            </div> <!-- end #inner-content --></div> <!-- end #content -->

    <?php get_template_part( "parts/content", "modal"); ?>

    <?php
    endwhile;
endif;
get_footer();