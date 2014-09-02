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
		catch(AuthFailedException $e)
		{
			return Response::json(new ReorderUserList(false));
		}
		catch(InvalidException $e)
		{
			return Response::json(new ReorderUserList(false));
		}
	}

	// 获取TaskList的相关设置内容
	public function getListSetting($listId)
	{
		$response = array(
			'state'     => false, 
			'name'      => '',
			'sort_by'   => '',
			'color'     => '',
			'icon'      => '',
			'shareable' => '',
			'shareCode' => '',
			);

		$list = TaskList::getById($listId);

		if($list)
		{
			$response['state']     = true;
			$response['name']      = $list->name;
			$response['sort_by']   = $list->sort_by;
			$response['color']     = $list->color;
			$response['icon']      = $list->icon;
			$response['shareable'] = $list->shareable;
			$response['shareCode'] = Helper::EncodeListId($list->id);
		}

		return Response::json($response);
	}

	// 更新TaskList设置
	public function updateListSetting_post()
	{
		$listSettingForm = new ListSettingForm(Input::all());

		//Helper::VarDump($listSettingForm);

		$response = array(
			'state'   => false,
			'name'    =>'',
			'sort_by' =>'',
			'color'   =>'',
			'icon'    =>'',
			);

		if(TaskList::updateByForm($listSettingForm))
		{
			$response['state']   = true;
			$response['name']    = $listSettingForm->name;
			$response['sort_by'] = $listSettingForm->sortBy;
			$response['color']   = $listSettingForm->color;
			$response['icon']    = $listSettingForm->icon;
		}
		return Response::json($response);
	}

	// 删除TaskList
	public function delete_post($listId)
	{
		$response = array(
			'state'   => false,
			);

		if(TaskList::softDeleteById($listId))
		{
			$response['state'] = true;
		}
		return Response::json($response);
	}
}