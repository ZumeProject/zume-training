<?php

/**
 * Function checker for async post requests
 * This runs on every page load looking for an async post request
 */
function dt_user_sync_async_send()
{
    // check for create new contact
    if ( isset( $_POST['_wp_nonce'] )
        && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_wp_nonce'] ) ) )
        && isset( $_POST['action'] )
        && sanitize_key( wp_unslash( $_POST['action'] ) ) == 'dt_async_user_sync' ) {
        try {
            $send_to_slack = new DT_User_Sync_Send();
            $send_to_slack->send();
        } catch ( Exception $e ) {
            dt_write_log( 'Caught exception: '. $e->getMessage() . "\n" );
        }
    }

}
add_action( 'init', 'dt_user_sync_async_send' );


/**
 * Class Disciple_Tools_Insert_Location
 */
class DT_User_Sync_Send extends Disciple_Tools_Async_Task
{
    protected $action = 'user_sync';

    protected function prepare_data( $data ) { return $data; }

    public function send()
    {
        // @codingStandardsIgnoreStart
        if( isset( $_POST[ 'action' ] )
            && sanitize_key( wp_unslash( $_POST[ 'action' ] ) ) == 'dt_async_'.$this->action
            && isset( $_POST[ '_nonce' ] )
            && $this->verify_async_nonce( sanitize_key( wp_unslash( $_POST[ '_nonce' ] ) ) ) ) {


            // Parse post data and build variables
            $hook_name = ( isset( $_POST[0]['hook_name'] ) && ! empty( $_POST[0]['hook_name'] ) ) ? $_POST[0]['hook_name'] : die() ;
            $data = $_POST[0]['data'] ?? [];
            if ( ! isset( $data['user_id'] ) ) {
                dt_write_log(__METHOD__ . ": Failed to find user_id parameter" );
                return new WP_Error(__METHOD__, 'Missing user id.' );
            }
            // @codingStandardsIgnoreEnd

            // get user packet
            if ( ! class_exists( 'DT_User_Sync' ) ) {
                require_once ( 'user-sync.php' );
            }
            $user_data = DT_User_Sync::instance()->get_user_packet( $data['user_id'] );

            $endpoint = 'user_data';

            if ( $settings = DT_User_Sync::instance()->settings ) {
                if ( ! isset( $settings['site']['id'] ) ) {
                    return new WP_Error(__METHOD__, 'Missing site to site link' );
                }
                $site = Site_Link_System::get_site_connection_vars( $settings['site']['id'] );
                if ( ! $site ) {
                    return new WP_Error(__METHOD__, 'Missing site to site data' );
                }

                // Send remote request
                $args = [
                    'method' => 'POST',
                    'body' => [
                        'transfer_token' => $site['transfer_token'],
                        'user_data' => $user_data,
                    ]
                ];

                $result = wp_remote_post( 'https://' . $site['url'] . '/wp-json/dt-public/v1/user_sync/' . $endpoint, $args );

                if ( is_wp_error( $result ) ) {
                    $error = new WP_Error( 'failed_remote_get', $result->get_error_message() );
                    dt_write_log($error);
                    return $error;
                }
            }
            else {
                dt_write_log('did not find settings');
            }

        } // end if check

    }

    protected function run_action(){}
}
