<?php
function get_media_data() {
    $items = array(
        0 => array ( 'title' => 'Thumbnail Size', 'slug' => '', 'value' => array( 'width' => 150, 'height' => 150 ), 'update' => 0 ),
        1 => array ( 'title' => 'Medium Size', 'slug' => '', 'value' => array( 'width' => 300, 'height' => 300 ), 'update' => 0 ),
        2 => array ( 'title' => 'Large Size', 'slug' => '', 'value' => array( 'width' => 1024, 'height' => 1024 ), 'update' => 0 ),
        3 => array ( 'title' => 'Uploading Files', 'slug' => '', 'value' => 1, 'update' => 0 ), //year month base folders (default)
        //email to post not done
    );
    return $items;
}
?>
