<?php

//assign pages as needed
//we will retain empty pages at this point
function get_post_data() {
    $pages = array ( 
        1 => array ( 
            'build' => 1, 'post_title' => 'Post 01', 'post_name' => 'post-01', 'guid' => 'post-01', 'template' => '',
            'post_content' => '',
        ),
        2 => array ( 
            'build' => 1, 'post_title' => 'Post 02', 'post_name' => 'post-02', 'guid' => 'post-02', 'template' => '', 
            'post_content' => '',
        ),
        3 => array ( 
            'build' => 1, 'post_title' => 'Post 03', 'post_name' => 'post-03', 'guid' => 'post-03', 'template' => '',
            'post_content' => '',
        ),
        4 => array ( 
            'build' => 1, 'post_title' => 'Post 04', 'post_name' => 'post-04', 'guid' => 'post-04', 'template' => '',
            'post_content' => '',
        ) );
    return $posts;
}
        
    
