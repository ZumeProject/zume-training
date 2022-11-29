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
    $zume_user_meta = ( is_user_logged_in() ) ? zume_get_user_meta( $zume_user->ID ) : [];

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
                'translations' => [
                    'x1' => __( 'Your Profile', 'zume' ),
                    'x2' => __( 'First and last name', 'zume' ),
                    'x3' => __( 'Phone', 'zume' ),
                    'x4' => __( 'Email', 'zume' ),
                    'x5' => __( 'This form is required.', 'zume' ),
                    'x6' => __( 'City', 'zume' ),
                    'x7' => __( 'example: Denver, CO 80120', 'zume' ),
                    'x8' => __( 'Affiliation Key', 'zume' ),
                    'x9' => __( 'Oh snap!', 'zume' ),
                    'x10' => __( 'Save', 'zume' ),
                    'x11' => __( 'Linked Accounts', 'zume' ),
                    'x12' => __( 'Linked Facebook Account', 'zume' ),
                    'x13' => __( 'Unlink', 'zume' ),
                    'x14' => __( 'Linked Google Account', 'zume' ),
                    'x15' => __( 'No location matches found. Try a less specific address.', 'zume' ),
                    'x16' => __( 'Name', 'zume' ),
                ]
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
        $languages = file_get_contents( get_theme_file_path( 'languages.json' ) );
        if ( ! empty( $languages ) ) {
            $languages = json_decode( $languages, true );
        } else {
            $languages = [];
        }
        wp_localize_script(
            "zumeTraining", "zumeTraining", array(
                'root' => esc_url_raw( rest_url() ),
                'theme_uri' => get_stylesheet_directory_uri(),
                'nonce' => wp_create_nonce( 'wp_rest' ),
                'current_user_id' => ( is_user_logged_in() ) ? get_current_user_id() : 0,
                'user_profile_fields' => [
                    'id' => ( is_user_logged_in() ) ? $zume_user->data->ID ?? '' : 0,
                    'name' => ( is_user_logged_in() ) ? $zume_user_meta['zume_full_name'] ?? '' : '',
                    'email' => ( is_user_logged_in() ) ? $zume_user->data->user_email ?? '' : '',
                    'phone' => ( is_user_logged_in() ) ? $zume_user_meta['zume_phone_number'] ?? '' : '',
                    'location_grid_meta' => ( is_user_logged_in() ) ? maybe_unserialize( $zume_user_meta['location_grid_meta'] ) : false,
                    'affiliation_key' => ( is_user_logged_in() ) ? $zume_user_meta['zume_affiliation_key'] ?? '' : '',
                    'facebook_sso_email' => ( is_user_logged_in() ) ? $zume_user_meta['facebook_sso_email'] ?? '' : false,
                    'google_sso_email' => ( is_user_logged_in() ) ? $zume_user_meta['google_sso_email'] ?? '' : false,
                    'zume_global_network' => ( is_user_logged_in() ) ? $zume_user_meta['zume_global_network'] ?? '' : false,
                ],
                'logged_in' => is_user_logged_in(),
                "current_language" => $current_language,
                "current_language_name" => zume_get_english_language_name( $current_language ),
                "languages" => $languages,
                "groups" => ( is_user_logged_in() ) ? Zume_V4_Groups::get_all_groups() : array(),
                "progress" => ( is_user_logged_in() ) ? Zume_V4_Progress::get_user_progress() : array(),
                "invitations" => ( is_user_logged_in() ) ? Zume_V4_Groups::get_colead_groups( 'waiting_acceptance_minimum' ) : array(),
                "zume_network_sites" => ( is_user_logged_in() ) ? Zume_V4_Users::zume_network_sites() : array(),
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
                    ),
                    'str' => array(
                        'x1' => __( 'Members', 'zume' ),
                        'x2' => __( 'Members List (optional)', 'zume' ),
                        'x3' => __( 'Location', 'zume' ),
                        'x4' => __( 'Connection to server failed. Try again.', 'zume' ),
                        'x5' => __( 'Accepted invitation', 'zume' ),
                        'x6' => __( 'Save', 'zume' ),
                        'x7' => __( 'Cancel', 'zume' ),
                        'x8' => __( 'add', 'zume' ),
                        'x9' => __( 'Zoom, click, or search for your location.', 'zume' ),
                        'x10' => __( 'find you current location', 'zume' ),
                        'x11' => __( 'Save Clicked Location', 'zume' ),
                        'x12' => __( 'Save Searched Location', 'zume' ),
                        'x13' => __( 'Save Current Location', 'zume' ),
                        'x14' => __( "You haven't selected anything yet. Click, search, or allow auto location.", 'zume' ),
                        'x15' => __( 'update', 'zume' ),
                        'x16' => __( 'Course Complete', 'zume' ),
                        'x17' => __( 'Next Session', 'zume' ),
                        'x18' => __( 'Archive', 'zume' ),
                        'x19' => __( 'Welcome to Session', 'zume' ),
                        'x20' => __( "You're missing out.", 'zume' ),
                        'x21' => __( 'Register Now!', 'zume' ),
                        'x22' => __( 'track your personal training progress', 'zume' ),
                        'x23' => __( 'access group planning tools', 'zume' ),
                        'x24' => __( 'connect with a coach', 'zume' ),
                        'x25' => __( 'add your effort to the global vision!', 'zume' ),
                        'x26' => __( 'Register for Free', 'zume' ),
                        'x27' => __( 'Login', 'zume' ),
                        'x28' => __( 'Continue', 'zume' ),
                        'x29' => __( 'Not Leading a Group', 'zume' ),
                        'x30' => __( 'Create New Group', 'zume' ),
                        'x31' => __( 'Session', 'zume' ),
                        'x32' => __( 'Which group are you leading?', 'zume' ),
                        'x33' => __( 'Number of Members', 'zume' ),
                        'x34' => __( 'Group Name', 'zume' ),
                        'x35' => __( 'Group addition failed. Try again.', 'zume' ),
                        'x36' => __( 'invites you to join', 'zume' ),
                        'x37' => __( 'Accept', 'zume' ),
                        'x38' => __( 'Decline', 'zume' ),
                        'x39' => __( 'Are you sure you want to archive this group?', 'zume' ),
                        'x40' => __( 'Show Archived Groups', 'zume' ),
                        'x41' => __( 'Re-Activate', 'zume' ),
                        'x42' => __( 'Delete Forever', 'zume' ),
                        'x43' => __( 'Archived Groups', 'zume' ),
                        'x44' => __( 'Close', 'zume' ),
                        'x45' => __( 'Are you sure you want to delete this group?', 'zume' ),
                        'x46' => __( 'Delete Forever', 'zume' ),
                        'x47' => __( 'Progress', 'zume' ),
                        'x48' => __( '32 Tools and Concepts', 'zume' ),
                        'x49' => __( 'Heard', 'zume' ),
                        'x50' => __( 'Obeyed', 'zume' ),
                        'x51' => __( 'Shared', 'zume' ),
                        'x52' => __( 'Trained', 'zume' ),
                        'x53' => __( 'Checklist', 'zume' ),
                        'x54' => __( 'Progress Overview', 'zume' ),
                        'x55' => __( 'There are 32 concepts and tools in Zúme training. Each concept or tool is intended to be practiced personally and trained into others. Use the progression of "heard", "obeyed", "shared", and "trained" as a way of tracking your mastery of the disciple-making training.', 'zume' ),
                        'x56' => __( 'Definitions', 'zume' ),
                        'x57' => __( '"Heard" means you gained awareness. You have moved from not knowing about a tool or concept to knowing about it.', 'zume' ),
                        'x58' => __( '"Obeyed" means you took personal action to practice or apply a concept or tool. Obeying with tools might look like beginning to use them with others, while obeying with concepts might look like changing thinking or priorities.', 'zume' ),
                        'x59' => __( '"Shared" means you helped someone else hear. This step is essential to truly understanding the concept or tool and preparing you to train others.', 'zume' ),
                        'x60' => __( '"Trained" means you coached someone else to hear, obey and share. More than sharing knowledge with someone, you have helped them become a sharer of the tool or concept.', 'zume' ),
                        'x61' => __( 'Connect Me to a Coach', 'zume' ),
                        'x62' => __( 'Coaches', 'zume' ),
                        'x63' => __( 'Our network of volunteer coaches are people like you, people who are passionate about loving God, loving others, and obeying the Great Commission.', 'zume' ),
                        'x64' => __( 'Advocates', 'zume' ),
                        'x65' => __( 'A coach is someone who will come alongside you as you implement the Zúme tools and training.', 'zume' ),
                        'x66' => __( 'Local', 'zume' ),
                        'x67' => __( 'On submitting this request, we will do our best to connect you with a coach near you.', 'zume' ),
                        'x68' => __( 'It\'s Free', 'zume' ),
                        'x69' => __( 'Coaching is free. You can opt out at any time.', 'zume' ),
                        'x70' => __( 'There are some errors in your form.', 'zume' ),
                        'x71' => __( 'Name', 'zume' ),
                        'x72' => __( 'First and last name', 'zume' ),
                        'x73' => __( 'Phone Number', 'zume' ),
                        'x74' => __( 'Email', 'zume' ),
                        'x75' => __( 'Email is required.', 'zume' ),
                        'x76' => __( 'City', 'zume' ),
                        'x77' => __( 'What is your city or state or postal code?', 'zume' ),
                        'x78' => __( 'How should we contact you?', 'zume' ),
                        'x79' => __( 'Text', 'zume' ),
                        'x80' => __( 'Phone', 'zume' ),
                        'x81' => __( 'WhatsApp', 'zume' ),
                        'x82' => __( 'Other', 'zume' ),
                        'x83' => __( 'Affiliation Notes', 'zume' ),
                        'x84' => __( 'On submitting this request, we will do our best to connect you with a coach near you.', 'zume' ),
                        'x85' => __( 'Submit', 'zume' ),
                        'x86' => __( 'You have requested coaching.', 'zume' ),
                        'x87' => __( 'No location matches found. Try a less specific address.', 'zume' ),
                        'x88' => __( 'Oops. Something went wrong. Try again!', 'zume' ),
                        'x89' => __( 'Zúme Network', 'zume' ),
                        'x90' => __( 'Oh snap!', 'zume' ),
                        'x91' => __( 'Click the circles and check off your progress on each of the concepts.', 'zume' ),
                        'x92' => __( 'Archive', 'zume' ),
                        'x93' => __( 'Add Group', 'zume' ),
                        'x94' => __( 'Group Name', 'zume' ),
                        'x95' => __( 'delete', 'zume' ),
                        'x96' => __( 'How can we serve you?', 'zume' ),
                        'x97' => __( 'I want to be coached', 'zume' ),
                        'x98' => __( 'I need technical assistance', 'zume' ),
                        'x99' => __( 'I\'ve gone through the training but need advice on implementation', 'zume' ),
                        'x100' => __( 'I have a question about the content that I need to talk to somebody else about', 'zume' ),
                        'x101' => __( 'I have a group started and need to know where do I go next', 'zume' ),
                        'x102' => __( 'Other', 'zume' ),
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
