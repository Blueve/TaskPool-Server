<?php

class NewListForm extends BaseFormModel
{
	public $name;

	public function __construct($input)
	{
		$rule = array(
			'name' 			=> 'required',
			);

		$this->init($input, $rule);
	}
}