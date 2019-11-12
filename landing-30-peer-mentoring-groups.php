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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/10-peer-mentoring.png" />

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

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e("Peer Mentoring Groups use leader-to-leader mentoring with individual followers of Jesus, with simple churches, with ministry organizations or even with a global simple church network that reaches around the world.", 'zume') ?></p>
                                    <p><?php esc_html_e("Peer Mentoring Groups consists of people who are leading and starting 3/3 Groups. It also follows a 3/3 format and is a powerful way to assess the spiritual health of God’s work in your area.", 'zume') ?></p>
                                    <p><?php esc_html_e("Peer Mentoring Groups follow Jesus’ example of ministry from scripture, ask questions of one another and give feedback -- all using the same basic time structure as a 3/3 Group.", 'zume') ?></p>

                                    <p><?php esc_html_e("Jesus said - “A new command I give you: Love one another. As I have loved you, so you must love one another. By this everyone will know that you are my disciples, if you love one another.”", 'zume') ?></p>
                                    <p><?php esc_html_e("The purpose of a Peer Mentoring Group is to provide a simple format for helping followers of Jesus grow through prayer, obedience, application and accountability. In other words -- “to love one another.”", 'zume') ?></p>
                                </div>
                                <div class="cell content-large">
                                    <p><?php esc_html_e("Use this simple format:", 'zume') ?></p>

                                    <h3><?php esc_html_e("LOOK BACK [1/3 of your time]", 'zume') ?></h3>

                                    <p><?php esc_html_e("During the first third - spend time in prayer and care just like you would in a basic 3/3 Group. Then spend time looking at the group’s vision and faithfulness in previous commitments:", 'zume') ?></p>
                                    <p><?php esc_html_e("How well are you abiding in Christ? [Scripture, prayer, trust, obedience, key relationships?]", 'zume') ?></p>
                                    <p><?php esc_html_e("Did your group complete your action plans from the last session? Review them.", 'zume') ?></p>

                                </div>
                                <div class="cell content-large">

                                    <h3><?php esc_html_e("LOOK UP [1/3 of your time]", 'zume') ?></h3>

                                    <p><?php esc_html_e("Have the group discuss the following simple questions:", 'zume') ?></p>
                                    <ol>
                                        <li><?php esc_html_e("How are you doing in each section of the Four Fields diagram?", 'zume' ) ?></li>
                                        <li><?php esc_html_e("What is working well? What are your biggest challenges?", 'zume' ) ?></li>
                                        <li><?php esc_html_e("Review your current generational map.", 'zume' ) ?></li>
                                        <li><?php esc_html_e("What challenged you or what did you find hard to understand?", 'zume' ) ?></li>
                                        <li><?php esc_html_e("What is God showing you recently?", 'zume' ) ?></li>
                                        <li><?php esc_html_e("Are there any questions from seasoned leaders or other participants?", 'zume' ) ?></li>
                                    </ol>

                                </div>
                                <div class="cell content-large">
                                    <h3><?php esc_html_e("LOOK FORWARD [1/3 of your time]", 'zume') ?></h3>

                                    <p><?php esc_html_e("Spend time in silent prayer with everyone in the group asking the Holy Spirit to show them how to answer these questions:", 'zume') ?></p>
                                    <ol start="7">
                                        <li><?php esc_html_e("What action plans or goals would God have me put into practice before our next time together? [Use the Four Fields tool to help focus your work]", 'zume' ) ?></li>
                                        <li><?php esc_html_e("How can my Mentor or other Group Members help me in this work?", 'zume' ) ?></li>
                                    </ol>
                                    <p><?php esc_html_e("Finally spend time as a group talking to God in prayer.", 'zume') ?></p>

                                    <p><?php esc_html_e("Have the group pray so that each member is prayed for and ask God to prepare the hearts of all those the group will reach out to during their time apart.", 'zume') ?></p>

                                    <p><?php esc_html_e("Pray for God to give each member of the group the courage and strength to apply and obey what God has taught them in this session. If a seasoned leader needs to pray specifically for a younger leader, this is the perfect time for that prayer.", 'zume') ?></p>

                                    <p><?php esc_html_e("Since these groups often meet at a distance, you are unlikely to be able to celebrate The Lord’s Supper or share a meal, but be sure to make time to check-in about health and family and friends.", 'zume') ?></p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ul>
                                        <li><?php esc_html_e( "How is this format for peer mentoring different or similar to other peer mentoring you've experienced either at school or work?", 'zume' ) ?></li>
                                    </ul>
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
