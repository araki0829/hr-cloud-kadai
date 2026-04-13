<div class="auth-panel">
  <h2 class="auth-title">ログイン</h2>
  <p class="auth-description">登録済みのメールアドレスとパスワードでログインします。</p>

  <form class="auth-form" method="post" action="/login">
    <?php echo \Form::csrf(); ?>
    <?php if ( ! empty($errors['auth'])): ?>
      <div class="error-box"><?php echo e($errors['auth']); ?></div>
    <?php endif; ?>

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

    <button class="btn btn-primary auth-submit" type="submit">ログイン</button>
  </form>

  <p class="auth-link">
    <a href="/signup">新規登録はこちら</a>
  </p>
</div>
