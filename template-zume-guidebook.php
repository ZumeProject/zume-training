<?php
/*
Template Name: Zume Guidebook
*/
?>

<?php get_header(); ?>

<div id="content" class="grid-x grid-padding-x"><div class="cell">

    <div id="inner-content">

        <div class="grid-x grid-margin-y">
            <div class="large-2 cell"></div>

            <div class="large-8 small-12 cell">

                <div class="grid-x grid-margin-y">
                    <div class="cell center">
                        <br>
                        <h2><?php esc_html_e( 'Zúme Guidebook', 'zume' ) ?></h2>
                    </div>
                </div>

                <div class="grid-x row vertical-padding">
                    <div class="cell large-3"></div>
                    <div class="large-6 cell">
                        <p style="font-size: 150%; margin: 20px 0 40px 0; text-align: center;"><?php esc_html_e( 'Our goal is kingdom growth, so we have made the entire training guidebook free for download. Use the link below.', 'zume' ) ?></p>
                    </div>
                    <div class="cell large-3"></div>
                </div>

                <div class="grid-x grid-margin-y">
                    <div class="cell center">
                        <a href="<?php echo esc_url( zume_files_uri() ) ?>zume_guidebook.pdf" class="button large" target="_blank"><i class="fi-page-export-pdf large"></i> <?php esc_html_e( 'Complete Zume Guidebook', 'zume' ) ?></a>
                    </div>
                </div>
                <br><br>
            </div>
            <div class="large-2 cell"></div>
        </div>



    </div> <!-- end #inner-content -->

    </div> <!--cell -->
</div> <!-- content-->

<?php get_footer(); ?>
