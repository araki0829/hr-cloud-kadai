# タスク管理アプリ

## 概要
日々のタスクを管理するアプリ。プロジェクトごとにタスクを管理できる。

## 機能
- ユーザ登録、ログイン、ログアウト
- プロジェクト管理機能（作成／一覧表示／編集／削除）
- タスク管理機能（作成／一覧表示／編集／削除）
- タスク状態変更機能（未着手／進行中／完了）

## 使用技術
- PHP 7.3
- FuelPHP 1.8
- MySQL 8.0
- Docker
- Knockout.js
- Bootstrap
- Git / GitHub

## 課題条件チェック

参照元:
`documents_araki/課題条件.md`

### 1. サーバサイド言語はPHPで、フレームワークのFuelPHPを使用すること
- 実装箇所:
  - `fuel/app/classes/controller/*`
  - `fuel/app/views/*`
  - `fuel/app/config/*`
- 内容:
  - FuelPHP の Controller / View / Config / Migration の構成で実装している

### 2. beforeメソッドを使う
- 実装箇所:
  - `fuel/app/classes/controller/base.php`
- 内容:
  - `before()` でログイン中ユーザ取得と未ログイン時のリダイレクトをしている

### 3. configファイルをカスタマイズする
- 実装箇所:
  - `fuel/app/config/config.php`
  - `fuel/app/config/task.php`
  - `fuel/app/config/development/db.php`
- 内容:
  - タイムゾーン、cookie、security、DB接続、タスク状態定義を設定している

### 4. sessionやcookieを使う
- 実装箇所:
  - `fuel/app/classes/controller/auth.php`
  - `fuel/app/classes/controller/base.php`
  - `fuel/app/config/config.php`
- 内容:
  - `Session` でログイン状態を保持
  - `Cookie` でログイン画面のメールアドレス再表示を実装

### 5. ネームスペースを使う
- 実装箇所:
  - `fuel/app/migrations/001_create_users.php`
  - `fuel/app/migrations/002_create_projects.php`
  - `fuel/app/migrations/003_create_tasks.php`
  - `fuel/app/migrations/004_add_check_constraint_to_tasks_status.php`
- 内容:
  - migration で `namespace Fuel\\Migrations;` を使っている

### 6. \（バックスラッシュ）を使ったグローバルな名前空間へのアクセスについて理解している
- 実装箇所:
  - `fuel/app/classes/controller/auth.php`
  - `fuel/app/classes/controller/projects.php`
  - `fuel/app/classes/controller/tasks.php`
  - `fuel/app/classes/controller/base.php`
- 内容:
  - `\Response`, `\Session`, `\Input`, `\Config`, `\DB` のようにグローバル名前空間アクセスを使っている

### 7. データベースとのやり取りはDBクラスを使うこと
- 実装箇所:
  - `fuel/app/classes/model/user.php`
  - `fuel/app/classes/model/project.php`
  - `fuel/app/classes/model/task.php`
- 内容:
  - `DB::select`, `DB::insert`, `DB::update`, `DB::delete` を使っている

### 8. 1:n関係のテーブル構造があること
- 実装箇所:
  - `documents_araki/DB設計.md`
  - `fuel/app/migrations/002_create_projects.php`
  - `fuel/app/migrations/003_create_tasks.php`
- 内容:
  - `users 1 : n projects`
  - `projects 1 : n tasks`

### 9. CRUDの機能が網羅されている
- 実装箇所:
  - `fuel/app/classes/controller/projects.php`
  - `fuel/app/classes/controller/tasks.php`
- 内容:
  - プロジェクトとタスクで作成・一覧・編集・削除を実装している

### 10. フロントエンドのライブラリにknockout.jsが使用されている
- 実装箇所:
  - `fuel/app/views/tasks/index.php`
- 内容:
  - タスク一覧のステータス変更 UI で Knockout.js を使っている

### 11. uxを考慮して一部動的なuiが実装されている（非同期処理）
- 実装箇所:
  - `fuel/app/views/tasks/index.php`
  - `fuel/app/classes/controller/api/tasks.php`
- 内容:
  - タスク一覧画面で画面遷移なしのステータス更新を実装している

### 12. GitHubでコードの管理を行う
- 実装箇所:
  - ローカルリポジトリ全体
- 内容:
  - Git で履歴管理している

### 13. セキュリティ資料を読み必要な実装を行う
- 実装箇所:
  - `fuel/app/config/config.php`
  - `fuel/app/views/template.php`
  - `fuel/app/views/auth/login.php`
  - `fuel/app/views/auth/signup.php`
  - `fuel/app/views/projects/form.php`
  - `fuel/app/views/projects/index.php`
  - `fuel/app/views/tasks/form.php`
  - `fuel/app/views/tasks/index.php`
  - `fuel/app/classes/controller/api/tasks.php`
  - `fuel/app/migrations/004_add_check_constraint_to_tasks_status.php`
- 内容:
  - XSS対策: 出力時エスケープ
  - 認可チェック: 他人データを操作不可
  - パスワードハッシュ化
  - CSRF対策
  - `tasks.status` の DB制約追加
