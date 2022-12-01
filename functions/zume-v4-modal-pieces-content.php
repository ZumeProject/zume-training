<?php

function get_modal_content( $postid, $lang, $strings ) {

    if ( 'en' !== $lang && ! is_wp_error( $postid ) ){
        $postid = zume_get_translation( $postid, $lang );
    }
    if ( is_wp_error( $postid ) ) {
        return '';
    }

    switch_to_locale( $lang );


    if ( ! is_textdomain_loaded( 'zume' ) ) {
        load_theme_textdomain( 'zume', get_template_directory() .'/translations' );
    }
    dt_write_log( is_textdomain_loaded( 'zume' ) );

    $meta = get_post_meta( (int) $postid );

    $tool_number = $meta['zume_piece'][0] ?? 0;
    $pre_video_content = $meta['zume_pre_video_content'][0] ?? '';
    $post_video_content = $meta['zume_post_video_content'][0] ?? '';
    $ask_content = $meta['zume_ask_content'][0] ?? '';
    $h1_title = empty( $meta['zume_piece_h1'][0] ) ? get_the_title( $postid ) : $meta['zume_piece_h1'][0];

    $args = Zume_V4_Pieces::vars( $tool_number );
    if ( empty( $args ) ) {
        return '';
    }

//    $session_number = $args['session_number'];
    $alt_video = $args['alt_video'];
    $image_url = $args['image_url'];
    $audio = $args['audio'];
    $has_video = $args['has_video'];
    $video_id = $args['video_id'];


    ob_start();
    ?>

    <!-- Wrappers -->
    <div id="content" class="grid-x grid-padding-x training pieces"><div id="inner-content" class="cell">

    <!------------------------------------------------------------------------------------------------>
    <!-- Title section -->
    <!------------------------------------------------------------------------------------------------>
    <div class="grid-x grid-margin-x grid-margin-y vertical-padding">
        <div class="medium-2 small-1 cell"></div><!-- Side spacer -->

        <!-- Center column -->
        <div class="medium-8 small-10 cell center">

            <?php if ( ! empty( $image_url ) ) : ?>
                <img src="<?php echo esc_url( $image_url ) ?>" alt="<?php echo esc_html( $h1_title ) ?>" style="max-height:225px;"/>
            <?php endif; ?>

            <h1><?php echo esc_html( $h1_title ) ?></h1>

        </div>

        <div class="medium-2 small-1 cell"></div><!-- Side spacer -->
    </div>


    <!------------------------------------------------------------------------------------------------>
    <!-- Unique page content section -->
    <!------------------------------------------------------------------------------------------------>
    <div class="grid-x ">

        <!-- Center column -->
        <div class="cell center-content" id="training-content">

            <section><!-- Step Title -->

                <!-- pre-video block -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="cell content-large">
                        <?php echo wp_kses_post( wpautop( $pre_video_content ) ) ?>
                    </div>
                </div>


                <!-- video block -->
                <?php if ($has_video) : ?>
                    <div class="grid-x grid-margin-x grid-margin-y">
                        <div class="cell content-large center">
                            <?php if ( $audio ) :  ?>
                                <h3><?php echo esc_html( $strings['lra'] ) ?? '' ?></h3>
                                <a class="button large text-uppercase"
                                   href="<?php echo esc_url( Zume_Course::get_download_by_key( '33', $lang ) ) ?>"
                                   target="_blank" rel="noopener noreferrer nofollow">
                                    <?php echo esc_html( $strings['d'] ) ?? '' ?>
                                </a>
                            <?php else : ?>
                                <h3 class="center"><?php echo esc_html( $strings['wtv'] ) ?? '' ?></h3>
                            <?php endif; ?>

                            <div class="video-section">
                                <?php if ( $alt_video ) : ?>
                                    <video width="960" height="540" style="border: 1px solid lightgrey;margin: 0 15%;" controls>
                                        <source src="<?php echo esc_url( Zume_Course::get_alt_video_by_key( 'alt_'.$video_id ) ) ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                <?php else : ?>
                                    <iframe style="border: 1px solid lightgrey;"  src="<?php echo esc_url( Zume_Course::get_video_by_key( $video_id, true, $lang ) ) ?>" width="560" height="315"
                                            frameborder="1" webkitallowfullscreen mozallowfullscreen allowfullscreen>
                                    </iframe>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


                <!-- post-video block -->
                <div class="grid-x grid-margin-x grid-margin-y">
                    <div class="cell content-large">
                        <?php echo wp_kses_post( wpautop( $post_video_content ) ) ?>
                    </div>
                </div>


                <!-- question block -->
                <div class="grid-x grid-margin-x">
                    <div class="cell content-large center">
                        <h3 class="center"><?php echo esc_html( $strings['ay'] ) ?? '' ?></h3>
                    </div>
                    <div class="cell content-large">
                        <?php echo wp_kses_post( wpautop( $ask_content ) ) ?>
                    </div>
                </div>

            </section>

        <div class="cell" id="invitation-footer"></div>
        </div>


    </div> <!-- grid-x -->
    <?php

    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;

}
