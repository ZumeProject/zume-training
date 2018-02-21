<?php
/*
Template Name: Zúme Progress
*/

get_header();

?>

<div id="content">
    <div id="inner-content" class="grid-x grid-margin-x">
        <div class="cell">

            <!-- Phase 1 Title -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" >
                <div class="medium-12 small-12 cell center">
                    <h3 class="blue-ribbon">
                        <strong><?php esc_html_e( 'Phase 1', 'zume' ) ?></strong>
                    </h3>
                </div>
            </div>

            <!-- Phase 1 Overiew -->
            <div class="grid-x grid-margin-x " >
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell">
                    <p><?php esc_attr_e('The first phase of the project is will be designed for use in the United States and will be presented in English. We will attempt to get a training group to be equipped in basic disciple-multiplication
skills. Each of these groups will be connected to a mentor/coach early in the process to provide encouragement, support, and accountability.', 'zume') ?></p>



                    <!--<div id="group-markers" style="width: 100%; height: 600px;"></div>-->

                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <!-- Phase 2 Title -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" >
                <div class="medium-12 small-12 cell center">
                    <h3 class="blue-ribbon">
                        <strong><?php esc_html_e( 'Phase 2', 'zume' ) ?></strong>
                    </h3>
                </div>
            </div>

            <!-- Phase 2 Overview -->
            <div class="grid-x grid-margin-x " >
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell">
                    <p><?php esc_attr_e( 'The second phase will be coaching these Phase One churches through the reproduction process and delivering the project in other major world languages in the USA.', 'zume' ) ?></p>

                    <div style="text-align: center">
                        <a href="https://support.chasm.solutions/zumeproject" target="_blank">
                            <img class="center" src="<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/pages/'; ?>zume-translation-infographic.png" alt="" />
                        </a>
                        <h2 style="color:#2cace2; font-weight: bold; text-align: center">YOU can help get Zúme into other languages! <br>
                            Donate to the translation of Zúme <a href="https://support.chasm.solutions/zumeproject" target="_blank" style="color:#8FC741">here</a>.</h2>
                    </div>

                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <!-- Phase 3 Title -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" >
                <div class="medium-12 small-12 cell center">
                    <h3 class="blue-ribbon">
                        <strong><?php esc_html_e( 'Phase 3', 'zume' ) ?></strong>
                    </h3>
                </div>
            </div>

            <!-- Phase 3 Overview -->
            <div class="grid-x grid-margin-x " >
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell">
                    <p><?php esc_attr_e( 'The third phase will be to launch the process globally and in many other languages around the world, and to coach the second-phase multi-lingual churches through the reproduction process.', 'zume' ) ?></p>

                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>
            <br>

            <!-- Goals of the Zume Project -->
            <div class="grid-x">
                <div class="cell vertical-padding" style="background-color:#323A68;">
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-2 cell"></div>
                        <div class="cell large-8" style="color: white;">
                            <h3 style="color: white;"><?php esc_html_e( 'Goals of the Zúme Project:', 'zume' ) ?></h3>
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
</div><!-- Content -->

<?php get_footer(); ?>
