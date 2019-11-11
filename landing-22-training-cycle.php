<?php
/*
Template Name: 22 - Training Cycle
*/
get_header();
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 7;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 22;
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

                        <img src="<?php echo esc_url( get_theme_file_uri() ) ?>/assets/images/pieces_pages/7-training-cycle.png" />

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
                                    <p><?php esc_html_e( "Have you ever learned how to ride a bicycle? Have you ever helped someone else learn? If so, chances are you already know THE TRAINING CYCLE. It’s as easy as MODEL, ASSIST, WATCH and LEAVE.", 'zume' ) ?></p>

                                </div>
                            </div> <!-- grid-x -->

                            <!-- Video block -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="small-12 small-centered cell video-section">

                                    <!-- 22 -->
                                    <?php if ( $alt_video ) : ?>
                                        <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                            <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_22' ) ) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php else : ?>
                                        <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '22' ) ) ?>" width="560" height="315"
                                                frameborder="1"
                                                webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                        </iframe>
                                    <?php endif; ?>

                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><h3><?php esc_html_e( "The Training Cycle works like this:", 'zume' ) ?></h3></p>
                                    <img src="<?php echo esc_url( zume_images_uri( 'temp/' ) ) ?>training-cycle.png" alt="Training Cycle" />
                                    <p><strong><?php esc_html_e("MODEL", 'zume') ?></strong><br><?php esc_html_e( "Modeling is simply providing an example of a practice or tool. It is the briefest part of the training cycle. It usually only needs to be done once. It is simply creating an awareness that a practice or a tool exists and giving a general idea of what it looks like. Modeling repeatedly is not an effective way to equip someone. They need to be allowed to try the skill themselves. When a child sees someone riding a bicycle, that is the MODEL phase.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e("ASSIST", 'zume') ?></strong><br><?php esc_html_e( "Assisting is allowing the learner to practice the skill. This takes longer than the modeling phase. It requires “hand-holding” on the part of the mentor. The mentor needs to be directive and take an active role in coaching the learner. This phase does not last until the learner is fully competent, but merely until they understand the basics of the skill. If this phase is continued too long, then the learner will develop a dependence on the mentor and never advance to full competence. The end of the assist phase should be marked by the learner starting to model for others. When a parent is holding onto the bicycle while a child is learning to keep his balance, that is the ASSIST phase.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e("WATCH", 'zume') ?></strong><br><?php esc_html_e( "Watching is the longest phase. It involves more indirect contact with the learner. It seeks to develop full competence in all facets of a skill. It may be ten times or more as long as the first two phases combined. As the learner progresses in skill, the contact with the mentor may become less regular and more ad hoc . In this phase the learner gradually takes more responsibility and initiative in the performance of the skill. Typically in disciplemaking the mark of the end of this phase is when the learner has passed on the skill successfully to the fourth generation through those whom he or she is coaching. When a parent is observing a child ride a bicycle and ensuring they have adequate skills and knowledge to ride unsupervised, this is the WATCH phase.", 'zume' ) ?></p>
                                    <p><strong><?php esc_html_e("LEAVE", 'zume') ?></strong><br><?php esc_html_e( "Leaving is a sort of graduation when the learner becomes a peer of the mentor. Periodic contact and peer mentoring may continue to take place if the learner and mentor are in the same network. When a parent releases a child to ride their bicycle completely unsupervised, that is the LEAVE phase.", 'zume' ) ?></p>
                                </div>
                            </div> <!-- grid-x -->

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ol>
                                        <li><?php esc_html_e( "Have you ever been a part of a Training Cycle?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Who did you train? Or who trained you?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Could the same person be at different parts of the Training Cycle while learning different skills?", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "What would it look like to train someone like that?", 'zume' ) ?></li>
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
