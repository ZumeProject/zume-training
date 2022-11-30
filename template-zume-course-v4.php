<?php
/*
Template Name: Zúme Course v4
*/

$session_id = 1;
if ( isset( $_GET['session'] ) ) {
    $session_id = sanitize_text_field( wp_unslash( $_GET['session'] ) );
}
$group = false;
$members = 1;
if ( isset( $_GET['group'] ) ) {
    $foreign_key = sanitize_text_field( wp_unslash( $_GET['group'] ) );
    $group = Zume_V4_Groups::get_group_by_foreign_key( $foreign_key );
    if ( empty( $group ) || ! isset( $group['key'] ) ) {
        dt_write_log( 'Failed to find group for key '. $foreign_key );
    }
    if ( ! Zume_V4_Groups::update_group_session_status( $group['key'], $session_id ) ) {
        dt_write_log( 'Failed to update session for '. $group['key'] );
    }

    $members = $group['members'] ?? 1;
}

?>

<?php get_header(); ?>

<?php do_action( 'zume_movement_log_course', [
    'language' => zume_current_language(),
    'session' => $session_id,
    'members' => $members
] ) ?>

<script>
    /* Hide the language selector during the course, because switching wipes out the group key. */
    jQuery(document).ready(function() {
        expand_course()
    })
    function collapse_course() {
        jQuery('#collapse-course').remove()
        jQuery('#expand-course').remove()
        jQuery('.top-bar').show();
        jQuery('.source-org').show();
        jQuery('#top-lang-div').html(`<div id="expand-course"><i class="fi-arrows-expand" id="hide-course-top-bar" onclick="expand_course()"></i></div>`)
    }
    function expand_course() {
        jQuery('#collapse-course').remove()
        jQuery('#expand-course').remove()
        jQuery('.top-bar').hide();
        jQuery('.source-org').hide();
        jQuery('body').append(`<div id="collapse-course"><i class="fi-arrows-compress" id="hide-course-top-bar" onclick="collapse_course()"></i></div>`)
    }

</script>
<style>
    #collapse-course {
        position: absolute;
        top: 10px;
        right: 20px;
        z-index: 100;
    }
</style>
<div id="content" class="max-content-width">
    <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">
        <div id="main" class="large-12 cell" role="main">

            <?php Zume_Course_Content::get_course_content( $session_id ); ?>

        </div> <!-- end #main -->
    </div> <!-- end #inner-content -->
</div><!-- end #content -->

<?php get_footer(); ?>
