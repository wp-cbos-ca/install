<?php

require_once dirname( __FILE__) . '/data.php';

function create_menus() {
    
    $menus = get_menu_data();
       
    if ( $menus ) foreach ( $menus as $menu ) {
        
        if ( $exists = wp_get_nav_menu_object( $menu['name'] ) ) {
        
            $menu_id = $exists->term_id;
            
            if ( $menu['build']  && empty ( $menu_id ) ) {
                
                $menu_id = wp_create_nav_menu( $menu['name'] );
            } 
            
            add_items_to_menu( $menu_id, $menu['slug'], $menu['items'] );
        }
        else {
            $menu_id = wp_create_nav_menu( $menu['name'] );
            add_items_to_menu( $menu_id, $menu['slug'], $menu['items'] );
        }
    }
    assign_menus();
}
add_action( 'create_menus', 'create_menus' );

function add_items_to_menu( $menu_id, $slug, $items ) {
    
   $primary = get_option('primary_built');
   $secondary = get_option('secondary_built');
   $footer = get_option('footer_built');
   
   if ( ! $primary && $slug == 'main-menu' ){   
        if ( $items ) foreach ( $items as $item ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title' =>  __($item['title']),
                'menu-item-classes' => '',
                'menu-item-url' => home_url( $item['slug'] ), 
                'menu-item-status' => 'publish'
                ));
            update_option( 'primary_built', true );
            }
        }
        
   if ( ! $secondary && $slug == 'secondary-menu' ) {   
        if ( $items ) foreach ( $items as $item ) {
            wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title' =>  __($item['title']),
                'menu-item-classes' => '',
                'menu-item-url' => home_url( $item['slug'] ), 
                'menu-item-status' => 'publish'
                ));
            update_option( 'secondary_built', true );
            }
        }
        
        if ( ! $footer && $slug == 'footer-menu' ){   
            if ( $items ) foreach ( $items as $item ) {
                wp_update_nav_menu_item( $menu_id, 0, array(
                'menu-item-title' =>  __($item['title']),
                'menu-item-classes' => '',
                'menu-item-url' => home_url( $item['slug'] ), 
                'menu-item-status' => 'publish'
            ));
            update_option( 'footer_built', true );
        }
   }
}

//Set the primary menu to Main Menu
function assign_menus() {
    $menus = array ( 
        0 => array ( 
            'name' => 'Main Menu' , 
            'location' => 'primary' ,
            'assign' => 1 ,
        ),
        1 => array ( 
            'name' => 'Secondary Menu' , 
            'location' => 'secondary' ,
            'assign' => 0 ,
        ),
        2 => array ( 
            'name' => 'Footer Menu' , 
            'location' => 'footer' ,
            'assign' => 1 ,
        )
    );
    if ( $menus ) foreach ( $menus as $menu ) {
        if ( $menu['assign'] ) {
            if ( $menu_exists = wp_get_nav_menu_object( $menu['name'] ) )
                $locations = get_theme_mod( 'nav_menu_locations' );
                $locations[ $menu['location'] ] = $menu_exists->term_id; 
                set_theme_mod( 'nav_menu_locations', $locations );
            }
        }
}
//add_action( 'admin_notices', 'display_menu_notice' );


/*
function install_default_menus() {
    
    $menu_name = 'Main Menu';
    $menu_exists = wp_get_nav_menu_object( $menu_name );
    
    if ( ! $menu_exists ) {
        
        //if exists then can create one called "Top Menu".
        $menu_id = wp_create_nav_menu( $menu_name );
    
        //have to iterate to check
        //$items = wp_get_nav_menu_items( $menu, $args );
        
        wp_update_nav_menu_item($menu_id, 0, array('menu-item-title' => 'Home',
                                           'menu-item-object' => 'page',
                                           'menu-item-object-id' => get_page_by_path('home')->ID,
                                           'menu-item-type' => 'post_type',
                                           'menu-item-status' => 'publish'));
        wp_update_nav_menu_item($menu_id, 0, array('menu-item-title' => 'About',
                                           'menu-item-object' => 'page',
                                           'menu-item-object-id' => get_page_by_path('about')->ID,
                                           'menu-item-type' => 'post_type',
                                           'menu-item-status' => 'publish'));
        wp_update_nav_menu_item($menu_id, 0, array('menu-item-title' => 'Blog',
                                           'menu-item-object' => 'page',
                                           'menu-item-object-id' => get_page_by_path('blog')->ID,
                                           'menu-item-type' => 'post_type',
                                           'menu-item-status' => 'publish'));
        wp_update_nav_menu_item($menu_id, 0, array('menu-item-title' => 'Contact',
                                           'menu-item-object' => 'page',
                                           'menu-item-object-id' => get_page_by_path('contact')->ID,
                                           'menu-item-type' => 'post_type',
                                           'menu-item-status' => 'publish')); 
                                           
        assign_primary_menu();
    }
}

//Set the primary menu to Main Menu
function assign_primary_menu( ) {

    $menu_name = 'Main Menu';
    
    $menu_exists = wp_get_nav_menu_object( $menu_name );
    
    if ( $menu_exists ) {
    
        $locations = get_theme_mod( 'nav_menu_locations' );
        $locations['primary'] = $menu_exists->term_id; 
        set_theme_mod( 'nav_menu_locations', $locations );
    }    
}
*/
