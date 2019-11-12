<!-- By default, this menu will use off-canvas for small
     and a topbar for medium-up -->

<?php
    $zume_is_logged_in = is_user_logged_in();

?>

<div class="grid-x top-bar">
    <div class="cell hide-for-small-only medium-1"></div>
    <div class="cell small-3 medium-2" id="top-logo-div">
        <a href="<?php echo is_user_logged_in() ? esc_url( zume_dashboard_url() ) : esc_url( zume_home_url() ); ?>">
            <div class="zume-logo-in-top-bar"></div>
        </a>
    </div>
    <div class="cell medium-5 show-for-medium center" id="top-full-menu-div-wrapper">
        <div id="top-full-menu-div">
            <?php zume_top_nav(); ?>
        </div>
    </div>
    <div class="cell small-6 medium-2" id="top-lang-div"><div id="lang-menu"><?php zume_the_languages( array( 'dropdown' => 1 ) ); ?></div></div>
    <div class="cell small-3 medium-2 show-for-small hide-for-large" id="top-mobile-menu-div">
        <div class="mobile-menu">
            <a data-toggle="off-canvas" style="cursor:pointer;"><img src="<?php echo esc_url( zume_images_uri() . 'hamburger.svg' ) ?>" alt="menu" /></a>
        </div>
    </div>
    <div class="cell hide-for-small-only medium-1"></div>
</div>
