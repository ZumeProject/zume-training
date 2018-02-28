<?php
/*
Template Name: Zúme Progress
*/

get_header();

?>

<div id="content" class="grid-x grid-padding-x"><div class="cell">
    <div id="inner-content" class="grid-x grid-margin-x">
        <div class="cell">
            <div class="grid-x grid-margin-y grid-padding-y">
                <div class="cell center">
                    <h2 ><?php esc_html_e( 'Progress', 'zume' ) ?></h2>
                </div>
            </div>

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
                        <?php esc_html_e( 'Focuses on the United States in English. The initial goal is for there to be a training group of four to twelve people in each census tract in the country. Each of these training groups will start two first-generation churches which will then begin to reproduce. There are about 75,000 census tracts so this will mean 150,000 first-generation churches.', 'zume' ) ?>
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
                        <?php esc_html_e( 'The second phase will include coaching these Phase One churches through the reproduction process, as well as delivering the project in other major world languages. The project will start in the following languages: Arabic, Bengali, Bhojpuri, Burmese, Chinese (Mandarin), Chinese (Cantonese), Farsi, French, German, Gujarati, Hausa, Hindi, Indonesian, Italian, Japanese, Kannada, Korean, Maithili, Malayalam, Marathi, Oriya, Panjabi (Eastern), Panjabi (Western), Portuguese, Russian, Spanish, Swahili, Tamil, Telugu, Thai, Turkish, Urdu, Vietnamese, Yoruba.', 'zume' ) ?>
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
                        <?php esc_html_e( 'Focuses globally in major world languages. The framework for targeting the training groups is based on the 4K maps developed by YWAM. It divides the world into segments based on population and the general level of gospel saturation, with less evangelized areas receiving about three times the attention of more evangelized areas. For more information on the framework go to www.4Kworldmap.com. The project will use the next generation of the data, 4K Plus, which will divide the world into about 60,000 Omega Districts. There will be training groups started in each Omega District which will then launch first-generation churches within the districts. In the least evangelized areas this will be a training group for approximately every 50,000 people.', 'zume' ) ?>
                    </p>

                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>
            <br>

            <!-- Goals of the Zume Project -->
            <div class="grid-x">
                <div class="cell vertical-padding" style="background-color:#323A68;">
                    <div class="grid-x grid-margin-x grid-padding-x grid-margin-y">
                        <div class="large-2 cell"></div>
                        <div class="cell large-8" style="color: white;">
                            <h3 class="secondary" style="color: white;"><?php esc_html_e( 'Goals of the Zúme Project:', 'zume' ) ?></h3>
                            <p>
                                <?php esc_html_e( 'Zúme means yeast in Greek. In Matthew 13:33, Jesus is quoted as saying, "The Kingdom of Heaven is like a woman who took yeast and mixed it into a large amount of flour until it was all leavened." This illustrates how ordinary people, using ordinary resources, can have an extraordinary impact for the Kingdom of God. Zúme aims to equip and empower ordinary believers to reach every neighborhood.', 'zume' ) ?>
                            </p>
                            <p>
                                <?php esc_html_e( 'Make disciples in every Omega District globally, using an online training platform focused on equipping participants in the basic disciple-making and simple church planting multiplication principles, processes, and practices.', 'zume' ) ?>
                            </p>
                        </div>
                        <div class="large-2 cell"></div>
                    </div>

                </div>
            </div>


        </div><!-- Cell -->
    </div><!-- Inner Content -->

    </div> <!-- cell -->
</div><!-- Content -->

<?php get_footer(); ?>
