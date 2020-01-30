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
    $zume_user = wp_get_current_user();
    $zume_user_meta = zume_get_user_meta( $zume_user->ID );

    // Adding scripts file in the footer
    zume_enqueue_script( 'site-js', 'assets/scripts/scripts.js', array( 'jquery' ), true );

    // Register main stylesheet
    zume_enqueue_style( 'site-css', 'assets/styles/style.css', array(), 'all' );
    wp_style_add_data( 'site-css', 'rtl', 'replace' );


    // Comment reply script for threaded comments
    if ( is_singular() && comments_open() && ( get_option( 'thread_comments' ) == 1 )) {
        wp_enqueue_script( 'comment-reply' );
    }

    /**
     * Zume 3.0 Features
     */
    if ( 'template-zume-training.php' !== basename( get_page_template() ) && 'landing' !== substr( basename( get_page_template() ), 0, 7 ) ) { /* @todo check necessary page loading. Loading on too many pages? */
        wp_enqueue_script( 'zume', get_template_directory_uri() . '/assets/scripts/zume.js', array( 'jquery' ), 1.1, true );
        wp_localize_script(
            "zume", "zumeMaps", array(
                'root' => esc_url_raw( rest_url() ),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'current_user_login' => wp_get_current_user()->user_login,
                'current_user_id' => get_current_user_id(),
                'theme_uri' => get_stylesheet_directory_uri(),
                "translations" => array(
                    "delete" => esc_html__( 'Delete', 'zume' ),
                    "failed_to_remove" => esc_html__( 'Failed to remove item.', 'zume' ),
                    "failed_to_change" => esc_html__( 'Failed to change item.', 'zume' ),
                    "print_copyright" => esc_html__( 'Three Month Plan - Zúme Project', 'zume' ),
                    "we_got_it" => esc_html__( 'We got it!', 'zume' ),
                    "we_got_it_message" => esc_html__( 'We\'re a volunteer network, so give us a few days. We\'ll reach out to you soon as possible!', 'zume' )
                )
            )
        );
    }

    if ( 'template-zume-course.php' === basename( get_page_template() ) /* 3.0 */ || 'template-zume-course-v4.php' === basename( get_page_template() ) /* 4.0 */ ) {
        wp_enqueue_script( 'jquery-steps', get_template_directory_uri() . '/assets/scripts/jquery.steps.js', array( 'jquery' ), 1.1, true );
        wp_localize_script(
            "jquery-steps", "stepsSettings", array(
                "translations" => array(
                    "cancel" => esc_html__( 'Cancel', 'zume' ),
                    "current:" => esc_html__( 'Current Step:', 'zume' ),
                    "pagination" => esc_html__( 'Cancel', 'zume' ),
                    "finish" => esc_html__( 'Finish', 'zume' ),
                    "next" => esc_html__( 'Next', 'zume' ),
                    "previous" => esc_html__( 'Previous', 'zume' ),
                    "loading" => esc_html__( 'Loading...', 'zume' ),
                )
            )
        );
    }

    if ( 'template-zume-profile.php' === basename( get_page_template() ) ) {

        wp_enqueue_script( 'zume-profile', get_template_directory_uri() . '/assets/scripts/profile.js', array( 'jquery', 'lodash', 'wp-i18n' ), filemtime( get_theme_file_path() . '/assets/scripts/profile.js' ), true );
        wp_localize_script(
            "zume-profile", "zumeProfile", array(
                'root' => esc_url_raw( rest_url() ),
                'theme_uri' => get_stylesheet_directory_uri(),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'current_user_id' => get_current_user_id(),
                'user_profile_fields' => [
                    'id' => $zume_user->data->ID,
                    'name' => $zume_user_meta['zume_full_name'] ?? '',
                    'email' => $zume_user->data->user_email,
                    'phone' => $zume_user_meta['zume_phone_number'] ?? '',
                    'location_grid_meta' => maybe_unserialize( $zume_user_meta['location_grid_meta'] ) ?? '',
                    'affiliation_key' => $zume_user_meta['zume_affiliation_key'] ?? '',
                    'facebook_sso_email' => $zume_user_meta['facebook_sso_email'] ?? false,
                    'google_sso_email' => $zume_user_meta['google_sso_email'] ?? false,
                ],
                'logged_in' => is_user_logged_in(),
                'map_key' => DT_Mapbox_API::get_key(),
            )
        );
    }

    /**
     Zume 4.0
     */
    if ( 'template-zume-training.php' === basename( get_page_template() )
        || 'template-pieces-page.php' === basename( get_page_template() )
        || 'template-zume-course-v4.php' === basename( get_page_template() ) ) {
        wp_register_script( 'lodash', 'https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.min.js', false, '4.17.11' );
        wp_enqueue_script( 'lodash' );

        wp_enqueue_script( 'zumeTraining', get_template_directory_uri() . '/assets/scripts/training.js', array( 'jquery', 'lodash', 'wp-i18n' ), filemtime( get_theme_file_path() . '/assets/scripts/training.js' ), true );
        $current_language = zume_current_language();
        wp_localize_script(
            "zumeTraining", "zumeTraining", array(
                'root' => esc_url_raw( rest_url() ),
                'theme_uri' => get_stylesheet_directory_uri(),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'current_user_id' => get_current_user_id(),
                'user_profile_fields' => [
                    'id' => $zume_user->data->ID,
                    'name' => $zume_user_meta['zume_full_name'] ?? '',
                    'email' => $zume_user->data->user_email,
                    'phone' => $zume_user_meta['zume_phone_number'] ?? '',
                    'location_grid_meta' => maybe_unserialize( $zume_user_meta['location_grid_meta'] ) ?? '',
                    'affiliation_key' => $zume_user_meta['zume_affiliation_key'] ?? '',
                    'facebook_sso_email' => $zume_user_meta['facebook_sso_email'] ?? false,
                    'google_sso_email' => $zume_user_meta['google_sso_email'] ?? false,
                    'zume_global_network' => $zume_user_meta['zume_global_network'] ?? false,
                ],
                'logged_in' => is_user_logged_in(),
                'map_key' => DT_Mapbox_API::get_key(),
                "current_language" => $current_language,
                "groups" => ( is_user_logged_in() ) ? Zume_V4_Groups::get_all_groups() : array(),
                "progress" => ( is_user_logged_in() ) ? Zume_V4_Progress::get_user_progress() : array(),
                "invitations" => ( is_user_logged_in() ) ? Zume_V4_Groups::get_colead_groups( 'waiting_acceptance_minimum' ) : array(),
                'urls' => array(
                    1 => esc_url( zume_get_landing_translation_url( 1, $current_language ) ),
                    2 => esc_url( zume_get_landing_translation_url( 2, $current_language ) ),
                    3 => esc_url( zume_get_landing_translation_url( 3, $current_language ) ),
                    4 => esc_url( zume_get_landing_translation_url( 4, $current_language ) ),
                    5 => esc_url( zume_get_landing_translation_url( 5, $current_language ) ),
                    6 => esc_url( zume_get_landing_translation_url( 6, $current_language ) ),
                    7 => esc_url( zume_get_landing_translation_url( 7, $current_language ) ),
                    8 => esc_url( zume_get_landing_translation_url( 8, $current_language ) ),
                    9 => esc_url( zume_get_landing_translation_url( 9, $current_language ) ),
                    10 => esc_url( zume_get_landing_translation_url( 10, $current_language ) ),
                    11 => esc_url( zume_get_landing_translation_url( 11, $current_language ) ),
                    12 => esc_url( zume_get_landing_translation_url( 12, $current_language ) ),
                    13 => esc_url( zume_get_landing_translation_url( 13, $current_language ) ),
                    14 => esc_url( zume_get_landing_translation_url( 14, $current_language ) ),
                    15 => esc_url( zume_get_landing_translation_url( 15, $current_language ) ),
                    16 => esc_url( zume_get_landing_translation_url( 16, $current_language ) ),
                    17 => esc_url( zume_get_landing_translation_url( 17, $current_language ) ),
                    18 => esc_url( zume_get_landing_translation_url( 18, $current_language ) ),
                    19 => esc_url( zume_get_landing_translation_url( 19, $current_language ) ),
                    20 => esc_url( zume_get_landing_translation_url( 20, $current_language ) ),
                    21 => esc_url( zume_get_landing_translation_url( 21, $current_language ) ),
                    22 => esc_url( zume_get_landing_translation_url( 22, $current_language ) ),
                    23 => esc_url( zume_get_landing_translation_url( 23, $current_language ) ),
                    24 => esc_url( zume_get_landing_translation_url( 24, $current_language ) ),
                    25 => esc_url( zume_get_landing_translation_url( 25, $current_language ) ),
                    26 => esc_url( zume_get_landing_translation_url( 26, $current_language ) ),
                    27 => esc_url( zume_get_landing_translation_url( 27, $current_language ) ),
                    28 => esc_url( zume_get_landing_translation_url( 28, $current_language ) ),
                    29 => esc_url( zume_get_landing_translation_url( 29, $current_language ) ),
                    30 => esc_url( zume_get_landing_translation_url( 30, $current_language ) ),
                    31 => esc_url( zume_get_landing_translation_url( 31, $current_language ) ),
                    32 => esc_url( zume_get_landing_translation_url( 32, $current_language ) ),

                ),
                'site_urls' => array(
                  'login' => esc_url( zume_login_url( $current_language ) ),
                  'register' => esc_url( zume_register_url( $current_language ) ),
                  'training' => esc_url( zume_training_url( $current_language ) ),
                  'course' => esc_url( zume_course_url() ),
                ),
                "translations" => array(
                    'titles' => array(
                        1 => empty( zume_get_landing_title( 1, $current_language ) ) ? __( 'God Uses Ordinary People', 'zume' ) : esc_html( zume_get_landing_title( 1, $current_language ) ),
                        2 => empty( zume_get_landing_title( 2, $current_language ) ) ? __( 'Simple Definition of Disciple and Church', 'zume' ) : esc_html( zume_get_landing_title( 2, $current_language ) ),
                        3 => empty( zume_get_landing_title( 3, $current_language ) ) ? __( 'Spiritual Breathing is Hearing and Obeying God', 'zume' ) : esc_html( zume_get_landing_title( 3, $current_language ) ),
                        4 => empty( zume_get_landing_title( 4, $current_language ) ) ? __( 'SOAPS Bible Reading', 'zume' ) : esc_html( zume_get_landing_title( 4, $current_language ) ),
                        5 => empty( zume_get_landing_title( 5, $current_language ) ) ? __( 'Accountability Groups', 'zume' ) : esc_html( zume_get_landing_title( 5, $current_language ) ),
                        6 => empty( zume_get_landing_title( 6, $current_language ) ) ? __( 'Consumer vs Producer Lifestyle', 'zume' ) : esc_html( zume_get_landing_title( 6, $current_language ) ),
                        7 => empty( zume_get_landing_title( 7, $current_language ) ) ? __( 'How to Spend an Hour in Prayer', 'zume' ) : esc_html( zume_get_landing_title( 7, $current_language ) ),
                        8 => empty( zume_get_landing_title( 8, $current_language ) ) ? __( 'Relational Stewardship – List of 100', 'zume' ) : esc_html( zume_get_landing_title( 8, $current_language ) ),
                        9 => empty( zume_get_landing_title( 9, $current_language ) ) ? __( 'The Kingdom Economy', 'zume' ) : esc_html( zume_get_landing_title( 9, $current_language ) ),
                        10 => empty( zume_get_landing_title( 10, $current_language ) ) ? __( 'The Gospel and How to Share It', 'zume' ) : esc_html( zume_get_landing_title( 10, $current_language ) ),
                        11 => empty( zume_get_landing_title( 11, $current_language ) ) ? __( 'Baptism and How To Do It', 'zume' ) : esc_html( zume_get_landing_title( 11, $current_language ) ),
                        12 => empty( zume_get_landing_title( 12, $current_language ) ) ? __( 'Prepare Your 3-Minute Testimony', 'zume' ) : esc_html( zume_get_landing_title( 12, $current_language ) ),
                        13 => empty( zume_get_landing_title( 13, $current_language ) ) ? __( 'Vision Casting the Greatest Blessing', 'zume' ) : esc_html( zume_get_landing_title( 13, $current_language ) ),
                        14 => empty( zume_get_landing_title( 14, $current_language ) ) ? __( 'Duckling Discipleship – Leading Immediately', 'zume' ) : esc_html( zume_get_landing_title( 14, $current_language ) ),
                        15 => empty( zume_get_landing_title( 15, $current_language ) ) ? __( "Eyes to See Where The Kingdom Isn't", 'zume' ) : esc_html( zume_get_landing_title( 15, $current_language ) ),
                        16 => empty( zume_get_landing_title( 16, $current_language ) ) ? __( "The Lord's Supper and How To Lead It", 'zume' ) : esc_html( zume_get_landing_title( 16, $current_language ) ),
                        17 => empty( zume_get_landing_title( 17, $current_language ) ) ? __( 'Prayer Walking and How To Do It', 'zume' ) : esc_html( zume_get_landing_title( 17, $current_language ) ),
                        18 => empty( zume_get_landing_title( 18, $current_language ) ) ? __( 'A Person of Peace and How To Find One', 'zume' ) : esc_html( zume_get_landing_title( 18, $current_language ) ),
                        19 => empty( zume_get_landing_title( 19, $current_language ) ) ? __( 'The BLESS Prayer Pattern', 'zume' ) : esc_html( zume_get_landing_title( 19, $current_language ) ),
                        20 => empty( zume_get_landing_title( 20, $current_language ) ) ? __( 'Faithfulness is Better Than Knowledge', 'zume' ) : esc_html( zume_get_landing_title( 20, $current_language ) ),
                        21 => empty( zume_get_landing_title( 21, $current_language ) ) ? __( '3/3 Group Meeting Pattern', 'zume' ) : esc_html( zume_get_landing_title( 21, $current_language ) ),
                        22 => empty( zume_get_landing_title( 22, $current_language ) ) ? __( 'Training Cycle for Maturing Disciples', 'zume' ) : esc_html( zume_get_landing_title( 22, $current_language ) ),
                        23 => empty( zume_get_landing_title( 23, $current_language ) ) ? __( 'Leadership Cells', 'zume' ) : esc_html( zume_get_landing_title( 23, $current_language ) ),
                        24 => empty( zume_get_landing_title( 24, $current_language ) ) ? __( 'Expect Non-Sequential Growth', 'zume' ) : esc_html( zume_get_landing_title( 24, $current_language ) ),
                        25 => empty( zume_get_landing_title( 25, $current_language ) ) ? __( 'Pace of Multiplication Matters', 'zume' ) : esc_html( zume_get_landing_title( 25, $current_language ) ),
                        26 => empty( zume_get_landing_title( 26, $current_language ) ) ? __( 'Always Part of Two Churches', 'zume' ) : esc_html( zume_get_landing_title( 26, $current_language ) ),
                        27 => __( 'Three-Month Plan', 'zume' ),
                        28 => empty( zume_get_landing_title( 28, $current_language ) ) ? __( 'Coaching Checklist', 'zume' ) : esc_html( zume_get_landing_title( 28, $current_language ) ),
                        29 => empty( zume_get_landing_title( 29, $current_language ) ) ? __( 'Leadership in Networks', 'zume' ) : esc_html( zume_get_landing_title( 29, $current_language ) ),
                        30 => empty( zume_get_landing_title( 30, $current_language ) ) ? __( 'Peer Mentoring Groups', 'zume' ) : esc_html( zume_get_landing_title( 30, $current_language ) ),
                        31 => empty( zume_get_landing_title( 31, $current_language ) ) ? __( 'Four Fields Tool', 'zume' ) : esc_html( zume_get_landing_title( 31, $current_language ) ),
                        32 => empty( zume_get_landing_title( 32, $current_language ) ) ? __( 'Generational Mapping', 'zume' ) : esc_html( zume_get_landing_title( 32, $current_language ) ),
                    ),
                    'sessions' => array(
                        1 => __( 'Session 1', 'zume' ),
                        2 => __( 'Session 2', 'zume' ),
                        3 => __( 'Session 3', 'zume' ),
                        4 => __( 'Session 4', 'zume' ),
                        5 => __( 'Session 5', 'zume' ),
                        6 => __( 'Session 6', 'zume' ),
                        7 => __( 'Session 7', 'zume' ),
                        8 => __( 'Session 8', 'zume' ),
                        9 => __( 'Session 9', 'zume' ),
                        10 => __( 'Session 10', 'zume' ),
                        11 => __( 'Session 11', 'zume' ),
                        12 => __( 'Session 12', 'zume' ),
                        13 => __( 'Session 13', 'zume' ),
                        14 => __( 'Session 14', 'zume' ),
                        15 => __( 'Session 15', 'zume' ),
                        16 => __( 'Session 16', 'zume' ),
                        17 => __( 'Session 17', 'zume' ),
                        18 => __( 'Session 18', 'zume' ),
                        19 => __( 'Session 19', 'zume' ),
                        20 => __( 'Session 20', 'zume' ),
                        21 => __( 'Session 21', 'zume' ),
                        22 => __( 'Session 22', 'zume' ),
                        23 => __( 'Session 23', 'zume' ),
                        24 => __( 'Session 24', 'zume' ),
                        25 => __( 'Session 25', 'zume' ),
                        26 => __( 'Session 26', 'zume' ),
                        27 => __( 'Session 27', 'zume' ),
                        28 => __( 'Session 28', 'zume' ),
                        29 => __( 'Session 29', 'zume' ),
                        30 => __( 'Session 30', 'zume' ),
                        31 => __( 'Session 31', 'zume' ),
                        32 => __( 'Session 32', 'zume' ),
                    )

                )
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
