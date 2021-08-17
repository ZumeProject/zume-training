<?php

// @codingStandardsIgnoreLine
require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php'); // loads the wp framework when called
global $wpdb;

/**
 * Single video request
 */
if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {

    if ( ! is_numeric( $_GET['id'] ) ) {
        die('Not the correct id type');
    }
    $video_id = sanitize_text_field( wp_unslash( $_GET['id'] ) );

    // @todo Add movement logging

    //global $wpdb;

    //$video_record = $wpdb->get_results("", ARRAY_A );


    // log view view to movement log


    // look up ip address

    // build record



    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
    <div style="padding:56.25% 0 0 0;position:relative;">
        <iframe src="https://player.vimeo.com/video/<?php echo $video_id ?>?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479&amp;h=fcfe2172a8"
                frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                allowfullscreen
                style="position:absolute;top:0;left:0;width:100%;height:100%;"
                title="<?php echo $video_id ?>">
        </iframe>
    </div>
    <script src="https://player.vimeo.com/api/player.js"></script>
    </body>
    </html>

<?php
}
/**
 * Language List of QR Codes
 */
else {

}

