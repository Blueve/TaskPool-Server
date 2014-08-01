<?php

class ListSettingForm extends BaseFormModel
{
	public $name;
	public $sort_by;

	public function __construct($input)
	{
		$rule = array(
			'name'    => 'required',
			'sort_by' => 'required|in: important, urgent, date, custom'
			);

		$this->init($input, $rule);
	}
}