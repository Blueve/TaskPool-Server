<?php

class PasswordInvalidException extends Exception
{
	public function __construct()
	{
		parent::__construct('Password Invalid');
	}
}