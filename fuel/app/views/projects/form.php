<style>
	.project-form-panel {
		max-width: 640px;
		margin: 0 auto;
	}
	.project-form-title {
		margin: 0 0 8px;
		font-size: 28px;
	}
	.project-form-description {
		margin: 0 0 24px;
		color: #667085;
	}
	.project-form .form-group {
		margin-bottom: 18px;
	}
	.project-form label {
		display: block;
		margin-bottom: 6px;
		font-weight: bold;
	}
	.project-form .form-control {
		width: 100%;
		padding: 10px 12px;
		border: 1px solid #cbd5e1;
		border-radius: 6px;
		box-sizing: border-box;
	}
	.project-form textarea.form-control {
		min-height: 140px;
		resize: vertical;
	}
	.project-form .error-text {
		margin-top: 6px;
		color: #c53030;
		font-size: 13px;
	}
	.project-form-actions {
		display: flex;
		gap: 12px;
		align-items: center;
	}
	.project-submit-button {
		border: none;
		border-radius: 6px;
		background: #2563eb;
		color: #fff;
		padding: 10px 18px;
		cursor: pointer;
	}
	.project-cancel-link {
		color: #475467;
		text-decoration: none;
	}
</style>

<div class="project-form-panel">
	<h2 class="project-form-title"><?php echo e($form_title); ?></h2>
	<p class="project-form-description"><?php echo e($form_description); ?></p>

	<form class="project-form" method="post" action="<?php echo e($form_action); ?>">
		<?php echo \Form::csrf(); ?>
		<div class="form-group">
			<label for="name">プロジェクト名</label>
			<input id="name" class="form-control" type="text" name="name" value="<?php echo e($form['name']); ?>" placeholder="プロジェクト名を入力">
			<?php if ( ! empty($errors['name'])): ?>
				<p class="error-text"><?php echo e($errors['name']); ?></p>
			<?php endif; ?>
		</div>

		<div class="form-group">
			<label for="description">説明</label>
			<textarea id="description" class="form-control" name="description" placeholder="プロジェクトの説明を入力"><?php echo e($form['description']); ?></textarea>
			<?php if ( ! empty($errors['description'])): ?>
				<p class="error-text"><?php echo e($errors['description']); ?></p>
			<?php endif; ?>
		</div>

		<div class="project-form-actions">
			<button class="project-submit-button" type="submit"><?php echo e($submit_label); ?></button>
			<a class="project-cancel-link" href="/projects">一覧へ戻る</a>
		</div>
	</form>
</div>
