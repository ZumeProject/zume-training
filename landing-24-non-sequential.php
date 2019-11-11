<?php
/*
Template Name: 24 - Non-Sequential
*/
get_header();
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 9;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 24;
        set_query_var( 'tool_number', absint( $tool_number ) );
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/9-non-sequential.png"/>

                        <h1>
                            <strong><?php the_title(); ?></strong>
                        </h1>
                        <span class="sub-caption">
                            <a onclick="open_session(<?php echo esc_attr( $session_number ); ?>)"><?php echo esc_html__( 'This concept can be found in session', 'zume' ) ?> <?php echo esc_html( $session_number ) ?></a>
                        </span>
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

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "When people think about disciples multiplying, they often think of it as a step-by-step process. First prayer. Then preparation. Then sharing God’s good news. Then building disciples. Then building churches. Then developing leaders. Then reproduction. When we learn this way, kingdom growth seems to be an easy-to-follow, linear and sequential process.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "One problem is that’s not how it always works.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "A bigger problem is that’s not how it often works best.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "If we want to see the kingdom of God grow rapidly we need to expect and even encourage non-sequential growth.", 'zume' ) ?></p>
                                </div>
                            </div>
                            <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 24 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_24' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '24' ) ) ?>" width="560" height="315"
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
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol>
                                        <li><?php esc_html_e( "Have you ever seen a new believer multiply quickly?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "What things do we do that actually slow or stop this from happening intentionally or unintentionally?", 'zume' ) ?></li>
                                    </ol>
                                </div>
                            </div>
                            <!-- grid-x -->

                        </section><!-- Step -->
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

            </div> <!-- end #inner-content --></div> <!-- end #content -->

        <?php get_template_part( "parts/content", "modal" ); ?>

        <?php
    endwhile;
endif;
get_footer();
