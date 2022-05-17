<?php

namespace Tests\Feature;

use Tests\TestCase;
//use Orchestra\Testbench\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\Models\User;
use Tests\Models\Post;

use Illuminate\Support\Facades\DB;

class XDBShowTest extends TestCase
{
	use RefreshDatabase;

	//protected $seed = true;

	private function seedFakeData()
	{
		$users = User::factory()
						->count(rand(10, 100))
            ->has(Post::factory()->count(rand(10, 100)))
            ->create();
	}

	public function test_only_admin_can_access_xdbshow_index()
	{
		// prepare fake database
		$this->seedFakeData();


		// assert unauthenticated user cannot access /admin/xdbshow route
		$response = $this->get(route('admin.xdbshow'));
		
		$response->assertStatus(302);
		$response->assertRedirect('/login');
		$this->assertGuest();


		// get a user
		$user = User::latest('id')->first();

		// assert user cannot access /admin/xdbshow route
		$response = $this->actingAs($user)->get(route('admin.xdbshow'));
		
		$this->assertAuthenticated();
		//$response->assertUnauthorized();
		$response->assertForbidden();
		$response->assertStatus(403);
		

		// get admin user
		$admin = User::first();
		
		// assert admin can access /admin/xdbshow route
		$response = $this->actingAs($admin)->get(route('admin.xdbshow'));
		
		$response->assertOk();
		$this->assertAuthenticated();
	}

	public function test_only_admin_can_list_all_available_tables()
	{
		// prepare fake database
		$this->seedFakeData();

		// get admin user
		$admin = User::first();
		
		// assert can see all available tables
		$response = $this->actingAs($admin)->get(route('admin.xdbshow'));
		
		$response->assertOk();
		$response->assertSeeText('users');
		$response->assertSeeText('posts');
	}

	public function test_admin_cannot_list_hidden_tables_specified_in_the_config_file()
	{
		// prepare fake database
		$this->seedFakeData();

		// get admin user
		$admin = User::first();
		
		// assert cannot see hidden tables
		$response = $this->actingAs($admin)->get(route('admin.xdbshow'));
		
		$response->assertOk();

		// get hidden table specified in the config file and assert cannot see them
		$hiddenTables = config('xDBShow.hidden_tables', []);

		foreach ($hiddenTables as $table) {
			$response->assertDontSeeText($table);
		}
	}

	public function test_only_admin_can_list_all_table_columns()
	{
		// prepare fake database
		$this->seedFakeData();

		// get admin user
		$admin = User::first();

		$tableName = ['users', 'posts'][mt_rand(0, 1)];
		config(['xDBShow.hidden_columns' . '.' . $tableName => []]);
		
		// assert can see all table's columns
		$response = $this->actingAs($admin)->get(route('admin.xdbshow.table', $tableName));
		
		$response->assertOk();
		
		// get table's columns
		$columns = \Illuminate\Support\Facades\Schema::getColumnListing($tableName);

		foreach ($columns as $column) {
			$response->assertSeeText($column);
		}
	}

	public function test_only_admin_cannot_see_hidden_table_columns_specified_in_the_config_file()
	{
		// prepare fake database
		$this->seedFakeData();

		// get admin user
		$admin = User::first();

		$tableName = ['users', 'posts'][mt_rand(0, 1)];
		
		// assert cannot see hidden table's columns specified in the config file
		$response = $this->actingAs($admin)->get(route('admin.xdbshow.table', $tableName));
		
		$response->assertOk();
		
		// get table's columns
		$columns = \Illuminate\Support\Facades\Schema::getColumnListing($tableName);

		// get hidden table's columns specified in the config file and assert cannot see them
		$hiddenColumns = config('xDBShow.hidden_columns' . '.' . $tableName, []);
		
		foreach ($hiddenColumns as $column) {
			$response->assertDontSeeText($column);
		}
	}

	public function test_only_admin_can_show_table_records()
	{
		// prepare fake database
		$this->seedFakeData();

		// get admin user
		$admin = User::first();

		$tableName = ['users', 'posts'][mt_rand(0, 1)];

		// get hidden table's columns specified in the config file
		$hiddenColumns = config('xDBShow.hidden_columns' . '.' . $tableName, []);
		switch ($tableName) {
			case 'users':
				$firstRecord = User::first();
				$records = tap(User::simplePaginate(15))->makeHidden($hiddenColumns);
				break;
				
			case 'posts':
				$firstRecord = Post::first();
				$records = tap(Post::simplePaginate(15))->makeHidden($hiddenColumns);
				break;
		}
		
		// assert can see table's records
		$response = $this->actingAs($admin)->get(route('admin.xdbshow.table', $tableName));

		$response->assertOk();
		$response->assertViewHas('title', $tableName);
		$response->assertViewHas('records', $records['data']);
	}

	public function test_if_there_are_no_records_show_a_proper_message_instead()
	{
		// prepare fake database
		$this->seedFakeData();

		// get admin user
		$admin = User::first();

		$tableName = 'posts';
		Post::truncate();

		// assert there are no records to display and can see a proper message instead
		$response = $this->actingAs($admin)->get(route('admin.xdbshow.table', $tableName));
		
		$response->assertOk();
		$response->assertSeeText('There are no records to display.');
	}

}
