<?php
/*
Template Name: 08 - Relational Stewardship List of 100
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 2;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 8;
        set_query_var( 'tool_number', absint( $tool_number ) );

        $args = Zume_V4_Pieces::vars( $tool_number );
        $image_url = $args['image_url'] ?? '';
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

                        <img src="<?php echo esc_url( $image_url ) ?>" alt="<?php the_title(); ?>"  style="height:225px;" />

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

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "God has already given us the relationships we need to “Go and make disciples.”", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "These are our family, friends, neighbors, co-workers and classmates - people we’ve known all our lives, people we’ve just met.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Being faithful with the people God has already put in our lives is a great first step in multiplying disciples. And it can start with the simple step of making a list.", 'zume' ) ?></p>
                                </div>

                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x">
                                <div class="cell center">
                                    <h3><?php esc_html_e("Listen and Read Along", 'zume' ) ?></h3>
                                    <a class="button large text-uppercase"
                                       href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                                       target="_blank" rel="noopener noreferrer nofollow">
                                        <?php esc_html_e( 'Download Guidebook', 'zume' ) ?>
                                    </a>
                                </div>
                                <div class="small-12 small-centered cell video-section">
                                    <!-- 8 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_8' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '8' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div> <!-- grid-x -->

                            <div class="grid-x">
                                <div class="cell">
                                    <div class="grid-x grid-padding-x center">
                                        <div class="cell small-4"><img src="<?php echo esc_url( get_theme_file_uri() ) . '/assets/images/temp/33_en_zume_guidebook 2_Page_08.jpg' ?>" alt="list of 100 page 1" /></div>
                                        <div class="cell small-4"><img src="<?php echo esc_url( get_theme_file_uri() ) . '/assets/images/temp/33_en_zume_guidebook 2_Page_09.jpg' ?>" alt="list of 100 page 2" /></div>
                                        <div class="cell small-4"><img src="<?php echo esc_url( get_theme_file_uri() ) . '/assets/images/temp/33_en_zume_guidebook 2_Page_10.jpg' ?>" alt="list of 100 page 3" /></div>
                                    </div>
                                </div>
                                <div class="cell center">
                                    <a href="<?php echo esc_url( zume_files_uri() . '74_en_list_of_100.pdf' ) ?>" class="button primary large"><?php esc_html_e( "Download List of 100", 'zume' ) ?></a>
                                </div>
                            </div>

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol class="rectangle-list">
                                        <li><?php esc_html_e( 'What names on this list could you share with in the next 24 hours?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'When is a regular time in the week when you can review this list and take steps to spiritually engage your personal network?', 'zume' ) ?></li>
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


            </div> <!-- end #inner-content --></div> <!-- end #content -->

        <?php get_template_part( "parts/content", "modal" ); ?>

        <?php
    endwhile;
endif;
get_footer();
