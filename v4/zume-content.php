<?php

/**
 * @version 4
 * Class Zume_Course_Content
 * Below is the HTML for the content of the Zume Course
 */
class Zume_Course_Content {

    public static function get_course_content( $session_id ) {
        ?>
        <div class="center padding-bottom hide-for-small-only session-title"><?php esc_html_e( 'Session', 'zume' ) ?> <?php echo esc_attr( $session_id ); ?></div>

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
                    // Enables all steps from the beginning
                    enableAllSteps: true,
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
                        jQuery("html, body").animate({ scrollTop: 0 }, "fast");
                        jQuery('a[href*="#finish"]:visible').append(` <span class="spinner" style="display:none;"><img src="<?php echo esc_url( get_theme_file_uri() ) ?>/spinner.svg" width="30px" height="30px" /></span>`)

                    },
                    onFinishing: function (event, currentIndex) {
                        jQuery('a[href*="#finish"]').css("background", "#fefefe").css("color", "#323a68")
                        jQuery('.spinner').show( "complete", function() {
                            location.replace('<?php echo esc_url( zume_dashboard_url() ) ?>')
                        })
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
            $zume_current_lang = zume_current_language();
            $alt_video = zume_alt_video( $zume_current_lang );
            switch ( $session_id ) {
                case '1':
                    self::get_course_content_1( $alt_video );
                    break;
                case '2':
                    self::get_course_content_2( $alt_video );
                    break;
                case '3':
                    self::get_course_content_3( $alt_video );
                    break;
                case '4':
                    self::get_course_content_4( $alt_video );
                    break;
                case '5':
                    self::get_course_content_5( $alt_video );
                    break;
                case '6':
                    self::get_course_content_6( $alt_video );
                    break;
                case '7':
                    self::get_course_content_7( $alt_video );
                    break;
                case '8':
                    self::get_course_content_8( $alt_video );
                    break;
                case '9':
                    self::get_course_content_9( $alt_video );
                    break;
                case '10':
                    self::get_course_content_10( $alt_video );
                    break;
                default:
                    break;
            }
            ?>
        </div>
        <div style="padding-bottom: 3em;"></div>
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
                    <div class="session-title"><?php esc_html_e( 'Welcome to Session', 'zume' ) ?> <?php echo esc_attr( $zume_session ); ?></div>
                    <div class="step-title"><?php esc_html_e( 'Which are you doing right now?', 'zume' ) ?></div>
                    <button class="button large expanded" data-open="group"><?php esc_html_e( 'Facilitating a Group', 'zume' ) ?>
                    </button>
                    <br>
                    <form action="" method="post">
                        <button type="submit" class="button large expanded" name="viewing" value="explore"><?php esc_html_e( 'Exploring the Session Content', 'zume' ) ?>
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
                        <form action="" method="post" id="submit-group-session">
                            <?php wp_nonce_field( 'zume_course_action', 'zume_course_nonce', true, true ) ?>
                            <p><label for="members"><?php esc_html_e( 'How many are with you?', 'zume' ) ?></label>
                                <select id="members" name="members">
                                    <?php
                                    $zume_group_meta = maybe_unserialize( $zume_group_meta );
                                    $i               = 1;
                                    while ( 27 > $i ) {
                                        echo '<option value="' . esc_attr( $i ) . '"';
                                        if ( $zume_group_meta['members'] == $i ) {
                                            echo 'selected';
                                        }
                                        echo '>' . esc_attr( $i ) . '</option>';
                                        $i ++;
                                    }
                                    ?>
                                </select></p>
                            <p><button type="submit" name="viewing" class="button" id="submit-group-session-button" value="group"><?php esc_html_e( 'Continue', 'zume' ) ?></button></p>
                        </form>
                    </div>
                    <div class="small-4 cell"></div>
                </div>

            </div>

        </section>
        <?php
    }

    public static function get_course_content_1( $alt_video = false ) {

        ?>
        <h3></h3>
        <section ><!-- Step Title -->
            <div id="s01-1of9">

            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Welcome to Zúme', 'zume' ) ?>
                </div>
                <!-- step-title cell -->
            </div><!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'Download', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description well">
                    <p>
                        <?php esc_html_e( 'You will be able to follow along on a digital PDF for this session, but please make sure that each member of your group has a printed copy of the materials for future sessions.', 'zume' ) ?>
                    </p>

                    <p>
                        <a class="button large text-uppercase"
                           href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                           target="_blank" rel="noopener noreferrer nofollow">
                            <?php esc_html_e( 'Download Guidebook', 'zume' ) ?>
                        </a>
                    </p>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div id="s01-2of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Group Prayer (5min)', 'zume' ) ?>
                </div>
            </div>

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Begin with prayer. Spiritual insight and transformation is not possible without the Holy Spirit. Take time as a group to invite Him to guide you over this session.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div id="s01-3of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div>
                <!-- step-title cell -->
            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'God uses ordinary people doing simple things to make a big impact. Watch this video on how God works.', 'zume' ) ?>
                </div>
            </div>
            <div class="grid-x grid-margin-x grid-margin-y" >
                <div class="small-12 small-centered cell">

                    <!-- 1 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/1.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '1' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>


                    <p class="center hide-for-small-only">
                        <a href="<?php echo esc_url( Zume_Course::get_download_by_key( '34' ) ) ?>"
                           target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Welcome", 'zume' ) ?></a></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'If Jesus intended every one of His followers to obey His Great Commission, why do so few actually make disciples?', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div id="s01-4of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?></div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'What is a disciple? And how do you make one? How do you teach a follower of Jesus to do what He told us in His Great Commission – to obey all of His commands?', 'zume' ) ?>
                </div>
            </div>

            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">


                    <!-- 2 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/2.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '2' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>


                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '35' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( 'Zúme Video Scripts: Teach Them to Obey', 'zume' ) ?></a></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol class="rectangle-list">
                        <li><?php esc_html_e( 'When you think of a church, what comes to mind?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'What\'s the difference between that picture and what\'s described in the video as a "Simple Church"?', 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( 'Which one do you think would be easier to multiply and why?', 'zume' ) ?></li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div id="s01-5of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?></div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'We breathe in. We breathe out. We\'re alive. Spiritual Breathing is like that, too.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">


                    <!-- 3 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/3.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '3' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '36' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( 'Zúme Video Scripts: Spiritual Breathing', 'zume' ) ?></a>
                    </p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol class="rectangle-list">
                        <li><?php esc_html_e( 'Why is it essential to learn to hear and recognize God\'s voice?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'Is hearing and responding to the Lord really like breathing? Why or why not?', 'zume' ) ?></li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section>
            <div id="s01-6of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'Listen and Read Along (3min)', 'zume' ) ?></div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'READ', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section"><?php esc_html_e( 'S.O.A.P.S. Bible Reading', 'zume' ) ?></p>
                    <p><?php esc_html_e( 'Hearing from God regularly is a key element in our personal relationship with Him, and in our ability to stay obediently engaged in what He is doing around us.', 'zume' ) ?></p>

                </div>
            </div>
            <!-- grid-x -->


            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Find the "S.O.A.P.S. Bible Reading" section in your Zúme Guidebook and listen to the audio overview.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 4 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/4.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '4' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a href="<?php echo esc_url( Zume_Course::get_download_by_key( '37' ) ) ?>"
                                                             target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( 'Zúme Video Scripts: S.O.A.P.S.', 'zume' ) ?></a></p>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section>
            <div id="s01-7of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'Listen and Read Along (3min)', 'zume' ) ?></div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'READ', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section">
                        <?php esc_html_e( 'Accountability Groups', 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'The Bible tells us that every follower of Jesus will one day be held accountable for what we do and say and think. Accountability Groups are a great way to get ready!', 'zume' ) ?>
                    </p>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Find the "Accountability Groups" section in your Zúme Guidebook, and listen to the audio below.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">


                    <!-- 5 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/5.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '5' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '38' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( 'Zúme Video Scripts: Accountability Groups', 'zume' ) ?></a>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div id="s01-8of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'Practice (45min)', 'zume' ) ?></div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'BREAK UP', 'zume' ) ?></div>
                <div class="large-9 cell activity-description"><?php esc_html_e( 'Break into groups of two or three people of the same gender.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">

                    <?php esc_html_e( 'Spend the next 45 minutes working together through Accountability Questions – List 2 in the "Accountability Groups" section of your', 'zume' ) ?>
                    <a class="btn btn-large next-step zume-purple uppercase bg-white font-zume-purple big-btn btn-wide"
                       href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                       target="_blank" rel="noopener noreferrer nofollow"><i
                            class="glyphicon glyphicon-download-alt"></i> <?php esc_html_e( 'Zúme Guidebook', 'zume' ) ?></a>.

                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section><!-- Step Title -->
            <div id="s01-9of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?>
                </div>
                <!-- step-title cell -->
                <div class="center cell">
                    <p id="complete_session_1"><?php esc_html_e( 'Congratulations! You\'ve completed Session 1.', 'zume' ) ?></p>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Below are next steps to take in preparation for the next session.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Begin practicing the S.O.A.P.S. Bible reading between now and your next meeting. Focus on Matthew 5-7, read it at least once a day. Keep a daily journal using the S.O.A.P.S. format.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Spend time asking God who He might want you to start an Accountability Group with using the tools you\'ve learned in this session. Share this person’s name with the group before you go. Reach out to that person about starting an Accountability Group and meeting with you weekly.', 'zume' ) ?>

                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'PRAY', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Pray that God helps you be obedient to Him and invite Him to work in you and those around you!', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Take a picture of your S.O.A.P.S. Bible study and share it on social media.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>

        <?php
    }

    public static function get_course_content_2( $alt_video = false ) {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s02-1of7">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'WELCOME BACK!', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'DOWNLOAD', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <p><?php esc_html_e( 'Does everyone have a printed copy of the Zúme Guidebook? If not, please be sure that someone can download the Guidebook and that everyone has access to some paper and a pen or pencil.', 'zume' ) ?>
                    </p>
                    <p>
                        <a class="button large text-uppercase"
                           href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                           target="_blank" rel="noopener noreferrer nofollow">
                            <?php esc_html_e( 'DOWNLOAD GUIDEBOOK', 'zume' ) ?>
                        </a>
                    </p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'CHECK-IN', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Before getting started, take some time to check-in.', 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( 'At the end of the last session, everyone in your group was challenged in two ways:', 'zume' ) ?>
                    <br><br>
                    <ol>
                        <li><?php esc_html_e( 'You were asked to begin practicing the S.O.A.P.S. Bible reading method and keeping a daily journal.', 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( 'You were encouraged to reach out to someone about starting an Accountability Group.', 'zume' ) ?></li>
                    </ol>
                    <?php esc_html_e( 'Take a few moments to see how your group did this week.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'PRAY', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Ask if anyone in the group has specific needs they would like the group to pray for. Ask someone to pray and ask God to help in the areas the group shared. Be sure to thank God that He promises in His Word to listen and act when His people pray. And, as always, ask God\'s Holy Spirit to lead your time, together.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s02-2of7">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'WATCH', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'If we want to make disciples who multiply – spiritual producers and not just consumers – then we need to learn and share four main ways God makes everyday followers more like Jesus:', 'zume' ) ?>
                    <ul style="padding:0;">
                        <li><?php esc_html_e( 'Prayer', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'Scripture', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'Body Life', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'Persecution and Suffering', 'zume' ) ?></li>
                    </ul>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 6 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/6.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '6' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '39' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Producers vs Consumers", 'zume' ) ?></a>
                    </p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( 'Of the four areas detailed above (prayer, God\'s Word, etc.), which ones do you already practice?', 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( 'Which ones do you feel unsure about?', 'zume' ) ?></li>
                        <li> <?php esc_html_e( 'How ready do you feel when it comes to training others?', 'zume' ) ?></li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s02-3of7">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Listen and Read Along (2min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'READ', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description">
                    <p class="read-section"><?php esc_html_e( 'Prayer Cycle', 'zume' ) ?></p>
                    <p><?php esc_html_e( 'The Bible tells us that prayer is our chance to speak to and hear from the same God who created us!', 'zume' ) ?></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Find the "Prayer Cycle" section in your Zúme Guidebook, and listen to the audio below.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 7 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/7.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '7' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '40' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( 'Zúme Video Scripts: Prayer Cycle', 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s02-4of7">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Practice the Prayer Cycle (60min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'LEAVE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Spend the next 60 minutes in prayer individually, using the exercises in "The Prayer Cycle" section of the Zúme Guidebook as a guide.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'RETURN', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Set a time for the group to return and reconnect. Be sure to add a few extra minutes for everyone to both find a quiet place to pray and to make their way back to the group.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( 'What is your reaction to spending an hour in prayer?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'How do you feel?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'Did you learn or hear anything?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'What would life be like if you made this kind of prayer a regular habit?', 'zume' ) ?></li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s02-5of7">
            <!-- Listen and Read Along -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Listen and Read Along (3min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( "READ", 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section">
                        <?php esc_html_e( 'List of 100', 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'God has already given us the relationships we need to “Go and make disciples.” These are our family, friends, neighbors, co-workers and classmates – people we’ve known all our lives or maybe just met.', 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'Being good stewards of these relationships is the first step in multiplying disciples. Start by making a list.', 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Find the "List of 100" section in your Zúme Guidebook, and listen to the audio below.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 8 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/8.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '8' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '41' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: List of 100", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s02-6of7">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Project (30min)', 'zume' ) ?>
                </div>
            </div>

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Create your own list of 100', 'zume' ) ?>
                            <br><br>
                            <?php esc_html_e( 'Have everyone in your group take the next 30 minutes to fill out their own inventory of relationships using the form in the "List of 100" section in your Zúme Guidebook. ', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s02-7of7">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell">
                    <p id="complete_session_2"><?php esc_html_e( 'Congratulations on finishing Session 2! ', 'zume' ) ?></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Below are next steps to take in preparation for the next session.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->


            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Spend time this week praying for five people from your List of 100 that you marked as an "Unbeliever" or "Unknown." Ask God to prepare their hearts to be open to His story.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Ask God who He wants you to share the List of 100 tool with. Share this person\'s name with the group before you go and reach out to them before the next session.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Pray that God help you be obedient to Him and invite Him to work in you and those around you!', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Think others could use the 60-minute prayer tool? Share about it on social media.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <?php
    }

    public static function get_course_content_3( $alt_video = false ) {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s03-1of7">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING BACK', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'CHECK-IN', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <p>
                        <?php esc_html_e( 'Before getting started, take some time to check-in.', 'zume' ) ?>
                    </p>

                    <p>
                        <?php esc_html_e( 'At the end of the last session, everyone in your group was challenged in two ways:', 'zume' ) ?>
                    </p>

                    <ol>
                        <li><?php esc_html_e( 'You were asked to pray for five people from your List of 100 that you marked as an "Unbeliever" or "Unknown."', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'You were encouraged to share how to make a List of 100 with someone.', 'zume' ) ?></li>
                    </ol>

                    <?php esc_html_e( 'Take a few moments to see how your group did this week.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'PRAY', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Pray and thank God for the results and invite His Holy Spirit to lead your time together.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'In this session, you’ll learn how God’s Spiritual Economy works and how God invests more in those who are faithful with what they\'ve already been given. You\'ll also learn two more tools for making disciples – sharing God’s Story from Creation to Judgement and Baptism.', 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( 'Then, when you\'re ready, get started!', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s03-2of7">

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'In this broken world, people feel rewarded when they take, when they receive and when they gain more than those around them. But God\'s Spiritual Economy is different – God invests more in those who are faithful with what they\'ve already been given.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 9 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/9.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '9' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a target="_blank" rel="noopener noreferrer nofollow"
                                                             href="<?php echo esc_url( Zume_Course::get_download_by_key( '42' ) ) ?>"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Spiritual Economy", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'What are some differences you see between God\'s Spiritual Economy and our earthly way of getting things done?', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s03-3of7">

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Read and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'READ', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p>
                        <?php esc_html_e( 'Jesus said, “You will receive power when the Holy Spirit comes upon you. And you will be my witnesses, telling people about me everywhere – in Jerusalem, throughout Judea, in Samaria, and to the ends of the earth.”', 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( "Jesus believed in His followers so much, He trusted them to tell His story. Then He sent them around the world to do it. Now, He’s sending us.", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'There’s no one “best way” to tell God’s story (also called The Gospel), because the best way will depend on who you’re sharing with. Every disciple should learn to tell God’s Story in a way that’s true to scripture and connects with the audience they’re sharing with.', 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( 'What comes to mind when you hear God\'s command to be His "witness" and to tell His story?', 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( 'Why do you think Jesus chose ordinary people instead of some other way to share His Good News?', 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( 'What would it take for you to feel more comfortable sharing God\'s Story?', 'zume' ) ?></li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s03-4of7">

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section"><?php esc_html_e( 'The Gospel', 'zume' ) ?></p>
                    <p><?php esc_html_e( 'One way to share God’s Good News is by telling God’s Story from Creation to Judgement – from the beginning of humankind all the way to the end of this age.', 'zume' ) ?></p>

                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 10 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/10.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '10' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a target="_blank" rel="noopener noreferrer nofollow"
                                                             href="<?php echo esc_url( Zume_Course::get_download_by_key( '43' ) ) ?>"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: The Gospel", 'zume' ) ?></a>
                    </p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( 'What do you learn about mankind from this story?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'What do you learn about God?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'Do you think it would be easier or harder to share God\'s Story by telling a story like this?', 'zume' ) ?>
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s03-5of7">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'PRACTICE SHARING GOD\'S STORY (45min)', 'zume' ) ?></div>
            </div>

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Break into groups of two or three people and spend the next 45 minutes practicing telling God\'s Story. You can use the using the Activity instructions for "God\'s Story" found in your Zúme Guidebook.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->
            </div>
        </section>
        <h3></h3>
        <section>
            <div id="s03-6of7">

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Read and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'READ', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section">
                        <?php esc_html_e( 'Baptism', 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the Father and of the Son and of the Holy Spirit…”', 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Find the "Baptism" section in your Zúme Guidebook, and listen to the audio below.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 11 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/11.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '11' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a target="_blank" rel="noopener noreferrer nofollow"
                                                             href="<?php echo esc_url( Zume_Course::get_download_by_key( '44' ) ) ?>"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Baptism", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( 'Have you ever baptized someone?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'Would you even consider it?', 'zume' ) ?></li>
                        <li><?php esc_html_e( 'If the Great Commission is for every follower of Jesus, does that mean every follower is allowed to baptize others? Why or why not?', 'zume' ) ?>
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <p>
                                <?php esc_html_e( 'IMPORTANT REMINDER – Have you been baptized?', 'zume' ) ?>
                            </p>
                            <p>
                                <?php esc_html_e( 'If not, then we encourage you to plan this before even one more session of this training. Invite your group to be a part of this important day when you celebrate saying "yes" to Jesus.', 'zume' ) ?>
                            </p>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s03-7of7">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell">
                    <p id="complete_session_3"><?php esc_html_e( 'Congratulations on finishing Session 3! ', 'zume' ) ?></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Below are next steps to take in preparation for the next session.', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Spend time this week practicing God\'s Story, and then share it with at least one person from your List of 100 that you marked as "Unbeliever" or "Unknown."', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Ask God who He wants you to train to use the Creation to Judgment story (or some other way to share God\'s Story). Share this person\'s name with the group before you go.', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Pray that God help you be obedient to Him and invite Him to work in you and those around you!', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'What’s been your Zúme highlight? Tell others about it on social media.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'IMPORTANT REMINDER – Your group will be celebrating the Lord\'s Supper next session. Be sure to remember the supplies (bread and wine / juice).', 'zume' ) ?>
                        </div>
                    </div>

                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->
            </div>
        </section>
        <?php
    }

    public static function get_course_content_4( $alt_video = false ) {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-1of9">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING BACK', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'CHECK-IN', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "At the end of the last session, everyone in your group was challenged in two ways:", 'zume' ) ?>
                    <br><br>
                    <ol>
                        <li><?php esc_html_e( 'You were asked to share God’s Story with at least one person from your List of 100 that you marked as "Unbeliever" or "Unknown."', 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "You were encouraged to train someone to use the Creation to Judgement story (or some other way to share God’s Story) with someone.", 'zume' ) ?>
                        </li>
                    </ol>
                    <?php esc_html_e( "Take a few moments to see how your group did this week.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'PRAY', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and thank God for the results and invite His Holy Spirit to lead your time together.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "In this session, you'll learn how God's plan is for every follower to multiply! You’ll discover how disciples multiply far and fast when they start to see where God’s Kingdom isn’t. And, you'll learn another great tool for inviting others into God's family is as simple as telling our story.", 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( "Then, when you're ready, get started!", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-2of9">
            <!-- Listen and Read Along -->

            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Listen and Read Along (3min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( "READ", 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section">
                        <?php esc_html_e( "3-Minute Testimony", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'As followers of Jesus, we are “witnesses" for Him, because we “testify” about the impact Jesus has had on our lives. Your story of your relationship with God is called your Testimony. It\'s powerful, and it\'s something no one can share better than you.', 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Find the \"3-Minute Testimony\" section in your Zúme Guidebook, and listen to the audio below.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 12 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/12.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '12' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '45' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Testimony", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-3of9">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Practice Sharing your Testimony (45min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Break into groups of two or three and and spend the next 45 minutes practicing sharing your Testimony using the Activity instructions on page 15 of your Zúme Guidebook.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-4of9">

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "What is God's greatest blessing for His children? Making disciples who multiply!", 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( "What if you could learn a simple pattern for making not just one follower of Jesus but entire spiritual families who multiply for generations to come?", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 13 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/13.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '13' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '46' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Greatest Blessing", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'DISCUSS', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( "Is this the pattern you were taught when you first began to follow Jesus? If not, what was different?", 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( "After you came to faith, how long was it before you began to disciple others?", 'zume' ) ?></li>
                        <li> <?php esc_html_e( "What do you think would happen if new followers started sharing and discipling others, immediately?", 'zume' ) ?>
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->

            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-5of9">

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "What do ducklings have to do with disciple making? They lead and follow at the same time.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 14 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/14.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '14' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only">
                        <a href="<?php echo esc_url( Zume_Course::get_download_by_key( '47' ) ) ?>"
                           target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Duckling Discipleship", 'zume' ) ?>
                        </a>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( "What is one area of discipleship (reading/understanding the Bible, praying, sharing God's Story, etc.) that you want to learn more about? Who is someone that could help you learn?", 'zume' ) ?>
                        </li>
                        <li> <?php esc_html_e( "What is one area of discipleship that you feel you could share with others? Who is someone that you could share with?", 'zume' ) ?>
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->

            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-6of9">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Have you ever stopped to think about where God's Kingdom... isn't?", 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( "Have you ever visited a home or a neighborhood or even a city where it seemed as if God was just... missing? These are usually the places where God wants to work the most.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 15 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/15.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '15' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '48' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Eyes to See", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( "Who are you more comfortable sharing with -- people you already know or people you haven't met, yet?", 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( "Why do you think that is?", 'zume' ) ?></li>
                        <li><?php esc_html_e( "How could you get better at sharing with people you're less comfortable with?", 'zume' ) ?></li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-7of9">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Listen and Read Along (3min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( "READ", 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section">
                        <?php esc_html_e( "The Lord's Supper", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( "Jesus said, “I am the living bread that came down from heaven. Whoever eats this bread will live forever. This bread is my flesh, which I will give for the life of the world.”", 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Find \"The Lord's Supper\" section in your Zúme Guidebook, and listen to the audio below.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 16 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/16.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '16' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '49' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Lord's Supper", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-8of9">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Practice the Lord's Supper (10min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Spend the next 10 minutes celebrating The Lord's Supper with your group using the pattern on page 15 of your Zúme Guidebook.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s04-9of9">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell"><br>
                    <p id="complete_session_4"><?php esc_html_e( "Congratulations on finishing Session 4!", 'zume' ) ?></p>
                    <p><?php esc_html_e( "Below are next steps to take in preparation for the next session.", 'zume' ) ?></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Spend time this week practicing your 3-Minute Testimony, and then share it with at least one person from your List of 100 that you marked as "Unbeliever" or "Unknown."', 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Ask God who He wants you to train with the 3-Minute Testimony tool. Share this person's name with the group before you go.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray that God help you be obedient to Him and invite Him to work in you and those around you!", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'What’s the best thing you got today? Share about it on social media.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <?php
    }

    public static function get_course_content_5( $alt_video = false ) {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s05-1of5">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING BACK', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'CHECK-IN', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "At the end of the last session, everyone in your group was challenged in two ways:", 'zume' ) ?>
                    <br><br>
                    <ol>
                        <li><?php esc_html_e( "You were asked to share your 3-Minute Testimony with at least one person on your List of 100.", 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( "You were encouraged to train someone else with the 3-Minute Testimony tool.", 'zume' ) ?></li>
                    </ol>
                    <?php esc_html_e( "Take a few moments to see how your group did this week.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'PRAY', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and thank God for the results and invite His Holy Spirit to lead your time together.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "In this session, you’ll learn how Prayer Walking is a powerful way to prepare a neighborhood for Jesus, and you'll learn a simple but powerful pattern for prayer that will help you meet and make new disciples along the way.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s05-2of5">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Listen and Read Along (15min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( "READ", 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section">
                        <?php esc_html_e( "Prayer Walking", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( "Prayer Walking is a simple way to obey God’s command to pray for others. And it's just what it sounds like – praying to God while walking around!", 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Find the \"Prayer Walking\" section in your Zúme Guidebook, and listen to the audio below.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 17 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/17.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '17' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '50' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Prayer Walking", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s05-3of5">

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Disciple-making can be rapidly advanced by finding a person of peace, even in a place where followers of Jesus are few and far between. How do you know when you have found a person of peace and what do you do when you find them?", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">

                <div class="small-12 small-centered cell">

                    <!-- 18 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/18.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '18' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a href="<?php echo esc_url( Zume_Course::get_download_by_key( '51' ) ) ?>"
                                                             target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Person of Peace", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li>
                            <?php esc_html_e( "Can someone who has a \"bad reputation\" (like the Samaritan woman or the demon-possessed man in the Gadarenes) really be a Person of Peace? Why or why not?", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "What is a community or segment of society near you that seems to have little (or no) Kingdom presence? How could a Person of Peace (someone who is OPEN, HOSPITABLE, KNOWS OTHERS and SHARES) accelerate the spread of the Gospel in that community?", 'zume' ) ?>
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>


        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s05-4of5">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Practice the B.L.E.S.S. Prayer (15min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Break into groups of two or three and practicing the B.L.E.S.S. Prayer. The prayer pattern can be found in the Zúme Guidebook. Practice praying the five areas of the B.L.E.S.S. Prayer.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s05-5of5">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell" id="complete_session_5">
                    <?php esc_html_e( "Prayer Walking (60-90min)", 'zume' ) ?>
                </div> <!-- grid-x -->
            </div>

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <p>1. <?php esc_html_e( "Break into groups of two or three and go out into the community to practice Prayer Walking.", 'zume' ) ?></p>
                            <p>2. <?php esc_html_e( "Choosing a location can be as simple as walking outside from where you are now, or you could plan to go to a specific destination.", 'zume' ) ?></p>
                            <p>3. <?php esc_html_e( "Go as God leads, and plan on spending 60-90 minutes on this activity.", 'zume' ) ?></p>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <div class="center cell">
                <p>
                    <?php esc_html_e( "The session ends with a prayer walking activity.", 'zume' ) ?></p>
                <p>
                    <?php esc_html_e( "Read through the Obey, Share, and Pray sections, below, before you head out!", 'zume' ) ?></p>
            </div>

            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="step-title cell center">
                    <?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?>
                </div> <!-- step-title cell -->

            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Spend time this week practicing Prayer Walking by going out alone or with a small group at least once.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Spend time asking God who He might want you to share the Prayer Walking tool with before your group meets again. Share this person’s name with the group before you go.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Before you go out on your Prayer Walking activity, be sure to pray with your group to end your time together. Thank God that He loves the lost, the last and the least – including us! Ask Him to prepare your heart and the heart of those you'll meet during your walk to be open to His work.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Take a picture of something you see on your prayer walk and post it on social media. ', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <?php
    }

    public static function get_course_content_6( $alt_video = false ) {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s06-1of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING BACK', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'CHECK-IN', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "At the end of the last session, everyone in your group was challenged in two ways:", 'zume' ) ?>
                    <br><br>
                    <ol>
                        <li><?php esc_html_e( "You were asked to spend some time Prayer Walking", 'zume' ) ?></li>
                        <li><?php esc_html_e( "You were encouraged to share the Prayer Walking tool with someone else.", 'zume' ) ?></li>
                    </ol>
                    <?php esc_html_e( "Take a few moments to see how your group did this week.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'PRAY', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and thank God for the results, ask Him to help when you find it hard to obey, and invite His Holy Spirit to lead your time together.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "In this session, you’ll learn how God uses faithful followers – even if they're brand new – much more than ones with years of knowledge and training who just won't obey. And you'll get a first look at a way to meet together that helps disciples multiply even faster.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s06-2of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "When we help multiply disciples, we need to make sure we're reproducing the right things. It's important what disciples know – but it's much more important what they DO with what they know.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 19 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/19.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '19' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '52' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Faithfulness", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Think about God's commands that you already know. How \"faithful\" are you in terms of obeying and sharing those things?", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s06-3of4">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Listen and Practice (75 min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( "READ", 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section">
                        <?php esc_html_e( "3/3 Groups Format", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( "A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow, fellowship, and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not just a small group but a Simple Church.", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( 'In the following video, you’ll be coached through an interactive 3/3 Group where you’ll learn a principle and then “press pause” and practice it with the group.', 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( 'Find the "3/3 Group Format" section in your Zúme Guidebook, and watch the video below.', 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 21 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/21.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '21' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '53' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: 3/3 Group", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li>
                            <?php esc_html_e( "Did you notice any differences between a 3/3 Group and a Bible Study or Small Group you've been a part of (or have heard about) in the past? If so, how would those differences impact the group?", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "Could a 3/3 Group be considered a Simple Church? Why or why not?", 'zume' ) ?>
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s06-4of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell">
                    <p  id="complete_session_6">
                        <?php esc_html_e( "Congratulations on finishing Session 6!", 'zume' ) ?></p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Below are next steps to take in preparation for the next session.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Spend time this week practicing Faithfulness by obeying and sharing at least one of God's commands that you already know.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Think about what you have heard and learned about Faithfulness in this session, and ask God who He wants you to share it with. Share this person’s name with the group before you go.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Thank God for His Faithfulness – for fulfilling every promise He's ever made. Ask Him to help you and your group become even more Faithful to Him.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Got a Christian brother or sister who might like Zúme? Share it with them on social media.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <?php
    }

    public static function get_course_content_7( $alt_video = false ) {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s07-1of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING BACK', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'CHECK-IN', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "At the end of the last session, everyone in your group was challenged in two ways:", 'zume' ) ?>
                    <br><br>
                    <ol>
                        <li>
                            <?php esc_html_e( "You were asked to practice Faithfulness by obeying and sharing one of God's commands.", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "You were encouraged to share the importance of Faithfulness with someone else.", 'zume' ) ?>
                        </li>
                    </ol>
                    <?php esc_html_e( "Take a few moments to see how your group did this week.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'PRAY', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and thank God for the group's commitment to faithfully following Jesus and invite God's Holy Spirit to lead your time together.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "In this session, you’ll learn a Training Cycle that helps disciples go from one to many and turns a mission into a movement. You'll also practice the 3/3 Groups Format and learn how the way you meet can impact the way you multiply.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s07-2of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p>
                        <?php esc_html_e( "Have you ever learned how to ride a bicycle? Have you ever helped someone else learn? If so, chances are you already know the Training Cycle.", 'zume' )?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Find the \"Training Cycle\" section in your Zúme Guidebook. When you're ready, watch this video, and then discuss the questions below.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 22 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/22.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '22' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '54' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Training Cycle", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( "Have you ever been a part of a Training Cycle?", 'zume' ) ?></li>
                        <li><?php esc_html_e( "Who did you train? Or who trained you?", 'zume' ) ?></li>
                        <li>
                            <?php esc_html_e( "Could the same person be at different parts of the Training Cycle while learning different skills?", 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( "What would it look like to train someone like that?", 'zume' ) ?></li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s07-3of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Practice and Discuss (90min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Have your entire group spend the next 90 minutes practicing the 3/3 Groups Format. Refer to the Zúme Guidebook if you need a reminder about the pattern.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->


            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( "PRACTICE", 'zume' ) ?></span>
                </div>
                <div class="large-9 cell activity-description">
                    <ul>
                        <li>
                            <?php esc_html_e( "LOOK BACK – Use last week's Session Challenges to practice \"Faithfulness\" in the Look Back section.", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "LOOK UP – Use Mark 5:1-20 as your group's reading passage and answer questions 1-4 during the Look Up section.", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "LOOK FORWARD – Use questions 5, 6, and 7 in the Look Forward section to develop how you will Obey, Train and Share.", 'zume' ) ?>
                        </li>
                    </ul>
                    <br>
                    <?php esc_html_e( "REMEMBER – Each section should take about 1/3 (or 30 minutes) of your practice time.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'DISCUSS', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( "What did you like best about the 3/3 Group? Why?", 'zume' ) ?></li>
                        <li><?php esc_html_e( "What was the most challenging? Why?", 'zume' ) ?></li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s07-4of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell">
                    <p id="complete_session_7">
                        <?php esc_html_e( "Congratulations on finishing Session 7!", 'zume' ) ?></p>
                    <p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Spend time this week obeying, training, and sharing based on the commitments you've made during your 3/3 Group practice.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and ask God who He wants you to share the 3/3 Group format with before your group meets again. Share this person’s name with the group before you go.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Thank God that He loves us enough to invite us into His most important work – growing His family!", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Hop on LIVE and tell the world what you just learned and where they could learn it too.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <?php
    }

    public static function get_course_content_8( $alt_video = false ) {
        ?>
        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s08-1of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING BACK', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'CHECK-IN', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Before getting started, take some time to check-in.", 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( "At the end of the last session, everyone in your group was challenged in two ways:", 'zume' ) ?>
                    <br><br>
                    <ol>
                        <li>
                            <?php esc_html_e( "You were asked to practice obeying, training, and sharing based on your commitments during 3/3 Group practice.", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "You were encouraged to share the 3/3 Group Format with someone else.", 'zume' ) ?>
                        </li>
                    </ol>
                    <?php esc_html_e( "Take a few moments to see how your group did this week.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'PRAY', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and thank God for giving your group the energy, the focus and the faithfulness to come so far in this training. Ask God to have His Holy Spirit remind everyone in the group that they can do nothing without Him!", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "In this session, you’ll learn how Leadership Cells prepare followers in a short time to become leaders for a lifetime. You'll learn how serving others is Jesus' strategy for leadership. And you'll spend time practicing as a 3/3 Group, again.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s08-2of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p>
                        <?php esc_html_e( "Jesus said, “Whoever wishes to become great among you shall be your servant.”", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( "Jesus radically reversed our understanding of leadership by teaching us that if we feel called to lead, then we are being called to serve. A Leadership Cell is a way someone who feels called to lead can develop their leadership by practicing serving.", 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Find the \"Leadership Cells\" section in your Zúme Guidebook. When you're ready, watch and discuss this video.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 23 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/23.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '23' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only"><a
                            href="<?php echo esc_url( Zume_Course::get_download_by_key( '55' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow"><img
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt=""
                                width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Leadership Cells", 'zume' ) ?></a></p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li>
                            <?php esc_html_e( "Is there a group of followers of Jesus you know that are already meeting or would be willing to meet and form a Leadership Cell to learn Zúme Training?", 'zume' ) ?>
                        </li>
                        <li> <?php esc_html_e( "What would it take to bring them together?", 'zume' ) ?></li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s08-3of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Practice 3/3 Group (90min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div>

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="cell auto"></div>
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Have your entire group spend the next 90 minutes practicing the 3/3 Groups Format.", 'zume' ) ?>
                        </div>
                    </div>
                </div>
                <div class="cell auto"></div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <span>
                        <?php esc_html_e( "PRACTICE", 'zume' ) ?>
                    </span>
                </div>

                <div class="large-9 cell activity-description">
                    <ul>
                        <li>
                            <?php esc_html_e( "LOOK BACK – Use last session’s Obey, Train, and Share challenges to check-in with each other.", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "LOOK UP – Use Acts 2:42-47 as your group’s reading passage and answer questions 1- 4.", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "LOOK FORWARD – Use questions 5, 6, and 7 to develop how you will Obey, Train and Share.", 'zume' ) ?>
                        </li>
                    </ul>
                    <br>
                    <?php esc_html_e( "REMEMBER – Each section should take about 1/3 (or 30 minutes) of your practice time.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s08-4of4">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell">
                    <p id="complete_session_8">
                        <?php esc_html_e( "Congratulations! You've completed Session 8. ", 'zume' ) ?></p>
                    <p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Spend time again this week obeying, sharing, and training based on the commitments you've made during this session's 3/3 Group practice.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and ask God who He wants you to share the Leadership Cell tool with before your group meets again. Share this person’s name with the group before you go.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Thank God for sending Jesus to show us that real leaders are real servants. Thank Jesus for showing us the greatest service possible is giving up our own lives for others.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'What’s the best thing you got today? Share about it on social media.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>

        <?php
    }

    public static function get_course_content_9( $alt_video = false ) {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s09-1of7">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'LOOKING BACK', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'CHECK-IN', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description">

                    <p><?php esc_html_e( "Before getting started, take some time to check-in.", 'zume' ) ?></p>

                    <p><?php esc_html_e( "At the end of the last session, everyone in your group was challenged in two ways:", 'zume' ) ?></p>
                    <ol>
                        <li>
                            <?php esc_html_e( "You were asked to practice Obeying, Training, and Sharing based on your commitments during last session's 3/3 Group practice.", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "You were encouraged to share the Leadership Cells tool with someone else.", 'zume' ) ?>
                        </li>
                    </ol>
                    <?php esc_html_e( "Take a few moments to see how your group did this week.", 'zume' ) ?>

                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and thank God that His ways are not our ways and His thoughts are not our thoughts. Ask Him to give each member of your group the mind of Christ — always focused on His Father's work. Ask the Holy Spirit to lead your time together and make it the best session yet.", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "In this session, you’ll learn how linear patterns hold back kingdom growth and how Non-Sequential thinking helps you multiply disciples. You'll discover how much time matters in disciple-making and how to accelerate Pace. You’ll learn how followers of Jesus can be a Part of Two Churches to help turn faithful, spiritual families into a growing city-wide body of believers. Finally, you'll learn how a simple Three Month Plan can focus your efforts and multiply your effectiveness in growing God's family exponentially.", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section><!-- Step -->
        <h3></h3>
        <section>
            <div id="s09-2of7">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <?php esc_html_e( 'WATCH', 'zume' ) ?>
                </div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "When people think about disciples multiplying, they often think of it as a step-by-step process. The problem with that is — that's not how it works best!", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="small-12 small-centered cell">

                    <!-- 24 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/24.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '24' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only">
                        <a href="<?php echo esc_url( Zume_Course::get_download_by_key( '56' ) ) ?>"
                           target="_blank" rel="noopener noreferrer nofollow" >
                            <img class="alignnone size-thumbnail wp-image-3274"
                                 style="vertical-align: text-bottom;"
                                 src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                 alt="" width="35" height="35"/>
                            <?php esc_html_e( "Zúme Video Scripts: Non-Sequential", 'zume' ) ?>
                        </a>
                    </p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( "What is the most exciting idea you heard in this video? Why?", 'zume' ) ?></li>
                        <li><?php esc_html_e( "What is the most challenging idea? Why?", 'zume' ) ?></li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section><!-- Step -->
        <h3></h3>
        <section>
            <div id="s09-3of7">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?></div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Multiplying matters and multiplying quickly matters even more. Pace matters because where we all spend our eternity — an existence that outlasts time — is determined in the very short time we call “life.“", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="small-12 small-centered cell">

                    <!-- 25 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/25.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '25' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only">
                        <a  href="<?php echo esc_url( Zume_Course::get_download_by_key( '57' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow" ><img
                                class="alignnone size-thumbnail wp-image-3274"
                                style="vertical-align: text-bottom;"
                                src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                alt="" width="35" height="35"/>
                            <?php esc_html_e( "Zúme Video Scripts: Pace", 'zume' ) ?>
                        </a>
                    </p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( "Why is pace important?", 'zume' ) ?></li>
                        <li>
                            <?php esc_html_e( "What do you need to change in your thinking, your actions, or your attitude to be better aligned with God's priority for pace?", 'zume' ) ?>
                        </li>
                        <li><?php esc_html_e( "What is one thing you can do starting this week that will make a difference?", 'zume' ) ?></li>
                    </ol>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section><!-- Step -->
        <h3></h3>
        <section>
            <div id="s09-4of7">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?></div>
                <!-- step-title cell -->

            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Jesus taught us that we are to stay close — to live as a small, spiritual family, to love and give our lives to one another, to celebrate and suffer — together. However, Jesus also taught us to leave our homes and loved ones behind and be willing to go anywhere — and everywhere — to share and start new spiritual families. So how can we do both? When you're ready, watch the video below and discuss the question that follows.", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
                <div class="small-12 small-centered cell">

                    <!-- 26 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/26.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '26' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only">
                        <a  href="<?php echo esc_url( Zume_Course::get_download_by_key( '58' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow">
                            <img class="alignnone size-thumbnail wp-image-3274"
                                 style="vertical-align: text-bottom;"
                                 src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                 alt="" width="35" height="35"/>
                            <?php esc_html_e( "Zúme Video Scripts: Two Churches", 'zume' ) ?>
                        </a>
                    </p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "What are some advantages of maintaining a consistent spiritual family that gives birth to new ones that grow and multiply instead of continually growing a family and splitting it in order to grow?", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section><!-- Step -->
        <h3></h3>
        <section>
            <div id="s09-5of7">
            <div class="grid-x grid-margin-x grid-margin-y">

                <div class="step-title cell"><?php esc_html_e( "Create a Three Month Plan (30min)", 'zume' ) ?></div>
                <!-- step-title cell -->
                <div class="center cell">

                    <!-- grid-x -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-3 cell activity-title"><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></div>
                        <div class="large-9 cell activity-description">
                            <p>
                                <?php esc_html_e( "In His Bible, God says, \"I know the plans I have for you, plans to prosper you and not to harm you, plans to give you hope and a future.\" God makes plans, and He expects us to make plans, too. He teaches us through His Word and His work to look ahead, see a better tomorrow, make a plan for how to get there, and then prepare the resources we'll need on the way.", 'zume' ) ?>
                            </p>
                            <p>
                                <?php esc_html_e( "A Three Month Plan is a tool you can use to help focus your attention and efforts and keep them aligned with God's priorities for making disciples who multiply. Spend the next 30 minutes praying over, reading through, and then completing the commitments listed in the Three Month Plan.", 'zume' ) ?>
                            </p>
                            <p>
                                <?php esc_html_e( "You can use the printed version in your Zúme Guidebook or our online version.", 'zume' ) ?>
                            </p>
                            <h2>
                                <a class="button" target="_blank" rel="noopener nofollow noreferrer" href="<?php echo esc_url( zume_three_month_plan_url() ) ?>"><i class="fi-link"></i> <?php esc_html_e( 'Online "Three Month Plan"', 'zume' ) ?></a>
                            </h2>
                        </div>
                    </div>
                    <!-- grid-x -->

                    <?php if ( is_user_logged_in() ) : ?>
                    <!-- Inset Block -->
                    <div class="grid-x grid-margin-x grid-margin-y single">
                        <div class="cell auto"></div>
                        <div class="large-9 cell activity-description well">
                            <div class="grid-x grid-padding-x grid-padding-y center" >
                                <div class="cell session-boxes">
                                    <?php esc_html_e( "Participants can access their own three month plan on the side column of their dashboard. They can connect their plan with this group by adding the following key:", 'zume' ) ?>
                                    <h2>
                                        <?php
                                        if ( isset( $_GET['group'] ) ) {
                                            $zume_group_key = sanitize_key( wp_unslash( $_GET['group'] ) );
                                            echo esc_attr( Zume_V4_Groups::get_group_public_key_by_foreign_key( $zume_group_key ) );
                                        }
                                        ?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="cell auto"></div>
                    </div> <!-- grid-x -->
                    <?php endif; ?>

                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                        <div class="large-9 cell activity-description">
                            <p>
                                <?php esc_html_e( "Ask God what He specifically wants you to do with the basic disciple-making tools and techniques you have learned over these last nine sessions. You can remember them in terms of the Greatest Blessing.", 'zume' ) ?>
                            </p>
                            <ul style="margin-left: 50px;">
                                <li>
                                    <?php esc_html_e( "It's a Blessing to ... S.O.A.P.S. Bible Reading, Accountability Groups, Prayer Cycle", 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( "It's a Great Blessing to ... Share your 3-Minute Testimony and God's Story, Prayer Walking", 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( "It's a Greater Blessing to ... Start a 3/3rds Group", 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( "It's the Greatest Blessing to ... Start a Zúme Group", 'zume' ) ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- grid-x -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-3 cell activity-title"><?php esc_html_e( 'LISTEN', 'zume' ) ?></div>
                        <div class="large-9 cell activity-description">
                            <?php esc_html_e( "Take at least 10 minutes to be as quiet as possible and listen intently to what God has to say and what He chooses to reveal. Make an effort to hear His voice.", 'zume' ) ?>
                        </div>
                    </div>
                    <!-- grid-x -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-3 cell activity-title"><?php esc_html_e( 'COMPLETE', 'zume' ) ?></div>
                        <div class="large-9 cell activity-description">
                            <p>
                                <?php echo esc_html( str_replace( "ZúmeProject.com", "https://zume.training", __( "Use the rest of your time to complete the Three Month Plan worksheet. You can write it out on a piece of paper. If you are logged in to ZúmeProject.com you can fill out your form digitally and link it to your group. Once you login, you’ll find the Three Month Plan under Settings. You can also find the Three Month Plan on your Dashboard.", 'zume' ) ) ); ?>
                            </p>
                            <p>
                                <?php esc_html_e( "You do not have to commit to every item, and there is room for other items not already on the list. Do your best to align your commitments to what you have heard God reveal to you about His will.", 'zume' ) ?>
                            </p>

                        </div>
                    </div>
                    <!-- grid-x -->

                </div>
            </div>
            </div>
        </section><!-- Step -->
        <h3></h3>
        <section>
            <div id="s09-6of7">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"> <?php esc_html_e( "Share you Plan (30min)", 'zume' ) ?></div>
                <!-- step-title cell -->
            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section"><?php esc_html_e( "In groups of two or three (15 minutes)", 'zume' ) ?></p>

                    <p><?php esc_html_e( "Take turns sharing your Three Month Plans with each other. Take time to ask questions about things you might not understand about plans and how the others will meet their commitments. Ask them to do the same for you and your plan. Find a training partner(s) that is willing to check in with you to report on progress and challenges and ask questions after 1, 2, 3, 4, 6, 8 and 12 weeks. Commit to doing the same for them.", 'zume' ) ?>
                    </p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section"><?php esc_html_e( "In your full training Group (15 minutes)", 'zume' ) ?></p>
                    <p>
                        <?php esc_html_e( "Discuss and develop a group plan for starting at least two new 3/3 Groups or Zúme Training Groups in your area. Several of your group members may have just completed and saved your individual Three-Month Plans to your Zúme group. On this step, if no one from your group has filled out a digital copy on the website of your Three-Month Plan, it is highly recommended that you do this together now. Just go to the Three-Month Plan under Settings and link the form to your group.", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( "Remember, your goal is to start Simple Churches that multiply. 3/3 Groups and Zúme Training Groups are two ways to do that. Discuss and decide whether these new Groups will be connected to an existing local church or network or whether you’ll start a new network out of your Zúme Training Group.", 'zume' ) ?>
                    </p>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section><!-- Step -->
        <h3></h3>
        <section>
            <div id="s09-7of7">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell"><?php esc_html_e( 'LOOKING FORWARD', 'zume' ) ?></div>
                <!-- step-title cell -->
                <div class="center vertical-padding" id="complete_session_9">
                    <?php esc_html_e( "Congratulations! You've completed Session 9.", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->

            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'OBEY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p><?php esc_html_e( "You may not know it, but you now have more practical training on starting simple churches and making disciples who multiply than many pastors and missionaries around the world!", 'zume' ) ?></p>
                    <p><?php esc_html_e( "Set aside time on your calendar each week to continue to work on your Three Month Plan, and plan check-ins with your training partner at the end of week 1, 2, 3, 4, 6, 8, and 12. Each time you're together, ask about their results and share yours, making sure you're both working through your plans. Prayerfully consider continuing as an ongoing spiritual family committed to multiplying disciples.", 'zume' ) ?></p>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'SHARE', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and ask God who He would have you share Zúme Training with by launching a Leadership Cell of future Zúme Training leaders.", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'PRAY', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Be sure to pray with your group before you end your time together. Thank God that He has created and gifted you with exactly the right talents to make a difference in His kingdom. Ask Him for wisdom to use the strengths He has given you and to find other followers who help cover your weaknesses. Pray that He would make you fruitful and multiply — this was His plan from the very beginning. Pray that God help you be obedient to Him and invite Him to work in you and those around you!", 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            <!-- Activity Block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title lowercase"><?php esc_html_e( '#ZumeProject', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( 'Excited to help a new Zúme group get started? Share about Zúme on social media and let people know where they can get started.', 'zume' ) ?>
                </div>
            </div>
            <!-- grid-x -->
            </div>
        </section>
        <?php
    }

    public static function get_course_content_10( $alt_video = false ) {
        ?>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s10-1of6">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Looking Back', 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell"><?php esc_html_e( 'Welcome back to Zúme Training!', 'zume' ) ?></div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'CHECK-IN', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Before getting started, take some time to check-in.", 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( "At the end of the last session, everyone in your group was challenged in two ways:", 'zume' ) ?>
                    <br><br>
                    <ol>
                        <li>
                            <?php esc_html_e( "You were asked to prayerfully consider continuing as an ongoing spiritual family committed to multiplying disciples.", 'zume' ) ?>
                        </li>
                        <li>
                            <?php esc_html_e( "You were encouraged to share Zúme Training by launching a Leadership Cell of future Zúme Training leaders.", 'zume' ) ?>
                        </li>
                    </ol>
                    <?php esc_html_e( "Take a few moments to see how your group has been doing with these items and their Three Month Plans since you've last met.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'PRAY', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Pray and thank God that He is faithful to complete His good work in us. Ask Him to give your group clear heads and open hearts to the great things He wants to do in and through you. Ask the Holy Spirit to lead your time together and thank Him for His faithfulness, too. He got you through!", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( 'OVERVIEW', 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "In this advanced training session, you’ll take a look at how you can level-up your Coaching Strengths with a quick checklist assessment. You’ll learn how Leadership in Networks allows a growing group of small churches to work together to accomplish even more. And you’ll learn how to develop Peer Mentoring Groups that take leaders to a whole new level of growth.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s10-2of6">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Activity (10min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell step-header"><?php esc_html_e( "Assess yourself using the coaching checklist.", 'zume' ) ?></div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'ASSESS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "The Coaching Checklist is a powerful tool you can use to quickly assess your own strengths and vulnerabilities when it comes to making disciples who multiply. It's also a powerful tool you can use to help others – and others can use to help you.", 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( "Find the Coaching Checklist section in your Zúme Guidebook, and take this quick (5-minutes or less) self-assessment:", 'zume' ) ?>
                    <br><br>
                    <ol>
                        <li><?php esc_html_e( "Read through the Disciple Training Tools in the far left column of the Checklist.", 'zume' ) ?></li>
                        <li><?php esc_html_e( "Mark each one of the Training Tools, using the following method:", 'zume' ) ?>
                            <ul>
                                <li> <?php esc_html_e( "If you're unfamiliar or don't understand the Tool – check the BLACK column", 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( "If you're somewhat familiar but still not sure about the Tool – check the RED column", 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( "If you understand and can train the basics on the Tool – check the YELLOW column", 'zume' ) ?>
                                </li>
                                <li>
                                    <?php esc_html_e( "If you feel confident and can effectively train the Tool – check the GREEN column", 'zume' ) ?>
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 28 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/28.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '28' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only">
                        <a  href="<?php echo esc_url( Zume_Course::get_download_by_key( '60' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow">
                            <img    src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/>
                            <?php esc_html_e( "Zúme Video Scripts: Coaching Checklist", 'zume' ) ?>
                        </a>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <ol>
                        <li><?php esc_html_e( "Which Training Tools did you feel you would be able to train well?", 'zume' ) ?></li>
                        <li><?php esc_html_e( "Which ones made you feel vulnerable as a trainer?", 'zume' ) ?></li>
                        <li><?php esc_html_e( "Are there any Training Tools that you would add or subtract from the Checklist? Why?", 'zume' ) ?></li>
                    </ol>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "REMEMBER – Be sure to share your Coaching Checklist results with training partner or other mentor. If you're helping coach or mentor someone, use this tool to help you assess which areas need your attention and training.", 'zume' ) ?>
                        </div>
                    </div>

                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s10-3of6">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Watch and Discuss (15min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'WATCH', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "What happens to churches as they grow and start new churches that start new churches? How do they stay connected and live life together as an extended, spiritual family? They become a network!", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 29 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/29.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '29' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only">
                        <a  href="<?php echo esc_url( Zume_Course::get_download_by_key( '61' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow">
                            <img    src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/> <?php esc_html_e( "Zúme Video Scripts: Leadership in Networks", 'zume' ) ?></a>
                    </p>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( 'DISCUSS', 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Are there advantages when networks of simple churches are connected by deep, personal relationships? What are some examples that come to mind?", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s10-4of6">
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( 'Listen and Read Along (3min)', 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><?php esc_html_e( "READ", 'zume' ) ?></div>
                <div class="large-9 cell activity-description">
                    <p class="read-section">
                        <?php esc_html_e( "Peer Mentoring Groups", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( "Making disciples who make disciples means making leaders who make leaders. How do you develop stronger leaders? By teaching them how to love one another better. Peer Mentoring Groups help leaders love deeper.", 'zume' ) ?>
                    </p>
                    <p>
                        <?php esc_html_e( "Find the Peer Mentoring Groups section in your Zúme Guidebook, and listen to the audio below.", 'zume' ) ?>
                    </p>
                </div>
            </div> <!-- grid-x -->

            <!-- Video block -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="small-12 small-centered cell">

                    <!-- 30 -->
                    <?php if ( $alt_video ) : ?>
                        <div class="alt-video-section">
                            <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/30.mp4' ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    <?php else : ?>
                        <div class="video-section">
                            <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '30' ) ) ?>" width="560" height="315"
                                    frameborder="1"
                                    webkitallowfullscreen mozallowfullscreen allowfullscreen>
                            </iframe>
                        </div>
                    <?php endif; ?>

                    <p class="center hide-for-small-only">
                        <a  href="<?php echo esc_url( Zume_Course::get_download_by_key( '62' ) ) ?>"
                            target="_blank" rel="noopener noreferrer nofollow">
                            <img    src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                    alt=""
                                    width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                    style="vertical-align: text-bottom"/>
                            <?php esc_html_e( "Zúme Video Scripts: Peer Mentoring Groups", 'zume' ) ?>
                        </a>
                    </p>
                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s10-5of6">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell">
                    <?php esc_html_e( "Practice (60min)", 'zume' ) ?>
                </div> <!-- step-title cell -->
            </div> <!-- grid-x -->

            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "Find the Peer Mentoring Groups section in your Zúme Training Guide, and follow these steps.", 'zume' ) ?>
                        </div>
                    </div>

                </div>
            </div> <!-- grid-x -->

            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title">
                    <span>
                        <?php esc_html_e( "GROUPS", 'zume' ) ?>
                    </span>
                </div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "Break into groups of two or three and work through the 3/3 sections of the Peer Mentoring Group format. Peer Mentoring is something that happens once a month or once a quarter and takes some time for the whole group to participate, so you will not have time for everyone to experience the full mentoring process in this session.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->
            <!-- Activity Block  -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="large-3 cell activity-title"><span><?php esc_html_e( "PRACTICE", 'zume' ) ?></span></div>
                <div class="large-9 cell activity-description">
                    <?php esc_html_e( "To practice, choose one person in your group to be the \"mentee\" for this session and have the other members spend time acting as Peer Mentors by working through the suggested questions list and providing guidance and encouragement for the Mentee's work.", 'zume' ) ?>
                    <br><br>
                    <?php esc_html_e( "By the time you're finished, everyone should have a basic understanding of asking and answering.", 'zume' ) ?>
                </div>
            </div> <!-- grid-x -->

            <!-- Inset Block -->
            <div class="grid-x grid-margin-x grid-margin-y single">
                <div class="large-9 cell activity-description well">
                    <div class="grid-x grid-padding-x grid-padding-y center" >
                        <div class="cell session-boxes">
                            <?php esc_html_e( "REMEMBER – Spend time studying the Four Fields Diagnostic Diagram and Generational Map in the Peer Mentoring Groups section of your Zúme Training Guide. Make sure everyone in your group has a basic understanding of these tools before asking the suggested questions.", 'zume' ) ?>
                        </div>
                    </div>

                </div>
            </div> <!-- grid-x -->
            </div>
        </section>

        <!-- Step -->
        <h3></h3>
        <section>
            <div id="s10-6of6">
            <!-- Step Title -->
            <div class="grid-x grid-margin-x grid-margin-y">
                <div class="step-title cell" style="text-transform: uppercase" id="complete_session_10">
                    <?php esc_html_e( "CONGRATULATIONS ON COMPLETING ZÚME TRAINING!", 'zume' ) ?>
                </div> <!-- step-title cell -->
                <div class="center cell">

                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="large-3 cell activity-title"><span><?php esc_html_e( 'WATCH', 'zume' ) ?></span></div>
                        <div class="large-9 cell activity-description">
                            <?php esc_html_e( "You and your group are now ready to take leadership to a new level! Here are a few more steps to help you KEEP growing!", 'zume' ) ?>
                        </div>
                    </div>

                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="small-12 small-centered cell">

                            <!-- 27 -->
                            <?php if ( $alt_video ) : ?>
                                <div class="alt-video-section">
                                    <video style="border: 1px solid lightgrey;max-width:100%;" controls>
                                        <source src="<?php echo esc_url( zume_mirror_url() . zume_current_language() ) . '/27.mp4' ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            <?php else : ?>
                                <div class="video-section">
                                    <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( '27' ) ) ?>" width="560" height="315"
                                            frameborder="1"
                                            webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                    </iframe>
                                </div>
                            <?php endif; ?>

                            <p class="center hide-for-small-only">
                                <a  href="<?php echo esc_url( Zume_Course::get_download_by_key( '59' ) ) ?>"
                                    target="_blank" rel="noopener noreferrer nofollow">
                                    <img src="<?php echo esc_url( zume_images_uri( 'course' ) ) ?>download-icon-150x150.png"
                                         alt="" width="35" height="35" class="alignnone size-thumbnail wp-image-3274"
                                         style="vertical-align: text-bottom"/>
                                    <?php esc_html_e( "Zúme Video Scripts: Completion of Training", 'zume' ) ?>
                                </a>
                            </p>
                        </div>
                    </div>

                    <br><br>
                </div>
            </div>
            </div>
        </section>
        <?php
    }
}
