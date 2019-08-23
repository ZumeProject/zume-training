<?php

add_filter( 'dt_mapbox_api_root_url', 'zume_mapbox_api_root_url' );
function zume_mapbox_api_root_url() {
    return  trailingslashit( get_template_directory_uri() ) . 'functions/dt-mapping/';
}
