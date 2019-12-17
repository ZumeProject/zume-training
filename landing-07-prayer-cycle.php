<?php
/*
Template Name: 07 - Prayer Cycle
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 2;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 7;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/2-pray-day-night.svg" alt="<?php the_title(); ?>" />

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
                                    <p><?php esc_html_e( "The Prayer Cycle is a simple tool for practicing prayer that you can use by yourself and share with any follower. In just 12 simple steps - 5 minutes each - the Prayer Cycle guides you through twelve ways the Bible teaches us to pray. At the end, you’ll have prayed for an hour.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "The Bible tells us -- “Pray without ceasing.” Not many of us can say we do that. But after this hour of prayer - you’ll be a step closer.", 'zume' ) ?></p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 7 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_7' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '7' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div> <!-- grid-x -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "In just 12 simple steps - 5 minutes each - this Prayer Cycle guides you through twelve ways the Bible teaches us to pray. At the end, you’ll have prayed for an hour.", 'zume' ) ?></p>
                                    <p class="center"><img src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>prayer-cycle-en.png" alt="prayer cycle" style="max-width:600px;" /></p>
                                    <p><strong><?php esc_html_e( "PRAISE", 'zume' ) ?></strong><br><?php esc_html_e( "Start your prayer hour by praising the Lord. Praise Him for things that are on your mind right now. Praise Him for one special thing He has done in your life in the past week. Praise Him for His goodness to your family.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "WAIT", 'zume' ) ?></strong><br><?php esc_html_e( "Spend time waiting on the Lord. Be silent and let Him pull together reflections for you.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "CONFESS", 'zume' ) ?></strong><br><?php esc_html_e( "Ask the Holy Spirit to show you anything in your life that might be displeasing to Him. Ask Him to point out attitudes that are wrong, as well as specific acts for which you have not yet made a prayer of confession. Now confess that to the Lord so that you might be cleansed.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "READ THE WORD", 'zume' ) ?></strong><br><?php esc_html_e( "Spend time reading in the Psalms, in the prophets, and passages on prayer located in the New Testament.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "ASK", 'zume' ) ?></strong><br><?php esc_html_e( "Make requests on behalf of yourself.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "INTERCESSION", 'zume' ) ?></strong><br><?php esc_html_e( "Make requests on behalf of others.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "PRAY THE WORD", 'zume' ) ?></strong><br><?php esc_html_e( "Pray specific passages. Scriptural prayers as well as a number of psalms lend themselves well to this purpose.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "THANK", 'zume' ) ?></strong><br><?php esc_html_e( "Give thanks to the Lord for the things in your life, on behalf of your family, and on behalf of your church.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "SING", 'zume' ) ?></strong><br><?php esc_html_e( "Sing songs of praise or worship or another hymn or spiritual song.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "MEDITATE", 'zume' ) ?></strong><br><?php esc_html_e( "Ask the Lord to speak to you. Have a pen and paper ready to record impressions He gives you.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "LISTEN", 'zume' ) ?></strong><br><?php esc_html_e( "Spend time merging the things you have read, things you have prayed and things you have sung and see how the Lord brings them all together to speak to you.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e( "PRAISE", 'zume' ) ?></strong><br><?php esc_html_e( "Praise the Lord for the time you have had to spend with Him and the impressions He has given you. Praise Him for His glorious attributes.", 'zume' ) ?></p>
                                    <p class="sub-caption"><?php esc_html_e( "From Dick Eastman’s book The Hour that Changes the World © 2002 by Dick Eastman, Chosen Books, Grand Rapids, MI, used by permission.", 'zume' ) ?></p>
                                    <p class="center"><a class="button primary-button-hollow large" href="https://zumeproject.github.io/prayer-cycle/" target="_blank"><?php esc_html_e( "Try the Simple Prayer Cycle Timer App", 'zume' ) ?></a> </p>
                                </div>

                            </div> <!-- grid-x -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ul class="rectangle-list">
                                        <li><?php esc_html_e( 'What must you rearrange or stop doing in order to increase your prayer life?', 'zume' ) ?></li>
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
