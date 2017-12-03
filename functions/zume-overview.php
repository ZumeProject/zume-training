<?php

/**
 * Zume Overview
 *
 * @class Disciple_Tools_Admin_Menus
 * @version	0.1
 * @since 0.1
 * @package	Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Zume_Overview {

    /**
     * Zume_Overview The single instance of Zume_Overview.
     * @var 	object
     * @access  private
     * @since 	0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Overview Instance
     *
     * Ensures only one instance of Zume_Overview is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Overview instance
     */
    public static function instance () {
        if ( is_null( self::$_instance ) )
            self::$_instance = new self();
        return self::$_instance;
    } // End instance()

    /**
     * Zume Overview: Primary content section
     * @return mixed
     */
    public static function load_sessions( $session = 1) {
        ?>
        <h2 class="center padding-bottom">Sessions Overview</h2>

        <script>
            jQuery(document).ready(function($) {
                "use strict";
                var startIndex = 0;
                if (! isNaN(parseInt(window.location.hash.substr(2)))) {
                    startIndex = parseInt(window.location.hash.substr(2)) - 1;
                }

                jQuery("#overview").steps({
                    // Disables the finish button (required if pagination is enabled)
                    enableFinishButton: false,
                    // Disables the next and previous buttons (optional)
                    enablePagination: false,
                    // Enables all steps from the begining
                    enableAllSteps: true,
                    // Removes the number from the title
//                    titleTemplate: "#title#",
                    startIndex: startIndex,
                    headerTag: "h3",
                    bodyTag: "section",
                    transitionEffect: "fade",
                    autoFocus: true,
                    onStepChanged: function(event, currentIndex, priorIndex) {
                        var newHash = "#s" + (currentIndex + 1);
                        <?php /* Replaces window.location.hash without creating
                        a history entry, and without scrolling or jumping, and
                        without triggering hashchange */ ?>
                        history.replaceState(null, null, newHash);
                    },
                    titleTemplate: '<span class="number">#index#</span> #title#'
                });
                window.addEventListener("hashchange", function(event) {
                    <?php /* This can get triggered when Overview menu items
                    get clicked */ ?>
                    var hash = event.newURL.substr(event.newURL.indexOf("#"));
                    if (! isNaN(parseInt(hash.substr(2)))) {
                        var stepIndex = parseInt(hash.substr(2)) - 1;
                        $("#overview .steps a#overview-t-" + stepIndex).click();
                    }
                });

            });

        </script>

        <div id="overview">
            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 1</h3>
                <?php self::get_overview_1() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 2</h3>
                <?php  self::get_overview_2() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 3</h3>
                <?php  self::get_overview_3() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 4</h3>
                <?php  self::get_overview_4() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 5</h3>
                <?php  self::get_overview_5() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 6</h3>
                <?php  self::get_overview_6() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 7</h3>
                <?php  self::get_overview_7() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 8</h3>
                <?php  self::get_overview_8() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 9</h3>
                <?php  self::get_overview_9() ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 10 - Advanced Training</h3>
                <?php  self::get_overview_10() ?>
            </section>

        </div>

        <?php if(is_user_logged_in()) { self::next_session_block(); } ?>

        <?php
    }

	public static function get_overview_1() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full" src="/wp-content/uploads/1.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full" src="/wp-content/uploads/1.2.png" alt="" width="400"
                    height="225"/><img class="alignnone wp-image-945 size-full" src="/wp-content/uploads/1.3.png" alt=""
                                       width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/Concept-1-4.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1564"/></td>
                <td>WELCOME TO ZÚME — You'll see how God uses ordinary people doing simple things to make a big
                    impact.
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/Concept-2-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1565"/></td>
                <td>TEACH THEM TO OBEY — Discover the essence of being a disciple, making a disciple, and what is the
                    church.
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/Concept-3-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1566"/></td>
                <td>SPIRITUAL BREATHING — Being a disciple means we hear from God and we obey God.</td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/tool-1-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1035"/></td>
                <td>S.O.A.P.S. BIBLE READING — a tool for daily Bible study that helps you understand, obey, and share
                    God’s Word
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/Tools-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1567"/></td>
                <td>ACCOUNTABILITY GROUPS — a tool for two or three people of the same gender to meet weekly and
                    encourage each other in areas that are going well and reveal areas that need correction
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>
        <table>
            <tr>
                <td><img src="/wp-content/uploads/Practice-1-5.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1568"/></td>
                <td>ACCOUNTABILITY GROUPS — Break into groups of two or three people to work through the Accountability
                    Questions. (45 minutes)
                </td>
            </tr>
        </table>
		<?php
	}

	public static function get_overview_2() {
		?>
        <div class="overview-image-bar"><img src="/wp-content/uploads/2.1.png" alt=""
                                             class="alignnone size-full wp-image-948"/><img
                    src="/wp-content/uploads/2.2.png" alt="" class="alignnone size-full wp-image-949"/><img
                    src="/wp-content/uploads/2.3-1.png"
                    alt="List 100 people you know, 3 categories: those who follow Jesus, those who don&#039;t follow Jesus, those they&#039;re not sure about"
                    width="400" height="225" class="alignnone size-full wp-image-1066"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/Concept-1-5.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1576"/></td>
                <td>PRODUCERS VS. CONSUMERS — You'll discover the four main ways God makes everyday followers more like
                    Jesus.
                </td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/Practice-1-6.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1577"/></td>
                <td>PRAYER CYCLE — See how easy it is to spend an hour in prayer.</td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/Practice-2-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1578"/></td>
                <td>LIST OF 100 — a tool designed to help you be a good steward of your relationships</td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/Tool-1-4.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1579"/></td>
                <td>PRAYER CYCLE — Spend 60 minutes in prayer individually.</td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/Tool-2-3.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1580"/></td>
                <td>LIST OF 100 — Create your own list of 100. (30 minutes)</td>
            </tr>
        </table>


		<?php
	}

	public static function get_overview_3() {
		?>
        <div class="overview-image-bar"><img src="/wp-content/uploads/3.1-1.png"
                                             alt="Whoever can be trusted with very little can also be trusted with much. - Jesus. Breathe in, hear, breathe out, obey and share. Giving God&#039;s blessings"
                                             width="400" height="225" class="alignnone size-full wp-image-1068"/><img
                    src="/wp-content/uploads/3.2.png" alt="Obey, do, practise, share, teach, pass on" width="400"
                    height="225" class="alignnone size-full wp-image-955"/><img src="/wp-content/uploads/3.3.png" alt=""
                                                                                width="400" height="225"
                                                                                class="alignnone size-full wp-image-957"/>
        </div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/concept-1-1.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1023"/></td>
                <td>SPIRITUAL ECONOMY — Learn how God's economy is different from the world's. God invests more in those
                    who are faithful with what they've already been given.
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/concept-2-1.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1024"/></td>
                <td>CREATION TO JUDGMENT — Learn a way to share God’s Good News from the beginning of humanity all the
                    way to the end of this age.
                </td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/tool-1-1-1.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1183"/></td>
                <td>BAPTISM — Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the
                    Father and of the Son and of the Holy Spirit…” Learn how to put this into practice.
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/tool-2-1.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1026"/></td>
                <td>SHARE GOD’S STORY — Break into groups of two or three and practice sharing God’s Story. (45
                    minutes)
                </td>
            </tr>
        </table>


		<?php
	}

	public static function get_overview_4() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full" src="/wp-content/uploads/4.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full" src="/wp-content/uploads/4.2.png" alt="" width="400"
                    height="225"/><img class="alignnone wp-image-945 size-full" src="/wp-content/uploads/4.3.png" alt=""
                                       width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/concept-1-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1028"/></td>
                <td>GREATEST BLESSING — Learn a simple pattern of making not just one follower of Jesus but entire
                    spiritual families who multiply for generations to come.
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/concept-2-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1029"/></td>
                <td>EYES TO SEE — Begin to see where God’s Kingdom isn’t. These are usually the places where God wants
                    to work the most.
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/duckling-e1505209401675.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1028"/></td>
                <td>DUCKLING DISCIPLESHIP — Learn what ducklings have to do with disciple-making.</td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/practice-1.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1035"/></td>
                <td>3-MINUTE TESTIMONY — Learn how to share your testimony in three minutes by sharing how Jesus has
                    impacted your life.
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/practice-2-3.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1186"/></td>
                <td>THE LORD'S SUPPER — It’s a simple way to celebrate our intimate connection and ongoing relationship
                    with Jesus. Learn a simple way to celebrate.
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>
        <table>
            <tr>
                <td><img src="/wp-content/uploads/practice-1.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1033"/></td>
                <td>SHARING YOUR TESTIMONY — Break into groups of two or three and practice sharing your Testimony with
                    others. (45 minutes)
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/practice-2-3.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1186"/></td>
                <td>THE LORD'S SUPPER — Take time as a group to do this together. (10 minutes)</td>
            </tr>
        </table>
		<?php
	}

	public static function get_overview_5() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full" src="/wp-content/uploads/5.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full" src="/wp-content/uploads/5.2.png" alt="" width="400"
                    height="225"/><img class="alignnone wp-image-945 size-full" src="/wp-content/uploads/5.3.png" alt=""
                                       width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/Concept-2-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1028"/></td>
                <td>PERSON OF PEACE — Learn who a person of peace might be and how to know when you've found one.</td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/tool-1-4.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1035"/></td>
                <td>PRAYER WALKING — It’s a simple way to obey God’s command to pray for others. And it's just what it
                    sounds like — praying to God while walking around!
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>
        <table>
            <tr>
                <td><img src="/wp-content/uploads/practice-1-1.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1033"/></td>
                <td>B.L.E.S.S. PRAYER — Practice a simple mnemonic to remind you of ways to pray for others. (15
                    minutes)
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/tool-1-4.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1033"/></td>
                <td>PRAYER WALKING — Break into groups of two or three and go out into the community to practice Prayer
                    Walking. (60-90 minutes)
                </td>
            </tr>
        </table>
		<?php
	}

	public static function get_overview_6() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full"
                                             src="/wp-content/uploads/6.1-1.png" alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full" src="/wp-content/uploads/6.2.png" alt="" width="400"
                    height="225"/><img class="alignnone wp-image-945 size-full" src="/wp-content/uploads/6.3.png" alt=""
                                       width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/concept-1-3.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1028"/></td>
                <td>FAITHFULNESS — It's important what disciples know — but it's much more important what they DO with
                    what they know.
                </td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/tool-1-5.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1035"/></td>
                <td>3/3 GROUP FORMAT — A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow,
                    fellowship and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not
                    just a small group but a Simple Church. (80 minutes)
                </td>
            </tr>
        </table>
		<?php
	}

	public static function get_overview_7() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full" src="/wp-content/uploads/7.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full" src="/wp-content/uploads/7.2-1.png" alt="" width="400"
                    height="225"/><img class="alignnone wp-image-945 size-full" src="/wp-content/uploads/7.3.png" alt=""
                                       width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/concept-1-6.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1570"/></td>
                <td>TRAINING CYCLE — Learn the training cycle and consider how it applies to disciple making.</td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/practice-1-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1033"/></td>
                <td>3/3 GROUP — Your entire group will spend 90 minutes practicing the 3/3 Group Format.</td>
            </tr>
        </table>
		<?php
	}

	public static function get_overview_8() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full" src="/wp-content/uploads/8.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full" src="/wp-content/uploads/8.2.png" alt="" width="400"
                    height="225"/><img class="alignnone wp-image-945 size-full" src="/wp-content/uploads/8.3.png" alt=""
                                       width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/concept-1-4.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1028"/></td>
                <td>LEADERSHIP CELLS — A Leadership Cell is a way someone who feels called to lead can develop their
                    leadership by practicing serving.
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/practice-1-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1033"/></td>
                <td>3/3 GROUP — Your entire group will spend 90 minutes practicing the 3/3 Group Format.</td>
            </tr>
        </table>
		<?php
	}

	public static function get_overview_9() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full" src="/wp-content/uploads/9.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full" src="/wp-content/uploads/9.2.png" alt="" width="400"
                    height="225"/><img class="alignnone wp-image-945 size-full" src="/wp-content/uploads/9.3.png" alt=""
                                       width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/concept-1-5.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1028"/></td>
                <td>NON-SEQUENTIAL — See how disciple making doesn't have to be linear. Multiple things can happen at
                    the same time.
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/concept-2-3.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1029"/></td>
                <td>PACE — Multiplying matters and multiplying quickly matters even more. See why pace matters.</td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/concept-3.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1030"/></td>
                <td>PART OF TWO CHURCHES — Learn how to obey Jesus' commands by going AND staying.</td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/practice-1-3.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1033"/></td>
                <td>3-MONTH PLAN — Create and share your plan for how you will implement the Zúme tools over the next
                    three months. (60 minutes)
                </td>
            </tr>
        </table>
		<?php
	}

	public static function get_overview_10() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full" src="/wp-content/uploads/10.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full" src="/wp-content/uploads/10.2.png" alt="" width="400"
                    height="225"/><img class="alignnone wp-image-945 size-full" src="/wp-content/uploads/10.3.png"
                                       alt="" width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/practic.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1028"/></td>
                <td>LEADERSHIP IN NETWORKS — Learn how multiplying churches stay connected and live life together as an
                    extended, spiritual family.
                </td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td><img src="/wp-content/uploads/tool-1-7.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1572"/></td>
                <td>PEER MENTORING GROUPS — This is a group that consists of people who are leading and starting 3/3
                    Groups. It also follows a 3/3 format and is a powerful way to assess the spiritual health of God’s
                    work in your area.
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>
        <table>
            <tr>
                <td><img src="/wp-content/uploads/practice-1-5.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1574"/></td>
                <td>COACHING CHECKLIST — The Coaching Checklist is a powerful tool you can use to quickly assess your
                    own strengths and vulnerabilities when it comes to making disciples who multiply. (10 minutes)
                </td>
            </tr>
            <tr>
                <td><img src="/wp-content/uploads/practice-2-2.png" alt="" width="40" height="40"
                         class="alignnone size-full wp-image-1033"/></td>
                <td>PEER MENTORING GROUPS — Break into groups of two or three and work through the Peer Mentoring Group
                    format. (60 minutes)
                </td>
            </tr>
        </table>
		<?php
	}



	/**
	 * Pulls the content from the pages database
	 * @return string
	 */
	public static function get_session_content( $session ) {

		switch ( $session ) {
			case '1':
				return 'Session Content';
				break;
			case '2':
				return 'Session Content';
				break;
			case '3':
				return 'Session Content';
				break;
			case '4':
				return 'Session Content';
				break;
			case '5':
				return 'Session Content';
				break;
			case '6':
				return 'Session Content';
				break;
			case '7':
				return 'Session Content';
				break;
			case '8':
				return 'Session Content';
				break;
			case '9':
				return 'Session Content';
				break;
			case '10':
				return 'Session Content';
				break;
			default:
				break;
		}

	}

    public static function next_session_block () {
        ?>
        <div class="callout">
            <p class="center padding-bottom">Go to the Dashboard to select your Group and start the next session</p>
            <p class="center"><a href="/dashboard/" class="button large">Dashboard</a></p>
        </div>
        <?php
    }
}
