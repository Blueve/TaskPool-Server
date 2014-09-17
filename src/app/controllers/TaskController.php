<?php

class TaskController extends BaseController
{
	/**
	 * 创建新的任务
	 * 
	 * @return Response Json
	 */
	public function postCreate()
	{
		$user = Auth::user();
		
		$tasks = Task::newTask($newTaskForm, $user);

		
		return Response::json($response);
	}

}