<?php

class FindPasswordForm extends BaseFormModel
{
	public $email;

	public function __construct($input)
	{
		$rule = array(
			'email' 			=> 'required|email',
			);

		$this->init($input, $rule);
	}
}