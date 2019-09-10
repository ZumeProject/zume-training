<?php
/*
Template Name: Tool - Person of Peace
*/

/**
 * Begin page template for Zume Overview
 */
get_header();

?>

    <div id="content">

        <div id="inner-content" class="grid-x grid-padding-x">
            <div class="cell medium-1 hide-for-small-only"></div>

            <div id="concepts-tools" class="cell auto" role="main">

                <div class="grid-x grid-padding-x">

                    <!-- Side Navigation -->
                    <div class="cell large-4 show-for-large" style="max-width:300px">
                    <?php get_template_part( 'parts/tools', 'menu' ); ?>
                    </div>

                    <div class="cell auto">
                        <div class="grid-x grid-padding-y">
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

                            <div class="cell host">
                                <hr>
                                <h2 class="center">You've heard the concept. We challenge you to live it, share it, and train others!</h2><br>
                                <table id="host-table" class="unstriped hover">
                                    <tbody>
                                    <tr>
                                        <td><span class="letter active">H</span></td>
                                        <td><span class="label-big">Heard</span></td>
                                        <td><span class="label-big success">&#10004</span></td>
                                        <td>"Heard" means you have become aware. Most Christians have not heard the idea shared above, but now you have.</td>
                                    </tr>
                                    <tr>
                                        <td><span class="letter">O</span></td>
                                        <td><span class="label-big">Obeyed</span></td>
                                        <td><span class="label-big alert">&#10008</span></td>
                                        <td>"Obeyed" means you have taken personal action. Obeying with tools might look like beginning to use them with others, while obeying with concepts might look like changing thinking or priorities.</td>
                                    </tr>
                                    <tr>
                                        <td><span class="letter">S</span></td>
                                        <td><span class="label-big">Shared</span></td>
                                        <td><span class="label-big alert">&#10008</span></td>
                                        <td>"Shared" means you have shared the tool with someone else. This step is essential to truly understanding the concept or tool and preparing you to train others.</td>
                                    </tr>
                                    <tr>
                                        <td><span class="letter">T</span></td>
                                        <td><span class="label-big">Trained</span></td>
                                        <td><span class="label-big alert">&#10008</span></td>
                                        <td>"Trained" means you have trained someone else to hear, obey, and share the tool or concept with the hope that they would train someone else.</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <h2 class="center"><a href="/login">Login and track your progress!</a></h2>
                            </div>

                            <div class="cell center">
                                <hr>
                                <p class="p-large">Zúme Training is an on-line and in-life learning experience designed for small groups who follow Jesus to learn how to obey His Great Commission and make disciples who multiply.</p>
                                <button class="button-jumbo-action">Register for Free Training</button>
                            </div>
                        </div>

                    </div> <!-- main column-->

                    <div class="cell large-3 hide-for-large">
                        <br><br>
                    <?php get_template_part( 'parts/tools', 'menu' ); ?>
                    </div>

                </div>

            </div> <!-- end #main -->
            <div class="cell medium-1 hide-for-small-only"></div>

        </div> <!-- end #inner-content -->

    </div><!-- end #content -->

<?php

get_footer();
