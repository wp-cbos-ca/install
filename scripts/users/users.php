<?php

require_once dirname( __FILE__) . '/data.php';

function create_users() {
    $client_id = 1;
    $users = get_user_data();
     if ( $users ) foreach  ( $users as $user ) {
         
         if ( ( ! $user_id = username_exists( $user['user_login'] ) ) && $user['create'] ) {
             empty( $user['user_password']) ? $user_password = wp_generate_password( 12, false ) : $user_password = $user['user_password'];
             $user_id = wp_create_user( $user['user_login'], $user_password, $user['user_email'] );
             update_user_option( $user_id, 'default_password_nag', true, true );
             empty( $user['user_password']) ? wp_new_user_notification( $user_id, $user_password ) : '';
             update_user_meta( $user_id, 'admin_color', $user['admin_color'] );
             update_user_meta( $user_id, 'show_welcome_panel', 0 );
             $rich_editing = $user['rich_editing'] ? 'true' : 'false'; //requires boolean text
             update_user_meta( $user_id, 'rich_editing', $rich_editing );
             update_user_meta( $user_id, 'first_name', $user['first_name'], 0 );
             update_user_meta( $user_id, 'last_name', $user['last_name'], 0 );
             assign_user_role( $user_id, $user['role'] );
             add_action( 'admin_notices', 'display_user_notice' );
             $new_user = new WP_User( $user_id );
             $new_user->set_role( $user['role'] );
             //adjust for client if needed
    
         }              
     }
     update_admin_email();
}
add_action( 'create_users', 'create_users' );

function update_admin_email( $user='' ) {
    if ( defined( 'WP_ADMIN_EMAIL' ) ) { //this should have been added during installation.
        add_default_user( WP_ADMIN_EMAIL );
    }
    else {
        $file = ABSPATH . 'wp-config-user.php'; //if not we can use backup, if set.
        if ( file_exists( $file )) {
            require_once( $file );
            if ( defined( 'WP_ADMIN_EMAIL_BACKUP' ) && ! empty ( WP_ADMIN_EMAIL_BACKUP ) ) {
                add_default_user( WP_ADMIN_EMAIL_BACKUP );
            }
            else {
                $msg = '<h4>Email needed</h4>';
                $msg .= '<p>Sorry, but we need an email to continue.</p><p>Please add one using the previous form, if it was shown, or add a backup in wp-config-user.php. ';
                $msg .= 'The wp-config-user.php file should be found in the root folder of your WordPress installation.';
                $msg .= 'If you do not know what the above means, please contact the vendor from which you obtained this installation bundle. Thank you.</p>';
                wp_die( $msg );
            }
        }
    }
}

function add_default_user( $user_email ) {
    
    $ex = explode( '@', $user_email );
    
    $user_name = trim( $ex[0] );
    
    update_option('admin_email', $user_email);
    
    
    // Create default user. If the user already exists, the user tables are
    // being shared among blogs. Just set the role in that case.
    $user_id = username_exists($user_name);
    $user_password = trim($user_password);
    $email_password = false;
    if ( !$user_id && empty($user_password) ) {
        $user_password = wp_generate_password( 12, false );
        $message = __('<strong><em>Note that password</em></strong> carefully! It is a <em>random</em> password that was generated just for you.');
        $user_id = wp_create_user($user_name, $user_password, $user_email);
        update_user_option($user_id, 'default_password_nag', true, true);
        $email_password = true;
    } else if ( !$user_id ) {
        // Password has been provided
        $message = '<em>'.__('Your chosen password.').'</em>';
        $user_id = wp_create_user($user_name, $user_password, $user_email);
    } else {
        $message = __('User already exists. Password inherited.');
    }

    $user = new WP_User($user_id);
    $user->set_role('administrator');

    wp_install_defaults($user_id);

    flush_rewrite_rules();

    wp_new_blog_notification($blog_title, $guessurl, $user_id, ($email_password ? $user_password : __('The password you chose during the install.') ) );

    wp_cache_flush();
}
 
function assign_user_role( $user_id, $role ) {
    $user = new WP_User( $user_id );
    $user->set_role( $role );
}

function wp_new_blog_notification( $blog_title, $blog_url, $user_id, $password ) {
    $user = new WP_User( $user_id );
    $email = $user->user_email;
    $name = $user->user_login;
    $message = sprintf(__("Your new WordPress site has been successfully set up at:
        %1\$s
        You can log in to the administrator account with the following information:
        Username: %2\$s
        Password: %3\$s
        We hope you enjoy your new site. Thanks!
        http://workshop.cbos.ca
        "), $blog_url, $name, $password );
    @wp_mail( $email, __( 'Customized WordPress Site'), $message );
}

