<?php
/*
Template Name: 02 - Obedience Focused Disciple Making
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 1;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 2;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/1-follow-jesus-point.svg" alt="<?php the_title(); ?>" />

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

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "It's important to have a simple definition of disciple and church, in order to know who we are supposed to be in Christ and who we should expect to be with in Christ.", 'zume' ) ?></p>
                                    <h3><?php esc_html_e( 'What is a disciple?', 'zume' ) ?></h3>
                                    <p><?php esc_html_e( "The meaning of the word disciple is a follower. So a disciple is a follower of God. Jesus said - All authority in heaven and earth has been given to Me. So in God’s kingdom, Jesus is our King. We are His citizens, subjects of His will. His desires, purposes, intentions, priorities and values are the highest and best. His Word is the law. So what is the law of the kingdom? What does Jesus tell His citizens to do?", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Jesus said that God’s commands from the Old Testament, i.e. all the law and the prophets, can be summarized in these two things: Love God and Love People.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Jesus also said, make disciples and teach them to obey all that I’ve commanded. So then, since making disciples includes teaching them all that Jesus commanded, the New Testament can be summarized in this one thing: Make Disciples.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("A disciple is a follower of Jesus who loves God, loves people and makes disciples.", 'zume' ) ?></p>
                                </div>
                            </div>

                            <div class="grid-x grid-margin-x">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Watch This Video', 'zume' ) ?></h3>
                                </div>
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 2 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_2' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '2' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div>

                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <h3><?php esc_html_e( "What is a church?", 'zume' ) ?></h3>
                                    <p><?php esc_html_e( "You may be used to thinking of the church as a building - a place where you go. But God’s Word talks about the church as a gathering - a people you belong to.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "The word “church” is used in the Bible three different ways:", 'zume' ) ?></p>
                                    <ul class="padding-horizontal-2">
                                        <li><?php esc_html_e("the universal church -- all the people who were, are and will ever be followers of Jesus", 'zume' ) ?></li>
                                        <li><?php esc_html_e("the city or regional church -- all the people who follow Jesus and live in or around a certain area of the world", 'zume' ) ?></li>
                                        <li><?php esc_html_e("the church at home -- all the people who follow Jesus and meet where one or more of them live", 'zume' ) ?></li>
                                    </ul>
                                    <p><?php esc_html_e( "A spiritual family - followers of Jesus who Love God, Love People and Make Disciples and who meet together locally make up this last kind of church - the church at home or the simple church. Simple churches are spiritual families with Jesus as their center and their King. Simple churches are spiritual families who Love God, Love Others and Make Disciples who Multiply.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "When groups of these simple churches connect to do something bigger, together, they can form a city or regional church. All of those simple churches networked into regions and stretched across history make up the universal church.", 'zume' ) ?></p>
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
                                        <li><?php esc_html_e( 'When you think of a church, what comes to mind?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( "What's the difference between that picture and what's described in the video as a 'Simple Church'?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'Which one do you think would be easier to multiply and why?', 'zume' ) ?></li>
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
