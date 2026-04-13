<?php

class Controller_Tasks extends Controller_Base
{
  public function get_index($project_id)
  {
    $project = $this->find_project_for_current_user((int) $project_id);

    if (empty($project))
    {
      throw new \HttpNotFoundException();
    }

    $tasks = \Model_Task::find_all_by_project_id($project['id']);

    foreach ($tasks as &$task)
    {
      $task = $this->format_task_for_display($task);
    }
    unset($task);

    $status_list = $this->get_task_status_list();

    $this->template->title = 'タスク一覧';
    $this->template->content = \View::forge('tasks/index', array(
      'project' => $this->format_project_for_display($project),
      'tasks' => $tasks,
      'status_list' => $status_list,
    ));
  }

  public function get_create($project_id)
  {
    $project = $this->find_project_for_current_user((int) $project_id);

    if (empty($project))
    {
      throw new \HttpNotFoundException();
    }

    $status_list = $this->get_task_status_list();
    $this->render_form(array(
      'project' => $this->format_project_for_display($project),
      'form_title' => 'タスク作成',
      'form_description' => '新しいタスクを登録します。',
      'form_action' => '/projects/'.$project['id'].'/tasks/create',
      'submit_label' => '保存',
      'form' => array(
        'title' => '',
        'body' => '',
        'status' => 0,
      ),
      'errors' => array(),
      'status_list' => $status_list,
    ));
  }

  public function post_create($project_id)
  {
    $project = $this->find_project_for_current_user((int) $project_id);

    if (empty($project))
    {
      throw new \HttpNotFoundException();
    }

    $form = array(
      'title' => trim((string) \Input::post('title', '')),
      'body' => trim((string) \Input::post('body', '')),
      'status' => (int) \Input::post('status', 0),
    );
    $status_list = $this->get_task_status_list();
    $errors = $this->validate_task_form($form, $status_list);

    if (empty($errors))
    {
      $now = time();

      \Model_Task::create(array(
        'project_id' => $project['id'],
        'title' => $form['title'],
        'body' => $form['body'] !== '' ? $form['body'] : null,
        'status' => $form['status'],
        'created_at' => $now,
        'updated_at' => $now,
      ));

      \Response::redirect('projects/'.$project['id'].'/tasks');
    }

    $this->render_form(array(
      'project' => $this->format_project_for_display($project),
      'form_title' => 'タスク作成',
      'form_description' => '新しいタスクを登録します。',
      'form_action' => '/projects/'.$project['id'].'/tasks/create',
      'submit_label' => '保存',
      'form' => $form,
      'errors' => $errors,
      'status_list' => $status_list,
    ));
  }

  public function get_edit($task_id)
  {
    $task = $this->find_task_for_current_user((int) $task_id);

    if (empty($task))
    {
      throw new \HttpNotFoundException();
    }

    $project = $this->find_project_for_current_user((int) $task['project_id']);
    $status_list = $this->get_task_status_list();

    $this->render_form(array(
      'project' => $this->format_project_for_display($project),
      'form_title' => 'タスク編集',
      'form_description' => '登録済みのタスク情報を更新します。',
      'form_action' => '/tasks/edit/'.$task['id'],
      'submit_label' => '更新',
      'form' => array(
        'title' => $task['title'],
        'body' => $task['body'],
        'status' => $task['status'],
      ),
      'errors' => array(),
      'status_list' => $status_list,
    ));
  }

  public function post_edit($task_id)
  {
    $task = $this->find_task_for_current_user((int) $task_id);

    if (empty($task))
    {
      throw new \HttpNotFoundException();
    }

    $project = $this->find_project_for_current_user((int) $task['project_id']);
    $status_list = $this->get_task_status_list();
    $form = array(
      'title' => trim((string) \Input::post('title', '')),
      'body' => trim((string) \Input::post('body', '')),
      'status' => (int) \Input::post('status', 0),
    );
    $errors = $this->validate_task_form($form, $status_list);

    if (empty($errors))
    {
      \Model_Task::update_by_id_and_project_id($task['id'], $task['project_id'], array(
        'title' => $form['title'],
        'body' => $form['body'] !== '' ? $form['body'] : null,
        'status' => $form['status'],
        'updated_at' => time(),
      ));

      \Response::redirect('projects/'.$task['project_id'].'/tasks');
    }

    $this->render_form(array(
      'project' => $this->format_project_for_display($project),
      'form_title' => 'タスク編集',
      'form_description' => '登録済みのタスク情報を更新します。',
      'form_action' => '/tasks/edit/'.$task['id'],
      'submit_label' => '更新',
      'form' => $form,
      'errors' => $errors,
      'status_list' => $status_list,
    ));
  }

  public function post_delete($task_id)
  {
    $task = $this->find_task_for_current_user((int) $task_id);

    if (empty($task))
    {
      throw new \HttpNotFoundException();
    }

    \Model_Task::delete_by_id_and_project_id($task['id'], $task['project_id']);

    \Response::redirect('projects/'.$task['project_id'].'/tasks');
  }

  protected function render_form(array $view_data)
  {
    $this->template->title = $view_data['form_title'];
    $this->template->content = \View::forge('tasks/form', $view_data);
  }

  protected function validate_task_form(array $form, array $status_list)
  {
    $errors = array();

    if ($form['title'] === '')
    {
      $errors['title'] = 'タスク名を入力してください。';
    }
    elseif (mb_strlen($form['title']) > 100)
    {
      $errors['title'] = 'タスク名は100文字以内で入力してください。';
    }

    if (mb_strlen($form['body']) > 65535)
    {
      $errors['body'] = '詳細が長すぎます。内容を短くしてください。';
    }

    if ( ! array_key_exists($form['status'], $status_list))
    {
      $errors['status'] = '状態の値が不正です。';
    }

    return $errors;
  }

  protected function get_task_status_list()
  {
    \Config::load('task', true);

    return \Config::get('task.status_list', array());
  }

  protected function find_project_for_current_user($project_id)
  {
    $project = \Model_Project::find_by_id_and_user_id($project_id, $this->current_user['id']);

    if ( ! $project)
    {
      return array();
    }

    if ($project['description'] === null)
    {
      $project['description'] = '';
    }

    return $project;
  }

  protected function find_task_for_current_user($task_id)
  {
    $task = \Model_Task::find_by_id_and_user_id($task_id, $this->current_user['id']);

    if ( ! $task)
    {
      return array();
    }

    if ($task['body'] === null)
    {
      $task['body'] = '';
    }

    return $task;
  }

  protected function format_project_for_display(array $project)
  {
    $description = $project['description'] === '' ? 'プロジェクト説明は未登録です。' : $project['description'];
    $project['description_display'] = $description;

    return $project;
  }

  protected function format_task_for_display(array $task)
  {
    $body = $task['body'] === null ? '' : $task['body'];
    $task['body'] = $body;
    $task['body_display'] = $body !== '' ? $body : '詳細は未登録です。';
    $task['updated_at_display'] = $task['updated_at'] ? date('Y-m-d H:i', $task['updated_at']) : '-';

    return $task;
  }
}
