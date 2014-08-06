<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 创建tp_users表
		Schema::create('tp_users', function($table)
		{
			$table->increments('id');						// 用户id
			$table->string('name', 16)->unique();			// 用户名
			$table->string('email')->unique();				// 用户email
			$table->char('psw_hash', 32);					// 经过Hash后的密码
			$table->char('psw_salt', 8);					// Hash算法的Salt
			$table->dateTime('created_at');					// 用户创建时间
			$table->boolean('confirmed')->default(false);	// 邮箱验证状态
			$table->rememberToken();						// Session状态
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tp_users');
	}

}
