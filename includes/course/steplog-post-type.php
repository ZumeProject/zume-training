<?php

/**
 * Zume_Steplog
 *
 * @class Zume_Steplog
 * @version	0.1
 * @since 0.1
 * @package	Zume
 * @author Chasm.Solutions
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Zume_Steplog {

    /**
     * Disciple_Tools_Admin_Menus The single instance of Disciple_Tools_Admin_Menus.
     * @var 	object
     * @access  private
     * @since 	0.1
     */
    private static $_instance = null;

    /**
     * Main Zume_Steplog Instance
     *
     * Ensures only one instance of Zume_Steplog is loaded or can be loaded.
     *
     * @since 0.1
     * @static
     * @return Zume_Steplog instance
     */
    public static function instance () {
        if ( is_null( self::$_instance ) )
            self::$_instance = new self();
        return self::$_instance;
    } // End instance()

    /**
     * Constructor function.
     * @access  public
     * @since   0.1
     */
    public function __construct () {
        add_action( 'init', array($this, 'zume_steplog_posttype'), 0 );
    } // End __construct()


    /**
     * Register StepLog Post Type
     * @access  public
     * @since   0.1
     */
    function zume_steplog_posttype() {

        $labels = array(
            'name'                  => _x( 'StepLog', 'Post Type General Name', 'zume' ),
            'singular_name'         => _x( 'StepLog', 'Post Type Singular Name', 'zume' ),
            'menu_name'             => __( 'StepLog', 'zume' ),
            'name_admin_bar'        => __( 'StepLog', 'zume' ),
            'archives'              => __( 'StepLog Archives', 'zume' ),
            'attributes'            => __( 'StepLog Attributes', 'zume' ),
            'parent_item_colon'     => __( 'Parent Item:', 'zume' ),
            'all_items'             => __( 'All StepLogs', 'zume' ),
            'add_new_item'          => __( 'Add New StepLog', 'zume' ),
            'add_new'               => __( 'Add New', 'zume' ),
            'new_item'              => __( 'New StepLog', 'zume' ),
            'edit_item'             => __( 'Edit StepLog', 'zume' ),
            'update_item'           => __( 'UpdateStepLog', 'zume' ),
            'view_item'             => __( 'View StepLog', 'zume' ),
            'view_items'            => __( 'ViewStepLog', 'zume' ),
            'search_items'          => __( 'Search StepLog', 'zume' ),
            'not_found'             => __( 'Not found', 'zume' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'zume' ),
            'featured_image'        => __( 'Featured Image', 'zume' ),
            'set_featured_image'    => __( 'Set featured image', 'zume' ),
            'remove_featured_image' => __( 'Remove featured image', 'zume' ),
            'use_featured_image'    => __( 'Use as featured image', 'zume' ),
            'insert_into_item'      => __( 'Insert into StepLog', 'zume' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'zume' ),
            'items_list'            => __( 'StepLogs list', 'zume' ),
            'items_list_navigation' => __( 'StepLogs list navigation', 'zume' ),
            'filter_items_list'     => __( 'Filter StepLogs list', 'zume' ),
        );
        $capabilities = array(
            'edit_post'             => 'edit_steplog',
            'read_post'             => 'read_steplog',
            'delete_post'           => 'delete_steplog',
            'edit_posts'            => 'edit_steplogs',
            'edit_others_posts'     => 'edit_others_steplogs',
            'publish_posts'         => 'publish_steplogs',
            'read_private_posts'    => 'read_private_steplogs',
        );
        $args = array(
            'label'                 => __( 'StepLog', 'zume' ),
            'description'           => __( 'Zúme Step Log for Groups', 'zume' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'excerpt' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 20,
            'menu_icon'             => 'dashicons-analytics',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'rewrite'               => false,
            'capabilities'          => $capabilities,
            'map_meta_cap'          => true,
            'show_in_rest'          => true,
            'rest_base'             => 'steplog',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        );
        register_post_type( 'steplog', $args );

    }

}
