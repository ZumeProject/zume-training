<?php
/*
Template Name: 01 - God Uses Ordinary People
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 1;
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

                        <section><!-- Step Title -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p>Have you ever wondered how the church got started?</p>

                                    <p>The first church sent ordinary people around the world to tell others about
                                        Jesus. The first church sent ordinary people to stand before governors and
                                        generals and rulers and kings. The first church sent ordinary people to heal the
                                        sick, feed the hungry, raise the dead, and teach all of God’s commands to
                                        everyone in the world.</p>

                                    <p>The first church sent ordinary people to change the world. And they did.</p>

                                </div>
                            </div>
                            <div class="grid-x grid-margin-x grid-margin-y" >
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 1 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_1' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '1' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <!-- grid-x -->
                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php echo esc_html__( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell  content-large">
                                    <?php esc_html_e( 'If Jesus intended every one of His followers to obey His Great Commission, why do so few actually make disciples?', 'zume' ) ?>
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
                            <div class="cell content-large center">
                                <h3 class="center"><?php echo esc_html__( 'Video Transcript', 'zume' ) ?></h3>
                            </div>
                            <div class="cell content-large">

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
