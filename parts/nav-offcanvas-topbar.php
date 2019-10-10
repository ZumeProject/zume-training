<!-- By default, this menu will use off-canvas for small
     and a topbar for medium-up -->

<?php
    $zume_is_logged_in = is_user_logged_in();

?>

<div class="grid-x top-bar">
    <div class="cell hide-for-small-only medium-1"></div>
    <div class="cell small-3 large-2">
        <a href="<?php echo is_user_logged_in() ? esc_url( zume_dashboard_url() ) : esc_url( zume_home_url() ); ?>">
            <div class="zume-logo-in-top-bar"></div>
        </a>
    </div>
    <div class="cell large-5 show-for-large">
        <?php zume_top_nav(); ?>
    </div>
    <div class="cell small-6 medium-3"><div id="lang-menu"><?php zume_the_languages( array( 'dropdown' => 1 ) ); ?></div></div>
    <div class="cell small-3 show-for-small hide-for-large">
        <div class="mobile-menu">
            <a data-toggle="off-canvas"><?php esc_html_e( 'Menu', 'zume' ); ?></a>
        </div>
    </div>
    <div class="cell hide-for-small-only medium-1"></div>
</div>
