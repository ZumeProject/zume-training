<?php
/*
Template Name: 28 - Coaching Checklist
*/
get_header();
if (have_posts()) :
    while (have_posts()) : the_post();
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
                            <a href="/dashboard"><?php echo esc_html__( 'This concept comes from the Zúme Training Course', 'zume' ) ?> - <?php echo esc_html__('Session', 'zume' ) ?> 5</a>.
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
                                    <?php esc_html_e( "Activity (10min)", 'zume' ) ?>
                                </div> <!-- step-title cell -->
                                <div class="center cell step-header"><?php esc_html_e( "Assess yourself using the coaching checklist.", 'zume' ) ?></div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="large-3 cell activity-title"><?php esc_html_e( 'ASSESS', 'zume' ) ?></div>
                                <div class="large-9 cell activity-description">
                                    <?php esc_html_e( "The Coaching Checklist is a powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply. It's also a powerful tool you can use to help others – and others can use to help you.", 'zume' ) ?>
                                    <br><br>
                                    <?php esc_html_e( "Find the Coaching Checklist section in your Zúme Guidebook, and take this quick (5-minutes or less) self-assessment:", 'zume' ) ?>
                                    <br><br>
                                    <ol>
                                        <li><?php esc_html_e( "Read through the Disciple Training Tools in the far left column of the Checklist.", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Mark each one of the Training Tools, using the following method:", 'zume' ) ?>
                                            <ul>
                                                <li> <?php esc_html_e( "If you're unfamiliar or don't understand the Tool – check the BLACK column", 'zume' ) ?>
                                                </li>
                                                <li>
                                                    <?php esc_html_e( "If you're somewhat familiar but still not sure about the Tool – check the RED column", 'zume' ) ?>
                                                </li>
                                                <li>
                                                    <?php esc_html_e( "If you understand and can train the basics on the Tool – check the YELLOW column", 'zume' ) ?>
                                                </li>
                                                <li>
                                                    <?php esc_html_e( "If you feel confident and can effectively train the Tool – check the GREEN column", 'zume' ) ?>
                                                </li>
                                            </ul>
                                        </li>
                                    </ol>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 28 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_28' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '28' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                    <p class="center hide-for-small-only">
                                        <a  href="<?php echo esc_url( Zume_Course::get_download_by_key( '60' ) ) ?>"
                                            target="_blank" rel="noopener noreferrer nofollow">
                                            <img    src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                                    alt=""
                                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                                    style="vertical-align: text-bottom"/>
                                            <?php esc_html_e( "Zúme Video Scripts: Coaching Checklist", 'zume' ) ?>
                                        </a>
                                    </p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                                <div class="large-9 cell activity-description">
                                    <ol>
                                        <li><?php esc_html_e( "Which Training Tools did you feel you would be able to train well?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Which ones made you feel vulnerable as a trainer?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Are there any Training Tools that you would add or subtract from the Checklist? Why?", 'zume' ) ?></li>
                                    </ol>
                                </div>
                            </div> <!-- grid-x -->
                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y single">
                                <div class="large-9 cell activity-description well">
                                    <div class="grid-x grid-padding-x grid-padding-y center" >
                                        <div class="cell session-boxes">
                                            <?php esc_html_e( "REMEMBER – Be sure to share your Coaching Checklist results with training partner or other mentor. If you're helping coach or mentor someone, use this tool to help you assess which areas need your attention and training.", 'zume' ) ?>
                                        </div>
                                    </div>

                                </div>
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

                        <?php get_template_part( 'parts/p', 'share' ); ?>

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
                        <hr>
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

    <?php
    endwhile;
endif;
get_footer();
