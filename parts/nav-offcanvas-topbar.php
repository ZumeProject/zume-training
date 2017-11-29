<!-- By default, this menu will use off-canvas for small
	 and a topbar for medium-up -->

<?php
    $is_logged_in = is_user_logged_in();
?>

<div class="top-bar" id="top-bar-menu">
	<div class="top-bar-left float-left">
		<ul class="menu">
			<li class="zume-logo-in-top-bar"><a href="<?php if ($is_logged_in) { echo '/dashboard'; } else { echo home_url(); } ?>"><!--
			    --><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/zume-logo-white.png" ><!--
			--></a></li>
		</ul>
	</div>
	<div class="top-bar-right float-right show-for-large">
        <ul id="menu-top-menu-1" class="vertical medium-horizontal menu float-right dropdown" data-responsive-menu="accordion medium-dropdown" role="menubar">
            <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-26 current_page_item menu-item-67 active" role="menuitem">

                <?php if($is_logged_in) : ?>
                <a href="<?php echo home_url('/dashboard') ?>">Dashboard</a>
                <?php else : ?>
                <a href="<?php echo home_url('/') ?>">Home</a>
                <?php endif ?>

            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-667 is-dropdown-submenu-parent opens-left" role="menuitem" aria-haspopup="true" aria-label="About">
                <a href="<?php echo home_url('/about/') ?>">About</a>
                <ul class="menu submenu is-dropdown-submenu first-sub vertical" data-submenu="about-sub" role="menu">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-666 is-submenu-item is-dropdown-submenu-item" role="menuitem">
                        <a href="<?php echo home_url('/about') ?>">About</a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-531 is-submenu-item is-dropdown-submenu-item" role="menuitem">
                        <a target="_blank" href="https://s3.amazonaws.com/zume/zume-guide-4039811470.pdf">Guidebook</a>
                    </li>
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-636 is-submenu-item is-dropdown-submenu-item" role="menuitem">
                        <a target="_blank" href="https://zumeproject.com/wp-content/uploads/886587b54605442ae6356261355f9c78-1.pdf">FAQ</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-849 is-submenu-item is-dropdown-submenu-item" role="menuitem">
                        <a href="<?php echo home_url('/zume-resources') ?>">Resources</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-79" role="menuitem"><a href="<?php echo home_url('/overview') ?>">Overview</a></li>
            <?php if($is_logged_in) : ?>
            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-584 is-dropdown-submenu-parent opens-left" role="menuitem" aria-haspopup="true" aria-label="Settings">
                <a href="#">Settings</a>
                <ul class="menu submenu is-dropdown-submenu first-sub vertical" data-submenu="settings-sub" role="menu">
                    <li class="bp-menu bp-activity-nav menu-item menu-item-type-custom menu-item-object-custom menu-item-3415 is-submenu-item is-dropdown-submenu-item" role="menuitem">
                        <a href="<?php echo home_url('/profile') ?>">Profile Settings</a>
                    </li>
                    <?php if( user_can( get_current_user_id(), 'manage_options') || current_user_can( 'coach' ) ) :  ?>
                    <li class="bp-menu bp-activity-nav menu-item menu-item-type-custom menu-item-object-custom menu-item-4123 is-submenu-item is-dropdown-submenu-item" role="menuitem">
                        <a href="<?php echo home_url('/wp-admin') ?>">Admin</a>
                    </li>
                    <?php endif ?>
                    <li class="bp-menu bp-logout-nav menu-item menu-item-type-custom menu-item-object-custom menu-item-77 is-submenu-item is-dropdown-submenu-item" role="menuitem">
                        <a href="<?php echo wp_logout_url('/') ?>">Log Out</a>
                    </li>
                </ul>
            </li>
            <?php endif; ?>
            <?php if( ! $is_logged_in ) : ?>
            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-72" role="menuitem"><a href="<?php echo home_url('/login') ?>">Login</a></li>
            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-23" role="menuitem"><a href="<?php echo home_url('/register') ?>">Register</a></li>
            <?php endif ?>
        </ul>
	</div>
	<div class="top-bar-right float-right show-for-small hide-for-large ">
        <ul class="menu float-right">
            <!-- <li><button class="menu-icon" type="button" data-toggle="off-canvas"></button></li> -->
            <li><a data-toggle="off-canvas" aria-expanded="false" aria-controls="off-canvas">Menu</a></li>
        </ul>
	</div>
</div>
