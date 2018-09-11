<?php
/**
 * Removes a few common methods for DDoS attacks on the site.
 */

/**
 * @param $methods
 *
 * @return mixed
 */
function zume_block_xmlrpc_attacks( $methods ) {
    unset( $methods['pingback.ping'] );
    unset( $methods['pingback.extensions.getPingbacks'] );

    return $methods;
}
add_filter( 'xmlrpc_methods', 'zume_block_xmlrpc_attacks' );

/**
 * @param $headers
 *
 * @return mixed
 */
function zume_remove_x_pingback_header( $headers ) {
    unset( $headers['X-Pingback'] );

    return $headers;
}
add_filter( 'wp_headers', 'zume_remove_x_pingback_header' );
