<?php

add_action( 'add_meta_boxes', 'zume_landing_box' );
function zume_landing_box() {
    global $post;
    if ( get_post_meta( $post->ID, '_wp_page_template', true ) === 'template-zume-landing.php' ) {

        remove_post_type_support( 'page', 'editor' );

        // --- Parameters: ---
        add_meta_box( 'landing-content', // ID attribute of metabox
            'Landing Content',       // Title of metabox visible to user
            'zume_landing_content', // Function that prints box in wp-admin
            'page',              // Show box for posts, pages, custom, etc.
            'normal',            // Where on the page to show the box
        'high' );            // Priority of box in display order
    }

}

function zume_landing_list_templates(){
    return [
        'full' => [
            'key' => 'full',
            'label' => 'Full List (default)'
        ],
        'leading_yourself' => [
            'key' => 'leading_yourself',
            'label' => 'Leading Yourself (4 part, abbreviated)'
        ]
    ];
}

function zume_landing_content( $post ) {
    wp_nonce_field( 'zume_landing_nonce'.get_current_user_id(), 'zume_landing_nonce' );

    $values = get_post_custom( $post->ID );

    ?>
    <p>Blank sections will go with defaults for template. Add logo to featured image.</p>
    <hr>

    <h3>Landing Title (override) for the &lt;h1&gt;</h3>
    <input name="zume_landing_h1" class="regular-text" id="zume_landing_h1" value="<?php echo esc_html( isset( $values['zume_landing_h1'] ) ? $values['zume_landing_h1'][0] : '' ) ?>" /><br><br>

    <hr>
    <h3>Pre-Video</h3>
    <?php
    $content = isset( $values['zume_pre_video_content'][0] ) ? $values['zume_pre_video_content'][0] : '';
    wp_editor( $content, 'zume_pre_video_content', array( "media_buttons" => true ) );

    ?>
    <h3>Show Video</h3>
    <select name="zume_landing_show_video">
        <?php

        if ( isset( $values['zume_landing_show_video'][0] ) ){
            echo '<option value="'. esc_attr( $values['zume_landing_show_video'][0] ).'" selected>'. esc_html( ucwords( $values['zume_landing_show_video'][0] ) ) . '</option>';
            echo '<option disabled>----</option>';
        }


        $list = [
            'yes' => [
                'key' => 'yes',
                'label' => 'Yes'
            ],
            'no' => [
                'key' => 'no',
                'label' => 'No'
            ]
        ];
        foreach ( $list as $value ){
            echo '<option value="'. esc_attr( $value['key'] ).'">'. esc_html( $value['label'] ) . '</option>';
        }
        ?></select><br>
    <h3>Post Video</h3>
    <?php
    $content = isset( $values['zume_post_video_content'][0] ) ? $values['zume_post_video_content'][0] : ''; // phpcs:ignore
    wp_editor( $content, 'zume_post_video_content', array( "media_buttons" => true ) );
    ?>
    <h3>List Template</h3>
    <select name="zume_landing_list_template">
    <?php
    $list = zume_landing_list_templates();
    foreach ( $list as $value ){
        $selected = '';
        if ( isset( $values['zume_landing_list_template'][0] ) && $values['zume_landing_list_template'][0] === $value['key'] ){
            $selected = ' selected';
        }
        echo '<option value="'.esc_attr( $value['key'] ).'" '. esc_attr( $selected ).'>'. esc_html( $value['label'] ) . '</option>'; // phpcs:ignore
    }
    ?></select><br>
    <?php
}


add_action( 'save_post', 'zume_landing_save' );
function zume_landing_save( $post_id ) {

    // Bail if we're doing an auto save
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return;
    }

    // if our nonce isn't there, or we can't verify it, bail
    if ( ! isset( $_POST['zume_landing_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['zume_landing_nonce'] ) ), 'zume_landing_nonce'.get_current_user_id() ) ) { return;
    }

    // if our current user can't edit this post, bail
//    if ( !current_user_can( 'edit_post' ) ) { return;
//    }

    if ( isset( $_POST['zume_landing_list_template'] ) ) {
        update_post_meta( $post_id, 'zume_landing_list_template', sanitize_text_field( wp_unslash( $_POST['zume_landing_list_template'] ) ) );
    }
    if ( isset( $_POST['zume_landing_h1'] ) ) {
        update_post_meta( $post_id, 'zume_landing_h1', sanitize_text_field( wp_unslash( $_POST['zume_landing_h1'] ) ) );
    }
    if ( isset( $_POST['zume_pre_video_content'] ) ) {
        $my_data = wp_kses_post( wp_unslash( $_POST['zume_pre_video_content'] ) );
        update_post_meta( $post_id, 'zume_pre_video_content', $my_data );
    }
    if ( isset( $_POST['zume_landing_show_video'] ) ) {
        update_post_meta( $post_id, 'zume_landing_show_video', sanitize_text_field( wp_unslash( $_POST['zume_landing_show_video'] ) ) );
    }
    if ( isset( $_POST['zume_post_video_content'] ) ) {
        $my_data = wp_kses_post( wp_unslash( $_POST['zume_post_video_content'] ) );
        update_post_meta( $post_id, 'zume_post_video_content', $my_data );
    }
}

