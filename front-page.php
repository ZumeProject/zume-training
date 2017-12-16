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

<div id="content">

    <div id="inner-content grid-x">

        <div id="main" class="cell" role="main">

            <!-- Video -->
            <div class="grid-x grid-margin-x grid-margin-y">
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
                                            src="https://www.youtube-nocookie.com/embed/EOdSAdJ6AhI?rel=0&amp;showinfo=0"

                                    ></iframe>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- end cell-->
                <div class="medium-2 small-1 cell"></div>
            </div>


            <!-- Challenge -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell center">
                    <h1 class="front-page-header">
                        <?php esc_html_e( 'Want to start the training?', 'zume' ) ?>
                    </h1>
                    <h1 class="front-page-header">
                        <?php esc_html_e( 'Get started below:', 'zume' ) ?>
                    </h1>
                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell center">
                    <a href="<?php echo '/' . esc_url( $zume_current_lang ) . '/register'; ?>" alt="Register" class="button large center "><?php esc_html_e( 'GET STARTED', 'zume' ) ?></a>
                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <hr style="border-color: #323A68;" size="3px" width="100%"/>


            <!-- Steps -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell center">
                    <h3 style="text-transform: uppercase"><?php esc_html_e( 'It\'s as easy as 1-2-3', 'zume' ) ?></h3>
                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell">
                    <div class="grid-x">
                        <div class="medium-4 cell center">
                            <h4 class="center" style="text-transform: uppercase"><span
                                        style="font-size:2.4rem;">&#10102</span>
                                 Sign up</h4>
                            <img class="center"
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/pages/'; ?>signup.jpg"
                                 alt="" width="100" height="100"/>

                        </div>
                        <div class="medium-4 cell center">
                            <h4 class="center" style="text-transform: uppercase"><span
                                        style="font-size:2.4rem;">&#10103</span> Invite
                                some friends</h4>
                            <img class="center"
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/pages/'; ?>invite.jpg"
                                 alt="" width="100" height="100"/>

                        </div>
                        <div class="medium-4 cell center">
                            <h4 class="center" style="text-transform: uppercase"><span
                                        style="font-size:2.4rem;">&#10104</span> Host
                                a training</h4>
                            <img class="center"
                                 src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/pages/'; ?>training.jpg"
                                 alt="" width="100" height="100"/>

                        </div>
                    </div>
                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>

            <!-- Slider -->
            <div class="grid-x expanded" style="background: #323A68;">
                <div class="medium-2 small-1 cell"></div>
                <div class="small-10 medium-8 small-centered cell">

                    <div style="color: white; text-align: center; padding: 20px;">

                        <h4 class="padding-bottom" style="text-transform: uppercase"><?php esc_html_e( 'What others are saying?', 'zume' ) ?></h4>

                        <div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
                            <ul class="orbit-container white">

                                <li class="orbit-slide">
                                    <div>
                                        <h4 class="text-center zume-slider-text"><strong>
                                            <?php esc_html_e( 'There is a great harvest readied in North America not being reached by the status quo. Zúme is a biblical wake-up call and tool to empower the everyday believer to begin walking in the Lords will to multiply disciples.', 'zume' ) ?></strong>
                                        </h4>
                                        <h4 class="zume-slider-name" style="text-transform: uppercase">
                                            <?php esc_html_e( 'Jake Duke — Indiana', 'zume' ) ?>
                                        </h4>
                                    </div>
                                </li>
                                <li class="orbit-slide">
                                    <div>
                                        <h4 class="text-center zume-slider-text">
                                            <strong>
                                                <?php esc_html_e( 'Do you want to make a difference in your workplace, neighborhood, or circle of friends? The Zúme Project essentially will give you practical rails to run on that follow the example of the Church as seen in the New Testament.', 'zume' ) ?>
                                            </strong>
                                        </h4>
                                        <h4 class="zume-slider-name" style="text-transform: uppercase">
                                            <?php esc_html_e( 'Gavin Duerson — Kentucky', 'zume' ) ?>
                                        </h4>
                                    </div>
                                </li>
                                <li class="orbit-slide">
                                    <div>
                                        <h4 class="text-center zume-slider-text">
                                            <strong>
                                                <?php esc_html_e( 'I am so excited to use this Zúme tool to help in training all the soldiers to make and multiply disciples in our neighborhood. Jesus can make it a neighborhood again.', 'zume' ) ?>
                                            </strong>
                                        </h4>
                                        <h4 class="zume-slider-name" style="text-transform: uppercase">
                                            <?php esc_html_e( 'Chad Rehnberg', 'zume' ) ?>
                                        </h4>
                                    </div>
                                </li>
                                <li class="orbit-slide">
                                    <div>
                                        <h4 class="text-center zume-slider-text">
                                            <strong>
                                                <?php esc_html_e( 'I believe Zúme can be used by the Lord to reach a huge number of people in our society who would never darken the door of a church building.', 'zume' ) ?>
                                            </strong>
                                        </h4>
                                        <h4 class="zume-slider-name" style="text-transform: uppercase">
                                            <?php esc_html_e( 'Curtis Sergeant — Alabama', 'zume' ) ?>
                                        </h4>
                                    </div>
                                </li>

                            </ul>
                            <nav class="orbit-bullets">
                                <button class="is-active" data-slide="0"><span
                                            class="show-for-sr">
                                        <?php esc_html_e( 'First slide details.', 'zume' ) ?></span><span
                                            class="show-for-sr">
                                        <?php esc_html_e( 'Current Slide', 'zume' ) ?></span></button>
                                <button data-slide="1"><span class="show-for-sr">
                                        <?php esc_html_e( 'Second slide details.', 'zume' ) ?></span>
                                </button>
                                <button data-slide="2"><span class="show-for-sr">
                                        <?php esc_html_e( 'Third slide details.', 'zume' ) ?></span>
                                </button>
                                <button data-slide="3"><span class="show-for-sr">
                                        <?php esc_html_e( 'Fourth slide details.', 'zume' ) ?></span>
                                </button>
                            </nav>
                        </div>
                    </div>

                </div> <!-- End columns-->
                <div class="medium-2 small-1 cell"></div>

            </div>

            <!-- Find out more link -->
            <div class="grid-x ">
                <div class="small-8 medium-3 small-centered cell center vertical-padding">
                    <br>
                    <a href="<?php echo '/' . esc_url( $zume_current_lang ) . '/about'; ?>" class="button large center " style="text-transform: uppercase">
                        <?php esc_html_e( 'Find out more about Zúme', 'zume' ) ?></a>
                    <br>
                </div>
            </div>

        </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
