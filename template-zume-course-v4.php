<?php
/*
Template Name: Zúme Course v4
*/

$session_id = 1;
if ( isset( $_GET['session'] ) ) {
    $session_id = sanitize_text_field( wp_unslash( $_GET['session'] ) );
}
$group = false;
if ( isset( $_GET['group'] ) ) {
    $foreign_key = sanitize_text_field( wp_unslash( $_GET['group'] ) );
    $group = Zume_v4_Groups::get_group_by_foreign_key( $foreign_key );
    if ( empty( $group ) || ! isset( $group['key'] ) ) {
        dt_write_log( 'Failed to find group for key '. $foreign_key );
    }
    if ( ! Zume_v4_Groups::update_group_session_status( $group['key'], $session_id ) ) {
        dt_write_log( 'Failed to update session for '. $group['key'] );
    }
}
?>

<?php get_header(); ?>

<script>
    /* Hide the language selector during the course, because switching wipes out the group key. */
    jQuery(document).ready(function() {
        jQuery('#lang_choice_1').hide();
    })
</script>
<div id="content" class="max-content-width">
    <div id="inner-content" class="grid-x grid-margin-x">
        <div id="main" class="large-12 cell" role="main">

            <?php Zume_Course_Content::get_course_content( $session_id ); ?>

        </div> <!-- end #main -->
    </div> <!-- end #inner-content -->
</div><!-- end #content -->

<?php get_footer(); ?>
