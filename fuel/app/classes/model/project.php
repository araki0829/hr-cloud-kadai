<?php

class Model_Project
{
  public static function find_all_by_user_id($user_id)
  {
    return \DB::select('id', 'name', 'description', 'created_at', 'updated_at')
      ->from('projects')
      ->where('user_id', '=', $user_id)
      ->order_by('updated_at', 'desc')
      ->execute()
      ->as_array();
  }

  public static function find_by_id_and_user_id($project_id, $user_id)
  {
    $project = \DB::select('id', 'user_id', 'name', 'description', 'created_at', 'updated_at')
      ->from('projects')
      ->where('id', '=', $project_id)
      ->where('user_id', '=', $user_id)
      ->execute()
      ->current();

    return $project ?: array();
  }

  public static function create(array $attributes)
  {
    return \DB::insert('projects')->set($attributes)->execute();
  }

  public static function update_by_id_and_user_id($project_id, $user_id, array $attributes)
  {
    return \DB::update('projects')
      ->set($attributes)
      ->where('id', '=', $project_id)
      ->where('user_id', '=', $user_id)
      ->execute();
  }

  public static function delete_by_id_and_user_id($project_id, $user_id)
  {
    return \DB::delete('projects')
      ->where('id', '=', $project_id)
      ->where('user_id', '=', $user_id)
      ->execute();
  }
}
