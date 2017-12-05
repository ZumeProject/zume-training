<?php
/**
 * @see https://polylang.wordpress.com/documentation/documentation-for-developers/functions-reference/
 * Wrap all polylang integration function in a if function exists test, so if the plugin is turned off or upgraded
 * the site doesn't error out.
 * use: function_exists('pll_the_languages' )
 */

/**
 * Tests if polylang plugin is installed.
 * Must check for plugin existence, because when the polylang plugin is updated, it will be deleted and reinstalled, which
 * could create an error on update if dependent functions are not protected.
 * @return bool
 */
function zume_has_polylang() {
	if( function_exists( 'pll_the_languages' ) ) {
		return true;
	} else {
		return false;
	}
}

function zume_the_languages( $args = [] ) {
	if( function_exists('pll_the_languages' ) ) {
		return pll_the_languages($args);
	}
	else {
		return new WP_Error('Polylang_missing', 'Polylang plugin missing');
	}
}

function zume_current_language() {
	if( function_exists('pll_the_languages' ) ) {
		return pll_current_language();
	}
	else {
		return new WP_Error('Polylang_missing', 'Polylang plugin missing');
	}
}

function zume_default_language() {
	if( function_exists('pll_the_languages' ) ) {
		return pll_default_language();
	}
	else {
		return new WP_Error('Polylang_missing', 'Polylang plugin missing');
	}
}

function zume_get_translation( $post_id, $slug = 'en' ) {
	if( function_exists('pll_the_languages' ) ) {
		return pll_get_post($post_id, $slug);
	}
	else {
		return new WP_Error('Polylang_missing', 'Polylang plugin missing');
	}

}