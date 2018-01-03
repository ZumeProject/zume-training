<?php
/*
Template Name: Zume Resources
*/
?>

<?php get_header(); ?>

<style>
    .resource-list {
        list-style-type: none;
    }
    .resource-list li {
        padding: .2em 0;
    }
    .resource-list li a {
        color:white;
        line-height: 1.5em;
    }
</style>

<div id="content">

    <div id="inner-content" class="grid-x">

        <div id="main" class="large-12 medium-12 cell" role="main">

            <div class="grid-x grid-margin-x verticle-padding">
                <div class="cell center">
                    <h2><?php esc_html_e( 'RESOURCES', 'zume' ) ?></h2>
                    <br>
                </div>
            </div>

            <div class="grid-x grid-margin-x vertical-padding" style="background-color:#323A68; color:white;">
                <div class="medium-2 cell"></div>
                <div class="medium-4 cell vertical-padding">
                    <h3 class="white"><?php esc_html_e( 'Promotional Materials', 'zume' ) ?></h3>
                    <ul class="resource-list">
                        <li>
                            <a href="<?php echo esc_url( zume_files_uri() ) ?>zume_guidebook.pdf"
                               target="_blank" rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>pdf-download.png"
                                            alt="PDF download" width="30" height="30"
                                            class="alignnone size-full wp-image-907"/></span>
                                <?php esc_html_e( 'Download Guidebook', 'zume' ) ?>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo esc_url( zume_files_uri() ) ?>flyer.pdf"
                               target="_blank" rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>pdf-download.png"
                                            alt="PDF download" width="30" height="30"
                                            class="alignnone size-full wp-image-907"/></span>
                                <?php esc_html_e( 'Download Zúme Promo Flyer', 'zume' ) ?>
                            </a>
                        </li>

                        <li><a href="<?php echo esc_url( Zume_Course::get_video_by_key( 'promo', false ) ) ?>" target="_blank"
                               rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>video-camera.png"
                                            alt="Video" width="30" height="30"
                                            class="alignnone size-full wp-image-908"/></span>
                                <?php esc_html_e( 'Download Zume Promo Video', 'zume' ) ?>
                            </a>
                        </li>
                        <li><a href="<?php echo esc_url( Zume_Course::get_video_by_key( 'overview', false ) ) ?>" target="_blank"
                               rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>video-camera.png"
                                            alt="Video" width="30" height="30"
                                            class="alignnone size-full wp-image-908"/></span>
                                <?php esc_html_e( 'Download Zume Overview Video', 'zume' ) ?>
                            </a>
                        </li>


                    </ul>
                </div>
                <div class="medium-4 cell vertical-padding">
                    <h3 class="white"><?php esc_html_e( 'Project Information', 'zume' ) ?></h3>
                    <ul class="resource-list">
                        <li>
                            <a href="<?php echo esc_url( zume_files_uri() ) ?>faq.pdf"
                               target="_blank" rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="<?php echo esc_url( zume_images_uri( 'pages' ) ) ?>pdf-download.png"
                                            alt="PDF download" width="30" height="30"
                                            class="alignnone size-full wp-image-907"/></span>
                                <?php esc_html_e( 'Frequently Asked Questions (FAQ).', 'zume' ) ?>
                            </a>
                        </li>
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
                <div class="medium-2 cell"></div>
            </div>

            <?php
            /**
             * Additional resources section
             */
            global $post;
            if ( ! empty( $post ) && ! empty( $post->post_content ) ) {
            ?>
                <div class="grid-x grid-margin-x vertical-padding">
                    <div class="medium-2 cell"></div>
                    <div class="medium-8 cell">
                        <h3><?php esc_html_e( "Additional Resources:", 'zume' ) ?></h3>
                        <?php
                        /**
                         * Optional content for the resources section specific to the language. This content can be added
                         * in the content area of the resource post for the language
                         */

                        echo '<hr>';
                        // @codingStandardsIgnoreStart
                        echo $post->post_content;
                        // @codingStandardsIgnoreEnd

                        ?>
                    </div>
                    <div class="medium-2 cell"></div>
                </div>
            <?php  } ?>

        </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
