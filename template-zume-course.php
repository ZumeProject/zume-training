<?php
/*
Template Name: Zúme Course
*/
zume_force_login();

if ( empty( $_GET['group'] ) || empty( $_GET['session'] ) ) {
    wp_die( esc_html__( 'You are missing a group or session number.', 'zume' ) . '<a href="'. esc_url( zume_dashboard_url() ) .'">' . esc_html__( 'Head back to your dashboard', 'zume' ) . '</a>' );
}
if ( isset( $_POST['viewing'] ) && isset( $_POST['zume_course_nonce'] ) && ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['zume_course_nonce'] ) ), 'zume_course_action' ) ) {
    wp_die( esc_html__( 'You do not have a valid nonce. Where did you come from? ', 'zume' ) . '<a href="'. esc_url( zume_dashboard_url() ) .'"> ' . esc_html__( 'Head back to your dashboard', 'zume' ) . '</a>' );
}
$zume_group_key = sanitize_key( wp_unslash( $_GET['group'] ) );
$zume_session   = sanitize_key( wp_unslash( $_GET['session'] ) );

// verify permissions to represent group
$zume_current_user = get_user_by( 'id', get_current_user_id() );
$zume_user_meta    = zume_get_user_meta( $zume_current_user->ID );
$zume_current_user_email = $zume_current_user->user_email;
$zume_group_meta = Zume_Dashboard::get_group_by_key( $zume_group_key );

if ( ! $zume_group_meta ) {
    wp_die( esc_html__( 'Cannot find this group.', 'zume' ) . '<a href="'. esc_url( zume_dashboard_url() ) .'">' . esc_html__( 'Head back to your dashboard and try again', 'zume' ) . '</a>' );
}
if ( ! isset( $zume_user_meta[ $zume_group_key ] ) ) { // check if owner of group
    if ( ! in_array( $zume_current_user_email, $zume_group_meta['coleaders'] ) ) { // if current_user is not a coleader
        wp_die( esc_html__( 'You are missing a correct group or session number.', 'zume' ) . ' <a href="'. esc_url( zume_dashboard_url() ).'">' . esc_html__( 'Head back to your dashboard', 'zume' ) . '</a>' );
    }
}

get_header();

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


                isset( $_POST['viewing'] ) ? $zume_isset_viewing = true : $zume_isset_viewing = false;
                if ( esc_attr( $zume_isset_viewing ) ) { // check if member check is complete

                    $zume_viewing = sanitize_key( wp_unslash( $_POST['viewing'] ) );
                    if ( isset( $_POST['members'] ) ) {
                        $zume_members = sanitize_key( wp_unslash( $_POST['members'] ) );
                    }
                    switch ( $zume_viewing ) {
                        case 'group':
                            Zume_Course::update_session_complete( $zume_group_key, $zume_session, $zume_group_meta['owner'] );
                            Zume_Course_Content::get_course_content( $zume_session );
                            Zume_Dashboard::update_ip_address( $zume_group_key );

                            zume_insert_log( [
                                'user_id'  => get_current_user_id(),
                                'group_id' => $zume_group_key,
                                'page'     => 'course',
                                'action'   => 'session_' . $zume_session,
                                'meta'     => 'group_' . $zume_members,
                            ] );

                            do_action( 'zume_session_complete', $zume_group_key, $zume_session, $zume_group_meta['owner'], get_current_user_id() );

                            break;
                        case 'explore':
                            Zume_Course_Content::get_course_content( $zume_session );
                            zume_insert_log( [
                                'user_id'  => get_current_user_id(),
                                'group_id' => $zume_group_key,
                                'page'     => 'course',
                                'action'   => 'session_' . $zume_session,
                                'meta'     => 'explore',
                            ] );
                            break;
                        default:
                            wp_die( esc_html__( 'You need a correctly formatted URL. This can happen if you came here from somewhere other than the dashboard.', 'zume' ) . ' <a href="/">' . esc_html__( 'Head back to your dashboard and try again.', 'zume' ) . '</a>' );
                            break;
                    }
                } else {
                    Zume_Course_Content::course_start_panel( $zume_session, $zume_group_meta );
                }

                ?>

            </div> <!-- end #main -->
        </div> <!-- end #inner-content -->
    </div><!-- end #content -->

<?php get_footer(); ?>