<?php

abstract class BaseFormModel
{

	private $_validator;

	protected function init($input, $rule = array())
	{
		$this->_validator = Validator::make($input, $rule);

		$formKey = array_keys(get_class_vars(get_class($this)));
		// 遍历表单键值 并赋予类成员
		foreach ($formKey as $value) 
		{
			if(isset($input[$value]))
			{
				$this->$value = $input[$value];
			}
		}
	}

	public function validator()
	{
		return $this->_validator;
	}

	public function isValid()
	{
		return !$this->_validator->fails();
	}

}