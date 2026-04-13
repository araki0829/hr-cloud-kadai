<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="/assets/css/bootstrap.css">
	<style>
		body {
			background: #f7f8fc;
		}
		.app-header {
			background: #111111;
			color: #fff;
			padding: 16px 0;
			margin-bottom: 24px;
		}
		.app-header a {
			color: #fff;
			margin-right: 16px;
		}
		.app-header-nav {
			display: flex;
			justify-content: flex-end;
			align-items: center;
			flex-wrap: wrap;
			gap: 12px;
		}
		.logout-form {
			display: inline-block;
			margin: 0;
		}
		.logout-button {
			border: 1px solid rgba(255, 255, 255, 0.6);
			background: transparent;
			color: #fff;
			padding: 6px 12px;
			border-radius: 4px;
			cursor: pointer;
		}
		.logout-button:hover {
			background: rgba(255, 255, 255, 0.12);
		}
		.app-card {
			background: #fff;
			border: 1px solid #d9e0ea;
			border-radius: 8px;
			padding: 24px;
			box-shadow: 0 4px 16px rgba(31, 58, 95, 0.08);
		}
		.flash-message {
			margin-bottom: 16px;
		}
		.user-status {
			margin: 0;
			font-size: 14px;
		}
	</style>
</head>
<body>
	<header class="app-header">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<!-- <h1>HR Cloud</h1> -->
					<p class="user-status">
						<!-- <?php if ( ! empty($current_user)): ?>
							ログイン中: <?php echo $current_user['name']; ?>
						<?php else: ?>
							未ログイン
						<?php endif; ?> -->
					</p>
				</div>
				<div class="col-md-4 text-right">
					<nav class="app-header-nav">
						<a href="/projects">プロジェクト一覧</a>
						<?php if ( ! empty($current_user)): ?>
							<form class="logout-form" method="post" action="/logout">
								<button class="logout-button" type="submit">ログアウト</button>
							</form>
						<?php else: ?>
							<a href="/login">ログイン</a>
							<a href="/signup">新規登録</a>
						<?php endif; ?>
					</nav>
				</div>
			</div>
		</div>
	</header>

	<main class="container">
		<?php if ( ! empty($flash_success)): ?>
			<div class="alert alert-success flash-message">
				<?php echo $flash_success; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty($flash_error)): ?>
			<div class="alert alert-danger flash-message">
				<?php echo $flash_error; ?>
			</div>
		<?php endif; ?>

		<div class="app-card">
			<?php echo $content; ?>
		</div>
	</main>
</body>
</html>
