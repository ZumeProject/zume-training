<?php
/*
Template Name: 19 - Bless  Prayer
*/
get_header();
$alt_video = false;
if (have_posts()) :
    while (have_posts()) : the_post();
        $session_number = 5;
        set_query_var( 'session_number', absint( $session_number ) );
        $tool_number = 19;
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
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell content-large">
                                    <p><?php esc_html_e("Here are five ways you can pray for people you meet during your Prayer Walk:", 'zume' ) ?></p>
                                    <p><?php esc_html_e("As you walk and pray, be alert for opportunities and listen for promptings by God’s Spirit to pray for individuals and groups you meet along the way.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("You can say, “We’re praying for this community, is there anything in particular we can pray for you about?” Or say, “I’m praying for this area. Do you know anything in particular we should pray for?” After listening to their response you can ask about their own needs. If they share, pray for them right away. If the Lord leads, you may pray about other needs as well.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("Use the word B.L.E.S.S. to help you remember 5 different ways you can pray:", 'zume' ) ?></p>
                                    <ul>
                                        <li><?php esc_html_e("Body [health]", 'zume' ) ?></li>
                                        <li><?php esc_html_e("Labor [job and finances]", 'zume' ) ?></li>
                                        <li><?php esc_html_e("Emotional [morale]", 'zume' ) ?></li>
                                        <li><?php esc_html_e("Social [relationships]", 'zume' ) ?></li>
                                        <li><?php esc_html_e("Spiritual [knowing and loving God more]", 'zume' ) ?></li>
                                    </ul>
                                    <p><?php esc_html_e("In most cases, people are grateful you care enough to pray.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("If the person is not a Christian, your prayer may open the door to a spiritual conversation and an opportunity to share your story and God’s story. You can invite them to be a part of a Bible study or even host one in their home.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("If the person is a Christian you can invite them to join your Prayer Walk or train them how they can Prayer Walk and use simple steps like praying for areas of influence or the B.L.E.S.S. Prayer to grow God’s family even more.", 'zume' ) ?></p>
                                    <p><?php esc_html_e("ACTIVITY [15 min] - Break into groups of two or three and spend the next 15 minutes practicing the B.L.E.S.S. Prayer. Practice praying the 5 areas of the B.L.E.S.S. Prayer for someone AND practice how you would train others to understand and use the B.L.E.S.S. Prayer, too.", 'zume' ) ?></p>
                                </div>
                            </div>
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
