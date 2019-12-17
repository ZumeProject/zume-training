<?php
/*
Template Name: 04 - SOAPS
*/
get_header();

$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 1;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 4;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/1-reading.svg" alt="<?php the_title(); ?>" />

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
                                    <p><?php esc_html_e( "As a follower of Jesus, we should be reading Scripture daily. A good guideline is to read through a minimum of 25-30 chapters in the Bible each week. Keeping a daily journal daily using the S.O.A.P.S. Bible Reading format will help you understand, obey and share even more.", 'zume' ) ?></p>

                                    <p><?php esc_html_e( "SOAPS stands for:", 'zume' ) ?></p>

                                    <ul>
                                        <li><?php esc_html_e( "Scripture: Write out one or more verses that are particularly meaningful to you, today.", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Observation: Rewrite those verses or key points in your own words to better understand.", 'zume' ) ?>
                                        </li>
                                        <li><?php esc_html_e( "Application: Think about what it means to obey these commands in your own life.", 'zume' ) ?>
                                        </li>
                                        <li><?php esc_html_e( "Prayer: Write out a prayer telling God what you’ve learned and how you plan to obey.", 'zume' ) ?>
                                        </li>
                                        <li><?php esc_html_e( "Sharing: Ask God who He wants you to share with about what you’ve learned applied.", 'zume' ) ?></li>
                                    </ul>

                                    <p><?php esc_html_e( "It’s a simple way to learn and remember an effective Bible study method that any follower of Jesus can use.", 'zume' ) ?></p>

                                </div>
                            </div>
                            <!-- grid-x -->


                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell center">
                                    <h3><?php esc_html_e("Listen and Read Along", 'zume' ) ?></h3>
                                    <a class="button large text-uppercase"
                                       href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                                       target="_blank" rel="noopener noreferrer nofollow">
                                        <?php esc_html_e( 'Download Guidebook', 'zume' ) ?>
                                    </a>
                                </div>
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 4 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_4' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '4' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>

                            </div>

                            <!-- grid-x -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-y">
                                <div class="cell content-large">


                                    <h3><?php esc_html_e( "Here’s an example of S.O.A.P.S. at work:", 'zume' ) ?></h3>
                                    <p><?php esc_html_e( "S – “For my thoughts are not your thoughts, nor are your ways My ways,” declares the Lord. “For as the heavens are higher than the earth, so are My ways higher than your ways and My thoughts than your thoughts.” Isaiah 55:8-9", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "O – As a human, I’m limited in what I know and what I know how to do. God is not limited in any way. He sees and knows EVERYTHING. He can do ANYTHING.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "A – Since God knows everything and His ways are best, I’ll have much more success in life if I follow Him instead of relying on my own way of doing things.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "P – Lord, I don’t know how to live a good life that pleases You and helps others. My ways lead to mistakes. My thoughts lead to hurt. Please teach me Your ways and Your thoughts, instead. Let your Holy Spirit guide me as I follow You.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "S – I will share these verses and this application with my friend, Steve, who is going through a difficult time and needs direction for important decisions he’s facing.", 'zume' ) ?></p>
                                </div>
                            </div>
                            <!-- grid-x -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol class="rectangle-list">
                                        <li><?php esc_html_e( 'Is sharing important to the depth of my bible study?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'Who are the people in my circles that I can share with right now?', 'zume' ) ?></li>
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
