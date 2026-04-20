<?php

class Controller_Auth extends Controller_Base
{
  protected $auth_exempt_actions = array('login', 'signup');

  public function get_login()
  {
    if ( ! empty($this->current_user))
    {
      \Response::redirect('projects');
    }
    // ログイン画面で前回入力したメールアドレスを覚える
    $this->render_login(array(
      'email' => (string) \Cookie::get('remember_email', ''),
    ), array());
  }

  public function post_login()
  {
    if ( ! empty($this->current_user))
    {
      \Response::redirect('projects');
    }

    $form = array(
      'email' => trim((string) \Input::post('email', '')),
    );
    $password = (string) \Input::post('password', '');
    $errors = array();

    if ($form['email'] !== '')
    {
      \Cookie::set('remember_email', $form['email']);
    }

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
      if ($this->attempt_auth_login($form['email'], $password))
      {
        \Session::set_flash('success', 'ログインしました。');
        \Response::redirect('projects');
      }

      $errors['auth'] = 'メールアドレスまたはパスワードが正しくありません。';
    }

    if ( ! empty($errors))
    {
      \Session::set_flash('error', 'ログインに失敗しました。');
    }

    $this->render_login($form, $errors);
  }

  public function get_signup()
  {
    if ( ! empty($this->current_user))
    {
      \Response::redirect('projects');
    }

    $this->render_signup(array(
      'name' => '',
      'email' => '',
    ), array());
  }

  public function post_signup()
  {
    if ( ! empty($this->current_user))
    {
      \Response::redirect('projects');
    }

    $form = array(
      'name' => trim((string) \Input::post('name', '')),
      'email' => trim((string) \Input::post('email', '')),
    );
    $password = (string) \Input::post('password', '');
    $password_confirmation = (string) \Input::post('password_confirmation', '');
    $errors = array();

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
      if (\Model_User::exists_by_email($form['email']))
      {
        $errors['email'] = 'このメールアドレスはすでに登録されています。';
      }
    }

    if (empty($errors))
    {
      $now = time();

      \Model_User::create(array(
        'name' => $form['name'],
        'username' => $form['email'],
        'email' => $form['email'],
        'password' => \Auth::instance()->hash_password($password),
        'group' => 1,
        'last_login' => 0,
        'login_hash' => '',
        'profile_fields' => serialize(array('name' => $form['name'])),
        'created_at' => $now,
        'updated_at' => $now,
      ));

      \Response::redirect('login');
    }

    \Session::set_flash('error', '入力内容を確認してください。');
    $this->render_signup($form, $errors);
    }
// セッション固定攻撃対策
  public function post_logout()
  {
    \Auth::logout();
    \Session::instance()->rotate();
    \Response::redirect('login');
  }

  protected function attempt_auth_login($email, $password)
  {
    if (\Auth::login($email, $password))
    {
      return true;
    }

    $legacy_user = \Model_User::find_by_email($email);

    if (empty($legacy_user) or ! password_verify($password, $legacy_user['password']))
    {
      return false;
    }

    \Model_User::update_by_id($legacy_user['id'], array(
      'username' => $legacy_user['email'],
      'password' => \Auth::instance()->hash_password($password),
      'group' => 1,
      'last_login' => 0,
      'login_hash' => '',
      'profile_fields' => serialize(array('name' => $legacy_user['name'])),
      'updated_at' => time(),
    ));

    return \Auth::login($email, $password);
  }

  protected function render_login(array $form, array $errors)
  {
    $this->template->title = 'ログイン | HR Cloud';
    $this->template->content = \View::forge('auth/login', array(
      'form' => $form,
      'errors' => $errors,
    ));
  }

  protected function render_signup(array $form, array $errors)
  {
    $this->template->title = '新規登録 | HR Cloud';
    $this->template->content = \View::forge('auth/signup', array(
      'form' => $form,
      'errors' => $errors,
    ));
  }
}
