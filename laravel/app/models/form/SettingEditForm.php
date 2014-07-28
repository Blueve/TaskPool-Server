<?php

class SettingEditForm extends BaseFormModel
{
	public $oldPassword;
	public $password;
	public $passwordConfirm;

	public function __construct($input)
	{
		$rule = array(
			'oldPassword' 		=> 'required',
			'password' 			=> 'required|min:8',
			'passwordConfirm' 	=> 'required|same:password'
			);

		$this->init($input, $rule);
	}
}