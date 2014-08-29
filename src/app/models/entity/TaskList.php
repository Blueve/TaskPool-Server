<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class TaskList extends Eloquent {

	use SoftDeletingTrait;

	protected $table = 'tp_lists';
	
	const important = 'important';
	const urgent    = 'urgent';
	const date      = 'date';
	const custom    = 'custom';

	public static function createByForm(NewListForm $newListForm, User $user)
	{
		if($newListForm->isValid())
		{
			if($newListForm->type == 'CREATE')
			{
				// 创建列表
				$list           = new TaskList();
				$list->user_id  = $user->id;
				$list->name     = $newListForm->nameOrCode;
				$list->sort_by  = 'important';
				$list->icon     = Config::get('iconset.list_icon_set')[0];
				$list->version  = 0;
				$list->save();
				// 创建用户列表
				$userList           = new UserList();
				$userList->user_id  = $user->id;
				$userList->list_id  = $list->id;
				$userList->priority = $user->userLists()->count();
				$userList->version  = 0;
				$userList->save();
			}
			else if($newListForm->type == 'COPY')
			{
				$listId     = Helper::DecodeListId($newListForm->nameOrCode);
				$sharedList = TaskList::find($listId);
				if($sharedList->shareable)
				{
					// 创建列表
					$list           = new TaskList();
					$list->user_id  = $user->id;
					$list->name     = $sharedList->name;
					$list->sort_by  = $sharedList->sort_by;
					$list->color    = $sharedList->color;
					$list->icon     = $sharedList->icon;
					$list->version  = 0;
					$list->save();
					// 创建用户列表
					$userList           = new UserList();
					$userList->user_id  = $user->id;
					$userList->list_id  = $list->id;
					$userList->priority = $user->userLists()->count();
					$userList->version  = 0;
					$userList->save();
					//TODO: Copy Tasks
				}
				else
				{
					//TODO: Error handling
				}
			}
			else if($newListForm->type == 'LINK')
			{
				//TODO:
			}
			return $list;
		}
	}

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