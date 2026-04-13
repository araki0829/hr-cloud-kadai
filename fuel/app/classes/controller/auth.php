<?php

class Controller_Auth extends Controller_Base
{
	protected $auth_exempt_actions = array('login', 'signup');

	public function action_login()
	{
		// すでにログイン済みなら一覧画面へ戻す
		if ( ! empty($this->current_user))
		{
			\Response::redirect('projects');
		}

		$form = array(
			'email' => '',
		);
		$errors = array();

		if (\Input::method() === 'POST')
		{
			$form['email'] = trim((string) \Input::post('email', ''));
			$password = (string) \Input::post('password', '');

			if ($form['email'] === '')
			{
				$errors['email'] = 'メールアドレスを入力してください。';
			}
			elseif ( ! filter_var($form['email'], FILTER_VALIDATE_EMAIL))
			{
				$errors['email'] = 'メールアドレスの形式が正しくありません。';
			}

			if ($password === '')
			{
				$errors['password'] = 'パスワードを入力してください。';
			}

			if (empty($errors))
			{
				$user = \DB::select('id', 'name', 'email', 'password')
					->from('users')
					->where('email', '=', $form['email'])
					->execute()
					->current();

				if (empty($user) or ! password_verify($password, $user['password']))
				{
					$errors['auth'] = 'メールアドレスまたはパスワードが正しくありません。';
				}
				else
				{
					\Session::set('user', array(
						'id' => $user['id'],
						'name' => $user['name'],
						'email' => $user['email'],
					));
					\Session::set_flash('success', 'ログインしました。');

					\Response::redirect('projects');
				}
			}

			if ( ! empty($errors))
			{
				\Session::set_flash('error', 'ログインに失敗しました。');
			}
		}

		$this->template->title = 'ログイン | HR Cloud';
		$this->template->content = \View::forge('auth/login', array(
			'form' => $form,
			'errors' => $errors,
		));
	}

	public function action_signup()
	{
		// すでにログイン済みなら一覧画面へ戻す
		if ( ! empty($this->current_user))
		{
			\Response::redirect('projects');
		}

		$form = array(
			'name' => '',
			'email' => '',
		);
		$errors = array();

		if (\Input::method() === 'POST')
		{
			$form['name'] = trim((string) \Input::post('name', ''));
			$form['email'] = trim((string) \Input::post('email', ''));
			$password = (string) \Input::post('password', '');
			$password_confirmation = (string) \Input::post('password_confirmation', '');

			if ($form['name'] === '')
			{
				$errors['name'] = 'ユーザ名を入力してください。';
			}
			elseif (mb_strlen($form['name']) > 100)
			{
				$errors['name'] = 'ユーザ名は100文字以内で入力してください。';
			}

			if ($form['email'] === '')
			{
				$errors['email'] = 'メールアドレスを入力してください。';
			}
			elseif ( ! filter_var($form['email'], FILTER_VALIDATE_EMAIL))
			{
				$errors['email'] = 'メールアドレスの形式が正しくありません。';
			}
			elseif (mb_strlen($form['email']) > 255)
			{
				$errors['email'] = 'メールアドレスは255文字以内で入力してください。';
			}

			if ($password === '')
			{
				$errors['password'] = 'パスワードを入力してください。';
			}
			elseif (strlen($password) < 8)
			{
				$errors['password'] = 'パスワードは8文字以上で入力してください。';
			}

			if ($password_confirmation === '')
			{
				$errors['password_confirmation'] = '確認用パスワードを入力してください。';
			}
			elseif ($password !== $password_confirmation)
			{
				$errors['password_confirmation'] = 'パスワードと確認用パスワードが一致しません。';
			}

			if (empty($errors))
			{
				$existing_user = \DB::select('id')
					->from('users')
					->where('email', '=', $form['email'])
					->execute()
					->as_array();

				if ( ! empty($existing_user))
				{
					$errors['email'] = 'このメールアドレスはすでに登録されています。';
				}
			}

			if (empty($errors))
			{
				$now = time();

				\DB::insert('users')->set(array(
					'name' => $form['name'],
					'email' => $form['email'],
					'password' => password_hash($password, PASSWORD_DEFAULT),
					'created_at' => $now,
					'updated_at' => $now,
				))->execute();

				\Response::redirect('login');
			}

			\Session::set_flash('error', '入力内容を確認してください。');
		}

		$this->template->title = '新規登録 | HR Cloud';
		$this->template->content = \View::forge('auth/signup', array(
			'form' => $form,
			'errors' => $errors,
		));
	}

	public function action_logout()
	{
		\Session::delete('user');
		\Response::redirect('login');
	}
}
