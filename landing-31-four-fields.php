<?php
/*
Template Name: 31 - Four Fields
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 10;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 31;
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

                            <!-- content-->
                            <div class="grid-x content-large">
                                <div class="cell center">
                                    <img src="<?php echo esc_url( zume_images_uri( '/zume_images/' ) ) ?>four-fields.png" alt="four-fields" />
                                </div>
                            </div>
                            <!-- content-->
                            <div class="grid-x content-large">
                                <div class="cell">
                                    <p>
                                        <?php esc_html_e("The four fields diagnostic chart is a simple tool to be used by a leadership cell to reflect on the status of current efforts and the kingdom activity around them.", 'zume') ?>
                                    </p>
                                    <p>
                                        <?php esc_html_e("Use the tool in peer mentoring to review activity, people, and groups by categorizing them into the different fields, and asking each other core questions to surface points of action and next steps.", 'zume') ?>
                                    </p>
                                    <div class="inset">
                                        <p>
                                            <strong><?php esc_html_e("Empty Field", 'zume') ?></strong><br>
                                            <?php esc_html_e("Ask the question: Where or with whom [what people groups] are you planning to extend the Kingdom?", 'zume') ?>
                                        </p>
                                        <p>
                                            <strong><?php esc_html_e("Seeding Field", 'zume') ?></strong><br>
                                            <?php esc_html_e("Ask the question: Where or with whom are you sharing the good news of the Kingdom? How are you doing that?", 'zume') ?>
                                        </p>
                                        <p>
                                            <strong><?php esc_html_e("Growing Field", 'zume') ?></strong><br>
                                            <?php esc_html_e("Ask the question: How are you equipping people and growing them spiritually, individually and in their natural networks?", 'zume') ?>
                                        </p>
                                        <p>
                                            <strong><?php esc_html_e("Harvesting Field", 'zume') ?></strong><br>
                                            <?php esc_html_e("Ask the question: How are new spiritual families [simple churches] being formed?", 'zume') ?>
                                        </p>
                                        <p>
                                            <strong><?php esc_html_e("Multiplying Field", 'zume') ?></strong><br>
                                            <?php esc_html_e("Ask the question: With whom, how and when are you filtering for faithful people and equipping them and holding them accountable for reproduction?", 'zume') ?>
                                        </p>
                                    </div>
                                    <p>
                                        <?php esc_html_e("Jesus often pulled the disciples back, away from ministry to quieter places to review how the work was going. This simple tool is to help you and the co-leaders with you to follow this pattern of Jesus and to address all parts of your stewardship.", 'zume') ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Activity Block  -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large center">
                                    <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                                </div>
                                <div class="cell content-large">
                                    <ul>
                                        <li><?php esc_html_e( "Who do you have that shares your passion that you can meet and review these questions with?", 'zume' ) ?></li>
                                    </ul>
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


                <!-- Activity Block  -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="cell content-large center">
                        <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                    </div>
                    <div class="cell content-large">
                        <ul>
                            <li><?php esc_html_e( "?", 'zume' ) ?></li>
                        </ul>
                    </div>
                </div> <!-- grid-x -->

            </div> <!-- end #inner-content --></div> <!-- end #content -->

        <?php get_template_part( "parts/content", "modal" ); ?>

        <?php
    endwhile;
endif;
get_footer();
