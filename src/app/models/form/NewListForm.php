<?php

class NewListForm extends BaseFormModel
{
	public $nameOrCode;
	public $type;

	public function __construct($input)
	{
		$rule = array(
			'nameOrCode' 	=> 'required',
			'type'			=> 'required',
			);

		$this->init($input, $rule);
	}
}