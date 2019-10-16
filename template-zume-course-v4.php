<?php
/*
Template Name: Zúme Course v4
*/

get_header();
$session_id = 1;
if ( isset( $_GET['session'] ) ) {
    $session_id = sanitize_text_field( wp_unslash( $_GET['session'] ) );
}
?>
    <script>
        /* Hide the language selector during the course, because switching wipes out the group key. */
        jQuery(document).ready(function() {
            jQuery('#lang_choice_1').hide();
        })
    </script>
    <div id="content" class="max-content-width">
        <div id="inner-content" class="grid-x grid-margin-x">
            <div id="main" class="large-12 cell" role="main">

                <?php
                /**
                 * Load Zume Course Content
                 */
                Zume_Course_Content::get_course_content( $session_id );
                ?>

            </div> <!-- end #main -->
        </div> <!-- end #inner-content -->
    </div><!-- end #content -->

<?php get_footer(); ?>
