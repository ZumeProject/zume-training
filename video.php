<?php

// @codingStandardsIgnoreLine
define( 'DOING_AJAX', true );
define( 'SHORTINIT', true );
require_once( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' ); // loads the wp framework when called
$theme_path = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/zume-training/';

global $wpdb;
$site_url  = $wpdb->get_var(
    "SELECT option_value
            FROM $wpdb->options o
            WHERE option_name = 'siteurl'"
);
/**
 * Single video request
 */
if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {

    if ( ! is_numeric( $_GET['id'] ) ) {
        die( 'Not the correct id type' );
    }
    $vimeo_id = sanitize_text_field( wp_unslash( $_GET['id'] ) );
    // https://zume.training/wp-content/themes/zume-training/video.php?id=551339739

    // @todo Add movement logging

    $post = $wpdb->get_row( $wpdb->prepare(
        "SELECT pm.post_id, pm.meta_key as tool_number, p.post_title as language_code
                FROM $wpdb->postmeta pm
                JOIN $wpdb->posts p ON p.ID=pm.post_id
                WHERE pm.meta_value = %s
                LIMIT 1",
        $vimeo_id
    ), ARRAY_A );
    if ( empty( $post ) ) {
        die( 'Not a recognized id' );
    }

    $post_id = $post['post_id'];
    $tool_number = $post['tool_number'];
    $language_code = $post['language_code'] ?? 'en';
    $language_name = 'English';
    $session = '';
    $title = '';
    $page_id = zume_landing_page_post_id( $tool_number );

    $title = $wpdb->get_var( $wpdb->prepare( "SELECT post_title FROM $wpdb->posts WHERE ID = %s", $page_id ) );

    $languages = json_decode( file_get_contents( $theme_path . '/languages.json' ), true );
    foreach ( $languages as $language ){
        if ( $language_code === $language['code'] ) {
            $language_name = $language['enDisplayName'];
            break;
        }
    }

    ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>
    <body>
        <div style="padding:56.25% 0 0 0;position:relative;">
            <iframe src="https://player.vimeo.com/video/<?php echo $vimeo_id ?>?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479&amp;h=fcfe2172a8"
                    frameborder="0" allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen
                    style="position:absolute;top:0;left:0;width:100%;height:100%;"
                    title="<?php echo $vimeo_id ?>">
            </iframe>
        </div>
        <script src="https://player.vimeo.com/api/player.js"></script>
        <script>
            jQuery(document).ready(function(){
                let data = {
                    "action": 'studying_offline_' + "<?php echo esc_attr( $tool_number ) ?>",
                    "category": "studying",
                    "data-language_code": "<?php echo $language_code ?>",
                    "data-language_name": "<?php echo $language_name ?>",
                    "data-session": "<?php echo $session ?>",
                    "data-tool": "<?php echo $tool_number ?>",
                    "data-title": "<?php echo $title ?>",
                    "data-group_size": "1",
                    "data-note": "is studying offline"
                }
                jQuery.ajax({
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    url: '<?php echo $site_url ?>/wp-json/movement_logging/v1/log',
                })
                    .done(function(response){
                        console.log(response)
                    })
            })
        </script>

    </body>
    </html>

    <?php
}
/**
 * Language List of QR Codes
 */
else if ( isset( $_GET['lang'] ) && ! empty( $_GET['lang'] ) ) {
    $lang = sanitize_text_field( wp_unslash( $_GET['lang'] ) );
    // is valid language code



}































if ( ! function_exists( 'dt_write_log' ) ) {
    /**
     * A function to assist development only.
     * This function allows you to post a string, array, or object to the WP_DEBUG log.
     * It also prints elapsed time since the last call.
     *
     * @param $log
     */
    function dt_write_log( $log ) {
        if ( true === WP_DEBUG ) {
            global $dt_write_log_microtime;
            $now = microtime( true );
            if ( $dt_write_log_microtime > 0 ) {
                $elapsed_log = sprintf( "[elapsed:%5dms]", ( $now - $dt_write_log_microtime ) * 1000 );
            } else {
                $elapsed_log = "[elapsed:-------]";
            }
            $dt_write_log_microtime = $now;
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( $elapsed_log . " " . print_r( $log, true ) );
            } else {
                error_log( "$elapsed_log $log" );
            }
        }
    }
}
function zume_landing_page_post_id( int $number ) : int {
    /**
     * These are the root post ids for the english page, which is used to find the translation page in the
     * polylang system.
     */
    $list = array(
        1 => 20730, // God uses ordinary people
        2 => 20731, // teach them to obey
        3 => 20732, // spiritual breathing
        4 => 20733, // soaps bible reading
        5 => 20735, // accountability groups
        6 => 20737, // consumers vs producers
        7 => 20738, // prayer cycle
        8 => 20739, // list of 100
        9 => 20740, // kingdom economy
        10 => 20741, // the gospel
        11 => 20742, // baptism
        12 => 20743, // 3-minute testimony
        13 => 20744, // greatest blessing
        14 => 20745, // duckling discipleship
        15 => 20746, // seeing where God's kingdom isn't
        16 => 20747, // the lord's supper
        17 => 20748, // prayer walking
        18 => 20750, // person of peace
        19 => 20749, // bless prayer
        20 => 20751, // faithfulness
        21 => 20752, // 3/3 group pattern
        22 => 20753, // training cycle
        23 => 20755, // leadership cells
        24 => 20756, // non-sequential
        25 => 20757, // pace
        26 => 20758, // part of two churches
        27 => 19848, // 3-month plan
        28 => 20759, // coaching checklist
        29 => 20760, // leadership in networks
        30 => 20761, // peer mentoring groups
        31 => 20762, // four fields tool
        32 => 20763, // generation mapping
        20730 => 1, // God uses ordinary people
        20731 => 2, // teach them to obey
        20732 => 3, // spiritual breathing
        20733 => 4, // soaps bible reading
        20735 => 5, // accountability groups
        20737 => 6, // consumers vs producers
        20738 => 7, // prayer cycle
        20739 => 8, // list of 100
        20740 => 9, // kingdom economy
        20741 => 10, // the gospel
        20742 => 11, // baptism
        20743 => 12, // 3-minute testimony
        20744 => 13, // greatest blessing
        20745 => 14, // duckling discipleship
        20746 => 15, // seeing where God's kingdom isn't
        20747 => 16, // the lord's supper
        20748 => 17, // prayer walking
        20750 => 18, // person of peace
        20749 => 19, // bless prayer
        20751 => 20, // faithfulness
        20752 => 21, // 3/3 group pattern
        20753 => 22, // training cycle
        20755 => 23, // leadership cells
        20756 => 24, // non-sequential
        20757 => 25, // pace
        20758 => 26, // part of two churches
        19848 => 27, // 3-month plan
        20759 => 28, // coaching checklist
        20760 => 29, // leadership in networks
        20761 => 30, // peer mentoring groups
        20762 => 31, // four fields tool
        20763 => 32, // generation mapping

    );

    return $list[$number] ?? 0;
}
