<?php

class Model_User
{
  public static function find_by_email($email)
  {
    $user = \DB::select('id', 'name', 'username', 'email', 'password', 'group', 'last_login', 'login_hash', 'profile_fields')
      ->from('users')
      ->where('email', '=', $email)
      ->execute()
      ->current();

    return $user ?: array();
  }

  public static function exists_by_email($email)
  {
    $user = \DB::select('id')
      ->from('users')
      ->where('email', '=', $email)
      ->execute()
      ->current();

    return ! empty($user);
  }

  public static function create(array $attributes)
  {
    return \DB::insert('users')->set($attributes)->execute();
  }

  public static function update_by_id($user_id, array $attributes)
  {
    return \DB::update('users')
      ->set($attributes)
      ->where('id', '=', $user_id)
      ->execute();
  }
}
