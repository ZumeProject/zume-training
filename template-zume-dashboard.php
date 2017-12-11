<?php
/*
Template Name: Zúme Dashboard
*/

if ( ! empty( $_POST ) ) {
    if ( ! empty( $_POST['type'] ) && $_POST['type'] == 'create' ) {
        Zume_Dashboard::create_group( $_POST );
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'edit' ) {
        Zume_Dashboard::edit_group( $_POST );
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'inactive' ) {
//        Zume_Dashboard::delete_group( $_POST );
    } elseif ( ! empty( $_POST['type'] ) && $_POST['type'] == 'delete' ) {
        Zume_Dashboard::delete_group( sanitize_key( wp_unslash( $_POST['key'] ) ) );
    } else {
        zume_write_log( 'Failed to filter' );
    }
}

$zume_current_lang = zume_current_language();
$zume_current_user = get_current_user_id();
$zume_user_meta    = array_map( function ( $a ) { return $a[0];
}, get_user_meta( $zume_current_user ) );

get_header();

?>

<div id="content">

    <div id="inner-content" class="grid-x">

        <div id="main" class="cell" role="main">

            <!-- First Row -->
            <div class="grid-x grid-margin-x" data-equalizer data-equalize-on="large" id="test-eq">
                <div class="large-1 cell"></div>
                <div class="large-7 cell">

                    <div class="callout" data-equalizer-watch>

                        <ul id="groups-list" class="item-list">
                            <li class="block">
                                <h2 class="center">Your Groups</h2>
                            </li>

                            <?php
                            $zume_no_groups = 0;
                            foreach ( $zume_user_meta as $key => $v ) {
                                $key_beginning = substr( $key, 0, 10 );
                                if ( 'zume_group' == $key_beginning ) {
                                    $value = maybe_unserialize( $v );
                                    ?>
                                    <!-- Group Row -->
                                    <li class="block">
                                        <div class="grid-x grid-margin-x">
                                            <div class="large-6 cell">
                                                <h3><a data-open="<?php echo $key; ?>"><?php echo $value['group_name'] ?></a>
                                                </h3>
                                                <p class="text-gray">
                                                    Meeting Time: <?php echo $value['meeting_time'] ?><br>
                                                    Members: <?php echo $value['members'] ?><br>
                                                    Address: <?php echo $value['address'] ?><br>
                                                </p>

                                                <button class="small" data-open="<?php echo $key; ?>">
                                                    <i class="fi-pencil hollow"></i> edit
                                                </button>
                                            </div>
                                            <div class="large-6 cell">
                                                <ul class="pagination" role="navigation" aria-label="Pagination">
                                                    <li class="<?php ( $value['session_1'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=1'; ?>">1</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_2'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=2'; ?>">2</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_3'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=3'; ?>">3</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_4'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=4'; ?>">4</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_5'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=5'; ?>">5</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_6'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=6'; ?>">6</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_7'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=7'; ?>">7</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_8'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=8'; ?>">8</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_9'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=9'; ?>">9</a>
                                                    </li>
                                                    <li class="<?php ( $value['session_10'] ) ? print 'current' : print ''; ?>">
                                                        <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=10'; ?>">10</a>
                                                    </li>
                                                </ul>

                                                <div class="button-group">
                                                    <a href="<?php echo zume_course_url() . '/?group=' . $key . '&session=' . $value['next_session']; ?>" class="button hollow">
                                                        Start Next Session <?php print $value['next_session'] ?>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </li>
                                    <?php
                                    $zume_no_groups++;
                                }
                            }

                            ?>

                            <?php if ( $zume_no_groups < 1 ) : ?>

                            <div class="grid-x grid-margin-x vertical-padding">
                                <div class="large-8 large-offset-2 cell center">
                                    <p><strong>You do not currently have a group.</strong></p>
                                    <p>You will need at least four people gathered together to start each new session.
                                        Please start a group below. If you intended to join someone else's group, please
                                        return
                                        to the invitation they
                                        sent and use the link provided to be automatically added to that group.</p>
                                </div>
                            </div>

                            <?php endif; ?>

                            <p class="center vertical-padding">
                                <button class="button hollow" data-open="create">Start New Group</button>
                            </p>

                    </div>
                </div>

                <div class="large-3 cell dashboard-messages">
                    <div class="callout" data-equalizer-watch>
                        <h2 class="center">Your Coach</h2>
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
        <input type="hidden" name="ip_address" value="<?php echo zume_get_real_ip_address(); ?>"/>
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
        <div class="small reveal" id="<?php echo $key; ?>" data-reveal>
            <h1>Edit Group</h1>
            <form method="post">

                <input type="hidden" name="key" value="<?php echo $key; ?>"/>
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <label for="group_name">Group Name</label>
                        <input type="text" value="<?php echo $value['group_name']; ?>" name="group_name" id="group_name" required/>
                    </div>
                    <div class="cell">
                        <label for="members">Number of Participants</label>
                        <input type="text" value="<?php echo $value['members']; ?>" name="members" id="members" required/>
                    </div>
                    <div class="cell">
                        <label for="meeting_time">Planned Meeting Time</label>
                        <input type="text" value="<?php echo $value['meeting_time']; ?>" name="meeting_time" id="meeting_time" required/>
                    </div>
                    <div class="cell">
                        <label for="address">Address</label>
                        <input type="text" value="<?php echo $value['address']; ?>" name="address"
                               id="address" required/>
                    </div>
                    <div class="cell">
                        <br>
                        <button type="submit" class="button" name="type" value="edit">Update</button>
                        <span class="align-right"><button type="submit" class="button hollow alert" name="type" value="delete">Delete</button></span>
                        <span class="align-right"><button type="submit" class="button hollow alert" name="type" value="inactive">Make Inactive</button></span>
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

<?php get_footer(); ?>

