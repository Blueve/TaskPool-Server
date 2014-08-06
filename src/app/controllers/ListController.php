<?php

class ListController extends BaseController {

	public function create()
	{
		$user = Auth::user();
		$newListForm = new NewListForm(Input::all());
		$list = TaskList::newTaskList($newListForm, $user);

		$response = array('state' => false, 'id' => 0, 'name' => '');
		if($list)
		{
			$response['state'] = true;
			$response['id'] = $list->id;
			$response['name'] = $list->name;
		}
		return Response::json($response);
	}

	public function content()
	{

		$response = array('state' => true, 
			'tasks' => 'list_'.Input::get('id').' --- '.(Input::has('dataset') ? Input::get('dataset') : 'today')
			);
		return Response::json($response);
	}

	public function reorder()
	{
		$user = Auth::user();

		$taskLists = explode(',', Input::get('taskLists'));

		$response = array('state' => false);
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

	public function getListSetting($listId)
	{
		$response = array(
			'state'   => false, 
			'name'    =>'',
			'sort_by' =>'',
			'color'   =>'',
			);

		$list = TaskList::getTaskListById($listId);

		if($list)
		{
			$response['state']   = true;
			$response['name']    = $list->name;
			$response['sort_by'] = $list->sort_by;
			$response['color']   = $list->color;
		}

		return Response::json($response);
	}

	public function updateListSetting()
	{
		$listSettingForm = new ListSettingForm(Input::all());

		//Helper::VarDump($listSettingForm);
		TaskList::updateTaskList($listSettingForm);

		$response = array(
			'state'   => false,
			'id'      =>'', 
			'name'    =>'',
			'sort_by' =>'',
			'color'   =>'',
			);

		if(!$listSettingForm->isValid())
		{
			TaskList::updateTaskList($listSettingForm);
			$response['state']   = true;
			$response['id']      = $listSettingForm->id;
			$response['name']    = $listSettingForm->name;
			$response['sort_by'] = $listSettingForm->sortBy;
			$response['color']   = $listSettingForm->color;
		}
		return Response::json($response);
	}
}