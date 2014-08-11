<?php

if ( ! defined( 'ABSPATH'))
    die( 'Access not allowed here.');

require_once ( dirname(__FILE__) .'/data.php' );

function install_settings() {
    $items = get_settings_data();
    foreach ( $items as $item ){
        $file = dirname(__FILE__) . '/' . $item['folder'] . '/' . $item['name'] . '.php';
        if ( file_exists( $file) && $item['load'] ) {
            require_once( $file );
        }
    }
}
add_action( 'install_settings', 'install_settings' );
