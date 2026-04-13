<h2>新規登録</h2>
<p>新規登録機能は次のステップで実装します。</p>

<form method="post" action="/signup">
	<div class="form-group">
		<label for="name">ユーザ名</label>
		<input id="name" class="form-control" type="text" name="name">
	</div>

	<div class="form-group">
		<label for="email">メールアドレス</label>
		<input id="email" class="form-control" type="email" name="email">
	</div>

	<div class="form-group">
		<label for="password">パスワード</label>
		<input id="password" class="form-control" type="password" name="password">
	</div>

	<div class="form-group">
		<label for="password_confirmation">パスワード確認</label>
		<input id="password_confirmation" class="form-control" type="password" name="password_confirmation">
	</div>

	<button class="btn btn-primary" type="submit">登録する</button>
</form>
