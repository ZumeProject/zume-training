<?php
/**
 * Zúme Project v5
 */

/**
 * LOAD REQUIRED RESOURCES
 */
require_once( 'globals.php' );
require_once( 'translations/translation.php' );
require_once( 'integrations/loader.php' );
require_once( 'login/loader.php' );
require_once( 'admin/loader.php' );
require_once( 'post-types/loader.php' );
require_once( 'assets/theme-setup/loader.php' );

require_once( 'dt-mapping/loader.php' ); // mapping utilities
new DT_Mapping_Module_Loader( 'theme' );


require_once( 'v4/loader.php' );

