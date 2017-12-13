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

    $zume_current_lang = zume_current_language();
    $zume_current_user = get_current_user_id();
    $zume_user_meta    = array_map( function ( $a ) { return $a[0];
    }, get_user_meta( $zume_current_user ) );
?>

<div id="content">

    <div id="inner-content" class="grid-x">

        <div id="main" class="cell" role="main">

            <!-- First Row -->
            <div class="grid-x grid-margin-x" data-equalizer data-equalize-on="large" id="test-eq">
                <div class="large-1 cell"></div>
                <div class="large-7 cell">

                    <div class="callout" data-equalizer-watch>
                        <p class="center">
                            <button class="button hollow small" data-open="create">Start New Group</button>
                        </p>
                        <ul id="groups-list" class="item-list">
                            <li class="block">
                                <h2 class="center">Your Groups</h2>
                            </li>

                            <?php
                            $zume_no_groups = 0;
                            foreach ( $zume_user_meta as $key => $v ) {
                                $key_beginning = substr( $key, 0, 10 );
                                if ( 'zume_group' == $key_beginning ) { // check if zume_group
                                    $value = maybe_unserialize( $v );
                                    if ( false == $value['closed'] ) : // check if closed
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
                                                    <i class="fi-pencil hollow"></i> edit
                                                </button>
                                            </div>
                                            <div class="large-6 cell">
                                                <ul class="pagination" role="navigation" aria-label="Pagination">
                                                    <li class="<?php echo esc_html( $value['session_1'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=1' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_2'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=2' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_3'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=3' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_4'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=4' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_5'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=5' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_6'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=6' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_7'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=7' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_8'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=8' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_9'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=9' );?>">1</a>
                                                    </li>
                                                     <li class="<?php echo esc_html( $value['session_10'] ? 'current' : '' ); ?>">
                                                        <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $key . '&session=10' );?>">1</a>
                                                    </li>
                                                </ul>


                                                    <a href="<?php echo esc_html(zume_course_url() . '/?group=' . $key . '&session=' . $value['next_session']); ?>" class="button large">
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

                            <?php if ( $zume_no_groups < 1 ) : ?>

                            <div class="grid-x grid-margin-x vertical-padding">
                                <div class="large-8 large-offset-2 cell center">
                                    <p><strong> <?php echo esc_html__( 'You are currently in a group', 'zume' ) ?></strong></p>
                                    <p><?php echo esc_html__( "You will need at least four people gathered together to start each new session.
                                        Please start a group below. If you intended to join someone else's group, please
                                        return
                                        to the invitation they
                                        sent and use the link provided to be automatically added to that group.", 'zume') ?></p>
                                </div>
                            </div>

                            <?php endif; ?>

                            <p class="center vertical-padding">
                                <button class="button hollow small" data-open="create">Start New Group</button>
                            </p>

                    </div>
                </div>

                <div class="large-3 cell dashboard-messages">

                    <div class="callout" data-equalizer-watch>

                        <?php
                        $zume_coach_id = get_user_meta( $zume_current_user, 'zume_coach', true );
                        if ( ! empty( $zume_coach_id ) ) :
                            $zume_coach_data = get_userdata( $zume_coach_id );
                        ?>

                        <div class="grid-x">
                            <div class="cell vertical-padding">
                                Your Coach

                            </div>
                        </div>

                        <div class="grid-x grid-margin-x">
                            <div class="small-2 cell">
                                <?php echo get_avatar( $zume_coach_id, 32 ) ?>
                            </div>
                            <div class="small-8 cell">
                                <?php echo $zume_coach_data->display_name; ?>
                            </div>
                        </div>

	                    <?php endif; ?>

                        <hr>

                        <div class="grid-x ">
                            <div class="cell vertical-padding">
                                Inactive Groups

                            </div>
                        </div>

	                    <?php
	                    $zume_no_groups = 0;
	                    foreach ( $zume_user_meta as $key => $v ) :
		                    $key_beginning = substr( $key, 0, 10 );
		                    if ( 'zume_group' == $key_beginning ) : // check if zume_group
			                    $value = maybe_unserialize( $v );
			                    if ( true == $value['closed'] ) : // check if closed
				                    ?>

                                    <div class="grid-x">
                                        <div class="small-9 cell">
						                    <?php echo $value['group_name']; ?>
                                        </div>
                                        <div class="small-3 cell">
                                            <a href="">activate</a>
                                        </div>
                                    </div>

				                    <?php
				                    $zume_no_groups ++;
			                    endif; // end if closed check
		                    endif; // end check if zume_group
	                    endforeach;
	                    ?>

                    </div>

                </div>

                <div class="large-1 cell"></div>

            </div>

        </div>

    </div>

</div>

<!-- Create a New Group Modal -->
<div class="small reveal" id="create" data-reveal>
    <h1>Create Group</h1>
    <form action="" method="post">
        <input type="hidden" name="type" value="create"/>
        <input type="hidden" name="ip_address" value="<?php echo esc_html( zume_get_real_ip_address() ); ?>"/>
        <div class="grid-x grid-margin-x">
            <div class="cell">
                <label for="group_name">Group Name</label>
                <input type="text" value="" name="group_name" id="group_name" required/>
            </div>
            <div class="cell">
                <label for="members">Number of Participants</label>
                <input type="text" value="" name="members" id="members" required/>
            </div>
            <div class="cell">
                <label for="meeting_time">Planned Meeting Time</label>
                <input type="text" value="" name="meeting_time" id="meeting_time" required/>
            </div>
            <div class="cell">
                <label for="address">Address</label>
                <input type="text" value="" placeholder="Please enter the full address for the group meeting"
                       name="address" id="address" required/>
            </div>
            <div class="cell">
                <br>
                <button type="submit" class="button">Submit</button>
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
    $zume_no_groups     = 0;
    if ( $key_beginning == 'zume_group' ) {
        $value = unserialize( $v );
        ?>

        <!-- Edit current groups section -->
        <div class="small reveal" id="<?php echo esc_html( $key ); ?>" data-reveal>
            <h1>Edit Group</h1>
            <form method="post">

                <input type="hidden" name="key" value="<?php echo esc_html( $key ); ?>"/>
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <label for="group_name">Group Name</label>
                        <input type="text" value="<?php echo esc_html( $value['group_name'] ); ?>" name="group_name" id="group_name" required/>
                    </div>
                    <div class="cell">
                        <label for="members">Number of Participants</label>
                        <input type="text" value="<?php echo esc_html( $value['members'] ); ?>" name="members" id="members" required/>
                    </div>
                    <div class="cell">
                        <label for="meeting_time">Planned Meeting Time</label>
                        <input type="text" value="<?php echo esc_html( $value['meeting_time'] ); ?>" name="meeting_time" id="meeting_time" required/>
                    </div>
                    <div class="cell">
                        <label for="address">Address</label>
                        <input type="text" value="<?php echo esc_html( $value['address'] ); ?>" name="address"
                               id="address" required/>
                    </div>
                    <div class="cell">
                        <br>
                        <button type="submit" class="button" name="type" value="edit">Update</button>
                        <span class="align-right"><button type="submit" class="button hollow alert" name="type" value="delete">Delete</button></span>
                        <span class="align-right"><button type="submit" class="button hollow alert" name="type" value="closed">Make Inactive</button></span>
                    </div>
                </div>

                <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
            </form>
        </div>

        <?php
        $zume_no_groups ++;
    }
}

?>

<?php

})();

get_footer(); ?>

