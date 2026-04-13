<?php

namespace Fuel\Migrations;

class Add_Check_Constraint_To_Tasks_Status
{
	protected $constraint_name = 'chk_tasks_status';

	public function up()
	{
		if ( ! \DBUtil::table_exists('tasks'))
		{
			return;
		}

		if ($this->constraint_exists())
		{
			return;
		}

		\DB::query(
			'ALTER TABLE tasks ADD CONSTRAINT '.$this->constraint_name.' CHECK (status IN (0, 1, 2))'
		)->execute();
	}

	public function down()
	{
		if ( ! \DBUtil::table_exists('tasks'))
		{
			return;
		}

		if ( ! $this->constraint_exists())
		{
			return;
		}

		\DB::query(
			'ALTER TABLE tasks DROP CHECK '.$this->constraint_name
		)->execute();
	}

	protected function constraint_exists()
	{
		$database = \DB::query('SELECT DATABASE() AS db_name')
			->execute()
			->current();

		$result = \DB::select('CONSTRAINT_NAME')
			->from('information_schema.TABLE_CONSTRAINTS')
			->where('CONSTRAINT_SCHEMA', '=', $database['db_name'])
			->where('TABLE_NAME', '=', 'tasks')
			->where('CONSTRAINT_NAME', '=', $this->constraint_name)
			->where('CONSTRAINT_TYPE', '=', 'CHECK')
			->execute()
			->current();

		return ! empty($result);
	}
}
