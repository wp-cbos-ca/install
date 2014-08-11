<?php
require_once dirname( __FILE__) . '/data.php';

function activate_plugin_script(){
    
    $plugins = get_activate_plugin_data();    
    
    if ( $plugins ) foreach ( $plugins as $plugin ) {
        if ( $plugin['activate'] ) {
            $plugin_name = get_plugin_name( $plugin );
            activate_plugin( $plugin_name );
        }
    }
}
add_action( 'activate_plugin_script', 'activate_plugin_script' );

 function get_plugin_name( $plugin ) {
    $plugin_name = $plugin['folder'] . '/' . $plugin['name'];
    return $plugin_name;
}

//add_action( 'admin_notices', 'display_plugin_notice' );

?>
