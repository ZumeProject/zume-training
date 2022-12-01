<?php
/*
Template Name: Zume Resources
*/
?>

<?php get_header(); ?>


<div id="content">

    <div id="inner-content">

        <div id="main" role="main">

            <?php if ( ! get_post_meta( get_the_ID(), 'zume_resource_hide_section', true ) ) : // Show/Hide default top section of resources ?>

                <div class="grid-x grid-margin-x">
                    <div class="cell center">
                        <h1 class="primary-color-text"><?php esc_html_e( 'RESOURCES', 'zume' ) ?></h1>
                    </div>
                </div>


                <div style="background-color:#323A68; color:white;">
                    <div class="grid-x grid-margin-x vertical-padding max-content-width">
                        <div class="medium-6 cell vertical-padding">
                            <h3 class="white"><?php esc_html_e( 'Promotional Materials', 'zume' ) ?></h3>
                            <ul class="main-resource-list">
                                <li>
                                    <a href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                                       target="_blank" rel="noopener noreferrer">
                                        <span style="padding:0 10px"><img
                                                    src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>pdf-download.png"
                                                    alt="PDF download" width="30" height="30"
                                                    class="alignnone size-full wp-image-907"/></span>
                                        <?php esc_html_e( 'Download Guidebook', 'zume' ) ?>
                                    </a>
                                </li>

                                <li><a href="<?php echo esc_url( Zume_Course::get_download_by_key( 'video_overview' ) ) ?>" target="_blank" >
                                        <span style="padding:0 10px"><img
                                                    src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>video-camera.png"
                                                    alt="Video" width="30" height="30"
                                                    class="alignnone size-full wp-image-908"/></span>
                                        <?php esc_html_e( 'Download Zume Overview Video', 'zume' ) ?>
                                    </a>
                                </li>


                            </ul>
                        </div>
                        <div class="medium-6 cell vertical-padding">
                            <h3 class="white"><?php esc_html_e( 'Project Information', 'zume' ) ?></h3>
                            <ul class="main-resource-list">
                                <li>
                                    <a href="https://docs.google.com/spreadsheets/d/12NUKhKfJl4ZnqegEdkHadlYMf2oHuEKIjNmyZI78TeA/edit?usp=sharing"
                                       target="_blank" rel="noopener noreferrer">
                                            <span style="padding:0 10px"><img
                                                        src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>pdf-download.png"
                                                        alt="" width="30" height="30"
                                                        class="alignnone size-full wp-image-906"/></span>
                                        <?php esc_html_e( 'Language Translation Progress', 'zume' ) ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

            <div class="max-content-width grid-x grid-margin-x">
                <div class="cell center">
                    <h1 class="primary-color-text"><?php esc_html_e( 'Zúme Training Resources', 'zume' ) ?></h1>
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
