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

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "Prayer Walking is just what it sounds like - praying to God while walking around.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Instead of closing our eyes and bowing our heads, we keep our eyes open to the needs we see around us and bow our hearts to ask humbly for God to intervene.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "You can prayer walk in small groups of two or three or you can prayer walk by yourself. As you walk and pray, be alert for opportunities and listen for promptings by God’s Spirit to pray for individuals and groups you meet along the way.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "God’s Word says that we should “petition, pray, intercede and give thanksgiving for all people, for kings and all those in authority -- that we may live peaceful and quiet lives in all godliness and holiness. This is good, and pleases God our Savior, who wants all people to be saved and to come to a knowledge of the truth.”", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Prayer Walking is a simple way to obey God’s command to pray for others. And it’s just what it sounds like - praying to God while walking around.", 'zume' ) ?></p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <h3 class="padding-bottom-1"><?php esc_html_e( "Four sources that can guide your prayer:", 'zume' ) ?></h3>
                                    <div class="padding-horizontal-2 bold-list-numbers">
                                        <ol>
                                            <li><strong><?php esc_html_e( "OBSERVATION", 'zume' ) ?></strong><br><?php esc_html_e( "What do you see? If you see a child’s toy in a yard, you might be prompted to pray for the neighborhood’s children, for families or for schools in the area.", 'zume' ) ?></li>
                                            <li><strong><?php esc_html_e( "RESEARCH", 'zume' ) ?></strong><br><?php esc_html_e( "What do you know? If you’ve read up about the neighborhood, you might know something about the people who live there, or if the area suffers from crime or injustice. Pray about these things and ask God to act.", 'zume' ) ?></li>
                                            <li><strong><?php esc_html_e( "REVELATION", 'zume' ) ?></strong><br><?php esc_html_e( "The Holy Spirit may nudge your heart or bring an idea to mind for a particular need or area of prayer. Listen - and pray!", 'zume' ) ?></li>
                                            <li><strong><?php esc_html_e( "SCRIPTURE", 'zume' ) ?></strong><br><?php esc_html_e( "You may have read part of God’s Word in preparation for your walk or as you walk, the Holy Spirit may bring a Scripture to mind. Pray about that passage and how it might impact the people in that area.", 'zume' ) ?></li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="cell content-large">
                                    <h3 class="padding-bottom-1"><?php esc_html_e( "Five areas of influence on which to focus prayer:", 'zume' ) ?></h3>
                                    <div class="padding-horizontal-2 bold-list-numbers">
                                        <ol>
                                            <li><strong><?php esc_html_e( "GOVERNMENT", 'zume' ) ?></strong><br><?php esc_html_e( "Look for and pray over Government centers such as courthouses, commission buildings or law enforcement offices. Pray for the area’s protection, for justice and for godly wisdom for its leaders.", 'zume' ) ?></li>
                                            <li><strong><?php esc_html_e( "BUSINESS AND COMMERCE", 'zume' ) ?></strong><br><?php esc_html_e( "Look for and pray over Commercial centers such as financial districts or shopping area. Pray for righteous investments and good stewardship of resources. Pray for economic justice and opportunity and for generous and godly givers who put people before profits.", 'zume' ) ?></li>
                                            <li><strong><?php esc_html_e( "EDUCATION", 'zume' ) ?></strong><br><?php esc_html_e( "Look for and pray over Educational centers such as schools and administration buildings, vocational training centers, community colleges and universities. Pray for righteous educators to teach God’s truth and protect the minds of their students. Pray that God would intervene in every effort to promote lies or confusion. Pray that these places would send out wise citizens who have a heart to serve and lead.", 'zume' ) ?></li>
                                            <li><strong><?php esc_html_e( "COMMUNICATION", 'zume' ) ?></strong><br><?php esc_html_e( "Look for and pray over Communication centers such as radio stations, tv stations and newspaper publishers. Pray for God’s Story and the testimony of His followers to be spread throughout the city and around the world. Pray that His message is delivered through His medium to His multitudes and that God’s people everywhere will see God’s work.", 'zume' ) ?></li>
                                            <li><strong><?php esc_html_e( "SPIRITUALITY", 'zume' ) ?></strong><br><?php esc_html_e( "Look for and pray over Spiritual centers such as church buildings, mosques or temples. Pray that every spiritual seeker would find peace and comfort in Jesus and not be distracted or confused by any false religion.", 'zume' ) ?></li>
                                        </ol>
                                    </div>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol class="rectangle-list">
                                        <li><?php esc_html_e( 'What are the normal places in your daily life that you could naturally prayer walk?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'What nearby locations could you prayer walk that are "dark" and could benefit from your prayer?', 'zume' ) ?></li>
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
