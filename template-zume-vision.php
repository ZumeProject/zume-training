<?php
/*
Template Name: Zúme Vision
*/
$zendesk_enable = true;
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

                <div class="grid-x deep-blue-section">
                    <div class="cell center">
                        <h2>Our Core Strategy</h2>
                        <h3>Holiness, Prayer, Training Saturation, Church Saturation</h3>
                    </div>
                </div>
                <div class="grid-x blue-notch-wrapper"><div class="cell center blue-notch"></div></div>
                <!-- White Section-->
                <div class="grid-x white-section">
                    <div class="cell center">
                        <h2>Holiness, Obedience, and Love</h2>
                        <h3>We need to be disciples worth multiplying.</h3>
                        <img src="<?php echo esc_url(zume_images_uri( 'zume_images') ) ?>V1.1/V1.1-C/Ruler.svg" alt="Jesus Measurement" />
                        <div class="grid-x">
                            <div class="cell medium-3"></div>
                            <div class="cell medium-6">
                                <p>Jesus is our measurement.</p>
                                <p>Not you. Not me. Not history. Not ideals. Not rituals. Jesus and
                                    Jesus alone.</p>
                                <p>How he lived. What he said. How he loved. Everything. In this, we aspire to be marked by immediate, radical, costly obedience to Jesus, like the heroes of the faith that came before us.</p>
                                <p>Jesus is both the measurement and His Spirit is our hope to become like Him. And the day we see
                                    kingdom fruit surrounding our lives and the loves of our friends, it will be because his Spirit has
                                    moved through us.</p>
                            </div>
                            <div class="cell medium-3"></div>
                        </div>
                    </div>

                </div>
                <div class="grid-x blue-notch-wrapper"><div class="cell center white-notch"></div></div><!-- White Notch-->
                <!-- End White Section-->


                <!-- Deep Blue Ribbon-->
                <div class="grid-x deep-blue-section">
                    <div class="cell center">
                    </div>
                </div>
                <div class="grid-x blue-notch-wrapper"><div class="cell center blue-notch"></div></div>

                <!-- White Section-->
                <div class="grid-x white-section">
                    <div class="cell center">
                        <h2>Extraordinary Prayer</h2>
                        <h3>Extraordinary prayer has proceeded every <a href="/articles/what-is-a-disciple-making-movement" class="underline">disciple making movement</a> in history.</h3>
                        <img src="<?php echo esc_url(zume_images_uri( 'zume_images') ) ?>V1.2/V1.2-A/worshiping.svg" alt="Extraordinary Prayer" />

                        <div class="grid-x padding-bottom-1">
                            <div class="cell medium-3"></div>
                            <div class="cell medium-6">
                                <p>You have not because you ask not (James 4:2). If we want to see movement, we need to ask for it.</p>
                            </div>
                            <div class="cell medium-3"></div>
                        </div>

                        <?php get_template_part('parts/content', 'joinus'); ?>

                    </div>
                </div>
                <!-- End White Section-->

                <!-- Deep Blue Ribbon-->
                <div class="grid-x deep-blue-section">
                    <div class="cell center">
                    </div>
                </div>
                <div class="grid-x blue-notch-wrapper"><div class="cell center blue-notch"></div></div>

                <!-- White Section-->
                <div class="grid-x white-section">
                    <div class="cell center">
                        <h2>Training Saturation</h2>
                        <h3>(1 Training &#xF7; Population)</h3>

                        <div class="padding-vertical-2">
                            <h3 style="color: black;">1 Training</h3>
                            <img src="<?php echo esc_url(zume_images_uri( 'vision') ) ?>training-division-illustration.svg" style="max-width:800px;" alt="Training Saturation" /><br>
                            <h3 style="color: black;">Every 5,000 People (North America)<br>
                                Every 50,000 People (Globally)</h3>
                        </div>

                        <div class="grid-x padding-bottom-2">
                            <div class="cell medium-3"></div>
                            <div class="cell medium-6">
                                <p>Disciple multiplication ideas are scriptural, but often missed. A simple training in multiplication principles can unlock even established believers from unfruitful lives.</p>
                                <p>Live trainings are often best. But the people who need trained, so vastly extends beyond the live trainings available.
                                    <a href="/training">Zume.Training</a> is an online, in-life, on-demand training for groups to get paradigm-shifting multiplication training.</p>
                                <p>We suspect, especially in places where the church has been, we will need a training movement before we see a disciple making movement.</p>
                            </div>
                            <div class="cell medium-3"></div>
                        </div>

                        <a class="button primary-button-hollow large" href="/training">View Training</a>
                    </div>

                </div>
                <!-- End White Section-->


                <!-- Deep Blue Ribbon-->
                <div class="grid-x deep-blue-section">
                    <div class="cell center"></div>
                </div>
                <div class="grid-x blue-notch-wrapper"><div class="cell center blue-notch"></div></div>

                <!-- White Section-->
                <div class="grid-x white-section">

                    <div class="cell center">
                        <h2>Simple Church Saturation</h2>
                        <h3>(2 Simple Churches &#xF7; Population)</h3>

                        <div class="padding-vertical-2">
                            <h3 style="color: black;">2 Simple Churches</h3>
                            <img src="<?php echo esc_url(zume_images_uri( 'vision') ) ?>two-churches-illustration.svg" style="max-width:800px;" alt="Church Saturation" /><br>
                            <h3 style="color: black;">Every 5,000 People (North America)<br>
                                Every 50,000 People (Globally)</h3>
                        </div>

                        <div class="grid-x padding-bottom-2">
                            <div class="cell medium-3"></div>
                            <div class="cell medium-6">
                                <p>Many churches in one place is a blessing, but many churches in many places is a greater blessing. And churches moving into places where there has never been a church one of the greatest blessings.</p>
                                <p>As the saying goes, "Plan your trust, don't trust your plan". We know it is the Father's heart to have families of believers in every tongue, tribe, and nation. He has also invited us to be his co-workers in reconciliation. So these goals of 1 training and 2 churches come from our trust in the one who can do it.,</p>

                            </div>
                            <div class="cell medium-3"></div>
                        </div>

                        <a class="button primary-button-hollow large" href="/progress">View Progress</a>
                        <a class="button primary-button-hollow large" href="/maps">View Maps</a>
                        <a class="button primary-button-hollow large" href="/reports">View Reports</a>

                        <?php get_template_part('parts/content', 'joinus'); ?>

                    </div>
                </div>
                <div class="grid-x white-notch-wrapper"><div class="cell center white-notch"></div></div><!-- White Notch-->
                <!-- End White Section-->


            </div><!-- Cell -->
        </div><!-- Inner Content -->

    </div> <!-- cell -->
</div><!-- Content -->

<?php get_footer(); ?>





