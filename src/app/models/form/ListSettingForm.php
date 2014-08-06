<?php

class ListSettingForm extends BaseFormModel
{
	public $id;
	public $name;
	public $sortBy;
	public $color;

	public function __construct($input)
	{
		$rule = array(
			'id'     => 'required',
			'name'   => 'required',
			'sortBy' => 'required|in: important, urgent, date, custom',
			'color'  => 'required|in: red, orange, yellow, green, blue, indigo, purple, black, darkgray, gray'
			);

		$this->init($input, $rule);
	}
}