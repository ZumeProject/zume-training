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

add_action( 'zume_movement_log_pieces', 'zume_movement_log_pieces', 10, 1 );
function zume_movement_log_pieces( $args = ['tool' => '', 'session' => '', 'language' => '' ] ) {
    ?>
    <script>
        jQuery(document).ready(function(){
            let has_scrolled = false
            jQuery(document).scroll(function() {
                if (jQuery(document).scrollTop() >= 200 && has_scrolled === false ) {
                    window.movement_logging({
                        "action": "<?php echo esc_attr( $args['tool'] ) ?>",
                        "category": "studying",
                        "data-language": "<?php echo esc_attr( $args['language'] ) ?>",
                        "data-session": "<?php echo esc_attr( $args['session'] ) ?>",
                        "data-tool": "<?php echo esc_attr( $args['tool'] ) ?>",
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

add_action( 'zume_movement_log_course', 'zume_movement_log_course', 10 , 1 );
function zume_movement_log_course( $args = ['members' => '', 'session' => '', 'language' => '' ] ){
    ?>
    <script>
        jQuery(document).ready(function(){
            if (typeof window.zume_vision_logging !== "undefined") {
                window.movement_logging({
                    "action": "<?php echo esc_attr($args['session']) ?>",
                    "category": "leading",
                    "data-language": "<?php echo esc_attr($args['language']) ?>",
                    "data-session": "<?php echo esc_attr($args['session']) ?>",
                    "data-group_size": "<?php echo esc_attr($args['members']) ?>",
                    "data-note": "is leading a group of <?php echo esc_attr($args['members']) ?> through session <?php echo esc_attr($args['session']) ?>"
                })
            }
        })
    </script>
    <?php
}

add_action( 'zume_movement_log_3mplan', 'zume_movement_log_3mplan', 10 , 1 );
function zume_movement_log_3mplan( $args = [ 'language' => '' ] ){
    ?>
    <script>
        jQuery(document).ready(function(){
            jQuery('#submit_profile').on('click', function(){
                if (typeof window.zume_vision_logging !== "undefined") {
                    window.movement_logging({
                        "action": "updated_3_month",
                        "category": "committing",
                        "data-language": "<?php echo esc_attr($args['language']) ?>",
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
    if ( class_exists( 'Network_Dashboard_Remote_Log') ) {
        Network_Dashboard_Remote_Log::log([
            "action" => "zume_training",
            "category" => "joining",
            "data-language" => zume_current_language(),
            "data-note" => "is registering for Zúme Training!"
        ]);
    }
}
