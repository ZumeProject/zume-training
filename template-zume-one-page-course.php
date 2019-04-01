<?php
/*
Template Name: Zúme One Page Course
*/
zume_force_login();

if ( ! user_can( get_current_user_id(), 'manage_options') ) {
    return;
}

get_header();

?>

    <div id="content" class="max-content-width">
        <div id="inner-content" class="grid-x grid-margin-x">
            <div id="main" class="large-12 cell" role="main">

                <?php
                /**
                 * Load Zume Course Content
                 */

                ?><hr><h1 style="text-align:center;">Session 1</h1><hr><br><br><?php

                Zume_Course_Content::get_course_content_1();
                ?><hr><h1>Session 1</h1><hr><?php
                Zume_Course_Content::get_course_content_2();
                Zume_Course_Content::get_course_content_3();
                Zume_Course_Content::get_course_content_4();
                Zume_Course_Content::get_course_content_5();
                Zume_Course_Content::get_course_content_6();
                Zume_Course_Content::get_course_content_7();
                Zume_Course_Content::get_course_content_8();
                Zume_Course_Content::get_course_content_9();
                Zume_Course_Content::get_course_content_10();

                ?>

            </div> <!-- end #main -->
        </div> <!-- end #inner-content -->
    </div><!-- end #content -->

<?php get_footer(); ?>