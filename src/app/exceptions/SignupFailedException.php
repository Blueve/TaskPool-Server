<?php

class SignupFailedException extends Exception
{
	public function __construct()
	{
		parent::__construct('Signup Failed Failed');
	}
}