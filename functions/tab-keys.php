<?php

/**
 * Disciple_Tools_Keys_Tab
 *
 * @class      Disciple_Tools_Keys_Tab
 * @package    Disciple_Tools
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Class Disciple_Tools_Keys_Tab
 */
class Zume_Keys_Tab
{
    /**
     * Packages and returns tab page
     *
     * @return void
     */
    public function content() {

        ?>
        <form method="post">

            <div class="wrap">
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-1">
                        <div id="post-body-content">

                            <?php DT_Ipstack_API::metabox_for_admin(); ?>
                            <br>
                            <?php $this->google_map_api_key_metabox() ?>
                            <br>
                            <?php $this->google_sso_key_metabox() ?>
                            <br>
                            <?php $this->google_captcha_key_metabox() ?>
                            <br>
                            <?php $this->facebook_sso_key_metabox() ?>
                            <br>
                            
                        </div><!-- end post-body-content -->
                        <div id="postbox-container-1" class="postbox-container">
                        </div><!-- postbox-container 1 -->
                        <div id="postbox-container-2" class="postbox-container">
                        </div><!-- postbox-container 2 -->
                    </div><!-- post-body meta box container -->
                </div>
                <!--poststuff end -->
            </div><!-- wrap end -->
        </form>
        <?php
    }

    public function google_map_api_key_metabox() {
        $this->handle_post();

        $current_key = get_option( 'google_map_key' );
        ?>
        <form method="post">
            <?php wp_nonce_field( 'zume_google_map_key_' . get_current_user_id() . '_nonce', 'zume_google_map_key' . get_current_user_id() ) ?>
            <table class="widefat striped">
                <thead>
                <th colspan="2">Google Maps API Key</th>
                </thead>
                <tbody>
                <?php if ( $this->is_default_key( $current_key ) ) : ?>
                <tr>
                    <td style="max-width:150px;">
                        <label>Default Keys<br><span style="font-size:.8em; ">( You can begin with
                                    these keys, but because of popularity, these keys can hit their
                                    limits. It is recommended that you get your own private key from
                                    Google.)</span></label>
                    </td>

                    <td>
                        <select name="default_keys" style="width: 100%;" <?php echo $this->is_default_key( $current_key ) ? '' : 'disabled' ?>>
                            <?php
                            $default_keys = zume_default_google_api_keys();
                            foreach ( $default_keys as $key => $value ) {
                                echo '<option value="'.esc_attr( $key ).'" ';
                                if ( array_search( $current_key, $default_keys ) == $key ) {
                                    echo 'selected';
                                }
                                $number = $key + 1;
                                echo '>Starter Key ' . esc_attr( $number ) . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <?php endif; ?>

                <tr>
                    <td>
                        <label>Add Your Own Key</label><br>
                        <span style="font-size:.8em;">(clear key and save to remove key)</span>
                    </td>
                    <td>
                        <input type="text" name="zume_google_map_key" id="zume_google_map_key" style="width: 100%;" value="<?php echo $this->is_default_key( $current_key ) ? '' : esc_attr( $current_key ) ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br><span style="float:right;"><button type="submit" class="button float-right">Save</button></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

        <?php
    }

    public function handle_post() {
        if ( isset( $_POST[ 'zume_google_map_key' . get_current_user_id() ] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ 'zume_google_map_key' . get_current_user_id() ] ) ), 'zume_google_map_key_' . get_current_user_id() . '_nonce' ) ) {
            if ( empty( $_POST['zume_google_map_key'] ) ) {
                $default_keys = zume_default_google_api_keys();
                $count = count( $default_keys ) - 1;

                if ( ! empty( $_POST['default_keys'] ) ) {
                    $submitted_key = sanitize_text_field( wp_unslash( $_POST['default_keys'] ) );

                    if ( isset( $default_keys[ $submitted_key ] ) ) { // check if set
                        if ( $default_keys[ $submitted_key ] <= $count ) { // check if it is a valid default key number
                            update_option( 'google_map_key', $default_keys[ $submitted_key ] );
                        }
                    }
                } else {
                    $key = $default_keys[ rand( 0, $count ) ];
                    update_option( 'google_map_key', $key );
                }
            }
            else {
                    dt_write_log( 'not empty zume_google_map_key' );
                update_option( 'google_map_key', trim( sanitize_text_field( wp_unslash( $_POST['zume_google_map_key'] ) ) ) );
                return;
            }
        }
    }

    public function mapbox_map_api_key_metabox() {
        $this->handle_post();

        $current_key = get_option( 'mapbox_map_key' );
        ?>
        <form method="post">
            <?php wp_nonce_field( 'zume_google_map_key_' . get_current_user_id() . '_nonce', 'zume_google_map_key' . get_current_user_id() ) ?>
            <table class="widefat striped">
                <thead>
                <th colspan="2">Google Maps API Key</th>
                </thead>
                <tbody>
                <?php if ( $this->is_default_key( $current_key ) ) : ?>
                    <tr>
                        <td style="max-width:150px;">
                            <label>Default Keys<br><span style="font-size:.8em; ">( You can begin with
                                    these keys, but because of popularity, these keys can hit their
                                    limits. It is recommended that you get your own private key from
                                    Google.)</span></label>
                        </td>

                        <td>
                            <select name="default_keys" style="width: 100%;" <?php echo $this->is_default_key( $current_key ) ? '' : 'disabled' ?>>
                                <?php
                                $default_keys = zume_default_google_api_keys();
                                foreach ( $default_keys as $key => $value ) {
                                    echo '<option value="'.esc_attr( $key ).'" ';
                                    if ( array_search( $current_key, $default_keys ) == $key ) {
                                        echo 'selected';
                                    }
                                    $number = $key + 1;
                                    echo '>Starter Key ' . esc_attr( $number ) . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                <?php endif; ?>

                <tr>
                    <td>
                        <label>Add Your Own Key</label><br>
                        <span style="font-size:.8em;">(clear key and save to remove key)</span>
                    </td>
                    <td>
                        <input type="text" name="zume_google_map_key" id="zume_google_map_key" style="width: 100%;" value="<?php echo $this->is_default_key( $current_key ) ? '' : esc_attr( $current_key ) ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br><span style="float:right;"><button type="submit" class="button float-right">Save</button></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

        <?php
    }

    public function is_default_key( $current_key ): bool
    {
        if ( empty( $current_key ) ) {
            $keys = zume_default_google_api_keys();
            $count = count( $keys ) - 1;
            $key = $keys[ rand( 0, $count ) ];

            update_option( 'dt_map_key', $key, true );
            return true;
        }

        $default_keys = zume_default_google_api_keys();
        foreach ( $default_keys as $default_key ) {
            if ( $default_key === $current_key ) {
                return true;
            }
        }
        return false;
    }

    public function google_sso_key_metabox() {
        $this->google_sso_key_handle_post();

        $current_key = get_option( 'dt_google_sso_key' );
        ?>
        <form method="post" name="oAuth">
            <?php wp_nonce_field( 'dt_google_sso_key' . get_current_user_id(), 'dt_google_sso_key' . get_current_user_id() ) ?>
            <table class="widefat striped">
                <thead>
                <th colspan="2">Google SSO Login/Registration oAuth Key</th>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label>Add Google API oAuth Login Key</label><br>
                    </td>
                    <td>
                        <input type="text" name="dt_google_sso_key" id="dt_google_sso_key" style="width: 100%;" value="<?php echo esc_attr( $current_key ) ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br><span style="float:right;"><button type="submit" class="button float-right">Save</button></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

        <?php
    }

    public function google_sso_key_handle_post() {
        if ( isset( $_POST[ 'dt_google_sso_key' . get_current_user_id() ] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ 'dt_google_sso_key' . get_current_user_id() ] ) ), 'dt_google_sso_key' . get_current_user_id() )
            && isset( $_POST['dt_google_sso_key'] ) ) {
            update_option( 'dt_google_sso_key', trim( sanitize_text_field( wp_unslash( $_POST['dt_google_sso_key'] ) ) ) );
            return;
        }
    }

    public function google_captcha_key_metabox() {
        $this->google_captcha_key_handle_post();
        $current_key = get_option( 'dt_google_captcha_key' );
        $server_key = get_option( 'dt_google_captcha_server_key' );
        ?>
        <form method="post" name="captcha">
            <?php wp_nonce_field( 'dt_google_captcha_key' . get_current_user_id(), 'dt_google_captcha_key' . get_current_user_id() ) ?>
            <table class="widefat striped">
                <thead>
                <th colspan="2">Google Captcha Key</th>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label>Client Key</label><br>
                    </td>
                    <td>
                        <input type="text" name="dt_google_captcha_key" id="dt_google_captcha_key" style="width: 100%;" value="<?php echo esc_attr( $current_key ) ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Server Secret Key</label><br>
                    </td>
                    <td>
                        <input type="text" name="dt_google_captcha_server_key" id="dt_google_captcha_server_key" style="width: 100%;" value="<?php echo esc_attr( $server_key ) ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br><span style="float:right;"><button type="submit" class="button float-right">Save</button></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

        <?php
    }

    public function google_captcha_key_handle_post() {
        if ( isset( $_POST[ 'dt_google_captcha_key' . get_current_user_id() ] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ 'dt_google_captcha_key' . get_current_user_id() ] ) ), 'dt_google_captcha_key' . get_current_user_id() )
            && isset( $_POST['dt_google_captcha_key'] )
            && isset( $_POST['dt_google_captcha_server_key'] ) ) {

            update_option( 'dt_google_captcha_key', trim( sanitize_text_field( wp_unslash( $_POST['dt_google_captcha_key'] ) ) ) );
            update_option( 'dt_google_captcha_server_key', trim( sanitize_text_field( wp_unslash( $_POST['dt_google_captcha_server_key'] ) ) ) );

            return;
        }
    }

    /**
     * Facebook Secret Key Metabox
     */
    public function facebook_sso_key_metabox() {
        $this->facebook_sso_key_handle_post();

        $pub_key = get_option( 'dt_facebook_sso_pub_key' );
        $sec_key = get_option( 'dt_facebook_sso_sec_key' );
        ?>
        <form method="post" name="oAuth">
            <?php wp_nonce_field( 'dt_facebook_sso_key' . get_current_user_id(), 'dt_facebook_sso_key' . get_current_user_id() ) ?>
            <table class="widefat striped">
                <thead>
                <th colspan="2">Facebook SSO Login/Registration Secret Key</th>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label>Add Facebook Public Key</label><br>
                    </td>
                    <td>
                        <input type="text" name="dt_facebook_sso_pub_key" id="dt_facebook_sso_pub_key" style="width: 100%;" value="<?php echo esc_attr( $pub_key ) ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Add Facebook Secret Key</label><br>
                    </td>
                    <td>
                        <input type="text" name="dt_facebook_sso_sec_key" id="dt_facebook_sso_sec_key" style="width: 100%;" value="<?php echo esc_attr( $sec_key ) ?>"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br><span style="float:right;"><button type="submit" class="button float-right">Save</button></span>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

        <?php
    }

    public function facebook_sso_key_handle_post() {
        if ( isset( $_POST[ 'dt_facebook_sso_key' . get_current_user_id() ] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ 'dt_facebook_sso_key' . get_current_user_id() ] ) ), 'dt_facebook_sso_key' . get_current_user_id() )
            && isset( $_POST['dt_facebook_sso_pub_key'] )
            && isset( $_POST['dt_facebook_sso_sec_key'] ) ) {
            update_option( 'dt_facebook_sso_pub_key', trim( sanitize_text_field( wp_unslash( $_POST['dt_facebook_sso_pub_key'] ) ) ) );
            update_option( 'dt_facebook_sso_sec_key', trim( sanitize_text_field( wp_unslash( $_POST['dt_facebook_sso_sec_key'] ) ) ) );
            return;
        }
    }

}

function zume_default_google_api_keys() {
    $default_keys = array(
        'AIzaSyBkI5W07GdlhQCqzf3F8VW2E_3mhdzR3s4',
        'AIzaSyAaaZusK9pa9eLuO0nlllGnbQPyXHfTGxQ',
        'AIzaSyBQOO1vujzL6BgkpOzYwZB89bJpGAlbBF8',
    );

    return $default_keys;
}
