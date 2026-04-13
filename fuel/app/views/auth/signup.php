<div class="w-420 mx-auto mt-24">
  <h2 class="auth-title">新規登録</h2>
  <p class="auth-description">アカウントを作成して、プロジェクトとタスクの管理を始めます。</p>

  <form class="auth-form" method="post" action="/signup">
    <?php echo \Form::csrf(); ?>
    <div class="form-group">
      <label for="name">ユーザ名</label>
      <input id="name" class="form-control" type="text" name="name" placeholder="ユーザ名を入力" value="<?php echo e($form['name']); ?>">
      <?php if ( ! empty($errors['name'])): ?>
        <p class="error-text"><?php echo e($errors['name']); ?></p>
      <?php endif; ?>
    </div>

    <div class="form-group">
      <label for="email">メールアドレス</label>
      <input id="email" class="form-control" type="email" name="email" placeholder="example@example.com" value="<?php echo e($form['email']); ?>">
      <?php if ( ! empty($errors['email'])): ?>
        <p class="error-text"><?php echo e($errors['email']); ?></p>
      <?php endif; ?>
    </div>

    <div class="form-group">
      <label for="password">パスワード</label>
      <input id="password" class="form-control" type="password" name="password" placeholder="パスワードを入力">
      <?php if ( ! empty($errors['password'])): ?>
        <p class="error-text"><?php echo e($errors['password']); ?></p>
      <?php endif; ?>
    </div>

    <div class="form-group">
      <label for="password_confirmation">パスワード確認</label>
      <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="確認用パスワードを入力">
      <?php if ( ! empty($errors['password_confirmation'])): ?>
        <p class="error-text"><?php echo e($errors['password_confirmation']); ?></p>
      <?php endif; ?>
    </div>

    <button class="btn btn-primary auth-submit" type="submit">新規登録</button>
  </form>

  <p class="auth-link mt-20">
    <a href="/login">ログインページへ</a>
  </p>
</div>
