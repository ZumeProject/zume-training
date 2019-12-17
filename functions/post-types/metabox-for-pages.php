<?php

add_action( 'add_meta_boxes', 'meta_box_attributes' );
function meta_box_attributes()
{                                      // --- Parameters: ---
    add_meta_box( 'attributes-meta-box-id', // ID attribute of metabox
        'Attributes',       // Title of metabox visible to user
        'meta_box_callback', // Function that prints box in wp-admin
        'page',              // Show box for posts, pages, custom, etc.
        'normal',            // Where on the page to show the box
        'high' );            // Priority of box in display order
}

function meta_box_callback( $post )
{
    $values = get_post_custom( $post->ID );
    $selected = isset( $values['meta_box_concept_name'] ) ? $values['meta_box_concept_name'][0] : '';

    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
    ?>
    <p>
        <label for="meta_box_attributes_embed">Concept Name</label>
        <input name="meta_box_concept_name" id="meta_box_concept_name" value="<?php echo $selected; ?>" />
    </p>

    <?php
}

add_action( 'save_post', 'meta_box_attributes_save' );
function meta_box_attributes_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;

    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;

    // now we can actually save the data
    $allowed = array(
        'a' => array( // on allow a tags
            'href' => array() // and those anchords can only have href attribute
        )
    );

    // Probably a good idea to make sure your data is set

    if( isset( $_POST['meta_box_concept_name'] ) )
        update_post_meta( $post_id, 'meta_box_concept_name', $_POST['meta_box_concept_name'] );

}

