<style>
	.task-form-panel {
		max-width: 680px;
		margin: 0 auto;
	}
	.task-form-title {
		margin: 0 0 8px;
		font-size: 28px;
	}
	.task-form-description {
		margin: 0 0 24px;
		color: #667085;
	}
	.task-project-summary {
		margin-bottom: 20px;
		padding: 16px 18px;
		border: 1px solid #d9e0ea;
		border-radius: 8px;
		background: #f8fafc;
	}
	.task-project-summary h3 {
		margin: 0 0 8px;
		font-size: 18px;
	}
	.task-project-summary p {
		margin: 0;
		color: #475467;
	}
	.task-form .form-group {
		margin-bottom: 18px;
	}
	.task-form label {
		display: block;
		margin-bottom: 6px;
		font-weight: bold;
	}
	.task-form .form-control {
		width: 100%;
		padding: 10px 12px;
		min-height: 44px;
		border: 1px solid #cbd5e1;
		border-radius: 6px;
		box-sizing: border-box;
	}
	.task-form textarea.form-control {
		min-height: 140px;
		resize: vertical;
	}
	.task-form .error-text {
		margin-top: 6px;
		color: #c53030;
		font-size: 13px;
	}
	.task-form-actions {
		display: flex;
		gap: 12px;
		align-items: center;
	}
	.task-submit-button {
		border: none;
		border-radius: 6px;
		background: #2563eb;
		color: #fff;
		padding: 10px 18px;
		cursor: pointer;
	}
	.task-cancel-link {
		color: #475467;
		text-decoration: none;
	}
</style>

<div class="task-form-panel">
	<h2 class="task-form-title"><?php echo e($form_title); ?></h2>
	<p class="task-form-description"><?php echo e($form_description); ?></p>

	<div class="task-project-summary">
		<h3><?php echo e($project['name']); ?></h3>
		<p><?php echo e($project['description_display']); ?></p>
	</div>

	<form class="task-form" method="post" action="<?php echo e($form_action); ?>">
		<?php echo \Form::csrf(); ?>
		<div class="form-group">
			<label for="title">タスク名</label>
			<input id="title" class="form-control" type="text" name="title" value="<?php echo e($form['title']); ?>" placeholder="タスク名を入力">
			<?php if ( ! empty($errors['title'])): ?>
				<p class="error-text"><?php echo e($errors['title']); ?></p>
			<?php endif; ?>
		</div>

		<div class="form-group">
			<label for="body">詳細</label>
			<textarea id="body" class="form-control" name="body" placeholder="タスクの詳細を入力"><?php echo e($form['body']); ?></textarea>
			<?php if ( ! empty($errors['body'])): ?>
				<p class="error-text"><?php echo e($errors['body']); ?></p>
			<?php endif; ?>
		</div>

		<div class="form-group">
			<label for="status">状態</label>
			<select id="status" class="form-control" name="status">
				<?php foreach ($status_list as $status_value => $status_label): ?>
					<option value="<?php echo e($status_value); ?>"<?php echo (string) $form['status'] === (string) $status_value ? ' selected' : ''; ?>>
						<?php echo e($status_label); ?>
					</option>
				<?php endforeach; ?>
			</select>
			<?php if ( ! empty($errors['status'])): ?>
				<p class="error-text"><?php echo e($errors['status']); ?></p>
			<?php endif; ?>
		</div>

		<div class="task-form-actions">
			<button class="task-submit-button" type="submit"><?php echo e($submit_label); ?></button>
			<a class="task-cancel-link" href="/projects/<?php echo e($project['id']); ?>/tasks">一覧へ戻る</a>
		</div>
	</form>
</div>
