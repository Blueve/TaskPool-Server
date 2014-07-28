<?php

class SigninForm extends BaseFormModel
{
	public $userId;
	public $password;
	public $rememberMe;

	public function __construct($input)
	{

		$this->init($input);

		// 设定rememberMe的值
		$this->rememberMe = isset($this->rememberMe) ? true : false;
	}
}