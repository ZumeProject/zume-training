<?php
/**
 * This file integrates into the Network Dashboard Remote Plugin
 */
/**
 * /assets/scripts/training.js
 *
 * NOTE: scripts included on the following lines:
 *
 * training.js:752 in function save_new_group()
 * training.js:803 in function save_invitation_response()
 * training.js:1670 in function send_coaching_request()
 */
function zume_get_english_language_name( $language_code ){
    if ( 'en' === $language_code ) {
        return 'English';
    } else {
        $languages = json_decode( file_get_contents( get_template_directory() . '/languages.json' ), true );
        foreach ( $languages as $language ){
            if ( $language_code === $language['code'] ) {
                return $language['enDisplayName'];
            }
        }
        return ''; // empty if no match
    }
}

add_action( 'zume_movement_log_pieces', 'zume_movement_log_pieces', 10, 1 );
function zume_movement_log_pieces( $args = [
'tool' => '',
'session' => '',
'language' => '',
'title' => ''
] ) {
    ?>
    <script>
        jQuery(document).ready(function(){
            let has_scrolled = false
            jQuery(document).scroll(function() {
                if (jQuery(document).scrollTop() >= 200 && has_scrolled === false ) {
                    window.movement_logging({
                        "action": 'studying_' + "<?php echo esc_attr( $args['tool'] ) ?>",
                        "category": "studying",
                        "data-language_code": "<?php echo esc_attr( $args['language'] ) ?>",
                        "data-language_name": "<?php echo esc_html( zume_get_english_language_name( $args['language'] ) ) ?>",
                        "data-session": "<?php echo esc_attr( $args['session'] ) ?>",
                        "data-tool": "<?php echo esc_attr( $args['tool'] ) ?>",
                        "data-title": "<?php echo esc_attr( $args['title'] ) ?>",
                        "data-group_size": "1",
                        "data-note": "is studying"
                    })
                    has_scrolled = true
                }
            });
        })
    </script>
    <?php
}

add_action( 'zume_movement_log_course', 'zume_movement_log_course', 10, 1 );
function zume_movement_log_course( $args = [
'members' => '',
'session' => '',
'language' => ''
] ){
    ?>
    <script>
        jQuery(document).ready(function(){
            if (typeof window.movement_logging !== "undefined") {
                window.movement_logging({
                    "action": 'leading_' + "<?php echo esc_attr( $args['session'] ) ?>",
                    "category": "leading",
                    "data-language_code": "<?php echo esc_attr( $args['language'] ) ?>",
                    "data-language_name": "<?php echo esc_html( zume_get_english_language_name( $args['language'] ) ) ?>",
                    "data-session": "<?php echo esc_attr( $args['session'] ) ?>",
                    "data-group_size": "<?php echo esc_attr( $args['members'] ) ?>",
                    "data-note": "is leading a group of <?php echo esc_attr( $args['members'] ) ?> through session <?php echo esc_attr( $args['session'] ) ?>"
                })
            }
        })
    </script>
    <?php
}

add_action( 'zume_movement_log_3mplan', 'zume_movement_log_3mplan', 10, 1 );
function zume_movement_log_3mplan( $args = [ 'language' => '' ] ){
    ?>
    <script>
        jQuery(document).ready(function(){
            jQuery('#submit_profile').on('click', function(){
                if (typeof window.movement_logging !== "undefined") {
                    window.movement_logging({
                        "action": "updated_3_month",
                        "category": "committing",
                        "data-language_code": "<?php echo esc_attr( $args['language'] ) ?>",
                        "data-language_name": "<?php echo esc_html( zume_get_english_language_name( $args['language'] ) ) ?>",
                        "data-note": "made a three month plan!"
                    })
                }
            })
        })
    </script>
    <?php
}

add_action( 'user_register', 'zume_movement_log_register', 99, 1 );
function zume_movement_log_register( $user_id ){
    if ( class_exists( 'Network_Dashboard_Remote_Log' ) ) {
        $language_code = zume_current_language();
        Network_Dashboard_Remote_Log::log([
            "action" => "zume_training",
            "category" => "joining",
            "data-language_code" => $language_code,
            "data-language_name" => zume_get_english_language_name( $language_code ),
            "data-note" => "is registering for Zúme Training!"
        ]);
    }
}
