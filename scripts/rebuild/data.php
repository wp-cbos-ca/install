<?php
function get_htaccess_script() {
    $arr = array ( 
        0 => '<IfModule mod_rewrite.c>',
        1 => 'RewriteEngine On',
        2 => 'RewriteBase /',
        3 => 'RewriteRule ^index\.php$ - [L]',
        4 => 'RewriteCond %{REQUEST_FILENAME} !-f',
        5 => 'RewriteCond %{REQUEST_FILENAME} !-d',
        6 => 'RewriteRule . /index.php [L]',
        7 => '</IfModule>'
        );
    return $arr;
}

?>
