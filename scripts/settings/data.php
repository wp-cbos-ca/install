<?php
function get_settings_data() {
    $items = array( 
        0 => array( 'folder' => 'discussion', 'name' => 'discussion', 'load' => 1 ),
        1 => array( 'folder' => 'general', 'name' => 'general', 'load' => 1 ),
        2 => array( 'folder' => 'media', 'name' => 'media', 'load' => 1 ),
        3 => array( 'folder' => 'permalinks', 'name' => 'permalinks', 'load' => 1 ),
        4 => array( 'folder' => 'reading', 'name' => 'reading', 'load' => 1 ),
        5 => array( 'folder' => 'writing', 'name' => 'writing', 'load' => 1 )
        );
    return $items;
}  
?>
