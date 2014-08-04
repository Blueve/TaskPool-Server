<?php

class ListSettingForm extends BaseFormModel
{
	public $name;
	public $sort_by;

	public function __construct($input)
	{
		$rule = array(
			'updateTaskListId' => 'required',
			'name'             => 'required',
			'sortBy'           => 'required|in: important, urgent, date, custom',
			'color'            => 'required|in: red, orange, yellow, green, blue, indigo, purple, black, darkgray, gray'
			);

		$this->init($input, $rule);
	}
}