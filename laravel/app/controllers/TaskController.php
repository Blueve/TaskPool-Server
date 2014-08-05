<?php

class TaskController extends BaseController {

	public function create()
	{
		$user = Auth::user();
		
		$tasks = Task::newTask($newTaskForm, $user);

		
		return Response::json($response);
	}

}