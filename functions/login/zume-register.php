<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly































































//add_filter('lostpassword_url', 'zume_lost_password_url');
//function zume_lost_password_url() {
//    $url = zume_get_posts_translation_url('Forgot Password');
//    return $url;
//}
/**********************************************************************************************************************/

function zume_mu_register_styles() {
    ?>
    <style type="text/css">
        div#signup-content {
            margin: 1% auto;
            width: 40%;
            border: 1px solid #323A68;
            padding: 15px;
        }

        p .submit {
            padding: 15px;
        }
        p.submit input:hover {
            background-color: #323A68;
            color: white;
            cursor: pointer;
        }

        /* On screens that are 992px or less, set the background color to blue */
        @media screen and (max-width: 992px) {
            div#signup-content {
                margin: 10px auto;
                width: 60%;
            }
        }

        /* On screens that are 600px or less, set the background color to olive */
        @media screen and (max-width: 600px) {
            div#signup-content {
                margin: 10px auto;
                width: 95%;
            }
        }
    </style>
    <?php
}

function zume_mu_disable_header() {
    ?>
    <style type="text/css">
        #zume-main-menu {display:none;}
        .wp-activate-container a {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
    <script>
        jQuery(document).ready(function() {
            jQuery('#signup-content').append('<p style="text-align:center;"><a class="button" href="<?php echo esc_url( site_url( '/login' ) )  ?>"><?php esc_attr( 'Login' ) ?></a></p>')

        })
    </script>
    <?php
}
add_action( 'signup_header', 'zume_mu_register_styles' );
add_action( 'activate_wp_head', 'zume_mu_register_styles' );
add_action( 'activate_wp_head', 'zume_mu_disable_header' );


/***********************************************************************************************************************
 * Modify Registration Form
 */

function zume_mu_register_form() {

    ?>
    <p>
        <label for="first_name"><?php esc_attr_e( 'First Name (optional for coaching)', 'zume' ) ?><br />
            <input type="text" name="first_name" id="first_name" class="input" value="" size="25" /></label>
    </p>
    <p>
        <label for="last_name"><?php esc_attr_e( 'Last Name (optional for coaching)', 'zume' ) ?><br />
            <input type="text" name="last_name" id="last_name" class="input" value="" size="25" /></label>
    </p>
    <p>
        <label for="zume_phone_number"><?php esc_attr_e( 'Phone Number (optional for coaching)', 'zume' ) ?><br />
            <input type="text" name="zume_phone_number" id="zume_phone_number" class="input" value="" size="25" /></label>
    </p>
    <p>
        <label for="zume_address"><?php esc_attr_e( 'Address (optional for coaching)', 'zume' ) ?><br />
            <input type="text" name="zume_address" id="zume_address" class="input" value="" size="25" />
        </label>
    </p>
    <?php
    $key = '';
    if ( isset( $_GET['affiliation'] ) ) {
        $key = strtoupper( sanitize_key( wp_unslash( $_GET['affiliation'] ) ) );
    }
    ?>
    <p class="grid-x grid-padding-x" style="width:100%">
        <label for="zume_affiliation_key"><?php esc_attr_e( 'Affiliation Key (optional)', 'zume' ) ?></label><br>
        <input type="text" value="<?php echo esc_html( $key ) ?>" id="zume_affiliation_key"
               name="zume_affiliation_key" maxlength="5" />
    </p>
    <br clear="all" />
    <style>#signup-content .wp-signup-container h2 {display:none;}</style>
    <?php wp_nonce_field( 'custom_registration_actions', 'custom_registration_nonce', false, true ) ?>

    <?php
    dt_write_log( __METHOD__ );
    dt_write_log( 'step 1' );
}
add_action( 'signup_extra_fields', 'zume_mu_register_form' );

//2. Add validation. In this case, we make sure first_name is required.
add_filter( 'registration_errors', 'zume_mu_registration_errors', 10, 3 );
function zume_mu_registration_errors( $errors, $sanitized_user_login, $user_email ) {

    if ( isset( $_POST['custom_registration_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['custom_registration_nonce'] ) ), 'custom_registration_actions' ) ) {
        if ( empty( $_POST['zume_address'] ) || ! empty( $_POST['zume_address'] ) && trim( sanitize_text_field( wp_unslash( $_POST['zume_address'] ) ) ) == '' ) {

            $results = Disciple_Tools_Google_Geocode_API::query_google_api( trim( sanitize_text_field( wp_unslash( $_POST['zume_address'] ) ) ), 'validate' );

            if ( ! $results ) {
                $errors->add( 'zume_address_error', esc_attr__( '<strong>ERROR</strong>: We can not recognize this address as valid location. Please, check spelling.', 'zume' ) );
            }
        }
    }

    dt_write_log( __METHOD__ );
    dt_write_log( 'validation step' );
    return $errors;
}

// Stores form data for activation
add_filter( 'add_signup_meta', 'custom_add_signup_meta' );
function custom_add_signup_meta( $meta ) {
    if ( isset( $_POST['custom_registration_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['custom_registration_nonce'] ) ), 'custom_registration_actions' ) ) {
        $first_name = '';
        $last_name = '';
        $zume_phone_number = '';
        $zume_address = '';
        $zume_affiliation_key = '';

        if ( ! empty( $_POST['first_name'] ) ) {
            $first_name = trim( sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) );
        }
        if ( ! empty( $_POST['last_name'] ) ) {
            $last_name = trim( sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) );
        }
        if ( ! empty( $_POST['zume_phone_number'] ) ) {
            $zume_phone_number = trim( sanitize_text_field( wp_unslash( $_POST['zume_phone_number'] ) ) );
        }
        if ( ! empty( $_POST['zume_address'] ) ) {
            $zume_address = trim( sanitize_text_field( wp_unslash( $_POST['zume_address'] ) ) );
        }
        if ( ! empty( $_POST['zume_affiliation_key'] ) ) {
            $zume_affiliation_key = trim( sanitize_key( wp_unslash( $_POST['zume_affiliation_key'] ) ) );
        }

        $user_meta = [
            'first_name'           => $first_name,
            'last_name'            => $last_name,
            'zume_phone_number'    => $zume_phone_number,
            'zume_address'         => $zume_address,
            'zume_affiliation_key' => $zume_affiliation_key,
        ];

        $meta['user_meta'] = $user_meta;
        dt_write_log( __METHOD__ );
        dt_write_log( 'Step 2' );
        dt_write_log( $meta );
    }

    return $meta;
}

// Save after activation step
add_action( 'wpmu_activate_user', 'custom_wpmu_activate_blog', 10, 3 );
function custom_wpmu_activate_blog(  $user_id, $password, $meta ) {
    dt_write_log( __METHOD__ );
    dt_write_log( "Save step" );

    // Capture user submitted fields
    if ( isset( $meta['user_meta']['first_name'] ) && ! empty( $meta['user_meta']['first_name'] ) ) {
        update_user_meta( $user_id, 'first_name', trim( sanitize_key( wp_unslash( $meta['user_meta']['first_name'] ) ) ) );
    }
    if ( isset( $meta['user_meta']['last_name'] ) && ! empty( $meta['user_meta']['last_name'] ) ) {
        update_user_meta( $user_id, 'last_name', trim( sanitize_key( wp_unslash( $meta['user_meta']['last_name'] ) ) ) );
    }
    if ( isset( $meta['user_meta']['zume_phone_number'] ) && ! empty( $meta['user_meta']['zume_phone_number'] ) ) {
        update_user_meta( $user_id, 'zume_phone_number', trim( sanitize_key( wp_unslash( $meta['user_meta']['zume_phone_number'] ) ) ) );
    }
    if ( isset( $meta['user_meta']['zume_address'] ) && ! empty( $meta['user_meta']['zume_address'] ) ) {

        $results = Disciple_Tools_Google_Geocode_API::query_google_api( trim( sanitize_key( wp_unslash( $meta['user_meta']['zume_address'] ) ) ), 'core' );

        if ( $results ) {
            update_user_meta( $user_id, 'zume_user_address', $results['formatted_address'] );
            update_user_meta( $user_id, 'zume_user_lng', $results['lng'] );
            update_user_meta( $user_id, 'zume_user_lat', $results['lat'] );
            update_user_meta( $user_id, 'zume_raw_location', $results );
        }
    }
    if ( isset( $meta['user_meta']['zume_affiliation_key'] ) && ! empty( $meta['user_meta']['zume_affiliation_key'] ) ) {
        update_user_meta( $user_id, 'zume_affiliation_key', trim( sanitize_key( wp_unslash( $meta['user_meta']['zume_affiliation_key'] ) ) ) );
    }

    zume_update_user_ip_address_and_location( $user_id ); // record ip address and location

    update_user_meta( $user_id, 'zume_language', zume_current_language() );

    add_user_to_blog( get_current_blog_id(), $user_id, 'subscriber' ); // add user to ZumeProject site.

}

/**********************************************************************************************************************/