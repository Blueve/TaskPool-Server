<?php

class SetPasswordForm extends BaseFormModel
{
	public $userId;
	public $checkCode;
	public $password;
	public $passwordConfirm;

	public function __construct($input)
	{
		$rule = array(
			'userId'			=> 'required',
			'checkCode'			=> 'required',
			'password' 			=> 'required|min:8',
			'passwordConfirm' 	=> 'required|same:password'
			);

		$this->init($input, $rule);
	}
}