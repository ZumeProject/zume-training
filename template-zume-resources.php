<?php
/*
Template Name: Zume Resources
*/
?>

<?php get_header(); ?>

<div id="content">

    <div id="inner-content" class="grid-x">

        <div id="main" class="large-12 medium-12 cell" role="main">

            <div class="grid-x grid-margin-x vertical-padding">
                <div class="medium-2 cell"></div>
                <div class="medium-8 cell">
                    <div class="responsive-embed widescreen"><!-- TODO: Add multilanguage video switcher-->
                        <img src="http://via.placeholder.com/1920x1080"/>
                    </div>
                </div>
                <div class="medium-2 cell"></div>
            </div>

            <div class="grid-x grid-margin-x vertical-padding" style="background-color:#323A68; color:white;">
                <div class="medium-2 cell"></div>
                <div class="medium-8 cell vertical-padding">
                    <h3 style="color: white"><?php echo __( 'The Zúme Mission:', 'zume' ) ?></h3>
					<?php echo __( 'Helping ordinary people make a big impact for the Kingdom of God by obeying and implementing the
                    Great Commission and the Great Commandment.', 'zume' ) ?>
                    <h3 style="color: white"><?php echo __( 'The Zúme Vision:', 'zume' ) ?></h3>
					<?php echo __( 'Make disciples in every census tract in the United States and then in every Omega District globally,
                    using an online training platform focused on equipping participants in the basic disciple-making and
                    simple church planting multiplication principles, processes, and practices.', 'zume' ) ?>
                </div>
                <div class="medium-2 cell"></div>
            </div>

            <div class="grid-x grid-margin-x vertical-padding">
                <div class="medium-2 cell"></div>
                <div class="medium-8 cell">
                    <h3>Resources:</h3>
                    <ul style="list-style-type: none;margin: 0">
                        <li>
                            <a href="<?php echo home_url() ?>/wp-content/themes/zume-project-multilingual/assets/files/en/zume-guide.pdf"
                               target="_blank" rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="/wp-content/themes/zume-project-multilingual/assets/images/pages/pdf-download.png"
                                            alt="PDF download" width="30" height="30"
                                            class="alignnone size-full wp-image-907"/></span>
								<?php echo __( 'Download Guidebook here.', 'zume' ) ?>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo home_url() ?>/wp-content/themes/zume-project-multilingual/assets/files/en/zume-promo-flier.pdf"
                               target="_blank" rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="/wp-content/themes/zume-project-multilingual/assets/images/pages/pdf-download.png"
                                            alt="PDF download" width="30" height="30"
                                            class="alignnone size-full wp-image-907"/></span>
								<?php echo __( 'Download and print the Zúme promo flyer.', 'zume' ) ?>
                            </a>
                        </li>

                        <li><a href="https://www.youtube.com/watch?v=qIs-PiCowlw&amp;t=1s" target="_blank"
                               rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="/wp-content/themes/zume-project-multilingual/assets/images/pages/video-camera.png"
                                            alt="Video" width="30" height="30"
                                            class="alignnone size-full wp-image-908"/></span>
								<?php echo __( 'Share the Zúme Promo video here.', 'zume' ) ?>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo home_url() ?>/wp-content/themes/zume-project-multilingual/assets/files/en/mission_frontiers_39-3_Issue_5-6.pdf"
                               target="_blank" rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="/wp-content/themes/zume-project-multilingual/assets/images/pages/pdf-download.png"
                                            alt="PDF download" width="30" height="30"
                                            class="alignnone size-full wp-image-907"/></span>
								<?php echo __( 'Download May/June 2017 issue of Mission Frontiers on Zúme here.', 'zume' ) ?>
                            </a>
                        </li>

                        <li>
                            <a href="https://docs.google.com/spreadsheets/d/12NUKhKfJl4ZnqegEdkHadlYMf2oHuEKIjNmyZI78TeA/edit?usp=sharing"
                               target="_blank" rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="/wp-content/themes/zume-project-multilingual/assets/images/pages/pdf-download.png"
                                            alt="" width="30" height="30"
                                            class="alignnone size-full wp-image-906"/></span>
								<?php echo __( 'Check on language translation progress here.', 'zume' ) ?>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo home_url() ?>/wp-content/themes/zume-project-multilingual/assets/files/en/zume-faq.pdf"
                               target="_blank" rel="noopener noreferrer">
                                <span style="padding:0 10px"><img
                                            src="/wp-content/themes/zume-project-multilingual/assets/images/pages/pdf-download.png"
                                            alt="PDF download" width="30" height="30"
                                            class="alignnone size-full wp-image-907"/></span>
								<?php echo __( 'Frequently Asked Questions (FAQ).', 'zume' ) ?>
                            </a>
                        </li>

                    </ul>

					<?php
					/**
					 * Optional content for the resources section specific to the language. This content can be added
					 * in the content area of the resource post for the language
					 */
					global $post;
					if ( ! empty( $post ) && ! empty( $post->post_content ) ) {
						echo '<hr>';
						echo $post->post_content;
					}
					?>

                </div>

                <div class="medium-2 cell"></div>

            </div>

        </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
