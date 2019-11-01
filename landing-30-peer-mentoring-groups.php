<?php
/*
Template Name: 30 - Peer Mentoring
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 10;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 30;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/zume_images/V5.1/1Waving1Not.svg" width="200px" />

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
                                    <p>Peer Mentoring Groups use leader-to-leader mentoring with individual followers of
                                        Jesus, with simple churches, with ministry organizations or even with a global
                                        simple church network that reaches around the world.</p>

                                    <p>Peer Mentoring Groups follow Jesus’ example of ministry from scripture, ask
                                        questions of one another and give feedback -- all using the same basic time
                                        structure as a 3/3 Group.</p>

                                    <p>The purpose of a Peer Mentoring Group is to provide a simple format for helping
                                        followers of Jesus grow through prayer, obedience, application and
                                        accountability. In other words -- “to love one another.”</p>

                                    <p>Jesus said - “A new command I give you: Love one another. As I have loved you, so
                                        you must love
                                        one another. By this everyone will know that you are my disciples, if you love
                                        one another.”
                                        A Peer Mentoring Group is a group that consists of people who are leading and
                                        starting 3/3
                                        Groups. It also follows a 3/3 format and is a powerful way to assess the
                                        spiritual health of God’s
                                        work in your area.</p>
                                    <p>Peer Mentoring Groups use leader-to-leader mentoring with individual followers of
                                        Jesus, with
                                        simple churches, with ministry organizations or even with a global simple church
                                        network that
                                        reaches around the world.</p>
                                    <p>Peer Mentoring Group participants look at objective indicators following Jesus’
                                        strategy for
                                        ministry and ask questions and give feedback. These sessions are not meant to
                                        inflate anyone’s
                                        ego or make anyone feel inferior. They are meant to instruct and inspire.</p>
                                    <p>Use this simple format:</p>
                                    <p>LOOK BACK [1/3 of your time]</p>
                                    <p>During the first third - spend time in prayer and care just like you would in a
                                        basic 3/3 Group.
                                        Then spend time looking at the group’s vision and faithfulness in previous
                                        commitments:
                                        How well are you abiding in Christ? [Scripture, prayer, trust, obedience, key
                                        relationships?]
                                        Did your group complete your action plans from the last session? Review
                                        them.</p>
                                    <p>LOOK UP [1/3 of your time]</p>
                                    <p>Have the group discuss the following simple questions:</p>
                                    <ol>
                                        <li>1. How are you doing in each section of the Four Fields diagram?</li>
                                        <li>2. What is working well? What are your biggest challenges?</li>
                                        <li>3. Review your current generational map.</li>
                                        <li>4. What challenged you or what did you find hard to understand?</li>
                                        <li>5. What is God showing you recently?</li>
                                        <li>6. Are there any questions from seasoned leaders or other participants?</li>
                                    </ol>
                                    <p>LOOK FORWARD [1/3 of your time]</p>
                                    <p>Spend time in silent prayer with everyone in the group asking the Holy Spirit to
                                        show them how
                                        to answer these questions:</p>
                                    <ol start="7">
                                        <li>7. What action plans or goals would God have me put into practice before our
                                            next
                                            time
                                            together? [Use the Four Fields tool to help focus your work]
                                        </li>
                                        <li>8. How can my Mentor or other Group Members help me in this work?</li>
                                    </ol>

                                    <p>Finally spend time as a group talking to God in prayer.</p>
                                    <p>Have the group pray so that each member is prayed for and ask God to prepare the
                                        hearts of all
                                        those the group will reach out to during their time apart.</p>
                                    <p>Pray for God to give each member of the group the courage and strength to apply
                                        and obey
                                        what God has taught them in this session. If a seasoned leader needs to pray
                                        specifically for a
                                        younger leader, this is the perfect time for that prayer.</p>
                                    <p>Since these groups often meet at a distance, you are unlikely to be able to
                                        celebrate The Lord’s
                                        Supper or share a meal, but be sure to make time to check-in about health and
                                        family and
                                        friends.</p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 30 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_30' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '30' ) ) ?>" width="560" height="315"
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
