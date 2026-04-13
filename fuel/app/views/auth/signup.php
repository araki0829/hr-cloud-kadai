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
	<h2 class="auth-title">新規登録</h2>
	<p class="auth-description">アカウントを作成して、プロジェクトとタスクの管理を始めます。</p>

	<form class="auth-form" method="post" action="/signup">
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

	<p class="auth-link">
		<a href="/login">ログインページへ</a>
	</p>
</div>
