<?php
/*
Template Name: Tool - Person of Peace
*/

get_header();

?>

<div id="content">

    <div id="inner-content" class="grid-x grid-padding-x">

        <div class="cell medium-1 hide-for-small-only"></div> <!-- edge padding -->

        <div id="concepts-tools" class="cell auto" role="main">

            <div id="content-section" class="grid-x grid-padding-x">

                <!-- Show at side for larger screens -->
                <div class="cell large-4 show-for-large" style="max-width:300px">
                    <?php get_template_part( 'parts/tools', 'menu' ); ?>
                </div>
                <!-- end menu-->

                <!-- Begin main content -->
                <div class="cell auto">
                    <div class="grid-x grid-padding-y">
                        <!-- Page Content -->

                        <div class="cell center">
                            <img src="https://zume-project.com/wp-content/themes/zume-project-multilingual/assets/images/overview/4.1.png" />
                            <h1>Person of Peace</h1>
                        </div>
                        <div class="cell">
                            A Person of Peace is:
                            <ul>
                                <li>Someone who is OPEN to hearing Your Story, God's Story, and the Good News of Jesus.</li>
                                <li>Someone who is HOSPITABLE and WELCOMES you into their home or their workplace or to join events with family and friends.</li>
                                <li>Someone who KNOWS OTHERS (or is KNOWN BY OTHERS) and who is excited to draw together a small group or even a crowd.</li>
                                <li>Someone who is FAITHFUL and SHARES what they learn with others - even after you're gone.</li>
                            </ul>
                            A Person of Peace can help rapidly reproduce disciple-making even in a place where followers of Jesus are few and far between. When you want to make disciples in a place where not many - or maybe even any - exist, then looking for a Person of Peace might be the most important thing you do.

                        </div>
                        <div class="cell center">
                            <h2>Watch the Concept Video</h2>
                            <!-- 18 -->
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '18' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                        <!-- End Page Content -->

                        <!-- Track Progress Section-->
                        <?php get_template_part( 'parts/tools', 'trackprogress' ); ?>

                        <!-- Challenge to Register-->
                        <?php get_template_part( 'parts/tools', 'register' ); ?>

                    </div>

                </div> <!-- main column-->

                <!-- Show at bottom on smaller screens -->
                <div class="cell large-3 hide-for-large">
                    <br><br>
                    <?php get_template_part( 'parts/tools', 'menu' ); ?>
                </div>
                <!-- end menu-->

            </div><!-- end conent-section-->

        </div> <!-- end #main -->

        <div class="cell medium-1 hide-for-small-only"></div><!-- edge padding -->

    </div> <!-- end #inner-content -->

</div><!-- end #content -->

<?php

get_footer();
