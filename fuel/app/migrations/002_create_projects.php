<?php

namespace Fuel\Migrations;

class Create_Projects
{
  public function up()
  {
    if ( ! \DBUtil::table_exists('projects'))
    {
      \DBUtil::create_table('projects', array(
        'id' => array(
          'type' => 'int',
          'constraint' => 11,
          'unsigned' => true,
          'auto_increment' => true,
        ),
        'user_id' => array(
          'type' => 'int',
          'constraint' => 11,
          'unsigned' => true,
        ),
        'name' => array(
          'type' => 'varchar',
          'constraint' => 100,
        ),
        'description' => array(
          'type' => 'text',
          'null' => true,
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
      ), array('id'), true, 'InnoDB', \Config::get('db.default.charset'), array(
        'fk_projects_user_id' => array(
          'key' => 'user_id',
          'reference' => array(
            'table' => 'users',
            'column' => 'id',
          ),
          'on_delete' => 'CASCADE',
          'on_update' => 'CASCADE',
        ),
      ));

      \DBUtil::create_index('projects', 'user_id', 'idx_projects_user_id');
    }
  }

  public function down()
  {
    \DBUtil::drop_table('projects');
  }
}
