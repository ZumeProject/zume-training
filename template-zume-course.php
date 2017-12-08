<?php
/*
Template Name: Zúme Course
*/

$group = get_query_var( 'group', false );
$session = get_query_var( 'session', false );

get_header();

?>

    <div id="content">

        <div id="inner-content" class="grid-x grid-margin-x">

            <div id="main" class="large-12 medium-12 cell" role="main">

                <?php
                /**
                 * Load Zume Course Content
                 */
                print $group . ' ' . $session;


//              Zume_Course::instance()->zume_pre_content_load();



                ?>

            </div> <!-- end #main -->

        </div> <!-- end #inner-content -->

    </div> <!-- end #content -->

<?php get_footer(); ?>
