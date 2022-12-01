<?php

/**
 * Class Zume_Integration_Hook_Groups
 */


if ( is_admin() ) {
    add_action( 'add_meta_boxes', 'zume_add_resource_hide_section_init' );
    add_action( 'save_post', 'zume_resource_hide_section_save', 9999, 1 );
    function zume_add_resource_hide_section_init() {
        global $post;

        if ( !empty( $post ))
        {
            $page_template = get_post_meta( $post->ID, '_wp_page_template', true );

            if ($page_template == 'template-zume-resources.php' )
            {
                add_meta_box( 'zume_resource_meta_section', 'Hide Default Top of Resource Page', 'zume_resource_hide_section_metabox', 'page', 'normal', 'low' );
            }
        }
    }

    function zume_resource_hide_section_metabox() {
        global $post;

        $checked = get_post_meta( $post->ID, 'zume_resource_hide_section', true );

        ?>
        <select name="zume_resource_hide_section_metabox" id="zume_resource_hide_section_metabox">
            <option value="0" <?php print esc_attr( $checked ? '' : 'selected' ) ?>>Show</option>
            <option value="1" <?php print esc_attr( $checked ? 'selected' : '' )  ?>>Hide</option>
        </select>
        <?php
    }

    function zume_resource_hide_section_save( $post_id ) {
        if ( isset( $_POST['zume_resource_hide_section_metabox'] ) ) {
            if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wpnonce'] ) ) ) ) {
                dt_write_log( __METHOD__ . ': Nonce failure' );
            }

            $checked = sanitize_text_field( wp_unslash( $_POST['zume_resource_hide_section_metabox'] ) );

            $page_template = get_post_meta( $post_id, '_wp_page_template', true );
            if ( $page_template == 'template-zume-resources.php' )
            {
                update_post_meta( $post_id, 'zume_resource_hide_section', $checked );
            }

        }
    }
}