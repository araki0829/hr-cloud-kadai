<div class="w-680 mx-auto">
  <h2 class="task-form-title"><?php echo e($form_title); ?></h2>
  <p class="task-form-description"><?php echo e($form_description); ?></p>

  <div class="panel-muted p-16-18 mb-20">
    <h3 class="task-summary-title"><?php echo e($project['name']); ?></h3>
    <p class="task-summary-description"><?php echo e($project['description_display']); ?></p>
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

    <div class="flex items-center gap-12">
      <button class="task-submit-button" type="submit"><?php echo e($submit_label); ?></button>
      <a class="task-cancel-link" href="/projects/<?php echo e($project['id']); ?>/tasks">一覧へ戻る</a>
    </div>
  </form>
</div>
