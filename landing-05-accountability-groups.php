<?php
/*
Template Name: 05 - Accountability Groups
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 1;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 5;
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

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p>Jesus shared many stories of accountability and told us many truths of how we
                                        will be held responsible for what we do and say.</p>

                                    <p>Accountability Groups are made up of two or three people of the same gender - men
                                        with men, women with women - who meet once a week to discuss a set of questions
                                        that help reveal areas where things are going right and other areas that need
                                        correction.</p>

                                    <p>Every follower of Jesus will be held accountable, so every follower of Jesus
                                        should practice accountability with others.</p>

                                </div>
                            </div>
                            <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 5 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_5' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '5' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <!-- grid-x -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p>Accountability Groups are made up of two or three people of the same gender - men
                                        with men,
                                        women with women - who meet once a week to discuss a set of questions that help
                                        reveal areas
                                        where things are going right and other areas that need correction. They can even
                                        meet by phone
                                        if they’re unable to meet face-to-face. Everyone in the group needs to
                                        understand that what is
                                        shared is confidential.</p>
                                    <p>Spend the
                                        next 45 minutes working together through the Accountability Questions - List 2,
                                        below. Since
                                        you haven’t done a group reading before this session, just skip over the
                                        questions about previous
                                        readings. List 1 is a great option as you get further into training.</p>

                                    <p>Accountability Questions - List 1</p>
                                    <ul>
                                        <li>Pray that we will become like Jesus.</li>
                                        <li>How are you doing? How is your prayer life?</li>
                                        <li>Do you have any sin to confess? [Relational, Sexual, Financial, Pride,
                                            Integrity,
                                            Submission
                                            to Authority, etc.]
                                        </li>
                                        <li>Did you obey what God told you last time? Share details.</li>
                                        <li>Did you pray for the “Unbelievers” on your relationship list this week? Did
                                            you
                                            have the
                                            chance to share with any of them? Share details.
                                        </li>
                                        <li>Did you memorize a new verse this week? Quote it.</li>
                                        <li>Did you read at least 25 chapters in the Bible this week?</li>
                                        <li>What did God say to you this week from the Word?</li>
                                        <li>What are you going to specifically do about it?</li>
                                        <li>Did you meet with your 3/3 group this week? How did it go?</li>
                                        <li>Did you model or assist someone in starting a new 3/3 group this week? Share
                                            details.
                                        </li>
                                        <li>Do you see anything hindering my walk with Christ?</li>
                                        <li>Did you have the opportunity to share the gospel this week? Share details.
                                        </li>
                                        <li>Practice 1-3 minute testimonies and the gospel right now.</li>
                                        <li>Who can you invite to the group next week? If the group is four or more,
                                            multiply
                                            it.
                                        </li>
                                        <li>Close with prayer regarding what was shared.</li>
                                    </ul>
                                    <p>Accountability Questions - List 2</p>
                                    <ul>
                                        <li>How have your insights from last week’s reading shaped the way you think and
                                            live?
                                        </li>
                                        <li>Who did you pass your insights from last week on to and how was it
                                            received?
                                        </li>
                                        <li>How have you seen God at work?</li>
                                        <li>Have you been a testimony this week to the greatness of Jesus Christ with
                                            both your words and actions?
                                        </li>
                                        <li>Have you been exposed to sexually alluring material or allowed your mind to
                                            entertain inappropriate sexual thoughts?
                                        </li>
                                        <li>Have you acknowledged God’s ownership in your use of money?</li>
                                        <li>Have you coveted anything?</li>
                                        <li>Have you hurt someone’s reputation or feelings by your words?</li>
                                        <li>Have you been dishonest in word or action or exaggerated?</li>
                                        <li>Have you given into an addictive [or lazy or undisciplined] behavior?</li>
                                        <li>Have you been a slave to clothing, friends, work, or possessions?</li>
                                        <li>Have you failed to forgive someone?</li>
                                        <li>What worries or anxieties are you facing? Have you complained or grumbled?
                                        </li>
                                        <li>Have you maintained a thankful heart?</li>
                                        <li>Have you been honoring, understanding and generous in your important
                                            relationships?
                                        </li>
                                        <li>What temptations in thought, word, or action have you faced and how did you
                                            respond?
                                        </li>
                                        <li>How have you taken opportunities to serve or bless others, especially
                                            believers?
                                        </li>
                                        <li>Have you seen specific answers to prayer?</li>
                                        <li>Did you complete the reading for the week?</li>
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
