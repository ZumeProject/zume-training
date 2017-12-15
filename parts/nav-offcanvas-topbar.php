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

<!-- By default, this menu will use off-canvas for small
     and a topbar for medium-up -->

<div class="top-bar" id="top-bar-menu">
    <div class="show-for-large" style="display: flex; flex-direction: row; justify-content: space-around; width:100%">
        <div class="menu-item show-for-large">
            <a href="<?php echo is_user_logged_in() ? print zume_dashboard_url() : print esc_attr( home_url() ); ?>">
               <img src="<?php echo esc_attr( get_stylesheet_directory_uri() ); ?>/assets/images/zume-logo-white.png" class="zume-logo-in-top-bar">
            </a>
        </div>
        <div class="menu-item show-for-large">
            <?php zume_top_nav(); ?>
        </div>
        <div class="menu-item show-for-large"><?php pll_the_languages( array( 'dropdown' => 1 ) ) ?></div>
    </div>


    <div class=" show-for-small hide-for-large">
        <ul class="menu">
            <li class="zume-logo-in-top-bar"><a href="<?php if (is_user_logged_in()) { echo zume_dashboard_url();
} else { echo esc_attr( home_url() ); } ?>">
                    <img src="<?php echo esc_attr( get_stylesheet_directory_uri() ); ?>/assets/images/zume-logo-white.png" >
                </a></li>
        </ul>
    </div>
    <div class="=show-for-small hide-for-large ">
        <ul class="menu float-right">
             <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li>
            <li><a data-toggle="off-canvas"><?php esc_html_e( 'Menu', 'zume' ); ?></a></li>
        </ul>
    </div>
</div>

