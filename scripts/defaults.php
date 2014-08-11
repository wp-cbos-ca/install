<?php
//move to folder, etc., as needed
function wp_install_script() {
     if ( !empty( $deprecated ) )
        _deprecated_argument( __FUNCTION__, '2.6' );

    //wp_check_mysql_version(); //not available
    wp_cache_flush();
    //make_db_current_silent(); //not available
    
    update_option( 'blogname', $blog_title );
    update_option( 'admin_email', $user_email );
    update_option( 'blog_public', $public );

    $guessurl = wp_guess_url();

    update_option('siteurl', $guessurl );

    // If not a public blog, don't ping.
    if ( ! $public )
        update_option('default_pingback_flag', 0);

    // Create default user. If the user already exists, the user tables are
    // being shared among blogs. Just set the role in that case.
    $user_id = username_exists( $user_name );
    $user_password = trim($user_password);
    $email_password = false;
    if ( ! $user_id && empty( $user_password ) ) {
        $user_password = wp_generate_password( 12, false );
        $message = __( '<strong><em>Note that password</em></strong> carefully! It is a <em>random</em> password that was generated just for you.' );
        $user_id = wp_create_user( $user_name, $user_password, $user_email );
        update_user_option( $user_id, 'default_password_nag', true, true );
        $email_password = true;
    } else if ( !$user_id ) {
        // Password has been provided
        $message = '<em>'.__('Your chosen password.').'</em>';
        $user_id = wp_create_user($user_name, $user_password, $user_email);
    } else {
        $message = __('User already exists. Password inherited.');
    }

    $user = new WP_User( $user_id );
    $user->set_role( 'administrator' );

    wp_install_defaults( $user_id );

    flush_rewrite_rules();
    
    wp_cache_flush();

    return array( 'url' => $guessurl, 'user_id' => $user_id, 'password' => $user_password, 'password_message' => $message );
}

//helper functions below
function setup_ping_list() {
     // http://mrjimhudson.com/wordpress-update-services-use-a-larger-ping-list/
     if ( file_exists( WP_CONTENT_DIR . '/ping-list.txt' ) ) {
         $services = file_get_contents( 'ping-list.txt', true );
         update_option( 'ping_sites', $services );
     } 
}
add_action( 'install_script', 'setup_ping_list' );

function setup_comments() {
     // Update Comment Moderation List
     // http://perishablepress.com/wordpress-blacklist-characters/
     if ( file_exists( WP_CONTENT_DIR . '/comment-moderation-list.txt' ) ) {
        $modlist = file_get_contents( 'comment-moderation-list.txt', true );
        update_option( 'moderation_keys', $modlist );
     }
     
     // Update Comment Blacklist
     // http://www.pureblogging.com/2008/04/29/create-a-comment-blacklist-in-wordpress-download-my-list-of-spam-words/
     if ( file_exists( WP_CONTENT_DIR . '/comment-blacklist.txt' ) ) {
         $blacklist = file_get_contents( 'comment-blacklist.txt', true );
         update_option( 'blacklist_keys', $blacklist );
     }
}
add_action( 'setup_comments', 'setup_comments' );
