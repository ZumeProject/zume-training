<?php
/**
 * This adds the LogRocket service to the header of the site, which allows us to track user issues and bugs.
 * @see https://app.logrocket.com
 */


function zume_add_logrocket_to_head() {
$user = wp_get_current_user();
?>
<script src="https://cdn.logrocket.io/LogRocket.min.js" crossorigin="anonymous"></script>
<script>window.LogRocket && window.LogRocket.init('mkpicf/zumeproject');</script>
<?php if ( ! empty( $user ) && is_user_logged_in() ) : ?>
<script>LogRocket.identify('<?php echo $user->ID ?>',{name:'<?php echo $user->display_name ?? '' ?>',email:'<?php echo $user->user_email ?? ''  ?>'});</script>
<?php
endif;
}
add_action( 'wp_head', 'zume_add_logrocket_to_head' );