<?php

class Controller_Base extends Controller_Template
{
  public $template = 'template';

  protected $current_user = array();
  protected $auth_exempt_actions = array();

  public function before()
  {
    parent::before();

    header('X-Frame-Options: DENY');
    header("Content-Security-Policy: frame-ancestors 'none'");

    $this->current_user = $this->resolve_current_user();

    // テンプレートを使う画面では共通データを渡す
    if (is_object($this->template))
    {
      $this->template->title = 'HR Cloud';
      $this->template->current_user = $this->current_user;
      $this->template->flash_success = \Session::get_flash('success', '');
      $this->template->flash_error = \Session::get_flash('error', '');
      $this->template->content = '';
    }

    // 認証必須画面で未ログインならログイン画面へ戻す
    if ($this->requires_auth() and empty($this->current_user))
    {
      \Response::redirect('login');
    }
  }

  protected function requires_auth()
  {
    return ! in_array($this->get_current_action(), $this->auth_exempt_actions, true);
  }

  protected function get_current_action()
  {
    return \Request::active()->action;
  }

  protected function resolve_current_user()
  {
    if ( ! \Auth::check())
    {
      return array();
    }

    $user_id = \Auth::instance()->get_user_id();

    if ( ! is_array($user_id) or ! isset($user_id[1]))
    {
      return array();
    }

    return array(
      'id' => (int) $user_id[1],
      'name' => (string) \Auth::instance()->get('name', ''),
      'email' => (string) \Auth::instance()->get_email(),
      'username' => (string) \Auth::instance()->get('username', ''),
    );
  }
}
