<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpListsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// tp_lists
		Schema::create('tp_lists', function($table)
		{
			$table->increments('id');					// 列表id
			$table->integer('user_id')->unsigned();		// 用户id
			$table->string('name');						// 列表名
			$table->integer('priority')->unsigned();	// 列表顺位
			$table->enum('sort_by', 					// 内部排序方式
				array(
					'important', 
					'urgent', 
					'date'))->default('important');
			$table->timestamps();						// created_at update_at 时间戳
			$table->softDeletes();						// deleted_at	
			$table->integer('version')->unsigned();		// 版本号
		});

		// tp_sharedlist
		Schema::create('tp_sharedlists', function($table)
		{
			$table->increments('id');					// id
			$table->integer('list_id')->unsigned();		// 可共享列表id
			$table->char('code', 10)->unique();			// 共享码
		});

		// tp_grp_list
		Schema::create('tp_grp_list', function($table)
		{
			$table->integer('list_id')->unsigned();		// 列表id
			$table->integer('group_id')->unsigned();	// 联系人组id
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tp_grp_list');
		Schema::drop('tp_sharedlists');
		Schema::drop('tp_lists');
	}

}
