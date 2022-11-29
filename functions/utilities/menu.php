<?php
// @todo remove


// Register menus
register_nav_menus(
    array(
        'main-nav' => __( 'The Main Menu', 'zume' ),   // Main nav in header
    //        'footer-links' => __( 'Footer Links', 'zume' ) // Secondary nav in footer
    )
);

// The Top Menu
function zume_top_nav() {
    wp_nav_menu(array(
         'container' => false,                           // Remove nav container
         'menu_class' => 'vertical medium-horizontal menu',       // Adding custom nav class
         'items_wrap' => '<ul id="%1$s" class="%2$s" data-responsive-menu="accordion medium-dropdown">%3$s</ul>',
         'theme_location' => 'main-nav',                 // Where it's located in the theme
         'depth' => 5,                                   // Limit the depth of the nav
         'fallback_cb' => false,                         // Fallback function (see below)
         'walker' => new Zume_Topbar_Menu_Walker()
    ));
}

// Big thanks to Brett Mason (https://github.com/brettsmason) for the awesome walker
class Zume_Topbar_Menu_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"menu\">\n";
    }
}

// The Off Canvas Menu
function zume_off_canvas_nav() {
    wp_nav_menu(array(
         'container' => false,                           // Remove nav container
         'menu_class' => 'vertical menu top-padding is-active',       // Adding custom nav class
         'items_wrap' => '<ul id="%1$s" class="%2$s" data-accordion-menu data-submenu-toggle="true" aria-expanded="true">%3$s</ul>',
         'theme_location' => 'main-nav',                 // Where it's located in the theme
         'depth' => 5,                                   // Limit the depth of the nav
         'fallback_cb' => false,                         // Fallback function (see below)
         'walker' => new Zume_Off_Canvas_Menu_Walker()
    ));
}

class Zume_Off_Canvas_Menu_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"vertical is-active menu\">\n";
    }
}


// Add Foundation active class to menu
function zume_required_active_nav_class( $classes, $item ) {
    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'zume_required_active_nav_class', 10, 2 );

// Numeric Page Navi (built into the theme by default)
function zume_page_navi() {
    global $wpdb, $wp_query;
    $request = $wp_query->request;
    $posts_per_page = intval( get_query_var( 'posts_per_page' ) );
    $paged = intval( get_query_var( 'paged' ) );
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;
    if ( $numposts <= $posts_per_page ) { return; }
    if (empty( $paged ) || $paged == 0) {
        $paged = 1;
    }
    $pages_to_show = 7;
    $pages_to_show_minus_1 = $pages_to_show -1;
    $half_page_start = floor( $pages_to_show_minus_1 /2 );
    $half_page_end = ceil( $pages_to_show_minus_1 /2 );
    $start_page = $paged - $half_page_start;
    if ($start_page <= 0) {
        $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if (( $end_page - $start_page ) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    if ($start_page <= 0) {
        $start_page = 1;
    }
    echo '<nav class="page-navigation"><ul class="pagination">';
    if ($start_page >= 2 && $pages_to_show < $max_page) {
        $first_page_text = __( 'First', 'zume' );
        echo '<li><a href="'.esc_attr( get_pagenum_link() ).'" title="'. esc_attr( $first_page_text ) .'">'. esc_html( $first_page_text ) .'</a></li>';
    }
    echo '<li>';
    previous_posts_link( __( 'Previous', 'zume' ) );
    echo '</li>';
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $paged) {
            echo '<li class="current"> '. esc_html( $i ).' </li>';
        } else {
            echo '<li><a href="'. esc_attr( get_pagenum_link( $i ) ).'">'.esc_html( $i ).'</a></li>';
        }
    }
    echo '<li>';
    next_posts_link( __( 'Next', 'zume' ), 0 );
    echo '</li>';
    if ($end_page < $max_page) {
        $last_page_text = __( 'Last', 'zume' );
        echo '<li><a href="'. esc_attr( get_pagenum_link( $max_page ) ).'" title="'.esc_attr( $last_page_text ) .'">'. esc_html( $last_page_text ) .'</a></li>';
    }
    echo '</ul></nav>';
} /* End page navi */
