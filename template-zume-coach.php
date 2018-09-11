<?php
/*
Template Name: Zume Coach
*/
zume_force_login();

if ( isset( $_POST['assign'] ) ) {
    Zume_Coach::assign( $_POST );
}

$zume_user_id = get_current_user_id();

?>

<?php get_header(); ?>

    <div id="content"class="grid-x grid-padding-x"><div class="cell">

        <div id="inner-content" class="grid-x grid-margin-x grid-margin-y" data-equalizer data-equalize-on="large">

            <div class="large-1 cell"></div>

            <div  class="large-7 cell">

                <div class="callout" data-equalizer-watch>

                    <h2 class="center vertical-padding"><?php echo esc_html__( 'Your Assigned People', 'zume' ) ?></h2>

                    <table class="hover stack">
                        <thead>
                            <tr>
                                <th><?php echo esc_html__( 'Name', 'zume' ) ?></th>
                                <th><?php echo esc_html__( 'Email', 'zume' ) ?></th>
                                <th><?php echo esc_html__( 'Phone', 'zume' ) ?></th>
                                <th><?php echo esc_html__( 'Last Active', 'zume' ) ?></th>
                                <th><?php echo esc_html__( 'Groups', 'zume' ) ?></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $zume_assignees = Zume_Coach::zume_get_coach_assignees( $zume_user_id );

                        foreach ( $zume_assignees as $value ) :
                            $zume_user = get_userdata( $value['user_id'] );
                            $zume_user_meta = get_user_meta( $value['user_id'] );
                            $zume_group_count = Zume_Coach::count_zume_groups_by_user( $value['user_id'] );
                            ?>

                        <tr>
                            <td><?php echo esc_attr( $zume_user->display_name ); ?></td>
                            <td><?php echo esc_attr( $zume_user->user_email ); ?></td>
                            <td><?php echo esc_attr( $zume_user_meta['zume_phone'][0] ); ?></td>
                            <td><?php echo esc_attr( $zume_user_meta['zume_last_active'][0] ); ?></td>
                            <td><?php echo esc_attr( $zume_group_count ); ?></td>
                        </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>



                </div>
            </div> <!-- end #main -->

            <div class="large-3 cell">

                <div class="callout" data-equalizer-watch>

                <?php if ( current_user_can( 'coach_leader' ) ) : ?>

                <!-- Assign users to coaches -->

                    <form action="" method="post">
                        <p class="center"><?php echo esc_html__( 'Assign Coach to Member', 'zume' ) ?></p>

                        <div class="grid-x">
                            <div class="cell">
                                <label for="user"><?php echo esc_html__( 'User to be assigned', 'zume' ) ?></label>
                                <select id="user" name="user_id">
                                    <?php
                                    $zume_unassigned_users = Zume_Coach::zume_get_unassigned_users();
                                    foreach ( $zume_unassigned_users as $value ) :
                                        $zume_user_data = get_userdata( $value['user_id'] );
                                        ?>

                                        <option value="<?php echo esc_attr( $value['user_id'] ); ?>"><?php echo esc_attr( $zume_user_data->display_name ); ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="cell">
                                <label for="coach">Coach<?php echo esc_html__( 'Groups', 'zume' ) ?></label>
                                <select id="coach" name="coach_id">
                                    <?php
                                    $zume_unassigned_users = Zume_Coach::zume_get_coaches();
                                    foreach ( $zume_unassigned_users as $value ) :
                                        $zume_user_data = get_userdata( $value['user_id'] );
                                        ?>

                                        <option value="<?php echo esc_attr( $value['user_id'] ); ?>"><?php echo esc_attr( $zume_user_data->display_name ); ?></option>

                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="cell">

                            </div>
                            <div class="cell">
                                <button type="submit" class="button" name="assign" value="true"><?php echo esc_html__( 'Assign', 'zume' ) ?></button>
                            </div>

                        </div>

                    </form>

                <?php endif; // end if coach_leader can ?>

                </div>

            </div>

            <div class="large-1 cell"></div>

        </div> <!-- end #inner-content -->

        </div> <!-- cell -->
    </div><!-- end #content -->

<?php get_footer(); ?>