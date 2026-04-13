<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
</head>
<body>
	<?php if ( ! empty($current_user)): ?>
		<p>ログイン中: <?php echo $current_user['name']; ?></p>
	<?php endif; ?>

	<?php if ( ! empty($flash_success)): ?>
		<p><?php echo $flash_success; ?></p>
	<?php endif; ?>

	<?php if ( ! empty($flash_error)): ?>
		<p><?php echo $flash_error; ?></p>
	<?php endif; ?>

	<?php echo $content; ?>
</body>
</html>
