<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserList extends Eloquent {

	use SoftDeletingTrait;

	protected $table = 'tp_userlist';

	/*
	 * 关系
	 */
	public function taskList()
	{
		return $this->belongsTo('TaskList', 'list_id');
	}

	public static function updatePriorityById($id, $priority)
	{
		UserList::where('list_id', '=', $id)->increment('version', 1, array('priority' => $priority));
	}

	public static function softDeleteById($listId)
	{
		if($listId)
		{
			UserList::where('list_id', '=', $listId)->increment('version', 1);
			UserList::where('list_id', '=', $listId)->delete();
			return true;
		}

		return false;
	}
}