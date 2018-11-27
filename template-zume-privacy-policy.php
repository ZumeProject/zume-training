<?php
/*
Template Name: Zume Privacy Policy
*/
?>

<?php get_header(); ?>

<div id="content" class="grid-x grid-padding-x">

    <div class="cell">

        <div id="inner-content">

            <div class="grid-x grid-margin-y">
                <div class="large-2 cell"></div>

                <div class="large-8 small-12 cell">

                    <div class="grid-x grid-margin-y grid-padding-y">
                        <div class="cell center">
                            <h2><?php esc_html_e( 'Zúme Privacy Policy', 'zume' ) ?></h2>
                        </div>
                    </div>

                    <!-- faq stack of questions-->
                    <div class="grid-x grid-margin-x grid-padding-y">

                        <!-- Item -->
                        <div class="cell">
                            <hr>
                            <?php esc_html_e( 'This privacy policy has been compiled to better serve those who are concerned with how their \'Personally Identifiable Information\' (PII) is being used online. PII, as described in US privacy law and information security, is information that can be used on its own or with other information to identify, contact, or locate a single person, or to identify an individual in context. Please read our privacy policy carefully to get a clear understanding of how we collect, use, protect or otherwise handle your Personally Identifiable Information in accordance with our website.', 'zume' ) ?>
                        </div>

                        <!-- Item -->
                        <div class="cell">
                            <hr>
                            <h3 class="secondary"><?php esc_html_e( 'What permissions do the social sign-on logins ask for?', 'zume' ) ?></h3>
                            <ul>
                                <li>
                                    <?php esc_html_e( 'Public Profile. This includes certain User’s Data such as id, name, picture, gender, and their locale.', 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( 'Email Address.', 'zume' ) ?>
                                </li>
                            </ul>
                        </div>

                        <!-- Item -->
                        <div class="cell">
                            <hr>
                            <h3 class="secondary"><?php esc_html_e( 'What permissions do the social sign-on logins ask for?', 'zume' ) ?></h3>
                            <ul>
                                <li>
                                    <?php esc_html_e( 'Information in the Basic Social Profile (if used) and email.', 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( 'Session and course activity.', 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( 'General location telemetry, so we know in what countries our training is being used.', 'zume' ) ?>
                                </li>
                            </ul>
                        </div>

                        <!-- Item -->
                        <div class="cell">
                            <hr>
                            <h3 class="secondary"><?php esc_html_e( 'When do we collect information?', 'zume' ) ?></h3>
                            <ul>
                                <li>
                                    <?php esc_html_e( 'We collect your information at login.', 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( 'We also track your progress through the training course.', 'zume' ) ?>
                                </li>
                            </ul>
                        </div>

                        <!-- Item -->
                        <div class="cell">
                            <hr>
                            <h3 class="secondary"><?php esc_html_e( 'How do we use your information?', 'zume' ) ?></h3>
                            <ul>
                                <li>
                                    <?php esc_html_e( 'We use your information to create a user account in the zume system based on your email address.', 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( 'We will email you with basic transactional emails like password reset requests and other system notifications.', 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( 'We email occasional reminders and encouragements depending on your progress through the training.', 'zume' ) ?>
                                </li>
                            </ul>
                        </div>


                        <?php
                        /**
                         * Additional Privacy Policy section
                         */
                        if (have_posts()) :
                            while (have_posts()) :
                                the_post();
                                the_content();
                            endwhile;
                        endif;
                        ?>

                    </div> <!-- end faq stack of questions-->

                </div>
                <div class="large-2 cell"></div>
            </div>

            <br><br>
            <!-- Goals of the Zume Project -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="background-color:#323A68;">
                <div class="large-2 cell"></div>
                <div class="cell large-8" style="color: white;">
                    <h3 class="secondary" style="color: white;"><?php esc_html_e( 'Goals of the Zúme Project:', 'zume' ) ?></h3>
                    <p>
                        <?php esc_html_e( 'Zúme means yeast in Greek. In Matthew 13:33, Jesus is quoted as saying, "The Kingdom of Heaven is like a woman who took yeast and mixed it into a large amount of flour until it was all leavened." This illustrates how ordinary people, using ordinary resources, can have an extraordinary impact for the Kingdom of God. Zúme aims to equip and empower ordinary believers to saturate the globe with multiplying disciples in our generation.', 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'Zúme uses an online training platform to equip participants in basic disciple-making and simple church planting multiplication principles, processes, and practices.', 'zume' ) ?>
                    </p>
                </div>
                <div class="large-2 cell"></div>
            </div>

        </div> <!-- end #inner-content -->

    </div> <!-- cell -->

</div> <!-- content -->

<?php get_footer(); ?>
