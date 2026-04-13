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
			<input id="name" class="form-control" type="text" name="name" placeholder="ユーザ名を入力">
		</div>

		<div class="form-group">
			<label for="email">メールアドレス</label>
			<input id="email" class="form-control" type="email" name="email" placeholder="example@example.com">
		</div>

		<div class="form-group">
			<label for="password">パスワード</label>
			<input id="password" class="form-control" type="password" name="password" placeholder="パスワードを入力">
		</div>

		<div class="form-group">
			<label for="password_confirmation">パスワード確認</label>
			<input id="password_confirmation" class="form-control" type="password" name="password_confirmation" placeholder="確認用パスワードを入力">
		</div>

		<button class="btn btn-primary auth-submit" type="submit">新規登録</button>
	</form>

	<p class="auth-link">
		<a href="/login">ログインページへ</a>
	</p>
</div>
