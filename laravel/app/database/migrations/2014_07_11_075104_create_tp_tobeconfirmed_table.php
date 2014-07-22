<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTpTobeconfirmedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// 创建tp_tobeconfirmed表
		Schema::create('tp_tobeconfirmed', function($table)
		{
			$table->increments('id');				// 项目id
			$table->integer('user_id')->unsigned();	// 用户id
			$table->char('check_code', 64);			// 校验码(页面标识串)
			$table->timestamp('created_at');		// 创建时间戳
			$table->enum('type', 
				array('findpsw', 'signin'));		// 确认类型
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tp_tobeconfirmed');
	}

}
