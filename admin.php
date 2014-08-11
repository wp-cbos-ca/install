<?php

/**
* This function calls all the install functions in order.
* First the "default_cleaner" removes the default content
* we don't want, such as the "Hello World" and "Sample Page",
* if they exist. Then it creates the users for this site,
* It then creates a stock set of pages, menus and finally 
* attaches the site elements, such as the menus, activates
* the plugins we have chosen for this site and sets the 
* page templates to the appropriate value. This configuration
* typically assumens a static front page, permalinks set to
* postname, an Eastern Standard Time time zone, and various 
* other settings we have prebuilt.
* 
*/
//adapted from: http://www.kathyisawesome.com/421/customizing-wordpress-install/

/**
* Gets the required install files
*/
function get_required_install_files() {
    require_once dirname(__FILE__) . '/scripts/defaults.php';
    require_once dirname(__FILE__) . '/scripts/site/site.php';
    require_once dirname(__FILE__) . '/scripts/functions.php';
    require_once dirname(__FILE__) . '/scripts/clean/clean.php';
    require_once dirname(__FILE__) . '/scripts/users/users.php';
    require_once dirname(__FILE__) . '/scripts/pages/pages.php';
    require_once dirname(__FILE__) . '/scripts/menus/menus.php';
    require_once dirname(__FILE__) . '/scripts/timezone/timezone.php';
    require_once dirname(__FILE__) . '/scripts/plugins/plugins.php';
    
    if ( ! isset( $_GET['install-scripts'] ) && ! isset( $_GET['key'] ) ) { //load only on clean install
        require_once(ABSPATH . 'wp-admin/includes/admin.php');
        require_once(ABSPATH . 'wp-admin/includes/schema.php');
    }
}
get_required_install_files();

//this will run by default during an install, or can be called by the action "install_script" );
function wp_install( $blog_title='', $user_name='', $user_email='', $public=false, $deprecated='', $user_password='' ) {
    
    $args = run_core_install_procedures();
    
    // Step 0. Prepare and clean default install
    do_action( 'default_cleaner' );
    
    do_action( 'setup_defaults' );
    
    // Step 1. Create Users
    do_action( 'create_users' ); //admin user now available.
    
    // Step 2. Create Pages
    do_action( 'create_pages' );
    
    // Step 3. Create Menus
    do_action( 'create_menus' );
    
    // Step 4. Create Menus
    do_action( 'wp_install_defaults' );
    
    // Step 5. Activate Plugins
    do_action( 'activate_plugin_script' );
    
    return $args;
}
add_action('install_script', 'wp_install' );

//this will run by default during an install
function wp_install_defaults( $user_id = 1 ) {
    
    global $wpdb, $wp_rewrite, $current_site, $table_prefix;
    
    update_option( 'start_of_week', 0 ); // Start of the Week 0 (Sunday) 1 (Monday)
    update_option( 'blogdescription', 'Wireframe&ndash;Content&ndash;Design&ndash;Install' );
    update_option( 'template', 'genesis' );
    update_option( 'stylesheet', 'genesis+child' );
    update_option( 'uploads_use_yearmonth_folders', 0 ); // Don't Organize Uploads by Date
    update_option( 'selection', 'postname' );
    update_option( 'page_on_front', 1 );
    update_option( 'page_for_posts', 3 );
    update_option( 'show_on_front', 'page' );
    update_option( 'permalink_structure', '/%postname%/' );
    update_post_meta( 1, '_genesis_layout', 'full-width-content'  );
    $wp_rewrite->flush_rules();
    
    //setup functions
    do_action( 'setup_timezone' );
    do_action( 'setup_comments' );
    do_action( 'setup_widgets' );
    do_action( 'setup_post_defaults' );
    do_action( 'setup_categories' );
    do_action( 'setup_ping_list' );
    
    //attach site elements
    do_action( 'attach_site_elements' );
    
}
add_action( 'install_script', 'wp_install_defaults' );
                            

// Attach site elements
function attach_site_elements(){
    
    //1. Attach the theme
    do_action( 'attach_theme' );
    
    //2. Activate plugins
    activate_plugin_script();
    
    //3. Set widgets in theme
    // N/A
    
    //4. Set page templates
    do_action( 'set_page_templates' );
    
    //we have to rebuild the htaccess script, as we are using permalinks, but WordPress doesn't know that yet. 
    do_action ( 'rebuild_htaccess_file' ); 
                    
    //5. Inform of completion
    add_action( 'admin_notices', 'display_completion_notice' );
    
}
add_action( 'attach_site_elements', 'attach_site_elements' );

//Step 1. Attach the theme
function attach_theme(){
    $themes = wp_get_themes();
    if ( isset( $themes['genesis'] ) ){ 
        update_option( 'template', 'genesis' );
        update_option( 'stylesheet', 'genesis' );
    }
    else {
        update_option( 'template', 'twentyfourteen' );
        update_option( 'stylesheet', 'twentyfourteen' );
    }
}
add_action( 'attach_theme', 'attach_theme' );


//Step 4. Set the page templates
function set_page_templates() {
    $pages = array (
        0 => array ( 'slug' => 'home', 'template' => 'front-page.php' ),
        1 => array ( 'slug' => 'contact', 'template' => 'contact.php' ),
        2 => array ( 'slug' => 'blog', 'template' => 'blog.php' )
        );
    
    if ( $pages ) foreach ( $pages as $page ) {
        if ( $post_id = get_page_id_by_title ( $page['slug'] ) ) {
            update_post_meta( $post_id, '_wp_page_template', $page['template'] );
        }
    }
    
    // Use a static front page
    if ( $front_page = get_page_by_title( 'Home' ) ) {
        update_option( 'page_on_front', $front_page->ID );
        update_option( 'show_on_front', 'page' );
    }
    
    // Set the blog page
    if ( $blog   = get_page_by_title( 'Blog' ) ) {
        update_option( 'page_for_posts', $blog->ID );
    }
    
}
add_action( 'set_page_templates', 'set_page_templates' );

//classes: "updated" (green and white); "error" (red and white); "update-nag" (yellow and white)
function display_admin_notice() {
    $message = "The installation plugin has completed its tasks.";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function display_completion_notice() {
    $message = "The installation plugin has completed its tasks.";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function display_cleaner_notice() {
    $message = "The cleaner has been run.";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function display_user_notice() {
    $message = "A user has been created";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function display_menu_notice() {
    $message = "Menus have been created.";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function display_page_notice() {
    $message = "Pages have been created.";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function display_post_notice() {
    $message = "Posts have been created.";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function display_plugin_notice() {
    $message = "Plugins have been activated";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function display_elements_notice() {
    $message = "Site elements have been attached.";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function new_blog_notification_notice() {
    $message = "A new blog notification has been sent.";
    $class = "updated";
    print_admin_notice ( $message, $class );
}

function print_admin_notice( $message, $class ) {
    $str  = '<div class="' . $class .'">';
    $str .= '<p>' . $message . '</p>';
    $str .= '</div>';
    echo $str;
}

do_action( 'install_script' );

?>