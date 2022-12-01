<?php
// @todo remove
/*
Template Name: Zúme Dashboard
*/
zume_force_login();


if ( ! empty( $_POST ) ) { // test if post submitted
    // validate nonce
//    dt_write_log( $_POST );
    if ( isset( $_POST['zume_nonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['zume_nonce'] ) ), get_current_user_id() ) ) { // verify that the form came from this page
        // remove excess nonce elements
        if ( isset( $_POST['zume_nonce'] ) ) {
            unset( $_POST['zume_nonce'] );
        }
        if ( isset( $_POST['_wp_http_referer'] ) ) {
            unset( $_POST['_wp_http_referer'] );
        }

        // handle post
        if ( isset( $_POST['type'] ) ) { // group submissions
            if ( ! empty( $_POST['type'] ) && $_POST['type'] == 'create' ) { // create group
                Zume_Dashboard::create_group( $_POST );
            } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'edit' ) { // edit group
                Zume_Dashboard::edit_group( $_POST );
            } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'closed' && isset( $_POST['key'] ) ) { // close group
                Zume_Dashboard::closed_group( sanitize_key( wp_unslash( $_POST['key'] ) ) );
            } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'delete' && isset( $_POST['key'] ) ) { // delete group
                Zume_Dashboard::delete_group( sanitize_key( wp_unslash( $_POST['key'] ) ) );
            } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'activate' && isset( $_POST['key'] ) ) { // re-activate group
                Zume_Dashboard::activate_group( sanitize_key( wp_unslash( $_POST['key'] ) ) );
            } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'coleader' ) { // coleader response
                Zume_Dashboard::coleader_invitation_response( $_POST );
            } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'remove' ) { // coleader response
                $zume_user = get_user_by( 'id', get_current_user_id() );
                if ( ! empty( $zume_user ) && isset( $_POST['key'] ) && isset( $_POST['owner'] ) ) {
                    Zume_Dashboard::delete_coleader( $zume_user->user_email, sanitize_key( wp_unslash( $_POST['key'] ) ), sanitize_key( wp_unslash( $_POST['owner'] ) ) );
                }
            } else {
                dt_write_log( 'Failed to filter' );
            }
        }
    } // endif nonce
    wp_redirect( zume_dashboard_url() );
}

get_header();

$zume_user = wp_get_current_user();
$zume_user_meta = zume_get_user_meta( $zume_user->ID );
$zume_highest_session = Zume_Dashboard::get_highest_session( $zume_user->ID );
update_user_meta( get_current_user_id(), 'zume_language', zume_current_language() );

do_action( 'zume_dashboard_header' );
?>

    <script type="application/javascript">
        var load_iframe = function (id, src) {
            jQuery("#video-display" + " iframe").attr("src", src)
        }
        var end_video_play = function (id) {
            jQuery("#" + id + " iframe").attr("src", '')
        }

    </script>
    <div id="content">

        <div id="inner-content" class="grid-x grid-margin-x grid-padding-x">

            <div id="main" class="cell" role="main">

                <div class="grid-x" id="test-eq">
                    <div class="large-1 cell"></div>

                    <!-- Left Column -->
                    <div class="large-8 cell">

                        <!-- ********************************************************************************************* -->
                        <!-- Groups Management Section -->
                        <!-- ********************************************************************************************* -->
                        <div class="callout">
                            <ul id="groups-list" class="item-list">
                                <li class="block">
                                    <h2 class="center"><?php echo esc_html__( 'Your Groups', 'zume' ) ?></h2>
                                </li>

                                <?php
                                /**
                                 * Groups
                                 */
                                $zume_no_groups = 0;
                                $zume_archived_groups = array();

                                // add colead groups to array
                                $zume_colead_groups = Zume_Dashboard::get_colead_groups();
                                foreach ( $zume_colead_groups as $zume_colead_key => $zume_colead_value ) {
                                    $zume_user_meta[ $zume_colead_key ] = $zume_colead_value;
                                }

                                foreach ( $zume_user_meta as $zume_key => $v ) {
                                    $zume_key_beginning = substr( $zume_key, 0, 10 );
                                    if ( 'zume_group' == $zume_key_beginning ) { // check if zume_group
                                        $zume_value = Zume_Dashboard::verify_group_array_filter( $v );

                                        if ( isset( $zume_value['closed'] ) && false == $zume_value['closed'] ) : // check if closed

                                            ?>
                                            <!-- Group Row -->
                                            <li class="block">
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell large-6 <?php if ( isset( $zume_value['no_edit'] ) ) { echo 'coleader-group'; } ?>" >

                                                            <span class="group-title"><a
                                                                        data-open="<?php echo esc_html( $zume_key ); ?>"><?php echo esc_html( $zume_value['group_name'] ) ?></a></span>&nbsp;

                                                            <?php if ( isset( $zume_value['no_edit'] ) ) : ?>
                                                                <button class="small"
                                                                        data-open="<?php echo esc_html( $zume_key ); ?>"
                                                                        style="opacity: .5;">
                                                                    <i class="fi-eye hollow"></i> <?php echo esc_html__( 'view', 'zume' ) ?>
                                                                </button>
                                                            <?php else : ?>
                                                                <button class="small"
                                                                        data-open="<?php echo esc_html( $zume_key ); ?>"
                                                                        style="opacity: .5;">
                                                                    <i class="fi-pencil hollow"></i> <?php echo esc_html__( 'edit', 'zume' ) ?>
                                                                </button>
                                                        <?php endif; ?>

                                                        <p class="text-gray">
                                                            <?php echo esc_html( __( 'Meeting Time', 'zume' ) . ": " . $zume_value['meeting_time'] ) ?>
                                                            <br>
                                                            <?php echo esc_html( __( 'Address', 'zume' ) . ': ' . $zume_value['address'] ) ?>
                                                            <br>
                                                            <?php echo esc_html( __( 'Members', 'zume' ) . ': ' . $zume_value['members'] ) ?>
                                                            <?php if ( ! isset( $zume_value['no_edit'] ) ) : ?>
                                                                <br>
                                                                <?php echo esc_html( __( 'Key', 'zume' ) . ':' ) ?> <span class="<?php echo esc_html( $zume_key ); ?>_public_key"><?php echo esc_attr( $zume_value['public_key'] ) ?></span>
                                                            <?php endif; ?>
                                                        </p>

                                                    </div>
                                                    <div class="large-6 cell" style="min-width:350px;">
                                                        <ul class="pagination" role="navigation"
                                                            aria-label="Pagination">
                                                            <li class="<?php echo $zume_value['session_1'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=1' ); ?>">1</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_2'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=2' ); ?>">2</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_3'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=3' ); ?>">3</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_4'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=4' ); ?>">4</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_5'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=5' ); ?>">5</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_6'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=6' ); ?>">6</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_7'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=7' ); ?>">7</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_8'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=8' ); ?>">8</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_9'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=9' ); ?>">9</a>
                                                            </li>
                                                            <li class="<?php echo $zume_value['session_10'] == 'true' ? esc_html( 'current' ) : ''; ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=10' ); ?>">10</a>
                                                            </li>
                                                        </ul>

                                                        <!-- Next Session Button -->
                                                        <?php if ( ! ( 0 == $zume_value['next_session'] || 11 == $zume_value['next_session'] ) ) : ?>
                                                            <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=' . $zume_value['next_session'] ); ?>"
                                                               class="button large">
                                                                <?php echo esc_html( __( 'Start Next Session ', 'zume' ) . $zume_value['next_session'] ); ?>
                                                            </a>
                                                        <?php else : ?>
                                                            <!-- Close group button -->
                                                            <?php if ( ! isset( $zume_value['no_edit'] ) ) : ?>
                                                                <form method="post" id="close-group-button">
                                                                    <?php wp_nonce_field( get_current_user_id(), 'zume_nonce' ) ?>
                                                                    <input type="hidden" name="key"
                                                                           value="<?php echo esc_html( $zume_key ); ?>"/>
                                                                    <span><button type="submit"
                                                                                  class="button hollow alert"
                                                                                  name="type"
                                                                                  value="closed"><?php echo esc_html__( 'Archive Group', 'zume' ) ?></button></span>
                                                                </form>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                            $zume_no_groups++;
                                        else :
                                            $zume_archived_groups[ $zume_key ] = $zume_value; // add archived groups to array for use in the archive section
                                        endif; // end if closed check
                                    } // end check if zume_group
                                }
                                ?>

                                <?php
                                /***********************************************************************************************
                                 * COLEADER REQUESTS SECTION
                                 **********************************************************************************************/
                                $zume_waiting_acceptance = Zume_Dashboard::get_colead_groups( 'waiting_acceptance' );

                                if ( count( $zume_waiting_acceptance ) > 0 ) :
                                    ?>
                                    <form method="post">
                                        <?php wp_nonce_field( get_current_user_id(), 'zume_nonce' ) ?>
                                        <input type="hidden" name="type" value="coleader"/>

                                        <div class="grid-x grid-padding-y">
                                            <?php
                                            foreach ( $zume_waiting_acceptance as $zume_accept_key => $zume_accept_value ) {
                                                ?>
                                                <div class="cell session-boxes">
                                                    <p class="center">
                                                        <strong><?php $zume_group_owner = get_user_by( 'id', $zume_accept_value['owner'] );
                                                            echo esc_attr( $zume_group_owner->display_name ) ?></strong> <?php esc_attr_e( 'invites you to join', 'zume' ) ?>
                                                        <strong><?php echo esc_attr( $zume_accept_value['group_name'] ) ?></strong>
                                                    </p><br>

                                                    <p class="center">
                                                        <button class="button" type="submit" name="accept"
                                                                value="<?php echo esc_attr( $zume_accept_key ) ?>"><?php esc_attr_e( 'Accept', 'zume' ) ?></button>
                                                        <button class="button" type="submit" name="decline"
                                                                value="<?php echo esc_attr( $zume_accept_key ) ?>"><?php esc_attr_e( 'Decline', 'zume' ) ?></button>
                                                    </p>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </form>
                                    <?php
                                endif; // end waiting acceptance if
                                /* END COLEADER REQUESTS */
                                ?>


                                <!-- Message if there are no groups -->
                                <?php if ( $zume_no_groups < 1 ) : ?>
                                    <div class="grid-x grid-margin-x vertical-padding">
                                        <div class="large-8 large-offset-2 cell center">
                                            <h4>
                                                <strong><?php echo esc_html__( 'You have no active groups', 'zume' ) ?></strong>
                                            </h4>
                                            <p><?php esc_html_e( "We recommend at least 3-11 people for a group.", 'zume' ) ?></p>
                                            <p><?php esc_html_e( "You can join a current group when the group owner adds your email to the approved coleader/participant list. To start your own group, use the button below.", 'zume' ) ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>


                                <p class="center vertical-padding">
                                    <button class="button hollow small"
                                            data-open="create"><?php echo esc_html__( 'Start New Group', 'zume' ) ?></button>
                                </p>
                        </div>


                        <!-- ********************************************************************************************* -->
                        <!-- VIDEOS SECTION -->
                        <!-- ********************************************************************************************* -->
                        <div class="callout">
                            <!-- Section top -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell">
                                    <h3 class="center padding-bottom"><?php esc_html_e( 'Video Library', 'zume' ) ?></h3>
                                    <span class="x-small center float-right"><?php Zume_Dashboard::get_available_videos_count( $zume_highest_session ); ?> <?php esc_html_e( 'of 32 videos', 'zume' ) ?></span>
                                    <hr>
                                    <div class="grid-x grid-margin-x"> <!-- Begin columns container -->
                                        <?php
                                        $zume_videos = array(
                                            array(
                                        "name" => esc_html__( 'Overview Video', 'zume' ),
                                        "length" => "(2:07)",
                                        "key" => "31",
                                        "session" => -1,
                                        "title" => 0,
                                        "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'How Zúme Works', 'zume' ),
                                            "length" => "(3:22)",
                                            "key" => "32",
                                            "session" => -1,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 1', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 1,
                                            "title" => 1,
                                            "column" => 1
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Welcome to Zume', 'zume' ),
                                            "length" => "(3:07)",
                                            "key" => "1",
                                            "session" => 1,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'Teach Them to Obey', 'zume' ),
                                            "length" => "(4:01)",
                                            "key" => "2",
                                            "session" => 1,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'Spiritual Breathing', 'zume' ),
                                            "length" => "(5:46)",
                                            "key" => "3",
                                            "session" => 1,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'S.O.A.P.S Bible Reading', 'zume' ),
                                            "length" => "(3:22)",
                                            "key" => "4",
                                            "session" => 1,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'Accountability Groups', 'zume' ),
                                            "length" => "(1:10)",
                                            "key" => "5",
                                            "session" => 1,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 2', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 2,
                                            "title" => 1,
                                            "column" => 1
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Producers vs Consumers', 'zume' ),
                                            "length" => "(5:33)",
                                            "key" => "6",
                                            "session" => 2,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'Prayer Cycle', 'zume' ),
                                            "length" => "(1:10)",
                                            "key" => "7",
                                            "session" => 2,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'List of 100', 'zume' ),
                                            "length" => "(1:04)",
                                            "key" => "8",
                                            "session" => 2,
                                            "title" => 0,
                                            "column" => 1
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 3', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 3,
                                            "title" => 1,
                                            "column" => 2
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Spiritual Economy', 'zume' ),
                                            "length" => "(2:32)",
                                            "key" => "9",
                                            "session" => 3,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'The Gospel', 'zume' ),
                                            "length" => "(4:41)",
                                            "key" => "10",
                                            "session" => 3,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Baptism', 'zume' ),
                                            "length" => "(3:22)",
                                            "key" => "11",
                                            "session" => 3,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 4', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 4,
                                            "title" => 1,
                                            "column" => 2
                                            ), // title
                                            array(
                                            "name" => esc_html__( '3 Minute Testimony', 'zume' ),
                                            "length" => "(2:26)",
                                            "key" => "12",
                                            "session" => 4,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Greatest Blessing', 'zume' ),
                                            "length" => "(2:26)",
                                            "key" => "13",
                                            "session" => 4,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Duckling Discipleship', 'zume' ),
                                            "length" => "(3:29)",
                                            "key" => "14",
                                            "session" => 4,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Eyes to See', 'zume' ),
                                            "length" => "(6:08)",
                                            "key" => "15",
                                            "session" => 4,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Lord\'s Supper', 'zume' ),
                                            "length" => "(1:54)",
                                            "key" => "16",
                                            "session" => 4,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 5', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 5,
                                            "title" => 1,
                                            "column" => 2
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Prayer Walking', 'zume' ),
                                            "length" => "(5:05)",
                                            "key" => "17",
                                            "session" => 5,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Person of Peace', 'zume' ),
                                            "length" => "(5:45)",
                                            "key" => "18",
                                            "session" => 5,
                                            "title" => 0,
                                            "column" => 2
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 6', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 6,
                                            "title" => 1,
                                            "column" => 3
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Faithfulness', 'zume' ),
                                            "length" => "(2:35)",
                                            "key" => "19",
                                            "session" => 6,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( '3/3 Group', 'zume' ),
                                            "length" => "(3:28)",
                                            "key" => "20",
                                            "session" => 6,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( '3/3 Group Live', 'zume' ),
                                            "length" => "(1:19:00)",
                                            "key" => "21",
                                            "session" => 6,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 7', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 7,
                                            "title" => 1,
                                            "column" => 3
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Training Cycle', 'zume' ),
                                            "length" => "(4:12)",
                                            "key" => "22",
                                            "session" => 7,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 8', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 8,
                                            "title" => 1,
                                            "column" => 3
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Leadership Cells', 'zume' ),
                                            "length" => "(2:22)",
                                            "key" => "23",
                                            "session" => 8,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 9', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 9,
                                            "title" => 1,
                                            "column" => 3
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Non-Sequential', 'zume' ),
                                            "length" => "(3:58)",
                                            "key" => "24",
                                            "session" => 9,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Pace', 'zume' ),
                                            "length" => "(2:53)",
                                            "key" => "25",
                                            "session" => 9,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Part of Two Churches', 'zume' ),
                                            "length" => "(3:55)",
                                            "key" => "26",
                                            "session" => 9,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Completion of Training', 'zume' ),
                                            "length" => "(2:35)",
                                            "key" => "27",
                                            "session" => 9,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Session 10', 'zume' ),
                                            "length" => "",
                                            "key" => "",
                                            "session" => 10,
                                            "title" => 1,
                                            "column" => 3
                                            ), // title
                                            array(
                                            "name" => esc_html__( 'Coaching Checklist', 'zume' ),
                                            "length" => "(1:22)",
                                            "key" => "28",
                                            "session" => 10,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Leadership in Networks', 'zume' ),
                                            "length" => "(4:26)",
                                            "key" => "29",
                                            "session" => 10,
                                            "title" => 0,
                                            "column" => 3
                                            ),
                                            array(
                                            "name" => esc_html__( 'Peer Mentoring', 'zume' ),
                                            "length" => "(4:15)",
                                            "key" => "30",
                                            "session" => 10,
                                            "title" => 0,
                                            "column" => 3
                                            ),

                                        );
                                        $zume_display_video_section = function ( $zume_video, $zume_highest_session ) {
                                            if ( $zume_highest_session > $zume_video["session"] && ! $zume_video["title"] ) {
                                                ?>
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="video-display"
                                                           onclick="load_iframe( 'video-display', '<?php echo esc_url( Zume_Course::get_video_by_key( $zume_video["key"] ) ) ?>')">
                                                            <i class="fi-play-circle secondary-color"></i>
                                                            <?php echo esc_html( $zume_video["name"] ) ?> <?php echo esc_html( $zume_video["length"] ) ?>
                                                        </a>
                                                    </div>
                                                </div>

                                            <?php } elseif ( $zume_highest_session > $zume_video["session"] && $zume_video["title"] ) { // adds titles
                                                ?>
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <?php echo esc_attr( $zume_video["name"] ) ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                        }; // end function ?>
                                        <div class="medium-4 cell">
                                            <?php
                                            foreach ( $zume_videos as $video ) {
                                                if ( $video["column"] == 1 ) {
                                                    $zume_display_video_section( $video, $zume_highest_session );
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="medium-4 cell">
                                            <?php
                                            foreach ( $zume_videos as $video ) {
                                                if ( $video["column"] == 2 ) {
                                                    $zume_display_video_section( $video, $zume_highest_session );
                                                }
                                            }
                                            ?>
                                        </div>
                                        <div class="medium-4 cell">
                                            <?php
                                            foreach ( $zume_videos as $video ) {
                                                if ( $video["column"] == 3 ) {
                                                    $zume_display_video_section( $video, $zume_highest_session );
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div> <!-- end columns container -->

                                    <div class="small reveal" id="video-display" data-reveal>
                                        <br>
                                        <iframe frameborder="0"
                                                width="100%" height="315"
                                                webkitallowfullscreen mozallowfullscreen
                                                allowfullscreen></iframe>
                                        <button class="close-button" data-close aria-label="Close reveal"
                                                type="button" onclick="end_video_play( 'video-display' )">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <?php if ( $zume_highest_session < 2 ) { ?>
                                        <div class="grid-x grid-margin-x grid-margin-y">
                                            <div class="cell large-3"></div>
                                            <div class="cell large-6 small text-gray">
                                                <?php esc_html_e( 'Session videos will be added as you complete sessions.', 'zume' ) ?>
                                            </div>
                                            <div class="cell large-3"></div>
                                        </div>
                                    <?php } ?>
                                </div> <!-- end container cell-->
                            </div> <!-- end grid container-->
                            <!--end bottom section-->

                        </div> <!-- end call out-->
                        <!--END VIDEO SECTION -->


                        <?php
                        /***********************************************************************************************
                         * Begin Inactive Groups Section
                         ***********************************************************************************************/
                        if ( ! empty( $zume_archived_groups ) ) : ?>
                            <div class="callout" id="archived">
                                <div class="grid-x ">
                                    <div class="cell vertical-padding center">
                                        <h3><?php echo esc_html__( 'Archived Groups', 'zume' ) ?></h3>
                                        <hr>
                                    </div>
                                </div>

                                <form action="" method="post">
                                    <?php wp_nonce_field( get_current_user_id(), 'zume_nonce' ) ?>
                                    <input type="hidden" name="type" value="activate"/>

                                    <?php foreach ( $zume_archived_groups as $zume_archive_key => $zume_archive_value ) : ?>
                                        <div class="grid-x grid-margin-x gr">
                                            <div class="small-8 cell">
                                                <?php echo esc_html( $zume_archive_value['group_name'] ) ?>
                                            </div>
                                            <?php if ( ! isset( $zume_archive_value['no_edit'] ) ) : ?>
                                            <div class="small-3 cell ">
                                                <button class="small button float-right" type="submit" name="key" value="<?php echo esc_attr( $zume_archive_key ) ?>"><?php esc_html_e( 'activate', 'zume' ) ?></button>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </form>
                            </div>
                        <?php endif; // end if there are archived groups
                        //<!-- End Inactive Groups Section -->
                        ?>

                    </div> <!-- End Left Column -->


                    <!-- Right Column -->
                    <div class="large-2 cell dashboard-messages">


                        <?php
                        /***********************************************************************************************
                         * WELCOME SECTION
                         **********************************************************************************************/
                        $zume_message = [
                            'title' => __( 'Welcome!', 'zume' ),
                            'message' => __( 'I want to make disciples who multiply!', 'zume' )
                        ];
                        ?>
                        <div class="callout show-for-large hide-for-small">

                            <!-- Encouragement message -->
                            <div class="grid-x">
                                <div class="cell center">
                                    <p class="center padding-bottom">
                                        <strong>
                                            <?php isset( $zume_message['title'] ) ? print esc_attr( $zume_message['title'] ) : print ''; ?>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                            <div class="grid-x">
                                <div class="cell small">
                                    <?php isset( $zume_message['message'] ) ? print esc_attr( $zume_message['message'] ) : print ''; ?>
                                </div>
                            </div>

                        </div>
                        <!-- END INSTRUCTIONS -->



                        <!-- ********************************************************************************************* -->
                        <!-- REQUEST COACHING -->
                        <!-- ********************************************************************************************* -->
                        <div class="grid-x grid-margin-x">
                            <div class="cell center">
                                <button class="button expanded" data-open="new-registration-tour">
                                    <?php esc_html_e( 'Get a Coach', 'zume' ) ?>
                                </button>
                            </div>
                        </div>
                        <!-- END REQUEST COACHING -->

                        <!-- ********************************************************************************************* -->
                        <!-- INVITE TO ZUME -->
                        <!-- ********************************************************************************************* -->
                        <div class="grid-x grid-margin-x">
                            <div class="cell center">
                                <a class="button expanded"
                                   href="mailto:?subject=<?php esc_attr_e( 'Join me on the Zúme Project' ) ?>&body=<?php esc_attr_e( 'Join me on the Zúme Project' ) ?>: <?php echo esc_url( site_url( '/' ) ) ?>">
                                    <?php esc_html_e( 'Invite to Zúme', 'zume' ) ?>
                                </a>
                            </div>
                        </div>
                        <!-- END INSTRUCTIONS -->

                        <!-- ********************************************************************************************* -->
                        <!-- DOWNLOAD GUIDEBOOK -->
                        <!-- ********************************************************************************************* -->
                        <div class="grid-x grid-margin-x">
                            <div class="cell center">
                                <a class="button expanded"
                                   href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                                   target="_blank" rel="noopener" download>
                                    <?php esc_html_e( 'Download Guidebook', 'zume' ) ?>
                                </a>
                            </div>
                        </div>
                        <!-- END INSTRUCTIONS -->

                        <?php
                        /***********************************************************************************************
                         * THREE MONTH PLAN
                         **********************************************************************************************/
                        $zume_three_month_plan = zume_three_month_plan_url();
                        if ( ! empty( $zume_three_month_plan ) ) :
                            ?>
                        <div class="grid-x grid-margin-x">
                            <div class="cell center">
                                <a class="button expanded"
                                   href="<?php echo esc_url( $zume_three_month_plan ) ?>" >
                                    <?php esc_html_e( 'Three Month Plan', 'zume' ) ?>
                                </a>
                            </div>
                        </div>
                        <!-- THREE MONTH PLAN -->
                        <?php endif; ?>

                        <?php
                        /***********************************************************************************************
                         * LINK TO ARCHIVES
                         **********************************************************************************************/
                        if ( ! empty( $zume_archived_groups ) ) : ?>
                            <div class="grid-x grid-margin-x">
                                <div class="cell center">
                                    <a class="small" href="#archived"  data-smooth-scroll>
                                        <?php esc_html_e( 'Archived Groups', 'zume' ); echo ' (' . count( $zume_archived_groups ) . ')' ?>
                                    </a>
                                </div>
                            </div>
                            <!-- THREE MONTH PLAN -->
                        <?php endif; ?>



                        <?php
                        /***********************************************************************************************
                         * NETWORKS SECTION
                         **********************************************************************************************/
                        $zume_user_sites = get_blogs_of_user( get_current_user_id() );
                        unset( $zume_user_sites[1] );

                        if ( ! empty( $zume_user_sites ) ) :
                            ?>
                            <div class="callout">
                                <div class="grid-x">
                                    <div class="cell center">
                                        <strong><?php echo esc_html__( 'Networks', 'zume' ) ?></strong>
                                    </div>
                                </div>

                                <div class="grid-x grid-margin-x grid-padding-y">
                                    <div class="small-9 cell">
                                        <ul style="list-style-type: none;">
                                            <?php
                                            $ordered_sites = array();
                                            foreach ($zume_user_sites as $key => $value) {
                                                $ordered_sites[$value->blogname] = $value->siteurl;
                                            }
                                            ksort( $ordered_sites );

                                            foreach ($ordered_sites as $sitename => $siteurl ) {
                                                echo '<li><a href="' . esc_url( $siteurl ) . '" target="_blank" rel="noopener">'. esc_html( $sitename ) .'</a></li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>

                    </div> <!-- End Right Column -->

                    <div class="large-1 cell"></div>

                </div>

            </div>

        </div>

    </div> <!-- Cell div -->

    <!-- ********************************************************************************************* -->
    <!-- Create a New Group Modal -->
    <!-- ********************************************************************************************* -->
    <div class="small reveal" id="create" data-reveal>
        <h1><?php echo esc_html__( 'Create Group', 'zume' ) ?></h1>
        <form action="" method="post" class="submit-new-form">
            <?php wp_nonce_field( get_current_user_id(), 'zume_nonce' ) ?>
            <input type="hidden" name="type" value="create"/>
            <input type="hidden" name="ip_address"
                   value="<?php echo esc_html( DT_Ipstack_API::get_real_ip_address() ); ?>"/>
            <div class="grid-x grid-margin-x">
                <!--Group Name-->
                <div class="cell">
                    <label for="group_name"><?php echo esc_html__( 'Group Name', 'zume' ) ?></label>
                    <input type="text" value="" name="group_name" id="group_name" required/>
                </div>

                <!-- Number of group members -->
                <div class="cell">
                    <label for="members"><?php echo esc_html__( 'Number of Group Members (including you)', 'zume' ) ?></label>
                    <select name="members" id="members" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                    </select>
                </div>

                <!-- Planned Meeting Time -->
                <div class="cell padding-top" style="padding-top: .8em;">
                    <label for="meeting_time"><?php echo esc_html__( 'Planned Meeting Time', 'zume' ) ?></label>
                    <input placeholder="<?php esc_attr_e( 'example: Saturday 7PM', 'zume' ) ?>"
                           type="text" value="" name="meeting_time" id="meeting_time" required/>
                </div>

                <!-- New Address -->
                <div class="cell">
                    <label for="validate_addressnew"><?php echo esc_html__( 'Address', 'zume' ) ?></label>
                    <div class="input-group">
                        <input type="text"
                               placeholder="example: 1000 Broadway, Denver, CO 80126"
                               class="profile-input input-group-field"
                               name="validate_address"
                               id="validate_addressnew"
                               value=""
                        />
                        <div class="input-group-button">
                            <input type="button" class="button"
                                   onclick="validate_group_address( jQuery('#validate_addressnew').val(), 'new')"
                                   value="<?php echo esc_html__( 'Validate', 'zume' ) ?>"
                                   id="validate_address_buttonnew">
                        </div>
                    </div>

                    <div id="possible-resultsnew">
                        <input type="hidden" name="address" id="address_new" value=""/>
                    </div>

                </div>
                <script>
                    jQuery('#validate_addressnew').keyup(function () {
                        check_address('new')
                    });
                </script>


                <!-- Add coleaders -->
                <div class="cell padding-top">
                    <label for="add_coleader"><strong><?php echo esc_html__( 'Coleaders or additional participants', 'zume' ) ?></strong></label>
                    <p class="small text-gray"><?php esc_attr( 'Adding a coleader or additional participant below gives that individual\'s Zúme dashboard access to the group after they accept the invitation. They can facilitate a training, but cannot change any details of the group.', 'zume' ) ?></p>


                    <span id="create_coleader"></span>

                    <button type="button" class="button clear"
                            onclick="create_coleader('create_coleader')"><i
                                class="fi-plus"></i> <?php esc_attr_e( 'Add', 'zume' ) ?></button>

                </div>

                <div class="cell">
                    <br>
                    <button type="submit" class="button"
                            id="submit_new"><?php echo esc_html__( 'Submit', 'zume' ) ?></button>
                </div>
            </div>

            <button class="close-button" data-close aria-label="Close modal" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
        </form>
    </div>

    <!-- ********************************************************************************************* -->
    <!-- GROUP MODAL BOXES SECTION -->
    <!-- ********************************************************************************************* -->
<?php
$zume_user_meta = zume_get_user_meta( $zume_user->ID ); // reset variable without coleader data
foreach ( $zume_user_meta as $zume_key => $v ) {
    $zume_key_beginning = substr( $zume_key, 0, 10 );
    if ( 'zume_group' == $zume_key_beginning ) {
        $zume_value = maybe_unserialize( $v );
        ?>

        <!-- Edit current groups section -->
        <div class="small reveal" id="<?php echo esc_html( $zume_key ); ?>" data-reveal>
            <form data-abide method="post">
                <?php wp_nonce_field( get_current_user_id(), 'zume_nonce' ) ?>
                <h1><?php echo esc_html__( 'Edit Group', 'zume' ) ?></h1>
                <p><?php esc_html_e('You are the owner of this group. All changes to the group details must be done through
                you.', 'zume') ?></p>
                <hr>

                <input type="hidden" name="key" value="<?php echo esc_html( $zume_key ); ?>"/>

                <div class="grid-x">
                    <!-- Group Public Key -->
                    <div class="cell public_key">
                        <p><strong><?php echo esc_html__( 'Key', 'zume' ) ?>:
                            </strong> <span class="<?php echo esc_html( $zume_key ); ?>_public_key">
                                <?php echo esc_html( $zume_value['public_key'] ); ?>
                            </span>
                            <span class="public_key_change" style="display:none">
                                <a class="small" onclick="change_group_key('<?php echo esc_html( $zume_key ); ?>')">
                                    <?php esc_html_e( 'Change Key', 'zume' ) ?>
                                </a></span></p>
                    </div>
                    <!-- Group name -->
                    <div class="cell">
                        <label for="group_name"><strong><?php echo esc_html__( 'Group Name', 'zume' ) ?></strong></label>
                        <input type="text" value="<?php echo esc_html( $zume_value['group_name'] ); ?>"
                               name="group_name" id="group_name" required/>
                    </div>

                    <!-- Participants -->
                    <div class="cell padding-bottom">
                        <label for="members"><strong><?php echo esc_html__( 'Number of Participants', 'zume' ) ?></strong></label>
                        <select name="members" id="members" required>
                            <option value="<?php echo esc_html( $zume_value['members'] ); ?>"><?php echo esc_html( $zume_value['members'] ); ?></option>
                            <option disabled>---</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                        </select>
                    </div>
                    <!-- Meeting Time -->
                    <div class="cell">
                        <label for="meeting_time"><strong><?php echo esc_html__( 'Planned Meeting Time', 'zume' ) ?></strong></label>
                        <input type="text"
                               placeholder="<?php esc_attr_e( 'example: Saturday 7PM', 'zume' ) ?>"
                               value="<?php echo esc_html( $zume_value['meeting_time'] ); ?>"
                               name="meeting_time" id="meeting_time" required/>
                    </div>
                    <!-- Address -->
                    <div class="cell padding-bottom">
                        <label for="validate_address<?php echo esc_html( $zume_key ); ?>"><strong><?php echo esc_html__( 'Address', 'zume' ) ?></strong></label>
                        <div class="input-group">
                            <input type="text"
                                   placeholder="<?php esc_attr_e( 'example: 1000 Broadway, Denver, CO 80126', 'zume' ) ?>"
                                   class="profile-input input-group-field"
                                   name="validate_address"
                                   id="validate_address<?php echo esc_html( $zume_key ); ?>"
                                   value="<?php echo isset( $zume_value['address'] ) ? esc_html( $zume_value['address'] ) : ''; ?>"
                            />
                            <div class="input-group-button">
                                <input type="button" class="button"
                                       onclick="validate_group_address( jQuery('#validate_address<?php echo esc_html( $zume_key ); ?>').val(), '<?php echo esc_html( $zume_key ); ?>')"
                                       value="<?php echo esc_html__( 'Validate', 'zume' ) ?>"
                                       id="validate_address_button<?php echo esc_html( $zume_key ); ?>" >
                            </div>
                        </div>

                        <div id="possible-results<?php echo esc_html( $zume_key ); ?>">
                            <input type="hidden" name="address" id="address_<?php echo esc_html( $zume_key ); ?>"
                                   value="<?php echo isset( $zume_value['address'] ) ? esc_html( $zume_value['address'] ) : ''; ?>"/>
                        </div>

                        <?php if ( ! empty( $zume_value['address'] ) && ! empty( esc_attr( $zume_value['lng'] ) ) && ! empty( esc_attr( $zume_value['lat'] ) ) ) : ?>
                            <div id="map<?php echo esc_html( $zume_key ); ?>">
                                <img src="<?php echo esc_url( DT_Mapbox_API::static_map( $zume_value['lng'], $zume_value['lat'], 7 ) ) ?>"/>
                            </div>
                        <?php endif; ?>

                    </div>

                    <!-- Add coleaders -->
                    <div class="cell padding-top">
                        <label for="add_coleader"><strong><?php echo esc_html__( 'Coleaders or additional participants', 'zume' ) ?></strong></label>
                        <p class="small text-gray">
                            <?php esc_html_e( 'Adding a coleader or additional participants gives them access to this group on their Zúme dashboard once they have signed up and logged in using the email address you add. When they login to their dashboard they will see an invitation from you on the right side of the screen. Adding them to this group allows them to facilitate a training but they cannot change any details of the group. Note: they will not receive a system email from Zúme with this invitation, you will need to ask them to sign up.', 'zume' ) ?>
                        </p>
                        <?php
                        // Print current coleaders
                        if ( isset( $zume_value['coleaders'] ) && ! empty( $zume_value['coleaders'] ) && is_array( $zume_value['coleaders'] ) ) :
                            echo '<ul id="coleaders-ul-' . esc_html( $zume_key ) . '" data-key="' . esc_html( $zume_key ) . '" style="padding: 0 2em;">';
                            $zume_i = 0;
                            foreach ( $zume_value['coleaders'] as $zume_coleader ) {
                                $zume_li_id = $zume_key . $zume_i; // create incrementing id of for each list item.
                                Zume_Dashboard::get_coleader_input( $zume_coleader, $zume_li_id, $zume_key );
                                $zume_i++;
                            } // endforeach
                            echo '</ul>';
                        endif; // if coleader exits
                        ?>

                        <span id="new_coleaders_<?php echo esc_html( $zume_key ); ?>"></span>

                        <button type="button" class="button clear"
                                onclick="add_new_coleader('new_coleaders_<?php echo esc_html( $zume_key ); ?>')"><i
                                    class="fi-plus"></i> <?php esc_attr_e( 'Add', 'zume' ) ?></button>
                    </div>



                    <!-- Update, Delete, Archive buttons -->
                    <div class="cell">
                        <br>
                        <button type="submit" class="button align-left" name="type"
                                onclick="check_address('<?php echo esc_html( $zume_key ); ?>')" value="edit"
                                id="submit_<?php echo esc_html( $zume_key ); ?>"><?php echo esc_html__( 'Update', 'zume' ) ?></button>

                        <span class="align-right"><button type="submit" class="button hollow alert" name="type"
                                                          value="closed"><?php echo esc_html__( 'Archive', 'zume' ) ?></button></span>
                        <span class="align-right"><button type="button" class="button clear alert" name="type"
                                                          data-open="<?php echo esc_html( $zume_key ); ?>-delete"><?php echo esc_html__( 'Delete', 'zume' ) ?></button></span>
                    </div>


                    <script>
                        jQuery('#validate_address<?php echo esc_html( $zume_key ); ?>').keyup(function () {
                            check_address('<?php echo esc_html( $zume_key ); ?>')
                        });
                    </script>


                </div>


                <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </form>
        </div>

        <!-- This is the nested modal -->
        <div class="reveal small" id="<?php echo esc_html( $zume_key ); ?>-delete" data-reveal>
            <form data-abide method="post">
                <?php wp_nonce_field( get_current_user_id(), 'zume_nonce' ) ?>
                <input type="hidden" name="key" value="<?php echo esc_html( $zume_key ); ?>"/>

                <div class="grid-x grid-padding-x">
                    <div class="cell center">
                        <h3><?php esc_attr_e( 'ARE YOU SURE YOU WANT TO DELETE THIS GROUP?', 'zume' ) ?></h3>
                    </div>
                </div>
                <div class="grid-x">
                    <div class="cell center">
                        <span class="center"><button type="submit" class="button alert" name="type"
                                                     value="delete"><?php echo esc_html__( 'Delete', 'zume' ) ?></button></span>
                        <span class="center"><button type="button" class="button hollow" name="type"
                                                     data-open="<?php echo esc_html( $zume_key ); ?>"><?php echo esc_html__( 'Cancel', 'zume' ) ?></button></span>
                    </div>
                </div>

                <button class="close-button" data-close aria-label="Close reveal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </form>
        </div>

        <?php
    }
}
?>

    <!-- ********************************************************************************************* -->
    <!-- GROUP MODAL COLEAD GROUPS SECTION -->
    <!-- ********************************************************************************************* -->
<?php
if ( ! empty( $zume_colead_groups ) ) : // reset variable without coleader data

    foreach ( $zume_colead_groups as $zume_key => $v ) {
        $zume_key_beginning = substr( $zume_key, 0, 10 );
        if ( 'zume_group' == $zume_key_beginning ) {
            $zume_value = maybe_unserialize( $v );
            ?>

            <!-- Edit current groups section -->
            <div class="small reveal" id="<?php echo esc_html( $zume_key ); ?>" data-reveal>
                    <h1><?php echo esc_html__( 'View Group', 'zume' ) ?></h1>

                    <p>
                        <?php esc_html_e( 'You are a participant or coleader of this group and can view the group
                        details and lead the group through a session, but cannot change the details of the group or add
                        participants. Please, make change requests through the group owner.', 'zume' ) ?>
                    </p>
                    <hr>
                    <div class="grid-x">
                        <!-- Group Public Key -->
                        <div class="cell">
                            <dl>
                                <dt><?php echo esc_html__( 'Group Owner', 'zume' ) ?></dt>
                                <dd><?php $zume_owner = get_user_by( 'id', $zume_value['owner'] );
                                echo esc_html( $zume_owner->nickname ); ?></dd>

                                <dt><?php echo esc_html__( 'Group Name', 'zume' ) ?></dt>
                                <dd><?php echo esc_html( $zume_value['group_name'] ); ?></dd>

                                <dt><?php echo esc_html__( 'Number of Participants', 'zume' ) ?></dt>
                                <dd><?php echo esc_html( $zume_value['members'] ); ?></dd>

                                <dt><?php echo esc_html__( 'Planned Meeting Time', 'zume' ) ?></dt>
                                <dd><?php echo esc_html( $zume_value['meeting_time'] ); ?></dd>

                                <dt><?php echo esc_html__( 'Address', 'zume' ) ?></dt>

                                <dd><?php echo isset( $zume_value['address'] ) ? esc_html( $zume_value['address'] ) : ''; ?></dd>
                                <dd>
                                    <?php if ( ! empty( $zume_value['address'] ) && ! empty( esc_attr( $zume_value['lng'] ) ) && ! empty( esc_attr( $zume_value['lat'] ) ) ) : ?>
                                        <div id="map<?php echo esc_html( $zume_key ); ?>">
                                            <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo esc_attr( $zume_value['lat'] ) . ',' . esc_attr( $zume_value['lng'] ) ?>&zoom=5&size=600x250&markers=color:red|<?php echo esc_attr( $zume_value['lat'] ) . ',' . esc_attr( $zume_value['lng'] ) ?>&key=<?php echo esc_attr( Disciple_Tools_Google_Geocode_API::key() ); ?>"/>
                                        </div>
                                    <?php endif; ?>
                                </dd>

                                <dt><?php echo esc_html__( 'Coleaders or additional participants', 'zume' ) ?></dt>
                                <dd>
                                    <?php
                                    // Print current coleaders
                                    if ( isset( $zume_value['coleaders'] ) && ! empty( $zume_value['coleaders'] ) && is_array( $zume_value['coleaders'] ) ) :
                                        echo '<ul style="padding: 0 2em;">';
                                        foreach ( $zume_value['coleaders'] as $zume_coleader ) {
                                            echo '<li>' . esc_html( $zume_coleader ) . '</li>';
                                        } // endforeach
                                        echo '</ul>';
                                    endif; // if coleader exits
                                    ?>
                                </dd>

                            </dl>
                        </div>

                        <div class="cell">
                            <span class="align-right">
                                <button type="button" class="button clear alert" name="type"
                                        data-open="<?php echo esc_html( $zume_key ); ?>-delete">
                                    <?php echo esc_html__( 'Remove Group', 'zume' ) ?>
                                </button>
                            </span>
                        </div>

                        <!-- This is the nested modal -->
                        <div class="reveal small" id="<?php echo esc_html( $zume_key ); ?>-delete" data-reveal>
                            <form data-abide method="post">
                                <?php wp_nonce_field( get_current_user_id(), 'zume_nonce' ) ?>
                                <input type="hidden" name="type" value="remove"/>
                                <input type="hidden" name="owner" value="<?php echo esc_attr( $zume_owner->ID ) ?>"/>

                                <div class="grid-x grid-padding-x">
                                    <div class="cell center">
                                        <h3><?php esc_attr_e( 'ARE YOU SURE YOU WANT TO REMOVE THIS GROUP?', 'zume' ) ?></h3>
                                        <p><?php esc_html_e( 'To reverse this action, the owner of the group must re-invite you to the group again.', 'zume' ) ?></p>
                                    </div>
                                </div>
                                <div class="grid-x">
                                    <div class="cell center">
                                        <span class="center">
                                            <button type="submit" class="button alert" name="key" value="<?php echo esc_html( $zume_key ); ?>">
                                                <?php echo esc_html__( 'Remove', 'zume' ) ?>
                                            </button>
                                        </span>
                                        <span class="center">
                                            <button type="button" class="button hollow" data-open="<?php echo esc_html( $zume_key ); ?>">
                                                <?php echo esc_html__( 'Cancel', 'zume' ) ?>
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <button class="close-button" data-close aria-label="Close reveal" type="button">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </form>
                        </div>

                    </div>

                    <button class="close-button" data-close aria-label="Close modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <?php
        }
    }
endif; // check if $zume_colead_groups is no empty
?>


<?php
/********************************************************************************************* -->
<!-- REQUEST COACHING -->
<!-- *********************************************************************************************/
?>
    <!-- Edit current groups section -->
    <div class="small reveal" id="new-registration-tour" data-reveal>
        <h1 class="primary-color" id="coach-modal-title"><?php echo esc_html__( 'Connect Me to a Coach', 'zume' ) ?></h1>
        <hr>


        <div class="grid-x" id="coaching-request-form-section">
            <div class="cell">
                <form data-abide novalidate id="coaching-request-form">
                <div class="grid-x grid-padding-x" >

                    <div class="cell small-6">
                        <i class="fi-torsos-all secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span style="font-size:2em; vertical-align: middle; text-wrap: none;"><?php esc_html_e( 'Coaches', 'zume' ) ?></span>
                        <p><?php esc_html_e( 'Our network of volunteer coaches are people like you, people who are passionate about loving God, loving others, and obeying the Great Commission.', 'zume' ) ?></p>
                    </div>

                    <div class="cell small-6">
                        <i class="fi-compass secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span style="font-size:2em; vertical-align: middle;"><?php esc_html_e( 'Advocates', 'zume' ) ?></span>
                        <p><?php esc_html_e( 'A coach is someone who will come alongside you as you implement the Zúme tools and training.', 'zume' ) ?></p>
                    </div>

                    <div class="cell small-6">
                        <i class="fi-map secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span style="font-size:2em; vertical-align: middle;"><?php esc_html_e( 'Local', 'zume' ) ?></span>
                        <p><?php esc_html_e( 'On submitting this request, we will do our best to connect you with a coach near you.', 'zume' ) ?></p>
                    </div>

                    <div class="cell small-6">
                        <i class="fi-dollar secondary-color" style="font-size:4em; vertical-align: middle;"></i>
                        &nbsp;<span style="font-size:2em; vertical-align: middle;text-wrap: none;"><?php esc_html_e( "It's Free", 'zume' ) ?></span>
                        <p><?php esc_html_e( 'Coaching is free. You can opt out at any time.', 'zume' ) ?></p>
                    </div>

                </div>
                <div data-abide-error class="alert callout" style="display: none;">
                    <p><i class="fi-alert"></i> There are some errors in your form.</p>
                </div>
                <table>
                    <tr style="vertical-align: top;">
                        <td>
                            <label for="zume_full_name"><?php echo esc_html__( 'Name', 'zume' )?></label>
                        </td>
                        <td>
                            <input type="text"
                                   placeholder="<?php echo esc_html__( 'First and last name', 'zume' )?>"
                                   aria-describedby="<?php echo esc_html__( 'First and last name', 'zume' )?>"
                                   class="profile-input"
                                   id="zume_full_name"
                                   name="zume_full_name"
                                   value="<?php echo esc_html( get_user_meta( $zume_user->ID, 'zume_full_name', true ) ); ?>"
                                   required />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <label for="zume_phone_number"><?php echo esc_html__( 'Phone Number', 'zume' )?></label>
                        </td>
                        <td>
                            <input type="tel"
                                   placeholder="111-111-1111"
                                   class="profile-input"
                                   id="zume_phone_number"
                                   name="zume_phone_number"
                                   value="<?php echo isset( $zume_user_meta['zume_phone_number'] ) ? esc_html( $zume_user_meta['zume_phone_number'] ) : ''; ?>"
                                   data-abide-ignore
                                    />
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <label for="user_email"><?php echo esc_html__( 'Email', 'zume' )?></label>
                        </td>
                        <td>
                            <input type="text"
                                   class="profile-input"
                                   placeholder="name@email.com"
                                   id="user_email"
                                   name="user_email"
                                   value="<?php echo esc_html( $zume_user->user_email ); ?>"
                                   required
                                   readonly
                            />
                            <span class="form-error">
                                <?php esc_attr_e( 'Email is required.', 'zume' ) ?>
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td style="vertical-align: top;">
                            <label for="validate_address">
                                <?php echo esc_html__( 'City', 'zume' )?>
                            </label>
                        </td>
                        <td>
                            <div class="input-group">
                                <input type="text"
                                       placeholder="example: Denver, CO 80126"
                                       class="profile-input input-group-field"
                                       id="validate_addressprofile"
                                       name="validate_address"
                                       value="<?php echo isset( $zume_user_meta['zume_user_address'] ) ? esc_html( $zume_user_meta['zume_user_address'] ) : ''; ?>"
                                       data-abide-ignore
                                />
                                <div class="input-group-button">
                                    <input type="button" class="button" id="validate_address_buttonprofile" value="<?php echo esc_html__( 'Validate', 'zume' ) ?>" onclick="validate_user_address( jQuery('#validate_addressprofile').val() )">
                                </div>
                            </div>

                            <div id="possible-results">
                                <input type="hidden" name="address" id="address_profile" value="<?php echo isset( $zume_user_meta['zume_user_address'] ) ? esc_html( $zume_user_meta['zume_user_address'] ) : ''; ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <label><?php echo esc_html__( 'How should we contact you?', 'zume' )?></label>
                        </td>
                        <td>
                            <fieldset>
                                <input id="zume_contact_preference1" name="zume_contact_preference" type="radio" value="email" checked data-abide-ignore>
                                <label for="zume_contact_preference1"><?php esc_attr_e( 'Email', 'zume' ) ?></label>
                                <input id="zume_contact_preference2" name="zume_contact_preference" type="radio" value="text" data-abide-ignore>
                                <label for="zume_contact_preference2"><?php esc_attr_e( 'Text', 'zume' ) ?></label>
                                <input id="zume_contact_preference3" name="zume_contact_preference" type="radio" value="phone" data-abide-ignore>
                                <label for="zume_contact_preference3"><?php esc_attr_e( 'Phone', 'zume' ) ?></label><br>
                                <input id="zume_contact_preference3" name="zume_contact_preference" type="radio" value="whatsapp" data-abide-ignore>
                                <label for="zume_contact_preference3"><?php esc_attr_e( 'WhatsApp', 'zume' ) ?></label>
                                <input id="zume_contact_preference3" name="zume_contact_preference" type="radio" value="other" data-abide-ignore>
                                <label for="zume_contact_preference3"><?php esc_attr_e( 'Other', 'zume' ) ?></label>
                            </fieldset>

                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <label for="zume_affiliation_key"><?php echo esc_html__( 'Affiliation Key', 'zume' )?></label>
                        </td>
                        <td>
                            <input type="text" value="<?php echo isset( $zume_user_meta['zume_affiliation_key'] )
                                ? esc_html( strtoupper( $zume_user_meta['zume_affiliation_key'] ) ) : ''; ?>"
                                   id="zume_affiliation_key"
                                   name="zume_affiliation_key" placeholder="" />
                        </td>
                    </tr>
                </table>
                <div data-abide-error  class="alert alert-box" style="display:none;" id="alert">
                    <strong><?php echo esc_html__( 'Oh snap!', 'zume' )?></strong>
                </div>
                <div class="cell">
                    <button class="button" type="button" onclick="validate_request()" id="submit_profile"><?php echo esc_html__( 'Submit', 'zume' )?></button><span id="request_spinner"></span>
                </div>
                </form>
            </div>
        </div>
        <script>
            jQuery(document).ready(function(){
                jQuery(document)
                    .on("formvalid.zf.abide", function(ev,frm) {
                        send_coaching_request()
                    })
            })
            function validate_request() {
                jQuery('#coaching-request-form').foundation('validateForm');
            }
        </script>

        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>

</div> <!-- End of reveal -->

<?php

do_action( 'zume_dashboard_footer' );

get_footer();
