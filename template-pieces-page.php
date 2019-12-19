<?php
/*
Template Name: Pieces Page
*/
get_header();


if (have_posts()) :
    while (have_posts()) : the_post();
        $post_id = get_the_ID();
        $meta = get_post_meta( $post_id );
        $tool_number = $meta['zume_piece'][0] ?? 0;
        $pre_video_content = $meta['zume_pre_video_content'][0] ?? '';
        $post_video_content = $meta['zume_post_video_content'][0] ?? '';
        $ask_content = $meta['zume_ask_content'][0] ?? '';
        $h1_title = empty( $meta['zume_piece_h1'][0] ) ? get_the_title( $post_id ) : $meta['zume_piece_h1'][0];

        $args = Zume_V4_Pieces::vars( $tool_number );
        if ( empty( $args ) ) {
            return;
        }
        $session_number = $args['session_number'];
        $alt_video = $args['alt_video'];
        $image_url = $args['image_url'];
        $audio = $args['audio']

        ?>

        <!-- Wrappers -->
        <div id="content" class="grid-x grid-padding-x training"><div  id="inner-content" class="cell">

        <!------------------------------------------------------------------------------------------------>
        <!-- Title section -->
        <!------------------------------------------------------------------------------------------------>
        <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
            <div class="medium-2 small-1 cell"></div><!-- Side spacer -->

            <!-- Center column -->
            <div class="medium-8 small-10 cell center">

                <img src="<?php echo esc_url( $image_url ) ?>" alt="<?php echo esc_html( $h1_title ) ?>" />

                <h1><?php echo esc_html( $h1_title ) ?></h1>
                <span class="sub-caption">
                    <a onclick="open_session(<?php echo esc_attr( $session_number ); ?>)">
                        <?php echo sprintf( esc_html__( 'This concept is called "%s" in session %s of the Zúme Training', 'zume' ),  get_the_title( $post_id ), $session_number ) ?>
                    </a>
                </span>
            </div>

            <div class="medium-2 small-1 cell"></div><!-- Side spacer -->
        </div>


        <!------------------------------------------------------------------------------------------------>
        <!-- Unique page content section -->
        <!------------------------------------------------------------------------------------------------>
        <div class="grid-x ">
            <div class="large-2 cell"></div><!-- Side spacer -->

            <!-- Center column -->
            <div class="large-8 small-12 cell" id="training-content">

                <section><!-- Step Title -->

                    <!-- pre-video block -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="cell content-large">
                            <?php echo wp_kses_post( wpautop( $pre_video_content ) ) ?>
                        </div>
                    </div>

                    <!-- video block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="cell content-large center">

                            <?php if ( $audio ) :  ?>
                                <h3><?php esc_html_e("Listen and Read Along", 'zume' ) ?></h3>
                                <a class="button large text-uppercase"
                                   href="<?php echo esc_url( Zume_Course::get_download_by_key( '33' ) ) ?>"
                                   target="_blank" rel="noopener noreferrer nofollow">
                                    <?php esc_html_e( 'Download Free Guidebook', 'zume' ) ?>
                                </a>
                            <?php else: ?>
                                <h3 class="center"><?php esc_html_e( 'Watch This Video', 'zume' ) ?></h3>
                            <?php endif; ?>

                        </div>
                        <div class="small-12 small-centered cell video-section">

                            <?php if ( $alt_video ) : ?>
                                <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                    <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_'.$tool_number ) ) ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php else : ?>
                                <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( $tool_number ) ) ?>" width="560" height="315"
                                        frameborder="1" webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                </iframe>
                            <?php endif; ?>

                        </div>
                    </div>


                    <!-- post-video block -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="cell content-large">
                            <?php echo wp_kses_post( wpautop( $post_video_content ) ) ?>
                        </div>
                    </div>


                    <!-- question block -->
                    <!-- Activity Block -->
                    <div class="grid-x grid-margin-x">
                        <div class="cell content-large center">
                            <h3 class="center"><?php esc_html_e( 'Ask Yourself', 'zume' ) ?></h3>
                        </div>
                        <div class="cell content-large">
                            <?php echo wp_kses_post( wpautop( $ask_content ) ) ?>
                        </div>
                    </div>
                    <!-- grid-x -->

                </section>

            </div>

            <div class="large-2 cell"></div><!-- Side spacer -->
        </div> <!-- grid-x -->


        <!------------------------------------------------------------------------------------------------>
        <!-- Share section -->
        <!------------------------------------------------------------------------------------------------>
        <div class="grid-x ">
            <div class="large-2 cell"></div><!-- Side spacer -->

            <!-- Center column -->
            <div class="large-8 small-12 cell">

                <?php /** Logged in */ if ( is_user_logged_in() ) : ?>

                    <div class="training margin-top-3 margin-bottom-3">
                        <div class="grid-x grid-margin-x grid-padding-y padding-1 landing-part">
                            <div class="small-12 small-centered cell center landing">
                                <h2><?php echo esc_html__( "Great job! Here's your progress with this concept", 'zume' ) ?>:</h2>
                            </div>
                            <div class="cell">
                                <div class="grid-x landing-host-list">
                                    <div class="cell auto"></div>
                                    <div class="cell small-1 center">
                                        <div class="stat-landing-title"><?php echo esc_html__( "Heard", 'zume' ) ?></div>
                                        <i class="p-icon-landing complete" id="<?php echo esc_attr( $tool_number ) ?>h"></i>
                                    </div>
                                    <div class="cell small-1 center">
                                        <div class="stat-landing-title"><?php echo esc_html__( "Obeyed", 'zume' ) ?></div>
                                        <i class="p-icon-landing" id="<?php echo esc_attr( $tool_number ) ?>o"></i>
                                    </div>
                                    <div class="cell small-1 center">
                                        <div class="stat-landing-title"><?php echo esc_html__( "Shared", 'zume' ) ?></div>
                                        <i class="p-icon-landing" id="<?php echo esc_attr( $tool_number ) ?>s"></i>
                                    </div>
                                    <div class="cell small-1 center">
                                        <div class="stat-landing-title"><?php echo esc_html__( "Trained", 'zume' ) ?></div>
                                        <i class="p-icon-landing" id="<?php echo esc_attr( $tool_number ) ?>t"></i>
                                    </div>
                                    <div class="cell auto"></div>
                                </div>
                            </div>
                            <div class="cell center">
                                <p>
                                    <a href="<?php echo esc_url( zume_training_url() ) ?>#panel1" class="button primary-button-hollow large"><?php echo esc_html__( "Course Overview", 'zume' ) ?></a>
                                    <a href="<?php echo esc_url( zume_training_url() ) ?>#panel2" class="button primary-button-hollow large"><?php echo esc_html__( "Groups", 'zume' ) ?></a>
                                    <a href="<?php echo esc_url( zume_training_url() ) ?>#panel3" class="button primary-button-hollow large"><?php echo esc_html__( "Checklist", 'zume' ) ?></a>
                                    <a onclick="open_session( <?php echo esc_attr( $session_number ) ?> )" class="button primary-button-hollow large"><?php echo esc_html__( "Start Session", 'zume' ) ?></a>
                                </p>
                            </div>
                            <script>
                                jQuery(document).ready(function(){
                                    window.API.update_progress( '<?php echo esc_attr( $tool_number ) ?>h', 'on' )
                                    load_progress()
                                })
                            </script>

                            <div class="cell"><hr></div>
                            <div class="cell center">
                                <p><?php echo esc_html__( "Zúme Training is freely offered as part of larger Zúme Vision.", 'zume' ) ?> </p>
                                <p><a class="button large primary-button-hollow" href="https://zume.vision"><?php echo esc_html__( "Learn more about the Zúme.Vision", 'zume' ) ?></a></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php /** Not logged in */ if ( ! is_user_logged_in() ) : ?>

                    <div class="training margin-top-3 margin-bottom-3">
                        <div class="grid-x padding-2 landing-part">

                            <div class="cell center"><h2><?php echo esc_html__( "You're missing out.", 'zume' ) ?> <?php echo esc_html__( "Register Now!", 'zume' ) ?></h2></div>
                            <div class="cell list-reasons">
                                <ul>
                                    <li><?php echo esc_html__( "track your personal training progress", 'zume' ) ?></li>
                                    <li><?php echo esc_html__( "access group planning tools", 'zume' ) ?></li>
                                    <li><?php echo esc_html__( "connect with a coach", 'zume' ) ?></li>
                                    <li><?php echo esc_html__( "add your effort to the global vision!", 'zume' ) ?></li>
                                </ul>
                            </div>
                            <div class="cell center">
                                <a href="<?php echo esc_url( zume_register_url() ) ?>" class="button large secondary-button" style="padding-right:2em;padding-left:2em;"><?php echo esc_html__( "Register for Free", 'zume' ) ?></a><br>
                                <a href="<?php echo esc_url( zume_login_url() ) ?>" class="button clear"><?php echo esc_html__( "Login", 'zume' ) ?></a>
                            </div>
                            <div class="cell"><hr></div>
                            <div class="cell center">
                                <p style="max-width:500px; margin:1em auto;"><?php echo esc_html__( "Zúme uses an online training platform to equip participants in basic disciple-making and simple church planting multiplication principles, processes, and practices.", 'zume' ) ?></p>
                                <p><a class="button primary-button-hollow large" href="<?php echo esc_url( zume_training_url() ) ?>"><?php echo esc_html__( "See Entire Training", 'zume' ) ?></a></p>
                            </div>
                            <div class="cell"><hr></div>
                            <div class="cell center">
                                <p><?php echo esc_html__( "Zúme Training is freely offered as part of larger Zúme Vision.", 'zume' ) ?> </p>
                                <p><a class="button large primary-button-hollow" href="https://zume.vision"><?php echo esc_html__( "Learn more about the Zúme.Vision", 'zume' ) ?></a></p>
                            </div>
                        </div>
                    </div>

                <?php endif; ?>

            </div>
            <div class="large-2 cell"></div><!-- Side spacer -->
        </div> <!-- grid-x -->


        <?php get_template_part( "parts/content", "modal" ); ?>

    <?php
    endwhile;
endif;
get_footer();
