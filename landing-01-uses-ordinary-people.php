<?php
/*
Template Name: 01 - God Uses Ordinary People
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 1;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 1;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/1-ordinary-people.png" alt="<?php the_title(); ?>" />

                        <h1>
                            <strong><?php the_title(); ?></strong>
                        </h1>
                        <span class="sub-caption">
                            <a onclick="open_session(<?php echo esc_attr( $session_number ); ?>)">
                                <?php echo esc_html__( 'This concept can be found in session', 'zume' ) ?> <?php echo esc_html( $session_number ) ?>
                            </a>
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

                        <!-- pre-video block -->
                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php echo esc_html__( "Have you ever wondered how the church got started? In the beginning nobody was a professional. Surprised? Good thing God had a plan that didn't require professionals. God uses ordinary people. He did it to start the first movement of the church. And he does it today.", 'zume' ) ?></p>
                                    <p><?php echo esc_html__( "The first church sent ordinary people around the world to tell others about Jesus. It sent ordinary people to stand before governors and generals and rulers and kings. It sent ordinary people to heal the sick, feed the hungry, raise the dead, and teach all of God’s commands to everyone in the world.", 'zume' ) ?></p>
                                    <p><?php echo esc_html__( "The first church sent ordinary people to change the world. And they did.", 'zume' ) ?></p>
                                </div>
                            </div>



                        <!-- video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Watch This Video', 'zume' ) ?></h3>
                                </div>
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 1 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_1' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '1' ) ) ?>" width="560" height="315"
                                                frameborder="1" webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div>


                        <!-- post-video block -->
                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php echo esc_html__( "Our dream is to do what Jesus said -- to help ordinary people around the world use small tools to make a big impact in God’s kingdom!", 'zume' ) ?></p>
                                    <p><?php echo esc_html__( "Jesus’ final instructions to His followers were simple. He said — All authority in heaven and earth has been given to Me. Therefore — Go and Make Disciples of all nations baptizing them in the name of the Father, Son and Holy Spirit, Teaching them to obey all I have commanded, And I will be with you always - even to the end of the age.", 'zume' ) ?></p>
                                    <p><?php echo esc_html__( "Jesus’ command was simple - Make Disciples.", 'zume' ) ?></p>
                                    <p><?php echo esc_html__( "His instructions on how to do that were simple: (1) Make disciples wherever you’re going; (2) Make disciples by baptizing them in the name of the Father, Son and Holy Spirit; (3) Make disciples by teaching them to obey all He commanded.", 'zume' ) ?></p>
                                    <p><?php echo esc_html__( "So what are the steps to make a disciple? (1) We make disciples all the time - wherever we’re going and as we go. (2) When someone decides to follow Jesus - they should be baptized. (3) As they grow - we should teach every disciple how to obey everything that Jesus commanded. Since one of the things He commanded is to make disciples, that means that every disciple who follows Jesus needs to learn how to make disciples too.", 'zume' ) ?></p>
                                </div>
                            </div>




                        <!-- question block -->
                            <!-- Activity Block -->
                            <div class="grid-x grid-margin-x">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell  content-large">
                                    <ul><li><?php esc_html_e( 'If Jesus intended every one of His followers to obey His Great Commission, why do so few actually make disciples?', 'zume' ) ?></li></ul>
                                    <ul><li><?php esc_html_e( 'Is the idea that God uses ordinary people different from what you had learned or assumed was the plan?', 'zume' ) ?></li></ul>
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


        <?php get_template_part( "parts/content", "modal" ); ?>

        <?php
    endwhile;
endif;
get_footer();
