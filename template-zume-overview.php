<?php
/*
Template Name: Zúme Overview
*/

/**
 * Begin page template for Zume Overview
 */
get_header();

?>

    <div id="content">

        <div id="inner-content" class="row">

            <div id="main" class="large-12 medium-12 columns" role="main">

				<?php
				/**
				 * Zúme Overview Content Loader
				 *
				 * @param 'id' in the url the id and session number is used to call the correct session.
				 */

				$zume_session  = 1;
				$zume_language = zume_current_language();
				if ( is_wp_error( $zume_language ) ) {
					$zume_language = 'en';
				}

				Zume_Overview_Content::load_sessions( $zume_session, $zume_language );

				?>

            </div> <!-- end #main -->

        </div> <!-- end #inner-content -->

    </div> <!-- end #content -->

<?php

get_footer();

/**
 * End Page Template
 */

?>


<?php

/**
 * HTML Content for the Zume Overview
 */
class Zume_Overview_Content {

	/**
	 * Zume Overview: Primary content section
	 * @return mixed
	 */
	public static function load_sessions() {
		?>
        <h2 class="center padding-bottom">Sessions Overview</h2>

        <script>
            jQuery(document).ready(function ($) {
                "use strict";
                var startIndex = 0;
                if (!isNaN(parseInt(window.location.hash.substr(2)))) {
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
                    onStepChanged: function (event, currentIndex, priorIndex) {
                        var newHash = "#s" + (currentIndex + 1);
						<?php /* Replaces window.location.hash without creating
                        a history entry, and without scrolling or jumping, and
                        without triggering hashchange */ ?>
                        history.replaceState(null, null, newHash);
                    },
                    titleTemplate: '<span class="number">#index#</span> #title#'
                });
                window.addEventListener("hashchange", function (event) {
					<?php /* This can get triggered when Overview menu items
                    get clicked */ ?>
                    var hash = event.newURL.substr(event.newURL.indexOf("#"));
                    if (!isNaN(parseInt(hash.substr(2)))) {
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
				<?php self::session_overview_1(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 2</h3>
				<?php self::session_overview_2(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 3</h3>
				<?php self::session_overview_3(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 4</h3>
				<?php self::session_overview_4(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 5</h3>
				<?php self::session_overview_5(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 6</h3>
				<?php self::session_overview_6(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 7</h3>
				<?php self::session_overview_7(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 8</h3>
				<?php self::session_overview_8(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 9</h3>
				<?php self::session_overview_9(); ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 10 - Advanced Training</h3>
				<?php self::session_overview_10(); ?>
            </section>

        </div>

		<?php if ( is_user_logged_in() ) {
			self::next_session_block();
		} ?>

		<?php
	}

	public static function next_session_block() {
		?>
        <div class="callout">
            <p class="center padding-bottom">Go to the Dashboard to select your Group and start the next session</p>
            <p class="center"><a href="/dashboard/" class="button large">Dashboard</a></p>
        </div>
		<?php
	}

	/**
	 * Pulls the content from the pages database
	 */
	public static function get_page_content( $session, $language = 'en' ) {

		$session_title = 'Session ' . $session . ' Overview';
		$page_object   = get_page_by_title( $session_title, OBJECT, 'page' );

		if ( $language != 'en' ) {
			$translation_id = zume_get_translation( $page_object->ID, $language );
			$page_object    = get_post( $translation_id, OBJECT );
		}

		if ( ! empty( $page_object ) || ! empty( $page_object->post_content ) ) {
			$page_content = (string) $page_object->post_content;
			// @codingStandardsIgnoreLine
			echo "<div class=\"overview\">$page_content</div>";

		} else {
			print 'Please republish "' . esc_html( $session_title ) . '" with content for this section in the pages administration area.';
		}
	}

	public static function session_overview_1() {
		?>
        <div class="grid-x grid-margin-x">
            <div class="large-2 cell"></div>
            <div class="large-8 cell">

                <!-- Image Bar -->
                <div class="grid-x">
                    <div class="small-4 cell">
                        <img class="alignnone wp-image-943 size-full"
                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>1.1.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <img class="alignnone wp-image-944 size-full"
                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>1.2.png"
                             alt="" width="400" height="225"/>
                    </div>
                    <div class="small-4 cell">
                        <img class="alignnone wp-image-945 size-full"
                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>1.3.png"
                             alt="" width="400" height="225"/>
                    </div>
                </div>

                <hr>

                <!-- Concepts -->
                <div class="grid-x">
                    <div class="cell">
                        <h3><?php esc_html_e( 'Concepts:', 'zume' ) ?></h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x">
                            <div class="large-1 cell">
                                <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-1-4.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1564"/>
                            </div>
                            <div class="large-11 cell">
					            <?php esc_html_e( 'WELCOME TO ZÚME — You\'ll see how God uses ordinary people doing simple things to make a big impact.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x">
                            <div class="large-1 cell">
                                <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-2-2.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1565"/>
                            </div>
                            <div class="large-11 cell">
					            <?php esc_html_e( 'TEACH THEM TO OBEY — Discover the essence of being a disciple, making a disciple, and what is the church.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x">
                            <div class="large-1 cell">
                                <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-3-2.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1566"/>
                            </div>
                            <div class="large-11 cell">
					            <?php esc_html_e( 'SPIRITUAL BREATHING — Being a disciple means we hear from God and we obey God.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Tools -->
                <div class="grid-x">
                    <div class="cell">
                        <h3>Tools:</h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x">
                            <div class="large-1 cell">
                                <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>tool-1-2.png"
                                     alt=""
                                     width="40" height="40" class="alignnone size-full wp-image-1035"/>
                            </div>
                            <div class="large-11 cell">
					            <?php esc_html_e( 'S.O.A.P.S. BIBLE READING — a tool for daily Bible study that helps you understand, obey, and share God’s Word.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x grid-margin-y">
                            <div class="large-1 cell">
                                <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>tool-2.png"
                                     alt=""
                                     width="40" height="40" class="alignnone size-full wp-image-1567"/>
                            </div>
                            <div class="large-11 cell">
					            <?php esc_html_e( 'ACCOUNTABILITY GROUPS — a tool for two or three people of the same gender to meet weekly and encourage each other in areas that are going well and reveal areas that need correction.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <div class="grid-x">
                            <div class="large-1 cell">
                                <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-3-2.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1566"/>
                            </div>
                            <div class="large-11 cell">
					            <?php esc_html_e( 'SPIRITUAL BREATHING — Being a disciple means we hear from God and we obey God.', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <!-- Practice -->
                <div class="grid-x">
                    <div class="cell">
                        <h3>Practice:</h3>
                    </div>
                    <div class="cell">
                        <div class="grid-x">
                            <div class="large-1 cell">
                                <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-1-5.png"
                                     alt="" width="40" height="40" class="alignnone size-full wp-image-1568"/>
                            </div>
                            <div class="large-11 cell">
					            <?php esc_html_e( 'ACCOUNTABILITY GROUPS — Break into groups of two or three people to work through the Accountability Questions. (45 minutes)', 'zume' ) ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="large-2 cell"></div>
        </div>

		<?php
	}

	public static function session_overview_2() {
		?>
        <div class="overview-image-bar"><img
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>2.1.png"
                    alt="" class="alignnone size-full wp-image-948"/><img
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>2.2.png"
                    alt="" class="alignnone size-full wp-image-949"/><img
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>2.3-1.png"
                    alt="List 100 people you know, 3 categories: those who follow Jesus, those who don&#039;t follow Jesus, those they&#039;re not sure about"
                    width="400" height="225" class="alignnone size-full wp-image-1066"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>Concept-1-5.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1576"/></td>
                <td>PRODUCERS VS. CONSUMERS — You'll discover the four main ways God makes everyday followers more like
                    Jesus.
                </td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>Practice-1-6.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1577"/></td>
                <td>PRAYER CYCLE — See how easy it is to spend an hour in prayer.</td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>Practice-2-2.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1578"/></td>
                <td>LIST OF 100 — a tool designed to help you be a good steward of your relationships</td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>Tool-1-4.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1579"/></td>
                <td>PRAYER CYCLE — Spend 60 minutes in prayer individually.</td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>Tool-2-3.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1580"/></td>
                <td>LIST OF 100 — Create your own list of 100. (30 minutes)</td>
            </tr>
        </table>


		<?php
	}

	public static function session_overview_3() {
		?>
        <div class="overview-image-bar"><img
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>3.1-1.png"
                    alt="Whoever can be trusted with very little can also be trusted with much. - Jesus. Breathe in, hear, breathe out, obey and share. Giving God&#039;s blessings"
                    width="400" height="225" class="alignnone size-full wp-image-1068"/><img
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>3.2.png"
                    alt="Obey, do, practise, share, teach, pass on" width="400" height="225"
                    class="alignnone size-full wp-image-955"/><img
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>3.3.png"
                    alt="" width="400" height="225" class="alignnone size-full wp-image-957"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-1-1.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1023"/></td>
                <td>SPIRITUAL ECONOMY — Learn how God's economy is different from the world's. God invests more in those
                    who are faithful with what they've already been given.
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-2-1.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1024"/></td>
                <td>CREATION TO JUDGMENT — Learn a way to share God’s Good News from the beginning of humanity all the
                    way to the end of this age.
                </td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>tool-1-1-1.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1183"/></td>
                <td>BAPTISM — Jesus said, “Go and make disciples of all nations, BAPTIZING them in the name of the
                    Father and of the Son and of the Holy Spirit…” Learn how to put this into practice.
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>tool-2-1.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1026"/></td>
                <td>SHARE GOD’S STORY — Break into groups of two or three and practice sharing God’s Story. (45
                    minutes)
                </td>
            </tr>
        </table>

		<?php
	}

	public static function session_overview_4() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full"
                                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>4.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full"
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>4.2.png"
                    alt="" width="400" height="225"/><img class="alignnone wp-image-945 size-full"
                                                          src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>4.3.png"
                                                          alt="" width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-1-2.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/></td>
                <td>GREATEST BLESSING — Learn a simple pattern of making not just one follower of Jesus but entire
                    spiritual families who multiply for generations to come.
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-2-2.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1029"/></td>
                <td>EYES TO SEE — Begin to see where God’s Kingdom isn’t. These are usually the places where God wants
                    to work the most.
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>duckling-e1505209401675.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/></td>
                <td>DUCKLING DISCIPLESHIP — Learn what ducklings have to do with disciple-making.</td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-1.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1035"/></td>
                <td>3-MINUTE TESTIMONY — Learn how to share your testimony in three minutes by sharing how Jesus has
                    impacted your life.
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-2-3.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1186"/></td>
                <td>THE LORD'S SUPPER — It’s a simple way to celebrate our intimate connection and ongoing relationship
                    with Jesus. Learn a simple way to celebrate.
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>
        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-1.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/></td>
                <td>SHARING YOUR TESTIMONY — Break into groups of two or three and practice sharing your Testimony with
                    others. (45 minutes)
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-2-3.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1186"/></td>
                <td>THE LORD'S SUPPER — Take time as a group to do this together. (10 minutes)</td>
            </tr>
        </table>
		<?php
	}

	public static function session_overview_5() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full"
                                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>5.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full"
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>5.2.png"
                    alt="" width="400" height="225"/><img class="alignnone wp-image-945 size-full"
                                                          src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>5.3.png"
                                                          alt="" width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>Concept-2-2.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/></td>
                <td>PERSON OF PEACE — Learn who a person of peace might be and how to know when you've found one.</td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>tool-1-4.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1035"/></td>
                <td>PRAYER WALKING — It’s a simple way to obey God’s command to pray for others. And it's just what it
                    sounds like — praying to God while walking around!
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>
        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-1-1.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/></td>
                <td>B.L.E.S.S. PRAYER — Practice a simple mnemonic to remind you of ways to pray for others. (15
                    minutes)
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>tool-1-4.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/></td>
                <td>PRAYER WALKING — Break into groups of two or three and go out into the community to practice Prayer
                    Walking. (60-90 minutes)
                </td>
            </tr>
        </table>
		<?php
	}

	public static function session_overview_6() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full"
                                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>6.1-1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full"
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>6.2.png"
                    alt="" width="400" height="225"/><img class="alignnone wp-image-945 size-full"
                                                          src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>6.3.png"
                                                          alt="" width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-1-3.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/></td>
                <td>FAITHFULNESS — It's important what disciples know — but it's much more important what they DO with
                    what they know.
                </td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>tool-1-5.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1035"/></td>
                <td>3/3 GROUP FORMAT — A 3/3 Group is a way for followers of Jesus to meet, pray, learn, grow,
                    fellowship and practice obeying and sharing what they've learned. In this way, a 3/3 Group is not
                    just a small group but a Simple Church. (80 minutes)
                </td>
            </tr>
        </table>
		<?php
	}

	public static function session_overview_7() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full"
                                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>7.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full"
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>7.2-1.png"
                    alt="" width="400" height="225"/><img class="alignnone wp-image-945 size-full"
                                                          src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>7.3.png"
                                                          alt="" width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-1-6.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1570"/></td>
                <td>TRAINING CYCLE — Learn the training cycle and consider how it applies to disciple making.</td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-1-2.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/></td>
                <td>3/3 GROUP — Your entire group will spend 90 minutes practicing the 3/3 Group Format.</td>
            </tr>
        </table>
		<?php
	}

	public static function session_overview_8() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full"
                                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>8.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full"
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>8.2.png"
                    alt="" width="400" height="225"/><img class="alignnone wp-image-945 size-full"
                                                          src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>8.3.png"
                                                          alt="" width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-1-4.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/></td>
                <td>LEADERSHIP CELLS — A Leadership Cell is a way someone who feels called to lead can develop their
                    leadership by practicing serving.
                </td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-1-2.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/></td>
                <td>3/3 GROUP — Your entire group will spend 90 minutes practicing the 3/3 Group Format.</td>
            </tr>
        </table>
		<?php
	}

	public static function session_overview_9() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full"
                                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>9.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full"
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>9.2.png"
                    alt="" width="400" height="225"/><img class="alignnone wp-image-945 size-full"
                                                          src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>9.3.png"
                                                          alt="" width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-1-5.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/></td>
                <td>NON-SEQUENTIAL — See how disciple making doesn't have to be linear. Multiple things can happen at
                    the same time.
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-2-3.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1029"/></td>
                <td>PACE — Multiplying matters and multiplying quickly matters even more. See why pace matters.</td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>concept-3.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1030"/></td>
                <td>PART OF TWO CHURCHES — Learn how to obey Jesus' commands by going AND staying.</td>
            </tr>
        </table>

        <br>

        <h3>Practice:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-1-3.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/></td>
                <td>3-MONTH PLAN — Create and share your plan for how you will implement the Zúme tools over the next
                    three months. (60 minutes)
                </td>
            </tr>
        </table>
		<?php
	}

	public static function session_overview_10() {
		?>
        <div class="overview-image-bar"><img class="alignnone wp-image-943 size-full"
                                             src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>10.1.png"
                                             alt="" width="400" height="225"/><img
                    class="alignnone wp-image-944 size-full"
                    src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>10.2.png"
                    alt="" width="400" height="225"/><img class="alignnone wp-image-945 size-full"
                                                          src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>10.3.png"
                                                          alt="" width="400" height="225"/></div>

        <br>

        <h3>Concepts:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practic.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1028"/></td>
                <td>LEADERSHIP IN NETWORKS — Learn how multiplying churches stay connected and live life together as an
                    extended, spiritual family.
                </td>
            </tr>
        </table>

        <br>

        <h3>Tools:</h3>

        <table>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>tool-1-7.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1572"/></td>
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
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-1-5.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1574"/></td>
                <td>COACHING CHECKLIST — The Coaching Checklist is a powerful tool you can use to quickly assess your
                    own strengths and vulnerabilities when it comes to making disciples who multiply. (10 minutes)
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo home_url( '/wp-content/themes/zume-project-multilingual/assets/images/overview/' ); ?>practice-2-2.png"
                         alt="" width="40" height="40" class="alignnone size-full wp-image-1033"/></td>
                <td>PEER MENTORING GROUPS — Break into groups of two or three and work through the Peer Mentoring Group
                    format. (60 minutes)
                </td>
            </tr>
        </table>
		<?php
	}

}
