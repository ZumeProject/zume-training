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

    /**
     * Zume 3.0 Features
     */
    if ( 'template-zume-training.php' !== basename( get_page_template() ) && 'landing' !== substr( basename( get_page_template() ), 0, 7 ) ) { /* @todo check necessary page loading. Loading on too many pages? */
        wp_enqueue_script('zume', get_template_directory_uri() . '/assets/scripts/zume.js', array('jquery'), 1.1, true);
        wp_localize_script(
            "zume", "zumeMaps", array(
                'root' => esc_url_raw(rest_url()),
                'nonce' => wp_create_nonce('wp_rest'),
                'current_user_login' => wp_get_current_user()->user_login,
                'current_user_id' => get_current_user_id(),
                'theme_uri' => get_stylesheet_directory_uri(),
                "translations" => [
                    "delete" => esc_html__('Delete', 'zume'),
                    "failed_to_remove" => esc_html__('Failed to remove item.', 'zume'),
                    "failed_to_change" => esc_html__('Failed to change item.', 'zume'),
                    "print_copyright" => esc_html__('Three Month Plan - Zúme Project', 'zume'),
                    "we_got_it" => esc_html__('We got it!', 'zume'),
                    "we_got_it_message" => esc_html__('We\'re a volunteer network, so give us a few days. We\'ll reach out to you soon as possible!', 'zume')
                ]
            )
        );
    }

    /**
     Zume 4.0
     */
    if ( 'template-zume-training.php' === basename( get_page_template() ) || 'landing' === substr( basename( get_page_template() ), 0, 7 )   ) {
        wp_register_script( 'lodash', 'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js', false, '4.17.11' );
        wp_enqueue_script( 'lodash' );

        wp_enqueue_script( 'zumeTraining', get_template_directory_uri() . '/assets/scripts/training.js', array( 'jquery', 'lodash', 'wp-i18n' ), filemtime( get_theme_file_path() . '/assets/scripts/training.js' ), true );
        $current_language = zume_current_language();
        wp_localize_script(
            "zumeTraining", "zumeTraining", array(
                'root' => esc_url_raw(rest_url()),
                'theme_uri' => get_stylesheet_directory_uri(),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'current_user_id' => get_current_user_id(),
                "current_language" => $current_language,
                "groups" => Zume_v4_Groups::get_all_groups(),
                "progress" => Zume_v4_Progress::get_user_progress(),
                'urls' => [
                    1 => esc_url( zume_get_landing_translation_url(1, $current_language) ),
                    2 => esc_url( zume_get_landing_translation_url(2, $current_language) ),
                    3 => esc_url( zume_get_landing_translation_url(3, $current_language) ),
                    4 => esc_url( zume_get_landing_translation_url(4, $current_language) ),
                    5 => esc_url( zume_get_landing_translation_url(5, $current_language) ),
                    6 => esc_url( zume_get_landing_translation_url(6, $current_language) ),
                    7 => esc_url( zume_get_landing_translation_url(7, $current_language) ),
                    8 => esc_url( zume_get_landing_translation_url(8, $current_language) ),
                    9 => esc_url( zume_get_landing_translation_url(9, $current_language) ),
                    10 => esc_url( zume_get_landing_translation_url(10, $current_language) ),
                    11 => esc_url( zume_get_landing_translation_url(11, $current_language) ),
                    12 => esc_url( zume_get_landing_translation_url(12, $current_language) ),
                    13 => esc_url( zume_get_landing_translation_url(13, $current_language) ),
                    14 => esc_url( zume_get_landing_translation_url(14, $current_language) ),
                    15 => esc_url( zume_get_landing_translation_url(15, $current_language) ),
                    16 => esc_url( zume_get_landing_translation_url(16, $current_language) ),
                    17 => esc_url( zume_get_landing_translation_url(17, $current_language) ),
                    18 => esc_url( zume_get_landing_translation_url(18, $current_language) ),
                    19 => esc_url( zume_get_landing_translation_url(19, $current_language) ),
                    20 => esc_url( zume_get_landing_translation_url(20, $current_language) ),
                    21 => esc_url( zume_get_landing_translation_url(21, $current_language) ),
                    22 => esc_url( zume_get_landing_translation_url(22, $current_language) ),
                    23 => esc_url( zume_get_landing_translation_url(23, $current_language) ),
                    24 => esc_url( zume_get_landing_translation_url(24, $current_language) ),
                    25 => esc_url( zume_get_landing_translation_url(25, $current_language) ),
                    26 => esc_url( zume_get_landing_translation_url(26, $current_language) ),
                    27 => esc_url( zume_get_landing_translation_url(27, $current_language) ),
                    28 => esc_url( zume_get_landing_translation_url(28, $current_language) ),
                    29 => esc_url( zume_get_landing_translation_url(29, $current_language) ),
                    30 => esc_url( zume_get_landing_translation_url(30, $current_language) ),
                    31 => esc_url( zume_get_landing_translation_url(31, $current_language) ),
                    32 => esc_url( zume_get_landing_translation_url(32, $current_language) ),
                ],
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
                    ],
                    'sessions' => [
                        1 => __('Session 1', 'zume'),
                        2 => __('Session 2', 'zume'),
                        3 => __('Session 3', 'zume'),
                        4 => __('Session 4', 'zume'),
                        5 => __('Session 5', 'zume'),
                        6 => __('Session 6', 'zume'),
                        7 => __('Session 7', 'zume'),
                        8 => __('Session 8', 'zume'),
                        9 => __('Session 9', 'zume'),
                        10 => __('Session 10', 'zume'),
                        11 => __('Session 11', 'zume'),
                        12 => __('Session 12', 'zume'),
                        13 => __('Session 13', 'zume'),
                        14 => __('Session 14', 'zume'),
                        15 => __('Session 15', 'zume'),
                        16 => __('Session 16', 'zume'),
                        17 => __('Session 17', 'zume'),
                        18 => __('Session 18', 'zume'),
                        19 => __('Session 19', 'zume'),
                        20 => __('Session 20', 'zume'),
                        21 => __('Session 21', 'zume'),
                        22 => __('Session 22', 'zume'),
                        23 => __('Session 23', 'zume'),
                        24 => __('Session 24', 'zume'),
                        25 => __('Session 25', 'zume'),
                        26 => __('Session 26', 'zume'),
                        27 => __('Session 27', 'zume'),
                        28 => __('Session 28', 'zume'),
                        29 => __('Session 29', 'zume'),
                        30 => __('Session 30', 'zume'),
                        31 => __('Session 31', 'zume'),
                        32 => __('Session 32', 'zume'),
                    ]

                ]
            )
        );
    }



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
