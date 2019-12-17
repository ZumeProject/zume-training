<?php
/*
Template Name: 21 - 3/3 Group Pattern
*/
get_header();
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 6;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 21;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/6-thirds.png" alt="<?php the_title(); ?>" style="max-height:250px" />

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
                                    <p><?php esc_html_e( "A 3/3 (PRONOUNCE AS “Three-Thirds”) Group is one that divides their time together into 3 parts, so that they can practice obeying some of the most important things that Jesus commands. This is how it works:", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Look Back - The first third of the group’s time is spent looking back at what’s happened since we’ve been together.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Look Up - The middle third of the group’s time is spent Looking Up for God’s wisdom and direction through scripture, discussion and prayer.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Look Forward - The final third of the group’s time is spent Looking Forward to how we can each apply and obey what we’ve learned.", 'zume' ) ?></p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 21 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_21' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '21' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div> <!-- grid-x -->

<hr>
                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <h3>Outline of 3/3 Meeting</h3>
                                    <p><?php esc_html_e( "LOOK BACK [1/3 of your time]", 'zume' ) ?></p>
                                    <div class="padding-horizontal-3">
                                        <p><?php esc_html_e( "Care and Prayer: Take time to have each person share something they are thankful for. Then each person should share something they are struggling with. Have the person to their right pray for them about the items they share. If anyone is struggling with something that requires more attention, stay after to care for that person.", 'zume' ) ?></p>
                                        <p><?php esc_html_e( "Vision: Spend time singing together and tie the lyrics to the themes of loving God, loving others, sharing Jesus with others, starting new groups, and helping others do the same. Alternatively people could share Bible passages that communicate these themes.", 'zume' ) ?></p>
                                        <p><?php esc_html_e( "Check-in: Have each person share how they did regarding the commitments they wrote down from the previous week:", 'zume' ) ?></p>
                                        <div class="padding-horizontal-3">
                                        <ol>
                                            <li><?php esc_html_e( "How have you obeyed what you have learned?", 'zume' ) ?></li>
                                            <li><?php esc_html_e( "Who have you trained in what you have learned?", 'zume' ) ?></li>
                                            <li><?php esc_html_e( "With whom have you shared your story or God’s story?", 'zume' ) ?></li>
                                        </ol>
                                        </div>
                                        <p><?php esc_html_e( "If they forgot to follow through on a commitment or did not have the opportunity to do so, then those commitments from the prior week should be added to this week’s commitments. If someone simply refuses to obey something they clearly heard from God then it should be treated as a church discipline issue.", 'zume' ) ?></p>

                                    </div>
                                    <p><?php esc_html_e( "LOOK UP [1/3 of your time]", 'zume' ) ?></p>
                                    <div class="padding-horizontal-3">
                                        <p><?php esc_html_e( "Pray: Talk with God simply and briefly. Ask God to teach you this passage.", 'zume' ) ?></p>
                                        <p><?php esc_html_e( "Read and Discuss: Read this week’s passage. Discuss the following questions:", 'zume' ) ?></p>
                                        <div class="padding-horizontal-3">
                                        <ol>
                                            <li><?php esc_html_e( "What did you like about this passage?", 'zume' ) ?></li>
                                            <li><?php esc_html_e( "What did you find challenging or hard to understand about this passage?", 'zume' ) ?></li>
                                        </ol>
                                        </div>
                                        <p><?php esc_html_e( "Read this week’s passage again.", 'zume' ) ?></p>
                                        <div class="padding-horizontal-3">
                                        <ol>
                                            <li><?php esc_html_e( "What can we learn about people from this passage?", 'zume' ) ?></li>
                                            <li><?php esc_html_e( "What can we learn about God from this passage?", 'zume' ) ?></li>
                                        </ol>
                                        </div>
                                    </div>
                                    <p><?php esc_html_e( "LOOK FORWARD [1/3 of your time]", 'zume' ) ?></p>
                                    <div class="padding-horizontal-3">
                                    <p><?php esc_html_e( "Obey. Train. Share. : Take at least five minutes in silent prayer. Have everyone in the group pray for the Holy Spirit to show them how to answer these questions, then make commitments. Everyone should write the commitments down so they can pray for people knowledgeably and hold them accountable. They may not hear something related to every question every week. They should note if they share a response which they are not sure they heard from God, but they think may be a good idea since the accountability will be handled at a different level in that case.", 'zume' ) ?></p>
                                        <div class="padding-horizontal-3">
                                        <ol>
                                        <li><?php esc_html_e( "How will I apply and obey this passage?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Who will I train or share with about this passage?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Who does God want me to share my story [testimony] and/or God’s story with this week?", 'zume' ) ?></li>
                                    </ol>
                                        </div>
                                    <p><?php esc_html_e( "Practice: In groups of two or three, practice what you have committed to do in question 5, 6 or 7. For example, role-play a difficult conversation or facing a temptation; practice teaching today’s passage, or practice sharing the Gospel.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Talk With God: In the same groups of two or three, pray for every member individually. Ask God to prepare the hearts of the people who will be hearing about Jesus this week. Ask Him to give you the strength and wisdom to be obedient to your commitments. This is the conclusion of the meeting.", 'zume' ) ?></p>
                                    </div>
                                    </div>
                            </div> <!-- grid-x -->
                            <hr>

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol>
                                        <li>
                                            <?php esc_html_e( "Did you notice any differences between a 3/3 Group and a Bible Study or Small Group you've been a part of (or have heard about) in the past? If so, how would those differences impact the group?", 'zume' ) ?>
                                        </li>
                                        <li>
                                            <?php esc_html_e( "Could a 3/3 Group be considered a Simple Church? Why or why not?", 'zume' ) ?>
                                        </li>
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
