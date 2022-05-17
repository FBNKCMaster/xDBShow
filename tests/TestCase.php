<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
//use FBNKCMaster\xDBShow\Providers\ServiceProvider;

abstract class TestCase extends BaseTestCase
{
	public function setUp(): void
	{
		parent::setUp();
		// additional setup
	}

	protected function getPackageProviders($app)
	{
		return [
			//ServiceProvider::class,
			'FBNKCMaster\xDBShow\Providers\ServiceProvider',
		];
	}

	public function getEnvironmentSetUp($app)
	{
		// perform environment setup
		// import migrations
		include_once __DIR__ . '/database/migrations/create_users_table.php.stub';
		include_once __DIR__ . '/database/migrations/create_posts_table.php.stub';

		// run the up() method of that migrations classes
		(new \CreateUsersTable)->up();
		(new \CreatePostsTable)->up();
	}
}