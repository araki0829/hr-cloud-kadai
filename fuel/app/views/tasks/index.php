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
		white-space: pre-line;
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
	.task-body-text {
		white-space: pre-line;
	}
	.task-status-select {
		min-width: 120px;
		padding: 8px 10px;
		border: 1px solid #cbd5e1;
		border-radius: 6px;
		background: #fff;
	}
	.task-status-select.is-saving {
		opacity: 0.6;
	}
	.task-status-select.is-error {
		border-color: #dc2626;
	}
	.task-status-message {
		display: block;
		min-height: 20px;
		margin-top: 6px;
		font-size: 13px;
		color: #475467;
	}
	.task-status-message.is-error {
		color: #dc2626;
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
	<p><?php echo e($project['description'] !== '' ? $project['description'] : 'プロジェクト説明は未登録です。'); ?></p>
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
					<td class="task-body-text"><?php echo e($task['body'] !== '' ? $task['body'] : '詳細は未登録です。'); ?></td>
					<td
						class="task-status-cell"
						data-task-id="<?php echo e($task['id']); ?>"
						data-status="<?php echo e($task['status']); ?>"
					>
						<select
							class="task-status-select"
							data-bind="
								css: {
									'is-saving': isSaving(),
									'is-error': hasError()
								},
								value: status,
								event: { change: changeStatus }
							"
						>
							<?php foreach ($status_list as $status_value => $status_label): ?>
								<option value="<?php echo e($status_value); ?>">
									<?php echo e($status_label); ?>
								</option>
							<?php endforeach; ?>
						</select>
						<div
							class="task-status-message"
							aria-live="polite"
							data-bind="
								text: message,
								css: { 'is-error': hasError() }
							"
						></div>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.5.1/knockout-min.js"></script>
<script>
(function () {
	function createTaskStatusViewModel(taskId, initialStatus) {
		return {
			taskId: taskId,
			status: ko.observable(String(initialStatus)),
			previousStatus: String(initialStatus),
			message: ko.observable(''),
			isSaving: ko.observable(false),
			hasError: ko.observable(false),
			changeStatus: function () {
				var nextStatus = this.status();
				var previousStatus = this.previousStatus;

				if (nextStatus === previousStatus || this.isSaving()) {
					return true;
				}

				this.isSaving(true);
				this.hasError(false);
				this.message('更新中...');

				fetch('/api/tasks/change_status', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
						'X-Requested-With': 'XMLHttpRequest'
					},
					body: new URLSearchParams({
						task_id: this.taskId,
						status: nextStatus
					}).toString()
				})
					.then(function (response) {
						return response.json().then(function (data) {
							return {
								ok: response.ok,
								data: data
							};
						});
					})
					.then(function (result) {
						if (!result.ok || !result.data.success) {
							throw new Error(result.data.message || 'ステータスの更新に失敗しました。');
						}

						this.previousStatus = String(result.data.status);
						this.status(String(result.data.status));
						this.message('更新しました。');
					}.bind(this))
					.catch(function (error) {
						this.status(previousStatus);
						this.hasError(true);
						this.message(error.message);
					}.bind(this))
					.finally(function () {
						this.isSaving(false);
					}.bind(this));

				return true;
			}
		};
	}

	function attachPlainFallback(cell) {
		var select = cell.querySelector('.task-status-select');
		var message = cell.querySelector('.task-status-message');
		var previousStatus = String(cell.getAttribute('data-status'));

		select.value = previousStatus;
		select.addEventListener('change', function () {
			var nextStatus = select.value;

			if (nextStatus === previousStatus) {
				return;
			}

			select.disabled = true;
			select.classList.remove('is-error');
			select.classList.add('is-saving');
			message.textContent = '更新中...';
			message.classList.remove('is-error');

			fetch('/api/tasks/change_status', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: new URLSearchParams({
					task_id: cell.getAttribute('data-task-id'),
					status: nextStatus
				}).toString()
			})
				.then(function (response) {
					return response.json().then(function (data) {
						return {
							ok: response.ok,
							data: data
						};
					});
				})
				.then(function (result) {
					if (!result.ok || !result.data.success) {
						throw new Error(result.data.message || 'ステータスの更新に失敗しました。');
					}

					previousStatus = String(result.data.status);
					select.value = previousStatus;
					message.textContent = '更新しました。';
				})
				.catch(function (error) {
					select.value = previousStatus;
					select.classList.add('is-error');
					message.textContent = error.message;
					message.classList.add('is-error');
				})
				.finally(function () {
					select.disabled = false;
					select.classList.remove('is-saving');
				});
		});
	}

	var statusCells = document.querySelectorAll('.task-status-cell');

	if (typeof ko === 'undefined') {
		statusCells.forEach(attachPlainFallback);
		return;
	}

	statusCells.forEach(function (cell) {
		var viewModel = createTaskStatusViewModel(
			cell.getAttribute('data-task-id'),
			cell.getAttribute('data-status')
		);

		ko.applyBindings(viewModel, cell);
	});
})();
</script>
