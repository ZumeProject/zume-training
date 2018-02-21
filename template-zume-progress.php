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
                    <p>
                        This is a description of Phase 1
                    </p>

                    <div id="group-markers" style="width: 100%; height: 600px;"></div>

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
                    <p>
                        This is a description of Phase 1
                    </p>

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
                    <p>
                        This is a description of Phase 3
                    </p>

                    <div id="group-markers" style="width: 100%; height: 600px;"></div>

                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>


        </div><!-- Cell -->
    </div><!-- Inner Content -->
</div><!-- Content -->

<?php get_footer(); ?>
