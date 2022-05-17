<?php

return [
	'prefix' => 'admin',
	'middleware' => ['web'],
	'auth_admin_middleware' => null, //'auth.admin',
	'hidden_tables' => [
		//'migrations'
	],
	'hidden_columns' => [
		'users' => [
			'password',
			'remember_token',
			'two_factor_secret',
			'two_factor_recovery_codes',
		]
	],
];