<h2>ログイン</h2>
<p>ログイン機能は次のステップで実装します。</p>

<form method="post" action="/login">
	<div class="form-group">
		<label for="email">メールアドレス</label>
		<input id="email" class="form-control" type="email" name="email">
	</div>

	<div class="form-group">
		<label for="password">パスワード</label>
		<input id="password" class="form-control" type="password" name="password">
	</div>

	<button class="btn btn-primary" type="submit">ログイン</button>
</form>
