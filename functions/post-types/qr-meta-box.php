<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly
/**
 * ADDS A QR CODE FOR THE PERMALINK INTO A METABOX ON THE SIDE OF THE ADMIN PAGE
 */
function qr_metabox_for_pages() {
    add_meta_box( 'rm-meta-box-id', esc_html__( 'QR Code', 'text-domain' ), 'qr_metabox_for_pages_box', 'page', 'side', 'high' );
}
add_action( 'add_meta_boxes', 'qr_metabox_for_pages');
function qr_metabox_for_pages_box( $meta_id ) {
    global $post;
    $full_link = get_page_link( $post->ID );
    $redirect_link = 'https://zume.training/zume_app/qr/?p=' . $post->ID ;

    ?>
    <a href="https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data=<?php echo esc_url( $redirect_link ) ?>"><img src="https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data=<?php echo esc_url( $redirect_link ) ?>" title="<?php echo esc_url( $redirect_link ) ?>" alt="<?php echo esc_url( $redirect_link ) ?>" style="width:100%;"/></a>
    <br>Links to:
    <br><?php echo esc_url( $full_link );  ?>
    <br>
    <?php
}
