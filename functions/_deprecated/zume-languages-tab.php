<?php


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Class Zume_Languages_Tab
 */
class Zume_Languages_Tab
{
    public function content() {
        ?>
        <form method="post">

            <div class="wrap">
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-1">
                        <div id="post-body-content">

                            <?php $this->language_map() ?>
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

    public function language_map() {
        $this->handle_post();

        ?>
        <form method="post">
            <?php wp_nonce_field( 'zume_language_map_' . get_current_user_id() . '_nonce', 'zume_language_map_' . get_current_user_id() ) ?>
            <table class="widefat striped">
                <thead>
                <th colspan="2">Map Language to Disciple Tools Site</th>
                </thead>
                <tbody>
                    <?php
                    global $wpdb;
                    $list_of_sites = get_option( 'site_link_system_api_keys' );
                    $results = $wpdb->get_col( "SELECT description FROM $wpdb->term_taxonomy WHERE taxonomy = 'language'" );
                    $map = get_option( 'zume_dt_language_map' );

                    if ( ! empty( $results ) ) {
                        foreach ( $results as $result) {
                            $var = unserialize( $result );
                            $lang_code = substr( $var['locale'], 0, 2 );
                            echo '<tr>';
                            echo '<td>'.esc_attr( Zume_Site_Stats::language_codes_and_names( $lang_code ) ).'</td>';
                            echo '<td><select name="map['. esc_attr( $lang_code ) .']">';
                            echo '<option></option>';
                            if ( isset( $map[$lang_code] ) && isset( $list_of_sites[$map[$lang_code]]['label'] ) ) {
                                echo '<option value="'.esc_attr( $map[$lang_code] ).'" selected>'.esc_attr( $list_of_sites[$map[$lang_code]]['label'] ).'</option>';
                                echo '<option>-----</option>';
                            }

                            if ( ! empty( $list_of_sites ) ) {
                                foreach ( $list_of_sites as $key => $site ) {
                                    echo '<option value="'. esc_attr( $key ) . '">' . esc_attr( $site['label'] ) . '</option>';
                                }
                            }

                            echo '</select></td>';
                            echo '</tr>';
                        }
                    }

                    ?>
                    <tr><td colspan="2"><span><button type="submit">Save</button></span></td></tr>
                </tbody>
            </table>
        </form>

        <?php
    }

    public function handle_post() {
        if ( isset( $_POST[ 'zume_language_map_' . get_current_user_id() ] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ 'zume_language_map_' . get_current_user_id() ] ) ), 'zume_language_map_' . get_current_user_id() . '_nonce' ) ) {
            // @codingStandardsIgnoreLine
            $map = array_map( 'sanitize_text_field', wp_unslash( $_POST['map'] ) );
            $map = array_filter( $map ); // clear empty array fields
            update_option( 'zume_dt_language_map', $map, false );
        }
    }


}
