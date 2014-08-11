<?php
function get_user_data() {
  $users = array (
         0 =>  array (
         'user_login' => 'default',
         'user_email' => 'default@example.com',
         'admin_color' => 'sunrise',
         'show_welcome_panel', 0,
         'rich_editing' => 0,
         'first_name' => 'Default',
         'last_name' => 'User',
         'role' => 'administrator',
         'create' => 0
         ),
         1 =>  array (
         'user_login' => 'cbos',
         'user_email' => 'tech@cbos.ca',
         'user_password' => '',
         'admin_color' => 'sunrise',
         'show_welcome_panel', 0,
         'rich_editing' => 0,
         'first_name' => 'Clarence',
         'last_name' => 'Bos',
         'role' => 'administrator',
         'create' => 0
         ),
         2 =>  array (
         'user_login' => 'client',
         'user_email' => 'client@example.com',
         'admin_color' => 'sunrise',
         'show_welcome_panel', 0,
         'rich_editing' => 0,
         'first_name' => 'A.',
         'last_name' => 'Client',
         'role' => 'administrator',
         'create' => 0
         ),
         3 =>  array (
         'user_login' => 'editor',
         'user_email' => 'editor@example.com',
         'admin_color' => 'blue',
         'show_welcome_panel', 0,
         'rich_editing' => 0,
         'first_name' => 'Sandy',
         'last_name' => 'Editor',
         'role' => 'editor',
         'create' => 0
         ),
         4 =>  array (
         'user_login' => 'author',
         'user_email' => 'author@example.com',
         'admin_color' => 'ocean',
         'show_welcome_panel', 0,
         'rich_editing' => 0,
         'first_name' => 'Edith',
         'last_name' => 'Author',
         'role' => 'author',
         'create' => 0
         ),
         5 =>  array (
         'user_login' => 'contributor',
         'user_email' => 'contributor@example.com',
         'admin_color' => 'light',
         'show_welcome_panel', 0,
         'rich_editing' => 0,
         'first_name' => 'Joe',
         'last_name' => 'Contributor',
         'role' => 'contributor',
         'create' => 0
         ),
         6 =>  array (
         'user_login' => 'subscriber',
         'user_email' => 'subscriber@example.com',
         'admin_color' => 'light',
         'show_welcome_panel', 0,
         'rich_editing' => 0,
         'first_name' => 'C.',
         'last_name' => 'Subscriber',
         'role' => 'subscriber',
         'create' => 0
         ) );
    return $users;         
}