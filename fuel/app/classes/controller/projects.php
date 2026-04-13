<?php

class Controller_Projects extends Controller_Base
{
	public function get_index()
	{
		$projects = $this->fetch_projects_for_current_user();

		$this->template->title = 'プロジェクト一覧';
		$this->template->content = \View::forge('projects/index', array(
			'current_user_name' => $this->current_user['name'],
			'projects' => $projects,
		));
	}

	public function get_create()
	{
		$this->render_form(array(
			'form_title' => 'プロジェクト作成',
			'form_description' => '新しいプロジェクト名と説明を登録します。',
			'form_action' => '/projects/create',
			'submit_label' => '保存',
			'form' => array(
				'name' => '',
				'description' => '',
			),
			'errors' => array(),
		));
	}

	public function post_create()
	{
		$form = array(
			'name' => trim((string) \Input::post('name', '')),
			'description' => trim((string) \Input::post('description', '')),
		);
		$errors = $this->validate_project_form($form);

		if (empty($errors))
		{
			$now = time();

			\DB::insert('projects')->set(array(
				'user_id' => $this->current_user['id'],
				'name' => $form['name'],
				'description' => $form['description'] !== '' ? $form['description'] : null,
				'created_at' => $now,
				'updated_at' => $now,
			))->execute();

			\Response::redirect('projects');
		}

		$this->render_form(array(
			'form_title' => 'プロジェクト作成',
			'form_description' => '新しいプロジェクト名と説明を登録します。',
			'form_action' => '/projects/create',
			'submit_label' => '保存',
			'form' => $form,
			'errors' => $errors,
		));
	}

	public function get_edit($project_id)
	{
		$project = $this->find_project_for_current_user((int) $project_id);

		if (empty($project))
		{
			throw new \HttpNotFoundException();
		}

		$this->render_form(array(
			'form_title' => 'プロジェクト編集',
			'form_description' => '登録済みのプロジェクト情報を更新します。',
			'form_action' => '/projects/edit/'.$project['id'],
			'submit_label' => '更新',
			'form' => array(
				'name' => $project['name'],
				'description' => $project['description'],
			),
			'errors' => array(),
		));
	}

	public function post_edit($project_id)
	{
		$project = $this->find_project_for_current_user((int) $project_id);

		if (empty($project))
		{
			throw new \HttpNotFoundException();
		}

		$form = array(
			'name' => trim((string) \Input::post('name', '')),
			'description' => trim((string) \Input::post('description', '')),
		);
		$errors = $this->validate_project_form($form);

		if (empty($errors))
		{
			\DB::update('projects')
				->set(array(
					'name' => $form['name'],
					'description' => $form['description'] !== '' ? $form['description'] : null,
					'updated_at' => time(),
				))
				->where('id', '=', $project['id'])
				->where('user_id', '=', $this->current_user['id'])
				->execute();

			\Response::redirect('projects');
		}

		$this->render_form(array(
			'form_title' => 'プロジェクト編集',
			'form_description' => '登録済みのプロジェクト情報を更新します。',
			'form_action' => '/projects/edit/'.$project['id'],
			'submit_label' => '更新',
			'form' => $form,
			'errors' => $errors,
		));
	}

	public function post_delete($project_id)
	{
		$project = $this->find_project_for_current_user((int) $project_id);

		if (empty($project))
		{
			throw new \HttpNotFoundException();
		}

		\DB::delete('projects')
			->where('id', '=', $project['id'])
			->where('user_id', '=', $this->current_user['id'])
			->execute();

		\Response::redirect('projects');
	}

	protected function render_form(array $view_data)
	{
		$this->template->title = $view_data['form_title'];
		$this->template->content = \View::forge('projects/form', $view_data);
	}

	protected function validate_project_form(array $form)
	{
		$errors = array();

		if ($form['name'] === '')
		{
			$errors['name'] = 'プロジェクト名を入力してください。';
		}
		elseif (mb_strlen($form['name']) > 100)
		{
			$errors['name'] = 'プロジェクト名は100文字以内で入力してください。';
		}

		if (mb_strlen($form['description']) > 65535)
		{
			$errors['description'] = '説明が長すぎます。内容を短くしてください。';
		}

		return $errors;
	}

	protected function fetch_projects_for_current_user()
	{
		$projects = \DB::select('id', 'name', 'description', 'created_at', 'updated_at')
			->from('projects')
			->where('user_id', '=', $this->current_user['id'])
			->order_by('updated_at', 'desc')
			->execute()
			->as_array();

		foreach ($projects as &$project)
		{
			$project = $this->format_project_for_display($project);
		}
		unset($project);

		return $projects;
	}

	protected function find_project_for_current_user($project_id)
	{
		$project = \DB::select('id', 'user_id', 'name', 'description', 'created_at', 'updated_at')
			->from('projects')
			->where('id', '=', $project_id)
			->where('user_id', '=', $this->current_user['id'])
			->execute()
			->current();

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

	protected function format_project_for_display(array $project)
	{
		$description = $project['description'] === null ? '' : $project['description'];
		$project['description'] = $description;
		$project['description_display'] = $description !== '' ? $description : '説明は未登録です。';
		$project['updated_at_display'] = $project['updated_at'] ? date('Y-m-d H:i', $project['updated_at']) : '-';

		return $project;
	}
}
