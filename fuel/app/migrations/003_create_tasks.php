<?php

namespace Fuel\Migrations;

class Create_Tasks
{
	public function up()
	{
		if ( ! \DBUtil::table_exists('tasks'))
		{
			\DBUtil::create_table('tasks', array(
				'id' => array(
					'type' => 'int',
					'constraint' => 11,
					'unsigned' => true,
					'auto_increment' => true,
				),
				'project_id' => array(
					'type' => 'int',
					'constraint' => 11,
					'unsigned' => true,
				),
				'title' => array(
					'type' => 'varchar',
					'constraint' => 100,
				),
				'body' => array(
					'type' => 'text',
					'null' => true,
				),
				'status' => array(
					'type' => 'tinyint',
					'constraint' => 1,
					'unsigned' => true,
					'default' => 0,
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
				'fk_tasks_project_id' => array(
					'key' => 'project_id',
					'reference' => array(
						'table' => 'projects',
						'column' => 'id',
					),
					'on_delete' => 'CASCADE',
					'on_update' => 'CASCADE',
				),
			));

			\DBUtil::create_index('tasks', 'project_id', 'idx_tasks_project_id');
			\DBUtil::create_index('tasks', 'status', 'idx_tasks_status');
		}
	}

	public function down()
	{
		\DBUtil::drop_table('tasks');
	}
}
