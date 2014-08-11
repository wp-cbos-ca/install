<?php
require_once dirname( __FILE__) . '/data.php';

function run_core_install_procedures() {
    
    $site = get_site_data();
    
    if ( strpos( dirname(__FILE__), 'core') !== FALSE ) { //if we are doing a core install, use, otherwise skip
        if ( function_exists( 'wp_check_mysql_version'))
            wp_check_mysql_version();
        wp_cache_flush();
        if ( function_exists( 'make_db_current_silent'))
            make_db_current_silent();
        if ( function_exists( 'populate_options'))
            populate_options();
        if ( function_exists( 'populate_roles'))
            populate_roles();
    }

    update_option( 'blogname', $site['blog_title'] );
    update_option( 'admin_email', $site['user_email'] );
    update_option( 'blog_public', $site['blog_public'] );

    $args = run_core_install_part_two( $site['blog_title'], $site['user_name'], $site['user_email'], $site['blog_public'] );
    return $args;
}
add_action('run_core_install_procedures', 'run_core_install_procedures' );

function run_core_install_part_two ( $blog_title='', $user_name='', $user_email='', $public='', $deprecated = '', $user_password='' ) {
    
    $guessurl = wp_guess_url();
    update_option( 'siteurl', $guessurl );
    
    // If not a public blog, don't ping.
    if ( ! $public )
        update_option('default_pingback_flag', 0);

    // Create default user. If the user already exists, the user tables are
    // being shared among blogs. Just set the role in that case.
    
    $user_id = 3; //user_id (client is installed third, :. # 3);
    
    wp_install_defaults( $user_id ); 

    flush_rewrite_rules();

    wp_cache_flush();

    return array('url' => $guessurl, 'user_id' => $user_id, 'password' => '', 'password_message' => '' );
}

