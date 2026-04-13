<div class="flex justify-between items-center mb-24">
  <div>
    <h2 class="projects-page-title">プロジェクト一覧</h2>
    <p class="projects-page-description">
      <?php echo e($current_user_name); ?> さんのプロジェクトを表示しています。
    </p>
  </div>
  <a class="project-create-link" href="/projects/create">新規作成</a>
</div>

<?php if (empty($projects)): ?>
  <div class="panel-empty">
    まだプロジェクトがありません。まずは新規作成から始めてください。
  </div>
<?php else: ?>
  <div class="grid-gap-16">
    <?php foreach ($projects as $project): ?>
      <div class="panel-soft p-20">
        <h3 class="project-card-title"><?php echo e($project['name']); ?></h3>
        <p class="project-card-description"><?php echo e($project['description_display']); ?></p>
        <p class="project-card-meta">
          更新日時:
          <?php echo e($project['updated_at_display']); ?>
        </p>
        <div class="project-actions flex wrap gap-8">
          <a class="action-tasks" href="/projects/<?php echo e($project['id']); ?>/tasks">タスクを見る</a>
          <a class="action-edit" href="/projects/edit/<?php echo e($project['id']); ?>">編集</a>
          <form class="inline-form" method="post" action="/projects/delete/<?php echo e($project['id']); ?>">
            <?php echo \Form::csrf(); ?>
            <button class="action-delete" type="submit">削除</button>
          </form>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
