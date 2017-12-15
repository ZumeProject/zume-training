jQuery( document ).ready( function() {

	/* ====== Plugin Settings ====== */

	// Hide content permissions message if disabled.
	if ( false === jQuery( '[name="zume_multi_role_settings[content_permissions]"]' ).prop( 'checked' ) ) {

		jQuery( '[name="zume_multi_role_settings[content_permissions]"]' ).parents( 'tr' ).next( 'tr' ).hide();
	}

	// Hide private feed message if private feed disabled.
	if ( false === jQuery( '[name="zume_multi_role_settings[private_feed]"]' ).prop( 'checked' ) ) {

		jQuery( '[name="zume_multi_role_settings[private_feed]"]' ).parents( 'tr' ).next( 'tr' ).hide();
	}

	// Show above hidden items if feature becomes enabled.
	jQuery( '[name="zume_multi_role_settings[content_permissions]"], [name="zume_multi_role_settings[private_feed]"]' ).on( 'change',
		function() {

			if ( jQuery( this ).prop( 'checked' ) ) {

				jQuery( this ).parents( 'tr' ).next( 'tr' ).show( 'slow' );
			} else {

				jQuery( this ).parents( 'tr' ).next( 'tr' ).hide( 'slow' );
			}
		}
	);
} );
