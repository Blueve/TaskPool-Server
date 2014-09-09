<?php

class ListController extends BaseController
{

	/**
	 * 创建新列表表单处理
	 * 
	 * @return Json 状态反馈&新列表基本信息
	 */
	public function create_post()
	{
		try
		{
			// 创建新的用户列表
			$userList = UserList::newUserList(new NewListForm(Input::all()));
			return Response::json(new CreateUserList(
				true, 
				$userList->id, 
				$userList->taskList->name,
				$userList->taskList->icon,
				$userList->taskList->shareable));
		}
		catch(ListInvalidException $e)	// 列表表单不合法
		{
			return Response::json(new CreateUserList(false));
		}
		catch(ListNotFoundException $e)	// 共享码错误
		{
			return Response::json(new CreateUserList(false));
		}
		catch(AuthFailedException $e)	// 越权访问
		{
			return Response::json(new CreateUserList(false));
		}
	}

	/**
	 * 列表内容
	 *
	 * 产生对应列表&数据集的列表内容
	 *
	 * @todo 尚未完成，目前仅为测试用
	 * @return View 页面片段
	 */
	public function content_post()
	{
		$response = array(
			'state' => true, 
			'tasks' => 'list_'.Input::get('id').' --- '.(Input::has('dataset') ? Input::get('dataset') : 'today'),
			);
		return Response::json($response);
	}

	/**
	 * 保存新的用户列表顺位
	 *
	 * 用户应当只能对自己的列表顺位进行调整，如果输入的内容不
	 * 合法，应该抛出错误的状态
	 * 
	 * @return Json 状态反馈
	 */
	public function reorder_post()
	{
		try
		{
			User::reorderUserList(Input::get('userLists'));
			return Response::json(new ReorderUserList(true));
		}
		catch(AuthFailedException $e)	// 用户验证失败
		{
			return Response::json(new ReorderUserList(false));
		}
		catch(InvalidException $e)	// 用户列表验证失败
		{
			return Response::json(new ReorderUserList(false));
		}
	}

	/**
	 * 获取任务列表的设置详情
	 * 
	 * @param  int $listId 列表Id
	 * @return Json        状态反馈
	 */
	public function getListSetting($userListId)
	{
		try
		{
			$list = UserList::retrieveById($userListId);
			return Response::json(new ListSetting(true, 
												  $list->taskList->name,
												  $list->taskList->sort_by,
												  $list->taskList->color,
												  $list->taskList->icon,
												  $list->taskList->shareable,
												  Helper::EncodeListId($list->list_id)));
		}
		catch(ListNotFoundException $e)	// 未找到对应的列表
		{
			return Response::json(new ListSetting(false));
		}
	}

	/**
	 * 处理列表设置表单
	 * 
	 * @return Json 状态反馈
	 */
	public function updateListSetting_post()
	{
		try
		{
			// 更新列表设置
			$listSettingForm = new ListSettingForm(Input::all());
			TaskList::updateByForm($listSettingForm);
			return Response::json(new ListSetting(true, 
												  
												  $listSettingForm->name,
												  $listSettingForm->sortBy,
												  $listSettingForm->color,
												  $listSettingForm->icon,
												  $listSettingForm->shareable,
												  Helper::EncodeListId($listSettingForm->id)));
		}
		catch(ListSettingInvalidException $e)	// 列表设置输入不合法
		{
			return Response::json(new ListSetting(false));
		}
	}

	/**
	 * 删除一个用户列表
	 *
	 * 当删除一个用户列表的时候需要对用户列表所对应的任务
	 * 列表进行检查，如果删除者是列表的最初拥有者，那么就
	 * 将任务列表以及所有对应的镜像链接的用户列表都删除
	 * 
	 * @param  int $userListId 用户列表Id
	 * @return Json            状态反馈
	 */
	public function delete_post($userListId)
	{
		UserList::softDeleteById($userListId);
		return Response::json(new BaseAjaxModel(true));
	}
}