<?php
/*
Template Name: Zúme Dashboard
*/
zume_force_login();

if ( ! empty( $_POST ) ) {
    if ( ! empty( $_POST['type'] ) && $_POST['type'] == 'create' ) {
        Zume_Dashboard::create_group( $_POST );
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'edit' ) {
        Zume_Dashboard::edit_group( $_POST );
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'closed' && isset( $_POST['key'] ) ) {
        Zume_Dashboard::closed_group( sanitize_key( wp_unslash( $_POST['key'] ) ) );
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'delete' && isset( $_POST['key'] ) ) {
        Zume_Dashboard::delete_group( sanitize_key( wp_unslash( $_POST['key'] ) ) );
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'activate' && isset( $_POST['key'] ) ) {
        Zume_Dashboard::activate_group( get_current_user_id(), sanitize_key( wp_unslash( $_POST['key'] ) ) );
    } else {
        zume_write_log( 'Failed to filter' );
    }
}

get_header();

$zume_current_user = get_current_user_id();
$zume_user_meta = zume_get_user_meta( $zume_current_user );
$zume_highest_session = Zume_Dashboard::get_highest_session( $zume_current_user );

?>

    <div id="content">

        <div id="inner-content" class="grid-x grid-margin-x">

            <div id="main" class="cell" role="main">

                <div class="grid-x grid-margin-x" id="test-eq">
                    <div class="large-1 cell"></div>

                    <!-- Left Column -->
                    <div class="large-7 cell">

                        <!-- ********************************************************************************************* -->
                        <!-- Groups Management Section -->
                        <!-- ********************************************************************************************* -->
                        <div class="callout">
                            <p class="center">
                                <button class="button hollow small"
                                        data-open="create"><?php echo esc_html__( 'Start New Group', 'zume' ) ?></button>
                            </p>
                            <ul id="groups-list" class="item-list">
                                <li class="block">
                                    <h2 class="center"><?php echo esc_html__( 'Your Groups', 'zume' ) ?></h2>
                                </li>

                                <?php
                                $zume_no_groups = 0;
                                foreach ( $zume_user_meta as $zume_key => $v ) {
                                    $zume_key_beginning = substr( $zume_key, 0, 10 );
                                    if ( 'zume_group' == $zume_key_beginning ) { // check if zume_group
                                        $zume_value = maybe_unserialize( $v );
                                        if ( isset( $zume_value['closed'] ) && false == $zume_value['closed'] ) : // check if closed
                                            ?>
                                            <!-- Group Row -->
                                            <li class="block">
                                                <div class="grid-x grid-margin-x">
                                                    <div class="large-6 cell">
                                                        <h3>
                                                            <a data-open="<?php echo esc_html( $zume_key ); ?>"><?php echo esc_html( $zume_value['group_name'] ) ?></a>
                                                        </h3>
                                                        <p class="text-gray">
                                                            <?php echo esc_html( __( 'Meeting Time', 'zume' ) . ": " . $zume_value['meeting_time'] ) ?>
                                                            <br>
                                                            <?php echo esc_html( __( 'Members', 'zume' ) . ': ' . $zume_value['members'] ) ?>
                                                            <br>
                                                            <?php echo esc_html( __( 'Address', 'zume' ) . ': ' . $zume_value['address'] ) ?>
                                                            <br>
                                                        </p>

                                                        <button class="small"
                                                                data-open="<?php echo esc_html( $zume_key ); ?>">
                                                            <i class="fi-pencil hollow"></i> <?php echo esc_html__( 'edit', 'zume' ) ?>
                                                        </button>
                                                    </div>
                                                    <div class="large-6 cell">
                                                        <ul class="pagination" role="navigation"
                                                            aria-label="Pagination">
                                                            <li class="<?php echo esc_html( $zume_value['session_1'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=1' ); ?>">1</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_2'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=2' ); ?>">2</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_3'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=3' ); ?>">3</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_4'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=4' ); ?>">4</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_5'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=5' ); ?>">5</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_6'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=6' ); ?>">6</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_7'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=7' ); ?>">7</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_8'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=8' ); ?>">8</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_9'] ? 'current' : '' ); ?>">
                                                                <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=9' ); ?>">9</a>
                                                            </li>
                                                            <li class="<?php echo esc_html( $zume_value['session_10'] ? 'current' : '' ); ?>">
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
                                                            <form method="post">
                                                                <input type="hidden" name="key"
                                                                       value="<?php echo esc_html( $zume_key ); ?>"/>
                                                                <span><button type="submit" class="button hollow alert"
                                                                              name="type"
                                                                              value="closed"><?php echo esc_html__( 'Archive Group', 'zume' ) ?></button></span>
                                                            </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php
                                            $zume_no_groups++;
                                        endif; // end if closed check
                                    } // end check if zume_group
                                }
                                ?>

                                <!-- Message if there is no groups -->
                                <?php if ( $zume_no_groups < 1 ) : ?>
                                    <div class="grid-x grid-margin-x vertical-padding">
                                        <div class="large-8 large-offset-2 cell center">
                                            <h4>
                                                <strong><?php echo esc_html__( 'You have no active groups', 'zume' ) ?></strong>
                                            </h4>
                                            <p>
                                                <?php echo esc_html__( "We recommend at least 4 people for a group and no more than 12 people. Please start a group with the button provided.", 'zume' ) ?></p>
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
                                        <div class="large-4 cell"><!-- begin first column -->

                                            <!-- Video link and modal block -->
                                            <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="promo"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Promo Challenge', 'zume' ) ?> (1:41)</a>
                                                </div>
                                                <div class="small reveal" id="promo" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'promo' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- end block -->

                                            <!-- Video link and modal block -->
                                            <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="overview"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Overview Video', 'zume' ) ?> (2:07)</a>
                                                </div>
                                                <div class="small reveal" id="overview" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'overview' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- end block -->

                                            <!-- Video link and modal block -->
                                            <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="how_zume_works"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'How Zúme Works', 'zume' ) ?> (3:22)</a>
                                                </div>
                                                <div class="small reveal" id="how_zume_works" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'how_zume_works' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- end block -->


                                            <!--end section top-->
                                            <?php
                                            if ( $zume_highest_session > 1 ) {
                                                ?>
                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_1"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Welcome to Zume', 'zume' ) ?> (3:07)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_1" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_1' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_2"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Teach Them to Obey', 'zume' ) ?> (4:01)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_2" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_2' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_3"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Spiritual Breathing', 'zume' ) ?> (5:46) </a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_3" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_3' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="toolkit_1"><i class="fi-microphone secondary-color"></i> <?php esc_html_e( 'S.O.A.P.S Bible Reading', 'zume' ) ?> (3:22)</a>
                                                    </div>
                                                    <div class="small reveal" id="toolkit_1" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_1' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="toolkit_2"><i class="fi-microphone secondary-color"></i> <?php esc_html_e( 'Accountability Groups', 'zume' ) ?> (1:10)</a>
                                                    </div>
                                                    <div class="small reveal" id="toolkit_2" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_2' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->


                                                <?php
                                            }
                                            if ( $zume_highest_session > 2 ) {
                                                ?>

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_4"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Producers vs Consumers', 'zume' ) ?> (5:33)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_4" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_4' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="toolkit_3"><i class="fi-microphone secondary-color"></i> <?php esc_html_e( 'Prayer Cycle', 'zume' ) ?> (1:10)</a>
                                                    </div>
                                                    <div class="small reveal" id="toolkit_3" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_3' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="toolkit_4"><i class="fi-microphone secondary-color"></i> <?php esc_html_e( 'List of 100', 'zume' ) ?> (1:04)</a>
                                                    </div>
                                                    <div class="small reveal" id="toolkit_4" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_4' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <?php
                                            }

                                            // SECOND COLUMN
                                            ?>
                                            </div> <!-- end first column-->
                                            <div class="large-4 cell"> <!-- begin second column-->

                                            <?php
                                            if ( $zume_highest_session > 3 ) {
                                                ?>

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_6"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Spiritual Economy', 'zume' ) ?> (2:32)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_6" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_6' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_7"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'The Gospel', 'zume' ) ?> (4:41)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_7" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_7' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="toolkit_6"><i class="fi-microphone secondary-color"></i> <?php esc_html_e( 'Baptism', 'zume' ) ?> (3:22)</a>
                                                    </div>
                                                    <div class="small reveal" id="toolkit_6" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_6' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <?php
                                            }


                                            if ( $zume_highest_session > 4 ) {
                                                ?>

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="toolkit_5"><i class="fi-microphone secondary-color"></i> <?php esc_html_e( '3 Minute Testimony', 'zume' ) ?> (2:26)</a>
                                                </div>
                                                <div class="small reveal" id="toolkit_5" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_5' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="scribe_5"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Greatest Blessing', 'zume' ) ?> (2:26)</a>
                                                </div>
                                                <div class="small reveal" id="scribe_5" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_5' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="scribe_17"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Duckling Discipleship', 'zume' ) ?> (3:29)</a>
                                                </div>
                                                <div class="small reveal" id="scribe_17" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_17' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="scribe_8"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Eyes to See', 'zume' ) ?> (6:08)</a>
                                                </div>
                                                <div class="small reveal" id="scribe_8" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_8' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="toolkit_9"><i class="fi-microphone secondary-color"></i> <?php esc_html_e( 'Lord\'s Supper', 'zume' ) ?> (1:54)</a>
                                                </div>
                                                <div class="small reveal" id="toolkit_9" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_9' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                </div>
                                                <!-- end block -->

                                                <?php
                                            }
                                            if ( $zume_highest_session > 5 ) {
                                                ?>

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="toolkit_8"><i class="fi-microphone secondary-color"></i> <?php esc_html_e( 'Prayer Walking', 'zume' ) ?> (5:05)</a>
                                                    </div>
                                                    <div class="small reveal" id="toolkit_8" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_8' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_18"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Person of Peace', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_18" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_18' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <?php
                                            }

                                            // THIRD COLUMN
                                            ?>
                                            </div> <!-- end second column-->
                                            <div class="large-4 cell"> <!-- begin third column-->

                                            <?php
                                            if ( $zume_highest_session > 6 ) {
                                                ?>

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_9"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Faithfulness', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_9" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_9' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="toolkit_10"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( '3/3 Group Format', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="toolkit_10" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_10' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="3_3_group"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( '3/3 Group Live', 'zume' ) ?> (1:19:00)</a>
                                                    </div>
                                                    <div class="small reveal" id="3_3_group" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( '3_3_group' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <?php
                                            }

                                            if ( $zume_highest_session > 7 ) {
                                                ?>

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_10"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Training Cycle', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_10" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_10' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <?php
                                            }

                                            if ( $zume_highest_session > 8 ) {
                                                ?>

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_11"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Leadership Cells', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_11" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_11' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <?php
                                            }

                                            if ( $zume_highest_session > 9 ) {
                                                ?>

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_12"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Non-Sequential', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_12" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_12' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_13"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Pace', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_13" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_13' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_14"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Part of Two Churches', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_14" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_14' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <!-- Video link and modal block -->
                                                <div class="grid-x grid-margin-x">
                                                    <div class="cell">
                                                        <a class="small" style="text-transform: uppercase;"
                                                           data-open="scribe_16"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Completion of Training', 'zume' ) ?> (5:45)</a>
                                                    </div>
                                                    <div class="small reveal" id="scribe_16" data-reveal>
                                                        <br>
                                                        <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_16' ) ) ?>"
                                                                width="560" height="315"
                                                                frameborder="0"
                                                                webkitallowfullscreen mozallowfullscreen
                                                                allowfullscreen></iframe>
                                                        <button class="close-button" data-close aria-label="Close reveal"
                                                                type="button">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- end block -->

                                                <?php
                                            }

                                            if ( $zume_highest_session > 10 ) {
                                            ?>

                                            <!-- Video link and modal block -->
                                            <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="scribe_15"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Leadership in Networks', 'zume' ) ?> (5:45)</a>
                                                </div>
                                                <div class="small reveal" id="scribe_15" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'scribe_15' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- end block -->

                                            <!-- Video link and modal block -->
                                            <div class="grid-x grid-margin-x">
                                                <div class="cell">
                                                    <a class="small" style="text-transform: uppercase;"
                                                       data-open="toolkit_11"><i class="fi-play-circle secondary-color"></i> <?php esc_html_e( 'Peer Mentoring Groups', 'zume' ) ?> (5:45)</a>
                                                </div>
                                                <div class="small reveal" id="toolkit_11" data-reveal>
                                                    <br>
                                                    <iframe src="<?php echo esc_url( Zume_Course::get_video_by_key( 'toolkit_11' ) ) ?>"
                                                            width="560" height="315"
                                                            frameborder="0"
                                                            webkitallowfullscreen mozallowfullscreen
                                                            allowfullscreen></iframe>
                                                    <button class="close-button" data-close aria-label="Close reveal"
                                                            type="button">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- end block -->

                                            <?php } ?><!-- Bottom section -->


                                        </div> <!-- end third column -->

                                    </div> <!-- end columns container -->
                                    <?php if ( $zume_highest_session < 2 ) { ?>
                                        <div class="grid-x grid-margin-x grid-margin-y">
                                            <div class="cell large-3"></div>
                                            <div class="cell large-6 callout warning">
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

                        <!-- ********************************************************************************************* -->
                        <!-- TOOLS SECTION -->
                        <!-- ********************************************************************************************* -->
                        <div class="callout">
                            <!-- Section top -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell">
                                    <h3 class="center padding-bottom"><?php esc_html_e( 'Tools You\'ve Gained', 'zume' ) ?></h3>
                                    <span class="float-right small"><?php Zume_Dashboard::get_available_tools_count( $zume_highest_session ); ?> <?php esc_html_e( 'of 12 tools', 'zume' ) ?></span>
                                    <hr>
                                    <!--end section top-->
                        <?php
                        if ( $zume_highest_session > 1 ) :
                            ?>
                                <div class="grid-x grid-margin-x"> <!-- Begin columns container -->
                                    <div class="large-4 cell"><!-- begin first column -->

                                        <div class="grid-x">
                                            <div class="cell small">
                                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-2.png"
                                                     alt=""
                                                     width="15" height="15"
                                                     class="alignnone size-full wp-image-1035"/>&nbsp;&nbsp;
                                                <?php esc_html_e( 'S.O.A.P.S. BIBLE READING', 'zume' ) ?>
                                            </div>
                                            <div class="cell small">
                                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-2.png"
                                                     alt=""
                                                     width="15" height="15"
                                                     class="alignnone size-full wp-image-1567"/>&nbsp;&nbsp;
                                                <?php esc_html_e( 'ACCOUNTABILITY GROUPS', 'zume' ) ?>
                                            </div>
                                            <div class="cell small">
                                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>concept-3-2.png"
                                                     alt="" width="15" height="15"
                                                     class="alignnone size-full wp-image-1566"/>&nbsp;&nbsp;
                                                <?php esc_html_e( 'SPIRITUAL BREATHING', 'zume' ) ?>
                                            </div>
                                        </div>
                                        <?php

                                        if ( $zume_highest_session > 2 ) {
                                            ?>

                                            <div class="grid-x">

                                                <div class="cell small">
                                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-1-6.png"
                                                         alt="" width="15" height="15"
                                                         class="alignnone size-full wp-image-1577"/>&nbsp;&nbsp;
                                                    <?php esc_html_e( 'PRAYER CYCLE', 'zume' ) ?>
                                                </div>
                                                <div class="cell small">
                                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-2-2.png"
                                                         alt="" width="15" height="15"
                                                         class="alignnone size-full wp-image-1578"/>&nbsp;&nbsp;
                                                    <?php esc_html_e( 'LIST OF 100', 'zume' ) ?>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        if ( $zume_highest_session > 3 ) {
                                            ?>

                                            <div class="grid-x">
                                                <div class="cell small">
                                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-1-1.png"
                                                         alt="" width="15" height="15"
                                                         class="alignnone size-full wp-image-1183"/>&nbsp;&nbsp;
                                                    <?php esc_html_e( 'BAPTISM', 'zume' ) ?>
                                                </div>
                                            </div>

                                            <?php
                                        } // end 3
                                        ?>
                                        <!-- TRANSITION TO SECOND COLUMN-->
                                    </div> <!-- end first column-->
                                    <div class="large-4 cell"> <!-- begin second column-->

                                        <?php

                                        if ( $zume_highest_session > 4 ) {
                                            ?>

                                            <div class="grid-x">
                                                <div class="cell small">
                                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-1.png"
                                                         alt="" width="15" height="15"
                                                         class="alignnone size-full wp-image-1035"/>&nbsp;&nbsp;
                                                    <?php esc_html_e( '3-MINUTE TESTIMONY', 'zume' ) ?>
                                                </div>
                                                <div class="cell small">
                                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-2-3.png"
                                                         alt="" width="15" height="15"
                                                         class="alignnone size-full wp-image-1186"/>&nbsp;&nbsp;
                                                    <?php esc_html_e( 'THE LORD\'S SUPPER', 'zume' ) ?>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        if ( $zume_highest_session > 5 ) {
                                            ?>

                                            <div class="grid-x">
                                                <div class="large-10 cell small">
                                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-4.png"
                                                         alt="" width="15" height="15"
                                                         class="alignnone size-full wp-image-1035"/>&nbsp;&nbsp;
                                                    <?php esc_html_e( 'PRAYER WALKING', 'zume' ) ?>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        if ( $zume_highest_session > 6 ) {
                                            ?>

                                            <div class="grid-x">
                                                <div class="cell small">
                                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-5.png"
                                                         alt="" width="15" height="15"
                                                         class="alignnone size-full wp-image-1035"/>&nbsp;&nbsp;
                                                    <?php esc_html_e( '3/3 GROUP FORMAT', 'zume' ) ?>
                                                </div>
                                            </div>

                                            <?php
                                        }
                                        if ( $zume_highest_session > 10 ) {
                                        ?>

                                        <div class="grid-x">
                                            <div class="cell small">
                                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-7.png"
                                                     alt="" width="15" height="15"
                                                     class="alignnone size-full wp-image-1572"/>&nbsp;&nbsp;
                                                <?php esc_html_e( 'PEER MENTORING GROUPS', 'zume' ) ?>
                                            </div>
                                            <div class="large-10 cell small">
                                                <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-1-5.png"
                                                     alt="" width="15" height="15"
                                                     class="alignnone size-full wp-image-1574"/>&nbsp;&nbsp;
                                                <?php esc_html_e( 'COACHING CHECKLIST', 'zume' ) ?></div>
                                        </div>

                                        <?php
                                        }
                                        ?><!-- Bottom section -->
                                    </div> <!-- end second column-->
                                </div> <!-- end columns container -->

                        <?php else : // end if session 1 exists ?>

                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell large-3"></div>
                                <div class="cell large-6 callout warning">
                                    <?php esc_html_e( 'Session tools will be added as you complete sessions.', 'zume' ) ?>
                                </div>
                                <div class="cell large-3"></div>
                            </div>

                        <?php endif; ?>
                                </div> <!-- end container cell-->
                            </div> <!-- end grid container-->
                            <!--end bottom section-->
                        </div> <!-- end call out-->
                        <!--END TOOLS SECTION -->


                    </div> <!-- End Left Column -->


                    <!-- Right Column -->
                    <div class="large-3 cell dashboard-messages">

                        <!-- ********************************************************************************************* -->
                        <!-- COACH SECTION -->
                        <!-- ********************************************************************************************* -->
                        <?php
                        $zume_coach_id = get_user_meta( $zume_current_user, 'zume_coach', true );
                        if ( ! empty( $zume_coach_id ) ) :
                            $zume_coach_data = get_userdata( $zume_coach_id );
                            ?>
                            <div class="callout">
                                <div class="grid-x">
                                    <div class="cell center">
                                        <h3><?php echo esc_html__( 'Your Coach', 'zume' ) ?></h3>
                                    </div>
                                </div>

                                <div class="grid-x grid-margin-x">
                                    <div class="small-3 cell">
                                        <?php echo get_avatar( $zume_coach_id, 64 ) ?>
                                    </div>
                                    <div class="small-9 cell">
                                        <strong><?php echo esc_html( $zume_coach_data->display_name ); ?></strong><br>
                                        <a href="mailto:<?php echo esc_html( $zume_coach_data->user_email ); ?>">
                                            <?php echo esc_html( $zume_coach_data->user_email ); ?>
                                        </a><br>
                                        "<?php echo esc_html( $zume_coach_data->description ); ?>"
                                    </div>
                                </div>
                            </div>

                        <?php endif; ?>
                        <!-- END COACH SECTION -->

                        <!-- ********************************************************************************************* -->
                        <!-- INSTRUCTIONS SECTION -->
                        <!-- ********************************************************************************************* -->
                        <div class="callout">
                            <div class="grid-x">
                                <div class="cell center">
                                    <h3 class="center padding-bottom"><?php echo esc_html__( 'Instructions', 'zume' ) ?></h3>
                                </div>
                            </div>

                            <div class="grid-x grid-margin-x">
                                <div class="cell">
                                    <ul>
                                        <li><?php esc_html_e( "Create a group", 'zume' ) ?><?php if ( $zume_no_groups > 0 ) {
                                                print ' &nbsp;<span class="primary-color">&#10004;</span>';
} ?></li>
                                        <li><?php esc_html_e( "Plan a time and invite friends", 'zume' ) ?></li>
                                        <li><?php esc_html_e( "Explore the upcoming session", 'zume' ) ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- END INSTRUCTIONS -->

                        <!-- ********************************************************************************************* -->
                        <!-- Begin Inactive Groups Section -->
                        <!-- ********************************************************************************************* -->
                        <?php
                        $zume_no_inactive_groups = 0;
                        $zume_html = '';
                        foreach ( $zume_user_meta as $zume_key => $v ) :
                            $zume_key_beginning = substr( $zume_key, 0, 10 );
                            if ( 'zume_group' == $zume_key_beginning ) : // check if zume_group
                                $zume_value = maybe_unserialize( $v );
                                if ( isset( $zume_value['closed'] ) && true == $zume_value['closed'] ) : // check if closed

                                    $zume_html .= '<div class="grid-x grid-margin-x"><div class="small-8 cell">';
                                    $zume_html .= esc_html( $zume_value['group_name'] );
                                    $zume_html .= '</div><div class="small-3 cell">';
                                    $zume_html .= '<button class="small button clear" type="submit" name="key" value="' . esc_attr( $zume_key ) . '">' . esc_html__( 'activate', 'zume' ) . '</button>';
                                    $zume_html .= '</div></div>';

                                    $zume_no_inactive_groups++;
                                endif; // end if closed check
                            endif; // end check if zume_group
                        endforeach;

                        ?>

                        <?php if ( $zume_no_inactive_groups > 0 ) : ?>
                            <div class="callout">
                                <div class="grid-x ">
                                    <div class="cell vertical-padding center">
                                        <h3><?php echo esc_html__( 'Archived Groups', 'zume' ) ?></h3>
                                        <hr>
                                    </div>
                                </div>

                                <form action="" method="post">
                                    <input type="hidden" name="type" value="activate"/>
                                    <?php
                                    // @codingStandardsIgnoreLine
                                    echo $zume_html ?>
                                </form>

                            </div>
                        <?php endif; ?>
                        <!-- End Inactive Groups Section -->


                    </div> <!-- End Right Column -->

                    <div class="large-1 cell"></div>

                </div>

            </div>

        </div>

    </div>

    <!-- ********************************************************************************************* -->
    <!-- Create a New Group Modal -->
    <!-- ********************************************************************************************* -->
    <div class="small reveal" id="create" data-reveal>
        <h1><?php echo esc_html__( 'Create Group', 'zume' ) ?></h1>
        <form action="" method="post">
            <input type="hidden" name="type" value="create"/>
            <input type="hidden" name="ip_address"
                   value="<?php echo esc_html( Zume_Google_Geolocation::get_real_ip_address() ); ?>"/>
            <div class="grid-x grid-margin-x">
                <div class="cell">
                    <label for="group_name"><?php echo esc_html__( 'Group Name', 'zume' ) ?></label>
                    <input type="text" value="" name="group_name" id="group_name" required/>
                </div>
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
                <div class="cell">
                    <label for="meeting_time"><?php echo esc_html__( 'Planned Meeting Time', 'zume' ) ?></label>
                    <input type="text" value="" name="meeting_time" id="meeting_time" required/>
                </div>
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
                                   value="<?php echo esc_html__( 'Validate', 'zume' ) ?>" id="validate_address_buttonnew">
                        </div>
                    </div>

                    <div id="possible-resultsnew">
                        <input type="hidden" name="address" id="address_new" value=""/>
                    </div>

                </div>
                <div class="cell">
                    <br>
                    <button type="submit" class="button"
                            id="submit_new"><?php echo esc_html__( 'Submit', 'zume' ) ?></button>
                </div>

                <script>
                    jQuery('#validate_addressnew').keyup(function () {
                        check_address('new')
                    });
                </script>

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
foreach ( $zume_user_meta as $zume_key => $v ) {
    $zume_key_beginning = substr( $zume_key, 0, 10 );
    if ( 'zume_group' == $zume_key_beginning ) {
        $zume_value = unserialize( $v );
        ?>

        <!-- Edit current groups section -->
        <div class="small reveal" id="<?php echo esc_html( $zume_key ); ?>" data-reveal>
            <form data-abide method="post">
                <h1><?php echo esc_html__( 'Edit Group', 'zume' ) ?></h1>

                <input type="hidden" name="key" value="<?php echo esc_html( $zume_key ); ?>"/>
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <label for="group_name"><?php echo esc_html__( 'Group Name', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $zume_value['group_name'] ); ?>"
                               name="group_name" id="group_name" required/>
                    </div>
                    <div class="cell">
                        <label for="members"><?php echo esc_html__( 'Number of Participants', 'zume' ) ?></label>
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
                    <div class="cell">
                        <label for="meeting_time"><?php echo esc_html__( 'Planned Meeting Time', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $zume_value['meeting_time'] ); ?>"
                               name="meeting_time" id="meeting_time" required/>
                    </div>
                    <div class="cell">
                        <label for="validate_address<?php echo esc_html( $zume_key ); ?>"><?php echo esc_html__( 'Address', 'zume' ) ?></label>
                        <div class="input-group">
                            <input type="text"
                                   placeholder="example: 1000 Broadway, Denver, CO 80126"
                                   class="profile-input input-group-field"
                                   name="validate_address"
                                   id="validate_address<?php echo esc_html( $zume_key ); ?>"
                                   value="<?php echo isset( $zume_value['address'] ) ? esc_html( $zume_value['address'] ) : ''; ?>"
                            />
                            <div class="input-group-button">
                                <input type="button" class="button"
                                       onclick="validate_group_address( jQuery('#validate_address<?php echo esc_html( $zume_key ); ?>').val(), '<?php echo esc_html( $zume_key ); ?>')"
                                       value="<?php echo esc_html__( 'Validate', 'zume' ) ?>"
                                       id="validate_address_button<?php echo esc_html( $zume_key ); ?>">
                            </div>
                        </div>

                        <div id="possible-results<?php echo esc_html( $zume_key ); ?>">
                            <input type="hidden" name="address" id="address_<?php echo esc_html( $zume_key ); ?>"
                                   value="<?php echo isset( $zume_value['address'] ) ? esc_html( $zume_value['address'] ) : ''; ?>"/>
                        </div>

                        <?php if ( ! empty( $zume_value['address'] ) && ! empty( esc_attr( $zume_value['lng'] ) ) && ! empty( esc_attr( $zume_value['lat'] ) ) ) : ?>
                            <div id="map<?php echo esc_html( $zume_key ); ?>">
                                <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo esc_attr( $zume_value['lat'] ) . ',' . esc_attr( $zume_value['lng'] ) ?>&zoom=5&size=600x250&markers=color:red|<?php echo esc_attr( $zume_value['lat'] ) . ',' . esc_attr( $zume_value['lng'] ) ?>&key=<?php echo esc_attr( Zume_Google_Geolocation::$key ); ?>"/>
                            </div>
                        <?php endif; ?>

                    </div>
                    <div class="cell">
                        <br>
                        <button type="submit" class="button" name="type"
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
                <input type="hidden" name="key" value="<?php echo esc_html( $zume_key ); ?>"/>
                <h3>ARE YOU SURE YOU WANT TO DELETE THIS GROUP?</h3><br>
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

<?php

get_footer();
