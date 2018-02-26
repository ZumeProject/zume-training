<!-- By default, this menu will use off-canvas for small
     and a topbar for medium-up -->

<?php
    $zume_is_logged_in = is_user_logged_in();

    // adds the current language to the nav url
if ( zume_has_polylang() ) {
    $zume_current_language_slug = pll_current_language() . '/';
} else {
    $zume_current_language_slug = '';
}
?>

<div class="top-bar" id="top-bar-menu">

    <div class="" style="display: flex; flex-direction: row; justify-content: space-around; width:100%">

        <!-- Show for large -->
        <div class="menu-item">
            <ul class="menu">
                <li class="zume-logo-in-top-bar">
                    <a href="<?php echo is_user_logged_in() ? esc_url( zume_dashboard_url() ) : esc_attr( site_url() ); ?>">
                        <img src="<?php echo esc_attr( zume_images_uri() ); ?>zume-logo-white.png"
                             class="zume-logo-in-top-bar">
                    </a>
                </li>
            </ul>
        </div>
        <div id="zume-main-menu" class="menu-item show-for-large">
            <?php zume_top_nav(); ?>
        </div>
        <!-- End show for large -->

        <!-- Show for all screens -->
        <div class="menu-item"><?php
            $zume_url_path = trim( parse_url( add_query_arg( array() ), PHP_URL_PATH ), '/' );
        if ( "course" != $zume_url_path ) {
            pll_the_languages( array( 'dropdown' => 1 ) );
        }
            ?>
        </div>
        <!-- End show for all -->

        <!-- Show for small/med -->
        <div class=" show-for-small hide-for-large">
            <ul class="menu float-right">
                <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li>
                <li><a data-toggle="off-canvas"><?php esc_html_e( 'Menu', 'zume' ); ?></a></li>
            </ul>
        </div>
        <!-- End show for small/med -->
    </div>
</div>