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

<div id="content" class="grid-x grid-padding-x"><div class="cell">

    <div id="inner-content grid-x">

        <div id="main" class="cell" role="main">

            <div style="background: linear-gradient(#2CA2E2, #21336A)">
            <!-- Video -->
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
                                            src="<?php echo esc_url( Zume_Course::get_video_by_key( 'overview' ) ) ?>"

                                    ></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end cell-->
                <div class="medium-2 small-1 cell"></div>
            </div>

            <!-- Challenge -->
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
            <!-- triangle -->
            <div class="center" style="width: 0; height: 0; border-left: 30px solid transparent; border-right: 30px solid transparent; border-top: 30px solid white; margin-top:0px;"></div>

                <!-- Get started section`-->
            <div class="row vertical-padding">
                <div class="large-6 medium-8 small-10  center">
                    <h3><strong style="color: white">It's as easy as 1-2-3</strong></h3>
                </div>
            </div>

            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell">
                    <div class="grid-x">
                        <div class="medium-4 cell center">
                            <h4 class="center" style="color:white">
                                <span style="font-size:2.4rem;">&#10102</span>
                                <span style="font-family:'europa-regular'; font-size:1.2rem; vertical-align:25%; display:inline-block">
                                 <?php esc_html_e( "Sign up", 'zume' ) ?></span>
                            </h4>

                            <img class="center"
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>sign-up.svg"
                                 alt="" width="100" height="100"/>

                        </div>
                        <div class="medium-4 cell center">
                            <h4 class="center" style="color:white">
                                <span style="font-size:2.4rem;">&#10103</span> 
                                <span style="font-family:'europa-regular'; font-size:1.2rem; vertical-align:25%; display:inline-block">
                                    <?php esc_html_e( "Invite some friends", 'zume' ) ?>
                                </span>
                            </h4>

                            <img class="center"
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>invite-friends.svg"
                                 alt="" width="100" height="100"/>

                        </div>
                        <div class="medium-4 cell center">
                            <h4 class="center" style="color:white">
                                <span style="font-size:2.4rem;">&#10104</span> 
                                <span style="font-family:'europa-regular'; font-size:1.2rem; vertical-align:25%; display:inline-block">  
                                    <?php esc_html_e( "Host a training", 'zume' ) ?>
                                </span>
                            </h4>
                            <img class="center"
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>host-training.svg"
                                 alt="" width="100" height="100"/>

                        </div>
                    </div>

                    <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                        <div class="medium-2 small-1 cell"></div>
                        <div class="medium-8 small-10 cell center" >
                            <a href="<?php echo esc_url( site_url( '/' ) .  'wp-login.php?action=register' ); ?>" alt="Register" class="button large center " style="background:white; color:#323a68; font-family:'europa-regular'; padding:0.5em 2em"><?php esc_html_e( 'Get Started', 'zume' ) ?></a>
                        </div>
                        <div class="medium-2 small-1 cell"></div>
                    </div>

                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>
            </div> <!-- Gradient background -->
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

    </div> <!-- end cell --> </div> <!-- content -->


<?php get_footer(); ?>
