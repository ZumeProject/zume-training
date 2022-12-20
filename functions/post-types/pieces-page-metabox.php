<?php

add_action( 'add_meta_boxes', 'zume_pieces_box' );
function zume_pieces_box() {
    global $post;
    if ( get_post_meta( $post->ID, '_wp_page_template', true ) === 'template-pieces-page.php' ) {

        remove_post_type_support( 'page', 'editor' );

        // --- Parameters: ---
        add_meta_box( 'pieces-content-box', // ID attribute of metabox
            'Pieces Content',       // Title of metabox visible to user
            'zume_pieces_content', // Function that prints box in wp-admin
            'page',              // Show box for posts, pages, custom, etc.
            'normal',            // Where on the page to show the box
        'high' );            // Priority of box in display order
    }

}

function zume_pieces_content( $post ) {
    wp_nonce_field( 'zume_piece_nonce'.get_current_user_id(), 'zume_piece_nonce' );

    $values = get_post_custom( $post->ID );

    $number = isset( $values['zume_piece'] ) ? $values['zume_piece'][0] : 0;

    ?>
    <h3>Pieces Page</h3>
    <select name="zume_piece">
        <option></option>
    <?php
    for ($x = 1; $x <= 32; $x++) {
        $selected = false;
        if ( $x == $number) {
            $selected = true;
        }
        $post_number = zume_landing_page_post_id( $x );
        ?>
        <option value="<?php echo esc_attr( $x ) ?>" <?php echo ( $selected ) ? 'selected' : ''; ?> ><?php echo esc_attr( $x ) . ' - '; echo esc_html( get_the_title( $post_number ) ) ?></option>
        <?php
    }
    ?></select><br>    <h3>Piece Title (override) for the &lt;h1&gt;</h3>
    <input name="zume_piece_h1" class="regular-text" id="zume_piece_h1" value="<?php echo esc_html( isset( $values['zume_piece_h1'] ) ? $values['zume_piece_h1'][0] : '' ) ?>" /><br><br>
        <hr>
    <h3>Pre-Video Content</h3>
    <?php
    $content = isset( $values['zume_pre_video_content'] ) ? $values['zume_pre_video_content'][0] : '';
    wp_editor( $content, 'zume_pre_video_content', array( "media_buttons" => true ) );

    ?>
    <h3>Post-Video Content</h3>
    <?php
    $content = isset( $values['zume_post_video_content'] ) ? $values['zume_post_video_content'][0] : '';
    wp_editor( $content, 'zume_post_video_content', array( "media_buttons" => true ) );

    ?>
    <h3>"Ask Yourself" Content</h3>
    <?php
    $content = isset( $values['zume_ask_content'] ) ? $values['zume_ask_content'][0] : '';
    wp_editor( $content, 'zume_ask_content', array( "media_buttons" => true ) );
}


add_action( 'save_post', 'zume_pieces_save' );
function zume_pieces_save( $post_id ) {

    // Bail if we're doing an auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return;
    }

    // if our nonce isn't there, or we can't verify it, bail
    if ( ! isset( $_POST['zume_piece_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['zume_piece_nonce'] ) ), 'zume_piece_nonce'.get_current_user_id() ) ) { return;
    }

    // if our current user can't edit this post, bail
    if ( !current_user_can( 'edit_posts' ) ) { return;
    }

    if ( isset( $_POST['zume_piece'] ) ) {
        update_post_meta( $post_id, 'zume_piece', sanitize_text_field( wp_unslash( $_POST['zume_piece'] ) ) );
    }
    if ( isset( $_POST['zume_piece_h1'] ) ) {
        update_post_meta( $post_id, 'zume_piece_h1', sanitize_text_field( wp_unslash( $_POST['zume_piece_h1'] ) ) );
    }
    if ( isset( $_POST['zume_pre_video_content'] ) ) {
        $my_data = wp_kses_post( wp_unslash( $_POST['zume_pre_video_content'] ) );
        update_post_meta( $post_id, 'zume_pre_video_content', $my_data );
    }
    if ( isset( $_POST['zume_post_video_content'] ) ) {
        $my_data = wp_kses_post( wp_unslash( $_POST['zume_post_video_content'] ) );
        update_post_meta( $post_id, 'zume_post_video_content', $my_data );
    }
    if ( isset( $_POST['zume_ask_content'] ) ) {
        $my_data = wp_kses_post( wp_unslash( $_POST['zume_ask_content'] ) );
        update_post_meta( $post_id, 'zume_ask_content', $my_data );
    }

}

