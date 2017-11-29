<?php
/**
 * BuddyPress - Members Activate
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<div id="buddypress">

	<?php

	/**
	 * Fires before the display of the member activation page.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_activation_page' ); ?>

  <div class="page" id="activate-page">

    <div id="template-notices" role="alert" aria-atomic="true">
		<?php

		/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
		do_action( 'template_notices' ); ?>

    </div>

	  <?php

	  /**
	   * Fires before the display of the member activation page content.
	   *
	   * @since 1.1.0
	   */
	  do_action( 'bp_before_activate_content' ); ?>

	  <?php if ( bp_account_was_activated() ) : ?>

		  <?php if ( isset( $_GET['e'] ) ) : ?>
          <p><?php _e( 'Your account was activated successfully! Your account details have been sent to you in a separate email.', 'buddypress' ); ?></p>
		  <?php else : ?>
          <p><?php printf( 'You can now log in below with the username and password you provided when you signed up.', wp_login_url( bp_get_root_domain() ) ); ?></p>
		  <?php endif; ?>

	  <?php else : ?>


	  <?php endif; ?>

    <h1>Login</h1>
	  <?php wp_login_form(); ?>

    <?php

	  /**
	   * Fires after the display of the member activation page content.
	   *
	   * @since 1.1.0
	   */
	  do_action( 'bp_after_activate_content' ); ?>

  </div><!-- .page -->

	<?php

	/**
	 * Fires after the display of the member activation page.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_activation_page' ); ?>

</div><!-- #buddypress -->
