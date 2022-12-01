<?php

function add_template_column( $cols ) {
    $cols['template'] = 'Template';
    return $cols;
}
add_filter( 'manage_pages_columns', 'add_template_column' );

function add_template_value( $column_name, $post_id ) {
    if ( 'template' === $column_name ) {
        $template = get_post_meta( $post_id, '_wp_page_template', true );
        if ( isset( $template ) && $template ) {
            echo esc_html( $template );
        } else {
            echo 'None';
        }
    }
}
add_action( 'manage_pages_custom_column', 'add_template_value', 10, 2 );

