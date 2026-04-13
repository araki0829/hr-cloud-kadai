<?php

class Controller_Api_Tasks extends Controller_Base
{
	public $template = null;

	public function post_change_status()
	{
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

		$task = \Model_Task::find_status_target_by_id_and_user_id($task_id, $this->current_user['id']);

		if (empty($task))
		{
			return $this->json_response(array(
				'success' => false,
				'message' => 'Task not found.',
				'csrf_token' => \Security::fetch_token(),
			), 404);
		}

		\Model_Task::update_by_id_and_project_id($task['id'], $task['project_id'], array(
			'status' => $status,
			'updated_at' => time(),
		));

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

	protected function json_response(array $payload, $status = 200)
	{
		return \Response::forge(
			json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
			$status,
			array('Content-Type' => 'application/json; charset=UTF-8')
		);
	}
}
