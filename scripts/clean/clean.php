<?php

//the cleaner
function default_cleaner() {
    if ( $post_id = get_page_id_by_title( 'Sample Page' ) ){
        wp_delete_post( $post_id, true );
    }
    if ( $post_id = get_post_id_by_title( 'Hello World!' ) ){
        wp_delete_post( $post_id, true );
    }
}
add_action( 'default_cleaner', 'default_cleaner' );
//add_action( 'admin_notices', 'display_cleaner_notice' );
