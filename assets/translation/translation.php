<?php
/**
 * Language Translation
 * @see http://codex.wordpress.org/I18n_for_WordPress_Developers
 * @see http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 *
 */
add_action( 'after_setup_theme', 'load_translations' );
function load_translations(){
    load_theme_textdomain( 'zume', get_template_directory() .'/assets/translation' );
}