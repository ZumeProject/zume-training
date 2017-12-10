<?php
/*
Template Name: Zúme Course
*/

// Get variables
if ( empty( $_GET['group'] ) || empty( $_GET['session'] ) ) {
    wp_die( 'You are mission your group or session number. <a href="/">Head back to your dashboard</a>' );
}
$zume_group_key       = $_GET['group'];
$zume_session      = $_GET['session'];
$zume_current_user = get_current_user_id();
$zume_user_meta    = array_map( function ( $a ) {
    return $a[0];
}, get_user_meta( $zume_current_user ) );

get_header();

?>

<div id="content">

    <div id="inner-content" class="grid-x grid-margin-x">

        <div class="large-1 cell"></div>

        <div id="main" class="large-10 cell" role="main">

            <div class="callout">

                <?php
                /**
                 * Load Zume Course Content
                 */

                    Zume_Course::update_session_complete( $zume_group_key, $zume_session );

                ?>
            </div>

        </div> <!-- end #main -->

        <div class="large-1 cell"></div>

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
