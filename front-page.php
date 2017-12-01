<?php
/*
Template Name: Full Width Home
*/
//if( is_user_logged_in() ) { wp_redirect('/dashboard'); }
?>
<?php get_header(); ?>

    <div id="content">

        <div id="inner-content">

            <main id="main" role="main">

                <div class="max-width-1024-wrapper">
                    <div class="laptop"><div class="laptop__screen"><div class="laptop__video-wrapper">
                        <iframe
                            class="laptop__iframe"
                            width="640"
                            height="360"
                            frameborder="0"
                            allowfullscreen
                            src="https://www.youtube-nocookie.com/embed/EOdSAdJ6AhI?rel=0&amp;showinfo=0"

                            ></iframe>
                    </div></div></div>
                </div>

                <div class="row">
                    <div class="large-12 columns center">
                        <br><br>
                        <h1 class="front-page-header">
                            Want to start the training?
                        </h1>
                        <h1 class="front-page-header">
                            Get started below:
                        </h1>
                    </div>
                </div>

                <div class="row ">

                    <div class="small-8 medium-3 small-centered columns center vertical-padding">
                        <br>
                        <a href="/register" alt="Register" class="button large center ">GET STARTED</a>
                        <br>
                    </div>

                </div>

                &nbsp;
                <div class="row expanded">
                    <div class="large-12 columns">
                        <hr style="border-color: #323A68;" size="3px" width="100%" />
                    </div>
                </div>

                <div class="row">
                    <div class="small-8 medium-4 columns small-centered center">
                        <br>
                        <h3 style="text-transform: uppercase">It's as easy as 1-2-3</h3>
                    </div>
                </div>
                &nbsp;
                <div class="row padding-bottom">
                    <div class="medium-10 small-centered columns">
                        <div class="row">
                            <div class="medium-4 columns center">
                                <h4 class="center" style="text-transform: uppercase"><span style="font-size:2.4rem;">&#10102</span>  Sign up</h4>
                                <img class="center" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/'; ?>signup.jpg" alt="" width="100" height="100" />

                            </div>
                            <div class="medium-4 columns center">
                                <h4 class="center" style="text-transform: uppercase"><span style="font-size:2.4rem;">&#10103</span> Invite some friends</h4>
                                <img class="center" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/'; ?>invite.jpg" alt="" width="100" height="100" />

                            </div>
                            <div class="medium-4 columns center">
                                <h4 class="center" style="text-transform: uppercase"><span style="font-size:2.4rem;">&#10104</span> Host a training</h4>
                                <img class="center" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/'; ?>training.jpg" alt="" width="100" height="100" />

                            </div>
                        </div>
                    </div>
                </div>


                &nbsp;
                <div class="row expanded" style="background: #323A68;">

                    <div class="small-10 medium-8 small-centered columns">

                        <div style="color: white; text-align: center; padding: 20px;">

                            <h4 class="padding-bottom" style="text-transform: uppercase">What others are saying</h4>

                            <div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
                                <ul class="orbit-container white">
<!--                                    <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>-->
<!--                                    <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>-->

                                    <li class="orbit-slide">
                                        <div>
                                            <h4 class="text-center zume-slider-text"><strong>There is a great harvest readied in North America not being reached by the status quo. Zúme is a biblical wake-up call and tool to empower the everyday believer to begin walking in the Lords will to multiply disciples.</strong></h4>
                                            <h4 class="zume-slider-name" style="text-transform: uppercase">Jake Duke — Indiana</h4>
                                        </div>
                                    </li>
                                    <li class="orbit-slide">
                                        <div>
                                            <h4 class="text-center zume-slider-text"><strong>Do you want to make a difference in your workplace, neighborhood, or circle of friends? The Zúme Project essentially will give you practical rails to run on that follow the example of the Church as seen in the New Testament.</strong></h4>
                                            <h4 class="zume-slider-name" style="text-transform: uppercase">Gavin Duerson — Kentucky</h4>
                                        </div>
                                    </li>
                                    <li class="orbit-slide">
                                        <div>
                                            <h4 class="text-center zume-slider-text"><strong>I am so excited to use this Zúme tool to help in training all the soldiers to make and multiply disciples in our neighborhood. Jesus can make it a neighborhood again.</strong></h4>
                                            <h4 class="zume-slider-name" style="text-transform: uppercase">Chad Rehnberg</h4>
                                        </div>
                                    </li>
                                    <li class="orbit-slide">
                                        <div>
                                            <h4 class="text-center zume-slider-text"><strong>I believe Zúme can be used by the Lord to reach a huge number of people in our society who would never darken the door of a church building.</strong></h4>
                                            <h4 class="zume-slider-name" style="text-transform: uppercase">Curtis Sergeant — Alabama</h4>
                                        </div>
                                    </li>
                                    <li class="orbit-slide">
                                        <div>
                                            <h4 class="text-center zume-slider-text"><strong>This simple and powerful disciple-making tool - for all laborers - has real potential to accelerate and spark healthy multiplication in every community for every nation.</strong></h4>
                                            <h4 class="zume-slider-name" style="text-transform: uppercase">Zach Duke — Indiana</h4>
                                        </div>
                                    </li>
                                    <li class="orbit-slide">
                                        <div>
                                            <h4 class="text-center zume-slider-text"><strong>The potential for ZÚME to catalyze a movement of multiplying disciple-makers is unprecedented in our lifetime.</strong></h4>
                                            <h4 class="zume-slider-name" style="text-transform: uppercase">Forrest Head - Georgia</h4>
                                        </div>

                                    </li>
                                    <li class="orbit-slide">
                                        <div>
                                            <h4 class="text-center zume-slider-text"><strong> In the West, Zúme is at the forefront of reclaiming a foundational biblical witness, the Church that meets from house to house.</strong></h4>
                                            <h4 class="zume-slider-name" style="text-transform: uppercase">Neal Karsten — Michigan</h4>
                                        </div>
                                    </li>

                                </ul>
                                <nav class="orbit-bullets">
                                    <button class="is-active" data-slide="0"><span class="show-for-sr">First slide details.</span><span class="show-for-sr">Current Slide</span></button>
                                    <button data-slide="1"><span class="show-for-sr">Second slide details.</span></button>
                                    <button data-slide="2"><span class="show-for-sr">Third slide details.</span></button>
                                    <button data-slide="3"><span class="show-for-sr">Fourth slide details.</span></button>
                                    <button data-slide="4"><span class="show-for-sr">Fifth slide details.</span></button>
                                    <button data-slide="5"><span class="show-for-sr">Sixth slide details.</span></button>
                                    <button data-slide="6"><span class="show-for-sr">Seventh slide details.</span></button>
                                </nav>
                            </div>
                        </div>

                    </div> <!-- End columns-->


                </div>

                <div class="row ">
                    <div class="small-8 medium-3 small-centered columns center vertical-padding">
                        <br>
                        <a href="/about" class="button large center " style="text-transform: uppercase">Find out more about Zúme</a>
                        <br>
                    </div>
                </div>

            </main> <!-- end #main -->

        </div> <!-- end #inner-content -->

    </div> <!-- end #content -->

<?php get_footer(); ?>
