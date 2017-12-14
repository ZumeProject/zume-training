<?php
/*
Template Name: Zúme Course
*/
zume_force_login();

/**
 * Template for the Zume Course content
 */

if ( empty( $_GET['group'] ) || empty( $_GET['session'] ) ) {
    wp_die( 'You are missing your group or session number. <a href="/">Head back to your dashboard</a>' );
}
$zume_group_key = sanitize_key( wp_unslash( $_GET['group'] ) );
$zume_session   = sanitize_key( wp_unslash( $_GET['session'] ) );

$zume_current_user = get_current_user_id();
$zume_user_meta = zume_get_user_meta( $zume_current_user );

get_header();

?>

    <div id="content">

        <div id="inner-content" class="grid-x grid-margin-x">

            <div class="large-1 cell"></div>

            <div id="main" class="large-10 cell" role="main">

                <?php
                /**
                 * Load Zume Course Content
                 */
                isset( $_POST['viewing'] ) ? $isset_viewing = true : $isset_viewing = false;
                if ( $isset_viewing ) { // check if member check is complete
                    $viewing = sanitize_key( wp_unslash( $_POST['viewing'] ) );
                    if ( isset( $_POST['members'] ) ) {
                        $members = sanitize_key( wp_unslash( $_POST['members'] ) );
                    }
                    switch ( $viewing ) {
                        case 'group':
                            Zume_Course::update_session_complete( $zume_group_key, $zume_session );
                            Zume_Course_Content::get_course_content( $zume_session );
                            zume_insert_log( [
                                'user_id'  => get_current_user_id(),
                                'group_id' => $zume_group_key,
                                'page'     => 'course',
                                'action'   => 'session_' . $zume_session,
                                'meta'     => 'group_' . $members,
                            ] );
                            break;
                        case 'member':
                            Zume_Course::update_session_complete( $zume_group_key, $zume_session );
                            Zume_Course_Content::get_course_content( $zume_session );
                            zume_insert_log( [
                                'user_id'  => get_current_user_id(),
                                'group_id' => $zume_group_key,
                                'page'     => 'course',
                                'action'   => 'session_' . $zume_session,
                                'meta'     => 'member_' . $members,
                            ] );
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
                            wp_die( 'You need a correctly formatted URL. This can happen if you came here from somewhere other than the dashboard. <a href="/">Head back to your dashboard and try again.</a>' );
                            break;
                    }
                } else {
                    Zume_Course_Content::course_start_panel( $zume_session, $zume_user_meta[$zume_group_key] );
                }

                ?>

            </div> <!-- end #main -->

            <div class="large-1 cell"></div>

        </div> <!-- end #inner-content -->

    </div> <!-- end #content -->

<?php get_footer(); ?>


<?php

/**
 * Class Zume_Course_Content
 * Below is the HTML for the content of the Zume Course
 */
class Zume_Course_Content {

    public static function get_course_content( $session_id ) {
        ?>
        <h2 class="center padding-bottom">Session <?php echo $session_id; ?></h2>

        <script>
            jQuery(document).ready(function ($) {
                "use strict";
                var startIndex = 0;
                if (!isNaN(parseInt(window.location.hash.substr(2)))) {
                    startIndex = parseInt(window.location.hash.substr(2)) - 1;
                }

                jQuery("#session").steps({
                    // Disables the finish button (required if pagination is enabled)
                    enableFinishButton: true,
                    // Disables the next and previous buttons (optional)
                    enablePagination: true,
                    // Enables all steps from the begining
                    enableAllSteps: false,
                    startIndex: startIndex,
                    headerTag: "h3",
                    bodyTag: "section",
                    transitionEffect: "fade",
                    autoFocus: true,
                    onStepChanged: function (event, currentIndex, priorIndex) {
                        var newHash = "#s" + (currentIndex + 1);
                        <?php /* Replaces window.location.hash without creating
                        a history entry, and without scrolling or jumping, and
                        without triggering hashchange */ ?>
                        history.replaceState(null, null, newHash);
                    },

                    onFinishing: function (event, currentIndex) {
                        window.location.replace("<?php echo zume_dashboard_url() ?>")
                    },
                    // Removes the number from the title
                    titleTemplate: '<span class="number">#index#</span> #title#'
                });
                window.addEventListener("hashchange", function (event) {
                    <?php /* This can get triggered when Overview menu items
                    get clicked */ ?>
                    var hash = event.newURL.substr(event.newURL.indexOf("#"));
                    if (!isNaN(parseInt(hash.substr(2)))) {
                        var stepIndex = parseInt(hash.substr(2)) - 1;
                        $("#session .steps a#session-t-" + stepIndex).click();
                    }
                });

            });

        </script>
        <div id="session" class="course-steps">
            <?php

            switch ( $session_id ) {
                case '1':
                    self::get_course_content_1();
                    break;
                case '2':
                    self::get_course_content_2();
                    break;
                case '3':
                    self::get_course_content_3();
                    break;
                case '4':
                    self::get_course_content_4();
                    break;
                case '5':
                    self::get_course_content_5();
                    break;
                case '6':
                    self::get_course_content_6();
                    break;
                case '7':
                    self::get_course_content_7();
                    break;
                case '8':
                    self::get_course_content_8();
                    break;
                case '9':
                    self::get_course_content_9();
                    break;
                case '10':
                    self::get_course_content_10();
                    break;
                default:
                    break;
            }
            ?>
        </div>
        <?php
    }

    public static function course_start_panel( $zume_session, $zume_group_meta ) {
        ?>
        <h3></h3>
        <section><!-- Step Title -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4"></div>
                <div class="large-4 cell center">
                    <p>Welcome to Session <?php echo $zume_session; ?></p>
                    <h2>Which are you doing right now?</h2>
                    <br>
                    <button class="button large expanded" data-open="group">Facilitating a Group
                    </button>
                    <br>
                    <button class="button large expanded" data-open="member">Participating in a Group
                    </button>
                    <br>
                    <form action="" method="post">
                    <button type="submit" class="button large expanded" name="viewing" value="explore">Exploring the Session Content
                    </button>
                    </form>

                </div>
                <div class="large-4"></div>
            </div>

            <!-- Modal for group -->
            <div class="small reveal" id="group" data-reveal>
                <div class="grid-x">
                    <div class="small-4 cell"></div>
                    <div class="small-4 cell center">
                        <form action="" method="post">
                            <label for="members">How many are with you?</label>
                            <select id="members" name="members" >
                                <?php
                                $zume_group_meta = maybe_unserialize( $zume_group_meta );
                                $i = 1;
                                while( 16 > $i ) {
                                    echo '<option value="'.$i.'"';
                                    if( $zume_group_meta['members'] == $i ) {
                                        echo 'selected';
                                    }
                                    echo '>'.$i.'</option>';
                                    $i++;
                                }
                                ?>
                            </select>
                            <button type="submit" name="viewing" class="button" value="group">Continue</button>
                        </form>
                    </div>
                    <div class="small-4 cell"></div>
                </div>

            </div>

            <div class="small reveal" id="member" data-reveal>
                <div class="grid-x">
                    <div class="small-4 cell"></div>
                    <div class="small-4 cell center">
                        <form action="" method="post">
                            <label for="members">How many are in your group?</label>
                            <select id="members" name="members" >
						        <?php
						        $zume_group_meta = maybe_unserialize( $zume_group_meta );
						        $i = 1;
						        while( 16 > $i ) {
							        echo '<option value="'.$i.'"';
							        if( $zume_group_meta['members'] == $i ) {
								        echo 'selected';
							        }
							        echo '>'.$i.'</option>';
							        $i++;
						        }
						        ?>
                            </select>
                            <button type="submit" name="viewing" class="button" value="member">Continue</button>
                        </form>
                    </div>
                    <div class="small-4 cell"></div>
                </div>

            </div>

        </section>
        <?php
    }

    public static function get_course_content_1() {

        ?>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">WELCOME TO ZÚME</div>
                <!-- step-title cell -->
            </div><!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DOWNLOAD</div>
                <div class="large-8 cell activity-description well">

                    You will be able to follow along on a digital PDF for this session, but please make sure that each
                    member of your group has a printed copy of the materials for future sessions.

                </div>
                <div class="large-8 large-offset-4 cell activity-description">
                    <a class="button"
                       style="background-color: #21336a; color: white;"
                       href="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/files/' ) . zume_current_language() . '/'; ?>zume-guide-4039811470.pdf"
                       target="_blank" rel="noopener">
                        <img class="alignnone size-full wp-image-1321"
                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                             alt="Download" width="29"
                             height="26"/> GUIDEBOOK</a></div>
            </div>
            <!-- grid-x -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">GROUP PRAYER (5min)</div>
            </div>
                <!-- Activity Block -->
                <div class="grid-x grid-margin-x grid-margin-y single">
                    <div class="large-8 cell activity-description well center">

                        Begin with prayer. Spiritual insight and transformation is not possible without the Holy Spirit.
                        Take time as a group to invite Him to guide you over this session.

                    </div>
                </div>
                <!-- grid-x -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">WATCH AND DISCUSS (15min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">God uses ordinary people doing simple things to make a
                    big impact.
                    Watch this video on how God works.
                </div>
            </div>

            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Welcome.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Welcome</a></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">If Jesus intended every one of His followers to obey His
                    Great
                    Commission, why do so few actually make disciples?
                </div>
            </div>
            <!-- grid-x -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">WATCH AND DISCUSS (15min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">What is a disciple? And how do you make one? How do you
                    teach a
                    follower of Jesus to do what He told us in His Great Commission &#8212; to obey all of His commands?
                </div>
            </div>

            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Teach_Them_to_Obey.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Teach Them to Obey</a></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol class="rectangle-list">
                        <li>When you think of a church, what comes to mind?</li>
                        <li>What's the difference between that picture and what's described in the video as a "Simple
                            Church"?
                        </li>
                        <li>Which one do you think would be easier to multiply and why?</li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">WATCH AND DISCUSS (15min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">We breathe in. We breathe out. We're alive. Spiritual
                    Breathing is
                    like that, too.
                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Spiritual_Breathing.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Spiritual Breathing</a>
                    </p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol class="rectangle-list">
                        <li>Why is it essential to learn to hear and recognize God's voice?</li>
                        <li>Is hearing and responding to the Lord really like breathing? Why or why not?</li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->

        </section>
        <h3></h3>
        <section>
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">LISTEN AND READ ALONG (3min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">

                    S.O.A.P.S. BIBLE READING<br><br>

                    Hearing from God regularly is a key element in our personal relationship with Him, and in our
                    ability to stay obediently engaged in what He is doing around us.

                    Find the "S.O.A.P.S. Bible Reading" section in your Zúme Guidebook and listen to the audio overview.

                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_SOAPS.pdf"
                                         target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: SOAPS</a></p>
                </div>
            </div>
            <!-- grid-x -->
        </section>
        <h3></h3>
        <section>
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">LISTEN AND READ ALONG (3min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">

                    ACCOUNTABILITY GROUPS<br><br>

                    The Bible tells us that every follower of Jesus will one day be held accountable for what we do and
                    say and think. Accountability Groups are a great way to get ready!

                    Find the "Accountability Groups" section in your Zúme Guidebook, and listen to the audio below.

                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Accountability_Groups.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Accountability Groups</a>
                </div>
            </div>
            <!-- grid-x -->
        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">PRACTICE (45min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">BREAK UP</div>
                <div class="large-8 cell activity-description">Break into groups of two or three people of the same
                    gender.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">

                    Spend the next 45 minutes working together through Accountability Questions - List 2 in the
                    "Accountability Groups" section of your
                    <a class="btn btn-large next-step zume-purple uppercase bg-white font-zume-purple big-btn btn-wide"
                       href="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/files/' ) . zume_current_language() . '/'; ?>zume-guide-4039811470.pdf"
                       target="_blank" rel="noopener"><i
                                class="glyphicon glyphicon-download-alt"></i> Zúme Guidebook</a>.

                </div>
            </div>
            <!-- grid-x -->

        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">LOOKING FORWARD</div>
                <!-- step-title cell -->
                <div class="center"><br>Congratulations! You've completed Session 1. <br> Below are next steps to take
                    in preparation for the next session.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OBEY</div>
                <div class="large-8 cell activity-description">Begin practicing the S.O.A.P.S. Bible reading between now
                    and your
                    next meeting. Focus on Matthew 5-7, read it at least once a day. Keep a daily journal using the
                    S.O.A.P.S. format.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">Spend time asking God who He might want you to start an
                    Accountability
                    Group with using the tools you've learned in this session. Share this person’s name with the group
                    before you go. Reach out to that person about starting an Accountabilty Group and meeting with you
                    weekly.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Pray that God helps you be obedient to Him and invite Him
                    to work in
                    you and those around you!
                </div>
            </div>
            <!-- grid-x -->

        </section>

        <?php
    }

    public static function get_course_content_2() {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WELCOME BACK!
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>DOWNLOAD</span></div>
                <div class="large-8 cell activity-description">Does everyone have a printed copy of the Zúme Guidebook?
                    If not,
                    please be sure that someone can download the Guidebook and that everyone has access to some paper
                    and a pen or pencil.
                    <br><br>
                    <a href="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/files/' ) . zume_current_language() . '/'; ?>zume-guide-4039811470.pdf"
                       class="btn btn-large next-step zume-purple uppercase bg-white font-zume-purple big-btn btn-wide"
                       target="_blank"><i class="glyphicon glyphicon-download-alt"></i> <span> GUIDEBOOK</span></a>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>CHECK-IN</span></div>
                <div class="large-8 cell activity-description">Before getting started, take some time to
                    check-in.<br><br>At the end
                    of the last session, everyone in your group was challenged in two ways: <br><br>
                    <ol>
                        <li>You were asked to begin practicing the S.O.A.P.S. Bible reading method and keeping a daily
                            journal.
                        </li>
                        <li>You were encouraged to reach out to someone about starting an Accountability Group.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRAY</span></div>
                <div class="large-8 cell activity-description">Ask if anyone in the group has specific needs they'd like
                    the group to
                    pray for. Ask someone to pray and ask God to help in the areas the group shared. Be sure to thank
                    God that He promises in His Word to listen and act when His people pray. And, as always, ask God's
                    Holy Spirit to lead your time, together.
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">If we want to make disciples who multiply &#8212;
                    spiritual producers
                    and not just consumers &#8212; then we need to learn and share four main ways God makes everyday
                    followers more like Jesus:<br><br>
                    <ul>
                        <li>Prayer</li>
                        <li>Scripture</li>
                        <li>Body Life</li>
                        <li>Persecution and Suffering</li>
                    </ul>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Producers_vs_Consumers.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Producers vs Consumers</a>
                    </p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Of the four areas detailed above (prayer, God's Word, etc.), which ones do you already
                            practice?
                        </li>
                        <li> Which ones do you feel unsure about?</li>
                        <li> How ready do you feel when it comes to training others?</li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LISTEN AND READ ALONG (2min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">ZÚME TOOLKIT - PRAYER CYCLE<br><br>
                    The Bible tells us that prayer is our chance to speak to and hear from the same God who created
                    us!<br><br>Find the "Prayer Cycle" section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Prayer_Cycle.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts:Prayer Cycle</a></p>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    PRACTICE THE PRAYER CYCLE (60min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">LEAVE</div>
                <div class="large-8 cell activity-description">Spend the next 60 minutes in prayer individually, using
                    the exercises
                    in "The Prayer Cycle" section of the Zúme Guidebook as a guide.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">RETURN</div>
                <div class="large-8 cell activity-description">Set a time for the group to return and reconnect. Be sure
                    to add a few
                    extra minutes for everyone to both find a quiet place to pray and to make their way back to the
                    group.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>What is your reaction to spending an hour in prayer?</li>
                        <li>How do you feel?</li>
                        <li>Did you learn or hear anything?</li>
                        <li>What would life be like if you made this kind of prayer a regular habit?</li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- LISTEN AND READ ALONG -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LISTEN AND READ ALONG (3min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">ZÚME TOOLKIT - LIST OF 100<br><br>God has already given
                    us the
                    relationships we need to “Go and make disciples.” These are our family, friends, neighbors,
                    co-workers and classmates &#8212; people we’ve known all our lives or maybe just met.<br><br>
                    Being good stewards of these relationships is the first step in multiplying disciples. Start by
                    making a list.<br><br>
                    Find the "List of 100" section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_List_of_100.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: List of 100</a></p>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">PROJECT (30min)</div>

                <!-- Activity Block  -->
                <div class="grid-x grid-margin-x grid-margin-y single">
                    <div class="large-8 cell activity-description well well-lg">CREATE YOUR OWN LIST OF 100<br><br>Have
                        everyone in
                        your group take the next 30 minutes to fill out their own inventory of relationships using the
                        form in the "List of 100" section in your Zúme Guidebook. 
                    </div>
                </div> <!-- grid-x -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING FORWARD
                </div> <!-- step-title cell -->
                <div class="center"><br>Congratulations on finishing Session 2! <br> Below are next steps to take in
                    preparation for the next session.
                </div>

            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OBEY</div>
                <div class="large-8 cell activity-description">Spend time this week praying for five people from your
                    List of 100
                    that you marked as an "Unbeliever" or "Unknown." Ask God to prepare their hearts to be open to His
                    story.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">Ask God who He wants you to share the List of 100 tool
                    with. Share
                    this person's name with the group before you go and reach out to them before the next session.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Pray that God help you be obedient to Him and invite Him
                    to work in
                    you and those around you!
                </div>
            </div> <!-- grid-x -->
        </section>
        <?php
    }

    public static function get_course_content_3() {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING BACK
                </div> <!-- step-title cell -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>CHECK-IN</span></div>
                <div class="large-8 cell activity-description">Before getting started, take some time to
                    check-in.<br><br>At the end
                    of the last session, everyone in your group was challenged in two ways: <br><br>
                    <ol>
                        <li>You were asked to pray for five people from your List of 100 that you marked as an
                            "Unbeliever" or "Unknown."
                        </li>
                        <li>You were encouraged to share how to make a List of 100 with someone.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRAY</span></div>
                <div class="large-8 cell activity-description">Pray and thank God for the results and invite His Holy
                    Spirit to lead
                    your time together.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>OVERVIEW</span></div>
                <div class="large-8 cell activity-description">In this session, you’ll learn how God’s Spiritual Economy
                    works and
                    how God invests more in those who are faithful with what they've already been given. You'll also
                    learn two more tools for making disciples &#8212; sharing God’s Story from Creation to Judgement and
                    Baptism.<br><br>Then, when you're ready, get started!
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">In this broken world, people feel rewarded when they
                    take, when they
                    receive and when they gain more than those around them. But God's Spiritual Economy is different
                    &#8212; God invests more in those who are faithful with what they've already been given.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Spiritual_Economy.pdf"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Spiritual Economy</a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">What are some differences you see between God's Spiritual
                    Economy and
                    our earthly way of getting things done?
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    READ AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">Jesus said, “You will receive power when the Holy Spirit
                    comes upon
                    you. And you will be my witnesses, telling people about me everywhere &#8212; in Jerusalem,
                    throughout Judea, in Samaria, and to the ends of the earth.”<br><br>
                    Jesus believed in His followers so much, He trusted them to tell His story. Then He sent them around
                    the world to do it. Now, He’s sending us.<br><br>
                    There’s no one “best way” to tell God’s story (also called The Gospel), because the best way will
                    depend on who you’re sharing with. Every disciple should learn to tell God’s Story in a way that’s
                    true to scripture and connects with the audience they’re sharing with.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>What comes to mind when you hear God's command to be His "witness" and to tell His story?
                        </li>
                        <li> Why do you think Jesus chose ordinary people instead of some other way to share His Good
                            News?
                        </li>
                        <li>What would it take for you to feel more comfortable sharing God's Story?</li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">One way to share God’s Good News is by telling God’s
                    Story from
                    Creation to Judgement &#8212; from the beginning of humankind all the way to the end of this age.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Creation_to_Judgement.pdf"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Creation to Judgement</a>
                    </p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>What do you learn about mankind from this story?</li>
                        <li>What do you learn about God?</li>
                        <li>Do you think it would be easier or harder to share God's Story by telling a story like
                            this?
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">PRACTICE SHARING GOD'S STORY (45min)</div>

                <div class="grid-x grid-margin-x grid-margin-y single">
                    <!-- Activity Block  -->
                    <div class="large-8 cell activity-description well">Break into groups of two or three people and
                        spend the next
                        45 minutes practicing telling God's Story using the Activity instructions on page 13 of your
                        Zúme Guidebook.
                    </div>
                </div>
                <!-- grid-x -->

        </section>
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    READ AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">ZÚME TOOLKIT - BAPTISM<br><br>
                    Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of
                    the Son and of the Holy Spirit…”<br><br>
                    Find the "Baptism" section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Baptism.pdf"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Baptism</a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Have you ever baptized someone?</li>
                        <li>Would you even consider it?</li>
                        <li> If the Great Commission is for every follower of Jesus, does that mean every follower is
                            allowed to baptize others? Why or why not?
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-8 cell activity-description well">IMPORTANT REMINDER &#8212; Have you been baptized?
                    If not, then
                    we encourage you to plan this before even one more session of this training. Invite your group to be
                    a part of this important day when you celebrate saying "yes" to Jesus.
                </div>
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING FORWARD
                </div> <!-- step-title cell -->
                <div class="center"><br>Congratulations on finishing Session 3! <br> Below are next steps to take in
                    preparation for the next session.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OBEY</div>
                <div class="large-8 cell activity-description">Spend time this week practicing God's Story, and then
                    share it with at
                    least one person from your List of 100 that you marked as "Unbeliever" or "Unknown."
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">Ask God who He wants you to train to use the Creation to
                    Judgment
                    story (or some other way to share God's Story). Share this person's name with the group before you
                    go.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Pray that God help you be obedient to Him and invite Him
                    to work in
                    you and those around you!
                </div>
            </div> <!-- grid-x -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-8 cell activity-description well">IMPORTANT REMINDER - Your group will be celebrating
                    the Lord's
                    Supper next session. Be sure to remember the supplies (bread and wine / juice).
                </div>
            </div>
        </section>
        <?php
    }

    public static function get_course_content_4() {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING BACK
                </div> <!-- step-title cell -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>CHECK-IN</span></div>
                <div class="large-8 cell activity-description">At the end of the last session, everyone in your group
                    was challenged
                    in two ways:<br><br>
                    <ol>
                        <li>You were asked to share God’s Story with at least one person from your List of 100 that you
                            marked as "Unbeliever" or "Unknown."
                        </li>
                        <li>You were encouraged to train someone to use the Creation to Judgement story (or some other
                            way to share God’s Story) with someone.
                        </li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRAY</span></div>
                <div class="large-8 cell activity-description">Pray and thank God for the results and invite His Holy
                    Spirit to lead
                    your time together.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>OVERVIEW</span></div>
                <div class="large-8 cell activity-description">In this session, you'll learn how God's plan is for every
                    follower to
                    multiply! You’ll discover how disciples multiply far and fast when they start to see where God’s
                    Kingdom isn’t. And, you'll learn another great tool for inviting others into God's family is as
                    simple as telling our story.<br><br>Then, when you're ready, get started!
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- LISTEN AND READ ALONG -->

            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LISTEN AND READ ALONG (3min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">ZÚME TOOLKIT - 3-MINUTE TESTIMONY<br><br>As followers of
                    Jesus, we are
                    “witnesses" for Him, because we “testify” about the impact Jesus has had on our lives. Your story of
                    your relationship with God is called your Testimony. It's powerful, and it's something no one can
                    share better than you.<br><br>Find the "3-Minute Testimony" section in your Zúme Guidebook, and
                    listen to the audio below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Testimony.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Testimony</a></p>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    PRACTICE SHARING YOUR TESTIMONY (45min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-8 cell activity-description well">Break into groups of two or three and and spend the
                    next 45
                    minutes practicing sharing your Testimony using the Activity instructions on page 15 of your Zúme
                    Guidebook.
                </div>
            </div> <!-- grid-x -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">What is God's greatest blessing for His children? Making
                    disciples who
                    multiply! <br><br>What if you could learn a simple pattern for making not just one follower of Jesus
                    but entire spiritual families who multiply for generations to come?
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Greatest_Blessing.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Greatest Blessing</a></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Is this the pattern you were taught when you first began to follow Jesus? If not, what was
                            different?
                        </li>
                        <li>After you came to faith, how long was it before you began to disciple others?</li>
                        <li> What do you think would happen if new followers started sharing and discipling others,
                            immediately?
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">What do ducklings have to do with disciple making? They
                    lead and
                    follow at the same time.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center">
                        <a href="https://zumeproject.com/wp-content/uploads/Duckling-discipleship.pdf"
                           target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/pages/' ); ?>download-icon.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Duckling Discipleship
                        </a>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>What is one area of discipleship (reading/understanding the Bible, praying, sharing God's
                            Story, etc.) that you want to learn more about? Who is someone that could help you learn?
                        </li>
                        <li> What is one area of discipleship that you feel you could share with others? Who is someone
                            that you could share with?
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">Have you ever stopped to think about where God's
                    Kingdom... isn't?<br><br>Have
                    you ever visited a home or a neighborhood or even a city where it seemed as if God was just...
                    missing? These are usually the places where God wants to work the most.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Eyes_to_See.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Eyes to See</a></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Who are you more comfortable sharing with &#8212; people you already know or people you
                            haven't met, yet?
                        </li>
                        <li>Why do you think that is?</li>
                        <li>How could you get better at sharing with people you're less comfortable with?</li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LISTEN AND READ ALONG (3min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">ZÚME TOOLKIT - THE LORD'S SUPPER<br><br>Jesus said, “I am
                    the living
                    bread that came down from heaven. Whoever eats this bread will live forever. This bread is my flesh,
                    which I will give for the life of the world.”<br><br>Find "The Lord's Supper" section in your Zúme
                    Guidebook, and listen to the audio below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Lord_s_Supper.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Lord's Supper</a></p>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    PRACTICE THE LORD'S SUPPER (10min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-8 cell activity-description well">Spend the next 10 minutes celebrating The Lord's
                    Supper with your
                    group using the pattern on page 15 of your Zúme Guidebook.
                </div>
            </div> <!-- grid-x -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING FORWARD
                </div> <!-- step-title cell -->
                <div class="center"><br>Congratulations on finishing Session 4! <br> Below are next steps to take in
                    preparation for the next session.
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OBEY</div>
                <div class="large-8 cell activity-description">Spend time this week practicing your 3-Minute Testimony,
                    and then
                    share it with at least one person from your List of 100 that you marked as "Unbeliever" or
                    "Unknown."
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">Ask God who He wants you to train with the 3-Minute
                    Testimony tool.
                    Share this person's name with the group before you go.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Pray that God help you be obedient to Him and invite Him
                    to work in
                    you and those around you!
                </div>
            </div> <!-- grid-x -->
        </section>
        <?php
    }

    public static function get_course_content_5() {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING BACK
                </div> <!-- step-title cell -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>CHECK-IN</span></div>
                <div class="large-8 cell activity-description">At the end of the last session, everyone in your group
                    was challenged
                    in two ways: <br><br>
                    <ol>
                        <li>You were asked to share your 3-Minute Testimony with at least one person on your List of
                            100.
                        </li>
                        <li>You were encouraged to train someone else with the 3-Minute Testimony tool.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRAY</span></div>
                <div class="large-8 cell activity-description">Pray and thank God for the results and invite His Holy
                    Spirit to lead
                    your time together.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>OVERVIEW</span></div>
                <div class="large-8 cell activity-description">In this session, you’ll learn how Prayer Walking is a
                    powerful way to
                    prepare a neighborhood for Jesus, and you'll learn a simple but powerful pattern for prayer that
                    will help you meet and make new disciples along the way.
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LISTEN AND READ ALONG (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">ZÚME TOOLKIT - PRAYER WALKING<br><br>Prayer Walking is a
                    simple way to
                    obey God’s command to pray for others. And it's just what it sounds like &#8212; praying to God
                    while walking around!<br><br>Find the "Prayer Walking" section in your Zúme Guidebook, and listen to
                    the audio below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Prayer_Walking.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Prayer Walking</a></p>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">Disciple-making can be rapidly advanced by finding a
                    person of peace,
                    even in a place where followers of Jesus are few and far between. How do you know when you have
                    found a person of peace and what do you when you find them?
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">

                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a href="https://zumeproject.com/wp-content/uploads/Person-of-Peace.pdf"
                                         target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Person of Peace</a></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Can someone who has a "bad reputation" (like the Samaritan woman or the demon-possessed man
                            in the Gadarenes) really be a Person of Peace? Why or why not?
                        </li>
                        <li>What is a community or segment of society near you that seems to have little (or no) Kingdom
                            presence? How could a Person of Peace (someone who is OPEN, HOSPITABLE, KNOWS OTHERS and
                            SHARES) accelerate the spread of the Gospel in that community?
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>


        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    PRACTICE THE B.L.E.S.S. PRAYER (15min)

                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-8 cell activity-description well">Break into groups of two or three and spend the next
                    15 minutes
                    practicing the B.L.E.S.S. Prayer using the pattern on page 17 of your Zúme Guidebook. Practice
                    praying the five areas of the B.L.E.S.S. Prayer for someone AND practice how you would train others
                    to understand and use the B.L.E.S.S. Prayer, too.
                </div>
            </div> <!-- grid-x -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    PRACTICE PRAYER WALKING (60-90min)

                </div> <!-- grid-x --><!-- Activity Block  -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="large-4 cell activity-title">ACTIVITY</div>
                    <div class="large-8 cell activity-description">Break into groups of two or three and go out into the
                        community to
                        practice Prayer Walking. <br><br>Choosing a location can be as simple as walking outside from
                        where you are now, or you could plan to go to a specific destination. <br><br>Go as God leads,
                        and plan on spending 60-90 minutes on this activity.
                    </div>
                </div> <!-- grid-x -->
            </div>


            <!-- Step Title -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="step-title cell center">
                        LOOKING FORWARD
                    </div> <!-- step-title cell -->
                    <div class="center">
                        <br> The session ends with a prayer walking activity. <br> Read through the Obey, Share, and
                        Pray sections, below, before you head out!
                    </div>
                </div> <!-- grid-x -->
                <!-- Activity Block  -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="large-4 cell activity-title">OBEY</div>
                    <div class="large-8 cell activity-description">Spend time this week practicing Prayer Walking by
                        going out alone
                        or with a small group at least once.
                    </div>
                </div> <!-- grid-x -->
                <!-- Activity Block  -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="large-4 cell activity-title">SHARE</div>
                    <div class="large-8 cell activity-description">Spend time asking God who He might want you to share
                        the Prayer
                        Walking tool with before your group meets again. Share this person’s name with the group before
                        you go.
                    </div>
                </div> <!-- grid-x -->
                <!-- Activity Block  -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="large-4 cell activity-title">PRAY</div>
                    <div class="large-8 cell activity-description">Before you go out on your Prayer Walking activity, be
                        sure to pray
                        with your group to end your time together. Thank God that He loves the lost, the last and the
                        least &#8212; including us! Ask Him to prepare your heart and the heart of those you'll meet
                        during your walk to be open to His work.
                    </div>
                </div> <!-- grid-x -->
        </section>
        <?php
    }

    public static function get_course_content_6() {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING BACK
                </div> <!-- step-title cell -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>CHECK-IN</span></div>
                <div class="large-8 cell activity-description">At the end of the last session, everyone in your group
                    was challenged
                    in two ways: <br><br>
                    <ol>
                        <li>You were asked to spend some time Prayer Walking</li>
                        <li>You were encouraged to share the Prayer Walking tool with someone else.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRAY</span></div>
                <div class="large-8 cell activity-description">Pray and thank God for the results, ask Him to help when
                    you find it
                    hard to obey, and invite His Holy Spirit to lead your time together.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>OVERVIEW</span></div>
                <div class="large-8 cell activity-description">In this session, you’ll learn how God uses faithful
                    followers &#8212;
                    even if they're brand new &#8212; much more than ones with years of knowledge and training who just
                    won't obey. And you'll get a first look at a way to meet together that helps disciples multiply even
                    faster.
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">When we help multiply disciples, we need to make sure
                    we're
                    reproducing the right things. It's important what disciples know &#8212; but it's much more
                    important what they DO with what they know.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Faithfulness.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Faithfulness</a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">Think about God's commands that you already know. How
                    "faithful" are
                    you in terms of obeying and sharing those things?
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LISTEN AND READ ALONG (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">ZÚME TOOLKIT - 3/3 GROUPS FORMAT<br><br>Jesus said,
                    “Where two or
                    three have gathered together in My name, I am there in their midst.”<br><br>Find the "3/3 Group
                    Format" section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_3_3_Group.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: 3/3 Group</a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Did you notice any differences between a 3/3 Group and a Bible Study or Small Group you've
                            been a part of (or have heard about) in the past? If so, how would those differences impact
                            the group?
                        </li>
                        <li>Could a 3/3 Group be considered a Simple Church? Why or why not?</li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    MODEL 3/3 GROUP
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">A 3/3 Group is a way for followers of Jesus to meet,
                    pray, learn,
                    grow, fellowship and practice obeying and sharing what they've learned. In this way
                    a 3/3 Group is
                    not just a small group but a Simple Church.<BR><BR> In the following video, you'll see a model 3/3
                    Group meet together and practice this format.<br><br>Find the "3/3 Groups Format" section in your
                    Zúme Guidebook, and watch the video below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING FORWARD
                </div> <!-- step-title cell -->
                <div class="center"><br>Congratulations on finishing Session 6! <br> Below are next steps to take in
                    preparation for the next session.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OBEY</div>
                <div class="large-8 cell activity-description">Spend time this week practicing Faithfulness by obeying
                    and sharing at
                    least one of God's commands that you already know.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">Think about what you have heard and learned about
                    Faithfulness in this
                    session, and ask God who He wants you to share it with. Share this person’s name with the group
                    before you go.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Thank God for His Faithfulness &#8212; for fulfilling
                    every promise
                    He's ever made. Ask Him to help you and your group become even more Faithful to Him.
                </div>
            </div> <!-- grid-x -->
        </section>
        <?php
    }

    public static function get_course_content_7() {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING BACK
                </div> <!-- step-title cell -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>CHECK-IN</span></div>
                <div class="large-8 cell activity-description">At the end of the last session, everyone in your group
                    was challenged
                    in two ways: <br><br>
                    <ol>
                        <li>You were asked to practice Faithfulness by obeying and sharing one of God's commands.</li>
                        <li>You were encouraged to share the importance of Faithfulness with someone else.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRAY</span></div>
                <div class="large-8 cell activity-description">Pray and thank God for the group's commitment to
                    faithfully following
                    Jesus and invite God's Holy Spirit to lead your time together.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>OVERVIEW</span></div>
                <div class="large-8 cell activity-description">In this session, you’ll learn a Training Cycle that helps
                    disciples go
                    from one to many and turns a mission into a movement. You'll also practice the 3/3 Groups Format and
                    learn how the way you meet can impact the way you multiply.
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">Have you ever learned how to ride a bicycle? Have you
                    ever helped
                    someone else learn? If so, chances are you already know the Training Cycle.<br><br>Find the
                    "Training Cycle" section in your Zúme Guidebook. When you're ready, watch this video, and then
                    discuss the questions below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Training_Cycle.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Training Cycle</a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Have you ever been a part of a Training Cycle?</li>
                        <li> Who did you train? Or who trained you?</li>
                        <li>Could the same person be at different parts of the Training Cycle while learning different
                            skills?
                        </li>
                        <li>What would it look like to train someone like that?</li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    PRACTICE AND DISCUSS (90min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRACTICE</span></div>
                <div class="large-8 cell activity-description">Have your entire group spend the next 90 minutes
                    practicing the 3/3
                    Groups Format using the pattern on pages 19-20 in your Zúme Guidebook.<br><br>
                    <ul>
                        <li>LOOK BACK - Use last week's Session Challenges to practice "Faithfulness" in the Look Back
                            section.
                        </li>
                        <li>LOOK UP - Use Mark 5:1-20 as your group's reading passage and answer questions 1-4 during
                            the Look Up section.
                        </li>
                        <li>LOOK FORWARD - Use questions 5, 6, and 7 in the Look Forward section to develop how you will
                            Obey, Train and Share.
                        </li>
                    </ul>
                    <br>
                    REMEMBER - Each section should take about 1/3 (or 30 minutes) of your practice time.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>DISCUSS</span></div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>What did you like best about the 3/3 Group? Why?</li>
                        <li> What was the most challenging? Why?</li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING FORWARD
                </div> <!-- step-title cell -->
                <div class="center"><br>Congratulations on finishing Session 7! <br> Below are next steps to take in
                    preparation for the next session.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OBEY</div>
                <div class="large-8 cell activity-description">Spend time this week obeying, training, and sharing based
                    on the
                    commitments you've made during your 3/3 Group practice.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">Pray and ask God who He wants you to share the 3/3 Group
                    format with
                    before your group meets again. Share this person’s name with the group before you go.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Thank God that He loves us enough to invite us into His
                    most important
                    work &#8212; growing His family!
                </div>
            </div> <!-- grid-x -->
        </section>
        <?php
    }

    public static function get_course_content_8() {
        ?>
        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING BACK
                </div> <!-- step-title cell -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>CHECK-IN</span></div>
                <div class="large-8 cell activity-description">Before getting started, take some time to
                    check-in.<br><br>At the end
                    of the last session, everyone in your group was challenged in two ways: <br><br>
                    <ol>
                        <li>You were asked to practice obeying, training, and sharing based on your commitments during
                            3/3 Group practice.
                        </li>
                        <li>You were encouraged to share the 3/3 Group Format with someone else.</li>
                    </ol>
                    Take a few moments to see how your group did this week.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRAY</span></div>
                <div class="large-8 cell activity-description">Pray and thank God for giving your group the energy, the
                    focus and the
                    faithfulness to come so far in this training. Ask God to have His Holy Spirit remind everyone in the
                    group that they can do nothing without Him!
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>OVERVIEW</span></div>
                <div class="large-8 cell activity-description">In this session, you’ll learn how Leadership Cells
                    prepare followers
                    in a short time to become leaders for a lifetime. You'll learn how serving others is Jesus' strategy
                    for leadership. And you'll spend time practicing as a 3/3 Group, again.
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">Jesus said, “Whoever wishes to become great among you
                    shall be your
                    servant.”
                    <br><br>
                    Jesus radically reversed our understanding of leadership by teaching us that if we feel called to
                    lead, then we are being called to serve. A Leadership Cell is a way someone who feels called to lead
                    can develop their leadership by practicing serving.
                    <br><br>
                    Find the "Leadership Cells" section in your Zúme Guidebook. When you're ready, watch and discuss
                    this video.
                </div>
            </div> <!-- grid-x -->
            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Leadership_Cells.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Leadership Cells</a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Is there a group of followers of Jesus you know that are already meeting or would be willing
                            to meet and form a Leadership Cell to learn Zúme Training?
                        </li>
                        <li> What would it take to bring them together?</li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    PRACTICE A 3/3 GROUP SESSION (90min)
                </div> <!-- step-title cell --><br>
                <div class="center"><!-- grid-x -->

                    <!-- Activity Block  -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-4 cell activity-title"><span>PRACTICE</span></div>
                        <div class="large-8 cell activity-description">Have your entire group spend the next 90 minutes
                            practicing
                            the 3/3 Groups Format using the pattern on pages 19-20 in your Zúme Guidebook.<br><br>
                            <ul>
                                <li>LOOK BACK - Use last session’s Obey, Train, and Share challenges to check-in with
                                    each other.
                                </li>
                                <li>LOOK UP - Use Acts 2:42-47 as your group’s reading passage and answer questions 1-
                                    4.
                                </li>
                                <li>LOOK FORWARD - Use questions 5, 6, and 7 to develop how you will Obey, Train and
                                    Share.
                                </li>
                            </ul>
                            <br>
                            REMEMBER - Each section should take about 1/3 (or 30 minutes) of your practice time.
                        </div>
                    </div> <!-- grid-x -->

        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING FORWARD
                </div> <!-- step-title cell -->
                <div class="center"><br>Congratulations! You've completed Session 8. <br> Below are next steps to take
                    in preparation for the next session.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OBEY</div>
                <div class="large-8 cell activity-description">Spend time again this week obeying, sharing, and training
                    based on the
                    commitments you've made during this session's 3/3 Group practice.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">Pray and ask God who He wants you to share the Leadership
                    Cell tool
                    with before your group meets again. Share this person’s name with the group before you go.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Thank God for sending Jesus to show us that real leaders
                    are real
                    servants. Thank Jesus for showing us the greatest service possible is giving up our own lives for
                    others.
                </div>
            </div> <!-- grid-x -->
        </section>

        <?php
    }

    public static function get_course_content_9() {
        ?>

        <!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">LOOKING BACK</div>
                <!-- step-title cell -->
                <div class="center">
                    Welcome back to Zúme Training!
                </div>
            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">CHECK-IN</div>
                <div class="large-8 cell activity-description">

                    Before getting started, take some time to check-in.

                    At the end of the last session, everyone in your group was challenged in two ways:
                    <ol>
                        <li>You were asked to practice Obeying, Training, and Sharing based on your commitments during
                            last session's 3/3 Group practice.
                        </li>
                        <li>You were encouraged to share the Leadership Cells tool with someone else.</li>
                    </ol>
                    Take a few moments to see how your group did this week.

                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Pray and thank God that His ways are not our ways and His
                    thoughts are
                    not our thoughts. Ask Him to give each member of your group the mind of Christ — always focused on
                    His Father's work. Ask the Holy Spirit to lead your time together and make it the best session yet.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OVERVIEW</div>
                <div class="large-8 cell activity-description">In this session, you’ll learn how linear patterns hold
                    back kingdom
                    growth and how Non-Sequential thinking helps you multiply disciples. You'll
                    discover how much time
                    matters in disciple-making and how to accelerate Pace. You’ll learn how followers of Jesus can be a
                    Part of Two Churches to help turn faithful, spiritual families into a growing
                    city-wide body of
                    believers. Finally, you'll learn how a simple 3-Month Plan can focus your efforts and multiply your
                    effectiveness in growing God's family exponentially.
                </div>
            </div>
            <!-- grid-x -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">WATCH AND DISCUSS (15min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">When people think about disciples multiplying, they often
                    think of it
                    as a step-by-step process. The problem with that is — that's not how it works best!
                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Non_Sequential.pdf"
                                target="_blank" rel="noopener"><img class="alignnone size-thumbnail wp-image-3274"
                                                                    style="vertical-align: text-bottom;"
                                                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                                                    alt="" width="35" height="35"/> Zúme Video Scripts:
                            Non-Sequential</a></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>What is the most exciting idea you heard in this video? Why?</li>
                        <li>What is the most challenging idea? Why?</li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">WATCH AND DISCUSS (15min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">Multiplying matters and multiplying quickly matters even
                    more. Pace
                    matters because where we all spend our eternity — an existence that outlasts time — is determined in
                    the very short time we call “life."
                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                    <p class="center"><a href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Pace.pdf"
                                         target="_blank" rel="noopener"><img
                                    class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom;"
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt="" width="35" height="35"/> Zúme Video
                            Scripts: Pace</a></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Why is pace important?</li>
                        <li>What do you need to change in your thinking, your actions, or your attitude to be better
                            aligned with God's priority for pace?
                        </li>
                        <li>What is one thing you can do starting this week that will make a difference?</li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">WATCH AND DISCUSS (15min)</div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">Jesus taught us that we are to stay close — to live as a
                    small,
                    spiritual family, to love and give our lives to one another, to celebrate and suffer — together.
                    However, Jesus also taught us to leave our homes and loved ones behind and be willing to go anywhere
                    — and everywhere — to share and start new spiritual families.

                    So how can we do both?

                    When you're ready, watch the video below and discuss the question that follows.
                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Two_Churches.pdf"
                                target="_blank" rel="noopener"><img class="alignnone size-thumbnail wp-image-3274"
                                                                    style="vertical-align: text-bottom;"
                                                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                                                    alt="" width="35" height="35"/> Zúme Video Scripts:
                            Two
                            Churches</a></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">What are some advantages of maintaining a consistent
                    spiritual family
                    that gives birth to new ones that grow and multiply instead of continually ggrid-x
                    grid-margin-xing a family and
                    splitting it in order to grow?
                </div>
            </div>
            <!-- grid-x -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">

                <div class="step-title cell">CREATE A 3-MONTH PLAN (30min)</div>
                <!-- step-title cell -->
                <div class="center">

                    <!-- grid-x -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-4 cell activity-title">OVERVIEW</div>
                        <div class="large-8 cell activity-description">In His Bible, God says, "I know the plans I have
                            for you,
                            plans to prosper you and not to harm you, plans to give you hope and a future."

                            God makes plans, and He expects us to make plans, too. He teaches us through His Word and
                            His work to look ahead, see a better tomorrow, make a plan for how to get there, and then
                            prepare the resources we'll need on the way.

                            A 3-Month Plan is a tool you can use to help focus your attention and efforts and keep them
                            aligned with God's priorities for making disciples who multiply.

                            Spend the next 30 minutes praying over, reading through, and then completing the commitments
                            listed in the 3-Month Plan section in your Zúme Guidebook.
                        </div>
                    </div>
                    <!-- grid-x -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-4 cell activity-title">PRAY</div>
                        <div class="large-8 cell activity-description">Ask God what He specifically wants you to do with
                            the basic
                            disciple-making tools and techniques you have learned over these last nine sessions.
                            Remember His words about Faithfulness.
                        </div>
                    </div>
                    <!-- grid-x -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-4 cell activity-title">LISTEN</div>
                        <div class="large-8 cell activity-description">Take at least 10 minutes to be as quiet as
                            possible and listen
                            intently to what God has to say and what He chooses to reveal. Make an effort to hear His
                            voice.
                        </div>
                    </div>
                    <!-- grid-x -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-4 cell activity-title">COMPLETE</div>
                        <div class="large-8 cell activity-description">Use the rest of your time to complete the 3-Month
                            Plan
                            worksheet. You do not have to commit to every item, and there is room for other items not
                            already on the list. Do your best to align your commitments to what you have heard God
                            reveal to you about His will.
                        </div>
                    </div>
                    <!-- grid-x -->

                </div>
            </div>
        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">ACTIVITY (30min)</div>
                <!-- step-title cell -->
                <div class="center">
                    SHARE YOUR PLAN AND PLAN AS A TEAM.
                </div>
            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">IN GROUPS OF TWO OR THREE (15 minutes)

                    Take turns sharing your 3-Month Plans with each other. Take time to ask questions about things you
                    might not understand about plans and how the others will meet their commitments. Ask them to do the
                    same for you and your plan.

                    Find a training partner(s) that is willing to check in with you to report on progress and challenges
                    and ask questions after 1, 2, 3, 4, 6, 8 and 12 weeks. Commit to doing the same for them.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">IN YOUR FULL TRAINING GROUP (15 minutes)

                    Discuss and develop a group plan for starting at least two new 3/3 Groups or Zúme Training Groups in
                    your area. Remember, your goal is start Simple Churches that multiply. 3/3 Groups and Zúme Training
                    Groups are two ways to do that.

                    Discuss and decide whether these new Groups will be connected to an existing local church or network
                    or whether you’ll start a new network out of your Zúme Training Group.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">CONNECT</div>
                <div class="large-8 cell activity-description">CONNECT WITH YOUR COACH

                    Make sure all group members know how to contact the Zúme Coach that’s been assigned to your group in
                    case anyone has questions or needs more training. Remember to share your 3-Month Plan with your
                    Coach, so they understand your goals.

                    Discuss any other locations where members of your group could help launch new 3/3 Groups or Zúme
                    Training Groups.

                    Be sure to pray as a group and ask God for His favor to bring about all the good work possible out
                    of these plans and commitments.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SEND</div>
                <div class="large-8 cell activity-description">

                    SUBMIT YOUR 3-MONTH PLAN

                    Any individual in your group can go login right now (if you’re not already) and send your 3-month
                    plan to your coach by filling out this webform. We will also email you a digital copy of your plan.

                    Feel feel free to contact your coach to discuss your plan or ask questions at any time.
                    <div style="text-align: center;">
                        <button class="button show-session-9-form" style="font-size: 20px;">Fill in my 3-Month Plan
                        </button>
                    </div>
                    <div class="session-9-plan-form" style="display: none;">[session_nine_plan]</div>
                </div>
            </div>
            <!-- grid-x -->

        </section><!-- Step -->
        <h3></h3>
        <section><!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">LOOKING FORWARD</div>
                <!-- step-title cell -->
                <div class="center">
                    Congratulations! You've completed Session 9.
                </div>
            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">You may not know it, but you now have more practical
                    training on
                    starting simple churches and making disciples who multiply than many pastors and missionaries around
                    the world!

                    Watch the following video and celebrate all that you've learned!
                </div>
            </div>
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Completion_of_Training.pdf"
                                target="_blank" rel="noopener"><img class="alignnone size-thumbnail wp-image-3274"
                                                                    style="vertical-align: text-bottom;"
                                                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                                                    alt="" width="35" height="35"/> Zúme Video Scripts:
                            Completion of Training</a></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">OBEY</div>
                <div class="large-8 cell activity-description">Set aside time on your calendar each week to continue to
                    work on your
                    3-Month Plan, and plan check-ins with your training partner at the end of week 1, 2, 3, 4, 6, 8, and
                    12. Each time you're together, ask about their results and share yours, making sure you're both
                    working through your plans.

                    Prayerfully consider continuing as an ongoing spiritual family committed to multiplying disciples.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">SHARE</div>
                <div class="large-8 cell activity-description">Pray and ask God who He would have you share Zúme
                    Training with by
                    launching a Leadership Cell of future Zúme Training leaders.
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">PRAY</div>
                <div class="large-8 cell activity-description">Be sure to pray with your group before you end your time
                    together.
                    Thank God that He has created and gifted you with exactly the right talents to make a difference in
                    His kingdom. Ask Him for wisdom to use the strengths He has given you and to find other followers
                    who help cover your weaknesses. Pray that He would make you fruitful and multiply — this was His
                    plan from the very beginning. Pray that God help you be obedient to Him and invite Him to work in
                    you and those around you!
                </div>
            </div>
            <!-- grid-x -->

            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">BONUS</div>
                <div class="large-8 cell activity-description">Check out <a href="https://www.2414now.net"
                                                                            target="_blank">www.2414now.net</a>
                    and join the global coalition praying and working together to start kingdom movement engagements in
                    every unreached people and place by 2025.
                </div>
            </div>
            <!-- grid-x -->

            <!-- grid-x -->
            <!-- Activity Block -->

        </section>
        <?php
    }

    public static function get_course_content_10() {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LOOKING BACK
                </div> <!-- step-title cell -->
                <div class="center"><br>Welcome back to Zúme Training!</div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>CHECK-IN</span></div>
                <div class="large-8 cell activity-description">Before getting started, take some time to
                    check-in.<br><br>At the end
                    of the last session, everyone in your group was challenged in two ways: <br><br>
                    <ol>
                        <li>You were asked to prayerfully consider continuing as an ongoing spiritual family committed
                            to multiplying disciples.
                        </li>
                        <li>You were encouraged to share Zúme Training by launching a Leadership Cell of future Zúme
                            Training leaders.
                        </li>
                    </ol>
                    Take a few moments to see how your group has been doing with these items and their 3-Month Plans
                    since you've last met.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRAY</span></div>
                <div class="large-8 cell activity-description">Pray and thank God that He is faithful to complete His
                    good work in
                    us. Ask Him to give your group clear heads and open hearts to the great things He wants to do in and
                    through you. Ask the Holy Spirit to lead your time together and thank Him for His faithfulness, too.
                    He got you through!
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>OVERVIEW</span></div>
                <div class="large-8 cell activity-description">In this advanced training session, you’ll take a look at
                    how you can
                    level-up your Coaching Strengths with a quick checklist assessment. You’ll learn how Leadership in
                    Networks allows a growing group of small churches to work together to accomplish
                    even more. And
                    you’ll learn how to develop Peer Mentoring Groups that take leaders to a whole new level of growth.
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    ACTIVITY (10min)
                </div> <!-- step-title cell -->
                <div class="center"><br>ASSESS YOURSELF USING THE COACHING CHECKLIST.</div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">ASSESS</div>
                <div class="large-8 cell activity-description">The Coaching Checklist is a powerful tool you can use to
                    quickly
                    assess your own strengths and vulnerabilities when it comes to making disciples who multiply. It's
                    also a powerful tool you can use to help others &#8212; and others can use to help you.<br><br>
                    Find the Coaching Checklist section in your Zúme Guidebook, and take this quick (5-minutes or less)
                    self-assessment:<br><br>
                    <ol>
                        <li>Read through the Disciple Training Tools in the far left column of the Checklist.</li>
                        <li>Mark each one of the Training Tools, using the following method:
                            <ul>
                                <li> If you're unfamiliar or don't understand the Tool &#8212; check the BLACK column
                                </li>
                                <li>If you're somewhat familiar but still not sure about the Tool &#8212; check the RED
                                    column
                                </li>
                                <li>If you understand and can train the basics on the Tool &#8212; check the YELLOW
                                    column
                                </li>
                                <li>If you feel confident and can effectively train the Tool &#8212; check the GREEN
                                    column
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">
                    <ol>
                        <li>Which Training Tools did you feel you would be able to train well?</li>
                        <li>Which ones made you feel vulnerable as a trainer?</li>
                        <li> Are there any Training Tools that you would add or subtract from the Checklist? Why?</li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-8 cell activity-description well">REMEMBER &#8212; Be sure to share your Coaching
                    Checklist results
                    with your Zúme Coach and/or your training partner or other mentor. If you're helping coach or mentor
                    someone, share this tool to help assess which areas need your attention and training.
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    WATCH AND DISCUSS (15min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">WATCH</div>
                <div class="large-8 cell activity-description">What happens to churches as they grow
                    and start new churches that
                    start new churches? How do they stay connected and live life together as an extended, spiritual
                    family? They become a network!
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Leadership_in_Networks.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Leadership in Networks</a>
                    </p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">DISCUSS</div>
                <div class="large-8 cell activity-description">Are there advantages when networks of simple churches are
                    connected by
                    deep, personal relationships? What are some examples that come to mind?
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    LISTEN AND READ ALONG (3min)
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title">READ</div>
                <div class="large-8 cell activity-description">ZÚME TOOLKIT - PEER MENTORING GROUPS<br><br>Making
                    disciples who make
                    disciples means making leaders who make leaders. How do you develop stronger leaders? By teaching
                    them how to love one another better. Peer Mentoring Groups help leaders love deeper.<br><br>Find the
                    Peer Mentoring Groups section in your Zúme Guidebook, and listen to the audio below.
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">
                    <div class="flex-video widescreen">
                        <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360" frameborder="0"
                                webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>

                    <p class="center"><a
                                href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Peer_Mentoring_Groups.pdf"
                                target="_blank"><img
                                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> Zúme Video Scripts: Peer Mentoring Groups</a>
                    </p>
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    PRACTICE (60min)
                </div> <!-- step-title cell -->
                <div class="center"><br>Practice peer mentoring groups. Spend the next 60 minutes practicing the Peer
                    Mentoring Groups format. Find the Peer Mentoring Groups section in your Zúme Training Guide, and
                    follow these steps.
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>GROUPS</span></div>
                <div class="large-8 cell activity-description">Break into groups of two or three and work through the
                    3/3 sections of
                    the Peer Mentoring Group format. Peer Mentoring is something that happens once a month or once a
                    quarter and takes some time for the whole group to participate, so you will not have time for
                    everyone to experience the full mentoring process in this session.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-4 cell activity-title"><span>PRACTICE</span></div>
                <div class="large-8 cell activity-description">To practice, choose one person in your group to be the
                    "mentee" for
                    this session and have the other members spend time acting as Peer Mentors by working through the
                    suggested questions list and providing guidance and encouragement for the Mentee's work.<br><br>

                    By the time you're finished, everyone should have a basic understanding of asking and answering.
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-8 cell activity-description well">REMEMBER - Spend time studying the Four Fields
                    Diagnostic Diagram
                    and Generational Map in the Peer Mentoring Groups section of your Zúme Training Guide. Make sure
                    everyone in your group has a basic understanding of these tools before asking the suggested
                    questions.
                </div>
            </div> <!-- grid-x -->
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell" style="text-transform: uppercase">
                    CONGRATULATIONS ON COMPLETEING ZÚME TRAINING!
                </div> <!-- step-title cell -->
                <div class="center">

                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-4 cell activity-title"><span>WATCH</span></div>
                        <div class="large-8 cell activity-description">
                            You and your group are now ready to take leadership to a new level!
                            Here are a few more steps to help you KEEP growing!
                        </div>
                    </div>

                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="small-12 small-centered cell">
                            <div class="flex-video widescreen">
                                <iframe src="https://player.vimeo.com/video/246841605" width="640" height="360"
                                        frameborder="0" webkitallowfullscreen mozallowfullscreen
                                        allowfullscreen></iframe>
                            </div>

                            <p class="center"><a
                                        href="https://zumeproject.com/wp-content/uploads/Zume_Video_Scripts_Completion_of_Training.pdf"
                                        target="_blank"><img
                                            src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/course/' ) ?>download-icon-150x150.png"
                                            alt="" width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                            style="vertical-align: text-bottom"/> Zúme Video Scripts: Completion of
                                    Training</a></p>
                        </div>
                    </div>
                    <!-- grid-x -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-4 cell activity-title"><span>Grow</span></div>
                        <div class="large-8 cell activity-description">
                            <p style="text-transform: uppercase">Grow as a disciple by putting your faith to work</p>
                            <p>
                                Consider registering online for reminders, coaching resources, and to become connected
                                with others who are using the same sort of ministry approach. You can do this at
                                ZumeProject.com.
                            </p>
                        </div>
                    </div>

                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-4 cell activity-title"><span>ACT</span></div>
                        <div class="large-8 cell activity-description">
                            <div class="congratulations-more">
                                <button class="button js-congratulations-more-button" data-item="learn-more"><span>
                                        <div class="congratulations-icon congratulations-icon-learn-more"></div>
                                        <span>Learn More</span>
                                    </span></button>
                                <button class="button js-congratulations-more-button" data-item="invite"><span>
                                        <div class="congratulations-icon congratulations-icon-invite"></div>
                                        <span>Invite my friends</span>
                                    </span></button>
                                <button class="button js-congratulations-more-button" data-item="coordinator"><span>
                                        <div class="congratulations-icon congratulations-icon-coordinator"></div>
                                        <span>Become a county coordinator</span>
                                    </span></button>
                                <button class="button js-congratulations-more-button" data-item="map"><span>
                                        <div class="congratulations-icon congratulations-icon-map"></div>
                                        <span>Map my neighborhood</span>
                                    </span></button>
                                <button class="button js-congratulations-more-button" data-item="language"><span>
                                        <div class="congratulations-icon congratulations-icon-language"></div>
                                        <span>Fund translation of Zúme</span>
                                    </span></button>
                                <button class="button js-congratulations-more-button" data-item="contact-coach"><span>
                                        <div class="congratulations-icon congratulations-icon-contact-coach"></div>
                                        <span>Contact my coach</span>
                                    </span></button>
                                <button class="button js-congratulations-more-button" data-item="share"><span>
                                        <div class="congratulations-icon congratulations-icon-share"></div>
                                        <span>Share on Social Media</span>
                                    </span></button>
                                <button class="button js-congratulations-more-button" data-item="champion"><span>
                                        <div class="congratulations-icon congratulations-icon-champion"></div>
                                        <span>Champion Zúme on Social Media</span>
                                    </span></button>
                                <button class="button js-congratulations-more-button" data-item="join-2414"><span>
                                        <div class="congratulations-icon congratulations-icon-learn-more"></div>
                                        <span>Join 2414</span>
                                    </span></button>
                            </div>

                            <div class="congratulations-more__text js-congratulations-more-item" data-item="learn-more"
                                 hidden>
                                <p>
                                    Find additional information on some of the multiplication concepts at
                                    <a href="http://metacamp.org/multiplication-concepts/" target="_blank">
                                        http://metacamp.org/multiplication-concepts/
                                    </a>
                                    or ask questions about specific resources by e-mailing
                                    <a href="mailto:info@zumeproject.com">info@zumeproject.com</a>.
                                </p>
                                <p class="center">
                                    <a class="button" href="http://metacamp.org/multiplication-concepts/"
                                       target="_blank">Learn more</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="invite"
                                 hidden>
                                <p>
                                    You can put what you know to work by helping spread the word about Zúme Training and
                                    inviting others to go through training, too. We make it easy to invite friends
                                    through
                                    email, Facebook, Twitter, Snapchat and other social sites, but we can't invite your
                                    friends for you.
                                </p>
                                <div class="js-congratulations-more-invite-button"></div>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="coordinator"
                                 hidden>
                                <p>
                                    One of the ways you can put what you know to work is by becoming a county
                                    coordinator,
                                    that is someone who can help connect groups as they get started in your area. If
                                    you’re
                                    the kind of person who likes to help people go and grow, this might be a way God can
                                    use
                                    your gifts to do even more. Let us know by sending an e-mail to
                                    <a href="mailto:info@zumeproject.com">info@zumeproject.com</a>.
                                </p>
                                <p class="center">
                                    <a class="button" href="/dashboard/#your-coaches">Contact my coach</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="map" hidden>
                                <p>
                                    We are working with
                                    <a href="http://www.mappingcenter.org"
                                       target="_blank">http://www.mappingcenter.org</a>
                                    to try to provide you with free information on the residents within your census
                                    tract in
                                    order to help you more effectively reach it. "Stay tuned" for more information. If
                                    you do
                                    not have relationships within your census tract and are looking for ways to connect
                                    with
                                    your neighbors, you might consider the Mapping Your Neighborhood program for
                                    disaster
                                    preparedness. You can find information and downloadable resources at
                                    <a href="http://mil.wa.gov/emergency-management-division/preparedness/map-your-neighborhood"
                                       target="_blank">
                                        http://mil.wa.gov/emergency-management-division/preparedness/map-your-neighborhood
                                    </a>.
                                </p>
                                <p class="center">
                                    <a class="button" href="http://www.mappingcenter.org/" target="_blank">Map my
                                        neighborhood</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="language"
                                 hidden>
                                <p>
                                    As Zúme Training grows, sessions will soon be available in 34 more languages. As we
                                    bring
                                    those trainings online, we’ll send you information on people in your neighborhood
                                    that
                                    speak those languages, so you can share something that’s built just for them. You
                                    can
                                    help fund the translation of the Zúme Training into additional languages by donating
                                    at
                                    <a href="https://big.life/donate" target="_blank">https://big.life/donate</a> and
                                    designating the gift for the Zúme Project with a note about the language you would
                                    like
                                    to fund.
                                </p>
                                <p class="center">
                                    <a class="button" href="https://big.life/donate" target="_blank">Fund translation of
                                        Zúme</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item"
                                 data-item="contact-coach" hidden>
                                <p class="center">
                                    <a class="button" href="/dashboard/#your-coaches">Contact my coach</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="share"
                                 hidden>
                                <p class="center">
                                    <a class="button" href="https://www.facebook.com/zumeproject" target="_blank">Facebook
                                        page</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="champion"
                                 hidden>
                                <p>
                                    Contact us at <a href="mailto:info@zumeproject.com">info@zumeproject.com</a> if you
                                    are
                                    interested in serving as a social media moderator for Zúme.
                                </p>
                                <p class="center">
                                    <a class="button" href="mailto:info@zumeproject.com">Contact us</a>
                                </p>
                            </div>
                            <div class="congratulations-more__text js-congratulations-more-item" data-item="join-2414"
                                 hidden>
                                <p>
                                    Check out <a href="https://www.2414now.net" target="_blank">www.2414now.net</a> and
                                    join
                                    the global coalition praying and working together to start kingdom movement
                                    engagements
                                    in every unreached people and place by 2025.
                                </p>
                                <p class="center">
                                    <a class="button" href="https://www.2414now.net" target="_blank">Join 2414</a>
                                </p>


                            </div>
                        </div>
        </section>
        <?php
    }
}
