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
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'closed' ) {
        Zume_Dashboard::closed_group( sanitize_key( wp_unslash( $_POST['key'] ) ) );
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'delete' ) {
        Zume_Dashboard::delete_group( sanitize_key( wp_unslash( $_POST['key'] ) ) );
    } else {
        zume_write_log( 'Failed to filter' );
    }
}


get_header();

(function() {

    $zume_current_user = get_current_user_id();
    $zume_user_meta    = array_map( function ( $a ) { return $a[0];
    }, get_user_meta( $zume_current_user ) );
?>

<div id="content">

    <div id="inner-content" class="grid-x">

        <div id="main" class="cell" role="main">

            <div class="grid-x grid-margin-x" data-equalizer data-equalize-on="large" id="test-eq">
                <div class="large-1 cell"></div>

                <!-- Left Column -->
                <div class="large-7 cell">

                    <!-- Groups Management Section -->
                    <div class="callout" data-equalizer-watch>
                        <p class="center">
                            <button class="button hollow small" data-open="create"><?php echo esc_html__( 'Start New Group', 'zume' ) ?></button>
                        </p>
                        <ul id="groups-list" class="item-list">
                            <li class="block">
                                <h2 class="center"><?php echo esc_html__( 'Your Groups', 'zume' ) ?></h2>
                            </li>

                            <?php
                            $zume_no_groups = 0;
                            foreach ( $zume_user_meta as $key => $v ) {
                                $key_beginning = substr( $key, 0, 10 );
                                if ( 'zume_group' == $key_beginning ) { // check if zume_group
                                    $value = maybe_unserialize( $v );
                                    if ( isset( $value['closed'] ) && false == $value['closed'] ) : // check if closed
                            ?>
                                <!-- Group Row -->
                                <li class="block">
                                    <div class="grid-x grid-margin-x">
                                        <div class="large-6 cell">
                                            <h3><a data-open="<?php echo esc_html( $key ); ?>"><?php echo esc_html( $value['group_name'] ) ?></a>
                                            </h3>
                                            <p class="text-gray">
                                                <?php echo esc_html( __( 'Meeting Time' , 'zume' ) . ": " .  $value['meeting_time'] ) ?><br>
                                                <?php echo esc_html( __( 'Members', 'zume' ) . ': ' . $value['members'] )?><br>
                                                <?php echo esc_html( __( 'Address', 'zume' ) . ': ' . $value['address'] )?><br>
                                            </p>

                                            <button class="small" data-open="<?php echo esc_html( $key ); ?>">
                                                <i class="fi-pencil hollow"></i> <?php echo esc_html__( 'edit', 'zume' ) ?>
                                            </button>
                                        </div>
                                        <div class="large-6 cell">
                                            <ul class="pagination" role="navigation" aria-label="Pagination">
                                                <li class="<?php echo esc_html( $value['session_1'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=1' );?>">1</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_2'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=2' );?>">2</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_3'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=3' );?>">3</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_4'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=4' );?>">4</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_5'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=5' );?>">5</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_6'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=6' );?>">6</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_7'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=7' );?>">7</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_8'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=8' );?>">8</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_9'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=9' );?>">9</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $value['session_10'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=10' );?>">10</a>
                                                </li>
                                            </ul>

                                            <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=' . $value['next_session'] ); ?>" class="button large">
                                                <?php echo esc_html( __( 'Start Next Session ', 'zume' ) . $value['next_session'] );?>
                                            </a>

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
                                    <h4><strong><?php echo esc_html__( 'You are not currently in a group', 'zume' ) ?></strong></h4>
                                    <p><?php echo esc_html__( "You will need at least four people gathered together to start each new session.
                                        Please start a group below. If you intended to join someone else's group, please
                                        return to the invitation they sent and use the link provided to be automatically added to that group.", 'zume') ?></p>
                                </div>
                            </div>
                            <?php endif; ?>

                            <p class="center vertical-padding">
                                <button class="button hollow small" data-open="create"><?php echo esc_html__( 'Start New Group', 'zume' ) ?></button>
                            </p>
                    </div>

                    <!-- Inactive Groups Section -->
                    <?php
                    $zume_no_inactive_groups = 0;
                    $html = '';
                    foreach ( $zume_user_meta as $key => $v ) :
                        $key_beginning = substr( $key, 0, 10 );
                        if ( 'zume_group' == $key_beginning ) : // check if zume_group
                            $value = maybe_unserialize( $v );
                            if ( isset( $value['closed'] ) && true == $value['closed'] ) : // check if closed

                                $html .= '<div class="grid-x grid-margin-x"><div class="small-10 cell">';
                                $html .= esc_html( $value['group_name'] );
                                $html .= '</div><div class="small-2 cell">';
                                $html .= '<a href="">' . esc_html__( 'activate', 'zume' ) . '</a>';
                                $html .= '</div></div><hr>';

                                $zume_no_inactive_groups++;
                            endif; // end if closed check
                        endif; // end check if zume_group
                    endforeach;

                    ?>

                    <?php if( $zume_no_inactive_groups > 0 ) : ?>
                    <div class="callout" >

                        <div class="grid-x ">
                            <div class="cell vertical-padding center">
			                    <h3><?php echo esc_html__( 'Inactive Groups', 'zume' ) ?></h3>
                                <hr>
                            </div>
                        </div>

	                    <?php echo $html; ?>

                    </div>
                    <?php endif; ?>
                    <!-- End Inactive Groups Section -->

                </div> <!-- End Left Column -->

                <!-- Right Column -->
                <div class="large-3 cell dashboard-messages">

                    <div class="callout" data-equalizer-watch>

                        <?php
                        $zume_coach_id = get_user_meta( $zume_current_user, 'zume_coach', true );
                        if ( ! empty( $zume_coach_id ) ) :
                            $zume_coach_data = get_userdata( $zume_coach_id );
                        ?>

                        <div class="grid-x">
                            <div class="cell vertical-padding">
                                <?php echo esc_html__( 'Your Coach', 'zume' ) ?>
                            </div>
                        </div>

                        <div class="grid-x grid-margin-x">
                            <div class="small-2 cell">
                                <?php echo get_avatar( $zume_coach_id, 32 ) ?>
                            </div>
                            <div class="small-8 cell">
                                <?php echo esc_html( $zume_coach_data->display_name ); ?>
                            </div>
                        </div>

                        <?php endif; ?>

                    </div>

                </div>
                <!-- End Right Column -->

                <div class="large-1 cell"></div>

            </div>

        </div>

    </div>

</div>

<!-- Create a New Group Modal -->
<div class="small reveal" id="create" data-reveal>
    <h1><?php echo esc_html__( 'Create Group', 'zume' ) ?></h1>
    <form action="" method="post">
        <input type="hidden" name="type" value="create"/>
        <input type="hidden" name="ip_address" value="<?php echo esc_html( zume_get_real_ip_address() ); ?>"/>
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <label for="group_name"><?php echo esc_html__( 'Group Name', 'zume' ) ?></label>
                <input type="text" value="" name="group_name" id="group_name" required/>
            </div>
            <div class="cell">
                <label for="members"><?php echo esc_html__( 'Number of Participants', 'zume' ) ?></label>
                <input type="text" value="" name="members" id="members" required/>
            </div>
            <div class="cell">
                <label for="meeting_time"><?php echo esc_html__( 'Planned Meeting Time', 'zume' ) ?></label>
                <input type="text" value="" name="meeting_time" id="meeting_time" required/>
            </div>
            <div class="cell">
                <label for="address"><?php echo esc_html__( 'Address', 'zume' ) ?></label>
                <input type="text" value="" placeholder="Please enter the full address for the group meeting"
                       name="address" id="address" required/>
            </div>
            <div class="cell">
                <br>
                <button type="submit" class="button"><?php echo esc_html__( 'Submit', 'zume' ) ?></button>
            </div>
        </div>

        <button class="close-button" data-close aria-label="Close modal" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
    </form>
</div>

<?php
foreach ( $zume_user_meta as $key => $v ) {
    $key_beginning = substr( $key, 0, 10 );
    if ( 'zume_group' == $key_beginning ) {
        $value = unserialize( $v );
        ?>

        <!-- Edit current groups section -->
        <div class="small reveal" id="<?php echo esc_html( $key ); ?>" data-reveal>
            <h1><?php echo esc_html__( 'Edit Group', 'zume' ) ?></h1>
            <form method="post">

                <input type="hidden" name="key" value="<?php echo esc_html( $key ); ?>"/>
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <label for="group_name"><?php echo esc_html__( 'Group Name', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $value['group_name'] ); ?>" name="group_name" id="group_name" required/>
                    </div>
                    <div class="cell">
                        <label for="members"><?php echo esc_html__( 'Number of Participants', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $value['members'] ); ?>" name="members" id="members" required/>
                    </div>
                    <div class="cell">
                        <label for="meeting_time"><?php echo esc_html__( 'Planned Meeting Time', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $value['meeting_time'] ); ?>" name="meeting_time" id="meeting_time" required/>
                    </div>
                    <div class="cell">
                        <label for="address"><?php echo esc_html__( 'Address', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $value['address'] ); ?>" name="address"
                               id="address" required/>
                    </div>
                    <div class="cell">
                        <br>
                        <button type="submit" class="button" name="type" value="edit"><?php echo esc_html__( 'Update', 'zume' ) ?></button>
                        <span class="align-right"><button type="submit" class="button hollow alert" name="type" value="delete"><?php echo esc_html__( 'Delete', 'zume' ) ?></button></span>
                        <span class="align-right"><button type="submit" class="button hollow alert" name="type" value="closed"><?php echo esc_html__( 'Close', 'zume' ) ?></button></span>
                    </div>
                </div>

                <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </form>
        </div>

        <?php
    }
}
?>

<?php

})();

get_footer();