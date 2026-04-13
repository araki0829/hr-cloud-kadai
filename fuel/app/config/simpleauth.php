<?php

return array(
  'db_connection' => null,
  'db_write_connection' => null,
  'table_name' => 'users',
  'table_columns' => array(
    'id',
    'username',
    'password',
    'email',
    'group',
    'last_login',
    'login_hash',
    'profile_fields',
  ),
  'guest_login' => false,
  'multiple_logins' => false,
  'login_hash_salt' => 'hr_cloud_login_hash_salt_2026',
  'username_post_key' => 'email',
  'password_post_key' => 'password',
  'groups' => array(
    1 => array(
      'name' => 'Users',
      'roles' => array('user'),
    ),
  ),
  'roles' => array(
    '#' => array(
      'website' => array('read'),
    ),
  ),
);
