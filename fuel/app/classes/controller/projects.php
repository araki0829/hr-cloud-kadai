<?php

class Controller_Projects extends Controller_Base
{
	public function action_index()
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
			'mode' => 'create',
			'form_title' => 'プロジェクト作成',
			'form_description' => '新しいプロジェクト名と説明を登録します。',
			'form_action' => '/projects/create',
			'submit_label' => '保存',
			'form' => $form,
			'errors' => $errors,
		));
	}
}
