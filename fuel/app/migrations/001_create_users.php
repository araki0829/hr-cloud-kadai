<?php

namespace Fuel\Migrations;

class Create_Users
{
  public function up()
  {
    if ( ! \DBUtil::table_exists('users'))
    {
      \DBUtil::create_table('users', array(
        'id' => array(
          'type' => 'int',
          'constraint' => 11,
          'unsigned' => true,
          'auto_increment' => true,
        ),
        'name' => array(
          'type' => 'varchar',
          'constraint' => 100,
        ),
        'email' => array(
          'type' => 'varchar',
          'constraint' => 255,
        ),
        'password' => array(
          'type' => 'varchar',
          'constraint' => 255,
        ),
        'created_at' => array(
          'type' => 'int',
          'constraint' => 11,
          'unsigned' => true,
          'default' => 0,
        ),
        'updated_at' => array(
          'type' => 'int',
          'constraint' => 11,
          'unsigned' => true,
          'default' => 0,
        ),
      ), array('id'), true, 'InnoDB', \Config::get('db.default.charset'));

      \DBUtil::create_index('users', 'email', 'email', 'UNIQUE');
    }
  }

  public function down()
  {
    \DBUtil::drop_table('users');
  }
}
