<?php
/*
Template Name: 17 - Prayer Walking
*/
get_header();
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 5;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 17;
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
                                    <p><?php esc_html_e("Prayer Walking is just what it sounds like - praying to God while walking around.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("Instead of closing our eyes and bowing our heads, we keep our eyes open to the needs we see around us and bow our hearts to ask humbly for God to intervene.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("You can prayer walk in small groups of two or three or you can prayer walk by yourself. As you walk and pray, be alert for opportunities and listen for promptings by God’s Spirit to pray for individuals and groups you meet along the way.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("God’s Word says that we should “petition, pray, intercede and give thanksgiving for all people, for kings and all those in authority -- that we may live peaceful and quiet lives in all godliness and holiness. This is good, and pleases God our Savior, who wants all people to be saved and to come to a knowledge of the truth.”", 'zume' ) ?></p>
                                    <p><?php esc_html_e("Prayer Walking is a simple way to obey God’s command to pray for others. And it’s just what it sounds like - praying to God while walking around.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("Instead of closing our eyes and bowing our heads, we keep our eyes open to the needs we see around us and bow our hearts to ask humbly for God to intervene.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("You can prayer walk in small groups of two or three or you can prayer walk by yourself. If you go in a group - try having everyone pray out loud, a conversation with God about what everyone is seeing and the needs that God brings to their hearts. If you go by yourself - try praying silently when alone and out loud when you pray with someone you meet along the way.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("Here are four ways you can know what to pray for during your Prayer Walk:", 'zume' ) ?></p>
                                    <p><?php esc_html_e("OBSERVATION - What do you see? If you see a child’s toy in a yard, you might be prompted to pray for the neighborhood’s children, for families or for schools in the area.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("RESEARCH - What do you know? If you’ve read up about the neighborhood, you might know something about the people who live there, or if the area suffers from crime or injustice. Pray about these things and ask God to act.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("REVELATION - The Holy Spirit may nudge your heart or bring an idea to mind for a particular need or area of prayer. Listen - and pray!", 'zume' ) ?></p>
                                    <p><?php esc_html_e("SCRIPTURE - You may have read part of God’s Word in preparation for your walk or as you walk, the Holy Spirit may bring a Scripture to mind. Pray about that passage and how it might impact the people in that area.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("Here are five areas of influence that you can focus on during your prayer walk:", 'zume' ) ?></p>
                                    <p><?php esc_html_e("GOVERNMENT - Look for and pray over Government centers such as courthouses, commission buildings or law enforcement offices. Pray for the area’s protection, for justice and for godly wisdom for its leaders.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("BUSINESS AND COMMERCE - Look for and pray over Commercial centers such as financial districts or shopping area. Pray for righteous investments and good stewardship of resources. Pray for economic justice and opportunity and for generous and godly givers who put people before profits.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("EDUCATION - Look for and pray over Educational centers such as schools and administration buildings, vocational training centers, community colleges and universities. Pray for righteous educators to teach God’s truth and protect the minds of their students. Pray that God would intervene in every effort to promote lies or confusion. Pray that these places would send out wise citizens who have a heart to serve and lead.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("COMMUNICATION - Look for and pray over Communication centers such as radio stations, tv stations and newspaper publishers. Pray for God’s Story and the testimony of His followers to be spread throughout the city and around the world. Pray that His message is delivered through His medium to His multitudes and that God’s people everywhere will see God’s work.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("SPIRITUALITY - Look for and pray over Spiritual centers such as church buildings, mosques or temples. Pray that every spiritual seeker would find peace and comfort in Jesus and not be distracted or confused by any false religion.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("ACTIVITY [60-90 min] - Break into groups of two or three and go out into the community to practice Prayer Walking. Choosing a location can be as simple as walking out from your current session or praying and planning a destination. Go as God leads, and plan on spending 60-90 minutes on this activity.", 'zume' ) ?></p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 17 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_17' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '17' ) ) ?>" width="560" height="315"
                                                frameborder="1" webkitallowfullscreen mozallowfullscreen allowfullscreen>
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

            </div> <!-- end #inner-content --></div> <!-- end #content -->

        <?php get_template_part( "parts/content", "modal" ); ?>

        <?php
    endwhile;
endif;
get_footer();
