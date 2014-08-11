<?php

require_once dirname( __FILE__) . '/data.php';

function setup_sidebars() {
    
    $items = get_sidebar_data();
                              
}
add_action( 'setup_sidebars', 'setup_sidebars' );
