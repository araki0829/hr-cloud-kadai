<?php

class Controller_Base extends Controller_Template
{
  public $template = 'template';

  protected $current_user = null;
  protected $auth_exempt_actions = array();

  public function before()
  {
    parent::before();

    // セッションからログイン中ユーザを取得する
    $this->current_user = \Session::get('user', array());

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
}
