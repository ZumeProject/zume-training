<?php

do_action( 'bp_before_group_header' );

?>

<div id="item-actions">

	<?php if ( bp_group_is_visible() ) : ?>

		<h3><?php _e( 'Leaders', 'buddypress' ); ?></h3>

		<?php bp_group_list_admins();


	endif; ?>


</div><!-- #item-actions -->

<div id="item-header-avatar">
	<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">

		<?php bp_group_avatar(); ?>

	</a>
</div><!-- #item-header-avatar -->

<div id="item-header-content">
	<h2><a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>"><?php bp_group_name(); ?></a></h2>


	<?php do_action( 'bp_before_group_header_meta' ); ?>

	<div id="item-meta">

		<?php bp_group_description(); ?>


        <?php do_action( 'bp_group_header_meta' ); ?>


	</div>
</div><!-- #item-header-content -->

<style>
    /* located /groups/single/groups-header.php */
    .article-header {display:none;}
    #group_invite_by_email-groups-li {display:none;}
    #group_invite_by_url-groups-li {display:none;}
    form#invite_by_email {margin-top: 15px;
        border-top: 1px solid #eaeaea;
        padding-top: 15px;}
    #group-map-groups-li {display:none;}
    #item-nav {border-bottom:1px solid #eaeaea;}
    #buddypress div.item-list-tabs#subnav {margin:0;}
    #buddypress #item-body form#whats-new-form {padding-top:15px;}

</style>


<?php
do_action( 'bp_after_group_header' );
do_action( 'template_notices' );
?>