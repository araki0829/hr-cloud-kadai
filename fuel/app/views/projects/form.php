<div class="w-640 mx-auto">
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

    <div class="flex items-center gap-12">
      <button class="project-submit-button" type="submit"><?php echo e($submit_label); ?></button>
      <a class="project-cancel-link" href="/projects">一覧へ戻る</a>
    </div>
  </form>
</div>
