<?php
/*
Template Name: Zúme Dashboard
*/

get_header();

?>

<div id="content">

    <div id="inner-content" class="grid-x">

        <div id="main" class="cell" role="main">


            <!-- First Row -->
            <div class="grid-x grid-margin-x" data-equalizer data-equalize-on="large" id="test-eq">
                <div class="large-1 cell"></div>
                <div class="large-10 cell">
                    <div class="callout" data-equalizer-watch>
                        <h2 class="center">Your Groups</h2>


                            <ul id="groups-list" class="item-list">


                                    <li>
                                        <div class="grid-x">
                                            <div class="large-5 columns gutter-large">
                                                <div class="item-avatar">
                                                    <a href=""><img src="http://placehold.it/30x30" /></a>
                                                </div>
                                                <div>
                                                    <div class="item-title">
                                                        <a href="">group name</a>
                                                    </div>
                                                    <div class="wp-caption-text">
                                                        description
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="large-3 cell gutter-large center dashboard-group-images">

                                            </div>
                                            <div class="large-4 cell gutter-large center">
                                                <div class="button-group">

                                                    <a href=""
                                                       class=" button  ">Invite</a>

                                                    <span class="hide-for-medium"><br></span>
                                                    <a href="/zume-training/?id=10&group_id="
                                                               class="button   ">See Sessions</a>
                                                               <a href="/zume-training/?id=&group_id="
                                                               class="button   ">Start
                                                                Session #</a>

                                                </div>
                                            </div>


                                            <div class="clear"></div>
                                        </div>
                                    </li>

                            </ul>


                            <div style="background: url('<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/noun_attention.png'; ?>') top left no-repeat;
                                    padding-left:55px;
                                    background-size:50px">
                                <p style="padding: 10px"><strong>You are currently not in a group.</strong><br>
                                    You will need at least four people gathered together to start each new session.
                                    Please start a group below.
                                    If you intended to join someone else's group, please return to the invitation they
                                    sent and use
                                    the link provided to be automatically added to that group.
                            </div>


                        <p class="center">
                            <a href="/groups/create/" class="button">Start New Group</a>
                        </p>
                    </div>
                </div>
                <div class="large-1 cell"></div>
            </div>


            <!-- Second Row -->
            <div class="grid-x grid-margin-x" data-equalizer data-equalize-on="large" id="test-eq">
                <div class="large-1 cell"></div>
                <div class="large-7 cell dashboard-coaches" id="your-coaches">

                    <div class="callout" data-equalizer-watch>

                            <h2 class="center">Your Coach</h2>

                                <ul id="groups-list" class="item-list">

                                    <li class="coach-item">

                                        <div class="coach-item__intro">

                                            <a href=""
                                               class="btn button" style="margin-bottom: 0">
                                                Private Message</a>
                                            <a href=""><img src="http://placehold.it/30x30" /></a>

                                        </div>

                                        <div class="coach-item__text">


                                            <?php esc_html_e( "for groups:" ); ?>

                                            <a href="">
                                                Group Name
                                            </a>



                                        </div>
                                    </li>
                                </ul>




                            <h2 class="center">Your Coach</h2>
                            <div style="background: url('<?php echo esc_attr( get_stylesheet_directory_uri() ) . '/assets/images/noun_attention.png'; ?>') top left no-repeat;
                                    padding-left:55px;
                                    background-size:50px">
                                <p style="padding: 10px">
                                    Every group will be assigned a live coach who will help mentor you during the
                                    disciple-making process and help keep you accountable.
                                    When your coach is assigned you'll see his/her name here and you'll be able to send
                                    a private message.
                                </p>
                            </div>


                    </div>
                </div>


                <div class="large-3 cell dashboard-messages">
                    <div class="callout" data-equalizer-watch>
                        <h2 class="center">Messages</h2>

                        <p class="center" style="margin-top: 15px">
                            <a href="/messages/"
                               class="button">View Messages</a>
                        </p>
                        <p class="center text-gray text-small">

                        </p>
                    </div>
                </div>
                <div class="large-1 cell"></div>
            </div>


        </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>

