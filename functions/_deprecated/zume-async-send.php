<?php
/**
 * Zume Send Contact
 * This async file must be loaded from the functions.php file, or else weird things happen. :)
 */

/**
 * Function checker for async post requests
 * This runs on every page load looking for an async post request
 */
function zume_integration_load_async_send() {
    // check for create new contact
    if ( isset( $_POST['_wp_nonce'] )
    && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wp_nonce'] ) ) )
    && isset( $_POST['action'] )
    && sanitize_key( wp_unslash( $_POST['action'] ) ) == 'dt_async_session_complete_transfer' ) {
        try {
            dt_write_log( __METHOD__ . ": dt_async_session_complete_transfer" );
            $insert_location = new Zume_Integration_Session_Complete_Transfer();
            $insert_location->send();
        } catch ( Exception $e ) {
            dt_write_log( 'Caught exception: ', $e->getMessage(), "\n" );
        }
    }

}
add_action( 'init', 'zume_integration_load_async_send' );


/**
 * Class Disciple_Tools_Insert_Location
 */
class Zume_Integration_Session_Complete_Transfer extends Disciple_Tools_Async_Task
{
    protected $action = 'session_complete_transfer';

    protected function prepare_data( $data ) { return $data; }

    public function send() {
            // @codingStandardsIgnoreStart
        if( isset( $_POST[ 'action' ] )
            && sanitize_key( wp_unslash( $_POST[ 'action' ] ) ) == 'dt_async_'.$this->action
            && isset( $_POST[ '_nonce' ] )
            && $this->verify_async_nonce( sanitize_key( wp_unslash( $_POST[ '_nonce' ] ) ) ) ) {

            $zume_group_key = sanitize_key( wp_unslash( $_POST[0]['zume_group_key'] ) );
            $owner_id = sanitize_key( wp_unslash( $_POST[0]['owner_id'] ) );
            // @codingStandardsIgnoreEnd

            dt_write_log( __METHOD__ . ': ' . $zume_group_key );

            $object = new Zume_Integration();
            $object->send_session_complete_transfer( $zume_group_key, $owner_id );

        } // end if check
        return;
    }

    protected function run_action(){}
}
