<?php
/*
Template Name: 12 - Testimony
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 4;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 12;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/4-testimony.png"  alt="<?php the_title(); ?>" />

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
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 12 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_12' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '12' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "Jesus told His followers - “You are witnesses of these things.”", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Everybody has a story. This is a chance to practice yours.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "As followers of Jesus, we are “witnesses”, too - “testifying” about the impact Jesus has had on our lives. Your story of your relationship with God is called your Testimony. Everybody has a story. Sharing your Testimony is a chance to practice yours.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "There are endless ways to shape your story, but here are some ways that we’ve seen work well:", 'zume' ) ?></p>
                                    <ul>
                                        <li><?php esc_html_e( "A Simple Statement - You can share a simple statement about why you chose to follow Jesus. This works well for a brand new believer.", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Before and After - You can share your “before” and “after” story - what your life was like before you knew Jesus and what your life your life is like now. Simple and powerful.", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "With and Without - You can share your “with” and “without” story - what your life is like “with Jesus” and what it would be like “without Him”. This version of your story works well if you came to faith at a young age.", 'zume' ) ?></li>
                                    </ul>
                                    <p><?php esc_html_e( "When sharing your story, it’s helpful to think of it as part of a three-part process:", 'zume' ) ?></p>
                                    <ul>
                                        <li><?php esc_html_e( "Their Story - Ask the person you are talking with to share about their spiritual journey.", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Your Story - Then share your Testimony shaped around their experience.", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "God’s Story - Finally share God’s story in a way that connects with their world-view, values and priorities.", 'zume' ) ?></li>
                                    </ul>
                                    <p><?php esc_html_e( "Your Testimony doesn’t have to be lengthy or share too many details to be impactful. In fact, keeping your story to around 3-minutes will leave time for questions and deeper conversation. If you’re worried about how to get started - keep it simple. God can use your story to change lives, but remember - you’re the one who gets to tell it.", 'zume' ) ?></p>

                                </div>
                            </div> <!-- grid-x -->



                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol class="rectangle-list">
                                        <li><?php esc_html_e( 'What false fears keep us from sharing our testimony?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'What makes a testimony effective? Where does its power come from?', 'zume' ) ?></li>
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
