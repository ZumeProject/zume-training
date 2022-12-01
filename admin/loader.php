<?php
$dir = scandir( __DIR__ );
foreach ( $dir as $file ){
    if ( 'php' === substr( $file, -3, 3 ) && 'index.php' !== $file && is_admin() ){
        require_once( $file );
    }
}

require_once( 'multi-role/multi-role.php' );
