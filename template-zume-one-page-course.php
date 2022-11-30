<?php
/*
Template Name: Zúme One Page Course
*/
zume_force_login();

if ( ! user_can( get_current_user_id(), 'manage_options' ) ) {
    return;
}

function zume_one_page_add_to_header(){
    ?>
    <!-- Compressed JavaScript -->
    <?php // @codingStandardsIgnoreStart ?>
    <script src="https://cdn.jsdelivr.net/npm/foundation-sites@6.5.3/dist/js/foundation.min.js" integrity="sha256-/PFxCnsMh+nTuM0k3VJCRch1gwnCfKjaP8rJNq5SoBg= sha384-9ksAFjQjZnpqt6VtpjMjlp2S0qrGbcwF/rvrLUg2vciMhwc1UJJeAAOLuJ96w+Nj sha512-UMSn6RHqqJeJcIfV1eS2tPKCjzaHkU/KqgAnQ7Nzn0mLicFxaVhm9vq7zG5+0LALt15j1ljlg8Fp9PT1VGNmDw==" crossorigin="anonymous"></script>
    <?php // @codingStandardsIgnoreEnd ?>
    <?php
}
add_action( 'wp_head', 'zume_one_page_add_to_header' );

get_header();

?>
<style>
    div.alt-video-section {
        width:100% !important;
        text-align: center;
    }
    div.alt-video-section video {
        width:100% !important;
    }
   @media screen and ( max-width: 600px ) {
       div.alt-video-section {
           max-height: 250px;
       }

   }
    iframe#launcher {
        display:none;
    }
</style>
    <div id="content" class="max-content-width">
        <div id="inner-content" class="grid-x grid-margin-x">
            <div id="main" class="large-12 cell" role="main">

                <ul class="tabs" data-tabs id="example-tabs">
                    <li class="tabs-title is-active"><a href="#panel1" aria-selected="true"><?php esc_html_e( 'Session 1', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel2" href="#panel2"><?php esc_html_e( 'Session 2', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel3" href="#panel2"><?php esc_html_e( 'Session 3', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel4" href="#panel2"><?php esc_html_e( 'Session 4', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel5" href="#panel2"><?php esc_html_e( 'Session 5', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel6" href="#panel2"><?php esc_html_e( 'Session 6', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel7" href="#panel2"><?php esc_html_e( 'Session 7', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel8" href="#panel2"><?php esc_html_e( 'Session 8', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel9" href="#panel2"><?php esc_html_e( 'Session 9', 'zume' ) ?></a></li>
                    <li class="tabs-title"><a data-tabs-target="panel10" href="#panel2"><?php esc_html_e( 'Session 10', 'zume' ) ?></a></li>
                </ul>
                <div class="tabs-content" data-tabs-content="example-tabs">
                    <div class="tabs-panel is-active" id="panel1">
                        <h1 class="center"><?php esc_html_e( 'Session 1', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_1( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel2">
                        <h1 class="center"><?php esc_html_e( 'Session 2', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_2( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel3">
                        <h1 class="center"><?php esc_html_e( 'Session 3', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_3( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel4">
                        <h1 class="center"><?php esc_html_e( 'Session 4', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_4( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel5">
                        <h1 class="center"><?php esc_html_e( 'Session 5', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_5( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel6">
                        <h1 class="center"><?php esc_html_e( 'Session 6', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_6( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel7">
                        <h1 class="center"><?php esc_html_e( 'Session 7', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_7( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel8">
                        <h1 class="center"><?php esc_html_e( 'Session 8', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_8( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel9">
                        <h1 class="center"><?php esc_html_e( 'Session 9', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_9( true ); ?>
                    </div>
                    <div class="tabs-panel" id="panel10">
                        <h1 class="center"><?php esc_html_e( 'Session 10', 'zume' ) ?></h1><br>
                        <hr>
                        <?php Zume_Course_Content::get_course_content_10( true ); ?>
                    </div>
                </div>

            </div> <!-- end #main -->
        </div> <!-- end #inner-content -->
    </div><!-- end #content -->
    <script>
       jQuery(document).ready(function(){
           jQuery('#zume-main-menu').empty()
           jQuery('#webWidget').remove()
           jQuery('#launcher').remove()
           jQuery('#nav-menu').remove()
       })
    </script>

<?php get_footer(); ?>
