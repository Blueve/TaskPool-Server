<?php

class Task extends Eloquent {

	protected $table = 'tp_tasks';
	
	const i_u   = 'i_u';
	const i_nu  = 'i_nu';
	const ni_u  = 'ni_u';
	const ni_nu = 'ni_nu';

	public static function newTask(NewTaskForm $newTaskForm, User $user)
	{
		if($newListForm->isValid())
		{
			$list              = new Task();
			$list->user_id     = $user->id;
			$list->list_id     = $newTaskForm->listId;
			$list->level       = 0;
			$list->title       = $newTaskForm->title;
			$list->description = $newTaskForm->description;
			$list->priority    = $user->taskLists->tasks()->count();
			$list->start       = $newTaskForm->start;
			$list->end         = $newTaskForm->end;
			$list->type        = $newTaskForm->type;
			$version           = 0;

			return $list;
		}
	}

}