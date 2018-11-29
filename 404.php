<?php
if ( is_user_logged_in() ) {
    wp_safe_redirect( zume_dashboard_url() );
} else {
    wp_safe_redirect( zume_site_url() );
}
