<?php
/*
Template Name: 28 - Coaching Checklist
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 10;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 28;
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
                                    <p><?php esc_html_e( "The Coaching Checklist is a simple tool you can use to help guide you as you assist others through various parts of Zume Training like The Training Cycle or their List of 100.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "What skills are you seeing develop in others? What areas still need to be developed?", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Having a Coaching Checklist will help you stay focused and engaged as you develop followers of Jesus into leaders in God’s family, everywhere you go.", 'zume' ) ?></p>
                                    <?php esc_html_e( "The Coaching Checklist is a powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply. It's also a powerful tool you can use to help others – and others can use to help you.", 'zume' ) ?>
                                    <br><br>
                                    <?php esc_html_e( "Download the Coaching Checklist with the link below and take this quick (5-minutes or less) self-assessment:", 'zume' ) ?>
                                    <div class="cell content-large center">
                                        <img src="<?php echo esc_url( zume_images_uri( '/temp/' ) ) ?>coaching-checklist.jpg" alt="checklist" style="max-width:300px;" />
                                    </div>
                                    <div class="cell content-large center">
                                        <a href="<?php echo esc_url( zume_files_uri() ) ?>84_en_coaching_checklist.pdf" class="button primary-button"><?php esc_html_e( "Download Coaching Checklist", 'zume' ) ?></a>
                                    </div>
                                    <ol>
                                        <li><?php esc_html_e( "Read through the Disciple Training Tools in the far left column of the Checklist.", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Mark each one of the Training Tools, using the following method:", 'zume' ) ?>
                                            <ul>
                                                <li><?php esc_html_e( "If you're unfamiliar or don't understand the Tool – check the BLACK column", 'zume' ) ?></li>
                                                <li><?php esc_html_e( "If you're somewhat familiar but still not sure about the Tool – check the RED column", 'zume' ) ?></li>
                                                <li><?php esc_html_e( "If you understand and can train the basics on the Tool – check the YELLOW column", 'zume' ) ?></li>
                                                <li><?php esc_html_e( "If you feel confident and can effectively train the Tool – check the GREEN column", 'zume' ) ?></li>
                                            </ul>
                                        </li>
                                    </ol>
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

                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol>
                                        <li><?php esc_html_e( "Which Training Tools did you feel you would be able to train well?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Which ones made you feel vulnerable as a trainer?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Are there any Training Tools that you would add or subtract from the Checklist? Why?", 'zume' ) ?></li>
                                    </ol>
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
