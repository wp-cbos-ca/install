<?php
require_once dirname( __FILE__) . '/data.php';

function setup_categories() {
    
    // Default category
     $cat_name = __( 'General' );
     /* translators: Default category slug */
     $cat_slug = sanitize_title(_x( 'General', 'Default category slug' ) );

     if ( global_terms_enabled() ) {
        $cat_id = $wpdb->get_var( $wpdb->prepare( "SELECT cat_ID FROM {$wpdb->sitecategories} WHERE category_nicename = %s", $cat_slug ) );
        
         if ( $cat_id == null ) {
             
            $wpdb->insert( $wpdb->sitecategories, array('cat_ID' => 0, 'cat_name' => $cat_name, 'category_nicename' => $cat_slug, 'last_updated' => current_time('mysql', true)) );
            $cat_id = $wpdb->insert_id;
         }
     update_option( 'default_category', $cat_id );
     } 
     else {
        $cat_id = 1;
     }
     
    $wpdb->insert( $wpdb->terms, array('term_id' => $cat_id, 'name' => $cat_name, 'slug' => $cat_slug, 'term_group' => 0) );
     $wpdb->insert( $wpdb->term_taxonomy, array('term_id' => $cat_id, 'taxonomy' => 'category', 'description' => '', 'parent' => 0, 'count' => 1));
     $cat_tt_id = $wpdb->insert_id;
     
    // Default link category
     $cat_name = __('Blogroll');
     /* translators: Default link category slug */
     $cat_slug = sanitize_title(_x('Blogroll', 'Default link category slug'));
     
    if ( global_terms_enabled() ) {
         $blogroll_id = $wpdb->get_var( $wpdb->prepare( "SELECT cat_ID FROM {$wpdb->sitecategories} WHERE category_nicename = %s", $cat_slug ) );
         if ( $blogroll_id == null ) {
         $wpdb->insert( $wpdb->sitecategories, array('cat_ID' => 0, 'cat_name' => $cat_name, 'category_nicename' => $cat_slug, 'last_updated' => current_time('mysql', true)) );
         $blogroll_id = $wpdb->insert_id;
         }
         update_option('default_link_category', $blogroll_id);
         } else {
         $blogroll_id = 2;
    }
     
    $wpdb->insert( $wpdb->terms, array('term_id' => $blogroll_id, 'name' => $cat_name, 'slug' => $cat_slug, 'term_group' => 0) );
    $wpdb->insert( $wpdb->term_taxonomy, array('term_id' => $blogroll_id, 'taxonomy' => 'link_category', 'description' => '', 'parent' => 0, 'count' => 7));
    $blogroll_tt_id = $wpdb->insert_id;
}
add_action( 'setup_categories', 'setup_categories' );
?>
