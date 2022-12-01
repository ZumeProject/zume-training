<?php
/*
Template Name: Zúme Progress
*/

get_header();

?>

<div id="content" class="grid-x grid-padding-x"><div class="cell">
    <div id="inner-content" class="grid-x grid-margin-x">
        <div class="cell">


            <!-- Add Map if Available -->
            <?php
            /**
             * Additional Resources section
             */
            if (have_posts()) :
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;

                else :
                    ?>
                    <div class="grid-x grid-margin-y grid-padding-y">
                        <div class="cell center">
                            <h2 ><?php esc_html_e( 'Progress', 'zume' ) ?></h2>
                        </div>
                    </div>
                    <?php
            endif;
                ?>

            <!-- Phase 1 Title -->
            <div class="grid-x grid-margin-x grid-margin-y " >
                <div class="medium-12 small-12 cell center">
                    <h3 class="blue-ribbon secondary">
                        <strong><?php esc_html_e( 'Phase 1', 'zume' ) ?></strong>
                    </h3>
                </div>
            </div>

            <!-- Phase 1 Overiew -->
            <div class="grid-x grid-margin-x " >
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell">
                    <p>
                        <?php esc_html_e( 'The first phase focuses on the United States and English. The initial goal is to catalyze a training group of four to twelve people per every 5,000 people in the country. Each of these training groups will be challenged to start two first-generation churches which should also reproduce. The target for the United States is to start more than 65,000 English-language Zúme groups and 130,000 churches.', 'zume' ) ?>
                    </p>


                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <!-- Phase 2 Title -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" >
                <div class="medium-12 small-12 cell center">
                    <h3 class="blue-ribbon secondary">
                        <strong><?php esc_html_e( 'Phase 2', 'zume' ) ?></strong>
                    </h3>
                </div>
            </div>

            <!-- Phase 2 Overview -->
            <div class="grid-x grid-margin-x " >
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell">
                    <p>
                        <?php esc_html_e( 'The second phase focuses on coaching these Phase 1 churches through the reproduction process, as well as delivering the project in other major world languages. The project will start in the following languages: Ahmaric, Arabic, Bengali, Bhojpuri, Burmese, Chinese (Mandarin), Chinese (Cantonese), Farsi, French, German, Gujarati, Hausa, Hindi, Indonesian, Italian, Japanese, Kannada, Korean, Maithili, Malayalam, Marathi, Oriya, Panjabi (Eastern), Panjabi (Western), Portuguese, Russian, Somali, Spanish, Swahili, Tamil, Telugu, Thai, Turkish, Urdu, Vietnamese, Yoruba.', 'zume' ) ?>
                    </p>

                    <div style="text-align: center">
                        <a href="https://support.chasm.solutions/zumeproject" target="_blank">
                            <img class="center" src="<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/pages/'; ?>zume-translation-infographic.png" alt="" />
                        </a>
                        <h2 style="color:#2cace2; font-weight: bold; text-align: center"><?php esc_html_e( 'YOU can help get Zúme into other languages!', 'zume' ) ?> <br>
                            <a href="https://support.chasm.solutions/zumeproject" target="_blank" ><?php esc_html_e( 'Donate to the translation of Zúme', 'zume' ) ?></a></h2>
                    </div>

                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <!-- Phase 3 Title -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" >
                <div class="medium-12 small-12 cell center">
                    <h3 class="blue-ribbon secondary">
                        <strong><?php esc_html_e( 'Phase 3', 'zume' ) ?></strong>
                    </h3>
                </div>
            </div>

            <!-- Phase 3 Overview -->
            <div class="grid-x grid-margin-x " >
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell">
                    <p>
                        <?php esc_html_e( 'The third phase focuses Phase 1 and Phase 2 churches to mobilize globally with a vision to make disciples in every place, among every people group. Zúme Project exists to saturate the globe with multiplying disciples in our generation. To accelerate our mission, we have developed and will deliver a mapping solution allowing teams to work strategically towards the goal of a Zúme training group and two simple churches among every 50,000 people outside the US.', 'zume' ) ?>
                    </p>

                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>
            <br>

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


        </div><!-- Cell -->
    </div><!-- Inner Content -->

    </div> <!-- cell -->
</div><!-- Content -->

<?php get_footer(); ?>
