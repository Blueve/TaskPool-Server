<?php

class TaskList extends Eloquent {

	protected $table = 'tp_lists';
	
	const important  = 'important';
	const urgent     = 'urgent';
	const date       = 'date';

	public static function newTaskList(NewListForm $newListForm, User $user)
	{
		if($newListForm->isValid())
		{
			$list           = new TaskList();
			$list->user_id  = $user->id;
			$list->name     = $newListForm->name;
			$list->priority = $user->taskLists()->count();
			$list->sort_by  = 'important';
			$list->version  = 0;
			$list->save();
			return $list;
		}
	}

	public static function updatePriorityById($id, $priority)
	{
		Tasklist::where('id', '=', $id)->increment('version', 1, array('priority' => $priority));
	}
}