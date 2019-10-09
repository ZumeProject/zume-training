<!-- By default, this menu will use off-canvas for small
     and a topbar for medium-up -->

<?php
    $zume_is_logged_in = is_user_logged_in();

?>

<div class="top-bar" id="top-bar-menu">

    <div class="" style="display: flex; flex-direction: row; justify-content: space-around; width:100%">

        <!-- Show for large -->
        <div class="menu-item" id="nav-logo">
            <ul class="menu">
                <li class="zume-logo-in-top-bar">
                    <a href="<?php echo is_user_logged_in() ? esc_url( zume_dashboard_url() ) : esc_url( zume_home_url() ); ?>">
                        <img src="<?php echo esc_attr( zume_images_uri() ); ?>zume-training-logo.svg" alt="Zume Logo" >
                    </a>
                </li>
            </ul>
        </div>
        <div id="zume-main-menu" class="menu-item show-for-large">
            <?php zume_top_nav(); ?>
        </div>
        <!-- End show for large -->

        <!-- Show for all screens -->
        <div class="menu-item" id="lang-menu"><?php zume_the_languages( array( 'dropdown' => 1 ) ); ?></div>
        <!-- End show for all -->

        <!-- Show for small/med -->
        <div class=" show-for-small hide-for-large">
            <ul class="menu float-right" id="nav-menu">
                <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li>
                <li><a data-toggle="off-canvas"><?php esc_html_e( 'Menu', 'zume' ); ?></a></li>
            </ul>
        </div>
        <!-- End show for small/med -->
    </div>
</div>
