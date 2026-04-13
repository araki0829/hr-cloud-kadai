<style>
	.projects-page-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 24px;
	}
	.projects-page-title {
		margin: 0;
	}
	.projects-page-description {
		margin: 8px 0 0;
		color: #667085;
	}
	.project-create-link {
		display: inline-block;
		padding: 10px 16px;
		border-radius: 6px;
		background: #2563eb;
		color: #fff;
		text-decoration: none;
	}
	.project-list {
		display: grid;
		gap: 16px;
	}
	.project-card {
		padding: 20px;
		border: 1px solid #d9e0ea;
		border-radius: 8px;
		background: #fdfefe;
	}
	.project-card-title {
		margin: 0 0 8px;
		font-size: 22px;
	}
	.project-card-description {
		margin: 0 0 12px;
		color: #475467;
	}
	.project-card-meta {
		margin: 0 0 16px;
		font-size: 13px;
		color: #667085;
	}
	.project-card-actions {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
	}
	.project-card-actions a,
	.project-card-actions button {
		padding: 8px 12px;
		border: none;
		border-radius: 4px;
		text-decoration: none;
		cursor: pointer;
	}
	.action-tasks {
		background: #16a34a;
		color: #fff;
	}
	.action-edit {
		background: #facc15;
		color: #111827;
	}
	.action-delete {
		background: #dc2626;
		color: #fff;
	}
	.empty-projects {
		padding: 24px;
		border: 1px dashed #cbd5e1;
		border-radius: 8px;
		background: #f8fafc;
		color: #475467;
		text-align: center;
	}
</style>

<div class="projects-page-header">
	<div>
		<h2 class="projects-page-title">プロジェクト一覧</h2>
		<p class="projects-page-description">
			<?php echo e($current_user['name']); ?> さんのプロジェクトを表示しています。
		</p>
	</div>
	<a class="project-create-link" href="/projects/create">新規作成</a>
</div>

<?php if (empty($projects)): ?>
	<div class="empty-projects">
		まだプロジェクトがありません。まずは新規作成から始めてください。
	</div>
<?php else: ?>
	<div class="project-list">
		<?php foreach ($projects as $project): ?>
			<div class="project-card">
				<h3 class="project-card-title"><?php echo e($project['name']); ?></h3>
				<p class="project-card-description">
					<?php echo $project['description'] !== null && $project['description'] !== '' ? nl2br(e($project['description'])) : '説明は未登録です。'; ?>
				</p>
				<p class="project-card-meta">
					更新日時:
					<?php echo $project['updated_at'] ? date('Y-m-d H:i', $project['updated_at']) : '-'; ?>
				</p>
				<div class="project-card-actions">
					<a class="action-tasks" href="/projects/<?php echo e($project['id']); ?>/tasks">タスクを見る</a>
					<a class="action-edit" href="/projects/edit/<?php echo e($project['id']); ?>">編集</a>
					<form method="post" action="/projects/delete/<?php echo e($project['id']); ?>" style="display:inline;">
						<?php echo \Form::csrf(); ?>
						<button class="action-delete" type="submit">削除</button>
					</form>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
