<?php
function get_general_data() {
    $items = array(
        0 => array ( 'title' => 'Front page displays', 'slug' => 'use_smilies', 'value' => 0 ),
        1 => array ( 'title' => 'Blog pages show at most', 'slug' => 'posts_per_page', 'value' => 10 ),
        2 => array ( 'title' => 'Syndication feeds show the most recent', 'slug' => 'posts_per_rss', 'value' => 10 ),
        3 => array ( 'title' => 'For each article in a feed show', 'slug' => 'rss_use_excerpt', 'value' => 1 ),
        4 => array ( 'title' => 'Search Engine Visibility', 'slug' => 'blog_public', 'value' => 1 ),  
    );
    return $items;
}
?>
