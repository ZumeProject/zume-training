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
                                    <p><?php esc_html_e( "Leadership Cells are 3/3 Groups that only meet for a limited and pre-determined length of time [like this 9-session Zúme Training course]. The purpose is to equip a group of people to go out and establish their own groups or establish another leadership cell at the conclusion of the training period.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "This approach can be used in several circumstances. It can be used with mobile population segments such as nomads, students, etc. It can be used if there numbers of people who are already Christians but for some reason it is not appropriate for them to form an ongoing group and they need to be trained to start their own groups. It can also be used if there is a situation where a number of people come to faith at the same time and there is not sufficient time or opportunity to do initial follow-up with them individually with the Greatest Blessing approach or some similar approach.", 'zume' ) ?></p>
                                </div>
                            </div>
                            <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
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
                                        <li><?php esc_html_e( "What is the most exciting idea you heard in this video? Why?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "What is the most challenging idea? Why?", 'zume' ) ?></li>
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
