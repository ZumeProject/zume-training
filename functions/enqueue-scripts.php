<?php
/**
 * Load scripts
 *
 * @param string $handle
 * @param string $rel_src
 * @param array  $deps
 * @param bool   $in_footer
 */
function zume_enqueue_script( $handle, $rel_src, $deps = array(), $in_footer = false ) {
    if ( $rel_src[0] === "/" ) {
        throw new Error( "zume_enqueue_script took \$rel_src argument which unexpectedly started with /" );
    }
    wp_enqueue_script( $handle, get_template_directory_uri() . "/$rel_src", $deps, filemtime( get_template_directory() . "/$rel_src" ), $in_footer );
}

/**
 * Load styles
 *
 * @param string $handle
 * @param string $rel_src
 * @param array  $deps
 * @param string $media
 */
function zume_enqueue_style( $handle, $rel_src, $deps = array(), $media = 'all' ) {
    if ( $rel_src[0] === "/" ) {
        throw new Error( "zume_enqueue_style took \$rel_src argument which unexpectedly started with /" );
    }
    wp_enqueue_style( $handle, get_template_directory_uri() . "/$rel_src", $deps, filemtime( get_template_directory() . "/$rel_src" ), $media );
}

/**
 * Standard Enqueue
 */
function zume_site_scripts() {
    global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way

    // Adding scripts file in the footer
    zume_enqueue_script( 'site-js', 'assets/scripts/scripts.js', array( 'jquery' ), true );

    // Register main stylesheet
    zume_enqueue_style( 'site-css', 'assets/styles/style.css', array(), 'all' );


    // Comment reply script for threaded comments
    if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1 )) {
        wp_enqueue_script( 'comment-reply' );
    }

    zume_enqueue_script( 'jquery-steps', 'assets/scripts/jquery.steps.js', array( 'jquery' ), true );
    wp_localize_script(
        "jquery-steps", "stepsSettings", array(
            "translations" => [
                "cancel" => esc_html__( 'Cancel', 'zume' ),
                "current:" => esc_html__( 'Current Step:', 'zume' ),
                "pagination" => esc_html__( 'Cancel', 'zume' ),
                "finish" => esc_html__( 'Finish', 'zume' ),
                "next" => esc_html__( 'Next', 'zume' ),
                "previous" => esc_html__( 'Previous', 'zume' ),
                "loading" => esc_html__( 'Loading...', 'zume' )
            ]
        )
    );

    zume_enqueue_script( 'zume', 'assets/scripts/zume.js', array( 'jquery' ), true );
    wp_localize_script(
        "zume", "zumeMaps", array(
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'current_user_login' => wp_get_current_user()->user_login,
            'current_user_id' => get_current_user_id(),
            "translations" => [
                "delete" => esc_html__( 'Delete', 'zume' ),
                "failed_to_remove" => esc_html__( 'Failed to remove item.', 'zume' ),
                "failed_to_change" => esc_html__( 'Failed to change item.', 'zume' ),
                "print_copyright" => esc_html__( 'Three Month Plan - Zúme Project', 'zume' ),
            ]
        )
    );

    zume_enqueue_style( 'zume-course', 'assets/styles/zume-course.css', array(), 'all' ); // Relocated into the _main.scss theme file

    zume_enqueue_style( 'zume_dashboard_style', 'assets/styles/zume-dashboard.css' ); // Relocated to the _main.scss in the theme

    wp_enqueue_style( 'foundations-icons', get_template_directory_uri() .'/assets/styles/foundation-icons/foundation-icons.css', array(), '3' );

//      @todo Rebuild the statistics lookups for Zume stats
    $stats = Zume_Stats::instance();
    $url_path = trim( parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );
    if ("stats" === $url_path){
        wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', array(), false );
        wp_enqueue_script( 'stats', get_template_directory_uri() . '/assets/scripts/stats.js', array( 'jquery', 'google-charts' ), '', false );
        wp_localize_script(
            "stats", "wpApiSettings", array(
                "locations" => $stats->get_group_locations(),
                "sizes" => $stats->get_group_sizes(),
                "steps" => $stats->get_group_steps(),
            //                "analytics" => $stats->analytics(),
            //                "intro_views" => $stats->get_intro_video_views()
            )
        );

    }
//    if ("catalysts" === $url_path){
//        wp_enqueue_script( 'stats', get_template_directory_uri() . '/assets/js/stats.js', array( 'jquery' ), '', false );
//        wp_localize_script(
//            "stats", "wpApiSettings", array(
//                "coach_groups" => $stats->get_coach_groups()
//            )
//        );
//
//    }
//    if ("progress" === $url_path || "zume-progress" === $url_path){
//        wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', array(), false );
//        wp_enqueue_script( 'stats', get_template_directory_uri() . '/assets/js/stats.js', array( 'jquery', 'google-charts' ), '', false );
//        wp_localize_script(
//            "stats", "wpApiSettings", array(
//                "locations" => $stats->get_group_locations(),
//            )
//        );
//
//    }


}
add_action( 'wp_enqueue_scripts', 'zume_site_scripts', 999 );

/**
 * Login Enqueue
 */
function zume_login_css() {
    zume_enqueue_style( 'zume_login_css', 'assets/styles/login.css', array() );
}
add_action( 'login_enqueue_scripts', 'zume_login_css', 999 );
