<h2>プロジェクト一覧</h2>
<p>ログイン後の遷移確認用に、仮の一覧画面を表示しています。</p>

<?php if ( ! empty($current_user)): ?>
	<p>ようこそ、<?php echo e($current_user['name']); ?> さん。</p>
<?php endif; ?>
