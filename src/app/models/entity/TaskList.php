<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TaskList extends Eloquent 
{

	use SoftDeletingTrait;

	protected $table = 'tp_lists';
	
	const important = 'important';
	const urgent    = 'urgent';
	const date      = 'date';
	const custom    = 'custom';

	//////////////////////////////////////////////////////////
	// 静态方法
	//////////////////////////////////////////////////////////

	public static function updatePriorityById($id, $priority)
	{
		TaskList::where('id', '=', $id)->increment('version', 1, array('priority' => $priority));
	}

	public static function getById($id)
	{
		return TaskList::where('id', '=', $id)->first();
	}

	public static function updateByForm(ListSettingForm $listSettingForm)
	{
		if(!$listSettingForm->isValid())
		{
			$taskList            = TaskList::where('id', '=', $listSettingForm->id)->first();
			$taskList->name      = $listSettingForm->name;
			$taskList->sort_by   = $listSettingForm->sortBy;
			$taskList->color     = $listSettingForm->color;
			$taskList->icon      = $listSettingForm->icon;
			$taskList->shareable = $listSettingForm->share;
			$taskList->version++;
			$taskList->save();
			return true;
		}
		return false;
	}

	public static function softDeleteById($listId)
	{
		if($listId)
		{
			TaskList::where('id', '=', $listId)->increment('version', 1);
			TaskList::where('id', '=', $listId)->delete();
			UserList::where('list_id', '=', $listId)->increment('version', 1);
			UserList::where('list_id', '=', $listId)->delete();
			return true;
		}

		return false;
	}
}