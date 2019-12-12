<?php
/*
Template Name: 32 - Generational Map
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 10;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 32;
        set_query_var( 'tool_number', absint( $tool_number ) );
        ?>

        <!-- Wrappers -->
        <div id="content" class="grid-x grid-padding-x training"><div id="inner-content" class="cell">

                <!------------------------------------------------------------------------------------------------>
                <!-- Title section -->
                <!------------------------------------------------------------------------------------------------>
                <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                    <div class="medium-2 small-1 cell"></div><!-- Side spacer -->

                    <!-- Center column -->
                    <div class="medium-8 small-10 cell center">

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

                        <div class="grid-x grid-padding-y content-large">
                            <div class="cell">
                                <p><?php esc_html_e( "Generation mapping is another simple tool to help leaders in a movement understand the growth around them. It helps show fruitful churches, which therefore deserve continued investment and attention. It helps show where there are stops in multiplication and training might be required.", 'zume' ) ?></p>
                                <p><?php esc_html_e( "Heath of the movement is a top concern for leaders. Fruitfulness is a top way to measure health.", 'zume' ) ?></p>
                                <p><?php esc_html_e( "A generation tree map can be drawn on a piece of paper or multiple pieces of paper.", 'zume' ) ?></p>
                            </div>
                            <div class="cell center">
                                <p class="sub-caption"><?php esc_html_e( "Example of generation tree map", 'zume' ) ?></p>
                                <img src="<?php echo esc_url( zume_images_uri( '/zume_images/' ) ) ?>generation-map-tree.svg" alt="generation mapping" style="max-width:600px;" />
                            </div>
                            <div class="cell">
                                <p><?php esc_html_e( "Key information about the maturity of a group can be recorded with five simple fields (drawn similar to the four fields pattern):", 'zume' ) ?></p>
                                <div class="inset">
                                    <ul>
                                        <li><?php esc_html_e( "Number of seekers in group", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Number of baptized believers in group", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Number in accountability relationships", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Functioning as a church (Y/N)", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Number who have started another group", 'zume' ) ?></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="cell center">
                                <p class="sub-caption"><?php esc_html_e( "Snapshot of group maturity", 'zume' ) ?></p>
                                <img src="<?php echo esc_url( zume_images_uri( '/zume_images/' ) ) ?>generation-map-fields.svg" alt="generation mapping" style="max-width:600px;" />
                            </div>
                        </div>

                        <!-- Activity Block  -->
                        <div class="grid-x grid-margin-x">
                            <div class="cell content-large center">
                                <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                            </div>
                            <div class="cell content-large">
                                <ul>
                                    <li><?php esc_html_e( "If you can't draw a generation map now, do you believe God through you could one day?", 'zume' ) ?></li>
                                </ul>
                            </div>
                        </div> <!-- grid-x -->

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
