<style>
	.tasks-page-header {
		display: flex;
		justify-content: space-between;
		align-items: flex-start;
		gap: 16px;
		margin-bottom: 24px;
	}
	.tasks-page-title {
		margin: 0;
	}
	.tasks-page-description {
		margin: 8px 0 0;
		color: #667085;
	}
	.task-create-link {
		display: inline-block;
		padding: 10px 16px;
		border-radius: 6px;
		background: #2563eb;
		color: #fff;
		text-decoration: none;
	}
	.task-project-card {
		margin-bottom: 20px;
		padding: 18px 20px;
		border: 1px solid #d9e0ea;
		border-radius: 8px;
		background: #f8fafc;
	}
	.task-project-card h3 {
		margin: 0 0 8px;
	}
	.task-project-card p {
		margin: 0;
		color: #475467;
	}
	.task-table {
		width: 100%;
		border-collapse: collapse;
		background: #fff;
		border: 1px solid #d9e0ea;
		border-radius: 8px;
		overflow: hidden;
	}
	.task-table th,
	.task-table td {
		padding: 14px;
		border-bottom: 1px solid #e5e7eb;
		text-align: left;
		vertical-align: top;
	}
	.task-table th {
		background: #f8fafc;
	}
	.task-status {
		display: inline-block;
		padding: 4px 10px;
		border-radius: 999px;
		font-size: 12px;
		font-weight: bold;
	}
	.task-status-0 {
		background: #e5e7eb;
		color: #374151;
	}
	.task-status-1 {
		background: #fde68a;
		color: #92400e;
	}
	.task-status-2 {
		background: #bbf7d0;
		color: #166534;
	}
	.task-actions {
		display: flex;
		flex-wrap: wrap;
		gap: 8px;
	}
	.task-actions a,
	.task-actions button {
		padding: 8px 12px;
		border: none;
		border-radius: 4px;
		text-decoration: none;
		cursor: pointer;
	}
	.task-action-edit {
		background: #facc15;
		color: #111827;
	}
	.task-action-delete {
		background: #dc2626;
		color: #fff;
	}
	.empty-tasks {
		padding: 24px;
		border: 1px dashed #cbd5e1;
		border-radius: 8px;
		background: #f8fafc;
		color: #475467;
		text-align: center;
	}
</style>

<div class="tasks-page-header">
	<div>
		<h2 class="tasks-page-title">タスク一覧</h2>
		<p class="tasks-page-description">プロジェクトごとにタスクを管理します。</p>
	</div>
	<a class="task-create-link" href="/projects/<?php echo e($project['id']); ?>/tasks/create">新規作成</a>
</div>

<div class="task-project-card">
	<h3><?php echo e($project['name']); ?></h3>
	<p><?php echo $project['description'] !== '' ? nl2br(e($project['description'])) : 'プロジェクト説明は未登録です。'; ?></p>
</div>

<?php if (empty($tasks)): ?>
	<div class="empty-tasks">
		まだタスクがありません。まずは新規作成から始めてください。
	</div>
<?php else: ?>
	<table class="task-table">
		<thead>
			<tr>
				<th>タスク名</th>
				<th>詳細</th>
				<th>状態</th>
				<th>更新日時</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($tasks as $task): ?>
				<tr>
					<td><?php echo e($task['title']); ?></td>
					<td><?php echo $task['body'] !== '' ? nl2br(e($task['body'])) : '詳細は未登録です。'; ?></td>
					<td>
						<span class="task-status task-status-<?php echo e($task['status']); ?>">
							<?php echo e(isset($status_list[$task['status']]) ? $status_list[$task['status']] : '不明'); ?>
						</span>
					</td>
					<td><?php echo $task['updated_at'] ? date('Y-m-d H:i', $task['updated_at']) : '-'; ?></td>
					<td>
						<div class="task-actions">
							<a class="task-action-edit" href="/tasks/edit/<?php echo e($task['id']); ?>">編集</a>
							<form method="post" action="/tasks/delete/<?php echo e($task['id']); ?>" style="display:inline;">
								<button class="task-action-delete" type="submit">削除</button>
							</form>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
