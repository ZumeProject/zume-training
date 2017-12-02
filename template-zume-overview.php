<?php
/*
Template Name: Zúme Overview
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


                $session = 1; // TODO get session from url and create session number for pre-selection

                Zume_Overview::load_sessions( $session );

                ?>

            </div> <!-- end #main -->

        </div> <!-- end #inner-content -->

    </div> <!-- end #content -->

<?php get_footer(); ?>
