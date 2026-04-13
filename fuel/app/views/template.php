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
			background: #1f3a5f;
			color: #fff;
			padding: 16px 0;
			margin-bottom: 24px;
		}
		.app-header a {
			color: #fff;
			margin-right: 16px;
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
					<h1>HR Cloud</h1>
					<p class="user-status">
						<?php if ( ! empty($current_user)): ?>
							ログイン中: <?php echo $current_user['name']; ?>
						<?php else: ?>
							未ログイン
						<?php endif; ?>
					</p>
				</div>
				<div class="col-md-4 text-right">
					<nav>
						<a href="/login">ログイン</a>
						<a href="/signup">新規登録</a>
						<a href="/projects">プロジェクト一覧</a>
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
