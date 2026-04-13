<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title><?php echo $title; ?></title>
  <meta name="csrf-token" content="<?php echo e(\Security::fetch_token()); ?>">
  <meta name="csrf-token-key" content="<?php echo e(\Config::get('security.csrf_token_key')); ?>">
  <link rel="stylesheet" href="/assets/css/bootstrap.css">
  <link rel="stylesheet" href="/assets/css/app.css">
  <link rel="stylesheet" href="/assets/css/auth.css">
  <link rel="stylesheet" href="/assets/css/projects.css">
  <link rel="stylesheet" href="/assets/css/tasks.css">
</head>
<body>
  <header class="app-header">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <p class="user-status"></p>
        </div>
        <div class="col-md-4 text-right">
          <nav class="app-header-nav">
            <a href="/projects">プロジェクト一覧</a>
            <?php if ( ! empty($current_user)): ?>
              <form class="logout-form" method="post" action="/logout">
                <?php echo \Form::csrf(); ?>
                <button class="logout-button" type="submit">ログアウト</button>
              </form>
            <?php else: ?>
              <a href="/login">ログイン</a>
              <a href="/signup">新規登録</a>
            <?php endif; ?>
          </nav>
        </div>
      </div>
    </div>
  </header>

  <main class="container">
    <?php if ( ! empty($flash_success)): ?>
      <div class="alert alert-success flash-message">
        <?php echo $flash_success; ?>
      </div>
    <?php endif; ?>

    <?php if ( ! empty($flash_error)): ?>
      <div class="alert alert-danger flash-message">
        <?php echo $flash_error; ?>
      </div>
    <?php endif; ?>

    <div class="app-card">
      <?php echo $content; ?>
    </div>
  </main>
  <script>
    window.hrCloudCsrfToken = <?php echo json_encode(\Security::fetch_token(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
    window.hrCloudCsrfTokenKey = <?php echo json_encode(\Config::get('security.csrf_token_key'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); ?>;
  </script>
</body>
</html>
