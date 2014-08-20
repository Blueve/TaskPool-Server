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
			$table->enum('color', 						// 颜色标识
				array(
					'red', 
					'orange', 
					'yellow',
					'green',
					'blue',
					'indigo',
					'purple',
					'black',
					'darkgray',
					'gray'))->default('darkgray');
			$table->enum('icon', Config::get('iconset.list_icon_set'))
				  ->default(Config::get('iconset.default_icon'));	// 列表图标
			$table->enum('sort_by', 								// 内部排序方式
				array(
					'important', 
					'urgent', 
					'date',
					'custom'))->default('important');
			$table->boolean('shareable')->default(false);	// 是否可共享

			$table->timestamps();						// created_at update_at 时间戳
			$table->softDeletes();						// deleted_at	
			$table->integer('version')->unsigned();		// 版本号
		});

		// tp_userlist
		Schema::create('tp_userlist', function($table)
		{
			$table->increments('id');					// 用户列表id
			$table->integer('user_id')->unsigned();		// 用户id
			$table->integer('list_id')->unsigned();		// 列表id
			$table->integer('priority')->unsigned();	// 列表顺位
			$table->timestamps();						// created_at update_at 时间戳
			$table->softDeletes();						// deleted_at
			$table->integer('version')->unsigned();		// 版本号
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
		Schema::drop('tp_userlist');
		Schema::drop('tp_lists');
	}

}
