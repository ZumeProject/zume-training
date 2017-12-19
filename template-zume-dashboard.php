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
$zume_user_meta    = zume_get_user_meta( $zume_current_user );

?>

<div id="content">

    <div id="inner-content" class="grid-x grid-margin-x">

        <div id="main" class="cell" role="main">

            <div class="grid-x grid-margin-x " data-equalizer data-equalize-on="large" id="test-eq">
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
                                            <h3><a data-open="<?php echo esc_html( $zume_key ); ?>"><?php echo esc_html( $zume_value['group_name'] ) ?></a>
                                            </h3>
                                            <p class="text-gray">
                                                <?php echo esc_html( __( 'Meeting Time', 'zume' ) . ": " .  $zume_value['meeting_time'] ) ?><br>
                                                <?php echo esc_html( __( 'Members', 'zume' ) . ': ' . $zume_value['members'] )?><br>
                                                <?php echo esc_html( __( 'Address', 'zume' ) . ': ' . $zume_value['address'] )?><br>
                                            </p>

                                            <button class="small" data-open="<?php echo esc_html( $zume_key ); ?>">
                                                <i class="fi-pencil hollow"></i> <?php echo esc_html__( 'edit', 'zume' ) ?>
                                            </button>
                                        </div>
                                        <div class="large-6 cell">
                                            <ul class="pagination" role="navigation" aria-label="Pagination">
                                                <li class="<?php echo esc_html( $zume_value['session_1'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=1' );?>">1</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_2'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=2' );?>">2</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_3'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=3' );?>">3</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_4'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=4' );?>">4</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_5'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=5' );?>">5</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_6'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=6' );?>">6</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_7'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=7' );?>">7</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_8'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=8' );?>">8</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_9'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=9' );?>">9</a>
                                                </li>
                                                 <li class="<?php echo esc_html( $zume_value['session_10'] ? 'current' : '' ); ?>">
                                                    <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=10' );?>">10</a>
                                                </li>
                                            </ul>

                                            <!-- Next Session Button -->
                                            <?php if ( ! 0 == $zume_value['next_session'] ) : ?>
                                            <a href="<?php echo esc_html( zume_course_url() . '/?group=' . $zume_key . '&session=' . $zume_value['next_session'] ); ?>" class="button large">
                                                <?php echo esc_html( __( 'Start Next Session ', 'zume' ) . $zume_value['next_session'] );?>
                                            </a>
                                            <?php else : ?>
                                                <!-- Close group button -->
                                            <form method="post">
                                                <input type="hidden" name="key" value="<?php echo esc_html( $zume_key ); ?>"/>
                                                <span><button type="submit" class="button hollow alert" name="type" value="closed"><?php echo esc_html__( 'Close Group', 'zume' ) ?></button></span>
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
                                    <h4><strong><?php echo esc_html__( 'You are not currently in a group', 'zume' ) ?></strong></h4>
                                    <p>
                                        <?php echo esc_html__( "You will need at least four people gathered together to start each new session. Please start a group below. If you intended to join someone else's group, please return to the invitation they sent and use the link provided to be automatically added to that group.", 'zume' ) ?></p>
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
                    $zume_html = '';
                    foreach ( $zume_user_meta as $zume_key => $v ) :
                        $zume_key_beginning = substr( $zume_key, 0, 10 );
                        if ( 'zume_group' == $zume_key_beginning ) : // check if zume_group
                            $zume_value = maybe_unserialize( $v );
                            if ( isset( $zume_value['closed'] ) && true == $zume_value['closed'] ) : // check if closed

                                $zume_html .= '<div class="grid-x grid-margin-x"><div class="small-1 cell"></div><div class="small-8 cell">';
                                $zume_html .= esc_html( $zume_value['group_name'] );
                                $zume_html .= '</div><div class="small-2 cell">';
                                $zume_html .= '<button class="small button hollow" type="submit" name="key" value="'. esc_attr( $zume_key ).'">' . esc_html__( 'activate', 'zume' ) . '</button>';
                                $zume_html .= '</div><div class="small-1 cell"></div></div>';

                                $zume_no_inactive_groups++;
                            endif; // end if closed check
                        endif; // end check if zume_group
                    endforeach;

                    ?>

                    <?php if ( $zume_no_inactive_groups > 0 ) : ?>

                        <div class="callout" >

                            <div class="grid-x ">
                                <div class="cell vertical-padding center">
                                    <h3><?php echo esc_html__( 'Closed Groups', 'zume' ) ?></h3>
                                    <hr>
                                </div>
                            </div>

                            <form action="" method="post">
                                <input type="hidden" name="type" value="activate" />
                                <?php
                                    // @codingStandardsIgnoreLine
                                    echo $zume_html ?>
                            </form>

                        </div>
                    <?php endif; ?>
                    <!-- End Inactive Groups Section -->

                </div> <!-- End Left Column -->

                <!-- Right Column -->
                <div class="large-3 cell dashboard-messages">

                    <div class="callout" data-equalizer-watch>

                        <!-- Your Coach Section -->
                        <?php
                        $zume_coach_id = get_user_meta( $zume_current_user, 'zume_coach', true );
                        if ( ! empty( $zume_coach_id ) ) :
                            $zume_coach_data = get_userdata( $zume_coach_id );
                        ?>

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
                        <hr>

                        <?php endif; ?>

                        <!-- TOOLS SECTION -->
                        <?php
                        $zume_highest_session = Zume_Dashboard::get_highest_session( $zume_current_user );

                        if ( $zume_highest_session > 1 ) {
                            ?>
                            <!-- Section top -->
                            <div class="grid-x grid-margin-x grid-margin-y">
                                <div class="cell">
                                    <h3 class="center padding-bottom"><?php esc_html_e( 'Tools You\'ve Gained', 'zume' ) ?></h3>
                                    <!--end section top-->

                                    <div class="grid-x grid-margin-y">
                                        <div class="large-2 cell">
                                            <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-2.png"
                                                 alt=""
                                                 width="20" height="20" class="alignnone size-full wp-image-1035"/>
                                        </div>
                                        <div class="large-10 cell">
                                            <?php esc_html_e( 'S.O.A.P.S. BIBLE READING', 'zume' ) ?>
                                        </div>
                                    </div>
                                    <div class="grid-x grid-margin-y grid-margin-y">
                                        <div class="large-2 cell">
                                            <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-2.png"
                                                 alt=""
                                                 width="20" height="20" class="alignnone size-full wp-image-1567"/>
                                        </div>
                                        <div class="large-10 cell">
                                            <?php esc_html_e( 'ACCOUNTABILITY GROUPS', 'zume' ) ?>
                                        </div>
                                    </div>
                                    <div class="grid-x grid-margin-y">
                                        <div class="large-2 cell">
                                            <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>concept-3-2.png"
                                                 alt="" width="20" height="20" class="alignnone size-full wp-image-1566"/>
                                        </div>
                                        <div class="large-10 cell">
                                            <?php esc_html_e( 'SPIRITUAL BREATHING', 'zume' ) ?>
                                        </div>
                                    </div>
                            <?php
                        }
                        if ( $zume_highest_session > 2 ) {
                            ?>

                            <div class="grid-x grid-margin-y">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-1-6.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1577"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( 'PRAYER CYCLE', 'zume' ) ?>
                                </div>
                            </div>
                            <div class="grid-x grid-margin-y grid-margin-y">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-2-2.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1578"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( 'LIST OF 100', 'zume' ) ?>
                                </div>
                            </div>

                            <?php
                        }
                        if ( $zume_highest_session > 3 ) {
                            ?>

                            <div class="grid-x grid-margin-y">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-1-1.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1183"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( 'BAPTISM', 'zume' ) ?>
                                </div>
                            </div>

                            <?php
                        }
                        if ( $zume_highest_session > 4 ) {
                            ?>

                            <div class="grid-x grid-margin-y">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-1.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1035"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( '3-MINUTE TESTIMONY', 'zume' ) ?>
                                </div>
                            </div>
                            <div class="grid-x grid-margin-y grid-margin-y">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-2-3.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1186"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( 'THE LORD\'S SUPPER', 'zume' ) ?>
                                </div>
                            </div>

                            <?php
                        }
                        if ( $zume_highest_session > 5 ) {
                            ?>

                            <div class="grid-x grid-margin-y">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-4.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1035"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( 'PRAYER WALKING', 'zume' ) ?>
                                </div>
                            </div>

                            <?php
                        }
                        if ( $zume_highest_session > 6 ) {
                            ?>

                            <div class="grid-x grid-margin-y">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-5.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1035"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( '3/3 GROUP FORMAT', 'zume' ) ?>
                                </div>
                            </div>

                            <?php
                        }
                        if ( $zume_highest_session > 10 ) {
                            ?>

                            <div class="grid-x grid-margin-y">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>tool-1-7.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1572"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( 'PEER MENTORING GROUPS', 'zume' ) ?>
                                </div>
                            </div>
                            <div class="grid-x grid-margin-y grid-margin-x">
                                <div class="large-2 cell">
                                    <!-- image -->
                                    <img src="<?php echo esc_url( zume_images_uri( 'overview' ) ); ?>practice-1-5.png"
                                         alt="" width="20" height="20" class="alignnone size-full wp-image-1574"/>
                                </div>
                                <div class="large-10 cell"><?php esc_html_e( 'COACHING CHECKLIST', 'zume' ) ?></div>
                            </div>

                            <?php
                        }
                        if ( $zume_highest_session > 1 ) {
                            ?><!-- Bottom section -->
                                </div>
                            </div>
                            <hr>
                        <!--end bottom section-->
                            <?php
                        }

                        ?>


                        <!-- Instructions for what to do -->
                        <div class="grid-x">
                            <div class="cell center">
                                <h3 class="center padding-bottom"><?php echo esc_html__( 'Instructions', 'zume' ) ?></h3>
                            </div>
                        </div>

                        <div class="grid-x grid-margin-x">
                            <div class="cell">
                               <ul>
                                   <li><?php esc_html_e( "Create a group", 'zume' ) ?> <?php if ( $zume_no_groups > 0 ) { print '<span class="primary-color">&#10004;</span>'; } ?></li>
                                   <li><?php esc_html_e( "Plan a time and invite friends", 'zume' ) ?></li>
                                   <li><?php esc_html_e( "Explore the upcoming session", 'zume' ) ?></li>
                               </ul>
                            </div>
                        </div>

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
        <input type="hidden" name="ip_address" value="<?php echo esc_html( Zume_Google_Geolocation::get_real_ip_address() ); ?>"/>
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
                <label for="validate_addressnew">Address</label>
                <div class="input-group">
                    <input type="text"
                           placeholder="example: 1000 Broadway, Denver, CO 80126"
                           class="profile-input input-group-field"
                           name="validate_address"
                           id="validate_addressnew"
                           value=""
                    />
                    <div class="input-group-button">
                        <input type="button" class="button" onclick="validate_group_address( jQuery('#validate_addressnew').val(), 'new')" value="Validate" id="validate_address_buttonnew">
                    </div>
                </div>

                <div id="possible-resultsnew">
                    <input type="hidden" name="address" value="" />
                </div>

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
foreach ( $zume_user_meta as $zume_key => $v ) {
    $zume_key_beginning = substr( $zume_key, 0, 10 );
    if ( 'zume_group' == $zume_key_beginning ) {
        $zume_value = unserialize( $v );
        ?>

        <!-- Edit current groups section -->
        <div class="small reveal" id="<?php echo esc_html( $zume_key ); ?>" data-reveal>
            <h1><?php echo esc_html__( 'Edit Group', 'zume' ) ?></h1>
            <form data-abide method="post">

                <input type="hidden" name="key" value="<?php echo esc_html( $zume_key ); ?>"/>
                <div class="grid-x grid-margin-x">
                    <div class="cell">
                        <label for="group_name"><?php echo esc_html__( 'Group Name', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $zume_value['group_name'] ); ?>" name="group_name" id="group_name" required/>
                    </div>
                    <div class="cell">
                        <label for="members"><?php echo esc_html__( 'Number of Participants', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $zume_value['members'] ); ?>" name="members" id="members" required/>
                    </div>
                    <div class="cell">
                        <label for="meeting_time"><?php echo esc_html__( 'Planned Meeting Time', 'zume' ) ?></label>
                        <input type="text" value="<?php echo esc_html( $zume_value['meeting_time'] ); ?>" name="meeting_time" id="meeting_time" required/>
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
                                <input type="button" class="button" onclick="validate_group_address( jQuery('#validate_address<?php echo esc_html( $zume_key ); ?>').val(), '<?php echo esc_html( $zume_key ); ?>')" value="Validate" id="validate_address_button<?php echo esc_html( $zume_key ); ?>">
                            </div>
                        </div>

                        <div id="possible-results<?php echo esc_html( $zume_key ); ?>">
                            <input type="hidden" name="address" value="<?php echo isset( $zume_value['address'] ) ? esc_html( $zume_value['address'] ) : ''; ?>" />
                        </div>

                        <?php if ( ! empty( $zume_value['address'] ) && ! empty( esc_attr( $zume_value['lng'] ) ) && ! empty( esc_attr( $zume_value['lat'] ) ) ) : ?>
                            <div id="map<?php echo esc_html( $zume_key ); ?>" >
                                <img src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo esc_attr( $zume_value['lat'] ) . ',' . esc_attr( $zume_value['lng'] ) ?>&zoom=5&size=600x250&markers=color:red|<?php echo esc_attr( $zume_value['lat'] ) . ',' . esc_attr( $zume_value['lng'] ) ?>&key=<?php echo esc_attr( Zume_Google_Geolocation::$key ); ?>" />
                            </div>
                        <?php endif; ?>
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

get_footer();
