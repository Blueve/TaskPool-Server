<?php

class ListController extends BaseController {

	//创建TaskList
	public function create_post()
	{
		$user = Auth::user();
		$newListForm = new NewListForm(Input::all());		//对输入进行校验
		$list = TaskList::createByForm($newListForm, $user);

		$response = array(
			'state' => false,
			'id'    => 0,
			'name'  => '',
			);

		if($list)
		{
			$response['state'] = true;
			$response['id'] = $list->id;
			$response['name'] = $list->name;
		}

		return Response::json($response);
	}

	//填充Task
	//TODO
	public function content_post()
	{
		$response = array(
			'state' => true, 
			'tasks' => 'list_'.Input::get('id').' --- '.(Input::has('dataset') ? Input::get('dataset') : 'today'),
			);
		return Response::json($response);
	}

	//保存TaskList的排列顺序
	public function reorder_post()
	{
		$user = Auth::user();

		$taskLists = explode(',', Input::get('taskLists'));

		$response = array(
			'state' => false,
			);
		if($user->checkTaskLists($taskLists))
		{
			foreach ($taskLists as $key => $value) 
			{
				TaskList::updatePriorityById($value, $key);
			}
			$response['state'] = true;
		}
		return Response::json($response);
	}

	//获取TaskList的相关设置内容
	public function getListSetting($listId)
	{
		$response = array(
			'state'   => false, 
			'name'    =>'',
			'sort_by' =>'',
			'color'   =>'',
			'icon'    =>'',
			);

		$list = TaskList::getById($listId);

		if($list)
		{
			$response['state']   = true;
			$response['name']    = $list->name;
			$response['sort_by'] = $list->sort_by;
			$response['color']   = $list->color;
			$response['icon']    = $list->icon;
		}

		return Response::json($response);
	}

	//更新TaskList设置
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

	//删除TaskList
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