<?php
/*
Template Name: 03 - Spiritual Breathing
*/

// translation strings
// title
// focus phrase
// Meta description


get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 1;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 3;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/1-spiritual-breathing.png" alt="<?php the_title(); ?>" />

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

                        <section><!-- Step Title -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "Spiritual breathing is hearing and obeying God ... all day, every day.", 'zume' ) ?></p>
                                </div>
                            </div>
                            <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Watch This Video', 'zume' ) ?></h3>
                                </div>
                                <div class="small-12 small-centered cell video-section">
                                    <!-- 3 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_3' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '3' ) ) ?>" width="560" height="315"
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
                                    <h3><?php esc_html_e("Breathe In", 'zume' ) ?></h3>
                                    <p><?php esc_html_e("In the Kingdom, we breathe in when we hear from God through:", 'zume' ) ?></p>
                                    <ol class="padding-horizontal-2">
                                        <li><?php esc_html_e("HIS WORD - the Bible", 'zume' ) ?></li>
                                        <li><?php esc_html_e("PRAYER - our conversations with him", 'zume' ) ?></li>
                                        <li><?php esc_html_e("HIS BODY - the church, other followers of Jesus", 'zume' ) ?></li>
                                        <li><?php esc_html_e("HIS WORKS - the events, experiences and sometimes even the persecutions and sufferings He allows His children to go through", 'zume' ) ?></li>
                                    </ol>
                                    <p><?php esc_html_e( "The good news for every follower of Jesus is that when we breathe IN and HEAR from God and when we breathe OUT and OBEY what we hear and SHARE with others what we’ve heard - God will speak even more clearly.", 'zume' ) ?></p>

                                    <h3><?php esc_html_e("Breathe Out", 'zume' ) ?></h3>
                                    <p><?php esc_html_e("In the Kingdom we breathe OUT when we ACT on what we hear from God. We breathe OUT when we OBEY.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("Sometimes breathing out to OBEY means changing our thoughts, our words or our actions to bring them into alignment with Jesus and His will. Sometimes breathing out to OBEY means sharing what Jesus has shared with us - giving away what He gave us - so that others can be blessed just as God is blessing us.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("For a follower of Jesus - this breathing IN and breathing OUT is critical. It’s our very life.", 'zume' ) ?></p>
                                </div>
                            </div>
                            <!-- grid-x -->

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol class="rectangle-list">
                                        <li><?php esc_html_e( 'Why is it essential to learn to hear and recognize God\'s voice?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'Is hearing and responding to the Lord really like breathing? Why or why not?', 'zume' ) ?></li>
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
