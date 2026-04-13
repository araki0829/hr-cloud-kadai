<style>
	.auth-panel {
		max-width: 420px;
		margin: 24px auto;
	}
	.auth-title {
		margin: 0 0 8px;
		font-size: 28px;
		text-align: center;
	}
	.auth-description {
		margin: 0 0 24px;
		color: #667085;
		text-align: center;
	}
	.auth-form label {
		display: block;
		margin-bottom: 6px;
		font-weight: bold;
	}
	.auth-form .form-group {
		margin-bottom: 16px;
	}
	.auth-form .error-text {
		margin-top: 6px;
		color: #c53030;
		font-size: 13px;
	}
	.auth-form .error-box {
		margin-bottom: 16px;
		padding: 12px 14px;
		border: 1px solid #f3b5b5;
		border-radius: 6px;
		background: #fff5f5;
		color: #c53030;
	}
	.auth-form .form-control {
		height: 44px;
	}
	.auth-submit {
		width: 100%;
		height: 44px;
		font-weight: bold;
	}
	.auth-link {
		margin-top: 20px;
		text-align: center;
	}
</style>

<div class="auth-panel">
	<h2 class="auth-title">ログイン</h2>
	<p class="auth-description">登録済みのメールアドレスとパスワードでログインします。</p>

	<form class="auth-form" method="post" action="/login">
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
