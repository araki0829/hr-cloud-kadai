<?php

class Model_Task
{
  public static function find_all_by_project_id($project_id)
  {
    return \DB::select('id', 'project_id', 'title', 'body', 'status', 'created_at', 'updated_at')
      ->from('tasks')
      ->where('project_id', '=', $project_id)
      ->order_by('updated_at', 'desc')
      ->execute()
      ->as_array();
  }

  public static function find_by_id_and_user_id($task_id, $user_id)
  {
    $task = \DB::select('tasks.id', 'tasks.project_id', 'tasks.title', 'tasks.body', 'tasks.status', 'tasks.created_at', 'tasks.updated_at')
      ->from('tasks')
      ->join('projects', 'INNER')
      ->on('tasks.project_id', '=', 'projects.id')
      ->where('tasks.id', '=', $task_id)
      ->where('projects.user_id', '=', $user_id)
      ->execute()
      ->current();

    return $task ?: array();
  }

  public static function find_status_target_by_id_and_user_id($task_id, $user_id)
  {
    $task = \DB::select('tasks.id', 'tasks.project_id', 'tasks.status')
      ->from('tasks')
      ->join('projects', 'INNER')
      ->on('tasks.project_id', '=', 'projects.id')
      ->where('tasks.id', '=', $task_id)
      ->where('projects.user_id', '=', $user_id)
      ->execute()
      ->current();

    return $task ?: array();
  }

  public static function create(array $attributes)
  {
    return \DB::insert('tasks')->set($attributes)->execute();
  }

  public static function update_by_id_and_project_id($task_id, $project_id, array $attributes)
  {
    return \DB::update('tasks')
      ->set($attributes)
      ->where('id', '=', $task_id)
      ->where('project_id', '=', $project_id)
      ->execute();
  }

  public static function delete_by_id_and_project_id($task_id, $project_id)
  {
    return \DB::delete('tasks')
      ->where('id', '=', $task_id)
      ->where('project_id', '=', $project_id)
      ->execute();
  }
}
