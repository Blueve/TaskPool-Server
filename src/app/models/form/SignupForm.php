<?php

class SignupForm extends BaseFormModel
{
	public $email;
	public $name;
	public $password;
	public $passwordConfirm;

	public function __construct($input)
	{
		$rule = array(
			'email' 			=> 'required|email|unique:tp_users',
			'name' 				=> 'required|min:6|unique:tp_users',
			'password' 			=> 'required|min:8',
			'passwordConfirm' 	=> 'required|same:password'
			);

		$this->init($input, $rule);
	}
}