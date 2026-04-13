<?php

class Controller_Tasks extends Controller_Base
{
	public function action_index($project_id)
	{
		$project = $this->find_project_for_current_user((int) $project_id);

		if (empty($project))
		{
			throw new \HttpNotFoundException();
		}

		$tasks = \DB::select('id', 'project_id', 'title', 'body', 'status', 'created_at', 'updated_at')
			->from('tasks')
			->where('project_id', '=', $project['id'])
			->order_by('updated_at', 'desc')
			->execute()
			->as_array();

		foreach ($tasks as &$task)
		{
			if ($task['body'] === null)
			{
				$task['body'] = '';
			}
		}
		unset($task);

		$status_list = \Config::get('task.status_list', array());

		$this->template->title = 'タスク一覧';
		$this->template->content = \View::forge('tasks/index', array(
			'project' => $project,
			'tasks' => $tasks,
			'status_list' => $status_list,
		));
	}

	protected function find_project_for_current_user($project_id)
	{
		$project = \DB::select('id', 'user_id', 'name', 'description')
			->from('projects')
			->where('id', '=', $project_id)
			->where('user_id', '=', $this->current_user['id'])
			->execute()
			->current();

		if ($project and $project['description'] === null)
		{
			$project['description'] = '';
		}

		return $project ?: array();
	}
}
