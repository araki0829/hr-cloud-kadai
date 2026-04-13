<?php

class Controller_Projects extends Controller_Base
{
	public function action_index()
	{
		$projects = $this->fetch_projects_for_current_user();

		$this->template->title = 'プロジェクト一覧';
		$this->template->content = \View::forge('projects/index', array(
			'current_user' => $this->current_user,
			'projects' => $projects,
		));
	}

	public function action_create()
	{
		$form = array(
			'name' => '',
			'description' => '',
		);
		$errors = array();

		if (\Input::method() === 'POST')
		{
			$form['name'] = trim((string) \Input::post('name', ''));
			$form['description'] = trim((string) \Input::post('description', ''));

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
		}

		$this->template->title = 'プロジェクト作成';
		$this->template->content = \View::forge('projects/form', array(
			'form_title' => 'プロジェクト作成',
			'form_description' => '新しいプロジェクト名と説明を登録します。',
			'form_action' => '/projects/create',
			'submit_label' => '保存',
			'form' => $form,
			'errors' => $errors,
		));
	}

	public function action_edit($project_id)
	{
		$project = $this->find_project_for_current_user((int) $project_id);

		if (empty($project))
		{
			throw new \HttpNotFoundException();
		}

		$form = array(
			'name' => $project['name'],
			'description' => $project['description'],
		);
		$errors = array();

		if (\Input::method() === 'POST')
		{
			$form['name'] = trim((string) \Input::post('name', ''));
			$form['description'] = trim((string) \Input::post('description', ''));
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
		}

		$this->template->title = 'プロジェクト編集';
		$this->template->content = \View::forge('projects/form', array(
			'form_title' => 'プロジェクト編集',
			'form_description' => '登録済みのプロジェクト情報を更新します。',
			'form_action' => '/projects/edit/'.$project['id'],
			'submit_label' => '更新',
			'form' => $form,
			'errors' => $errors,
		));
	}

	public function action_delete($project_id)
	{
		if (\Input::method() !== 'POST')
		{
			\Response::redirect('projects');
		}

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
			if ($project['description'] === null)
			{
				$project['description'] = '';
			}
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

		if ($project and $project['description'] === null)
		{
			$project['description'] = '';
		}

		return $project ?: array();
	}
}
