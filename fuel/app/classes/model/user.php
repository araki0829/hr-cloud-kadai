<?php

class Model_User
{
  public static function find_by_email($email)
  {
    $user = \DB::select('id', 'name', 'email', 'password')
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
}
