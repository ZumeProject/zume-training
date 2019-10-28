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
                        <section>

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p>Jesus told His followers - “You are witnesses of these things.”</p>

                                    <p>As followers of Jesus, we are “witnesses”, too - “testifying” about the impact
                                        Jesus has had on on our lives. Your story of your relationship with God is
                                        called your testimony.</p>

                                    <p>Everybody has a story. This is a chance to practice yours.</p>

                                    <p>Jesus told His followers - “You are witnesses of these things.”</p>
                                    <p>As followers of Jesus, we are “witnesses”, too - “testifying” about the impact
                                        Jesus has had on
                                        our lives. Your story of your relationship with God is called your Testimony.
                                        Everybody has a
                                        story. Sharing your Testimony is a chance to practice yours.</p>
                                    <p>There are endless ways to shape your story, but here are some ways that we’ve
                                        seen work well:</p>
                                    <ul>
                                        <li>A Simple Statement - You can share a simple statement about why you chose
                                            to
                                            follow
                                            Jesus. This works well for a brand new believer.
                                        </li>
                                        <li>Before and After - You can share your “before” and “after” story - what
                                            your
                                            life was like
                                            before you knew Jesus and what your life your life is like now. Simple and
                                            powerful.
                                        </li>
                                        <li>With and Without - You can share your “with” and “without” story - what
                                            your
                                            life is like
                                            “with Jesus” and what it would be like “without Him”. This version of your
                                            story
                                            works well
                                            if you came to faith at a young age.
                                        </li>
                                    </ul>
                                    <p>When sharing your story, it’s helpful to think of it as part of a three-part
                                        process:</p>
                                    <ul>
                                        <li>Their Story - Ask the person you are talking with to share about their
                                            spiritual journey.
                                        </li>
                                        <li>Your Story - Then share your Testimony shaped around their experience.
                                        </li>
                                        <li>God’s Story - Finally share God’s story in a way that connects with their
                                            world-view, values and priorities.
                                        </li>
                                    </ul>
                                    <p>Your Testimony doesn’t have to be lengthy or share too many details to be
                                        impactful. In fact,
                                        keeping your story to around 3-minutes will leave time for questions and deeper
                                        conversation.
                                        If you’re worried about how to get started - keep it simple. God can use your
                                        story to change
                                        lives, but remember - you’re the one who gets to tell it.</p>

                                    <p>ACTIVITY [45 min] - Break into groups of two or three and
                                        spend the next 45 minutes
                                        practicing sharing your Testimony. Choose 5 people from your List of 100 that
                                        you marked as an
                                        “Unbeliever” or “Unknown.” Have someone pretend to be each of those five people,
                                        and practice
                                        your Testimony in a way that you think will make sense to that particular
                                        person.
                                        You can use any of the patterns detailed above or some other way you think will
                                        work well for
                                        the one you’re sharing with. After you’ve practiced, switch. Pretend to be
                                        someone else’s five
                                        people from their list. By the time you’re finished, you should be able to tell
                                        your Testimony in
                                        about 3 minutes or less.</p>

                                </div>
                            </div> <!-- grid-x -->

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
                            <div class="large-12 cell content-large center">
                                <h3 class="center"><?php echo esc_html__( 'Video Transcript', 'zume' ) ?></h3>
                            </div>
                            <div class="large-12 cell content-large">

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
