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
                    <h1 style="margin-bottom:0px;color: #323a68;">
                        <strong><?php the_title(); ?></strong>
                    </h1>
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

        </div> <!-- end #inner-content -->

        <div style="width:100%; height:3px; background-color: #2CA2E2;"></div>
        <!----------------------------------->
        <!-- VIDEO RIBBON -->
        <!----------------------------------->
        <div style="background: linear-gradient(#2CA2E2, #21336A)">


            <div class="grid-x grid-margin-x grid-margin-y vertical-padding" style="max-width:100%; margin:0; background:white; padding:17px; color: #0A246A; font-size: 24px">
                <div class="cell show-for-small hide-for-large  center">
                    <a href="<?php echo esc_url( zume_register_url( zume_current_language() ) ); ?>" alt="Register" class="button large center " style="background:white; color:#323a68; font-family:'europa-regular'; padding:0.5em 2em">
                        <?php esc_html_e( 'Get Started', 'zume' ) ?>
                    </a>
                    <a href="<?php echo esc_url( zume_login_url( zume_current_language() ) ); ?>" alt="Login" class="button large center" style="background:white; color:#323a68; font-family:'europa-regular'; padding:0.5em 2em">
                        <?php esc_html_e( 'Login', 'zume' ) ?>
                    </a>
                </div>
                <div class="medium-3 small-2 cell"></div>
                <div class="medium-6 small-8 cell center">
                    <?php esc_html_e( "Zúme Training is an on-line and in-life learning experience designed for small groups who follow Jesus to learn how to obey His Great Commission and make disciples who multiply.", 'zume' ) ?>
                </div>
                <div class="medium-3 small-2 cell"></div>
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
                             <?php esc_html_e( "Host a training", 'zume' ) ?></span>
                        <img class=""
                             src="<?php echo esc_url( get_stylesheet_directory_uri() ) . '/assets/images/home/'; ?>host-training.svg"
                             alt="" width="50"/>
                    </h4>
                </div>
            </div>
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="medium-2 small-1 cell"></div>
                <div class="medium-8 small-10 cell center" >
                    <a href="<?php echo esc_url( zume_register_url( zume_current_language() ) ); ?>" alt="Register" class="button large center " style="background:white; color:#323a68; font-family:'europa-regular'; padding:0.5em 2em"><?php esc_html_e( 'Get Started', 'zume' ) ?></a>
                </div>
                <div class="medium-2 small-1 cell"></div>
            </div>
        </div> <!-- Gradient background -->


        <br clear />


    </div> <!-- cell -->
</div> <!-- content -->

        <?php
} // end while
} // end if
get_footer();
?>
