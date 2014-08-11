<?php
require_once dirname(__FILE__) . '/data.php';

function rebuild_htaccess_file() {
    $file = ABSPATH . '.htaccess';
    if ( file_exists( $file )){
        $marker = 'WordPress';
        $arr = extract_from_markers( $file, $marker );
        if ( empty ( $arr ) || ( count( $arr ) < 8 ) ){
            $r = write_htaccess_script();
            return $r;
        }
        else{
            return $arr;
        }
    }
}

function write_htaccess_script(  ) {
    $file = ABSPATH. '.htaccess';
    if ( file_exists( $file )){
        $marker = 'WordPress';
        $insertion = get_htaccess_script();
        $r = insert_with_markers( $file, $marker, $insertion );
        return $r;
    }
}
 
add_action( 'rebuild_htaccess_file', 'rebuild_htaccess_file' );
  
?>
