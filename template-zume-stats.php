<?php
/*
Template Name: Zúme Stats
*/
if ( !current_user_can( "administrator" ) ){
    wp_redirect( "dashboard" );
}

get_header();

?>

    <div id="content">
        <div id="inner-content" class="row">

            <main id="main" class="large-12 medium-12 columns" role="main" style="margin:0 auto; max-width: 1000px">

                <div id="sizes" style="width: 900px; height: 600px;"></div>
                <div id="sessions" style="width: 900px; height: 600px;"></div>

                <h3><?php esc_html_e( 'Groups Locations', 'zume' ) ?></h3>
                <div id="group-markers" style="width: 900px; height: 600px;"></div>

                <br>
                <br>
<!--                <h3>Other stats</h3>-->
<!--                <div>Homepage page views: <span id="analytics"></span></div>-->
<!--                <div>Intro video views: <span id="intro_views"></span></div>-->

                <br>
                <br>
                <h3><?php esc_html_e( 'Translation Progress', 'zume' ) ?></h3>
                    <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRnYZtXXZ6sBIrVYJAibJXuQ08rFqJe6HtPfnxBMoywOTvIeoDK-UtGlEWTSWZNqquM8doyr-JCw2By/pubhtml?gid=2022886715&amp;single=true&amp;widget=true&amp;headers=false"
                        width="60%" height="400px"
                    ></iframe>
                <br>
                <br><br>
                <h3><?php esc_html_e( 'Progress for Each Language', 'zume' ) ?></h3>
                <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRnYZtXXZ6sBIrVYJAibJXuQ08rFqJe6HtPfnxBMoywOTvIeoDK-UtGlEWTSWZNqquM8doyr-JCw2By/pubhtml?gid=446320782&amp;single=true&amp;widget=true&amp;headers=false"
                    width="60%"
                    height="1100px"
                >
                </iframe>
            </main>
        </div>
    </div>

<?php get_footer(); ?>
