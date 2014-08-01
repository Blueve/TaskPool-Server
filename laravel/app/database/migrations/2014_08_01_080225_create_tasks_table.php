<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// tp_tasks
		Schema::create('tp_tasks', function($table)
		{
			$table->increments('id');					// 任务id
			$table->integer('user_id')->unsigned();		// 所属用户id
			$table->integer('list_id')->unsigned();		// 所属列表id
			$table->integer('child_id')->unsigned();	// 子任务id
			$table->tinyInteger('level')->unsigned();	// 任务层级 - 最高为0 每一层子任务+1
			$table->text('description');				// 任务详情
			$table->integer('priority')->unsigned();	// 任务顺位 - 自定义排序模式下有效
			$table->timestamps();						// created_at update_at 时间戳
			$table->softDeletes();						// deleted_at
			$table->integer('version')->unsigned();		// 版本号
		});

		// tp_comments
		Schema::create('tp_comments', function($table)
		{
			$table->increments('id');					// 评论id
			$table->integer('user_id')->unsigned();		// 评论发起者id
			$table->integer('task_id')->unsigned();		// 所属任务id
			$table->integer('topic_id')->unsigned();	// 所属评论id - 仅在为指向回复时有值
			$table->text('content');					// 评论内容
			$table->timestamp('start');					// 任务开始时间
			$table->timestamp('end');					// 任务截止时间
			$table->enum('type', 						// 任务分类 - 默认为不重要且不紧急
				array(
					'i_u', 
					'i_nu', 
					'ni_u',
					'ni_nu'))->default('ni_nu');
			$table->integer('priority')->unsigned();	// 列表顺位
			$table->timestamps();						// created_at update_at 时间戳

		});

		// tp_attachments
		Schema::create('tp_attachments', function($table)
		{
			//!TODO: 待定
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tp_attachments');
		Schema::drop('tp_comments');
		Schema::drop('tp_tasks');
	}

}
