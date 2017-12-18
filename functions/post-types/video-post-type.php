<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly.

/**
 * Zume_Video_Post_Type Post Type Class
 * All functionality pertaining to project update post types in Zume_Video_Post_Type.
 *
 * @package  Disciple_Tools
 * @author   Chasm.Solutions & Kingdom.Training
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
    public function __construct( $post_type = 'zume_video', $singular = 'Video', $plural = 'Videos', $args = [], $taxonomies = [] )
    {
        $this->post_type = $post_type;
        $this->singular = $singular;
        $this->plural = $plural;
        $this->args = $args;
        $this->taxonomies = $taxonomies;

        add_action( 'init', [ $this, 'register_post_type' ] );

        if ( is_admin() ) {
            global $pagenow;

            add_action( 'admin_menu', [ $this, 'meta_box_setup' ], 20 );
            add_action( 'save_post', [ $this, 'meta_box_save' ] );
            add_filter( 'enter_title_here', [ $this, 'enter_title_here' ] );
            add_filter( 'post_updated_messages', [ $this, 'updated_messages' ] );

            if ( $pagenow == 'edit.php' && isset( $_GET['post_type'] ) ) {
                $pt = sanitize_text_field( wp_unslash( $_GET['post_type'] ) );
                if ( $pt === $this->post_type ) {
                    add_filter( 'manage_edit-' . $this->post_type . '_columns', [ $this, 'register_custom_column_headings' ], 10, 1 );
                    add_action( 'manage_posts_custom_column', [ $this, 'register_custom_columns' ], 10, 2 );
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
    public function register_post_type()
    {
        register_post_type( $this->post_type, /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
            // let's now add all the options for this post type
            array(
            'labels' => array(
                'name' => __( 'Zume Video', 'zume' ), /* This is the Title of the Group */
                'singular_name' => __( 'Zume Video', 'zume' ), /* This is the individual type */
                'all_items' => __( 'All Zume Videos', 'zume' ), /* the all items menu item */
                'add_new' => __( 'Add New', 'zume' ), /* The add new menu item */
                'add_new_item' => __( 'Add New Zume Video', 'zume' ), /* Add New Display Title */
                'edit' => __( 'Edit', 'zume' ), /* Edit Dialog */
                'edit_item' => __( 'Edit Zume Video', 'zume' ), /* Edit Display Title */
                'new_item' => __( 'New Zume Video', 'zume' ), /* New Display Title */
                'view_item' => __( 'View Zume Video', 'zume' ), /* View Display Title */
                'search_items' => __( 'Search Zume Videos', 'zume' ), /* Search Custom Type Title */
                'not_found' => __( 'Nothing found in the Database.', 'zume' ), /* This displays if there are no entries yet */
                'not_found_in_trash' => __( 'Nothing found in Trash', 'zume' ), /* This displays if there is nothing in the trash */
                'parent_item_colon' => ''
            ), /* end of arrays */
                  'description' => __( 'Zume video catalog for language videos', 'zume' ), /* Custom Type Description */
                  'public' => false,
                  'publicly_queryable' => false,
                  'exclude_from_search' => true,
                  'show_ui' => true,
                  'query_var' => true,
                  'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
                  'menu_icon' => 'dashicons-book', /* the icon for the custom post type menu. uses built-in dashicons (CSS class name) */
                  'rewrite' => array( 'slug' => 'zume_video', 'with_front' => false ), /* you can specify its url slug */
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
    public function register_custom_columns( $column_name )
    {
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
    public function register_custom_column_headings( $defaults )
    {

        $new_columns = []; //array( 'image' => __( 'Image', 'zume' ));

        $last_item = [];

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
    public function updated_messages( $messages )
    {
        global $post;

        $messages[ $this->post_type ] = [
            0  => '', // Unused. Messages start at index 1.
            1  => sprintf(
                __( '%3$s updated. %1$sView %4$s%2$s', 'zume' ),
                '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">',
                '</a>',
                $this->singular,
                strtolower( $this->singular )
            ),
            2  => __( 'Zume Video updated.', 'zume' ),
            3  => __( 'Zume Video deleted.', 'zume' ),
            4  => sprintf( __( '%s updated.', 'zume' ), $this->singular ),
            /* translators: %s: date and time of the revision */
            5  => isset( $_GET['revision'] ) ? sprintf( __( '%1$s restored to revision from %2$s', 'zume' ), $this->singular, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => sprintf( __( '%1$s published. %3$sView %2$s%4$s', 'zume' ), $this->singular, strtolower( $this->singular ), '<a href="' . esc_url( get_permalink( $post->ID ) ) . '">', '</a>' ),
            7  => sprintf( __( '%s saved.', 'zume' ), $this->singular ),
            8  => sprintf( __( '%1$s submitted. %2$sPreview %3$s%4$s', 'zume' ), $this->singular, strtolower( $this->singular ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) . '">', '</a>' ),
            9  => sprintf(
                __( '%1$s scheduled for: %1$s. %2$sPreview %2$s%3$6$s', 'zume' ),
                $this->singular,
                strtolower( $this->singular ),
                // translators: Publish box date format, see http://php.net/date
                '<strong>' . date_i18n( __( 'M j, Y @ G:i' ),
                strtotime( $post->post_date ) ) . '</strong>',
                '<a target="_blank" href="' . esc_url( get_permalink( $post->ID ) ) . '">',
                '</a>'
            ),
            10 => sprintf( __( '%1$s draft updated. %2$sPreview %3$s%4$s', 'zume' ), $this->singular, strtolower( $this->singular ), '<a target="_blank" href="' . esc_url( add_query_arg( 'preview', 'true', get_permalink( $post->ID ) ) ) . '">', '</a>' ),
        ];

        return $messages;
    } // End updated_messages()

    /**
     * Setup the meta box.
     *
     * @access public
     * @since  0.1.0
     * @return void
     */
    public function meta_box_setup()
    {
        add_meta_box( $this->post_type . '_scribes', __( 'Video Scribes', 'zume' ), array( $this, 'load_video_meta_box' ), $this->post_type, 'normal', 'high' );
        add_meta_box( $this->post_type . '_toolkit', __( 'Audio Toolkit', 'zume' ), array( $this, 'load_audio_meta_box' ), $this->post_type, 'normal', 'high' );
    } // End meta_box_setup()

    /**
     * Meta box for Status Information
     *
     * @access public
     * @since  0.1.0
     */
    public function load_video_meta_box()
    {
        echo 'These numeric ids below refer to the unique Vimeo id. It should work with the url "https://player.vimeo.com/video/{put_video_id_here}". Use the "verify link" to check if the video loads correctly.<br><br>The page title above needs to be the two character language code.<br><hr>';
        $this->meta_box_content( 'scribe' ); // prints
    }

    /**
     * Meta box for Status Information
     *
     * @access public
     * @since  0.1.0
     */
    public function load_audio_meta_box()
    {
        echo 'These numeric ids below refer to the unique Vimeo id. <br>';
        $this->meta_box_content( 'toolkit' ); // prints
    }

    /**
     * The contents of our meta box.
     *
     * @param string $section
     */
    public function meta_box_content( $section = 'scribe' )
    {
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
                            echo '</td><tr/>' . "\n";
                            break;
                        case 'text':
                            echo '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . esc_html( $v['name'] ) . '</label></th>
                                <td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
                            echo '<p class="description">' . esc_html( $v['description'] ) . '</p>' . "\n";
                            echo '</td><tr/>' . "\n";
                            break;
                        case 'link':
                            echo '<tr valign="top"><th scope="row"><label for="' . esc_attr( $k ) . '">' . esc_html( $v['name'] ) . '</label></th>
                                <td><input name="' . esc_attr( $k ) . '" type="text" id="' . esc_attr( $k ) . '" class="regular-text" value="' . esc_attr( $data ) . '" />' . "\n";
                            $video_id = esc_attr( $k ) .'video';
                            echo '<p class="description"><a onclick="show_video( \'' . esc_attr( $video_id ) . '\', \'' . esc_attr( $data ) . '\' )">verify link</a><span id="'. esc_attr( $video_id ) .'"></span></p>' . "\n";
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
                            echo '</td><tr/>' . "\n";
                            break;

                        default:
                            break;
                    }
                }
            }
            echo '</tbody>' . "\n";
            echo '</table>' . "\n";
            echo "<script>
                    function show_video( block, id ) {
                        jQuery( '#' + block ).append('<iframe src=\"https://player.vimeo.com/video/' + id + '\" width=\"340\" height=\"160\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe><p><a onclick=\"jQuery(\'#' + block + '\').empty();\">Close video</a></p>')
                    }
                    </script>";
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
    public function meta_box_save( $post_id )
    {

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
    public function enter_title_here( $title )
    {
        if ( get_post_type() == $this->post_type ) {
            $title = __( 'Enter the title here', 'zume' );
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
    public function get_custom_fields_settings()
    {
        $fields = [];

        // Project Update Information Section
        $fields['promo'] = [
            'name'        => 'Promo',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'scribe',
        ];
        $fields['overview'] = [
            'name'        => 'Overview',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'scribe',
        ];
        $fields['intro'] = [
            'name'        => 'Intro',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'scribe',
        ];
        $fields['scribe_1'] = [
            'name'        => 'Welcome to Zume (scribe_1)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247062938',
            'section'     => 'scribe',
        ];
        $fields['scribe_2'] = [
            'name'        => 'Teach them to Obey (scribe_2)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247382094',
            'section'     => 'scribe',
        ];
        $fields['scribe_3'] = [
            'name'        => 'Spiritual Breathing (scribe_3)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247382094', // todo upload this video and get the right id
            'section'     => 'scribe',
        ];
        $fields['scribe_4'] = [
            'name'        => 'Producers vs Consumers (scribe_4)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247063338',
            'section'     => 'scribe',
        ];
        $fields['scribe_5'] = [
            'name'        => 'Greatest Blessing (scribe_5)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247063777',
            'section'     => 'scribe',
        ];
        $fields['scribe_6'] = [
            'name'        => 'Spiritual Economy (scribe_6)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247064680',
            'section'     => 'scribe',
        ];
        $fields['scribe_7'] = [
            'name'        => 'The Gospel (scribe_7)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247064875',
            'section'     => 'scribe',
        ];
        $fields['scribe_8'] = [
            'name'        => 'Eyes to See (scribe_8)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247065338',
            'section'     => 'scribe',
        ];
        $fields['scribe_9'] = [
            'name'        => 'Faithfulness (scribe_9)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247065912',
            'section'     => 'scribe',
        ];
        $fields['scribe_10'] = [
            'name'        => 'Training Cycle (scribe_10)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247066070',
            'section'     => 'scribe',
        ];
        $fields['scribe_11'] = [
            'name'        => 'Leadership Cells (scribe_11)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247376979',
            'section'     => 'scribe',
        ];
        $fields['scribe_12'] = [
            'name'        => 'Non-Sequential (scribe_12)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247377353',
            'section'     => 'scribe',
        ];
        $fields['scribe_13'] = [
            'name'        => 'Pace (scribe_13)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247076726',
            'section'     => 'scribe',
        ];
        $fields['scribe_14'] = [
            'name'        => 'Part of Two Churches (scribe_14)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247077391',
            'section'     => 'scribe',
        ];
        $fields['scribe_15'] = [
            'name'        => 'Leadership in Networks (scribe_15)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247077671',
            'section'     => 'scribe',
        ];
        $fields['scribe_16'] = [
            'name'        => 'Completion of Training (scribe_16)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247078031',
            'section'     => 'scribe',
        ];
        $fields['scribe_17'] = [
            'name'        => 'Duckling Discipleship (scribe_17)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247378271',
            'section'     => 'scribe',
        ];
        $fields['scribe_18'] = [
            'name'        => 'Person of Peace (scribe_18)',
            'description' => '',
            'type'        => 'link',
            'default'     => '247382094', // todo upload this video and get the right id
            'section'     => 'scribe',
        ];

        /* Toolkit */
        $fields['toolkit_1'] = [
            'name'        => 'SOAPS (toolkit_1)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_2'] = [
            'name'        => 'Accountability Groups (toolkit_2)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_3'] = [
            'name'        => 'Prayer Cycle (toolkit_3)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_4'] = [
            'name'        => 'List of 100 (toolkit_4)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_5'] = [
            'name'        => '3 Minute Testimony (toolkit_5)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_6'] = [
            'name'        => 'Baptism (toolkit_6)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_7'] = [
            'name'        => 'God\'s Story (toolkit_7)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_8'] = [
            'name'        => 'Prayer Walking (toolkit_8)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_9'] = [
            'name'        => 'Lord\'s Supper (toolkit_9)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_10'] = [
            'name'        => '3|3 Groups (toolkit_10)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_11'] = [
            'name'        => 'Peer Mentoring (toolkit_11)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_12'] = [
            'name'        => 'Leadership Cell (toolkit_12)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];
        $fields['toolkit_13'] = [
            'name'        => 'Coaching Checklist (toolkit_13)',
            'description' => '',
            'type'        => 'link',
            'default'     => '245293029',
            'section'     => 'toolkit',
        ];



        return apply_filters( 'zume_video_fields_settings', $fields );
    } // End get_custom_fields_settings()

    /**
     * Run on activation.
     *
     * @access public
     * @since  0.1.0
     */
    public function activation()
    {
        $this->flush_rewrite_rules();
    } // End activation()

    /**
     * Flush the rewrite rules
     *
     * @access public
     * @since  0.1.0
     */
    private function flush_rewrite_rules()
    {
        $this->register_post_type();
        flush_rewrite_rules();
    } // End flush_rewrite_rules()

} // End Class
Zume_Video_Post_Type::instance();