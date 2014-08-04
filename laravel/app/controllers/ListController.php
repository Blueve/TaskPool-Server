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

	public function getListSetting()
	{
		$curTaskListId = Input::get('curTaskList');

		$response = array(
			'state'   => false, 
			'name'    =>'',
			'sort_by' =>'',
			'color'   =>'',
			);

		$curTaskList = TaskList::getTaskListById($curTaskListId);

		if($curTaskList)
		{
			$response['state']   = true;
			$response['name']    = $curTaskList->name;
			$response['sort_by'] = $curTaskList->sort_by;
			$response['color']   = $curTaskList->color;
		}

		return Response::json($response);
	}

	public function updateListSetting()
	{
		$listSettingForm = new ListSettingForm(Input::all());
		if($listSettingForm->isValid())
		{
			TaskList::updateTaskList($listSettingForm);
		}
	}
}