<?php

//assign pages as needed
//we will retain empty pages at this point
function get_page_data() {
    $pages = array ( 
        1 => array ( 
            'build' => 1, 'post_title' => 'Home', 'post_name' => 'home', 'guid' => 'home', 'template' => 'home',
            'post_content' => '',
        ),
        2 => array ( 
            'build' => 1, 'post_title' => 'About', 'post_name' => 'about', 'guid' => 'about', 'template' => 'default', 
            'post_content' => '',
        ),
        3 => array ( 
            'build' => 1, 'post_title' => 'Blog', 'post_name' => 'blog', 'guid' => 'blog', 'template' => 'blog',
            'post_content' => '',
        ),
        4 => array ( 
            'build' => 1, 'post_title' => 'Contact', 'post_name' => 'contact', 'guid' => 'contact', 'template' => 'contact',
            'post_content' => '',
        ) );
    return $pages;
}
        
    
