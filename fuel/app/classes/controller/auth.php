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

		$this->template->title = 'ログイン | HR Cloud';
		$this->template->content = \View::forge('auth/login');
	}

	public function action_signup()
	{
		// すでにログイン済みなら一覧画面へ戻す
		if ( ! empty($this->current_user))
		{
			\Response::redirect('projects');
		}

		$this->template->title = '新規登録 | HR Cloud';
		$this->template->content = \View::forge('auth/signup');
	}

	public function action_logout()
	{
		\Session::delete('user');
		\Session::set_flash('success', 'ログアウトしました。');

		\Response::redirect('login');
	}
}
