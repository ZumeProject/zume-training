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
    wp_style_add_data( 'site-css', 'rtl', 'replace' );


    // Comment reply script for threaded comments
    if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1 )) {
        wp_enqueue_script( 'comment-reply' );
    }

    if ( 'template-zume-course.php' === basename( get_page_template() ) ) {
        wp_enqueue_script( 'jquery-steps', get_template_directory_uri() . '/assets/scripts/jquery.steps.js', array( 'jquery' ), 1.1, true );
        wp_localize_script(
            "jquery-steps", "stepsSettings", array(
                "translations" => [
                    "cancel" => esc_html__( 'Cancel', 'zume' ),
                    "current:" => esc_html__( 'Current Step:', 'zume' ),
                    "pagination" => esc_html__( 'Cancel', 'zume' ),
                    "finish" => esc_html__( 'Finish', 'zume' ),
                    "next" => esc_html__( 'Next', 'zume' ),
                    "previous" => esc_html__( 'Previous', 'zume' ),
                    "loading" => esc_html__( 'Loading...', 'zume' ),
                ]
            )
        );
    }

    if ( 'template-zume-training.php' === basename( get_page_template() ) ) {
        wp_enqueue_script( 'zumeTraining', get_template_directory_uri() . '/assets/scripts/training.js', array( 'jquery' ), filemtime( get_theme_file_path() . '/assets/scripts/training.js' ), true );
        $current_language = zume_current_language();
        wp_localize_script(
            "zumeTraining", "zumeTraining", array(
                "current_language" => $current_language,
                "translations" => [
                    'titles' => [
                        1 => esc_html( zume_get_landing_title(1, $current_language) ),
                        2 => esc_html( zume_get_landing_title(2, $current_language) ),
                        3 => esc_html( zume_get_landing_title(3, $current_language) ),
                        4 => esc_html( zume_get_landing_title(4, $current_language) ),
                        5 => esc_html( zume_get_landing_title(5, $current_language) ),
                        6 => esc_html( zume_get_landing_title(6, $current_language) ),
                        7 => esc_html( zume_get_landing_title(7, $current_language) ),
                        8 => esc_html( zume_get_landing_title(8, $current_language) ),
                        9 => esc_html( zume_get_landing_title(9, $current_language) ),
                        10 => esc_html( zume_get_landing_title(10, $current_language) ),
                        11 => esc_html( zume_get_landing_title(11, $current_language) ),
                        12 => esc_html( zume_get_landing_title(12, $current_language) ),
                        13 => esc_html( zume_get_landing_title(13, $current_language) ),
                        14 => esc_html( zume_get_landing_title(14, $current_language) ),
                        15 => esc_html( zume_get_landing_title(15, $current_language) ),
                        16 => esc_html( zume_get_landing_title(16, $current_language) ),
                        17 => esc_html( zume_get_landing_title(17, $current_language) ),
                        18 => esc_html( zume_get_landing_title(18, $current_language) ),
                        19 => esc_html( zume_get_landing_title(19, $current_language) ),
                        20 => esc_html( zume_get_landing_title(20, $current_language) ),
                        21 => esc_html( zume_get_landing_title(21, $current_language) ),
                        22 => esc_html( zume_get_landing_title(22, $current_language) ),
                        23 => esc_html( zume_get_landing_title(23, $current_language) ),
                        24 => esc_html( zume_get_landing_title(24, $current_language) ),
                        25 => esc_html( zume_get_landing_title(25, $current_language) ),
                        26 => esc_html( zume_get_landing_title(26, $current_language) ),
                        27 => esc_html( zume_get_landing_title(27, $current_language) ),
                        28 => esc_html( zume_get_landing_title(28, $current_language) ),
                        29 => esc_html( zume_get_landing_title(29, $current_language) ),
                        30 => esc_html( zume_get_landing_title(30, $current_language) ),
                        31 => esc_html( zume_get_landing_title(31, $current_language) ),
                        32 => esc_html( zume_get_landing_title(32, $current_language) ),
                    ]
                ]
            )
        );
    }

    wp_enqueue_script( 'zume', get_template_directory_uri() . '/assets/scripts/zume.js', array( 'jquery' ), 1.1, true );
    wp_localize_script(
        "zume", "zumeMaps", array(
            'root' => esc_url_raw( rest_url() ),
            'nonce' => wp_create_nonce( 'wp_rest' ),
            'current_user_login' => wp_get_current_user()->user_login,
            'current_user_id' => get_current_user_id(),
            'theme_uri' => get_stylesheet_directory_uri(),
            "translations" => [
                "delete" => esc_html__( 'Delete', 'zume' ),
                "failed_to_remove" => esc_html__( 'Failed to remove item.', 'zume' ),
                "failed_to_change" => esc_html__( 'Failed to change item.', 'zume' ),
                "print_copyright" => esc_html__( 'Three Month Plan - Zúme Project', 'zume' ),
                "we_got_it" => esc_html__( 'We got it!', 'zume' ),
                "we_got_it_message" => esc_html__( 'We\'re a volunteer network, so give us a few days. We\'ll reach out to you soon as possible!', 'zume' )
            ]
        )
    );

    zume_enqueue_style( 'zume-course', 'assets/styles/zume-course.css', array(), 'all' ); // Relocated into the _main.scss theme file
    wp_style_add_data( 'zume-course', 'rtl', 'replace' );

    zume_enqueue_style( 'zume_dashboard_style', 'assets/styles/zume-dashboard.css' ); // Relocated to the _main.scss in the theme
    wp_style_add_data( 'zume_dashboard_style', 'rtl', 'replace' );

    wp_enqueue_style( 'foundations-icons', get_template_directory_uri() .'/assets/styles/foundation-icons/foundation-icons.css', array(), '3' );

}
add_action( 'wp_enqueue_scripts', 'zume_site_scripts', 999 );

/**
 * Login Enqueue
 */
function zume_login_css() {
    zume_enqueue_style( 'zume_login_css', 'assets/styles/login.css', array() );
}
add_action( 'login_enqueue_scripts', 'zume_login_css', 999 );
