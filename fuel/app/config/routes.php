<?php
return array(
	'_root_'  => 'auth/login',
	'_404_'   => 'welcome/404',

	// auth
	'login' => 'auth/login',
	'signup' => 'auth/signup',
	'logout' => 'auth/logout',

	// projects
	'projects' => 'projects/index',
	'projects/create' => 'projects/create',
	'projects/edit/(:num)' => 'projects/edit/$1',
	'projects/delete/(:num)' => 'projects/delete/$1',

	// tasks
	'projects/(:num)/tasks' => 'tasks/index/$1',
	'projects/(:num)/tasks/create' => 'tasks/create/$1',
	'tasks/edit/(:num)' => 'tasks/edit/$1',
	'tasks/delete/(:num)' => 'tasks/delete/$1',

	// api
	'api/tasks/change_status' => 'api/tasks/change_status',
);
