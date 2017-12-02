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
                <?php print self::get_session_content(1) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 2</h3>
                <?php print self::get_session_content(2) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 3</h3>
                <?php print self::get_session_content(3) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 4</h3>
                <?php print self::get_session_content(4) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 5</h3>
                <?php print self::get_session_content(5) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 6</h3>
                <?php print self::get_session_content(6) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 7</h3>
                <?php print self::get_session_content(7) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 8</h3>
                <?php print self::get_session_content(8) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 9</h3>
                <?php print self::get_session_content(9) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 10 - Advanced Training</h3>
                <?php print self::get_session_content(10) ?>
            </section>

        </div>

        <?php if(is_user_logged_in()) { self::next_session_block(); } ?>

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
