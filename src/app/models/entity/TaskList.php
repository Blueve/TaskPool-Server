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
	/**
	 * 根据列表Id更新列表的顺位权值
	 * 
	 * @param  int $id       列表Id
	 * @param  int $priority 新顺位
	 * @return void
	 */
	public static function updatePriorityById($id, $priority)
	{
		TaskList::where('id', '=', $id)->increment('version', 1, array('priority' => $priority));
	}

	/**
	 * 根据列表Id取得一个列表
	 * 
	 * @param  int $id 列表Id
	 * @return TaskList
	 */
	public static function retrieveById($id)
	{
		$taskList =  TaskList::find($id);
		if($taskList)
		{
			return $taskList;
		}
		else
		{
			throw new ListNotFoundException();
		}
	}

	/**
	 * 根据表单更新列表的设置
	 * 
	 * @param  ListSettingForm $listSettingForm 列表设置表单
	 * @return void
	 */
	public static function updateByForm(ListSettingForm $listSettingForm)
	{
		if($listSettingForm->isValid())
		{
			$taskList            = UserList::find($listSettingForm->id)->taskList;
			$taskList->name      = $listSettingForm->name;
			$taskList->sort_by   = $listSettingForm->sortBy;
			$taskList->color     = $listSettingForm->color;
			$taskList->icon      = $listSettingForm->icon;
			$taskList->shareable = $listSettingForm->shareable;
			$taskList->version++;
			$taskList->save();
		}
		else
		{
			throw new ListSettingInvalidException();
		}
	}

	/**
	 * 删除任务列表
	 *
	 * 当删除任务列表的时候，所有与之关联的用户列表都将
	 * 被删除（包括经过分享途径创建的镜像链接）
	 * 
	 * @param  int $listId 列表Id
	 * @return void
	 */
	public static function softDeleteById($listId)
	{
		TaskList::where('id', '=', $listId)->increment('version', 1);
		TaskList::where('id', '=', $listId)->delete();
		UserList::where('list_id', '=', $listId)->increment('version', 1);
		UserList::where('list_id', '=', $listId)->delete();
	}
}