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
            <img src="https://zumeproject.com/wp-content/themes/zume-project-multilingual/assets/images/overview/4.1.png" />

            <h1>
                <strong><?php the_title(); ?></strong>
            </h1>
            <p>
                This concept comes from Session 5 of the <a href="#">Zume Training Course</a>.
            </p>
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
                        <p>A Person of Peace is:</p>
                        <ul>
                            <li>Someone who is OPEN to hearing Your Story, God's Story, and the Good News of Jesus.</li>
                            <li>Someone who is HOSPITABLE and WELCOMES you into their home or their workplace or to join events with families and friends.</li>
                            <li>Someone who KNOWS OTHERS (or is KNOWN BY OTHERS) and who is excited to draw together a small group or even a crowd.</li>
                            <li>Someone who is FAITHFUL and SHARES what they learn with others - even after you're gone.</li>
                        </ul>
                        <p>
                            A Person of Peace can help rapidly reproduce disciple-making even in a place where followers of Jesus are few and far
                            between. When you want to make disciples in a place where not many - or maybe even any - exist, then looking for a
                            Person of Peace might be the most important thing you do.
                        </p>
                    </div>
                </div> <!-- grid-x -->

                <!-- Video block -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="cell"><h3 class="center">Watch the Concept Video</h3></div>
                    <div class="small-12 small-centered cell video-section">

                        <div class="widescreen responsive-embed">
                            <iframe style="border: 1px solid lightgrey;" src="https://player.vimeo.com/video/248149796" width="560" height="315" frameborder="1" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="">
                            </iframe>
                        </div>
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
                    <div class="large-12 cell activity-description-no-border">

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
