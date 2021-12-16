<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

/**
 * Zume_Video_Post_Type Post Type Class
 * All functionality pertaining to project update post types in Zume_Video_Post_Type.
 *
 * @package  Disciple_Tools
 * @since    0.1.0
 */
class Zume_Video_Post_Type
{
    /**
     * The post type token.
     *
     * @access public
     * @since  0.1.0
     * @var    string
     */
    public $post_type;

    /**
     * The post type singular label.
     *
     * @access public
     * @since  0.1.0
     * @var    string
     */
    public $singular;

    /**
     * The post type plural label.
     *
     * @access public
     * @since  0.1.0
     * @var    string
     */
    public $plural;

    /**
     * The post type args.
     *
     * @access public
     * @since  0.1.0
     * @var    array
     */
    public $args;

    /**
     * The taxonomies for this post type.
     *
     * @access public
     * @since  0.1.0
     * @var    array
     */
    public $taxonomies;

    /**
     * Zume_Video_Post_Type The single instance of Zume_Video_Post_Type.
     * @var     object
     * @access  private
     * @since   0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Video_Post_Type Instance
     *
     * Ensures only one instance of Zume_Video_Post_Type is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Video_Post_Type instance
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    } // End instance()

    /**
     * Disciple_Tools_Prayer_Post_Type constructor.
     *
     * @param string $post_type
     * @param string $singular
     * @param string $plural
     * @param array  $args
     * @param array  $taxonomies
     */
    public function __construct( $post_type = 'zume_video', $singular = 'Video', $plural = 'Videos', $args = array(), $taxonomies = array() ) {
        $this->post_type = $post_type;
        $this->singular = $singular;
        $this->plural = $plural;
        $this->args = $args;
        $this->taxonomies = $taxonomies;

        add_action( 'init', array( $this, 'register_post_type' ) );

        if ( is_admin() ) {
            global $pagenow;

            add_action( 'admin_menu', array( $this, 'meta_box_setup' ), 20 );
            add_action( 'save_post', array( $this, 'meta_box_save' ) );
            add_filter( 'enter_title_here', array( $this, 'enter_title_here' ) );
            add_filter( 'post_updated_messages', array( $this, 'updated_messages' ) );

            if ( $pagenow == 'edit.php' && isset( $_GET['post_type'] ) ) {
                $pt = sanitize_text_field( wp_unslash( $_GET['post_type'] ) );
                if ( $pt === $this->post_type ) {
                    add_filter( 'manage_edit-' . $this->post_type . '_columns', array( $this, 'register_custom_column_headings' ), 10, 1 );
                    add_action( 'manage_posts_custom_column', array( $this, 'register_custom_columns' ), 10, 2 );
                }
            }
        }
    } // End __construct()

    /**
     * Register the post type.
     *
     * @access public
     * @return void
     */
    public function register_post_type() {
        register_post_type( $this->post_type, /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
            // let's now add all the options for this post type
            array(
            'labels' => array(
                'name' => 'Zume Video', /* This is the Title of the Group */
                'singular_name' => 'Zume Video', /* This is the individual type */
                'all_items' => 'All Zume Videos', /* the all items menu item */
                'add_new' => 'Add New', /* The add new menu item */
                'add_new_item' => 'Add New Zume Video', /* Add New Display Title */
                'edit' => 'Edit', /* Edit Dialog */
                'edit_item' => 'Edit Zume Video', /* Edit Display Title */
                'new_item' => 'New Zume Video', /* New Display Title */
                'view_item' => 'View Zume Video', /* View Display Title */
                'search_items' => 'Search Zume Videos', /* Search Custom Type Title */
                'not_found' => 'Nothing found in the Database.', /* This displays if there are no entries yet */
                'not_found_in_trash' => 'Nothing found in Trash', /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
                  'description' => 'Zume video catalog for language videos', /* Custom Type Description */
                  'public' => false,
                  'publicly_queryable' => false,
                  'exclude_from_search' => true,
                  'show_ui' => true,
                  'query_var' => true,
                  'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
                  'menu_icon' => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
                  'rewrite' => array(
            'slug' => 'zume_video',
            'with_front' => false
            ), /* you can specify its url slug */
                  'has_archive' => 'zume_video', /* you can rename the slug here */
                  'capability_type' => 'post',
                  'hierarchical' => false,
                /* the next one is important, it tells what's enabled in the post editor */
                  'supports' => array( 'title' )
            ) /* end of options */
        ); /* end of register post type */
    } // End register_post_type()


    /**
     * Add custom columns for the "manage" screen of this post type.
     *
     * @access public
     *
     * @param  string $column_name
     *
     * @since  0.1.0
     * @return void
     */
    public function register_custom_columns( $column_name ) {
//        global $post;

        switch ( $column_name ) {
            case 'image':
                break;
            case 'phone':
                echo '';
                break;

            default:
                break;
        }
    }

    /**
     * Add custom column headings for the "manage" screen of this post type.
     *
     * @access public
     *
     * @param  array $defaults
     *
     * @since  0.1.0
     * @return mixed/void
     */
    public function register_custom_column_headings( $defaults ) {

        $new_columns = array(); //array( 'image' => __( 'Image', 'zume' ));

        $last_item = array();

        if ( count( $defaults ) > 2 ) {
            $last_item = array_slice( $defaults, -1 );

            array_pop( $defaults );
        }
        $defaults = array_merge( $defaults, $new_columns );

        if ( is_array( $last_item ) && 0 < count( $last_item ) ) {
            foreach ( $last_item as $k => $v ) {
                $defaults[ $k ] = $v;
                break;
            }
        }

        return $defaults;
    } // End register_custom_column_headings()

    /**
     * Update messages for the post type admin.
     *
     * @since  0.1.0
     *
     * @param  array $messages Array of messages for all post types.
     *
     * @return array           Modified array.
     */
    public function updated_messages( $messages ) {
        global $post;

        $messages[ $this->post_type ] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => sprintf(
                '%3$s updated. %1$sView %4$s%2$s',
                '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">',
                '</a>',
                $this->singular,
                strtolower( $this->singular )
            ),
            2  => 'Zume Video updated.',
            3  => 'Zume Video deleted.',
            4  => sprintf( '%s updated.', $this->singular ),
            /* translators: %s: date and time of the revision */
            5  => isset( $_GET['revision'] ) ? sprintf( '%1$s restored to revision from %2$s', $this->singular, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => sprintf( '%1$s published. %3$sView %2$s%4$s', $this->singular, strtolower( $this->singular ), '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">', '</a>' ),
            7  => sprintf( '%s saved.', $this->singular ),
            8  => sprintf( '%1$s submitted. %2$sPreview %3$s%4$s', $this->singular, strtolower( $this->singular ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) . '">', '</a>' ),
            9  => sprintf(
                '%1$s scheduled for: %2$s. %3$s Preview %4$s',
                strtolower( $this->singular ),
                // translators: Publish box date format, see http://php.net/date
                '<strong>' . date_i18n(  'M j, Y @ G:i',
                strtotime( $post->post_date ) ) . '</strong>',
                '<a target="_blank" href="' . esc_url( get_permalink( $post->ID ) ) . '">',
                '</a>'
            ),
            10 => sprintf( '%1$s draft updated. %2$sPreview %3$s%4$s', $this->singular, strtolower( $this->singular ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) . '">', '</a>' ),
        );

        return $messages;
    } // End updated_messages()

    /**
     * Setup the meta box.
     *
     * @access public
     * @since  0.1.0
     * @return void
     */
    public function meta_box_setup() {
        add_meta_box( $this->post_type . '_scribes', 'Video Scribes', array( $this, 'load_video_meta_box' ), $this->post_type, 'normal', 'high' );
    } // End meta_box_setup()

    /**
     * Meta box for Status Information
     *
     * @access public
     * @since  0.1.0
     */
    public function load_video_meta_box() {
        ?>
        These numeric ids below refer to the unique Vimeo id. It should work with the url "https://player.vimeo.com/video/{put_video_id_here}". Use the "verify link" to check if the video loads correctly.<br>The page title above needs to be the two character language code.<br><br>
        <a id="show-hide-qr" class="button" onclick="show_hide_qr()" data-state="off">Show/Hide QR Codes</a> <a id="show-hide-videos" class="button" onclick="show_hide_videos()" data-state="off">Show/Hide Videos</a>
        <hr>
        <?php

        $this->meta_box_content( 'scribe' ); // prints

        ?>
        <style>
            .active-spinner {
                background: url( "<?php echo get_stylesheet_directory_uri() ?>/spinner.svg") no-repeat;
                background-size: 24px 24px;
                background-position-x: 50%;
                background-position-y: 50%;
            }
        </style>
        <script>
            function show_hide_qr() {
                let qr_raw_link = '<?php echo get_stylesheet_directory_uri() . '/video.php?id='; ?>'
                let qr_link = '<?php echo urlencode( get_stylesheet_directory_uri() . '/video.php?id=' ); ?>'
                let button = jQuery('#show-hide-qr')
                let state = button.data('state')
                let list = jQuery('.viewer-cell')
                if ( 'off' === state ) {
                    // console.log('Turning on qr')
                    button.data('state', 'on')
                    jQuery.each(list, function(i,v){
                        if ( v.id ) {
                            let cell = jQuery('#'+v.id)
                            cell.addClass('active-spinner')
                            cell.html(`<img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&color=323a68&data=${qr_link}${v.id}" title="${qr_raw_link}${v.id}" alt="${qr_raw_link}${v.id}" /><br><a href="https://api.qrserver.com/v1/create-qr-code/?size=300x300&color=323a68&data=${qr_link}${v.id}">direct link</a>`)
                        }
                    })
                }
                else {
                    // console.log('Turning off qr')
                    button.data('state', 'off')
                    list.empty()
                    list.removeClass('active-spinner')
                }
            }
            function show_hide_videos() {
                let button = jQuery('#show-hide-videos')
                let state = button.data('state')
                let list = jQuery('.viewer-cell')
                if ( 'off' === state ) {
                    // console.log('Turning on videos')
                    button.data('state', 'on')
                    jQuery.each(list, function(i,v){
                        if ( v.id ) {
                            let cell = jQuery('#'+v.id)
                            cell.html(`<iframe src="https://player.vimeo.com/video/${v.id}" width="340" height="160" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>`)
                        }
                    })
                }
                else {
                    // console.log('Turning off videos')
                    button.data('state', 'off')
                    list.empty()
                    list.removeClass('active-spinner')
                }
            }
        </script>
        <?php
    }

    /**
     * Meta box for Status Information
     *
     * @access public
     * @since  0.1.0
     */
    public function load_alt_video_meta_box() {
        echo 'These boxes include full URLs. <br>';
        $this->meta_box_content( 'alt_video' ); // prints
    }

    /**
     * The contents of our meta box.
     *
     * @param string $section
     */
    public function meta_box_content( $section = 'scribe' ) {
        global $post_id;
        $fields = get_post_custom( $post_id );
        $field_data = $this->get_custom_fields_settings();

        echo '<input type="hidden" name="' . esc_attr( $this->post_type ) . '_noonce" id="' . esc_attr( $this->post_type ) . '_noonce" value="' . esc_attr( wp_create_nonce( 'video_noonce_action' ) ) . '" />';

        if ( 0 < count( $field_data ) ) {
            echo '<table class="form-table">' . "\n";
            echo '<tbody>' . "\n";

            foreach ( $field_data as $k => $v ) {

                if ( $v['section'] == $section ) {

                    $data = $v['default'];
                    if ( isset( $fields[ $k ] ) && isset( $fields[ $k ][0] ) ) {
                        $data = $fields[ $k ][0];
                    }

                    $type = $v['type'];

                    switch ( $type ) {

                        case 'url':
                            echo '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . esc_html( $v['name'] ) . '</label></th><td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
                            echo '<p class="description">' . esc_html( $v['description'] ) . '</p>' . "\n";
                            echo '</td><td>';
                            echo '';
                            echo '</td><tr/>' . "\n";
                            break;
                        case 'text':
                            echo '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . esc_html( $v['name'] ) . '</label></th>
                                <td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
                            echo '<p class="description">' . esc_html( $v['description'] ) . '</p>' . "\n";
                            echo '</td><td>';
                            echo '';
                            echo '</td><tr/>' . "\n";
                            break;
                        case 'link':
                            $qr_raw_link = get_stylesheet_directory_uri() . '/video.php?id='  . esc_attr( $data );
                            $qr_link = urlencode( get_stylesheet_directory_uri() . '/video.php?id='  . esc_attr( $data ) );
                            echo '<tr style="vertical-align:top;"><th scope="row"><label for="' . esc_attr( $k ) . '">' . esc_html( $v['name'] ) . '</label></th>
                                <td style="vertical-align:top;"><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
                            $video_id = esc_attr( $k ) .'video';

                            if ( $data && false ) {
                                echo 'QR Code for Independent Viewing<br>';
                                echo '<img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&color=323a68&data=' . $qr_link . '" name="' . esc_attr( $data ) . '" /><br>';
                                echo 'Links To<br>';
                                echo '<a href="' . $qr_raw_link . '">' . $qr_raw_link .'</a>';
                            }
                            echo '</td><td id="'.esc_attr( $data ).'" class="viewer-cell" data-value="'.esc_attr( $data ).'">';
                            echo '';
                            echo '</td><tr/>' . "\n";
                            break;
                        case 'alt_link':
                            echo '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . esc_html( $v['name'] ) . '</label></th>
                                <td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
                            $video_id = esc_attr( $k ) .'video';
                            echo '<p class="description"><a onclick="show_alt_video( \'' . esc_attr( $video_id ) . '\', \'' . esc_attr( $data ) . '\' )">verify link</a><span id="'. esc_attr( $video_id ) .'"></span></p>' . "\n";
                            echo '</td><td>';
                            echo '';
                            echo '</td><tr/>' . "\n";
                            break;
                        case 'select':
                            echo '<tr valign="top"><th scope="row">
                                <label for="' . esc_attr( $k ) . '">' . esc_html( $v['name'] ) . '</label></th>
                                <td>
                                <select name="' . esc_attr( $k ) . '" id="' . esc_attr( $k ) . '" class="regular-text">';
                            // Iterate the options
                            foreach ( $v['default'] as $vv ) {
                                echo '<option value="' . esc_attr( $vv ) . '" ';
                                if ( $vv == $data ) {
                                    echo 'selected';
                                }
                                echo '>' . esc_html( $vv ) . '</option>';
                            }
                            echo '</select>' . "\n";
                            echo '<p class="description">' . esc_html( $v['description'] ) . '</p>' . "\n";
                            echo '</td><td>';
                            echo '';
                            echo '</td><tr/>' . "\n";
                            break;

                        default:
                            break;
                    }
                }
            }
            echo '</tbody>' . "\n";
            echo '</table>' . "\n";
        }
    } // End meta_box_content()

    /**
     * Save meta box fields.
     *
     * @access public
     * @since  0.1.0
     *
     * @param  int $post_id
     *
     * @return int $post_id
     */
    public function meta_box_save( $post_id ) {

        // Verify
        if ( get_post_type() != $this->post_type ) {
            return $post_id;
        }

        $key = $this->post_type . '_noonce';
        if ( isset( $_POST[ $key ] ) && !wp_verify_nonce( sanitize_key( $_POST[ $key ] ), 'video_noonce_action' ) ) {
            return $post_id;
        }

        if ( isset( $_POST['post_type'] ) && 'page' == sanitize_text_field( wp_unslash( $_POST['post_type'] ) ) ) {
            if ( !current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
        } else {
            if ( !current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        if ( isset( $_GET['action'] ) ) {
            if ( $_GET['action'] == 'trash' || $_GET['action'] == 'untrash' || $_GET['action'] == 'delete' ) {
                return $post_id;
            }
        }

        $field_data = $this->get_custom_fields_settings();
        $fields = array_keys( $field_data );

        foreach ( $fields as $f ) {
            if ( !isset( $_POST[ $f ] ) ) {
                continue;
            }

            ${$f} = strip_tags( trim( sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) ) );

            // Escape the URLs.
            if ( 'url' == $field_data[ $f ]['type'] ) {
                ${$f} = esc_url( ${$f} );
            }

            if ( get_post_meta( $post_id, $f ) == '' ) {
                add_post_meta( $post_id, $f, ${$f}, true );
            } elseif ( ${$f} != get_post_meta( $post_id, $f, true ) ) {
                update_post_meta( $post_id, $f, ${$f} );
            } elseif ( ${$f} == '' ) {
                delete_post_meta( $post_id, $f, get_post_meta( $post_id, $f, true ) );
            }
        }
        return $post_id;
    } // End meta_box_save()



    /**
     * Customise the "Enter title here" text.
     *
     * @access public
     * @since  0.1.0
     *
     * @param  string $title
     *
     * @return string
     */
    public function enter_title_here( $title ) {
        if ( get_post_type() == $this->post_type ) {
            $title = 'Enter the title here';
        }

        return $title;
    } // End enter_title_here()

    /**
     * Get the settings for the custom fields.
     *
     * @access public
     * @since  0.1.0
     * @return array
     */
    public function get_custom_fields_settings() {
        $fields = array();

        $fields['1'] = array(
            'name'        => 'Welcome to Zume (1)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247062938',
            'section'     => 'scribe',
        );
        $fields['2'] = array(
            'name'        => 'Teach them to Obey (2)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247382094',
            'section'     => 'scribe',
        );
        $fields['3'] = array(
            'name'        => 'Spiritual Breathing (3)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247063777',
            'section'     => 'scribe',
        );
        $fields['4'] = array(
            'name'        => 'S.O.A.P.S. (4)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248176918',
            'section'     => 'scribe',
        );
        $fields['5'] = array(
            'name'        => 'Accountability Groups (5)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248177083',
            'section'     => 'scribe',
        );
        $fields['6'] = array(
            'name'        => 'Producers vs Consumers (6)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247063338',
            'section'     => 'scribe',
        );
        $fields['7'] = array(
            'name'        => 'Prayer Cycle (7)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248177053',
            'section'     => 'scribe',
        );
        $fields['8'] = array(
            'name'        => 'List of 100 (8)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248177079',
            'section'     => 'scribe',
        );
        $fields['9'] = array(
            'name'        => 'Spiritual Economy (9)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247064680',
            'section'     => 'scribe',
        );
        $fields['10'] = array(
            'name'        => 'The Gospel (10)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247064875',
            'section'     => 'scribe',
        );
        $fields['11'] = array(
            'name'        => 'Baptism (11)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248150621',
            'section'     => 'scribe',
        );
        $fields['12'] = array(
            'name'        => '3 Minute Testimony (12)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248177254',
            'section'     => 'scribe',
        );
        $fields['13'] = array(
            'name'        => 'Greatest Blessing (13)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247064323',
            'section'     => 'scribe',
        );
        $fields['14'] = array(
            'name'        => 'Duckling Discipleship (14)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247378271',
            'section'     => 'scribe',
        );
        $fields['15'] = array(
            'name'        => 'Eyes to See (15)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247065338',
            'section'     => 'scribe',
        );
        $fields['16'] = array(
            'name'        => 'Lord\'s Supper (16)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248150969',
            'section'     => 'scribe',
        );
        $fields['17'] = array(
            'name'        => 'Prayer Walking (17)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248150722',
            'section'     => 'scribe',
        );
        $fields['18'] = array(
            'name'        => 'Person of Peace (18)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248149796',
            'section'     => 'scribe',
        );
        $fields['19'] = array(
            'name'        => 'Faithfulness (19)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247065912',
            'section'     => 'scribe',
        );
        $fields['20'] = array(
            'name'        => '3|3 Groups (20)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248184750',
            'section'     => 'scribe',
        );
        $fields['21'] = array(
            'name'        => '3|3 Group Live (21)',
            'description' => '',
            'type'        => 'link',
            'default'     => '249724003',
            'section'     => 'scribe',
        );
        $fields['22'] = array(
            'name'        => 'Training Cycle (22)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247066070',
            'section'     => 'scribe',
        );
        $fields['23'] = array(
            'name'        => 'Leadership Cells (23)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247376979',
            'section'     => 'scribe',
        );
        $fields['24'] = array(
            'name'        => 'Non-Sequential (24)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247377353',
            'section'     => 'scribe',
        );
        $fields['25'] = array(
            'name'        => 'Pace (25)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247076726',
            'section'     => 'scribe',
        );
        $fields['26'] = array(
            'name'        => 'Part of Two Churches (26)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247077391',
            'section'     => 'scribe',
        );
        $fields['27'] = array(
            'name'        => 'Completion of Training (27)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247078031',
            'section'     => 'scribe',
        );
        $fields['28'] = array(
            'name'        => 'Coaching Checklist (28)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248150334',
            'section'     => 'scribe',
        );
        $fields['29'] = array(
            'name'        => 'Leadership in Networks (29)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247077671',
            'section'     => 'scribe',
        );
        $fields['30'] = array(
            'name'        => 'Peer Mentoring (30)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248150042',
            'section'     => 'scribe',
        );
        $fields['31'] = array(
            'name'        => 'Overview (31)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248149800',
            'section'     => 'scribe',
        );
        $fields['32'] = array(
            'name'        => 'How Zume Works (32)',
            'description' => '',
            'type'        => 'link',
            'default'     => '248149797',
            'section'     => 'scribe',
        );
        $fields['68'] = array(
            'name'        => 'Four Relationships (68)',
            'description' => '',
            'type'        => 'link',
            'default'     => '',
            'section'     => 'scribe',
        );

        /**
         * Alternate Video
         */

//        $fields['alt_1'] = array(
//            'name'        => 'Welcome to Zume (1)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_2'] = array(
//            'name'        => 'Teach them to Obey (2)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_3'] = array(
//            'name'        => 'Spiritual Breathing (3)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_4'] = array(
//            'name'        => 'S.O.A.P.S. (4)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_5'] = array(
//            'name'        => 'Accountability Groups (5)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_6'] = array(
//            'name'        => 'Producers vs Consumers (6)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_7'] = array(
//            'name'        => 'Prayer Cycle (7)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_8'] = array(
//            'name'        => 'List of 100 (8)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_9'] = array(
//            'name'        => 'Spiritual Economy (9)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_10'] = array(
//            'name'        => 'The Gospel (10)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_11'] = array(
//            'name'        => 'Baptism (11)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_12'] = array(
//            'name'        => '3 Minute Testimony (12)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_13'] = array(
//            'name'        => 'Greatest Blessing (13)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_14'] = array(
//            'name'        => 'Duckling Discipleship (14)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_15'] = array(
//            'name'        => 'Eyes to See (15)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_16'] = array(
//            'name'        => 'Lord\'s Supper (16)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_17'] = array(
//            'name'        => 'Prayer Walking (17)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_18'] = array(
//            'name'        => 'Person of Peace (18)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_19'] = array(
//            'name'        => 'Faithfulness (19)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_20'] = array(
//            'name'        => '3|3 Groups (20)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_21'] = array(
//            'name'        => '3|3 Group Live (21)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_22'] = array(
//            'name'        => 'Training Cycle (22)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_23'] = array(
//            'name'        => 'Leadership Cells (23)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_24'] = array(
//            'name'        => 'Non-Sequential (24)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_25'] = array(
//            'name'        => 'Pace (25)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_26'] = array(
//            'name'        => 'Part of Two Churches (26)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_27'] = array(
//            'name'        => 'Completion of Training (27)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_28'] = array(
//            'name'        => 'Coaching Checklist (28)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_29'] = array(
//            'name'        => 'Leadership in Networks (29)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_30'] = array(
//            'name'        => 'Peer Mentoring (30)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_31'] = array(
//            'name'        => 'Overview (31)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );
//        $fields['alt_32'] = array(
//            'name'        => 'How Zume Works (32)',
//            'description' => '',
//            'type'        => 'alt_link',
//            'default'     => '',
//            'section'     => 'alt_video',
//        );


        return apply_filters( 'zume_video_fields_settings', $fields );
    } // End get_custom_fields_settings()

    /**
     * Run on activation.
     *
     * @access public
     * @since  0.1.0
     */
    public function activation() {
        $this->flush_rewrite_rules();
    } // End activation()

    /**
     * Flush the rewrite rules
     *
     * @access public
     * @since  0.1.0
     */
    private function flush_rewrite_rules() {
        $this->register_post_type();
        flush_rewrite_rules();
    } // End flush_rewrite_rules()

} // End Class
Zume_Video_Post_Type::instance();
