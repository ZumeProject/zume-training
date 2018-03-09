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

                <h3>Groups locations</h3>
                <div id="group-markers" style="width: 900px; height: 600px;"></div>

                <br>
                <br>
<!--                <h3>Other stats</h3>-->
<!--                <div>Homepage page views: <span id="analytics"></span></div>-->
<!--                <div>Intro video views: <span id="intro_views"></span></div>-->

                <br>
                <br>
                <h3>Translation Progress</h3>
                <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vS3rJ_shcus0nIrYWHzFpWY5F5UfiYWb4ql8kaNTtWDf5htAA8-KmiVwV49RYWIxZumfI6zVH5fY4ZG/pubhtml?gid=2023643321&amp;single=true&amp;widget=true&amp;headers=false"
                        width="60%" height="400px"
                ></iframe>
                <br>
                <br><br>
                <h3>Progress for each language</h3>
                <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vS3rJ_shcus0nIrYWHzFpWY5F5UfiYWb4ql8kaNTtWDf5htAA8-KmiVwV49RYWIxZumfI6zVH5fY4ZG/pubhtml?gid=0&amp;single=true&amp;widget=true&amp;headers=false"
                        width="60%"
                        height="1000px"
                ></iframe>
            </main>
        </div>
    </div>

<?php get_footer(); ?>
