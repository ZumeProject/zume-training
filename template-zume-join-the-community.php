<?php
/*
Template Name: Zume Join The Community
*/
?>

<?php get_header(); ?>


<div id="content">

    <div id="inner-content">

        <div id="main" role="main">

            <div class="max-content-width grid-x grid-margin-x">
                <div class="cell center">
                    <h1 class="primary-color-text"><?php esc_html_e( 'Join the Zume Community', 'zume' ) ?></h1>
                    <p class="primary-color-text"><?php esc_html_e( 'Zúme is a community of practice for those who want to see disciple making movements.', 'zume' ) ?></p>
                </div>

                <div class="cell">
                    <?php
                    /**
                     * Additional Resources section
                     */
                    if (have_posts()) :
                        while (have_posts()) :
                            the_post();
                            the_content();
                        endwhile;
                    endif;
                    ?>
                </div>
            </div>

        </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

</div><!-- end #content -->

<?php get_footer(); ?>
