<?php

/**
 * Zume Overview
 *
 * @class Disciple_Tools_Admin_Menus
 * @version 0.1
 * @since 0.1
 * @package Disciple_Tools
 * @author Chasm.Solutions & Kingdom.Training
 */

if ( ! defined( 'ABSPATH' ) ) { exit; // Exit if accessed directly
}

class Zume_Overview {


    /**
     * Zume Overview: Primary content section
     * @return mixed
     */
    public static function load_sessions( $session = 1, $language = 'en') {
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
                <?php self::get_page_content( '1', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 2</h3>
                <?php self::get_page_content( '2', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 3</h3>
                <?php self::get_page_content( '3', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 4</h3>
                <?php self::get_page_content( '4', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 5</h3>
                <?php self::get_page_content( '5', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 6</h3>
                <?php self::get_page_content( '6', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 7</h3>
                <?php self::get_page_content( '7', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 8</h3>
                <?php self::get_page_content( '8', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 9</h3>
                <?php self::get_page_content( '9', $language ) ?>
            </section>

            <h3></h3>
            <section>
                <h3 style="text-align: center; font-weight: bold">Session 10 - Advanced Training</h3>
                <?php self::get_page_content( '10', $language ) ?>
            </section>

        </div>

        <?php if (is_user_logged_in()) { self::next_session_block(); } ?>

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
        $page_object = get_page_by_title( $session_title, OBJECT, 'page' );

        if ( $language != 'en' ) {
            $translation_id = zume_get_translation( $page_object->ID, $language );
            $page_object = get_post( $translation_id, OBJECT );
        }

        if ( ! empty( $page_object ) || ! empty( $page_object->post_content )) {
            $page_content = (string) $page_object->post_content;
			// @codingStandardsIgnoreLine
			echo "<div class=\"overview\">$page_content</div>";
        }
        else {
            print 'Please republish "' . esc_html( $session_title ) . '" with content for this section in the pages administration area.';
        }
    }
}
