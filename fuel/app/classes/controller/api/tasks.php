<?php

class Controller_Api_Tasks extends Controller_Base
{
	public $template = null;

	public function action_change_status()
	{
		if (\Input::method() !== 'POST')
		{
			return $this->json_response(array(
				'success' => false,
				'message' => 'Method Not Allowed',
				'csrf_token' => \Security::fetch_token(),
			), 405);
		}

		$task_id = (int) \Input::post('task_id', 0);
		$status = (int) \Input::post('status', -1);
		$status_list = $this->get_task_status_list();

		if ($task_id <= 0)
		{
			return $this->json_response(array(
				'success' => false,
				'message' => 'task_id is required.',
				'csrf_token' => \Security::fetch_token(),
			), 400);
		}

		if ( ! array_key_exists($status, $status_list))
		{
			return $this->json_response(array(
				'success' => false,
				'message' => 'status is invalid.',
				'csrf_token' => \Security::fetch_token(),
			), 400);
		}

		$task = $this->find_task_for_current_user($task_id);

		if (empty($task))
		{
			return $this->json_response(array(
				'success' => false,
				'message' => 'Task not found.',
				'csrf_token' => \Security::fetch_token(),
			), 404);
		}

		\DB::update('tasks')
			->set(array(
				'status' => $status,
				'updated_at' => time(),
			))
			->where('id', '=', $task['id'])
			->where('project_id', '=', $task['project_id'])
			->execute();

		return $this->json_response(array(
			'success' => true,
			'task_id' => $task['id'],
			'status' => $status,
			'status_label' => $status_list[$status],
			'csrf_token' => \Security::fetch_token(),
		));
	}

	protected function get_task_status_list()
	{
		\Config::load('task', true);

		return \Config::get('task.status_list', array());
	}

	protected function find_task_for_current_user($task_id)
	{
		$task = \DB::select('tasks.id', 'tasks.project_id', 'tasks.status')
			->from('tasks')
			->join('projects', 'INNER')
			->on('tasks.project_id', '=', 'projects.id')
			->where('tasks.id', '=', $task_id)
			->where('projects.user_id', '=', $this->current_user['id'])
			->execute()
			->current();

		return $task ?: array();
	}

	protected function json_response(array $payload, $status = 200)
	{
		return \Response::forge(
			json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
			$status,
			array('Content-Type' => 'application/json; charset=UTF-8')
		);
	}
}
