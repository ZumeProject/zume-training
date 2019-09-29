<?php
/*
Template Name: P - Person of Piece
*/


get_header();

if (have_posts()) : while (have_posts()) : the_post();

?>

<!-- Wrappers -->
<div id="content" class="grid-x grid-padding-x"><div class="cell"><div id="inner-content">

    <!-- Title Content -->
    <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="max-width:100%; margin:0; background:white; padding:17px">

        <!-- Side spacer -->
        <div class="medium-2 small-1 cell"></div>

        <!-- Center column -->
        <div class="medium-8 small-10 cell center">

            <!------------------------------------------------------------------------------------------------>
            <!-- Title section -->
            <!------------------------------------------------------------------------------------------------>
            <h1 style="margin-bottom:0px;color: #323a68;">
                <strong><?php the_title(); ?></strong>
            </h1>
            This concept comes from session 5 of  <a href="#">Zume Training</a>.
        </div>

        <!-- Side spacer -->
        <div class="medium-2 small-1 cell"></div>
    </div>

    <!-- Body Content -->
    <div class="grid-x ">

        <!-- Side spacer -->
        <div class="large-2 cell"></div>

        <!-- Center column -->
        <div class="large-8 small-12 cell">

            <!------------------------------------------------------------------------------------------------>
            <!-- Unique page content section -->
            <!------------------------------------------------------------------------------------------------>
            <section id="session-p-2" role="tabpanel" aria-labelledby="session-h-2" class="body current" aria-hidden="false" style="display: block;">

                <!-- Activity Block  -->
                <div class="grid-x grid-margin-x grid-margin-y">

                    <div class="large-12 cell activity-description-no-border">
                        Disciple-making can be rapidly advanced by finding a person of peace, even in a
                        place where followers of Jesus are few and far between. How do you know when you
                        have found a person of peace and what do you when you find them?
                    </div>
                </div> <!-- grid-x -->

                <!-- Video block -->
                <div class="grid-x grid-margin-x grid-margin-y">

                    <div class="small-12 small-centered cell video-section">

                        <!-- 18 -->
                        <div class="widescreen responsive-embed"><iframe style="border: 1px solid lightgrey;" src="https://player.vimeo.com/video/248149796" width="560" height="315" frameborder="1" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="">
                            </iframe></div>


                    </div>
                </div> <!-- grid-x -->


                <!------------------------------------------------------------------------------------------------>
                <!-- Share section -->
                <!------------------------------------------------------------------------------------------------>
                <?php get_template_part( 'parts/p', 'share' ); ?>


                <!------------------------------------------------------------------------------------------------>
                <!-- Transcription section -->
                <!------------------------------------------------------------------------------------------------>
                <hr>
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="large-12 cell activity-description-no-border center">
                        <h3 class="center">Video Transcript</h3>
                    </div>
                    <div class="large-12 cell ">

                            <?php the_content(); ?>

                    </div>
                </div>

        </section>

        </div>

        <!-- Side spacer -->
        <div class="large-2 cell"></div>

    </div>


</div> <!-- end #inner-content --></div> <!-- cell --></div> <!-- content -->

<?php endwhile; endif; ?>
<?php
get_footer();
