<?php
/*
Template Name: Full Width Home
*/

$zume_current_lang = zume_current_language();
if ( is_user_logged_in() ) {
    wp_redirect( '/' . $zume_current_lang . '/dashboard' );
}
?>
<?php get_header(); ?>

<div id="content" >

    <div id="inner-content grid-x grid-padding-x">

        <div id="main" class="cell" role="main">

            <!----------------------------------->
            <!-- VIDEO RIBBON -->
            <!----------------------------------->
            <div style="background: linear-gradient(#2CA2E2, #21336A)">
                <div class="grid-x grid-margin-x " style="padding-top:30px">
                    <div class="medium-2 small-1 cell"></div>
                    <div class="medium-8 small-10 cell">

                        <div class="max-width-1024-wrapper">
                            <div class="laptop">
                                <div class="laptop__screen">
                                    <div class="laptop__video-wrapper">
                                        <iframe
                                                class="laptop__iframe"
                                                width="640"
                                                height="360"
                                                frameborder="0"
                                                allowfullscreen
                                                src="<?php echo esc_url( Zume_Course::get_video_by_key( '31' ) ) ?>"

                                        ></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end cell-->
                    <div class="medium-2 small-1 cell"></div>
                </div>

                <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="max-width:100%; margin:0; background:white; padding:17px; color: #0A246A; font-size: 24px">
                    <div class="medium-3 small-2 cell"></div>
                    <div class="medium-6 small-8 cell center">
                        <?php esc_html_e( "Zúme Training is an on-line and in-life learning experience designed for small groups who follow Jesus to learn how to obey His Great Commission and make disciples who multiply.", 'zume' ) ?>
                    </div>
                    <div class="medium-3 small-2 cell"></div>
                </div>
                <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="max-width:100%; margin:0; background:white; padding:17px; color: #0A246A; padding-top:0">
                    <div class="cell center" style="margin-top:0">
                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>zume-training.png">
                    </div>
                </div>


                <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="max-width:900px; margin:0 auto; padding:17px; color: white; font-size: 24px">
                    <div class="cell small-12" style="max-width:900px;margin-left:auto;margin-right:auto">
                        <h3 class="center"><strong style="color: white" ><?php esc_html_e( "Zúme consists of 10 sessions, 2 hours each:", 'zume' ) ?></strong></h3>
                    </div>
                    <div class="cell small-12" style="max-width:800px;margin-left:auto;margin-right:auto;font-size: 20px">
                        <div class="grid-x grid-margin-x vertical-padding" >
                             <div class="cell small-2">
                                <img height="20px" width="30px" style="float:right;margin-top:10px" src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>play.svg">
                            </div>
                            <div class="cell small-10">
                                <?php esc_html_e( "Video and Audio to help your group understand basic principles of multiplying disciples.", 'zume' ) ?>
                            </div>
                        </div>
                        <div class="grid-x grid-margin-x vertical-padding" >
                             <div class="cell small-2">
                                <img height="20px" width="30px" style="float:right;margin-top:10px" src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>discuss.svg">
                            </div>
                            <div class="cell small-10">
                                <?php esc_html_e( "Group Discussions to help your group think through what’s being shared.", 'zume' ) ?>
                            </div>
                        </div>
                        <div class="grid-x grid-margin-x vertical-padding" >
                             <div class="cell small-2">
                                <img height="20px" width="30px" style="float:right;margin-top:10px" src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>run.svg">
                            </div>
                            <div class="cell small-10">
                                <?php esc_html_e( "Simple Exercises to help your group put what you’re learning into practice.", 'zume' ) ?>
                            </div>
                        </div>
                        <div class="grid-x grid-margin-x vertical-padding" >
                             <div class="cell small-2">
                                <img height="20px" width="30px" style="float:right;margin-top:10px" src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>plant-ground.svg">
                            </div>
                            <div class="cell small-10">
                                <?php esc_html_e( "Session Challenges to help your group keep learning and growing between sessions.", 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!----------------------------------->
                <!-- CHALLENGE RIBBON -->
                <!----------------------------------->
                <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="max-width:100%; margin:0; background:white; padding:17px">
                    <div class="medium-2 small-1 cell"></div>
                    <div class="medium-8 small-10 cell center">
                        <h3 style="margin-bottom:0px">
                            <strong><?php esc_html_e( 'Want to start the training?', 'zume' ) ?></strong>
                        </h3>
                        <h3 style="margin-bottom:0px">
                            <strong><?php esc_html_e( 'Get started below', 'zume' ) ?></strong>
                        </h3>
                    </div>
                    <div class="medium-2 small-1 cell"></div>
                </div>


                <!----------------------------------->
                <!-- GET STARTED RIBBON -->
                <!----------------------------------->
                <!-- triangle -->
                <div class="center" style="width: 0; height: 0; border-left: 30px solid transparent; border-right: 30px solid transparent; border-top: 30px solid white; margin-top:0px;"></div>
                <div class="row vertical-padding">
                    <div class="large-6 medium-8 small-10  center">
                        <h3><strong style="color: white"><?php esc_html_e( "It's as easy as 1-2-3", 'zume' ) ?></strong></h3>
                    </div>
                </div>

                <div class="grid-x grid-margin-x grid-margin-y vertical-padding easy-1-2-3" style="max-width:1200px; margin:0 auto">
                    <div class="cell medium-4 small-12">
                        <h4 class="" style="color:white;">
                            <span style="font-size:2.4rem;vertical-align:middle">&#10102</span>
                            <span style="font-size:1.5rem; display:inline-block; margin: 0 10px">
                             <?php esc_html_e( "Sign up", 'zume' ) ?></span>
                            <img class=""
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>sign-up.svg"
                                 alt="" width="50"/>
                        </h4>
                    </div>
                    <div class="cell medium-4 small-12">
                        <h4 class="" style="color:white">
                            <span style="font-size:2.4rem;vertical-align:middle">&#10103</span>
                            <span style="font-size:1.5rem; display:inline-block; margin: 0 10px">
                             <?php esc_html_e( "Invite some friends", 'zume' ) ?></span>
                            <img class=""
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>invite-friends.svg"
                                 alt="" width="50"/>
                        </h4>
                    </div>
                    <div class="cell medium-4 small-12">
                        <h4 class="" style="color:white">
                            <span style="font-size:2.4rem;vertical-align:middle">&#10104</span>
                            <span style="font-size:1.5rem; display:inline-block; margin: 0 10px">
                             <?php esc_html_e( "Invite some friends", 'zume' ) ?></span>
                            <img class=""
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>host-training.svg"
                                 alt="" width="50"/>
                        </h4>
                    </div>
                </div>
                <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                    <div class="medium-2 small-1 cell"></div>
                    <div class="medium-8 small-10 cell center" >
                        <a href="<?php echo esc_url( site_url( '/' ) .  'wp-login.php?action=register' ); ?>" alt="Register" class="button large center " style="background:white; color:#323a68; font-family:'europa-regular'; padding:0.5em 2em"><?php esc_html_e( 'Get Started', 'zume' ) ?></a>
                    </div>
                    <div class="medium-2 small-1 cell"></div>
                </div>
            </div> <!-- Gradient background -->





            <!----------------------------------->
            <!-- WHAT OTHERS ARE SAYING RIBBON -->
            <!----------------------------------->
            <br clear />
            <!-- Slider -->
            <div class="grid-x expanded" >
                <div class="medium-2 small-1 cell"></div>
                <div class="small-10 medium-8 small-centered cell">

                    <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                        <div class="medium-2 small-1 cell"></div>
                        <div class="medium-8 small-10 cell center">
                            <h3 class="center"><strong><?php esc_html_e( 'What others are saying?', 'zume' ) ?></strong></h3>
                        </div>
                        <div class="medium-2 small-1 cell"></div>
                    </div>

                    <div class="grid-x grid-margin-x grid-margin-y vertical-padding">

                        <div class="cell front-page-social" data-equalizer style="color:#21336A;">
                            <div class="grid-x grid-margin-x grid-margin-y">
                            <div class="large-4 medium-6 small-12 cell centered" data-equalizer-watch>
                                <img src="<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>1body.png"
                                     class="center front-page-social-image">
                                <p class="text-center" style="color:#21336A">
                                    <?php esc_attr_e( '"Zúme will help us accelerate our training into more countries and languages."', 'zume' ) ?>
                            </div>
                            <div class="large-4 medium-6 small-12 cell centered" data-equalizer-watch>
                                <img src="<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>noplaceleft.png"
                                     class="center front-page-social-image">
                                <p class="text-center" style="color:#21336A">
                                    <?php esc_attr_e('"Zúme is a helpful way to filter for faithful people that can spread quickly and
                                    conserve training bandwidth."', 'zume') ?>
                                </p>
                            </div>
                            <div class="large-4 medium-6 small-12 cell centered" data-equalizer-watch>
                                <img src="<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>2414.png"
                                     class="center front-page-social-image">
                                <p class="text-center" style="color:#21336A">
                                    <?php esc_attr_e( '"Zúme is a wonderful on-ramp for our coalition."', 'zume' ) ?>
                                </p>
                            </div>
                            <div class="large-4 medium-6 small-12 cell centered" data-equalizer-watch>
                                <!--                                <div class="center">-->
                                <img src="<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>biglife.png"
                                     class="center front-page-social-image" style="max-height: 60px">
                                <!--                                </div>-->
                                <p class="text-center" style="color:#21336A">
                                    <?php esc_attr_e( '"Zúme brilliantly encapsulates the principles in our introductory training."', 'zume' ) ?>
                                </p>
                            </div>
                            <div class="large-4 medium-6 small-12 cell centered">
                                <!--                                <div style="height: 60px" class="center">-->
                                <img src="<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>teamexpansion.png"
                                     class="center front-page-social-image" style="max-height: 60px">
                                <!--                                </div>-->
                                <p class="text-center" style="color:#21336A">
                                    <?php esc_attr_e('"The principles and life practices packed into the Zúme disciple-multiplication
                                    training course have enormous potential to impact not only the USA but also, as the
                                    course is translated into 34 other languages, the world as well."', 'zume') ?>
                                </p>
                            </div>
                            <div class="large-4 medium-6 small-12 cell centered" data-equalizer-watch>
                                <div style="height: 75px" class="center">
                                    <img src="<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>finishingthetask-logo.png"
                                         class="center front-page-social-image" style="max-height: 60px; width:280px">
                                </div>
                                <p class="text-center" style="color:#21336A">
                                    <?php esc_attr_e('"Zúme is a valuable tool for many of our member organizations to use in engaging new
                                    people groups."', 'zume') ?>
                                </p>
                            </div>
                            </div>
                        </div>

                        <!-- Find out more link -->
                    </div>
                </div> <!-- end #main -->

                </div> <!-- End columns-->
                <div class="medium-2 small-1 cell"></div>

            </div>

            <!-- Find out more link -->
            <div class="grid-x ">
                <div class="small-8 medium-3 small-centered cell center vertical-padding">
                    <br>
                    <a href="<?php echo esc_url( site_url( '/' ) . $zume_current_lang ) . '/about'; ?>" class="button large center " >
                        <?php esc_html_e( 'Find out more about Zúme', 'zume' ) ?></a>
                    <br>
                </div>
            </div>

        </div> <!-- end #main -->

    </div> <!-- end cell --><!-- content -->


<?php get_footer(); ?>
