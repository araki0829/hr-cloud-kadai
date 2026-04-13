<?php

namespace Fuel\Migrations;

class Add_Simpleauth_Columns_To_Users
{
  protected $auth_columns = array(
    'username' => array(
      'type' => 'varchar',
      'constraint' => 255,
      'null' => true,
    ),
    'group' => array(
      'type' => 'int',
      'constraint' => 11,
      'unsigned' => true,
      'default' => 1,
    ),
    'last_login' => array(
      'type' => 'int',
      'constraint' => 11,
      'unsigned' => true,
      'default' => 0,
    ),
    'login_hash' => array(
      'type' => 'varchar',
      'constraint' => 255,
      'default' => '',
    ),
    'profile_fields' => array(
      'type' => 'text',
      'null' => true,
    ),
  );

  public function up()
  {
    if ( ! \DBUtil::table_exists('users'))
    {
      return;
    }

    $existing_columns = array_keys(\DB::list_columns('users'));
    $fields_to_add = array();

    foreach ($this->auth_columns as $column => $definition)
    {
      if ( ! in_array($column, $existing_columns, true))
      {
        $fields_to_add[$column] = $definition;
      }
    }

    if ( ! empty($fields_to_add))
    {
      \DBUtil::add_fields('users', $fields_to_add);
    }

    if ( ! $this->index_exists('users', 'username'))
    {
      \DBUtil::create_index('users', 'username', 'username', 'UNIQUE');
    }

    $users = \DB::select('id', 'name', 'email')
      ->from('users')
      ->execute()
      ->as_array();

    foreach ($users as $user)
    {
      \DB::update('users')
        ->set(array(
          'username' => $user['email'],
          'group' => 1,
          'last_login' => 0,
          'login_hash' => '',
          'profile_fields' => serialize(array('name' => $user['name'])),
        ))
        ->where('id', '=', $user['id'])
        ->execute();
    }
  }

  public function down()
  {
    if ( ! \DBUtil::table_exists('users'))
    {
      return;
    }

    if ($this->index_exists('users', 'username'))
    {
      \DBUtil::drop_index('users', 'username');
    }

    $existing_columns = array_keys(\DB::list_columns('users'));
    $fields_to_drop = array();

    foreach (array_keys($this->auth_columns) as $column)
    {
      if (in_array($column, $existing_columns, true))
      {
        $fields_to_drop[] = $column;
      }
    }

    if ( ! empty($fields_to_drop))
    {
      \DBUtil::drop_fields('users', $fields_to_drop);
    }
  }

  protected function index_exists($table_name, $index_name)
  {
    $database = \DB::query('SELECT DATABASE() AS db_name')
      ->execute()
      ->current();

    $index = \DB::select('INDEX_NAME')
      ->from('information_schema.STATISTICS')
      ->where('TABLE_SCHEMA', '=', $database['db_name'])
      ->where('TABLE_NAME', '=', $table_name)
      ->where('INDEX_NAME', '=', $index_name)
      ->execute()
      ->current();

    return ! empty($index);
  }
}
