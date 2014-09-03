<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class UserList extends Eloquent 
{

	use SoftDeletingTrait;

	protected $table = 'tp_userlist';

	//////////////////////////////////////////////////////////
	// 关系
	//////////////////////////////////////////////////////////
	public function taskList()
	{
		return $this->belongsTo('TaskList', 'list_id');
	}

	//////////////////////////////////////////////////////////
	// 静态方法
	//////////////////////////////////////////////////////////
	/**
	 * 根据用户列表Id取得一个用户列表
	 * 
	 * @param  int $id 列表Id
	 * @return UserList
	 */
	public static function retrieveById($id)
	{
		$userList =  UserList::find($id);
		if($userList)
		{
			return $userList;
		}
		else
		{
			throw new UserListNotFoundException();
		}
	}
	/**
	 * 根据用户列表Id更新用户列表的顺位
	 *
	 * 在更新用户列表顺位的同时，还需要将用户列表的版本号进行提升
	 * 
	 * @param  int $id       列表Id
	 * @param  int $priority 新顺位
	 * @return void
	 */
	public static function updatePriorityById($id, $priority)
	{
		UserList::where('id', '=', $id)->increment('version', 1, array('priority' => $priority));
	}

	/**
	 * 删除指定的用户列表
	 *
	 * 采用Soft Delete的方式进行删除，在删除用户列表的同时，对应
	 * 列表也采用Soft Delete的方式进行删除
	 * 
	 * @param  int $id 用户列表Id
	 * @return void
	 */
	public static function softDeleteById($id)
	{
		// 找到用户列表
		$userList = UserList::find($id);
		if($userList->user_id === $userList->taskList->user_id)
		{
			// 在删除者为任务列表拥有者时将任务列表也删除
			TaskList::softDeleteById($userList->list_id);
		}
		else
		{
			// 删除用户列表
			UserList::where('id', '=', $id)->increment('version', 1);
			UserList::where('id', '=', $id)->delete();
		}
	}

	/**
	 * 根据新列表表单创建新的用户列表
	 *
	 * 根据用户列表的类型创建不同的任务列表项
	 * 
	 * @param  NewListForm $newListForm 新列表表单
	 * @return UserList                 用户列表
	 */
	public static function newUserList(NewListForm $newListForm)
	{
		if(Auth::check())
		{
			$user = Auth::user();
		}
		else
		{
			throw new AuthFailedException();
		}

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
				if(!$sharedList)
				{
					throw new ListNotFoundException();
				}
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
					/**@todo 复制 */
				}
			}
			else if($newListForm->type == 'LINK')
			{
				/**@todo 创建一个到已存在的列表的镜像链接 */
			}
			return $userList;
		}
		else
		{
			throw new ListInvalidException();
		}
	}
}