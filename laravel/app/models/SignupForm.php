<?php

class SignupForm extends BaseFormModel
{
	public $email;
	public $name;
	public $password;
	public $passwordConfirm;

	public function __construct($input)
	{
		$this->init($input);
	}
}