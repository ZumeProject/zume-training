<?php
/*
Template Name: Zume Landing
*/
get_header();
if ( have_posts() ) {  while ( have_posts() ) { ?>

<div id="content" class="grid-x grid-padding-x">
    <div class="cell">
        <div id="inner-content">

            <!-- Challenge -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="max-width:100%; margin:0; background:white; padding:17px">
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell center">
                    <h3 style="margin-bottom:0px">
                        <strong><?php the_title(); ?></strong>
                    </h3>
                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <div class="grid-x ">
                <div class="large-2 cell"></div>

                <div class="large-8 small-12 cell">

                    <?php the_post();
                    the_content(); ?>

                </div>
                <div class="large-2 cell"></div>
            </div>

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

<?php
} // end while
} // end if
get_footer();
?>
