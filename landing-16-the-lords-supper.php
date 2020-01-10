<?php
/*
Template Name: 16 - The Lord's Supper
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 4;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 16;
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

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x">
                                <div class="cell center">
                                    <h3><?php esc_html_e( "Listen and Read Along", 'zume' ) ?></h3>
                                    <a class="button large text-uppercase"
                                       href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                                       target="_blank" rel="noopener noreferrer nofollow">
                                        <?php esc_html_e( 'Download Guidebook', 'zume' ) ?>
                                    </a>
                                </div>
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 16 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_16' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '16' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "Jesus said - “I am the living bread that came down from heaven. Whoever eats this bread will live forever. This bread is my flesh, which I will give for the life of the world.”", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Holy Communion or “The Lord’s Supper” is a way to celebrate our intimate connection and ongoing relationship with Jesus.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Here’s a simple way to celebrate --", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "When you gather as followers of Jesus, spend time in quiet meditation, silently considering and confessing your sins. When you are ready, have someone read this passage from scripture --", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "“For I received from the Lord that which I also delivered to you, that the Lord Jesus in the night in which He was betrayed took bread; and when He had given thanks, He broke it and said, “This is My body, which is for you; do this in remembrance of Me.” 1 Corinthians 11:23-24", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Pass out bread you have set aside for your group, and eat. Continue the reading --", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "“In the same way, He took the cup also after supper, saying, ‘This cup is the new covenant in My blood; do this, as often as you drink it, in remembrance of Me.’” 1 Corinthians 11:25", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Share the juice or wine you have set aside for your group, and drink. Finish the reading --", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "“For as often as you eat this bread and drink the cup, you proclaim the Lord’s death until He comes.” 1 Corinthians 11:26", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Celebrate in prayer or singing. You have shared in The Lord’s Supper. You are His, and He is yours!", 'zume' ) ?></p>
                                </div>
                            </div> <!-- grid-x -->




                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ul class="rectangle-list">
                                        <li><?php esc_html_e( 'What does the bible say is required and not required to take communion?', 'zume' ) ?></li>
                                    </ul>
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
