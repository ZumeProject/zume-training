<?php
/*
Template Name: 11 - Baptism
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 3;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 11;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/3-baptism.svg"/>

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

                                    <!-- 11 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_11' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '11' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e( "Baptism is a picture of our new life, soaked in the image of Jesus, transformed in obedience to God. It is a picture of our death to sin, just as Jesus died for our sins; a burial of our old way of life, just as Jesus was buried; a rebirth to a new life in Christ, just as Jesus was resurrected and lives today.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Jesus said -- “go and make disciples of all nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit...”", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "Baptism - or Baptizo in the original Greek language - means a drenching or submerging - like when you dye a cloth and it soaks in the color and comes out transformed. Baptism is a picture of our new life, soaked in the image of Jesus, transformed in obedience to God. It is a picture of our death to sin, just as Jesus died for our sins; a burial of our old way of life, just as Jesus was buried; a rebirth to a new life in Christ, just as Jesus was resurrected and lives today.", 'zume' ) ?></p>
                                    <p><?php esc_html_e( "If you have never baptized someone before, it may seem intimidating, but it shouldn’t be. Here are some simple steps:", 'zume' ) ?></p>
                                    <div class="inset">
                                        <ol>
                                            <li><?php esc_html_e( "Find some standing water, deep enough to allow the new disciple to be submerged. This can be a pond, river, lake or ocean. It could be a bathtub or another way to gather water.", 'zume' ) ?></li>
                                            <li><?php esc_html_e( "Let the disciple hold one of your hands with theirs and support their back with the other.", 'zume' ) ?></li>
                                            <li><?php esc_html_e( "Ask two questions like these to make sure they understand their decision. “Have you received Jesus Christ as your Lord and Savior?” “Will you obey and serve Him as your King for the rest of your life?”", 'zume' ) ?></li>
                                            <li><?php esc_html_e( "If they answer “Yes,” to both, then say something like this: “Because you’ve professed your faith in the Lord Jesus, I now baptize you in the name of the Father, Son, and Holy Spirit.”", 'zume' ) ?></li>
                                            <li><?php esc_html_e( "Help them lower into the water, submerge completely and raise them back up. Congratulations! You’ve baptized a new follower of Jesus - a new citizen of heaven - a new child of the Living God. It’s time to celebrate!", 'zume' ) ?></li>
                                        </ol>
                                    </div>
                                </div>
                            </div> <!-- grid-x -->



                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol>
                                        <li><?php esc_html_e( 'Have you ever baptized someone?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'Would you even consider it?', 'zume' ) ?></li>
                                        <li><?php esc_html_e( 'If the Great Commission is for every follower of Jesus, does that mean every follower is allowed to baptize others? Why or why not?', 'zume' ) ?>
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
