<?php

class SigninForm extends BaseFormModel
{
	public $userId;
	public $password;
	public $rememberMe;

	public function __construct($input)
	{
		$rule = array(
			'email' 			=> 'required|email|unique:tp_users',
			'name' 				=> 'required|min:6|unique:tp_users',
			'password' 			=> 'required|min:8',
			'passwordConfirm' 	=> 'required|same:password'
			);

		$this->init($input, $rule);

		// 设定rememberMe的值
		$this->rememberMe = isset($this->rememberMe) ? true : false;
	}
}