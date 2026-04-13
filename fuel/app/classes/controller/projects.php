<?php

class Controller_Projects extends Controller_Base
{
	public function action_index()
	{
		$this->template->title = 'プロジェクト一覧 | HR Cloud';
		$this->template->content = \View::forge('projects/index', array(
			'current_user' => $this->current_user,
		));
	}
}
