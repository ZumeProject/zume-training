<?php
/*
Template Name: Full Width (No Sidebar)
*/
?>

<?php get_header(); ?>

<style>
    .temp-full-width {
        background-color: #21336A;
        color: white;
        padding-top: 20px;
        padding-bottom: 10px;
        margin-top: 20px;
        margin-bottom: 20px;
        margin-left: -0.9375rem;
        margin-right: -0.9375rem;
        padding-left: 0.9375rem;
        padding-right: 0.9375rem;
    }

    @media only screen and (min-width: 40em) {
        .temp-full-width {
            margin-left: -1.25rem;
            margin-right: -1.25rem;
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }
    }

    @media only screen and (min-width: 75rem) {
        .temp-full-width {
            margin-left: calc(-100vw / 2 + 75rem / 2 - 1.25rem);
            margin-right: calc(-100vw / 2 + 75rem / 2 - 1.25rem);
            padding-left: calc(100vw / 2 - 75rem / 2 + 1.25rem);
            padding-right: calc(100vw / 2 - 75rem / 2 + 1.25rem);
        }
    }
</style>

<div id="content">

    <div id="inner-content" class="row">

        <div id="main" class="large-12 medium-12 columns" role="main">

            <!-- Video Embed -->
            <script src="https://fast.wistia.com/embed/medias/fv8nyh7r1y.jsonp" async></script>
            <script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>

            <div class="wistia_responsive_padding" style="padding: 56.0% 0 0 0; position: relative;">
                <div class="wistia_responsive_wrapper"
                     style="height: 100%; left: 0; position: absolute; top: 0; width: 100%;">
                    <div class="wistia_embed wistia_async_fv8nyh7r1y videoFoam=true"
                         style="height: 100%; width: 100%;"></div>
                </div>
            </div>

            <!-- Content Section -->
            <p style="font-size: 150%; margin: 20px 0 40px 0; text-align: center;">
	            <?php echo __( 'Zúme Training is an on-line and in-life learning experience designed for small groups who follow Jesus
                to learn how to obey His Great Commission and make disciples who multiply.', 'zume') ?>
            </p>

            <div class="temp-full-width">
                <h3 style="color: white;"><?php echo __( 'Goals of the Zúme Project:', 'zume') ?></h3>

                <p>
					<?php echo __( 'Zúme means yeast in Greek. In Matthew 13:33 Jesus is quoted as saying, "The Kingdom of Heaven is like a
                woman who took yeast and mixed it into a large amount of flour until it was all leavened." This
                illustrates how ordinary people, using ordinary resources, can have an extraordinary impact for the
                    Kingdom of God. Zúme aims to equip and empower ordinary believers to reach every neighborhood.', 'zume' ) ?>
                </p>

                <p><?php echo __( 'The initial goal of Zúme is for there to be a training group of four to twelve people in each census
                    tract in the country. Each of these training groups will start two first-generation churches which
                    will then begin to reproduce. There are about 75,000 census tracts in the U.S.', 'zume') ?>
                </p>
            </div>

            <div class="row">
                <div class="medium-4 cell">
                    <img class="size-full wp-image-899 alignleft" style="float: left; margin-bottom: 50px;"
                         src="<?php echo get_theme_file_uri( 'assets/images/pages/training2.png' ) ?>"
                         alt="Zúme in 10 sessions, 2 hours each, cost: free" width="230"
                         height="150"/>
                </div>
                <div class="medium-8 cell">
                    <h3><?php echo __( 'Zúme Training consists of nine (two-hour) Basic Sessions and includes:', 'zume') ?></h3>

                    <ul style="margin-bottom: 1.6rem;">
                        <li><?php echo __( 'Video and Audio to help your group understand basic principles of multiplying disciples.', 'zume') ?></li>
                        <li><?php echo __( 'Group Discussions to help your group think through what’s being shared.', 'zume') ?></li>
                        <li><?php echo __( 'Simple Exercises to help your group put what you’re learning into practice.', 'zume') ?></li>
                        <li><?php echo __( 'Session Challenges to help your group keep learning and growing between sessions.', 'zume') ?></li>
                        <li><?php echo __( 'There is an optional Session 10 with extra material.', 'zume') ?></li>
                    </ul>
                </div>

            </div>


            <img class="size-full wp-image-901 alignleft" style="clear: both; float: left; margin-bottom: 50px;"
                 src="<?php echo get_theme_file_uri( 'assets/images/pages/getstarted.png' ) ?>" alt="" width="230"
                 height="150"/>

            <h3><?php echo __( 'How to get started:', 'zume') ?></h3>

            <ul style="margin-bottom: 1.8rem;">
                <li><?php echo __( 'If you haven\'t created a login yet, please do so.', 'zume') ?></li>
                <li><?php echo __( 'Invite 3-11 friends. You must have at least four people present, who have accepted your invitation,
                    to start the first session.', 'zume') ?></li>
                <li><?php echo __( 'Schedule a time to get together with your friends.', 'zume') ?></li>
                <li><?php echo __( 'Make sure you have access to an internet-enabled device.', 'zume') ?></li>
            </ul>

            <img class="size-full wp-image-900 alignleft" style="clear: both; float: left;"
                 src="<?php echo get_theme_file_uri( 'assets/images/pages/guidebook.png' ) ?>" alt="" width="230"
                 height="150"/>

            <h3><?php echo __( 'Optional prep for your first meeting:', 'zume') ?></h3>

            <ul>
                <li><?php echo __( 'Download the Zúme Guidebook.', 'zume') ?></li>
                <li><?php echo __( 'If you\'d like, you can print out copies for the members of your group.', 'zume') ?></li>
                <li><?php echo __( 'Consider connecting to a TV or projector so everyone in your group can view the content.', 'zume') ?></li>
            </ul>

        </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
